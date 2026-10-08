<template>
    <div class="overflow-x-hidden font-serif selection:bg-gray-200">
        <div v-if="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-white">
            <SandalWoodLoader />
        </div>

        <div v-else>
            <AppLayout>
                <section class="relative h-[78svh] min-h-[560px] max-h-[900px] w-full overflow-hidden bg-[#001221] text-white">
                    <div class="absolute inset-0 z-0">
                        <div
                            v-for="(slide, index) in slides"
                            :key="index"
                            class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                            :class="{ 'opacity-100': currentSlide === index, 'opacity-0': currentSlide !== index }"
                        >
                            <img
                                :class="currentSlide === index ? 'scale-110' : 'scale-100'"
                                :src="slide.image"
                                @load="handleImageLoad"
                                class="h-full w-full transform object-cover opacity-55 transition-transform duration-[10000ms]"
                            />
                        </div>
                    </div>

                    <button
                        @click="prevSlide"
                        class="absolute top-1/2 left-3 z-30 -translate-y-1/2 opacity-80 transition-opacity hover:opacity-100 md:left-8"
                    >
                            <svg class="h-9 w-9 sm:h-10 sm:w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7" />
                            </svg>
                    </button>

                    <button
                        @click="nextSlide"
                        class="absolute top-1/2 right-3 z-30 -translate-y-1/2 opacity-80 transition-opacity hover:opacity-100 md:right-8"
                    >
                            <svg class="h-9 w-9 sm:h-10 sm:w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5l7 7-7 7" />
                            </svg>
                    </button>

                    <div class="relative z-20 flex h-full w-full flex-col items-center justify-center px-6 text-center">
                        <div class="text-content-container">
                            <transition name="fade-slide" mode="out-in">
                                <div :key="currentSlide" class="flex flex-col items-center">
                                    <p class="font-cinzel mb-1 text-3xl font-light tracking-[0.16em] uppercase sm:text-4xl md:text-5xl">
                                        SANDALWOOD
                                    </p>
                                    <h1 class="font-cinzel mb-8 max-w-4xl text-3xl font-light tracking-[0.08em] uppercase sm:text-4xl md:text-5xl">
                                        {{ heroProjectName }}
                                    </h1>
                                </div>
                            </transition>
                        </div>

                        <div class="font-cinzel mb-8 flex max-w-5xl flex-wrap items-center justify-center gap-x-3 gap-y-2 text-[10px] tracking-[0.16em] uppercase opacity-90 sm:mb-10 sm:gap-x-5 sm:text-xs">
                            <template v-for="(item, index) in heroDetails" :key="item">
                                <span v-if="index" class="h-3 w-px bg-white/50"></span>
                                <span>{{ item }}</span>
                            </template>
                        </div>

                        <Link
                            :href="slides[currentSlide]?.slug ? `/projects/${slides[currentSlide].slug}` : '/projects'"
                            class="font-montserrat bg-black px-8 py-3 text-[11px] tracking-[0.2em] text-white uppercase transition-all duration-500 hover:bg-[#1a365d] sm:px-10 sm:text-xs sm:tracking-[0.3em]"
                        >
                            LEARN MORE
                        </Link>
                    </div>

                    <div class="absolute bottom-8 left-1/2 z-30 flex -translate-x-1/2 space-x-3">
                        <button
                            v-for="(_, i) in slides"
                            :key="i"
                            @click="currentSlide = i"
                            class="h-2 w-2 rounded-full transition-all duration-300"
                            :class="currentSlide === i ? 'scale-125 bg-white' : 'bg-white/30'"
                        ></button>
                    </div>
                </section>
                <div class="relative z-10 w-full bg-white">
                    <section class="reveal mx-auto max-w-6xl px-6 py-14 sm:px-10 sm:py-20 lg:px-12">
                        <div class="max-w-5xl">
                            <h2 class="font-cinzel mb-5 text-2xl tracking-[0.08em] text-[#001221] uppercase sm:text-3xl sm:tracking-[0.15em]">
                                PREMIUM PROPERTIES IN PRIME LOCATIONS
                            </h2>
                            <p class="font-cormorant text-justify text-base leading-relaxed text-gray-500 sm:text-lg">
                                Sandalwood Properties is renowned for its distinguished reputation in the real estate industry. With over two decades
                                of experience, we conceptualise and deliver exceptional developments that redefine luxury living, seamlessly
                                integrating lush green spaces and beautifully curated gardens that enhance both aesthetics and well-being. Each
                                project is thoughtfully set in the most coveted locations, defined by timeless design and an elevated standard of
                                living.
                            </p>
                        </div>
                    </section>

                    <section class="reveal mx-auto max-w-6xl px-6 py-10 sm:px-10 lg:px-12 lg:py-12">
                        <div class="mb-3 flex items-center gap-4">
                            <span class="font-cinzel text-[10px] tracking-[0.2em] text-gray-400">DEVELOPMENTS</span>
                            <div class="h-px flex-1 bg-gray-300"></div>
                        </div>
                        <h3 class="font-cinzel mb-2 text-3xl tracking-[0.08em] text-[#001221] uppercase sm:text-4xl">RECENT LAUNCHES</h3>
                        <p class="font-cormorant mb-6 max-w-5xl text-justify text-base leading-relaxed text-gray-500 sm:text-lg">
                                Each project is thoughtfully designed to captivate, the striking architectural designs and high-end finishes exude
                                elegance and timeless luxury. Every detail reflects our commitment to creating exceptional living experiences that
                                embody sophistication and comfort.
                        </p>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8">
                            <Link v-for="proj in recent_launches.slice(0, 2)" :key="proj.id" :href="`/projects/${proj.slug}`" class="group motion-card block">
                                <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                                    <img
                                        :src="proj.image"
                                        :alt="proj.title"
                                        @load="handleImageLoad"
                                        class="motion-card-image h-full w-full object-cover"
                                    />
                                </div>
                                <h4 class="mt-2 text-center font-serif text-[10px] tracking-wide text-gray-500 uppercase sm:text-xs">{{ proj.title }}</h4>
                            </Link>
                        </div>
                        <div class="mt-8 text-center">
                            <Link href="/projects" class="font-montserrat inline-block bg-[#001221] px-6 py-3 text-[11px] font-semibold tracking-wider text-white uppercase transition-colors hover:bg-[#1a365d]">VIEW ALL DEVELOPMENTS</Link>
                        </div>
                    </section>

                    <section class="reveal mx-auto max-w-6xl border-t border-gray-100 px-6 py-14 sm:px-10 lg:px-12 lg:py-20">
                        <div class="mb-3 flex items-center gap-4">
                            <span class="font-cinzel text-[10px] tracking-[0.2em] text-gray-400">DEVELOPMENTS</span>
                            <div class="h-px w-24 bg-gray-300"></div>
                        </div>
                        <h3 class="font-cinzel mb-3 text-3xl tracking-[0.08em] text-[#001221] uppercase sm:text-4xl">COMPLETED PROJECTS</h3>
                        <p class="font-cormorant mb-8 max-w-5xl text-justify text-base leading-relaxed text-gray-500 sm:text-lg">
                            Each finished project stands as an expression of vision realized, where superior craftsmanship meets timeless design. Delivered to the highest standards, these properties embody enduring quality, elevated living, and the trust we have consistently earned in the real estate space.
                        </p>
                        <div class="grid grid-cols-1 gap-x-6 gap-y-7 sm:grid-cols-2 lg:auto-rows-[210px] lg:grid-cols-3">
                            <Link v-for="(proj, index) in completed_projects.slice(0, 5)" :key="proj.id" :href="`/projects/${proj.slug}`" class="group motion-card flex h-full flex-col" :class="index === 0 ? 'lg:row-span-2' : ''">
                                <div class="min-h-0 flex-1 overflow-hidden bg-gray-100" :class="index === 0 ? 'aspect-[4/3] lg:aspect-auto' : 'aspect-[4/3] lg:aspect-auto'">
                                    <img :src="proj.image" :alt="proj.title" @load="handleImageLoad" class="motion-card-image h-full w-full object-cover" />
                                </div>
                                <h4 class="mt-2 text-center font-serif text-[10px] tracking-wide text-gray-500 uppercase sm:text-xs">{{ proj.title }}</h4>
                            </Link>
                        </div>
                        <div class="mt-10 text-center">
                            <Link href="/projects" class="font-montserrat inline-block bg-[#001221] px-6 py-3 text-[11px] font-semibold tracking-wider text-white uppercase transition-colors hover:bg-[#1a365d]">VIEW ALL DEVELOPMENTS</Link>
                        </div>
                    </section>
                </div>
            </AppLayout>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref, nextTick, watch } from 'vue';
