<template>
    <AppLayout>
        <SandalWoodLoader v-if="loading" />

        <main v-else class="min-h-screen bg-white pb-20">
            <section class="w-full">
                <img :src="project.cover_image" :alt="project.title" class="h-[min(62vw,560px)] min-h-[300px] w-full object-cover md:min-h-[400px]" />
            </section>

            <section class="mx-auto max-w-6xl px-6 pt-10 pb-5 md:px-10 md:pt-14">
                <div class="mb-4 flex items-center gap-4">
                    <span class="font-montserrat text-[10px] tracking-[0.16em] text-gray-500 uppercase">Welcome to {{ project.title }}</span>
                    <div class="h-px w-20 bg-gray-300"></div>
                </div>

                <h1 class="font-cinzel mb-2 text-3xl tracking-wide text-[#1a365d] uppercase md:text-4xl">
                    {{ project.title }}
                </h1>

                <p v-if="project.description" class="font-cormorant w-full max-w-none text-justify text-lg leading-relaxed text-gray-600">
                    {{ project.description }}
                </p>
            </section>

            <section class="mx-auto max-w-6xl px-6 py-5 md:px-10 md:py-7">
                <div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:gap-10">
                    <div class="overflow-hidden">
                        <img :src="project.ideal_image" :alt="`${project.title} setting`" class="aspect-[4/3] w-full object-cover" />
                    </div>
                    <div v-if="project.ideal_description" class="space-y-5">
                        <div class="flex items-center gap-3">
                            <span class="font-montserrat text-[10px] tracking-[0.16em] text-gray-500 uppercase">{{ project.ideal_title || 'The Ideal Setting' }}</span>
                            <div class="h-px w-20 bg-gray-300"></div>
                        </div>
                        <p class="font-cormorant text-justify text-lg leading-relaxed text-gray-600">
                            {{ project.ideal_description }}
                        </p>
                    </div>
                </div>
            </section>

            <section class="mx-auto my-6 max-w-5xl px-6 py-9">
                <div v-if="project.specifications || project.location || project.amenities?.length" class="flex flex-wrap justify-center gap-x-12 gap-y-6">
                    <div v-if="project.specifications" class="flex max-w-52 items-center gap-3 text-gray-700">
                        <BedDouble class="h-7 w-7 shrink-0" />
                        <span class="font-cormorant text-base leading-tight">{{ project.specifications }}</span>
                    </div>
                    <a v-if="project.location" :href="project.location_url || undefined" :target="project.location_url ? '_blank' : undefined" :rel="project.location_url ? 'noopener noreferrer' : undefined" class="flex max-w-52 items-center gap-3 text-gray-700" :class="project.location_url ? 'hover:text-[#1a365d]' : ''">
                        <MapPin class="h-7 w-7 shrink-0" />
                        <span class="font-cormorant text-base leading-tight">{{ project.location_url ? 'View Location' : project.location }}</span>
                    </a>
                    <div v-if="project.amenities?.length" class="flex max-w-52 items-center gap-3 text-gray-700">
                        <HouseWifi class="h-7 w-7 shrink-0" />
                        <span class="font-cormorant text-base leading-tight">Exclusive Amenities</span>
                    </div>
                </div>
                <div class="mt-7 flex justify-center">
                    <a href="/contact" class="font-montserrat bg-[#001529] px-8 py-2.5 text-xs font-semibold tracking-wide text-white uppercase transition-colors hover:bg-[#00203a]">Enquire</a>
                </div>
            </section>

            <!-- =========================================================
               GALLERY
          ========================================================== -->
            <section class="mx-auto max-w-6xl px-6 py-7 md:px-10 md:py-10">
                <div class="mb-4 flex items-center gap-4">
                    <span class="font-cinzel text-2xl tracking-wide text-[#1a365d] uppercase">Gallery</span>

                    <div class="h-px w-12 bg-gray-300"></div>
                </div>

                <h2 class="font-cinzel mb-3 text-xl text-[#1a365d] uppercase md:text-2xl">Exquisite Living Spaces Just for You</h2>

                <!-- No gallery -->
                <div v-if="project.gallery.length === 0" class="py-16 text-center">
                    <p class="font-cormorant text-lg text-gray-400">Gallery images coming soon.</p>
                </div>

                <!-- Gallery -->
                <div v-else class="group relative mt-8 overflow-hidden" @mouseenter="pauseGallery" @mouseleave="resumeGallery">
                    <!-- Slides -->
                    <div
                        class="flex transition-transform duration-1000 ease-in-out"
                        :style="{
                            transform: `translateX(-${gallerySlide * 100}%)`,
                        }"
                    >
                        <!-- Each slide contains TWO images -->
                        <div v-for="slide in gallerySlides" :key="slide.index" class="grid min-w-full grid-cols-1 gap-5 md:grid-cols-2 md:gap-8">
                            <!-- First / Second image -->
                            <button
                                v-for="image in slide.images"
                                :key="image.id"
                                type="button"
                                class="group/image relative overflow-hidden rounded-sm bg-gray-100 text-left shadow-md"
                                @click="openLightbox(getOriginalImageIndex(image.id))"
                            >
                                <img
                                    :src="image.url"
                                    :alt="image.name || project.title"
                                    class="aspect-[4/3] w-full object-cover transition-transform duration-1000 group-hover/image:scale-105"
                                />

                                <!-- Image overlay -->
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-500 group-hover/image:bg-black/20"
                                >
                                    <span
                                        class="font-montserrat translate-y-4 text-xs tracking-[0.2em] text-white uppercase opacity-0 transition-all duration-500 group-hover/image:translate-y-0 group-hover/image:opacity-100"
                                    >
                                        View Image
                                    </span>
                                </div>
                            </button>

                            <!-- Empty second slot for odd number of images -->
                            <div v-if="slide.images.length === 1" class="hidden overflow-hidden rounded-sm bg-gray-100 md:block"></div>
                        </div>
                    </div>

                    <!-- Previous button -->
                    <button
                        v-if="gallerySlides.length > 1"
                        type="button"
                        @click="previousGallerySlide"
                        class="absolute top-1/2 left-3 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-gray-700 opacity-100 shadow-md transition-all duration-300 hover:bg-white sm:left-4 md:opacity-0 md:group-hover:opacity-100"
                        aria-label="Previous gallery slide"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Next button -->
                    <button
                        v-if="gallerySlides.length > 1"
                        type="button"
                        @click="nextGallerySlide"
                        class="absolute top-1/2 right-3 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-gray-700 opacity-100 shadow-md transition-all duration-300 hover:bg-white sm:right-4 md:opacity-0 md:group-hover:opacity-100"
                        aria-label="Next gallery slide"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>

                <!-- Gallery indicators -->
                <div v-if="gallerySlides.length > 1" class="mt-10 flex items-center justify-center gap-2">
                    <div class="h-px w-16 bg-gray-300"></div>

                    <div class="flex items-center gap-2">
                        <button
                            v-for="(_, index) in gallerySlides"
                            :key="index"
                            type="button"
                            @click="goToGallerySlide(index)"
                            :class="[
                                'h-2 rounded-full transition-all duration-500',
                                index === gallerySlide ? 'w-6 bg-[#1a365d]' : 'w-2 bg-gray-300 hover:bg-gray-400',
                            ]"
                            :aria-label="`Go to gallery slide ${index + 1}`"
                        ></button>
                    </div>

                    <div class="h-px w-16 bg-gray-300"></div>
                </div>
            </section>

            <section v-if="project.amenities?.length" class="mx-auto max-w-6xl px-6 py-7 md:px-10 md:py-10">
                <div class="mb-4 flex items-center gap-4">
                    <span class="font-montserrat text-xs tracking-[0.2em] text-gray-500 uppercase">Wellness and Leisure</span>
                    <div class="h-px w-12 bg-gray-300"></div>
                </div>
                <h2 class="font-cinzel mb-4 text-4xl tracking-wide text-[#1a365d] uppercase">Amenities</h2>
                <p class="font-cormorant max-w-3xl text-lg leading-relaxed text-gray-600">A curated selection of modern amenities brings comfort and convenience to your doorstep.</p>


                <div class="mt-9 grid grid-cols-2 gap-x-6 gap-y-10 sm:grid-cols-3 md:grid-cols-5">
                    <div v-for="amenity in project.amenities" :key="amenity.name" class="group flex flex-col items-center text-center">
                        <div class="flex h-20 w-20 items-center justify-center md:h-24 md:w-24">
                            <img v-if="amenity.image" :src="getImageUrl(amenity.image)" :alt="amenity.name" class="h-full w-full object-contain" />
                        </div>
                        <span
                            class="font-montserrat text-[11px] font-bold tracking-wider text-gray-700 uppercase
           block w-32 text-center whitespace-normal break-words"
                        >
    {{ amenity.name }}
