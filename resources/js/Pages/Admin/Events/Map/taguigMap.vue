<script setup>
import { onMounted, onBeforeUnmount, ref, watch } from 'vue'
import * as leaflet from 'leaflet'
import 'leaflet/dist/leaflet.css'
import booleanPointInPolygon from '@turf/boolean-point-in-polygon'
import markerIcon from 'leaflet/dist/images/marker-icon.png'
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png'
import markerShadow from 'leaflet/dist/images/marker-shadow.png'
import useMap from '@/Composable/useMap/useMap.js'

const mapDiv = ref(null)

const props = defineProps({
  places: { type: Array, default: () => [] },   // [{ id, name, lat, lng }]
  center: { type: Array, default: () => [] },
  zoom:   { type: Number, default: 0 },
})

const emit = defineEmits(['pick'])

const {
    showModal,
    selectedLat,
    selectedLng,
    renderMap,
    closeModal,
    confirmLocation,
    addBorder,
    areaPinpont,
} = useMap(mapDiv, props, emit);

</script>
<template>
    <div ref="mapDiv" class="h-[1000px] w-full rounded-lg z-0" />
    <!-- Coordinates Modal -->
    <div v-if="showModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 p-4" @click.self="closeLocationModal">
        <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl" role="dialog" aria-modal="true" aria-labelledby="location-title">

            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">
                    Selected Location Coordinates
                </h2>

                <button
                    type="button"
                    @click="closeModal"
                    class="text-2xl text-gray-500 hover:text-gray-900"
                    aria-label="Close modal"
                >
                    &times;
                </button>
            </div>

            <!-- Latitude textbox -->
            <div class="mb-4">
            <label
                for="latitude"
                class="mb-2 block text-sm font-medium text-gray-700"
            >
                Latitude
            </label>

            <input
                id="latitude"
                v-model="selectedLat"
                type="text"
                inputmode="decimal"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                    text-gray-900 outline-none focus:border-blue-500
                    focus:ring-2 focus:ring-blue-200"
            />
            </div>

            <!-- Longitude textbox -->
            <div class="mb-6">
            <label
                for="longitude"
                class="mb-2 block text-sm font-medium text-gray-700"
            >
                Longitude
            </label>

            <input
                id="longitude"
                v-model="selectedLng"
                type="text"
                inputmode="decimal"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                    text-gray-900 outline-none focus:border-blue-500
                    focus:ring-2 focus:ring-blue-200"
            />
            </div>

            <!-- Modal buttons -->
            <div class="flex justify-end gap-3">
            <button
                type="button"
                @click="closeModal"
                class="rounded-lg border border-gray-300 px-4 py-2
                    text-gray-700 hover:bg-gray-100"
            >
                Cancel
            </button>

            </div>
        </div>
    </div>
</template>
