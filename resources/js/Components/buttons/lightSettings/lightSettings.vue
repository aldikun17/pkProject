<script setup>
const props = defineProps({
    themeColor: {
        type: String,
        default: 'light',
    },
});
const emit = defineEmits(['toggle-theme']);
function toggleTheme() {
    const newTheme = props.themeColor === 'dark' ? 'light' : 'dark';

    emit('toggle-theme', newTheme);
}
</script>
<template>
    <button class="icon-btn" type="button" :aria-label="themeColor === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'" @click="toggleTheme">

        <svg v-if="themeColor === 'dark'" width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="4" />
            <path d="M12 2v2M12 20v2M2 12h2M20 12h2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
        </svg>

        <svg v-else width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M20 14.5A8.5 8.5 0 019.5 4 8.5 8.5 0 1020 14.5z" />
        </svg>

    </button>
</template>
