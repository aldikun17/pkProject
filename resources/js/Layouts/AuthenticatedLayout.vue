<script setup>
import { ref } from "vue";
import { usePage  } from "@inertiajs/vue3";
import { useTheme } from '../Composable/useTheme/useTheme.js';
import { useSidebar } from '../Composable/useSideBar/useSideBar.js';
import lightComponent from   './../Components/buttons/lightSettings/lightSettings.vue';
import sidebarComponent from '../Components/sidebar/content/sidebarContent.vue';
const { theme , setTheme } = useTheme();
const { open, toggle, close } = useSidebar();
const page = usePage();
const props = defineProps({
    content: {
        type:Object,
        required: true
    }
});
//const showingNavigationDropdown = ref(false);
//const isActive = (href) => page.url.startsWith(href)
function changeTheme(newTheme) {
    theme.value = newTheme;
    setTheme(newTheme);
}
console.log();
</script>

<template>
    <div class="flex h-screen overflow-hidden" @keydown.[.window="toggle">
        <div v-if="open" class="fixed inset-0 z-20 bg-black/50 md:hidden" @click="close" />
        <aside class="w-[17rem] shrink-0 flex flex-col bg-surface border-r border-line transition-[margin,transform] duration-200 max-md:fixed max-md:inset-y-0
        max-md:left-0 max-md:z-30" :class="open ? 'max-md:translate-x-0' : '-ml-[17rem] invisible max-md:ml-0 max-md:-translate-x-full'">
            <sidebarComponent :content="$page.props.content"></sidebarComponent>
        </aside>
        <div class="flex-1 min-w-0 flex flex-col">
            <header class="h-14 px-4 flex items-center gap-3 border-b border-line bg-surface">
                <button class="icon-btn" aria-label="Toggle sidebar" :aria-expanded="open" @click="toggle">☰</button>
                <div class="flex-1" />
                <lightComponent :themeColor="theme" @toggle-theme="changeTheme" />
            </header>
            <main class="flex-1 overflow-y-auto p-4 md:p-10">
                <div class="min-h-screen bg-bg py-12">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
