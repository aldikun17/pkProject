<script setup>
import { Link , usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    categories: {
        type: Array,
    }
});
defineOptions({
    layout:  AuthenticatedLayout
});
</script>
<template>
    <div class="min-h-screen bg-bg text-slate-900">

        <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-b border-line pb-3 text-sm">
            <div class="flex"></div>
            <div class="flex flex-wrap items-center gap-1">
                <button class="flex h-8 items-center gap-1.5 rounded-md px-2.5 text-muted hover:bg-surface2 hover:text-fg"><Search class="size-4" /> Search</button>
                <button class="btn btn-outline !h-8 !py-0 !px-3 !font-medium px-2.5 py-1.5 font-medium text-link">Export</button>
                <button class="btn btn-primary !h-8 !py-0 !px-3 px-2.5 py-1.5 font-medium text-link">Add User <ChevronDown class="size-4" /></button>
            </div>
        </div>

        <!-- filters -->
        <div class="mt-3 flex flex-wrap items-center gap-2 text-sm">
            <button class="flex h-8 items-center gap-1.5 rounded-full border border-line bg-surface px-3 hover:border-cinnabar hover:bg-surface2 px-2.5 py-1.5 font-medium text-link">
                <UserCircle2 class="size-4 text-chili" /> Role: <span class="font-medium text-link">All</span> <ChevronDown class="size-3.5 text-muted" />
            </button>
            <button class="flex items-center gap-1 text-muted hover:text-fg"><Plus class="size-4" /> Add filter</button>
        </div>

        <!-- table -->
        <div class="mt-4 overflow-x-auto rounded-xl border border-line bg-surface" style="box-shadow: var(--shadow)">
            <table class="w-full min-w-[960px] text-sm">
                <thead class="bg-surface2 text-left text-muted">
                    <tr class="border-b border-line">
                        <th class="w-10 px-3 py-2.5"><input type="checkbox" class="rounded border-line accent-chili" aria-label="Select all" /></th>
                        <th v-for="h in headers" :key="h.label" class="px-3 py-2.5 font-medium">
                            <span class="inline-flex items-center gap-1.5"><component :is="h.icon" class="size-4" /> {{ h.label }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in users" :key="u.email" class="border-b border-line last:border-0 hover:bg-surface2">
                        <td class="px-3 py-2"><input type="checkbox" class="rounded border-line accent-chili" :aria-label="`Select ${u.name}`" /></td>
                        <td class="px-3 py-2">
                            <div class="flex items-center gap-2.5">
                                <img :src="`https://i.pravatar.cc/64?img=${u.img}`" :alt="u.name" class="size-6 rounded-full object-cover" />
                                <span class="font-medium">{{ u.name }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-2">
                            <a href="#" class="text-link underline decoration-line underline-offset-2 hover:decoration-current">{{ u.email }}</a>
                        </td>
                        <td class="px-3 py-2 text-muted">{{ u.role }}</td>
                        <td class="px-3 py-2">
                            <Badge :color="u.active ? 'var(--chili)' : 'var(--vermilion)'">{{ u.active ? 'Active' : 'Inactive' }}</Badge>
                        </td>
                        <td class="num whitespace-nowrap px-3 py-2 text-muted">{{ u.joined }}</td>
                        <td class="px-3 py-2">
                            <Badge :color="u.twoFa ? 'var(--scarlet)' : 'var(--rose)'">{{ u.twoFa ? 'Enabled' : 'Disabled' }}</Badge>
                        </td>
                        <td class="px-3 py-2">
                            <div class="flex items-center gap-1.5">
                                <button class="btn btn-outline !h-7 !gap-1.5 !px-2.5 !py-0 !text-xs"><Pencil class="size-3.5" /> Edit</button>
                                <button class="btn btn-outline !h-7 !gap-1.5 !px-2.5 !py-0 !text-xs hover:!border-rose hover:!text-rose"><Trash2 class="size-3.5" /> Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- footer -->
        <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-sm text-muted">
            <div class="flex items-center gap-3">
                <span>Rows per page</span>
                <select class="field !h-8 !w-auto !py-0 !px-2"><option>15</option><option>25</option><option>50</option></select>
                <span class="num">1-15 of 380 rows</span>
            </div>
            <nav class="flex items-center gap-1" aria-label="Pagination">
                <button class="flex size-8 items-center justify-center rounded-md hover:bg-surface2" aria-label="First page"><ChevronsLeft class="size-4" /></button>
                <button class="flex size-8 items-center justify-center rounded-md hover:bg-surface2" aria-label="Previous page"><ChevronLeft class="size-4" /></button>
                <button class="num h-8 min-w-8 rounded-md px-2 hover:bg-surface2">1</button>
                <button class="num h-8 min-w-8 rounded-md bg-accentsoft px-2 font-semibold text-link" aria-current="page">2</button>
                <button class="num h-8 min-w-8 rounded-md px-2 hover:bg-surface2">3</button>
                <button class="num h-8 min-w-8 rounded-md px-2 hover:bg-surface2">4</button>
                <button class="num h-8 min-w-8 rounded-md px-2 hover:bg-surface2">5</button>
                <button class="flex size-8 items-center justify-center rounded-md hover:bg-surface2" aria-label="Next page"><ChevronRight class="size-4" /></button>
                <button class="flex size-8 items-center justify-center rounded-md hover:bg-surface2" aria-label="Last page"><ChevronsRight class="size-4" /></button>
            </nav>
        </div>

        <!-- toast (static)
        <div class="fixed right-4 top-4 z-50 w-[360px] max-w-[calc(100vw-2rem)] rounded-xl bg-chili p-4 text-white" style="box-shadow: var(--shadow)" role="status">
            <div class="flex items-start gap-2.5">
                <CheckCircle2 class="mt-0.5 size-4 shrink-0" />
                <div class="flex-1">
                    <p class="text-sm font-semibold">"Alexander Wright" details updated</p>
                    <p class="mt-0.5 text-xs opacity-90">Details have been successfully updated.</p>
                    <div class="mt-2 flex gap-3 text-xs font-semibold">
                        <button class="hover:underline">Undo</button>
                        <button class="hover:underline">View profile</button>
                    </div>
                </div>
                <button class="opacity-80 hover:opacity-100" aria-label="Dismiss"><X class="size-4" /></button>
            </div>
        </div>-->


    </div>

</template>
