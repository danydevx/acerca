<script setup>
import { ref, inject, onMounted, onUnmounted, watch } from 'vue'

const props = defineProps({
    position: {
        type: Array,
        required: true
    },
    draggable: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['click', 'dragend'])

const mapContext = inject('orpMap')
const markerInstance = ref(null)

onMounted(() => {
    if (!mapContext) {
        console.warn('OrpMapMarker must be used inside OrpMap')
        return
    }

    const checkMap = setInterval(() => {
        const map = mapContext.getMap()
        if (map && mapContext.isReady()) {
            clearInterval(checkMap)

            markerInstance.value = L.marker(props.position, {
                draggable: props.draggable
            }).addTo(map)

            markerInstance.value.on('click', (e) => {
                emit('click', e)
            })

            if (props.draggable) {
                markerInstance.value.on('dragend', (e) => {
                    emit('dragend', e)
                })
            }
        }
    }, 10)

    onUnmounted(() => {
        clearInterval(checkMap)
    })
})

onUnmounted(() => {
    if (markerInstance.value) {
        markerInstance.value.remove()
        markerInstance.value = null
    }
})

watch(() => props.position, (newPosition) => {
    if (markerInstance.value && newPosition) {
        markerInstance.value.setLatLng(newPosition)
    }
})
</script>

<template>
    <slot />
</template>
