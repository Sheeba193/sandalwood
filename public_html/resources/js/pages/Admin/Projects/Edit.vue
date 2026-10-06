<template>
    <Head :title="`Edit Project: ${project.title}`" />
    <AdminLayout>
        <div class="p-6 max-w-7xl mx-auto space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Edit Project</h1>
                    <p class="text-sm text-gray-500 mt-1">Update presentation blocks, media assets, and project details</p>
                </div>
                <div class="flex gap-3">
                    <button
                        type="button"
                        @click="cancel"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition"
                    >
                        Back
                    </button>
                    <button
                        type="submit"
                        form="edit-project-form"
                        :disabled="processing"
                        class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition disabled:opacity-50 flex items-center gap-2"
                    >
                        <svg v-if="processing" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ processing ? 'Saving...' : 'Save Changes' }}
                    </button>
                </div>
            </div>

            <form id="edit-project-form" @submit.prevent="updateProject" class="space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-base font-semibold text-gray-900">Basic Details</h2>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tagline (Pre-header)</label>
                            <input v-model="form.tagline" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" placeholder="e.g. WELCOME TO SANDALWOOD KITISURU" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Project Title *</label>
                            <input v-model="form.title" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                            <input v-model="form.location" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Badge *</label>
                            <select v-model="form.status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                                <option value="planned">Planned</option>
                                <option value="sold_out">SOLD OUT</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Specifications</label>
                            <input v-model="form.specifications" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" placeholder="e.g. 5 BEDROOM VILLAS" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Map/Location URL</label>
                            <input v-model="form.location_url" type="url" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" placeholder="https://maps.google.com/..." />
                        </div>
                    </div>
                </div>

                <!-- Project Amenities -->
                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-base font-semibold text-gray-900">Project Amenities</h2>
                        <p class="mt-1 text-sm text-gray-500">Select every amenity available at this project.</p>
                    </div>
                    <div v-if="amenities.length" class="grid grid-cols-2 gap-4 p-6 md:grid-cols-3 lg:grid-cols-4">
                        <label v-for="amenity in amenities" :key="amenity.id" class="cursor-pointer">
                            <input v-model="form.amenity_ids" type="checkbox" :value="amenity.id" class="peer sr-only" />
                            <div class="h-full overflow-hidden rounded-lg border-2 border-gray-200 transition peer-checked:border-emerald-600 hover:border-gray-400">
                                <div class="flex h-28 items-center justify-center bg-gray-50 p-4">
                                    <img v-if="amenity.image" :src="getImageUrl(amenity.image)" :alt="amenity.name" class="h-full w-full object-contain" />
                                    <span v-else class="text-xs text-gray-400">No image</span>
                                </div>
                                <div class="p-3 text-sm font-medium text-gray-700">{{ amenity.name }}</div>
                            </div>
                        </label>
                    </div>
                    <p v-else class="p-6 text-sm text-gray-500">No amenities have been created yet.</p>
                </div>

                <!-- Featured / Banner Image -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-base font-semibold text-gray-900">Featured / Hero Image</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div v-if="project.featured_image_url" class="mb-3">
                            <p class="text-xs font-medium text-gray-500 mb-2">Current Image:</p>
                            <img :src="project.featured_image_url" class="h-40 w-auto object-cover rounded-lg border border-gray-200" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Featured Image</label>
                            <input type="file" accept="image/*" @change="e => handleFileSelect(e, 'featured_image')" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                        </div>
                    </div>
                </div>

                <!-- Main Overview Description -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-base font-semibold text-gray-900">Main Overview Paragraph</h2>
                    </div>
                    <div class="p-6">
                        <textarea v-model="form.description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" placeholder="Introductory project text..."></textarea>
                    </div>
                </div>

                <!-- Section 1: Ideal Setting -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-base font-semibold text-gray-900">Section 1: The Ideal Setting</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section Title</label>
                            <input v-model="form.setting_title" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" placeholder="e.g. THE IDEAL SETTING" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section Description</label>
                            <textarea v-model="form.setting_description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                        </div>
                        <div>
                            <div v-if="project.setting_image_url" class="mb-3">
                                <p class="text-xs font-medium text-gray-500 mb-2">Current Section Image:</p>
                                <img :src="project.setting_image_url" class="h-32 w-auto object-cover rounded-lg border border-gray-200" />
                            </div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Section 1 Image</label>
                            <input type="file" accept="image/*" @change="e => handleFileSelect(e, 'setting_image')" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                        </div>
                    </div>
                </div>

                <!-- Section 2: Tranquil Retreat -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-base font-semibold text-gray-900">Section 2: Tranquil Retreat</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section Title</label>
                            <input v-model="form.retreat_title" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500" placeholder="e.g. A TRANQUIL RETREAT" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section Description</label>
                            <textarea v-model="form.retreat_description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                        </div>
                        <div>
                            <div v-if="project.retreat_image_url" class="mb-3">
                                <p class="text-xs font-medium text-gray-500 mb-2">Current Section Image:</p>
                                <img :src="project.retreat_image_url" class="h-32 w-auto object-cover rounded-lg border border-gray-200" />
                            </div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Section 2 Image</label>
                            <input type="file" accept="image/*" @change="e => handleFileSelect(e, 'retreat_image')" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                        </div>
                    </div>
                </div>

                <!-- Gallery Images -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-base font-semibold text-gray-900">Gallery Assets</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div v-if="project.gallery?.length" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div v-for="item in project.gallery" :key="item.id" class="relative group">
                                <img :src="item.url" class="w-full h-32 object-cover rounded-lg border border-gray-200" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Add at least seven Gallery Images for the project slideshow</label>
                            <input type="file" accept="image/*" multiple @change="handleGallerySelect" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" />
                        </div>
                    </div>
                </div>

                <!-- Submit Action Footer -->
                <div class="flex justify-end gap-3 pt-4">
                    <button
                        type="button"
                        @click="cancel"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="processing"
                        class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md text-sm font-medium transition disabled:opacity-50 flex items-center gap-2"
                    >
                        <svg v-if="processing" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ processing ? 'Saving...' : 'Save Changes' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';

