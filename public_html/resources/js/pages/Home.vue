<template>
    <div class="overflow-x-hidden font-serif selection:bg-gray-200">
        <div v-if="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-white">
            <SandalWoodLoader />
        </div>

        <div v-else>
            <AppLayout>
                <section class="relative h-[85vh] w-full overflow-hidden bg-[#001221] text-white">
                    <div class="absolute inset-0 z-0">
                        <div
                            v-for="(slide, index) in slides"
                            :key="index"
                            class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                            :class="{ 'opacity-100': currentSlide === index, 'opacity-0': currentSlide !== index }"
                        >
                            <img
                                :src="slide.image"
                                @load="handleImageLoad"
                                class="h-full w-full transform object-cover opacity-60 transition-transform duration-[10000ms]"
                                :class="currentSlide === index ? 'scale-110' : 'scale-100'"
                            />
                        </div>
                    </div>

                    <button
                        @click="prevSlide"
                        class="group absolute top-1/2 left-8 z-30 hidden -translate-y-1/2 opacity-60 transition-opacity hover:opacity-100 md:block"
                    >
                        <div class="relative">
                            <div
                                class="absolute inset-0 scale-0 rounded-full bg-white/20 transition-transform duration-300 group-hover:scale-100"
                            ></div>
                            <svg class="relative z-10 h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7" />
                            </svg>
                        </div>
                    </button>

                    <button
                        @click="nextSlide"
                        class="group absolute top-1/2 right-8 z-30 hidden -translate-y-1/2 opacity-60 transition-opacity hover:opacity-100 md:block"
                    >
                        <div class="relative">
                            <div
                                class="absolute inset-0 scale-0 rounded-full bg-white/20 transition-transform duration-300 group-hover:scale-100"
                            ></div>
                            <svg class="relative z-10 h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </button>

                    <div class="relative z-20 flex h-full w-full flex-col items-center justify-center px-6 text-center">
                        <div class="text-content-container">
                            <transition name="fade-slide" mode="out-in">
                                <div :key="currentSlide" class="flex flex-col items-center">
                                    <h1 class="font-cinzel mb-2 text-4xl tracking-[0.3em] whitespace-nowrap uppercase md:text-6xl">
                                        {{ slides[currentSlide]?.title }}
                                    </h1>
                                    <h2 class="font-cinzel mb-8 text-3xl tracking-[0.1em] whitespace-nowrap md:text-5xl">
                                        {{ slides[currentSlide]?.subtitle }}
                                    </h2>
                                </div>
                            </transition>
                        </div>

                        <div class="font-cinzel mb-10 flex items-center space-x-6 text-[12px] tracking-[0.3em] uppercase opacity-80">
                            <span>Loresho</span>
                            <span class="h-4 w-px bg-white/40"></span>
                            <span>Apartments</span>
                            <span class="h-4 w-px bg-white/40"></span>
                            <span>Under Construction</span>
                        </div>

                        <Link
                            href="/projects"
                            class="font-montserrat bg-black px-10 py-3 text-[12px] tracking-[0.3em] text-white uppercase transition-all duration-500 hover:bg-white hover:text-black"
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
                    <!-- JUSTIFIED TEXT VERSION -->
                    <section class="reveal mx-auto max-w-7xl px-6 py-24 md:px-12">
                        <div class="mx-auto max-w-4xl">
                            <h2 class="font-cinzel mb-8 text-2xl tracking-[0.15em] text-[#001221] uppercase md:text-4xl">
                                PREMIUM PROPERTIES IN PRIME LOCATIONS
                            </h2>
                            <p class="font-cormorant text-justify text-[18px] leading-relaxed text-gray-400">
                                Sandalwood Properties is renowned for its distinguished reputation in the real estate industry. With over two decades
                                of experience, we conceptualise and deliver exceptional developments that redefine luxury living, seamlessly
                                integrating lush green spaces and beautifully curated gardens that enhance both aesthetics and well-being. Each
                                project is thoughtfully set in the most coveted locations, defined by timeless design and an elevated standard of
                                living.
                            </p>
                        </div>
                    </section>

                    <section class="reveal mx-auto max-w-7xl px-6 py-24 md:px-12">
                        <div class="mx-auto max-w-4xl">
                            <span class="text-[10px] font-medium tracking-[0.2em] text-gray-400 uppercase">DEVELOPMENTS</span>
                            <div class="h-[0.5px] w-24 bg-gray-200"></div>
                        </div>

                        <div class="mx-auto max-w-4xl">
                            <h3 class="font-cinzel mb-6 text-3xl tracking-[0.15em] text-[#001221] uppercase">RECENT LAUNCHES</h3>
                            <p class="font-cormorant text-justify text-[18px] leading-relaxed text-gray-400">
                                Each project is thoughtfully designed to captivate, the striking architectural designs and high-end finishes exude
                                elegance and timeless luxury. Every detail reflects our commitment to creating exceptional living experiences that
                                embody sophistication and comfort.
                            </p>
                        </div>

                        <div class="mx-auto mt-8 grid max-w-4xl grid-cols-1 gap-12 md:grid-cols-3">
                            <div v-for="proj in recent_launches" :key="proj.id" class="group cursor-pointer">
                                <div class="mb-6 aspect-[4/5] overflow-hidden">
                                    <img
                                        :src="proj.image"
                                        @load="handleImageLoad"
                                        class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                    />
                                </div>
                                <h4 class="text-[11px] font-medium tracking-[0.2em] text-gray-600 uppercase">{{ proj.title }}</h4>
                            </div>
                        </div>

                        <div class="mt-16 text-center">
                            <Link
                                href="/projects"
                                class="font-montserrat inline-block bg-black px-12 py-4 text-[10px] tracking-[0.2em] text-white uppercase transition-colors hover:bg-gray-800"
                            >
                                VIEW ALL DEVELOPMENTS
                            </Link>
                        </div>
                    </section>

                    <section
                        class="reveal mx-auto max-w-7xl border-t border-gray-100 px-6 py-24 md:px-12"
                        @mouseenter="stopRotation"
                        @mouseleave="startRotation"
                    >
                        <div class="mx-auto max-w-4xl">
                            <div class="mb-6 flex items-center space-x-4">
                                <span class="font-cinzel text-[10px] font-medium tracking-[0.2em] text-gray-400 uppercase">DEVELOPMENTS</span>
                                <div class="h-[0.5px] w-24 bg-gray-200"></div>
                            </div>

                            <div class="mb-12 flex items-end justify-between">
                                <div class="text-left">
                                    <h3 class="font-cinzel mb-6 text-3xl tracking-[0.15em] text-[#001221] uppercase">COMPLETED PROJECTS</h3>
                                    <p class="font-cormorant text-justify text-[18px] leading-relaxed text-gray-400">
                                        Each finished project stands as an expression of vision realized, where superior craftsmanship meets timeless
                                        design.
                                    </p>
                                </div>
                                <div class="mb-2 flex space-x-4">
                                    <button @click="rotateProjects" class="transition-colors hover:text-gray-400">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 5l7 7-7 7" stroke-width="1" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-10 md:grid-cols-12">
                                <div class="group cursor-pointer overflow-hidden md:col-span-6 lg:col-span-5">
                                    <transition name="fade-scale" mode="out-in">
                                        <div v-if="displayProjects?.length" :key="displayProjects[0]?.id">
                                            <div class="mb-6 aspect-[3/4] overflow-hidden">
                                                <img
                                                    :src="displayProjects[0]?.image"
                                                    class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-105"
                                                    alt=""
                                                />
                                            </div>

                                            <h4 class="font-cinzel text-[11px] font-medium tracking-[0.2em] text-gray-600 uppercase">
                                                {{ displayProjects[0]?.title }}
                                            </h4>
                                        </div>
                                    </transition>
                                </div>

                                <div class="grid grid-cols-2 gap-6 md:col-span-6 lg:col-span-7">
                                    <transition-group name="list">
                                        <div v-for="proj in displayProjects.slice(1, 5)" :key="proj.id" class="group cursor-pointer">
                                            <div class="mb-3 aspect-video overflow-hidden lg:aspect-square">
                                                <img
                                                    :src="proj.image"
                                                    class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                                />
                                            </div>
                                            <h4 class="font-cinzel text-[9px] font-medium tracking-[0.2em] text-gray-400 uppercase">
                                                {{ proj.title }}
                                            </h4>
                                        </div>
                                    </transition-group>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </AppLayout>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref, nextTick, onUnmounted } from 'vue';
