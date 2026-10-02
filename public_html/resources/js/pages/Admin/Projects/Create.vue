<template>
    <Head title="Create New Project" />

    <AdminLayout>
        <div class="mx-auto max-w-7xl space-y-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Create Project</h1>
                    <p class="mt-1 text-sm text-gray-500">Add a new project presentation layout</p>
                </div>

                <div class="flex gap-3">
                    <button
                        type="button"
                        @click="cancel"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        form="create-project-form"
                        :disabled="form.processing"
                        class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-medium text-white transition hover:bg-emerald-700 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Creating...' : 'Create Project' }}
                    </button>
                </div>
            </div>

            <form id="create-project-form" @submit.prevent="submit" class="space-y-6">
                <!-- ===================================== -->
                <!-- BASIC INFORMATION -->
                <!-- ===================================== -->

                <div class="space-y-6 rounded-lg border border-gray-200 bg-white p-6">
                    <h2 class="border-b pb-3 text-lg font-medium text-gray-900">Basic Information</h2>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Project Title -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700"> Project Title * </label>

                            <input
                                v-model="form.title"
                                type="text"
                                class="w-full rounded-md border px-3 py-2"
                                placeholder="e.g. SANDALWOOD KITISURU"
                                required
                            />

                            <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">
                                {{ form.errors.title }}
                            </p>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700"> Location * </label>

                            <input
                                v-model="form.location"
                                type="text"
                                class="w-full rounded-md border px-3 py-2"
                                placeholder="e.g. Kitisuru, Nairobi"
                                required
                            />
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700"> Status * </label>

                            <select v-model="form.status" class="w-full rounded-md border px-3 py-2 text-gray-700">
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                                <option value="planned">Planned</option>
                                <option value="sold_out">SOLD OUT</option>
                            </select>
                        </div>

                        <!-- Specifications -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700"> Specifications </label>

                            <input
                                v-model="form.specifications"
                                type="text"
                                class="w-full rounded-md border px-3 py-2"
                                placeholder="e.g. 5 BEDROOM VILLAS"
                            />
                        </div>

                        <!-- Map URL -->
                        <div class="md:col-span-2">
                            <label class="mb-1 block text-sm font-medium text-gray-700"> Map / Location URL </label>

                            <input
                                v-model="form.location_url"
                                type="url"
                                class="w-full rounded-md border px-3 py-2"
                                placeholder="https://maps.google.com/..."
                            />
                        </div>
                    </div>
                </div>

                <!-- ===================================== -->
                <!-- COVER IMAGE -->
                <!-- ===================================== -->

                <div class="space-y-5 rounded-lg border border-gray-200 bg-white p-6">
                    <div class="border-b pb-3">
                        <h2 class="text-lg font-medium text-gray-900">Cover / Banner Image</h2>

                        <p class="mt-1 text-sm text-gray-500">This image will be displayed as the main project cover.</p>
                    </div>

                    <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-2">
                        <!-- Upload -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700"> Cover Image * </label>

                            <input
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                @change="(e) => handleFileSelect(e, 'cover_image')"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-emerald-700 hover:file:bg-emerald-100"
                            />

                            <p class="mt-2 text-xs text-gray-400">
                                JPG, PNG or WebP · Recommended:
                                <strong>1920 × 600 px</strong> · Max size: 5 MB
                            </p>

                            <p v-if="form.errors.cover_image" class="mt-2 text-sm text-red-600">
                                {{ form.errors.cover_image }}
                            </p>
                        </div>

                        <!-- Preview -->
                        <div v-if="coverPreview">
                            <label class="mb-2 block text-sm font-medium text-gray-700"> Preview </label>

                            <div class="overflow-hidden rounded-lg border border-gray-200">
                                <img :src="coverPreview" alt="Cover preview" class="aspect-[16/5] w-full object-cover" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================================== -->
                <!-- MAIN OVERVIEW -->
                <!-- ===================================== -->

                <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-6">
                    <h2 class="border-b pb-3 text-lg font-medium text-gray-900">Main Overview</h2>

                    <textarea
                        v-model="form.description"
                        rows="5"
                        class="w-full rounded-md border border-b-gray-900 px-3 py-2 text-gray-900"
                        placeholder="Detailed project introduction..."
                    ></textarea>
                </div>

                <!-- ===================================== -->
                <!-- AMENITIES -->
                <!-- ===================================== -->

                <div class="space-y-5 rounded-lg border border-gray-200 bg-white p-6">
                    <div class="border-b pb-3">
                        <h2 class="text-lg font-medium text-gray-900">Project Amenities</h2>

                        <p class="mt-1 text-sm text-gray-500">Select the amenities available at this project.</p>
                    </div>

                    <div v-if="props.amenities.length" class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                        <label v-for="amenity in props.amenities" :key="amenity.id" class="relative cursor-pointer">
                            <input v-model="form.amenity_ids" type="checkbox" :value="amenity.id" class="peer sr-only" />

                            <div
                                class="overflow-hidden rounded-lg border-2 border-gray-200 bg-white transition peer-checked:border-emerald-600 peer-checked:ring-2 peer-checked:ring-emerald-100 hover:border-gray-400"
                            >
                                <!-- Image -->
                                <div class="flex h-32 items-center justify-center bg-gray-50 p-5">
                                    <img
                                        v-if="amenity.image"
                                        :src="getImageUrl(amenity.image)"
                                        :alt="amenity.name"
                                        class="h-full w-full object-contain"
                                    />

                                    <span v-else class="text-xs text-gray-400"> No image </span>
                                </div>

                                <!-- Name -->
                                <div class="flex items-center gap-3 p-3">
                                    <div
                                        class="flex h-5 w-5 shrink-0 items-center justify-center rounded border border-gray-300 peer-checked:border-emerald-600 peer-checked:bg-emerald-600"
                                    >
                                        <svg class="h-3 w-3 text-white opacity-0 peer-checked:opacity-100" viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                fill-rule="evenodd"
                                                d="M16.704 5.29a1 1 0 010 1.42l-7.25 7.25a1 1 0 01-1.415 0l-3.25-3.25a1 1 0 111.415-1.42L8.75 11.84l6.543-6.55a1 1 0 011.411 0z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </div>

                                    <span class="text-sm font-medium text-gray-700">
                                        {{ amenity.name }}
                                    </span>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div v-else class="rounded-lg border border-dashed border-gray-300 p-8 text-center">
                        <p class="text-sm text-gray-500">No amenities have been created yet.</p>
                    </div>

                    <!-- Validation -->
                    <p v-if="form.errors.amenity_ids" class="text-sm text-red-600">
                        {{ form.errors.amenity_ids }}
                    </p>
                </div>
                <!-- ===================================== -->
                <!-- IDEAL SETTING -->
                <!-- ===================================== -->

                <div class="space-y-5 rounded-lg border border-gray-200 bg-white p-6">
                    <div class="border-b pb-3">
                        <h2 class="text-lg font-medium text-gray-900">The Ideal Setting</h2>

                        <p class="mt-1 text-sm text-gray-500">Describe the location, environment and lifestyle of the project.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Description -->
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700"> Section Title </label>

                                <input
                                    v-model="form.ideal_title"
                                    type="text"
                                    class="w-full rounded-md border px-3 py-2"
                                    placeholder="THE IDEAL SETTING"
                                />
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700"> Description </label>

                                <textarea
                                    v-model="form.ideal_description"
                                    rows="7"
                                    class="w-full rounded-md border border-b-gray-900 px-3 py-2 text-gray-900"
                                    placeholder="Describe the ideal setting..."
                                ></textarea>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700"> Ideal Setting Image </label>

                            <input
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                @change="(e) => handleFileSelect(e, 'ideal_image')"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-emerald-700 hover:file:bg-emerald-100"
                            />

                            <p class="text-xs text-gray-400">JPG, PNG or WebP · Max size: 5 MB</p>

                            <div v-if="idealPreview" class="overflow-hidden rounded-lg border border-gray-200">
                                <img :src="idealPreview" alt="Ideal setting preview" class="h-72 w-full object-cover" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================================== -->
                <!-- TRANQUIL RETREAT -->
                <!-- ===================================== -->

                <div class="space-y-5 rounded-lg border border-gray-200 bg-white p-6">
                    <div class="border-b pb-3">
                        <h2 class="text-lg font-medium text-gray-900">A Tranquil Retreat</h2>

                        <p class="mt-1 text-sm text-gray-500">Describe the peaceful, private and lifestyle aspects of the project.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Image -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700"> Tranquil Retreat Image </label>

                            <input
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                @change="(e) => handleFileSelect(e, 'tranquil_image')"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-emerald-700 hover:file:bg-emerald-100"
                            />

                            <p class="text-xs text-gray-400">JPG, PNG or WebP · Max size: 5 MB</p>

                            <div v-if="tranquilPreview" class="overflow-hidden rounded-lg border border-gray-200">
                                <img :src="tranquilPreview" alt="Tranquil retreat preview" class="h-72 w-full object-cover" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700"> Section Title </label>

                                <input
                                    v-model="form.tranquil_title"
                                    type="text"
                                    class="w-full rounded-md border px-3 py-2"
                                    placeholder="A TRANQUIL RETREAT"
                                />
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700"> Description </label>

                                <textarea
                                    v-model="form.tranquil_description"
                                    rows="7"
                                    class="w-full rounded-md border px-3 py-2"
                                    placeholder="Describe the tranquil retreat..."
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================================== -->
                <!-- GALLERY -->
                <!-- ===================================== -->

                <div class="space-y-5 rounded-lg border border-gray-200 bg-white p-6">
                    <div class="border-b pb-3">
                        <h2 class="text-lg font-medium text-gray-900">Project Gallery</h2>

                        <p class="mt-1 text-sm text-gray-500">Upload at least seven images to fill the project slideshow and gallery.</p>
                    </div>

                    <input
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        multiple
                        @change="handleGallerySelect"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-emerald-700 hover:file:bg-emerald-100"
                    />

                    <p class="text-xs text-gray-400">JPG, PNG or WebP · Multiple images allowed · Max size: 5 MB per image</p>

                    <!-- Gallery Preview -->
                    <div v-if="galleryPreviews.length" class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                        <div
                            v-for="(image, index) in galleryPreviews"
                            :key="index"
                            class="group relative overflow-hidden rounded-lg border border-gray-200"
                        >
                            <img :src="image" alt="Gallery image" class="h-40 w-full object-cover" />

                            <button
                                type="button"
                                @click="removeGalleryImage(index)"
                                class="absolute top-2 right-2 flex h-8 w-8 items-center justify-center rounded-full bg-black/70 text-white opacity-0 transition group-hover:opacity-100"
                            >
                                ×
                            </button>
                        </div>
                    </div>

                    <div v-else class="rounded-lg border-2 border-dashed border-gray-200 p-10 text-center">
                        <p class="text-sm text-gray-400">No gallery images selected yet.</p>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const form = useForm({
    // Basic information
    title: '',
    subtitle: '',
    tagline: '',
    location: '',
    specifications: '',
    location_url: '',
    status: 'ongoing',
    is_featured: 0,

    amenity_ids: [] as number[],
    description: '',

    // Ideal Setting
    ideal_title: 'THE IDEAL SETTING',
    ideal_description: '',
    ideal_image: null as File | null,

    // Tranquil Retreat
    tranquil_title: 'A TRANQUIL RETREAT',
    tranquil_description: '',
    tranquil_image: null as File | null,

    // Cover
    cover_image: null as File | null,

    // Gallery
    gallery: [] as File[],
});

