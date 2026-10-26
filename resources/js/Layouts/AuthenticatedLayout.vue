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
            <sidebarComponent></sidebarComponent>
        </aside>
        <div class="flex-1 min-w-0 flex flex-col">
            <header class="h-14 px-4 flex items-center gap-3 border-b border-line bg-surface">
                <button class="icon-btn" aria-label="Toggle sidebar" :aria-expanded="open" @click="toggle">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2"></rect><path d="M9 4v16"></path></svg>
                </button>
                <div class="min-w-0 flex-1 truncate text-muted text-sm">
                    Redline Studio <span class="mx-1 opacity-60">/</span> <span class="text-fg font-medium" id="crumb">Overview</span>
                </div>
                <div class="flex-1" />
                <lightComponent :themeColor="theme" @toggle-theme="changeTheme" />
            </header>

            <main class="flex-1 overflow-y-auto p-2 md:p-4">
                <div class="min-h-screen bg-bg">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