import Lenis from 'lenis';
import { Link } from '@inertiajs/vue3';
import SandalWoodLoader from '@/Components/SandalWoodLoader.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    slides: { type: Array, default: () => [] },

    recent_launches: { type: Array, default: () => [] },

    completed_projects: { type: Array, default: () => [] },
});

const loading = ref(true);
const currentSlide = ref(0);
const imagesLoaded = ref(0);
const displayProjects = ref([...props.completed_projects]);

const totalImages = (props.slides?.length || 0) + (props.recent_launches?.length || 0) + (props.completed_projects?.length || 0);

let rotationInterval: ReturnType<typeof setInterval> | null = null;

const rotateProjects = () => {
    if (displayProjects.value.length <= 1) return;
    const shiftedItem = displayProjects.value.shift();
    if (shiftedItem) {
        displayProjects.value.push(shiftedItem);
    }
};

const startRotation = () => {
    if (!rotationInterval && displayProjects.value.length > 0) {
        rotationInterval = setInterval(rotateProjects, 5000);
    }
};

const stopRotation = () => {
    if (rotationInterval) {
        clearInterval(rotationInterval);
        rotationInterval = null;
    }
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
    startRotation();
});

onUnmounted(() => {
    stopRotation();
});
</script>

<style scoped>
/* Scroll Reveal Styles */
.reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: all 1.2s cubic-bezier(0.22, 1, 0.36, 1);
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
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