import Lenis from 'lenis';
import { Link } from '@inertiajs/vue3';
import SandalWoodLoader from '@/Components/SandalWoodLoader.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    slides: { type: Array, default: () => [] },

    recent_launches: { type: Array, default: () => [] },

    completed_projects: { type: Array, default: () => [] },
    under_construction: { type: Array, default: () => [] },
});

const loading = ref(true);
const currentSlide = ref(0);
const imagesLoaded = ref(0);
const totalImages = (props.slides?.length || 0) + (props.recent_launches?.length || 0) + (props.completed_projects?.length || 0);
const heroProjectName = computed(() => {
    const title = props.slides?.[currentSlide.value]?.title ?? '';
    return title.replace(/^sandalwood\s*/i, '') || title;
});

const projectDetails: Record<string, { location: string; specifications: string }> = {
    'sandalwood-loresho': { location: 'Loresho', specifications: '3 & 4 Bedroom Apartments' },
    'sandalwood-kyuna': { location: 'Kyuna, Nairobi', specifications: 'Residential Development' },
    'sandalwood-kitisuru': { location: 'Kitisuru, Nairobi', specifications: '5 Bedroom Villas' },
    'sandalwood-othaya': { location: 'Othaya Road, Lavington', specifications: '3 Bedroom Apartments' },
    'sandalwood-waterfront': { location: 'Karen, Nairobi', specifications: 'Villas' },
    'sandalwood-brookside': { location: 'Brookside, Westlands', specifications: '3 Bedroom Apartments' },
    'the-colosseum-residences': { location: 'Westlands, Nairobi', specifications: '2, 3 & 4 Bedroom Apartments' },
    'silver-terraces': { location: 'Rhapta Road, Westlands', specifications: '2 & 3 Bedroom Apartments' },
    'ivory-terraces': { location: 'Rhapta Road, Westlands', specifications: '2 & 3 Bedroom Apartments' },
    'the-convex': { location: 'Riverside, Westlands', specifications: 'Office Development' },
    'chilly-breezes': { location: 'Westlands, Nairobi', specifications: '1, 2 & 3 Bedroom Apartments' },
    'the-haven': { location: 'Loresho, Nairobi', specifications: '4 & 5 Bedroom Homes' },
    'oak-and-ivy': { location: 'Loresho, Nairobi', specifications: 'Villas' },
    'sandalwood-riverside': { location: 'Riverside, Nairobi', specifications: '2, 3 & 4 Bedroom Apartments' },
    'sandalwood-lenana-road': { location: 'Lenana Road, Nairobi', specifications: 'Apartments' },
    'sandalwood-clyde-gardens': { location: 'Lavington, Nairobi', specifications: '3 Bedroom Apartments' },
};

