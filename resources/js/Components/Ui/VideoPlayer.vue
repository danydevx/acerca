<template>
  <div
    class="video-player"
    :class="[`video-player--${aspectRatio}`]"
  >
    <video
      ref="videoRef"
      class="video-player__media"
      :src="src"
      :poster="poster"
      :autoplay="autoplay"
      :muted="muted"
      :loop="loop"
      playsinline
      @play="$emit('play')"
      @pause="$emit('pause')"
      @ended="$emit('ended')"
      @timeupdate="$emit('timeupdate', currentTime)"
      @loadedmetadata="onLoadedMetadata"
    >
      <track
        v-for="(track, index) in tracks"
        :key="index"
        :kind="track.kind"
        :label="track.label"
        :srclang="track.language"
      >
    </video>

    <div v-if="poster && !isPlaying" class="video-player__poster" @click="togglePlay">
      <img :src="poster" :alt="title" class="video-player__poster-img">
      <div class="video-player__play-overlay">
        <div class="video-player__play-icon">
          <i class="bi bi-play-fill"></i>
        </div>
      </div>
      <div v-if="title" class="video-player__poster-meta">
        <p class="video-player__poster-title">{{ title }}</p>
        <span v-if="duration" class="video-player__poster-duration">{{ formatTime(duration) }}</span>
      </div>
    </div>

    <div v-if="showControls" class="video-player__controls" :class="{ 'video-player__controls--visible': controlsVisible || !isPlaying }">
      <div class="video-player__timeline">
        <span class="video-player__time">{{ formatTime(currentTime) }}</span>
        <div class="video-player__progress">
          <div class="video-player__progress-bar" :style="{ width: `${progress}%` }"></div>
        </div>
        <input
          type="range"
          class="video-player__range"
          min="0"
          :max="duration || 100"
          :value="currentTime"
          @input="onSeek"
        >
        <span class="video-player__time">{{ formatTime(duration) }}</span>
      </div>

      <div class="video-player__controls-row">
        <div class="video-player__controls-left">
          <button class="video-player__btn" :aria-label="isPlaying ? 'Pause' : 'Play'" @click="togglePlay">
            <i :class="isPlaying ? 'bi bi-pause-fill' : 'bi bi-play-fill'"></i>
          </button>

          <div class="video-player__volume">
            <button class="video-player__btn video-player__btn--sm" :aria-label="isMuted ? 'Unmute' : 'Mute'" @click="toggleMute">
              <i :class="volumeIcon"></i>
            </button>
            <input
              type="range"
              class="video-player__volume-range"
              min="0"
              max="1"
              step="0.1"
              :value="isMuted ? 0 : volume"
              @input="onVolumeChange"
            >
          </div>

          <span v-if="title" class="video-player__title">{{ title }}</span>
        </div>

        <div class="video-player__controls-right">
          <button v-if="canFullscreen" class="video-player__btn video-player__btn--sm" :aria-label="isFullscreen ? 'Exit fullscreen' : 'Fullscreen'" @click="toggleFullscreen">
            <i :class="isFullscreen ? 'bi bi-fullscreen-exit' : 'bi bi-fullscreen'"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  src: { type: String, default: '' },
  poster: { type: String, default: '' },
  title: { type: String, default: '' },
  autoplay: { type: Boolean, default: false },
  muted: { type: Boolean, default: false },
  loop: { type: Boolean, default: false },
  aspectRatio: { type: String, default: '16-9' },
  showControls: { type: Boolean, default: true },
  tracks: { type: Array, default: () => [] },
})

const emit = defineEmits(['play', 'pause', 'ended', 'timeupdate'])

const videoRef = ref(null)
const isPlaying = ref(false)
const currentTime = ref(0)
const duration = ref(0)
const volume = ref(1)
const isMuted = ref(props.muted)
const isFullscreen = ref(false)
const controlsVisible = ref(true)
const canFullscreen = ref(false)

const progress = computed(() => {
  if (!duration.value) return 0
  return (currentTime.value / duration.value) * 100
})

const volumeIcon = computed(() => {
  if (isMuted.value || volume.value === 0) return 'bi bi-volume-mute-fill'
  if (volume.value < 0.5) return 'bi bi-volume-down-fill'
  return 'bi bi-volume-up-fill'
})

const formatTime = (seconds) => {
  if (!seconds || isNaN(seconds)) return '0:00'
  const mins = Math.floor(seconds / 60)
  const secs = Math.floor(seconds % 60)
  return `${mins}:${secs.toString().padStart(2, '0')}`
}

