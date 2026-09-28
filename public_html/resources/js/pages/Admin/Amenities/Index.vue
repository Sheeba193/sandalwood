<script setup lang="ts">
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2, Image as ImageIcon, X, Upload } from 'lucide-vue-next';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { route } from 'ziggy-js';
interface Amenity {
    id: number;
    name: string;
    image: string;
    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    amenities: Amenity[];
}>();

/*
|--------------------------------------------------------------------------
| Modal
|--------------------------------------------------------------------------
*/

const showModal = ref(false);

const editingAmenity = ref<Amenity | null>(null);

/*
|--------------------------------------------------------------------------
| Image preview
|--------------------------------------------------------------------------
*/

const imagePreview = ref<string | null>(null);

/*
|--------------------------------------------------------------------------
| Form
|--------------------------------------------------------------------------
*/

const form = useForm<{
    name: string;
    image: File | null;
}>({
    name: '',
    image: null,
});

/*
|--------------------------------------------------------------------------
| Open create modal
|--------------------------------------------------------------------------
*/

const openCreateModal = () => {
    editingAmenity.value = null;

    form.reset();
    form.clearErrors();

    imagePreview.value = null;

    showModal.value = true;
};

/*
|--------------------------------------------------------------------------
| Open edit modal
|--------------------------------------------------------------------------
*/

const openEditModal = (amenity: Amenity) => {
    editingAmenity.value = amenity;

    form.name = amenity.name;
    form.image = null;

    form.clearErrors();

    imagePreview.value = amenity.image ? `/storage/${amenity.image}` : null;

    showModal.value = true;
};

/*
|--------------------------------------------------------------------------
| Close modal
|--------------------------------------------------------------------------
*/

const closeModal = () => {
    if (form.processing) {
        return;
    }

    showModal.value = false;

    editingAmenity.value = null;

    form.reset();
    form.clearErrors();

    imagePreview.value = null;
};

/*
|--------------------------------------------------------------------------
| Image selection
|--------------------------------------------------------------------------
*/

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;

    const file = target.files?.[0];

    if (!file) {
        return;
    }

    form.image = file;

    imagePreview.value = URL.createObjectURL(file);
};

/*
|--------------------------------------------------------------------------
| Submit
|--------------------------------------------------------------------------
*/

const submit = () => {
    if (editingAmenity.value) {
        form.post(`/admin/amenities/${editingAmenity.value.id}/update`, {
            forceFormData: true,

            onSuccess: () => {
                closeModal();
            },
        });

        return;
    }

    form.post('/admin/amenities/store', {
        forceFormData: true,

        onSuccess: () => {
            closeModal();
        },
    });
};

/*
|--------------------------------------------------------------------------
| Delete
|--------------------------------------------------------------------------
*/

const deleteAmenity = (amenity: Amenity) => {
    if (!confirm(`Are you sure you want to delete "${amenity.name}"?`)) {
        return;
    }

    router.delete(`/admin/amenities/${amenity.id}/destroy`);
};

/*
|--------------------------------------------------------------------------
| Image URL
|--------------------------------------------------------------------------
*/

const getImageUrl = (image: string) => {
    if (!image) {
        return '';
    }

    if (image.startsWith('http://') || image.startsWith('https://') || image.startsWith('/')) {
        return image;
    }

    return `/storage/${image}`;
};
</script>