</span>                    </div>
                </div>
            </section>

            <!--            <section class="max-w-7xl mx-auto px-6 py-16 border-t border-gray-100">-->
            <!--                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">-->
            <!--                    <div class="space-y-2">-->
            <!--                        <div class="text-4xl font-cinzel text-[#1a365d] font-bold">300,000</div>-->
            <!--                        <div class="font-montserrat text-xs tracking-wider text-gray-500 uppercase">SQFT</div>-->
            <!--                        <div class="h-px w-12 bg-gray-200 mx-auto mt-2"></div>-->
            <!--                    </div>-->
            <!--                    <div class="space-y-2">-->
            <!--                        <div class="text-4xl font-cinzel text-[#1a365d] font-bold">⚡</div>-->
            <!--                        <div class="font-montserrat text-xs tracking-wider text-gray-500 uppercase">Standby Power Generator</div>-->
            <!--                    </div>-->
            <!--                    <div class="space-y-2">-->
            <!--                        <div class="text-4xl font-cinzel text-[#1a365d] font-bold">🚗</div>-->
            <!--                        <div class="font-montserrat text-xs tracking-wider text-gray-500 uppercase">Ample Parking</div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </section>-->

            <!-- =========================================================
             LIGHTBOX
        ========================================================== -->
            <Teleport to="body">
                <div
                    v-if="showLightbox && project.gallery.length > 0"
                    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/95 p-4"
                    @click.self="closeLightbox"
                >
                    <!-- Close -->
                    <button
                        type="button"
                        @click="closeLightbox"
                        class="absolute top-6 right-6 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/20"
                        aria-label="Close image"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-6 w-6"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Previous -->
                    <button
                        type="button"
                        @click="prevImage"
                        class="absolute left-4 flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/20 md:left-8"
                        aria-label="Previous image"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-6 w-6"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Image -->
                    <div class="flex max-h-[90vh] max-w-[90vw] flex-col items-center">
                        <img
                            :src="project.gallery[currentImageIndex]?.url"
                            :alt="project.gallery[currentImageIndex]?.name || project.title"
                            class="max-h-[80vh] max-w-full object-contain"
                        />

                        <p class="font-montserrat mt-4 text-xs tracking-[0.2em] text-white/60 uppercase">
                            {{ currentImageIndex + 1 }}
                            /
                            {{ project.gallery.length }}
                        </p>
                    </div>

                    <!-- Next -->
                    <button
                        type="button"
                        @click="nextImage"
                        class="absolute right-4 flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/20 md:right-8"
                        aria-label="Next image"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-6 w-6"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </Teleport>
        </main>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import SandalWoodLoader from '@/Components/SandalWoodLoader.vue';
