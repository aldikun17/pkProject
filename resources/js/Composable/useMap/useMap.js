
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import * as leaflet from 'leaflet';
import 'leaflet/dist/leaflet.css';
import booleanPointInPolygon from '@turf/boolean-point-in-polygon'

export default function useMap(mapLayout, props, emit) {
    let map = null;
    let layer = null;
    let borderLayer = null;
    let landFeature = null;
    let selectedMarker = null;
    const showModal = ref(false);
    const selectedLat = ref(null);
    const selectedLng = ref(null);

    function initializeMap() {
        if (!mapLayout.value || map) return;

        map = leaflet.map(mapLayout.value).setView(
            props.center,
            props.zoom
        );

        leaflet.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                maxZoom: props.zoom,
                attribution: '&copy; OpenStreetMap contributors',
            }
        ).addTo(map);

        layer = leaflet.layerGroup().addTo(map);

        map.on('click', handleMapClick);
        map.on('popupopen', handlePopupOpen);
    }

    function renderMap() {
        if (!map || !layer) return;

        layer.clearLayers();

        props.places.forEach((p) => {
            leaflet.marker([p.lat, p.lng])
                .bindPopup(p.name)
                .addTo(layer);
        });

        if (props.places.length) {
            map.fitBounds(
                leaflet.latLngBounds(
                    props.places.map((p) => [p.lat, p.lng])
                ),
                { padding: [30, 30] }
            );
        }
    }

    function handleMapClick(e) {
        const { lat, lng } = e.latlng;

        if (landFeature) {
            const features =
                landFeature.type === 'FeatureCollection'
                    ? landFeature.features
                    : [landFeature];

            const insideTaguig = features.some((feature) =>
                booleanPointInPolygon([lng, lat], feature)
            );

            if (!insideTaguig) return;
        }

        selectedLat.value = lat.toFixed(7);
        selectedLng.value = lng.toFixed(7);

        if (selectedMarker) {
            selectedMarker.setLatLng([lat, lng]);
        } else {
            selectedMarker = leaflet.marker([lat, lng]).addTo(map);
        }

        selectedMarker
            .bindPopup(`
                <button
                    type="button"
                    id="open-location-modal"
                    style="color:#2563eb;font-weight:600;cursor:pointer;"
                >
                    Selected Location
                </button>
            `)
            .openPopup();
    }

    function handlePopupOpen(e) {
        const popupElement = e.popup.getElement();
        const button = popupElement?.querySelector(
            '#open-location-modal'
        );

        if (button) {
            button.onclick = () => {
                showModal.value = true;
                selectedMarker?.closePopup();
            };
        }
    }

    function closeModal() {
        showModal.value = false;
    }

    function confirmLocation() {
        emit('pick', {
            lat: selectedLat.value,
            lng: selectedLng.value,
        });

        closeModal();
    }

    async function addBorder() {
        try {
            const res = await fetch('/geo/taguig.geojson');

            if (!res.ok) {
                throw new Error('Failed to load Taguig GeoJSON');
            }

            const data = await res.json();
            landFeature = data;

            borderLayer = leaflet.geoJSON(data, {
                style: {
                    color: '#0E0D0D',
                    weight: 3,
                    opacity: 0.9,
                    fill: false,
                },
            }).addTo(map);

            map.fitBounds(borderLayer.getBounds(), {
                padding: [20, 20],
            });
        } catch (error) {
            console.error('Unable to load map boundary:', error);
        }
    }

    function areaPinpont() {
        if (!map) return;

        map.on('click', handleAreaPinpoint);
    }

    function handleAreaPinpoint(e) {
        if (!landFeature) return;

        const { lat, lng } = e.latlng;

        if (!booleanPointInPolygon([lng, lat], landFeature)) return;

        emit('pick', { lat, lng });
    }

    onMounted(async () => {
        initializeMap();
        await addBorder();
        renderMap();
    });

    watch(() => props.places, renderMap, { deep: true });

    onBeforeUnmount(() => {
        map?.off('click', handleMapClick);
        map?.off('popupopen', handlePopupOpen);
        map?.off('click', handleAreaPinpoint);
        map?.remove();

        map = null;
        layer = null;
    });

    return {
        showModal,
        selectedLat,
        selectedLng,
        initializeMap,
        renderMap,
        handleMapClick,
        handlePopupOpen,
        closeModal,
        confirmLocation,
        addBorder,
        areaPinpont,
    };
}
