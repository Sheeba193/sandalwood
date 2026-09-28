<script setup>
import { ref, onMounted, computed, nextTick } from 'vue';
import { Link } from '@inertiajs/vue3';
import Lenis from 'lenis';
import AppLayout from '@/Layouts/AppLayout.vue';
import SandalWoodLoader from '@/Components/SandalWoodLoader.vue';

// Define the projects prop passed from the backend
const props = defineProps({
    projects: Array
});

const loading = ref(true);
const currentSlide = ref(0);

// Statistics from your branding
const stats = [
    { value: '20+', label: 'YEARS OF<br>EXPERIENCE' },
    { value: '15+', label: 'PROJECTS' },
    { value: '2', label: 'PROJECTS UNDER<br>CONSTRUCTION' },
    { value: '10+', label: 'PRIME<br>LOCATIONS' }
];

// Computed property to group projects into sets of 3 for the slider
const propertyGroups = computed(() => {
    const groups = [];
    if (!props.projects) return groups;

    for (let i = 0; i < props.projects.length; i += 3) {
        groups.push(props.projects.slice(i, i + 3));
    }
    return groups;
});

const next = () => {
    if (currentSlide.value < propertyGroups.value.length - 1) {
        currentSlide.value++;
    } else {
        currentSlide.value = 0;
    }
};

const prev = () => {
    if (currentSlide.value > 0) {
        currentSlide.value--;
    } else {
        currentSlide.value = propertyGroups.value.length - 1;
    }
};

onMounted(() => {
    // Smooth scrolling initialization
    const lenis = new Lenis({ duration: 1.2 });
    function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
    requestAnimationFrame(raf);

    setTimeout(() => {
        loading.value = false;
        nextTick(() => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => entry.isIntersecting && entry.target.classList.add('active'));
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    }, 1500);
});
</script>

