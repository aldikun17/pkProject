<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Pagination from "@/Components/Pagination.vue";
import {
    Search,
    ChevronDown,
    UserCircle2,
    Plus,
    Pencil,
    Trash2,
} from "lucide-vue-next"; //icons to sir
import { useToastr } from "@/Notification/toastr.js";

const toastr = useToastr();

const props = defineProps({
    categories: {
        type: Array,
    },
    event_categories: {
        type: [Array],
        default: () => ({ data: [] }),
    },
});


defineOptions({
    layout: AuthenticatedLayout,
});

const isModalOpen = ref(false); //set to false so its not gonna show the modal
const editingCategory = ref(null); // if null = create, if category exist = edit, as of now we dont have data yet

//forms input
const form = useForm({
    category_name: "",
    category_description: "",
});

// open create modal
const openCreateModal = () => {
    editingCategory.value = null; // means u are creating
    form.reset(); //reset the form
    form.clearErrors(); //clear the errors
    isModalOpen.value = true; //opens the modal
};

//open edit modal
const openEditModal = (category) => {
    editingCategory.value = category; // now we put an existing category, so can edit it
    form.clearErrors();
    form.category_name = category.category_name || "";
    form.category_description = category.category_description || "";
    isModalOpen.value = true;
};

//close modal
const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

//delete
const deleteCategory = (id) => {
    if (confirm("Do you really want to delete this category?")) {
        form.delete(route("event_category.delete", id), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    }
    toastr.success("Category Deleted Successfully");
};

const submitForm = () => {
    if (editingCategory.value) {
        form.put(route("event_category.update", editingCategory.value.id), {
            onSuccess: () => closeModal(),
        });

        toastr.success("Category Updated Successfully");
    } else {
        form.post(route("event_category.store"), {
            onSuccess: () => closeModal(),
        });
        toastr.success("Category Created Successfully");
    }
};
</script>

<template>
    <div class="min-h-screen bg-bg text-slate-900">
        <div
            class="mt-6 flex flex-wrap items-center justify-between gap-3 border-b border-line pb-3 text-sm"
        >
            <div class="flex"></div>
            <div class="flex flex-wrap items-center gap-1">
                <button
                    class="flex h-8 items-center gap-1.5 rounded-md px-2.5 text-muted hover:bg-surface2 hover:text-fg"
                >
                    <Search class="size-4" /> Search
                </button>
                <button
                    class="btn btn-outline !h-8 !py-0 !px-3 !font-medium px-2.5 py-1.5 font-medium text-link"
                >
                    Export
                </button>

                <button
                    class="btn btn-primary !h-8 !py-0 !px-3 px-2.5 py-1.5 font-medium text-link"
                >
                    Add User <ChevronDown class="size-4" />
                </button>

                <button
                    @click="openCreateModal"
                    class="btn btn-primary !h-8 !py-0 !px-3 px-2.5 py-1.5 font-medium text-link"
                >
                    Add Category <ChevronDown class="size-4" />
                </button>
            </div>
        </div>

        <!-- filters -->
        <div class="mt-3 flex flex-wrap items-center gap-2 text-sm">
            <button
                class="flex h-8 items-center gap-1.5 rounded-full border border-line bg-surface px-3 hover:border-cinnabar hover:bg-surface2 px-2.5 py-1.5 font-medium text-link"
            >
                <UserCircle2 class="size-4 text-chili" /> Role:
                <span class="font-medium text-link">All</span>
                <ChevronDown class="size-3.5 text-muted" />
            </button>
            <button class="flex items-center gap-1 text-muted hover:text-fg">
                <Plus class="size-4" /> Add filter
            </button>
        </div>

        <!-- table -->
        <div
            class="mt-4 overflow-x-auto rounded-xl border border-line bg-surface"
            style="box-shadow: var(--shadow)"
        >
            <table class="w-full min-w-[960px] text-sm">
                <thead class="bg-surface2 text-left text-muted">
                    <tr class="border-b border-line">
                        <th class="w-10 px-3 py-2.5">Category Name</th>
                        <th class="w-10 px-3 py-2.5">Description</th>
                        <th class="w-10 px-3 py-2.5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="c in event_categories.data"
                        :key="c.id"
                        class="border-b border-line last:border-0 hover:bg-surface2"
                    >
                        <td class="px-3 py-2">
                            {{ c.category_name }}
                        </td>

                        <td class="px-3 py-2">
                            {{ c.category_description }}
                        </td>

                        <td class="px-3 py-2">
                            <div class="flex items-center gap-1.5">
                                <button
                                    @click="openEditModal(c)"
                                    class="btn btn-outline !h-7 !gap-1.5 !px-2.5 !py-0 !text-xs"
                                >
                                    <Pencil class="size-3.5" />
                                </button>

                                <button
                                    @click="deleteCategory(c.id)"
                                    class="btn btn-outline !h-7 !gap-1.5 !px-2.5 !py-0 !text-xs hover:!border-rose hover:!text-rose"
                                >
                                    <Trash2 class="size-3.5" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Single Modal Component for both Create and Edit -->
        <Modal :show="isModalOpen" @close="closeModal">
            <form @submit.prevent="submitForm" class="p-6">
                <!-- Modal Title changes dynamically -->
                <h2 class="text-lg font-medium text-gray-900">
                    {{ editingCategory ? "Edit Category" : "Create Category" }}
                </h2>

                <div>
                    <InputLabel for="category_name" value="Category" />

                    <TextInput
                        id="category_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.category_name"
                        required
                        autofocus
                        autocomplete="category_name"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.category_name"
                    />
                </div>

                <div>
                    <InputLabel
                        for="category_description"
                        value="Description"
                    />

                    <TextInput
                        id="category_description"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.category_description"
                        required
                        autofocus
                        autocomplete="category_description"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.category_description"
                    />
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex justify-end gap-3">
                    <button
                        type="button"
                        @click="closeModal"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-medium"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 disabled:opacity-50"
                    >
                        {{
                            editingCategory ? "Edit Category" : "Save Category"
                        }}
                    </button>
                </div>
            </form>
        </Modal>

        <!-- footer -->
        <div
            class="mt-4 flex flex-wrap items-center justify-between gap-3 text-sm text-muted"
        >
            <div class="flex items-center gap-3">
                <span>Rows per page</span>
                <select class="field !h-8 !w-auto !py-0 !px-2">
                    <option>15</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                <span class="num">1-15 of 380 rows</span>
            </div>

            <!-- Pagination -->
            <Pagination class="mt-4" :links="event_categories.links" />
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
