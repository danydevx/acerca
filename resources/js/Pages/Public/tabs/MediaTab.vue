<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Gallery</h3>
      <div class="mb-4">
        <UiGallery :items="galleryImages" :columns="3" />
      </div>
      <div class="mb-4">
        <h4 class="subtitle is-6">Gallery with 4 columns</h4>
        <UiGallery :items="galleryImages" :columns="4" />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Media (Single Image)</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiMedia
            src="https://picsum.photos/400/400?random=10"
            alt="Square image"
            aspect="square"
          />
          <p class="is-size-7 mt-2">Square aspect ratio</p>
        </div>
        <div class="column is-4">
          <UiMedia
            src="https://picsum.photos/400/300?random=11"
            alt="Landscape image"
            aspect="landscape"
          />
          <p class="is-size-7 mt-2">Landscape aspect ratio</p>
        </div>
        <div class="column is-4">
          <UiMedia
            src="https://picsum.photos/300/400?random=12"
            alt="Portrait image"
            aspect="portrait"
          />
          <p class="is-size-7 mt-2">Portrait aspect ratio</p>
        </div>
      </div>
      <div class="columns">
        <div class="column is-6">
          <UiMedia
            src="https://picsum.photos/600/340?random=13"
            alt="Wide image"
            aspect="wide"
          />
          <p class="is-size-7 mt-2">Wide aspect ratio (16:9)</p>
        </div>
        <div class="column is-6">
          <UiMedia
            src="https://picsum.photos/400/400?random=14"
            alt="Rounded image"
            aspect="square"
            :rounded="true"
          />
          <p class="is-size-7 mt-2">Rounded corners</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Avatar</h3>
      <div class="columns is-vcentered">
        <div class="column is-2 has-text-centered">
          <UiAvatar :size="16" name="XS" />
          <p class="is-size-7 mt-2">16px - XS</p>
        </div>
        <div class="column is-2 has-text-centered">
          <UiAvatar :size="24" name="S" />
          <p class="is-size-7 mt-2">24px - S</p>
        </div>
        <div class="column is-2 has-text-centered">
          <UiAvatar :size="32" name="M" />
          <p class="is-size-7 mt-2">32px - M</p>
        </div>
        <div class="column is-2 has-text-centered">
          <UiAvatar :size="48" name="L" />
          <p class="is-size-7 mt-2">48px - L</p>
        </div>
        <div class="column is-2 has-text-centered">
          <UiAvatar :size="64" name="XL" />
          <p class="is-size-7 mt-2">64px - XL</p>
        </div>
        <div class="column is-2 has-text-centered">
          <UiAvatar :size="96" name="XXL" />
          <p class="is-size-7 mt-2">96px - XXL</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Avatar with Image</h3>
      <div class="columns is-vcentered">
        <div class="column is-2 has-text-centered">
          <UiAvatar
            src="https://picsum.photos/150/150?random=20"
            :size="64"
            name="John Doe"
          />
          <p class="is-size-7 mt-2">With image</p>
        </div>
        <div class="column is-2 has-text-centered">
          <UiAvatar
            src="https://picsum.photos/150/150?random=21"
            :size="64"
            name="Jane Smith"
          />
          <p class="is-size-7 mt-2">With image</p>
        </div>
        <div class="column is-2 has-text-centered">
          <UiAvatar
            :size="64"
            name="No Image"
          />
          <p class="is-size-7 mt-2">Without image</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Avatar Rounded</h3>
      <div class="columns">
        <div class="column is-2 has-text-centered">
          <UiAvatar
            src="https://picsum.photos/150/150?random=25"
            :size="64"
            name="Rounded"
            :rounded="true"
          />
          <p class="is-size-7 mt-2">Rounded</p>
        </div>
        <div class="column is-2 has-text-centered">
          <UiAvatar
            src="https://picsum.photos/150/150?random=26"
            :size="64"
            name="Square"
          />
          <p class="is-size-7 mt-2">Square (default)</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Avatar Status</h3>
      <div class="columns is-vcentered">
        <div class="column is-2 has-text-centered">
          <div class="ui-avatar-status">
            <UiAvatar
              src="https://picsum.photos/150/150?random=30"
              :size="64"
              name="Online"
              :rounded="true"
            />
            <span class="ui-avatar-status__indicator ui-avatar-status__indicator--online"></span>
          </div>
          <p class="is-size-7 mt-2">Online</p>
        </div>
        <div class="column is-2 has-text-centered">
          <div class="ui-avatar-status">
            <UiAvatar
              src="https://picsum.photos/150/150?random=31"
              :size="64"
              name="Away"
              :rounded="true"
            />
            <span class="ui-avatar-status__indicator ui-avatar-status__indicator--away"></span>
          </div>
          <p class="is-size-7 mt-2">Away</p>
        </div>
        <div class="column is-2 has-text-centered">
          <div class="ui-avatar-status">
            <UiAvatar
              src="https://picsum.photos/150/150?random=32"
              :size="64"
              name="Busy"
              :rounded="true"
            />
            <span class="ui-avatar-status__indicator ui-avatar-status__indicator--busy"></span>
          </div>
          <p class="is-size-7 mt-2">Busy</p>
        </div>
        <div class="column is-2 has-text-centered">
          <div class="ui-avatar-status">
            <UiAvatar
              src="https://picsum.photos/150/150?random=33"
              :size="64"
              name="Offline"
              :rounded="true"
            />
            <span class="ui-avatar-status__indicator ui-avatar-status__indicator--offline"></span>
          </div>
          <p class="is-size-7 mt-2">Offline</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Avatar Upload</h3>
      <div class="columns">
        <div class="column is-3">
          <UiAvatarUpload />
          <p class="is-size-7 mt-2 has-text-centered">Default</p>
        </div>
        <div class="column is-3">
          <UiAvatarUpload
            src="https://picsum.photos/200/200?random=40"
            label="Profile Photo"
            :removable="true"
          />
          <p class="is-size-7 mt-2 has-text-centered">With image</p>
        </div>
        <div class="column is-3">
          <UiAvatarUpload
            label="Uploading..."
            :uploading="true"
            :progress="65"
          />
          <p class="is-size-7 mt-2 has-text-centered">Uploading</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Video Card</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiVideoCard
            title="Building with Bulma"
            thumbnail="https://picsum.photos/400/225?random=50"
            :duration="120"
            author="John Doe"
          />
        </div>
        <div class="column is-4">
          <UiVideoCard
            title="Vue 3 Tutorial"
            thumbnail="https://picsum.photos/400/225?random=51"
            :duration="1845"
            author="Jane Smith"
            :views="12500"
          />
        </div>
        <div class="column is-4">
          <UiVideoCard
            title="Laravel Best Practices"
            thumbnail="https://picsum.photos/400/225?random=52"
            :duration="3600"
            author="Bob Wilson"
            :views="45200"
            :premium="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Video Player</h3>
      <UiVideoPlayer
        src="https://www.w3schools.com/html/mov_bbb.mp4"
        poster="https://picsum.photos/800/450?random=60"
        title="Sample Video"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">Audio Player</h3>
      <UiAudioPlayer
        src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"
        title="Summer Vibes"
        artist="DJ Mix"
        album="Beach Party"
        cover="https://picsum.photos/300/300?random=70"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import UiGallery from '@/Components/Ui/Gallery.vue'
