<template>
  <div class="audio-player">
    <audio
      ref="audioRef"
      :src="src"
      :preload="preload"
      :autoplay="autoplay"
      :muted="muted"
      :loop="loop"
      @timeupdate="onTimeUpdate"
      @loadedmetadata="onLoadedMetadata"
      @ended="$emit('ended')"
    ></audio>

    <div class="audio-player__artwork">
      <img v-if="artwork" :src="artwork" :alt="title">
      <div v-else class="audio-player__artwork-placeholder">
        <i class="bi bi-music-note"></i>
      </div>
    </div>

    <div class="audio-player__content">
      <div class="audio-player__header">
        <div>
          <h3 class="audio-player__title">{{ title || 'Unknown Title' }}</h3>
          <p v-if="artist" class="audio-player__subtitle">{{ artist }}</p>
        </div>
        <span v-if="duration" class="audio-player__duration">{{ formatTime(duration) }}</span>
      </div>

      <div class="audio-player__timeline">
        <span class="audio-player__time">{{ formatTime(currentTime) }}</span>
        <div class="audio-player__progress">
          <div class="audio-player__progress-bar" :style="{ width: `${progress}%` }"></div>
        </div>
        <input
          type="range"
          class="audio-player__range"
          min="0"
          :max="duration || 100"
          :value="currentTime"
          @input="onSeek"
        >
        <span class="audio-player__time">{{ formatTime(duration) }}</span>
      </div>

      <div class="audio-player__controls">
        <button class="audio-player__btn" aria-label="Rewind 10s" @click="seek(-10)">
          <i class="bi bi-arrow-left-short"></i>
        </button>

        <button class="audio-player__btn audio-player__btn--play" :aria-label="isPlaying ? 'Pause' : 'Play'" @click="togglePlay">
          <i :class="isPlaying ? 'bi bi-pause-fill' : 'bi bi-play-fill'"></i>
        </button>

        <button class="audio-player__btn" aria-label="Forward 10s" @click="seek(10)">
          <i class="bi bi-arrow-right-short"></i>
        </button>
      </div>

      <div class="audio-player__secondary-controls">
        <button class="audio-player__btn audio-player__btn--sm" :aria-label="isMuted ? 'Unmute' : 'Mute'" @click="toggleMute">
          <i :class="isMuted || volume === 0 ? 'bi bi-volume-mute-fill' : 'bi bi-volume-up-fill'"></i>
        </button>

        <input
          type="range"
          class="audio-player__volume-range"
          min="0"
          max="1"
          step="0.1"
          :value="isMuted ? 0 : volume"
          @input="onVolumeChange"
        >
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  src: { type: String, default: '' },
  title: { type: String, default: '' },
  artist: { type: String, default: '' },
  album: { type: String, default: '' },
  artwork: { type: String, default: '' },
  duration: { type: Number, default: 0 },
  preload: { type: String, default: 'metadata' },
  autoplay: { type: Boolean, default: false },
  muted: { type: Boolean, default: false },
  loop: { type: Boolean, default: false },
})

const emit = defineEmits(['play', 'pause', 'ended', 'timeupdate'])

const audioRef = ref(null)
const isPlaying = ref(false)
const currentTime = ref(0)
const audioDuration = ref(props.duration)
const volume = ref(1)
const isMuted = ref(props.muted)

const progress = computed(() => {
  if (!audioDuration.value) return 0
  return (currentTime.value / audioDuration.value) * 100
})

const formatTime = (seconds) => {
  if (!seconds || isNaN(seconds)) return '0:00'
  const mins = Math.floor(seconds / 60)
  const secs = Math.floor(seconds % 60)
  return `${mins}:${secs.toString().padStart(2, '0')}`
}

const onTimeUpdate = () => {
  if (audioRef.value) {
    currentTime.value = audioRef.value.currentTime
    emit('timeupdate', currentTime.value)
  }
}

const onLoadedMetadata = () => {
  if (audioRef.value) {
    audioDuration.value = audioRef.value.duration
  }
}