interface GalleryItem {
    id: number;
    url: string;
}

interface AmenityItem {
    id: number;
    name: string;
    image: string | null;
}

interface ProjectProps {
    id: number;
    title: string;
    subtitle?: string;
    tagline?: string;
    location: string;
    specifications?: string;
    location_url?: string;
    amenity_ids?: number[];
    status: string;
    is_featured: number;
    description: string;
    setting_title?: string;
    setting_description?: string;
    retreat_title?: string;
    retreat_description?: string;
    featured_image_url?: string;
    setting_image_url?: string;
    retreat_image_url?: string;
    gallery?: GalleryItem[];
}

const props = defineProps<{
    project: ProjectProps;
    amenities: AmenityItem[];
}>();

const processing = ref(false);

const form = reactive({
    title: props.project.title || '',
    subtitle: props.project.subtitle || '',
    tagline: props.project.tagline || '',
    location: props.project.location || '',
    specifications:
        props.project.specifications ||
        (props.project.title === 'Sandalwood Loresho'
            ? '3 & 4 BEDROOM APARTMENTS'
            : props.project.title === 'Sandalwood Kitisuru'
              ? '5 BEDROOM VILLAS'
              : props.project.title === 'Sandalwood Othaya'
                ? '3 BEDROOM APARTMENTS'
                : props.project.title === 'Sandalwood Waterfront'
                  ? '5 BEDROOM APARTMENTS'
                  : ''),
    location_url: props.project.location_url || '',
    amenity_ids: props.project.amenity_ids || [],
    status: props.project.status || 'ongoing',
    is_featured: props.project.is_featured || 0,
    description: props.project.description || '',
    setting_title: props.project.setting_title || 'THE IDEAL SETTING',
    setting_description: props.project.setting_description || '',
    retreat_title: props.project.retreat_title || 'A TRANQUIL RETREAT',
    retreat_description: props.project.retreat_description || '',
    featured_image: null as File | null,
    setting_image: null as File | null,
    retreat_image: null as File | null,
    gallery: [] as File[],
});

const getImageUrl = (image: string | null) => {
    if (!image) return '';
    if (image.startsWith('http://') || image.startsWith('https://') || image.startsWith('/')) return image;
    return `/storage/${image}`;
};

const handleFileSelect = (event: Event, field: 'featured_image' | 'setting_image' | 'retreat_image') => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form[field] = target.files[0];
    }
};

const handleGallerySelect = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files) {
        form.gallery = Array.from(target.files);
    }
};

const updateProject = () => {
    processing.value = true;

    router.post(`/admin/projects/${props.project.id}`, {
        _method: 'put',
        ...form,
    }, {
        forceFormData: true,
        onFinish: () => {
            processing.value = false;
        },
    });
};

const cancel = () => {
    router.get('/admin/projects');
};
</script>