import UiMedia from '@/Components/Ui/Media.vue'
import UiAvatar from '@/Components/Ui/Avatar.vue'
import UiAvatarUpload from '@/Components/Ui/AvatarUpload.vue'
import UiVideoCard from '@/Components/Ui/VideoCard.vue'
import UiVideoPlayer from '@/Components/Ui/VideoPlayer.vue'
import UiAudioPlayer from '@/Components/Ui/AudioPlayer.vue'

const galleryImages = ref([
  { id: 1, src: 'https://picsum.photos/400/400?random=1', alt: 'Gallery Image 1' },
  { id: 2, src: 'https://picsum.photos/400/400?random=2', alt: 'Gallery Image 2' },
  { id: 3, src: 'https://picsum.photos/400/400?random=3', alt: 'Gallery Image 3' },
  { id: 4, src: 'https://picsum.photos/400/400?random=4', alt: 'Gallery Image 4' },
  { id: 5, src: 'https://picsum.photos/400/400?random=5', alt: 'Gallery Image 5' },
  { id: 6, src: 'https://picsum.photos/400/400?random=6', alt: 'Gallery Image 6' },
])
</script>

<style lang="scss" scoped>
.playground-section {
  padding: 1rem 0;
}

.mb-4 {
  margin-bottom: 1.5rem;
}

.mt-2 {
  margin-top: 0.5rem;
}

.ui-avatar-status {
  position: relative;
  display: inline-block;

  &__indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid white;

    &--online {
      background: #48c78e;
    }

    &--away {
      background: #ffe08a;
    }

    &--busy {
      background: #f14668;
    }

    &--offline {
      background: #b5b5b5;
    }
  }
}
</style>
