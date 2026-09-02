<script setup>
import { ref, provide, onMounted, onUnmounted, watch } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

delete L.Icon.Default.prototype._getIconUrl
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
})

const props = defineProps({
    center: {
        type: Array,
        default: () => [20.6736, -103.344]
    },
    zoom: {
        type: Number,
        default: 14
    },
    minZoom: {
        type: Number,
        default: 1
    },
    maxZoom: {
        type: Number,
        default: 19
    },
    scrollWheelZoom: {
        type: Boolean,
        default: false
    },
    dragging: {
        type: Boolean,
        default: true
    },
    zoomControl: {
        type: Boolean,
        default: true
    },
    height: {
        type: String,
        default: '300px'
    }
})

const emit = defineEmits(['ready', 'click', 'moveend', 'zoomend'])

const mapContainer = ref(null)
const mapInstance = ref(null)
const isReady = ref(false)

const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
const tileAttribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'

provide('orpMap', {
    getMap: () => mapInstance.value,
    isReady: () => isReady.value
})

onMounted(() => {
    if (!mapContainer.value) return

    mapInstance.value = L.map(mapContainer.value, {
        center: props.center,
        zoom: props.zoom,
        minZoom: props.minZoom,
        maxZoom: props.maxZoom,
        scrollWheelZoom: props.scrollWheelZoom,
        dragging: props.dragging,
        zoomControl: props.zoomControl,
        zoomAnimation: true,
    })

    L.tileLayer(tileUrl, {
        attribution: tileAttribution,
        maxZoom: props.maxZoom
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

    isReady.value = true
    emit('ready', mapInstance.value)
})

onUnmounted(() => {
    if (mapInstance.value) {
        mapInstance.value.remove()
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
    }
})
</script>

<template>
    <div class="orp-map">
        <div
            ref="mapContainer"
            class="orp-map__canvas"
            :style="{ height: height }"
            :aria-label="ariaLabel"
        ></div>
        <slot />
    </div>
</template>

<script>
export default {
    inheritAttrs: false
}
</script>

<style lang="less">
@import '../../../less/orp-ui/components/_map.less';
</style>
