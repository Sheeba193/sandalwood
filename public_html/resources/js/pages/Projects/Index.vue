<template>
    <AppLayout>
        <SandalWoodLoader v-if="loading" />

        <main v-else class="min-h-screen bg-white pt-20 pb-24">
            <section class="reveal mx-auto max-w-7xl px-6 py-4 md:px-12">
                <div class="mx-auto max-w-4xl">
                    <header class="mb-16 max-w-4xl">
                        <h3 class="font-cinzel mb-8 text-4xl tracking-widest text-[#001221] uppercase md:text-5xl">Sandalwood Projects</h3>
                        <p class="font-cormorant text-justify text-[18px] leading-relaxed text-gray-500">
                            A curated collection of exceptional properties that reflect our vision for refined living. Each project is thoughtfully
                            designed and meticulously crafted to harmonize elegance, functionality, and enduring value.
                        </p>
                    </header>

                    <nav class="mb-20 flex flex-wrap gap-4">
                        <button
                            @click="activeFilter = 'all'"
                            :class="activeFilter === 'all' ? 'bg-[#404040] text-white' : 'border border-gray-300 text-gray-600'"
                            class="font-montserrat rounded-full px-8 py-2 text-[11px] tracking-widest uppercase transition-all"
                        >
                            All Projects
                        </button>
                        <button
                            @click="activeFilter = 'ongoing'"
                            :class="activeFilter === 'ongoing' ? 'bg-[#404040] text-white' : 'border border-gray-300 text-gray-600'"
                            class="rounded-full px-8 py-2 text-[11px] tracking-widest uppercase transition-all"
                        >
                            Under Construction
                        </button>
                        <button
                            @click="activeFilter = 'completed'"
                            :class="activeFilter === 'completed' ? 'bg-[#404040] text-white' : 'border border-gray-300 text-gray-600'"
                            class="rounded-full px-8 py-2 text-[11px] tracking-widest uppercase transition-all"
                        >
                            Completed
                        </button>
                    </nav>

                    <div class="space-y-24">
                        <section
                            v-for="project in filteredProjects"
                            :key="project.id"
                            class="reveal-on-scroll grid grid-cols-1 items-center gap-12 md:grid-cols-2"
                        >
                            <div class="aspect-video overflow-hidden bg-gray-100">
                                <img
                                    :src="project.image"
                                    class="h-full w-full object-cover transition-transform duration-1000 hover:scale-105"
                                    :alt="project.title"
                                />
                            </div>

                            <div class="space-y-6">
                                <h2 class="font-cinzel text-3xl tracking-[0.2em] text-[#001221] uppercase">
                                    {{ project.title }}
                                </h2>
                                <Link
                                    :href="`/projects/${project.slug}`"
                                    class="font-montserrat inline-block bg-black px-10 py-4 text-[14px] tracking-[0.3em] text-white uppercase transition-colors hover:bg-gray-800"
                                >
                                    Get More Details
                                </Link>
                            </div>
                        </section>

                        <div v-if="filteredProjects.length === 0" class="py-20 text-center text-sm tracking-widest text-gray-400 uppercase">
                            No projects found in this category.
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch, nextTick } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SandalWoodLoader from '@/Components/SandalWoodLoader.vue';

interface Project {
    id: number;
    title: string;
    subtitle: string | null;
    tagline: string | null;

    location: string;
    location_url: string | null;
    specifications: string | null;

    status: 'ongoing' | 'completed' | 'planned' | 'sold_out';
    slug: string;
    is_featured: boolean;

    image: string;
    cover_image: string;

    ideal_title: string;
    ideal_description: string | null;
    ideal_image: string;

    description: string | null;

    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    projects: Project[];
}>();

const loading = ref(true);

const activeFilter = ref<'all' | 'ongoing' | 'completed'>('all');

const filteredProjects = computed<Project[]>(() => {
    if (activeFilter.value === 'all') {
        return props.projects;
    }

    return props.projects.filter((project) => project.status?.toLowerCase() === activeFilter.value.toLowerCase());
});

const initObserver = () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        },
        {
            threshold: 0.1,
        },
    );

    document.querySelectorAll('.reveal-on-scroll').forEach((el) => {
        observer.observe(el);
    });
};

watch(activeFilter, async () => {
    await nextTick();
    initObserver();
});

onMounted(() => {
    setTimeout(() => {
        loading.value = false;

        setTimeout(() => {
            initObserver();
        }, 100);
    }, 2000);
});
</script>

<style scoped>
.reveal-on-scroll {
    opacity: 0;
    transform: translateY(30px);
    transition: all 1s ease-out;
}
.reveal-on-scroll.active {
    opacity: 1;
    transform: translateY(0);
}
</style>
