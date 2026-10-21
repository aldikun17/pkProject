<script setup>
import { Link , usePage } from '@inertiajs/vue3'
const page = usePage();
const sidebarOption = defineEmits(['sidebar-toggle']);
function sidebar_toggle(){
    const item = props.String === 'Open' ? 'Clo' : 'dark';
    emit('sidebar-toggle', newTheme);
}
//const isActive = (href) => page.url.startsWith(href)
const isActive = (href) => page.url.startsWith(href)
</script>
<template>
    <div class="h-14 px-4 flex items-center gap-3 border-b border-line">
        <span class="font-display font-bold"> CGT </span>
    </div>
    <nav class="flex-1 p-4 flex flex-col gap-1">
        <Link v-for="(url, label) in page.props.auth.sidebar" :key="label" :href="url" class="rounded-lg px-3 py-2 font-medium transition-colors"
        :class="isActive(label.href) ? 'bg-accentsoft text-link' : 'text-muted hover:bg-surface2 hover:text-fg'" >
            {{ label.charAt(0).toUpperCase() + label.slice(1).replaceAll('_', ' ') }} <!-- capitalize the first letter and remove the underscore -->
        </Link>
    </nav>
</template>
