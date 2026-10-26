<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import taguigMap from '../Map/taguigMap.vue';
const props = defineProps({
  places: { type: Array, default: () => [] },   // [{ id, name, lat, lng }]
  center: { type: Array, default: () => [] },
  zoom: { type: Number, default: 0 },
})
console.log(props.places);

</script>
<template>
    <AuthenticatedLayout>
        <taguigMap :places="props.places" :center="props.center" :zoom="props.zoom" ></taguigMap>
    </AuthenticatedLayout>
</template>