import { BedDouble, MapPin, HouseWifi } from '@lucide/vue';

/*
|--------------------------------------------------------------------------
| Interfaces
|--------------------------------------------------------------------------
*/

interface ProjectImage {
    id: number;
    url: string;
    name: string;
}

interface Project {
    id: number;

    title: string;
    slug: string;

    subtitle: string | null;
    tagline: string | null;

    location: string;
    location_url: string | null;
    specifications: string | null;

    status: 'ongoing' | 'completed' | 'planned' | 'sold_out';

    is_featured: boolean;

    description: string | null;

    /*
    |--------------------------------------------------------------------------
    | Project Images
    |--------------------------------------------------------------------------
    */

    image: string;
    cover_image: string;

    ideal_title: string;
    ideal_description: string | null;
    ideal_image: string;

    tranquil_title: string;
    tranquil_description: string | null;
    tranquil_image: string;

    /*
    |--------------------------------------------------------------------------
    | Gallery
    |--------------------------------------------------------------------------
    */

    gallery: ProjectImage[];
    amenities: { id: number; name: string; image: string | null }[];

    created_at: string;
    updated_at: string;
}

/*
|--------------------------------------------------------------------------
| Props
|--------------------------------------------------------------------------
*/

const props = defineProps<{
    project: Project;
}>();