interface Amenity {
    id: number;
    name: string;
    image: string | null;
}

const props = defineProps<{
    amenities: Amenity[];
}>();
/*
|--------------------------------------------------------------------------
| Image Previews
|--------------------------------------------------------------------------
*/

const coverPreview = computed(() => {
    return form.cover_image ? URL.createObjectURL(form.cover_image) : null;
});

const idealPreview = computed(() => {
    return form.ideal_image ? URL.createObjectURL(form.ideal_image) : null;
});

const tranquilPreview = computed(() => {
    return form.tranquil_image ? URL.createObjectURL(form.tranquil_image) : null;
});

const galleryPreviews = computed(() => {
    return form.gallery.map((file) => URL.createObjectURL(file));
});

/*
|--------------------------------------------------------------------------
| Single Image Upload
|--------------------------------------------------------------------------
*/

type SingleImageField = 'cover_image' | 'ideal_image' | 'tranquil_image';

const handleFileSelect = (event: Event, field: SingleImageField) => {
    const target = event.target as HTMLInputElement;

    if (!target.files || !target.files[0]) {
        return;
    }

    const file = target.files[0];

    // 5 MB validation
    if (file.size > 5 * 1024 * 1024) {
        alert('Image must not exceed 5 MB.');

        target.value = '';

        return;
    }

    form[field] = file;
};