const onLoadedMetadata = () => {
  if (videoRef.value) {
    duration.value = videoRef.value.duration
    canFullscreen.value = !!document.fullscreenEnabled
  }
}

const togglePlay = () => {
  if (!videoRef.value) return
  if (isPlaying.value) {
    videoRef.value.pause()
    isPlaying.value = false
  } else {
    videoRef.value.play()
    isPlaying.value = true
  }
}

const toggleMute = () => {
  if (!videoRef.value) return
  isMuted.value = !isMuted.value
  videoRef.value.muted = isMuted.value
}

const toggleFullscreen = async () => {
  if (!videoRef.value) return
  if (!document.fullscreenElement) {
    await videoRef.value.requestFullscreen()
    isFullscreen.value = true
  } else {
    await document.exitFullscreen()
    isFullscreen.value = false
  }
}

const onSeek = (e) => {
  if (!videoRef.value) return
  const val = parseFloat(e.target.value)
  videoRef.value.currentTime = val
  currentTime.value = val
}

const onVolumeChange = (e) => {
  if (!videoRef.value) return
  const val = parseFloat(e.target.value)
  videoRef.value.volume = val
  volume.value = val
  isMuted.value = val === 0
}
</script>

<style lang="scss" scoped>
.video-player {
  position: relative;
  width: 100%;
  background: #000;
  border-radius: var(--bulma-radius-large);
  overflow: hidden;

  &--16-9 { aspect-ratio: 16 / 9; }
  &--4-3 { aspect-ratio: 4 / 3; }
  &--1-1 { aspect-ratio: 1 / 1; }
  &--9-16 { aspect-ratio: 9 / 16; }

  &__media {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
  }

  &__poster {
    position: absolute;
    inset: 0;
    cursor: pointer;

    &:hover .video-player__play-icon {
      transform: scale(1.1);
    }
  }

  &__poster-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  &__play-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: oklch(0 0 0 / 0.3);
  }

  &__play-icon {
    width: 72px;
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: oklch(100% 0 0 / 0.9);
    border-radius: 50%;
    color: #000;
    transition: transform 150ms;

    i {
      font-size: 32px;
      margin-left: 4px;
    }
  }

  &__poster-meta {
    position: absolute;
    bottom: 1rem;
    left: 1rem;
    right: 1rem;
  }

  &__poster-title {
    color: #fff;
    font-weight: 600;
    margin: 0 0 0.5rem;
    text-shadow: 0 1px 3px oklch(0 0 0 / 0.5);
  }

  &__poster-duration {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    background: oklch(0 0 0 / 0.7);
    border-radius: var(--bulma-radius-small);
    color: #fff;
    font-size: 0.875rem;
  }

  &__controls {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem;
    background: linear-gradient(to top, oklch(0 0 0 / 0.8) 0%, transparent 100%);
    opacity: 0;
    transition: opacity 150ms;

    &--visible {
      opacity: 1;
    }
  }

  &__timeline {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
  }

  &__time {
    color: #fff;
    font-size: 0.875rem;
    font-variant-numeric: tabular-nums;
    flex-shrink: 0;
  }

  &__progress {
    position: absolute;
    left: 4rem;
    right: 4rem;
    height: 3px;
    background: oklch(100% 0 0 / 0.3);
    border-radius: 9999px;
    overflow: hidden;
  }

  &__progress-bar {
    height: 100%;
    background: var(--bulma-primary);
    border-radius: 9999px;
    transition: width 0.1s linear;
  }

  &__range {
    position: absolute;
    left: 4rem;
    right: 4rem;
    height: 3px;
    opacity: 0;
    cursor: pointer;
    width: calc(100% - 8rem);
  }

  &__controls-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  &__controls-left {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
  }

  &__controls-right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  &__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    padding: 0;
    background: transparent;
    border: none;
    border-radius: var(--bulma-radius-small);
    color: #fff;
    cursor: pointer;
    transition: background 150ms;

    &:hover {
      background: oklch(100% 0 0 / 0.1);
    }

    i {
      font-size: 20px;
    }

    &--sm {
      width: 32px;
      height: 32px;

      i {
        font-size: 16px;
      }
    }
  }

  &__volume {
    display: flex;
    align-items: center;
    gap: 0.5rem;

    &:hover .video-player__volume-range {
      width: 80px;
    }
  }

  &__volume-range {
    width: 0;
    height: 3px;
    overflow: hidden;
    transition: width 150ms;
    cursor: pointer;
  }

  &__title {
    color: #fff;
    font-size: 0.875rem;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
  }
}
</style>