/*
|--------------------------------------------------------------------------
| Loading
|--------------------------------------------------------------------------
*/

const loading = ref(false);

/*
|--------------------------------------------------------------------------
| Gallery Slides
|--------------------------------------------------------------------------
|
| Two images are displayed per slide.
|
| Example:
|
| Slide 1 => image 1 + image 2
| Slide 2 => image 3 + image 4
| Slide 3 => image 5 + image 6
|
|--------------------------------------------------------------------------
*/

const getImageUrl = (image: string | null) => {
    if (!image) {
        return '';
    }

    if (image.startsWith('http://') || image.startsWith('https://') || image.startsWith('/')) {
        return image;
    }

    return `/storage/${image}`;
};

const gallerySlide = ref(0);

const gallerySlides = computed(() => {
    const slides: {
        index: number;
        images: ProjectImage[];
    }[] = [];

    for (let i = 0; i < props.project.gallery.length; i += 2) {
        slides.push({
            index: i / 2,
            images: props.project.gallery.slice(i, i + 2),
        });
    }

    return slides;
});

/*
|--------------------------------------------------------------------------
| Gallery Navigation
|--------------------------------------------------------------------------
*/

const nextGallerySlide = () => {
    if (gallerySlides.value.length <= 1) {
        return;
    }

    gallerySlide.value = (gallerySlide.value + 1) % gallerySlides.value.length;
};

const previousGallerySlide = () => {
    if (gallerySlides.value.length <= 1) {
        return;
    }

    gallerySlide.value = (gallerySlide.value - 1 + gallerySlides.value.length) % gallerySlides.value.length;
};

const goToGallerySlide = (index: number) => {
    gallerySlide.value = index;
};

/*
|--------------------------------------------------------------------------
| Gallery Auto Slideshow
|--------------------------------------------------------------------------
*/

let galleryInterval: ReturnType<typeof setInterval> | null = null;

const startGallerySlideshow = () => {
    stopGallerySlideshow();

    if (gallerySlides.value.length <= 1) {
        return;
    }

    galleryInterval = setInterval(() => {
        nextGallerySlide();
    }, 4000);
};

const stopGallerySlideshow = () => {
    if (galleryInterval !== null) {
        clearInterval(galleryInterval);
        galleryInterval = null;
    }
};

const pauseGallery = () => {
    stopGallerySlideshow();
};

const resumeGallery = () => {
    if (!showLightbox.value) {
        startGallerySlideshow();
    }
};

/*
|--------------------------------------------------------------------------
| Get Original Gallery Image Index
|--------------------------------------------------------------------------
*/

const getOriginalImageIndex = (imageId: number): number => {
    return props.project.gallery.findIndex((image) => image.id === imageId);
};

/*
|--------------------------------------------------------------------------
| Amenities Icons
|--------------------------------------------------------------------------
*/

const ParkingIcon = {
    template: `
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M5 20h14M6 4h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
            <path d="M10 10h4a2 2 0 0 1 0 4h-4z"/>
        </svg>
    `,
};

const HighSpeedIcon = {
    template: `
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z"/>
        </svg>
    `,
};

const ReceptionIcon = {
    template: `
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <rect
                x="2"
                y="7"
                width="20"
                height="14"
                rx="2"
                ry="2"
            />
            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
        </svg>
    `,
};

const LoungeIcon = {
    template: `
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M4 19h16M4 15h16M8 8v4M16 8v4M3 5h18M6 5v3M18 5v3"/>
        </svg>
    `,
};

const StandbyPowerIcon = {
    template: `
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
            <circle
                cx="12"
                cy="12"
                r="3"
            />
        </svg>
    `,
};

const GeneratorIcon = {
    template: `
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <rect
                x="4"
                y="8"
                width="16"
                height="12"
                rx="2"
            />
            <path d="M9 4v4M15 4v4"/>
            <path d="M8 12h8"/>
            <path d="M12 16v-4"/>
        </svg>
    `,
};

/*
|--------------------------------------------------------------------------
| Displayed Features
|--------------------------------------------------------------------------
*/