const getImageUrl = (image: string | null) => {
    if (!image) {
        return '';
    }

    if (
        image.startsWith('http://') ||
        image.startsWith('https://') ||
        image.startsWith('/')
    ) {
        return image;
    }

    return `/storage/${image}`;
};
/*
|--------------------------------------------------------------------------
| Gallery Upload
|--------------------------------------------------------------------------
*/

const handleGallerySelect = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (!target.files) {
        return;
    }

    const files = Array.from(target.files);

    const validFiles = files.filter((file) => {
        if (file.size > 5 * 1024 * 1024) {
            alert(`${file.name} exceeds the 5 MB limit.`);

            return false;
        }

        return true;
    });

    form.gallery = [...form.gallery, ...validFiles];
};

/*
|--------------------------------------------------------------------------
| Remove Gallery Image
|--------------------------------------------------------------------------
*/

const removeGalleryImage = (index: number) => {
    form.gallery.splice(index, 1);
};

/*
|--------------------------------------------------------------------------
| Submit
|--------------------------------------------------------------------------
*/

const submit = () => {
    form.post('/admin/projects', {
        forceFormData: true,

        onSuccess: () => {
            // Optional redirect handled by Laravel
        },
    });
};

/*
|--------------------------------------------------------------------------
| Cancel
|--------------------------------------------------------------------------
*/

const cancel = () => {
    router.get('/admin/projects');
};
</script>
