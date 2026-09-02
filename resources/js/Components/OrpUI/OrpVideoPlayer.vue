<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { useOrpMediaPlayer, formatMediaTime } from '@/Composables/OrpUI/useOrpMediaPlayer'

const props = defineProps({
    src: {
        type: String,
        default: ''
    },
    poster: {
        type: String,
        default: ''
    },
    title: {
        type: String,
        default: ''
    },
    preload: {
        type: String,
        default: 'metadata'
    },
    autoplay: {
        type: Boolean,
        default: false
    },
    muted: {
        type: Boolean,
        default: false
    },
    loop: {
        type: Boolean,
        default: false
    },
    aspectRatio: {
        type: String,
        default: '16-9'
    },
    showControls: {
        type: Boolean,
        default: true
    },
    initialTime: {
        type: Number,
        default: 0
    }
})

const emit = defineEmits(['play', 'pause', 'ended', 'timeupdate', 'error', 'state-change'])

const videoRef = ref(null)
const containerRef = ref(null)
const controlsVisible = ref(true)
const controlsTimeout = ref(null)
const speedMenuOpen = ref(false)
const captionsMenuOpen = ref(false)

const speeds = [0.5, 0.75, 1, 1.25, 1.5, 2]
const speedLabels = {
    0.5: '0.5x',
    0.75: '0.75x',
    1: '1x',
    1.25: '1.25x',
    1.5: '1.5x',
    2: '2x'
}

const {
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
    captionsEnabled,
    formattedCurrentTime,
    formattedDuration,
    progress,
    bufferedProgress,
    canFullscreen,
    canPiP,
    canSeek,
    bindMedia,
    play,
    pause,
    togglePlay,
    replay,
    seek,
    setVolume,
    toggleMute,
    setPlaybackRate,
    toggleFullscreen,
    togglePiP,
    toggleCaptions,
    handleKeydown,
    setSrc
} = useOrpMediaPlayer({
    autoplay: props.autoplay,
    muted: props.muted,
    loop: props.loop,
    preload: props.preload,
    initialTime: props.initialTime
})

const aspectClass = computed(() => `orp-video--${props.aspectRatio}`)

const stateClass = computed(() => {
    if (error.value) return 'orp-video--error'
    if (loading.value) return 'orp-video--loading'
    if (buffering.value) return 'orp-video--buffering'
    if (ended.value) return 'orp-video--ended'
    if (playing.value) return 'orp-video--playing'
    return ''
})

const controlsClass = computed(() => {
    if (!props.showControls) return 'orp-video--controls-hidden'
    if (controlsVisible.value) return 'orp-video--controls-visible'
    if (paused.value) return ''
    return 'orp-video--controls-hidden'
})

const showPlayOverlay = computed(() => {
    return paused.value && !props.poster && !loading.value && !error.value
})

const showBigPlay = computed(() => {
    return paused.value && !ended.value && !error.value && !loading.value
})

const errorMessage = computed(() => {
    if (!error.value) return ''
    return 'This media cannot be played.'
})

const currentSpeedLabel = computed(() => speedLabels[playbackRate.value] || '1x')

function handleTimelineInput(e) {
    const val = parseFloat(e.target.value)
    seek(val)
}

function handleVolumeInput(e) {
    const val = parseFloat(e.target.value)
    setVolume(val)
}

function handleSpeedSelect(speed) {
    setPlaybackRate(speed)
    speedMenuOpen.value = false
}

function showControlsTemporarily() {
    controlsVisible.value = true
    if (controlsTimeout.value) {
        clearTimeout(controlsTimeout.value)
    }
    if (playing.value && props.showControls) {
        controlsTimeout.value = setTimeout(() => {
            controlsVisible.value = false
        }, 3000)
    }
}

function handleMouseMove() {
    showControlsTemporarily()
}

function handlePosterClick() {
    if (paused.value) {
        play()
    }
}

onMounted(() => {
    if (videoRef.value) {
        bindMedia(videoRef.value)
        if (props.src) {
            setSrc(props.src)
        }
    }
    window.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown)
    if (controlsTimeout.value) {
        clearTimeout(controlsTimeout.value)
    }
})

watch(() => props.src, (val) => {
    if (val) setSrc(val)
})
</script>