const displayedFeatures = ref([
    {
        name: 'AMPLE PARKING',
        icon: ParkingIcon,
    },
    {
        name: 'HIGH SPEED',
        icon: HighSpeedIcon,
    },
    {
        name: 'RECEPTION',
        icon: ReceptionIcon,
    },
    {
        name: 'LOUNGE',
        icon: LoungeIcon,
    },
    {
        name: 'STANDBY POWER',
        icon: StandbyPowerIcon,
    },
    {
        name: 'GENERATOR',
        icon: GeneratorIcon,
    },
]);

/*
|--------------------------------------------------------------------------
| Dynamic Feature Icon
|--------------------------------------------------------------------------
*/

const getIconComponent = (featureName: string) => {
    const lower = featureName.toLowerCase();

    if (lower.includes('park')) {
        return ParkingIcon;
    }

    if (lower.includes('speed') || lower.includes('high speed')) {
        return HighSpeedIcon;
    }

    if (lower.includes('reception')) {
        return ReceptionIcon;
    }

    if (lower.includes('lounge')) {
        return LoungeIcon;
    }

    if (lower.includes('standby')) {
        return StandbyPowerIcon;
    }

    if (lower.includes('generator')) {
        return GeneratorIcon;
    }

    return HighSpeedIcon;
};

/*
|--------------------------------------------------------------------------
| Lightbox
|--------------------------------------------------------------------------
*/

const showLightbox = ref(false);
const currentImageIndex = ref(0);

const openLightbox = (index: number) => {
    if (index < 0) {
        return;
    }

    currentImageIndex.value = index;
    showLightbox.value = true;

    stopGallerySlideshow();

    document.body.style.overflow = 'hidden';
};

const closeLightbox = () => {
    showLightbox.value = false;

    document.body.style.overflow = '';

    startGallerySlideshow();
};

const nextImage = () => {
    if (!props.project.gallery.length) {
        return;
    }

    currentImageIndex.value = (currentImageIndex.value + 1) % props.project.gallery.length;
};

const prevImage = () => {
    if (!props.project.gallery.length) {
        return;
    }

    currentImageIndex.value = (currentImageIndex.value - 1 + props.project.gallery.length) % props.project.gallery.length;
};

/*
|--------------------------------------------------------------------------
| Keyboard Navigation
|--------------------------------------------------------------------------
*/

const handleKeydown = (event: KeyboardEvent) => {
    if (!showLightbox.value) {
        return;
    }

    switch (event.key) {
        case 'Escape':
            closeLightbox();
            break;

        case 'ArrowRight':
            nextImage();
            break;

        case 'ArrowLeft':
            prevImage();
            break;
    }
};

/*
|--------------------------------------------------------------------------
| Lifecycle
|--------------------------------------------------------------------------
*/

onMounted(() => {
    document.addEventListener('keydown', handleKeydown);

    startGallerySlideshow();
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown);

    stopGallerySlideshow();

    document.body.style.overflow = '';
});
</script>

<style scoped>
/*
|--------------------------------------------------------------------------
| Fonts
|--------------------------------------------------------------------------
*/

.font-montserrat {
    font-family: 'Montserrat', sans-serif;
}

.font-cinzel {
    font-family: 'Cinzel', serif;
}

h1.font-cinzel {
    font-family: 'Cinzel', serif !important;
}

.font-cormorant {
    font-family: 'Cormorant Garamond', serif;
}

/*
|--------------------------------------------------------------------------
| Smooth transitions
|--------------------------------------------------------------------------
*/

button,
img {
    transition: all 0.25s ease;
}

/*
|--------------------------------------------------------------------------
| Justified text
|--------------------------------------------------------------------------
*/

.text-justify {
    text-align: justify;
}

/*
|--------------------------------------------------------------------------
| Amenity icon hover
|--------------------------------------------------------------------------
*/

.group:hover svg {
    transform: scale(1.05);
    transition: transform 0.2s;
}

/*
|--------------------------------------------------------------------------
| Gallery image hover
|--------------------------------------------------------------------------
*/

.group\/image:hover img {
    transform: scale(1.05);
}

/*
|--------------------------------------------------------------------------
| Responsive
|--------------------------------------------------------------------------
*/

@media (max-width: 768px) {
    h1 {
        font-size: 2.5rem;
    }

    .max-w-7xl {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
}
</style>