const heroDetails = computed(() => {
    const slide = props.slides?.[currentSlide.value];
    if (!slide) return [];

    const fallback = projectDetails[slide.slug] ?? { location: '', specifications: '' };
    const status = String(slide.status ?? '').toLowerCase();
    const soldOutSlugs = ['sandalwood-othaya', 'sandalwood-kitisuru', 'the-convex', 'sandalwood-clyde-gardens'];
    const availability = status === 'sold_out' || soldOutSlugs.includes(slide.slug) ? 'Sold Out' : 'Available for Inquiry';
    const construction = status === 'sold_out' ? 'Completed' : formatStatus(status);

    return [
        availability,
        slide.specifications || fallback.specifications,
        slide.location || fallback.location,
        construction,
    ].filter(Boolean);
});

const formatStatus = (status?: string) => {
    if (!status) return '';
    if (status === 'ongoing') return 'Under Construction';
    return status.replaceAll('_', ' ');
};

const handleImageLoad = () => {
    imagesLoaded.value++;

    if (imagesLoaded.value >= totalImages) {
        loading.value = false;
    }
};

const nextSlide = () => {
    if (props.slides.length) {
        currentSlide.value = (currentSlide.value + 1) % props.slides.length;
    }
};

const prevSlide = () => {
    if (props.slides.length) {
        currentSlide.value = (currentSlide.value - 1 + props.slides.length) % props.slides.length;
    }
};

const initSmoothScroll = () => {
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true,
    });

    function raf(time: number) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);
};

const initScrollReveal = () => {
    const observer = new IntersectionObserver(
        (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                            observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.05, // Trigger earlier
            rootMargin: '0px 0px -50px 0px', // Trigger before it actually hits the viewport
        },
    );

    // Use nextTick to ensure the DOM is fully rendered
    nextTick(() => {
        document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
    });
};
onMounted(async () => {
    const lenis = new Lenis({
        autoRaf: true, // Newer versions of Lenis handle the RAF for you
    });

    await nextTick();

    // Fallback: If images take too long, show content anyway
    setTimeout(() => {
        loading.value = false;
        // CRITICAL: Tell Lenis the page height might have changed
        lenis.resize();
        initScrollReveal();
    }, 3000);

    if (totalImages === 0) {
        loading.value = false;
    } else {
        setTimeout(() => {
            loading.value = false;
        }, 3000);
    }

    if (props.slides.length > 0) {
        setInterval(nextSlide, 6000);
    }
});

watch(loading, async (isLoading) => {
    if (!isLoading) {
        await nextTick();
        initScrollReveal();
    }
}, { flush: 'post' });
</script>

<style scoped>
/* Scroll Reveal Styles */
.reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 650ms cubic-bezier(0.22, 1, 0.36, 1), transform 650ms cubic-bezier(0.22, 1, 0.36, 1);
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
}

@media (prefers-reduced-motion: reduce) {
    .reveal {
        opacity: 1;
        transform: none;
        transition: none;
    }
}

/* Hero Text Transition */
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.8s ease;
}
.fade-slide-enter-from {
    opacity: 0;
    transform: translateY(20px);
}
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}

.font-serif {
    font-family: 'Optima', 'Adobe Garamond Pro', serif;
}
/* Big Image Transition */
.fade-scale-enter-active,
.fade-scale-leave-active {
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}
.fade-scale-enter-from {
    opacity: 0;
    transform: scale(0.95);
}
.fade-scale-leave-to {
    opacity: 0;
    transform: scale(1.05);
}

/* Small Images Transition Group */
.list-move,
.list-enter-active,
.list-leave-active {
    transition: all 0.8s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

/* Ensure leaving items are taken out of flow so others can slide */
.list-leave-active {
    position: absolute;
    visibility: hidden;
}
</style>
