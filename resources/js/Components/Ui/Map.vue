<template>
  <div class="ui-map" :style="{ height: height }">
    <div ref="mapContainer" class="ui-map__container"></div>
    <slot></slot>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

const defaultIcon = L.icon({
  iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
  iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [0, -41],
})

const props = defineProps({
  center: {
    type: Array,
    default: () => [20.6736, -103.344],
  },
  zoom: {
    type: Number,
    default: 14,
  },
  height: {
    type: String,
    default: '300px',
  },
  scrollWheelZoom: {
    type: Boolean,
    default: false,
  },
  dragging: {
    type: Boolean,
    default: true,
  },
  zoomControl: {
    type: Boolean,
    default: true,
  },
  markers: {
    type: Array,
    default: () => [],
  },
})

const emit = defineEmits(['ready', 'click', 'moveend', 'zoomend'])

const mapContainer = ref(null)
const mapInstance = ref(null)

const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
const tileAttribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'

const initMap = () => {
  if (!mapContainer.value || mapInstance.value) return

  mapInstance.value = L.map(mapContainer.value, {
    center: props.center,
    zoom: props.zoom,
    scrollWheelZoom: props.scrollWheelZoom,
    dragging: props.dragging,
    zoomControl: props.zoomControl,
    zoomAnimation: true,
  })

  L.tileLayer(tileUrl, {
    attribution: tileAttribution,
    maxZoom: 19,
  }).addTo(mapInstance.value)

  mapInstance.value.on('click', (e) => {
    emit('click', e)
  })

  mapInstance.value.on('moveend', () => {
    emit('moveend')
  })

  mapInstance.value.on('zoomend', () => {
    emit('zoomend')
  })

  addMarkers()

  emit('ready', mapInstance.value)
}

const addMarkers = () => {
  if (!mapInstance.value || !props.markers.length) return

  props.markers.forEach((marker) => {
    let icon = defaultIcon
    if (marker.iconUrl) {
      icon = L.icon({
        iconUrl: marker.iconUrl,
        iconSize: marker.iconSize || [25, 41],
        iconAnchor: marker.iconAnchor || [12, 41],
        popupAnchor: marker.popupAnchor || [0, -41],
      })
    }

    const LMarker = L.marker(marker.position, { icon })

    if (marker.popup) {
      LMarker.bindPopup(marker.popup)
    }

    LMarker.addTo(mapInstance.value)
  })
}

onMounted(() => {
  initMap()
})

onUnmounted(() => {
  if (mapInstance.value) {
    try {
      mapInstance.value.remove()
    } catch (e) {
      // Map already removed
    }
    mapInstance.value = null
  }
})

watch(() => props.center, (newCenter) => {
  if (mapInstance.value && newCenter) {
    mapInstance.value.setView(newCenter)
  }
})

watch(() => props.zoom, (newZoom) => {
  if (mapInstance.value && newZoom) {
    mapInstance.value.setZoom(newZoom)
  }
})

defineExpose({
  getMap: () => mapInstance.value,
  invalidateSize: () => {
    if (mapInstance.value) {
      mapInstance.value.invalidateSize()
    }
  },
})
</script>

<style lang="scss" scoped>
.ui-map {
  position: relative;
  width: 100%;
  border-radius: var(--bulma-radius-large);
  overflow: hidden;
  border: 1px solid var(--bulma-border);

  &__container {
    width: 100%;
    height: 100%;
  }
}

:deep(.leaflet-popup-content-wrapper) {
  border-radius: var(--bulma-radius);
}

:deep(.leaflet-popup-content) {
  margin: 0.75rem;
  font-family: var(--bulma-family-sans-serif);
}
</style>
