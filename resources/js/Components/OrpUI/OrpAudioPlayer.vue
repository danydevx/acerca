<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useOrpMediaPlayer, formatMediaTime } from '@/Composables/OrpUI/useOrpMediaPlayer'

const props = defineProps({
    src: {
        type: String,
        default: ''
    },
    title: {
        type: String,
        default: ''
    },
    artist: {
        type: String,
        default: ''
    },
    album: {
        type: String,
        default: ''
    },
    artwork: {
        type: String,
        default: ''
    },
    duration: {
        type: Number,
        default: 0
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
    variant: {
        type: String,
        default: 'default'
    }
})

const emit = defineEmits(['play', 'pause', 'ended', 'timeupdate', 'error'])

const audioRef = ref(null)

const {
    playing,
    paused,
    ended,
    loading,
    buffering,
    error,
    currentTime,
    volume,
    mutedState,
    playbackRate,
    formattedCurrentTime,
    formattedDuration,
    progress,
    bindMedia,
    play,
    pause,
    togglePlay,
    replay,
    seek,
    setVolume,
    toggleMute,
    setPlaybackRate,
    handleKeydown,
    setSrc
} = useOrpMediaPlayer({
    autoplay: props.autoplay,
    muted: props.muted,
    loop: props.loop,
    preload: props.preload
})

const speeds = [0.5, 0.75, 1, 1.25, 1.5, 2]
const speedLabels = {
    0.5: '0.5x',
    0.75: '0.75x',
    1: '1x',
    1.25: '1.25x',
    1.5: '1.5x',
    2: '2x'
}

const variantClass = computed(() => `orp-audio--${props.variant}`)

const playerClass = computed(() => {
    const classes = ['orp-audio', variantClass.value]
    if (loading.value) classes.push('orp-audio--loading')
    if (error.value) classes.push('orp-audio--error')
    return classes.join(' ')
})

const currentSpeedLabel = computed(() => speedLabels[playbackRate.value] || '1x')

const displayDuration = computed(() => {
    if (props.duration > 0) return formatMediaTime(props.duration)
    return formattedDuration.value
})

const subtitle = computed(() => {
    if (props.artist && props.album) return `${props.artist} • ${props.album}`
    if (props.artist) return props.artist
    return ''
})

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
}

onMounted(() => {
    if (audioRef.value) {
        bindMedia(audioRef.value)
        if (props.src) {
            setSrc(props.src)
        }
    }
    window.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown)
})
</script>

<template>
    <div :class="playerClass">
        <audio
            ref="audioRef"
            :src="src"
            :preload="preload"
            :autoplay="autoplay"
            :muted="muted"
            :loop="loop"
            @click="togglePlay"
        ></audio>

        <div class="orp-audio__artwork">
            <img v-if="artwork" :src="artwork" :alt="title">
            <div v-else class="orp-audio__artwork-placeholder">
                <i class="bi bi-music-note" aria-hidden="true"></i>
            </div>
        </div>

        <div class="orp-audio__content">
            <div class="orp-audio__header">
                <div>
                    <h3 class="orp-audio__title">{{ title || 'Unknown Title' }}</h3>
                    <p v-if="subtitle" class="orp-audio__subtitle">{{ subtitle }}</p>
                </div>
                <div v-if="displayDuration" class="orp-audio__meta">
                    <span class="orp-audio__duration-badge">{{ displayDuration }}</span>
                </div>
            </div>

            <div class="orp-audio__timeline">
                <span class="orp-audio__time">{{ formattedCurrentTime }}</span>
                <div class="orp-audio__timeline-track">
                    <div class="orp-audio__progress">
                        <div class="orp-audio__progress-bar" :style="{ width: `${progress}%` }"></div>
                    </div>
                    <input
                        type="range"
                        class="orp-range orp-range--time"
                        min="0"
                        :max="duration || 100"
                        :value="currentTime"
                        aria-label="Seek"
                        @input="handleTimelineInput"
                    >
                </div>
                <span class="orp-audio__time">{{ displayDuration }}</span>
            </div>

            <div class="orp-audio__controls">
                <button
                    class="orp-audio__control-btn orp-audio__control-btn--sm"
                    aria-label="Rewind 10 seconds"
                    @click="seek(currentTime - 10)"
                >
                    <i class="bi bi-arrow-left-short" aria-hidden="true"></i>
                </button>

                <button
                    class="orp-audio__control-btn orp-audio__control-btn--play"
                    :aria-label="playing ? 'Pause' : 'Play'"
                    @click="togglePlay"
                >
                    <i :class="playing ? 'bi bi-pause-fill' : 'bi bi-play-fill'" aria-hidden="true"></i>
                </button>

                <button
                    class="orp-audio__control-btn orp-audio__control-btn--sm"
                    aria-label="Forward 10 seconds"
                    @click="seek(currentTime + 10)"
                >
                    <i class="bi bi-arrow-right-short" aria-hidden="true"></i>
                </button>
            </div>

            <div class="orp-audio__controls" style="margin-top: var(--orp-space-2);">
                <button
                    class="orp-audio__control-btn orp-audio__control-btn--sm"
                    :aria-label="mutedState ? 'Unmute' : 'Mute'"
                    @click="toggleMute"
                >
                    <i :class="mutedState || volume === 0 ? 'bi bi-volume-mute-fill' : 'bi bi-volume-up-fill'" aria-hidden="true"></i>
                </button>

                <div class="orp-audio__volume">
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

                <span class="orp-audio__speed">{{ currentSpeedLabel }}</span>
            </div>
        </div>
    </div>
</template>