const togglePlay = () => {
  if (!audioRef.value) return
  if (isPlaying.value) {
    audioRef.value.pause()
    isPlaying.value = false
    emit('pause')
  } else {
    audioRef.value.play()
    isPlaying.value = true
    emit('play')
  }
}

const seek = (delta) => {
  if (!audioRef.value) return
  audioRef.value.currentTime = Math.max(0, Math.min(audioRef.value.currentTime + delta, audioDuration.value))
  currentTime.value = audioRef.value.currentTime
}

const onSeek = (e) => {
  if (!audioRef.value) return
  const val = parseFloat(e.target.value)
  audioRef.value.currentTime = val
  currentTime.value = val
}

const toggleMute = () => {
  if (!audioRef.value) return
  isMuted.value = !isMuted.value
  audioRef.value.muted = isMuted.value
}

const onVolumeChange = (e) => {
  if (!audioRef.value) return
  const val = parseFloat(e.target.value)
  audioRef.value.volume = val
  volume.value = val
  isMuted.value = val === 0
}
</script>

<style lang="scss" scoped>
.audio-player {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: var(--bulma-scheme-main);
  border: 1px solid var(--bulma-border);
  border-radius: var(--bulma-radius-large);

  &__artwork {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    border-radius: var(--bulma-radius);
    overflow: hidden;
    background: var(--bulma-scheme-main-bis);

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    &-placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--bulma-text-weak);

      i {
        font-size: 2rem;
      }
    }
  }

  &__content {
    flex: 1;
    min-width: 0;
  }

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.5rem;
  }

  &__title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  &__subtitle {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    margin: 0.125rem 0 0;
  }

  &__duration {
    font-size: 0.875rem;
    color: var(--bulma-text-weak);
    flex-shrink: 0;
  }

  &__timeline {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
  }

  &__time {
    font-size: 0.75rem;
    color: var(--bulma-text-weak);
    font-variant-numeric: tabular-nums;
    flex-shrink: 0;
    width: 2.5rem;
  }

  &__progress {
    flex: 1;
    height: 4px;
    background: var(--bulma-border);
    border-radius: 9999px;
    overflow: hidden;
    position: relative;
  }

  &__progress-bar {
    height: 100%;
    background: var(--bulma-primary);
    border-radius: 9999px;
  }

  &__range {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
  }

  &__controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
  }

  &__secondary-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
  }

  &__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    padding: 0;
    background: transparent;
    border: none;
    border-radius: var(--bulma-radius-small);
    color: var(--bulma-text);
    cursor: pointer;
    transition: background 150ms, color 150ms;

    &:hover {
      background: var(--bulma-scheme-main-bis);
    }

    i {
      font-size: 1.25rem;
    }

    &--play {
      width: 48px;
      height: 48px;
      background: var(--bulma-primary);
      color: var(--bulma-primary-invert);
      border-radius: 50%;

      &:hover {
        background: color-mix(in oklch, var(--bulma-primary) 90%, black);
      }

      i {
        font-size: 1.5rem;
      }
    }

    &--sm {
      width: 28px;
      height: 28px;

      i {
        font-size: 1rem;
      }
    }
  }

  &__volume-range {
    flex: 1;
    max-width: 100px;
    height: 4px;
    cursor: pointer;
    -webkit-appearance: none;
    appearance: none;
    background: transparent;

    &::-webkit-slider-runnable-track {
      width: 100%;
      height: 4px;
      background: var(--bulma-border);
      border-radius: 9999px;
    }

    &::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 12px;
      height: 12px;
      background: var(--bulma-primary);
      border-radius: 50%;
      margin-top: -4px;
      cursor: pointer;
    }

    &::-moz-range-track {
      width: 100%;
      height: 4px;
      background: var(--bulma-border);
      border-radius: 9999px;
    }

    &::-moz-range-thumb {
      width: 12px;
      height: 12px;
      background: var(--bulma-primary);
      border-radius: 50%;
      border: none;
      cursor: pointer;
    }
  }
}
</style>