<template>
    <Head title="Amenities" />

    <AdminLayout>
        <div class="min-h-screen bg-gray-50 p-6 lg:p-8">
            <!-- Header -->
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="font-cinzel text-2xl tracking-wide text-[#001221]">Amenities</h1>

                    <p class="mt-1 text-sm text-gray-500">Manage the amenities displayed on your website.</p>
                </div>

                <button
                    type="button"
                    @click="openCreateModal"
                    class="inline-flex items-center justify-center gap-2 bg-[#001221] px-5 py-3 text-xs font-medium tracking-[0.15em] text-white uppercase transition hover:bg-[#1a365d]"
                >
                    <Plus class="h-4 w-4" />

                    Add Amenity
                </button>
            </div>

            <!-- Empty State -->
            <div
                v-if="props.amenities.length === 0"
                class="flex min-h-[350px] flex-col items-center justify-center border border-dashed border-gray-300 bg-white"
            >
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                    <ImageIcon class="h-6 w-6 text-gray-400" />
                </div>

                <h3 class="font-cinzel text-lg text-[#001221]">No Amenities</h3>

                <p class="mt-2 text-sm text-gray-500">Add your first amenity to get started.</p>

                <button
                    type="button"
                    @click="openCreateModal"
                    class="mt-5 inline-flex items-center gap-2 bg-[#001221] px-5 py-3 text-xs font-medium tracking-[0.15em] text-white uppercase"
                >
                    <Plus class="h-4 w-4" />

                    Add Amenity
                </button>
            </div>

            <!-- Amenities Grid -->
            <div v-else class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <div
                    v-for="amenity in props.amenities"
                    :key="amenity.id"
                    class="group overflow-hidden border border-gray-200 bg-white transition hover:-translate-y-1 hover:shadow-lg"
                >
                    <!-- Image -->
                    <div class="flex h-48 items-center justify-center bg-white p-8">
                        <img
                            v-if="amenity.image"
                            :src="getImageUrl(amenity.image)"
                            :alt="amenity.name"
                            class="h-full w-full object-contain transition duration-500 group-hover:scale-105"
                        />

                        <ImageIcon v-else class="h-12 w-12 text-gray-300" />
                    </div>

                    <!-- Details -->
                    <div class="border-t border-gray-100 px-5 py-4">
                        <h3 class="font-montserrat text-sm font-medium tracking-[0.12em] text-[#001221] uppercase">
                            {{ amenity.name }}
                        </h3>

                        <!-- Actions -->
                        <div class="mt-4 flex items-center gap-2">
                            <button
                                type="button"
                                @click="openEditModal(amenity)"
                                class="inline-flex flex-1 items-center justify-center gap-2 border border-gray-200 px-3 py-2 text-xs tracking-wider text-gray-600 uppercase transition hover:border-[#001221] hover:text-[#001221]"
                            >
                                <Pencil class="h-3.5 w-3.5" />

                                Edit
                            </button>

                            <button
                                type="button"
                                @click="deleteAmenity(amenity)"
                                class="inline-flex items-center justify-center border border-red-100 px-3 py-2 text-red-500 transition hover:border-red-200 hover:bg-red-50"
                            >
                                <Trash2 class="h-3.5 w-3.5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create / Edit Modal -->
            <Teleport to="body">
                <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click.self="closeModal">
                    <div class="w-full max-w-lg overflow-hidden bg-white shadow-2xl">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">
                            <div>
                                <h2 class="font-cinzel text-lg tracking-wide text-[#001221]">
                                    {{ editingAmenity ? 'Edit Amenity' : 'Create Amenity' }}
                                </h2>

                                <p class="mt-1 text-xs text-gray-500">
                                    {{ editingAmenity ? 'Update the amenity details.' : 'Add a new property amenity.' }}
                                </p>
                            </div>

                            <button type="button" @click="closeModal" class="text-gray-400 transition hover:text-gray-700">
                                <X class="h-5 w-5" />
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form @submit.prevent="submit" class="space-y-6 p-6">
                            <!-- Name -->
                            <div>
                                <label class="mb-2 block text-xs font-medium tracking-[0.12em] text-gray-600 uppercase"> Amenity Name </label>

                                <input
                                    v-model="form.name"
                                    type="text"
                                    placeholder="e.g. Ample Parking Spaces"
                                    class="w-full border border-gray-200 px-4 py-3 text-sm transition outline-none focus:border-[#001221]"
                                />

                                <p v-if="form.errors.name" class="mt-1 text-xs text-red-500">
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <!-- Image -->
                            <div>
                                <label class="mb-2 block text-xs font-medium tracking-[0.12em] text-gray-600 uppercase"> Amenity Image </label>

                                <label
                                    class="relative flex min-h-[200px] cursor-pointer flex-col items-center justify-center overflow-hidden border border-dashed border-gray-300 bg-gray-50 transition hover:border-[#001221]"
                                >
                                    <!-- Preview -->
                                    <img
                                        v-if="imagePreview"
                                        :src="imagePreview"
                                        :alt="form.name || 'Amenity preview'"
                                        class="h-44 w-full object-contain p-5"
                                    />

                                    <!-- Upload -->
                                    <div v-else class="flex flex-col items-center justify-center text-center">
                                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-sm">
                                            <Upload class="h-5 w-5 text-gray-500" />
                                        </div>

                                        <p class="text-sm font-medium text-gray-600">Upload amenity image</p>

                                        <p class="mt-1 text-xs text-gray-400">PNG, JPG, WEBP or SVG</p>
                                    </div>

                                    <input
                                        type="file"
                                        accept="image/png,image/jpeg,image/webp,image/svg+xml"
                                        class="hidden"
                                        @change="handleImageChange"
                                    />
                                </label>

                                <p v-if="form.errors.image" class="mt-1 text-xs text-red-500">
                                    {{ form.errors.image }}
                                </p>

                                <p v-if="editingAmenity" class="mt-2 text-[11px] text-gray-400">
                                    Leave the image unchanged if you do not want to replace it.
                                </p>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end gap-3 border-t border-gray-100 pt-5">
                                <button
                                    type="button"
                                    @click="closeModal"
                                    class="border border-gray-200 px-5 py-3 text-xs font-medium tracking-[0.12em] text-gray-600 uppercase transition hover:bg-gray-50"
                                >
                                    Cancel
                                </button>

                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center gap-2 bg-[#001221] px-6 py-3 text-xs font-medium tracking-[0.12em] text-white uppercase transition hover:bg-[#1a365d] disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    <span v-if="form.processing"> Saving... </span>

                                    <span v-else>
                                        {{ editingAmenity ? 'Update Amenity' : 'Create Amenity' }}
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </Teleport>
        </div>
    </AdminLayout>
</template>