<template>
    <div class="font-serif selection:bg-gray-200 overflow-x-hidden">
        <div v-if="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-white">
            <SandalWoodLoader />
        </div>

        <div v-else>
            <AppLayout>
                <section class="relative h-[30vh] bg-[#001221] overflow-hidden">
                    <img src="/images/about-hero.jpg" class="w-full h-full object-cover opacity-50" alt="Hero" />
                </section>

                <div class="bg-white relative z-10">
                    <section class="max-w-7xl mx-auto px-6 md:px-12 py-24 reveal">
                        <div class="max-w-4xl mx-auto">
                            <div class="flex items-center space-x-4 mb-6">
                                <span class="text-[12px] tracking-[0.2em] uppercase text-gray-700 font-cinzel">overview</span>
                                <div class="h-[0.5px] w-32 bg-gray-400"></div>
                            </div>
                            <h2 class="text-2xl md:text-4xl tracking-[0.15em] uppercase text-[#001221] mb-8 font-light font-cinzel">
                                ABOUT SANDALWOOD PROPERTIES
                            </h2>
                            <p class="text-[18px] leading-relaxed text-gray-500 font-cormorant text-justify">
                                Sandalwood Developers is a distinguished real estate development company, recognized for its excellence in delivering thoughtfully designed residential and office
                                developments. With a strong foundation built over two decades, Sandalwood Developers combines expertise in design, construction, and project delivery to create
                                exceptional living environments.
                            </p>
                        </div>
                    </section>

                    <section class="bg-[#c1c2c3] py-20 reveal">
                        <div class="max-w-7xl mx-auto px-6 md:px-12 flex flex-wrap justify-between items-center gap-12">
                            <div v-for="(stat, i) in stats" :key="i" class="flex items-center">
                                <div class="flex items-center space-x-6">
                                    <span class="text-5xl md:text-6xl font-cinzel text-[#001221]">{{ stat.value }}</span>
                                    <div class="text-[11px] tracking-[0.2em] uppercase text-gray-600 leading-tight font-cinzel" v-html="stat.label"></div>
                                </div>
                                <div v-if="i !== stats.length - 1" class="h-16 w-[1px] bg-gray-300 ml-12 hidden lg:block"></div>
                            </div>
                        </div>
                    </section>

                    <section class="max-w-7xl mx-auto px-6 md:px-12 py-24 reveal">
                        <div class="max-w-4xl mx-auto">
                        <h3 class="text-2xl tracking-[0.2em] uppercase text-[#001221] font-cinzel mb-16">THE SANDALWOOD STANDARD</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="bg-[#f4f5f7] p-12 flex flex-col items-center text-center">
                                <h4 class="text-lg tracking-[0.15em] uppercase text-[#001221] font-cinzel mb-6">OUR MISSION</h4>
                                <p class="text-[18px] leading-relaxed text-gray-500 font-cormorant text-justify">
                                    To create exceptional developments through innovation, quality, and attention to detail, consistently delivering spaces that surpass expectations.
                                </p>
                            </div>

                            <div class="bg-[#f4f5f7] p-12 flex flex-col items-center text-center">
                                <h4 class="text-lg tracking-[0.15em] uppercase text-[#001221] font-cinzel mb-6">OUR VISION</h4>
                                <p class="text-[18px] leading-relaxed text-gray-500 font-cormorant text-justify">
                                    To set the benchmark in real estate by developing distinctive properties that inspire modern living and lasting value.
                                </p>
                            </div>

                            <div class="bg-[#f4f5f7] p-12 flex flex-col items-center text-center">
                                <h4 class="text-lg tracking-[0.15em] uppercase text-[#001221] font-cinzel mb-6">OUR VALUE</h4>
                                <p class="text-[18px] leading-relaxed text-gray-500 font-cormorant text-justify">
                                    We are driven by integrity, precision, and a steadfast commitment to excellence, ensuring every project upholds the highest standards of quality and trust.
                                </p>
                            </div>
                        </div>
                        </div>
                    </section>


                </div>

                <div class="bg-white relative z-10">

                    <section class="max-w-7xl mx-auto px-6 md:px-12 py-24 reveal">
                        <div class="max-w-4xl mx-auto">
                        <div class="flex justify-between items-end mb-12">
                            <h3 class="text-2xl tracking-[0.15em] uppercase text-[#001221] font-cinzel">SANDALWOOD PROPERTIES</h3>
                            <Link href="/projects" class="text-[14px] bg-[#001221] text-white px-8 py-3 tracking-[0.2em] font-montserrat uppercase">VIEW ALL</Link>
                        </div>

                        <div class="relative overflow-hidden">
                            <div class="flex transition-transform duration-1000 ease-in-out" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
                                <div v-for="(group, idx) in propertyGroups" :key="idx" class="flex-none w-full grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <div v-for="prop in group" :key="prop.id" class="group cursor-pointer">
                                        <div class="overflow-hidden mb-6 aspect-[4/3] bg-gray-50">
                                            <img :src="prop.image" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                                        </div>
                                        <h4 class="text-[18px] leading-relaxed text-gray-500 font-cormorant text-justify">{{ prop.title }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-16 flex items-center justify-center space-x-12">
                            <button @click="prev" class="opacity-30 hover:opacity-100 transition-opacity">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7"/></svg>
                            </button>

                            <div class="flex items-center space-x-2">
                                <button
                                    v-for="(_, i) in propertyGroups"
                                    :key="i"
                                    @click="currentSlide = i"
                                    class="w-2.5 h-2.5 transition-all duration-300"
                                    :class="currentSlide === i ? 'bg-black' : 'bg-gray-200'"
                                ></button>
                            </div>

                            <button @click="next" class="opacity-30 hover:opacity-100 transition-opacity">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                        </div>
                    </section>
                </div>
            </AppLayout>
        </div>
    </div>
</template>

<style scoped>
.reveal { opacity: 0; transform: translateY(40px); transition: all 1.2s cubic-bezier(0.22, 1, 0.36, 1); }
.reveal.active { opacity: 1; transform: translateY(0); }
</style>
