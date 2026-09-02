import { ref, computed, watch, onUnmounted } from 'vue'

export function formatMediaTime(seconds) {
    if (isNaN(seconds) || !isFinite(seconds)) {
        return '0:00'
    }

    const hrs = Math.floor(seconds / 3600)
    const mins = Math.floor((seconds % 3600) / 60)
    const secs = Math.floor(seconds % 60)

    if (hrs > 0) {
        return `${hrs}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`
    }

    return `${mins}:${secs.toString().padStart(2, '0')}`
}

export function useOrpMediaPlayer(options = {}) {
    const {
        autoplay = false,
        muted = false,
        loop = false,
        preload = 'metadata',
        initialTime = 0
    } = options

    const mediaRef = ref(null)
    const src = ref('')
    const poster = ref('')

    const playing = ref(false)
    const paused = ref(true)
    const ended = ref(false)
    const loading = ref(true)
    const buffering = ref(false)
    const error = ref(null)
    const currentTime = ref(0)
    const duration = ref(0)
    const buffered = ref(0)
    const volume = ref(1)
    const mutedState = ref(muted)
    const playbackRate = ref(1)
    const fullscreen = ref(false)
    const pip = ref(false)
    const tracks = ref([])
    const activeTrack = ref(null)
    const captionsEnabled = ref(false)

    const formattedCurrentTime = computed(() => formatMediaTime(currentTime.value))
    const formattedDuration = computed(() => formatMediaTime(duration.value))
    const progress = computed(() => {
        if (duration.value === 0) return 0
        return (currentTime.value / duration.value) * 100
    })
    const bufferedProgress = computed(() => {
        if (duration.value === 0) return 0
        return (buffered.value / duration.value) * 100
    })
    const hasError = computed(() => error.value !== null)
    const isSupported = computed(() => {
        if (!mediaRef.value) return true
        return true
    })

    const canPlay = computed(() => src.value.length > 0)
    const canPlayPause = computed(() => canPlay.value && !loading.value && !hasError.value)
    const canSeek = computed(() => canPlay.value && duration.value > 0)
    const canVolume = computed(() => canPlay.value)
    const canFullscreen = computed(() => {
        if (!mediaRef.value) return false
        return document.fullscreenEnabled || mediaRef.value.requestFullscreen
    })
    const canPiP = computed(() => {
        if (!mediaRef.value) return false
        return 'pictureInPictureEnabled' in document && document.pictureInPictureEnabled
    })
    const canSpeed = computed(() => canPlay.value)

    function bindMediaEvents(media) {
        media.addEventListener('play', () => {
            playing.value = true
            paused.value = false
            ended.value = false
        })

        media.addEventListener('pause', () => {
            playing.value = false
            paused.value = true
        })

        media.addEventListener('ended', () => {
            playing.value = false
            paused.value = true
            ended.value = true
        })

        media.addEventListener('loadedmetadata', () => {
            duration.value = media.duration
            loading.value = false
            if (initialTime > 0 && initialTime < media.duration) {
                media.currentTime = initialTime
            }
        })

        media.addEventListener('canplay', () => {
            loading.value = false
            buffering.value = false
        })

        media.addEventListener('waiting', () => {
            buffering.value = true
        })

        media.addEventListener('playing', () => {
            buffering.value = false
            loading.value = false
        })

        media.addEventListener('timeupdate', () => {
            currentTime.value = media.currentTime
        })

        media.addEventListener('progress', () => {
            if (media.buffered.length > 0) {
                buffered.value = media.buffered.end(media.buffered.length - 1)
            }
        })

        media.addEventListener('volumechange', () => {
            volume.value = media.volume
            mutedState.value = media.muted
        })

        media.addEventListener('ratechange', () => {
            playbackRate.value = media.playbackRate
        })

        media.addEventListener('error', (e) => {
            error.value = e
            loading.value = false
            buffering.value = false
        })

        if (media.textTracks) {
            media.textTracks.addEventListener('change', () => {
                tracks.value = Array.from(media.textTracks).map((track, index) => ({
                    index,
                    kind: track.kind,
                    label: track.label,
                    language: track.language,
                    mode: track.mode
                }))
                const active = Array.from(media.textTracks).find(t => t.mode === 'showing')
                activeTrack.value = active ? tracks.value.find(t => t.index === Array.from(media.textTracks).indexOf(active)) : null
            })
        }
    }

    function play() {
        if (!mediaRef.value || !canPlayPause.value) return Promise.resolve()
        return mediaRef.value.play().catch(err => {
            if (err.name !== 'AbortError') {
                error.value = err
            }
        })
    }

    function pause() {
        if (!mediaRef.value || !canPlayPause.value) return
        mediaRef.value.pause()
    }

    function togglePlay() {
        if (playing.value) {
            pause()
        } else {
            play()
        }
    }

    function stop() {
        if (!mediaRef.value) return
        mediaRef.value.pause()
        mediaRef.value.currentTime = 0
    }

    function replay() {
        if (!mediaRef.value) return
        mediaRef.value.currentTime = 0
        play()
    }

    function seek(time) {
        if (!mediaRef.value || !canSeek.value) return
        mediaRef.value.currentTime = Math.max(0, Math.min(time, duration.value))
    }

    function seekRelative(delta) {
        seek(currentTime.value + delta)
    }

    function setVolume(val) {
        if (!mediaRef.value || !canVolume.value) return
        const newVolume = Math.max(0, Math.min(1, val))
        mediaRef.value.volume = newVolume
        if (newVolume > 0 && mutedState.value) {
            mediaRef.value.muted = false
        }
    }

    function toggleMute() {
        if (!mediaRef.value || !canVolume.value) return
        mediaRef.value.muted = !mediaRef.value.muted
    }

    function setMuted(val) {
        if (!mediaRef.value || !canVolume.value) return
        mediaRef.value.muted = val
    }

    function setPlaybackRate(rate) {
        if (!mediaRef.value || !canSpeed.value) return
        mediaRef.value.playbackRate = rate
    }

    function setSrc(newSrc) {
        if (src.value === newSrc) return
        src.value = newSrc
        error.value = null
        ended.value = false
        currentTime.value = 0
        duration.value = 0
        buffered.value = 0
        if (mediaRef.value) {
            mediaRef.value.load()
        }
    }

    function setPoster(newPoster) {
        poster.value = newPoster
    }

    async function enterFullscreen() {
        if (!mediaRef.value || !canFullscreen.value) return
        try {
            if (mediaRef.value.requestFullscreen) {
                await mediaRef.value.requestFullscreen()
                fullscreen.value = true
            }
        } catch (err) {
            console.warn('Fullscreen not supported:', err)
        }
    }

    async function exitFullscreen() {
        if (!document.fullscreenElement) return
        try {
            await document.exitFullscreen()
            fullscreen.value = false
        } catch (err) {
            console.warn('Exit fullscreen failed:', err)
        }
    }

    function toggleFullscreen() {
        if (fullscreen.value) {
            exitFullscreen()
        } else {
            enterFullscreen()
        }
    }

    async function enterPiP() {
        if (!mediaRef.value || !canPiP.value) return
        try {
            await mediaRef.value.requestPictureInPicture()
            pip.value = true
        } catch (err) {
            console.warn('PiP not supported:', err)
        }
    }

    async function exitPiP() {
        if (!document.pictureInPictureElement) return
        try {
            await document.exitPictureInPicture()
            pip.value = false
        } catch (err) {
            console.warn('Exit PiP failed:', err)
        }
    }

    function togglePiP() {
        if (pip.value) {
            exitPiP()
        } else {
            enterPiP()
        }
    }

    function enableCaption(trackIndex) {
        if (!mediaRef.value) return
        const textTracks = mediaRef.value.textTracks
        if (!textTracks) return

        for (let i = 0; i < textTracks.length; i++) {
            textTracks[i].mode = i === trackIndex ? 'showing' : 'hidden'
        }
        captionsEnabled.value = true
    }

    function disableCaptions() {
        if (!mediaRef.value) return
        const textTracks = mediaRef.value.textTracks
        if (!textTracks) return

        for (let i = 0; i < textTracks.length; i++) {
            textTracks[i].mode = 'hidden'
        }
        captionsEnabled.value = false
    }

    function toggleCaptions() {
        if (captionsEnabled.value) {
            disableCaptions()
        } else if (tracks.value.length > 0) {
            enableCaption(tracks.value[0].index)
        }
    }

    function handleKeydown(e) {
        if (e.target.tagName === 'BUTTON' || e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') {
            return
        }

        switch (e.key) {
            case ' ':
            case 'k':
                e.preventDefault()
                togglePlay()
                break
            case 'ArrowLeft':
                e.preventDefault()
                seekRelative(-5)
                break
            case 'ArrowRight':
                e.preventDefault()
                seekRelative(5)
                break
            case 'ArrowUp':
                e.preventDefault()
                setVolume(volume.value + 0.1)
                break
            case 'ArrowDown':
                e.preventDefault()
                setVolume(volume.value - 0.1)
                break
            case 'm':
                e.preventDefault()
                toggleMute()
                break
            case 'f':
                e.preventDefault()
                toggleFullscreen()
                break
            case 'c':
                e.preventDefault()
                toggleCaptions()
                break
        }
    }

    function setupFullscreenListener() {
        document.addEventListener('fullscreenchange', () => {
            fullscreen.value = !!document.fullscreenElement
        })
    }

    function setupPiPListener() {
        if (!mediaRef.value) return
        mediaRef.value.addEventListener('enterpictureinpicture', () => {
            pip.value = true
        })
        mediaRef.value.addEventListener('leavepictureinpicture', () => {
            pip.value = false
        })
    }

    function bindMedia(media) {
        mediaRef.value = media
        bindMediaEvents(media)
        setupFullscreenListener()
        if (canPiP.value) {
            setupPiPListener()
        }
    }

    watch(volume, (val) => {
        if (mediaRef.value && mediaRef.value.volume !== val) {
            mediaRef.value.volume = val
        }
    })

    watch(mutedState, (val) => {
        if (mediaRef.value && mediaRef.value.muted !== val) {
            mediaRef.value.muted = val
        }
    })

    onUnmounted(() => {
        if (mediaRef.value) {
            mediaRef.value.pause()
        }
    })

    return {
        mediaRef,
        src,
        poster,
        playing,
        paused,
        ended,
        loading,
        buffering,
        error,
        currentTime,
        duration,
        buffered,
        volume,
        mutedState,
        playbackRate,
        fullscreen,
        pip,
        tracks,
        activeTrack,
        captionsEnabled,
        formattedCurrentTime,
        formattedDuration,
        progress,
        bufferedProgress,
        hasError,
        isSupported,
        canPlay,
        canPlayPause,
        canSeek,
        canVolume,
        canFullscreen,
        canPiP,
        canSpeed,
        bindMedia,
        play,
        pause,
        togglePlay,
        stop,
        replay,
        seek,
        seekRelative,
        setVolume,
        toggleMute,
        setMuted,
        setPlaybackRate,
        setSrc,
        setPoster,
        enterFullscreen,
        exitFullscreen,
        toggleFullscreen,
        enterPiP,
        exitPiP,
        togglePiP,
        enableCaption,
        disableCaptions,
        toggleCaptions,
        handleKeydown,
        formatMediaTime
    }
}
