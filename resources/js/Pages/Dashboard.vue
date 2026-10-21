<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head , usePage } from '@inertiajs/vue3';
const page = usePage();
const props = defineProps({
    content: {
        type:Object,
        required: true
    }
});
</script>

<template>
    <AuthenticatedLayout :content="$page.props.content">
    <div class="min-h-screen bg-bg py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg border border-line bg-surface shadow-sm">
                <div class="p-6 text-fg">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