<template>
    <div
        ref="containerRef"
        class="orp-video"
        :class="[aspectClass, stateClass, controlsClass]"
        @mousemove="handleMouseMove"
        @mouseleave="controlsVisible = false"
    >
        <video
            ref="videoRef"
            class="orp-video__media"
            :poster="poster"
            :preload="preload"
            :autoplay="autoplay"
            :muted="muted"
            :loop="loop"
            playsinline
            @click="togglePlay"
        >
            <source v-if="src" :src="src" type="video/mp4">
            <track
                v-for="(track, index) in tracks"
                :key="index"
                :kind="track.kind"
                :label="track.label"
                :srclang="track.language"
            >
        </video>

        <div v-if="poster && !playing && !ended" class="orp-video__poster" @click="handlePosterClick">
            <img :src="poster" :alt="title" class="orp-video__media">
            <div class="orp-video__play-overlay">
                <div class="orp-video__play-icon">
                    <i class="bi bi-play-fill" aria-hidden="true"></i>
                </div>
            </div>
            <div v-if="title || duration" class="orp-video__poster-meta">
                <h3 v-if="title" class="orp-video__poster-title">{{ title }}</h3>
                <span v-if="duration" class="orp-video__poster-duration">{{ formattedDuration }}</span>
            </div>
        </div>

        <div v-if="showBigPlay" class="orp-video__big-play" @click="play" aria-label="Play video">
            <i class="bi bi-play-fill" aria-hidden="true"></i>
        </div>

        <div v-if="ended" class="orp-video__state">
            <div class="orp-video__state-icon">
                <i class="bi bi-arrow-counterclockwise" aria-hidden="true"></i>
            </div>
            <h3 class="orp-video__state-title">Playback ended</h3>
            <button class="orp-video__replay" @click="replay">
                <i class="bi bi-arrow-counterclockwise" aria-hidden="true"></i>
                Replay
            </button>
        </div>

        <div v-if="error" class="orp-video__state">
            <div class="orp-video__state-icon">
                <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
            </div>
            <h3 class="orp-video__state-title">Playback error</h3>
            <p class="orp-video__state-description">{{ errorMessage }}</p>
        </div>

        <div v-if="buffering && !error" class="orp-video__state">
            <div class="orp-spinner orp-spinner--lg"></div>
        </div>

        <div v-if="showControls" class="orp-video__controls">
            <div class="orp-video__timeline">
                <span class="orp-video__time">{{ formattedCurrentTime }}</span>
                <div class="orp-video__timeline-track">
                    <div class="orp-video__progress">
                        <div class="orp-video__progress-bar" :style="{ width: `${progress}%` }"></div>
                        <div class="orp-video__progress-buffered" :style="{ width: `${bufferedProgress}%` }"></div>
                    </div>
                    <input
                        type="range"
                        class="orp-range orp-range--time"
                        min="0"
                        :max="duration || 100"
                        :value="currentTime"
                        :style="{ '--orp-range-buffered': `${bufferedProgress}%` }"
                        :disabled="!canSeek"
                        aria-label="Seek"
                        @input="handleTimelineInput"
                    >
                </div>
                <span class="orp-video__time">{{ formattedDuration }}</span>
            </div>

            <div class="orp-video__controls-row">
                <div class="orp-video__controls-primary">
                    <button
                        class="orp-video__control-btn"
                        :aria-label="playing ? 'Pause' : 'Play'"
                        :disabled="!playing && !paused"
                        @click="togglePlay"
                    >
                        <i :class="playing ? 'bi bi-pause-fill' : 'bi bi-play-fill'" aria-hidden="true"></i>
                    </button>

                    <div class="orp-video__volume">
                        <button
                            class="orp-video__control-btn orp-video__control-btn--sm"
                            :aria-label="mutedState ? 'Unmute' : 'Mute'"
                            @click="toggleMute"
                        >
                            <i :class="mutedState || volume === 0 ? 'bi bi-volume-mute-fill' : 'bi bi-volume-up-fill'" aria-hidden="true"></i>
                        </button>
                        <div class="orp-video__volume-slider">
                            <input
                                type="range"
                                class="orp-range orp-range--volume"
                                min="0"
                                max="1"
                                step="0.05"
                                :value="mutedState ? 0 : volume"
                                aria-label="Volume"
                                @input="handleVolumeInput"
                            >
                        </div>
                    </div>

                    <span v-if="title" class="orp-video__title">{{ title }}</span>
                </div>

                <div class="orp-video__controls-secondary">
                    <div class="orp-dropdown" style="position: relative;">
                        <button
                            class="orp-video__control-btn orp-video__control-btn--sm"
                            aria-label="Playback speed"
                            @click="speedMenuOpen = !speedMenuOpen"
                        >
                            {{ currentSpeedLabel }}
                        </button>
                        <div v-if="speedMenuOpen" class="orp-dropdown__menu" style="position: absolute; bottom: 100%; right: 0; margin-bottom: 8px;">
                            <div class="orp-dropdown__content">
                                <button
                                    v-for="speed in speeds"
                                    :key="speed"
                                    class="orp-dropdown__item"
                                    :class="{ 'orp-dropdown__item--active': playbackRate === speed }"
                                    @click="handleSpeedSelect(speed)"
                                >
                                    {{ speedLabels[speed] }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <button
                        v-if="tracks.length > 0"
                        class="orp-video__control-btn orp-video__control-btn--sm"
                        :aria-label="captionsEnabled ? 'Disable captions' : 'Enable captions'"
                        :class="{ 'orp-video__control-btn--active': captionsEnabled }"
                        @click="toggleCaptions"
                    >
                        <i class="bi bi-badge-cc" aria-hidden="true"></i>
                    </button>

                    <button
                        v-if="canPiP"
                        class="orp-video__control-btn orp-video__control-btn--sm"
                        aria-label="Picture in Picture"
                        @click="togglePiP"
                    >
                        <i class="bi bi-picture-in-picture" aria-hidden="true"></i>
                    </button>

                    <button
                        v-if="canFullscreen"
                        class="orp-video__control-btn orp-video__control-btn--sm"
                        :aria-label="fullscreen ? 'Exit fullscreen' : 'Enter fullscreen'"
                        @click="toggleFullscreen"
                    >
                        <i :class="fullscreen ? 'bi bi-fullscreen-exit' : 'bi bi-fullscreen'" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.orp-video__control-btn--active {
    color: var(--orp-primary);
}

.orp-dropdown__item--active {
    background: var(--orp-surface-muted);
    font-weight: 500;
}
</style>
