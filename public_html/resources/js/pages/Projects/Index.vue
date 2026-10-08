<template>
    <AppLayout>
        <SandalWoodLoader v-if="loading" />

        <main v-else class="min-h-screen bg-white pt-20 pb-24">
            <section class="reveal mx-auto max-w-7xl px-6 py-4 md:px-12">
                <div class="mx-auto max-w-4xl">
                    <header class="mb-10 max-w-4xl">
                        <h3 class="font-cinzel mb-5 text-4xl tracking-widest text-[#001221] uppercase md:text-5xl">Sandalwood Projects</h3>
                        <p class="font-cormorant text-justify text-[18px] leading-relaxed text-gray-500">
                            A curated collection of exceptional properties that reflect our vision for refined living. Each project is thoughtfully
                            designed and meticulously crafted to harmonize elegance, functionality, and enduring value.
                        </p>
                    </header>

                    <nav class="project-filters mb-10 flex flex-wrap gap-3">
                        <button
                            @click="activeFilter = 'all'"
                            :aria-pressed="activeFilter === 'all'"
                            :class="activeFilter === 'all' ? 'bg-[#001221] text-white' : 'border border-gray-300 text-gray-600'"
                            class="font-montserrat rounded-full px-6 py-2 text-[11px] tracking-widest uppercase transition-all"
                        >
                            All Projects
                        </button>
                        <button
                            @click="activeFilter = 'ongoing'"
                            :aria-pressed="activeFilter === 'ongoing'"
                            :class="activeFilter === 'ongoing' ? 'bg-[#001221] text-white' : 'border border-gray-300 text-gray-600'"
                            class="rounded-full px-6 py-2 text-[11px] tracking-widest uppercase transition-all"
                        >
                            Under Construction
                        </button>
                        <button
                            @click="activeFilter = 'completed'"
                            :aria-pressed="activeFilter === 'completed'"
                            :class="activeFilter === 'completed' ? 'bg-[#001221] text-white' : 'border border-gray-300 text-gray-600'"
                            class="rounded-full px-6 py-2 text-[11px] tracking-widest uppercase transition-all"
                        >
                            Completed
                        </button>
                    </nav>

                    <div class="space-y-10">
                        <section
                            v-for="(project, index) in filteredProjects"
                            :key="project.id"
                            class="reveal-on-scroll motion-card grid grid-cols-1 items-center gap-4 sm:grid-cols-[minmax(0,2fr)_minmax(12rem,1fr)] sm:gap-6 lg:gap-10"
                            :style="{ '--reveal-delay': `${(index % 4) * 80}ms` }"
                        >
                            <div class="group/card relative aspect-[16/10] overflow-hidden bg-gray-100 sm:aspect-video">
                                <img
                                    :src="project.image"
                                    :alt="project.title"
                                    class="motion-card-image h-full w-full object-cover"
                                />
                            </div>

                            <div class="flex flex-col items-start gap-4 sm:gap-6">
                                <h2 class="font-cinzel text-xl tracking-[0.12em] text-[#001221] uppercase md:text-2xl">
                                    {{ project.title }}
                                </h2>
                                <Link
                                    :href="`/projects/${project.slug}`"
                                    class="motion-card-cta font-montserrat inline-flex min-h-10 items-center bg-[#001221] px-5 py-2 text-[10px] tracking-[0.15em] text-white uppercase transition-colors hover:bg-[#1a365d]"
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
    status: 'ongoing' | 'completed' | 'planned' | 'sold_out';
    slug: string;
    image: string;
    images?: string[];
}

const props = defineProps<{
    projects: Project[];
}>();

const referenceProjects: Project[] = [
    {
        id: 1,
        title: 'Sandalwood Loresho',
        status: 'ongoing',
        slug: 'sandalwood-loresho',
        image: '/images/loresho.jpg',
        images: ['/images/loresho.jpg', '/images/loresho1.jpeg', '/images/loresho2.jpg', '/images/loresho3.jpg', '/images/loresho4.jpg'],
    },
    { id: 2, title: 'Oak and Ivy', status: 'completed', slug: 'oak-and-ivy', image: '/images/IMG-20251113-WA0016.jpg' },
    { id: 3, title: 'The Colosseum Residences', status: 'completed', slug: 'the-colosseum-residences', image: '/images/IMG-20251113-WA0015.jpg' },
    { id: 4, title: 'The Haven', status: 'completed', slug: 'the-haven', image: '/images/IMG-20251113-WA0018.jpg' },
    { id: 5, title: 'Sandalwood Waterfront', status: 'completed', slug: 'sandalwood-waterfront', image: '/images/IMG-20251113-WA0025.jpg' },
    { id: 6, title: 'Sandalwood Kitisuru', status: 'completed', slug: 'sandalwood-kitisuru', image: '/images/IMG-20251113-WA0027.jpg' },
    { id: 7, title: 'Sandalwood Clyde Gardens', status: 'completed', slug: 'sandalwood-clyde-gardens', image: '/images/projects/sandalwood-clyde-gardens/clyde1.jpg' },
    { id: 8, title: 'Sandalwood Lenana Road', status: 'completed', slug: 'sandalwood-lenana-road', image: '/images/IMG-20251113-WA0024.jpg' },
    { id: 9, title: 'Sandalwood Riverside', status: 'completed', slug: 'sandalwood-riverside', image: '/images/IMG-20251113-WA0019.jpg' },
    { id: 10, title: 'Sandalwood Brookside', status: 'completed', slug: 'sandalwood-brookside', image: '/images/IMG-20251113-WA0026.jpg' },
    { id: 11, title: 'Sandalwood Othaya', status: 'completed', slug: 'sandalwood-othaya', image: '/images/IMG-20251113-WA0017.jpg' },
    { id: 12, title: 'The Convex', status: 'completed', slug: 'the-convex', image: '/images/IMG-20251113-WA0022.jpg' },
    { id: 13, title: 'Chilly Breezes', status: 'completed', slug: 'chilly-breezes', image: '/images/IMG-20251113-WA0020.jpg' },
    { id: 14, title: 'Silver Terraces', status: 'completed', slug: 'silver-terraces', image: '/images/IMG-20251113-WA0014.jpg' },
    { id: 15, title: 'Ivory Terraces', status: 'completed', slug: 'ivory-terraces', image: '/images/projects/ivory-terraces/3I9A0277.JPG' },
    {
        id: 16,
        title: 'Sandalwood Kyuna',
        status: 'ongoing',
        slug: 'sandalwood-kyuna',
        image: '/images/projects/sandalwood-kyuna/WhatsApp%20Image%202026-10-03%20at%2009.53.10%20(2).jpeg',
        images: ['/images/projects/sandalwood-kyuna/WhatsApp%20Image%202026-10-03%20at%2009.53.10%20(2).jpeg'],
    },
];

const projectImageSets: Record<string, string[]> = {
    'sandalwood-loresho': [
        '/images/projects/sandalwood-loresho/loresho.jpg',
        '/images/projects/sandalwood-loresho/loresho4.jpg',
        '/images/projects/sandalwood-loresho/loresho5.jpg',
        '/images/projects/sandalwood-loresho/IMG-20251113-WA0015.jpg',
        '/images/projects/sandalwood-loresho/IMG-20251113-WA0017.jpg',
        '/images/projects/sandalwood-loresho/IMG-20251113-WA0018.jpg',
        '/images/projects/sandalwood-loresho/IMG-20251113-WA0021.jpg',
        '/images/projects/sandalwood-loresho/IMG-20251113-WA0019.jpg',
        '/images/projects/sandalwood-loresho/IMG-20251113-WA0024.jpg',
        '/images/projects/sandalwood-loresho/IMG-20251113-WA0025.jpg',
    ],
    'oak-and-ivy': [
        '/images/projects/oak%26ivy/3I9A6381.JPG',
        '/images/projects/oak%26ivy/3I9A6652.JPG',
        '/images/projects/oak%26ivy/3I9A6814.jpg',
        '/images/projects/oak%26ivy/3I9A6704.jpg',
        '/images/projects/oak%26ivy/3I9A6622.JPG',
        '/images/projects/oak%26ivy/3I9A6896.jpg',
        '/images/projects/oak%26ivy/3I9A6986.jpg',
        '/images/projects/oak%26ivy/3I9A7034.jpg',
        '/images/projects/oak%26ivy/3I9A7128.JPG',
        '/images/projects/oak%26ivy/3I9A7045.JPG',
        '/images/projects/oak%26ivy/3I9A7162-2.JPG',
    ],
    'ivory-terraces': [
        '/images/projects/ivory-terraces/3I9A0277.JPG',
        '/images/projects/ivory-terraces/3I9A0189.JPG',
        '/images/projects/ivory-terraces/3I9A0207.JPG',
        '/images/projects/ivory-terraces/3I9A0258.JPG',
        '/images/projects/ivory-terraces/3I9A9866.JPG',
        '/images/projects/ivory-terraces/3I9A9883.JPG',
        '/images/projects/ivory-terraces/3I9A9930.JPG',
        '/images/projects/ivory-terraces/3I9A9890.JPG',
        '/images/projects/ivory-terraces/Ivory(2).jpeg',
    ],
    'the-colosseum-residences': [
        '/images/projects/the-colosseum-residences/3I9A7706.JPG',
        '/images/projects/the-colosseum-residences/3I9A7738.JPG',
        '/images/projects/the-colosseum-residences/3I9A7747.JPG',
        '/images/projects/the-colosseum-residences/3I9A7750.JPG',
        '/images/projects/the-colosseum-residences/3I9A7779.JPG',
        '/images/projects/the-colosseum-residences/3I9A7797.JPG',
        '/images/projects/the-colosseum-residences/3I9A7849.JPG',
        '/images/projects/the-colosseum-residences/3I9A7884.JPG',
        '/images/projects/the-colosseum-residences/3I9A7893.JPG',
        '/images/projects/the-colosseum-residences/3I9A7912.JPG',
    ],
    'the-haven': [
        '/images/projects/the-haven/3I9A7199.JPG',
        '/images/projects/the-haven/3I9A7206.JPG',
        '/images/projects/the-haven/3I9A7215.JPG',
        '/images/projects/the-haven/3I9A7217-2.JPG',
        '/images/projects/the-haven/3I9A7242.JPG',
        '/images/projects/the-haven/3I9A7266.JPG',
        '/images/projects/the-haven/3I9A7308.JPG',
        '/images/projects/the-haven/3I9A7317-2.JPG',
        '/images/projects/the-haven/3I9A7326.JPG',
    ],
    'sandalwood-waterfront': [
        '/images/projects/sandalwood-waterfront/3I9A8217.JPG',
        '/images/projects/sandalwood-waterfront/3I9A8242.JPG',
        '/images/projects/sandalwood-waterfront/3I9A8351.JPG',
        '/images/projects/sandalwood-waterfront/3I9A8371.JPG',
        '/images/projects/sandalwood-waterfront/3I9A8393.JPG',
        '/images/projects/sandalwood-waterfront/3I9A8407.JPG',
        '/images/projects/sandalwood-waterfront/3I9A8425.JPG',
        '/images/projects/sandalwood-waterfront/3I9A8548.JPG',
        '/images/projects/sandalwood-waterfront/3I9A8582.JPG',
        '/images/projects/sandalwood-waterfront/3I9A8628.JPG',
    ],
    'sandalwood-kitisuru': [
        '/images/projects/sandalwood-kitisuru/1.JPG',
        '/images/projects/sandalwood-kitisuru/2.JPG',
        '/images/projects/sandalwood-kitisuru/3.JPG',
        '/images/projects/sandalwood-kitisuru/4.JPG',
        '/images/projects/sandalwood-kitisuru/5.JPG',
        '/images/projects/sandalwood-kitisuru/6.JPG',
        '/images/projects/sandalwood-kitisuru/8.JPG',
        '/images/projects/sandalwood-kitisuru/11.JPG',
        '/images/projects/sandalwood-kitisuru/12.JPG',
        '/images/projects/sandalwood-kitisuru/28.JPG',
    ],
    'sandalwood-brookside': [
        '/images/projects/sandalwood-brookside/3I9A7539.JPG.jpeg',
        '/images/projects/sandalwood-brookside/3I9A7555.JPG.jpeg',
        '/images/projects/sandalwood-brookside/3I9A7558.JPG.jpeg',
        '/images/projects/sandalwood-brookside/3I9A7565.JPG.jpeg',
        '/images/projects/sandalwood-brookside/3I9A7574.JPG.jpeg',
        '/images/projects/sandalwood-brookside/3I9A7577.JPG.jpeg',
        '/images/projects/sandalwood-brookside/3I9A7580.JPG.jpeg',
        '/images/projects/sandalwood-brookside/3I9A7582.JPG.jpeg',
        '/images/projects/sandalwood-brookside/3I9A7594.JPG.jpeg',
        '/images/projects/sandalwood-brookside/3I9A7622.JPG.jpeg',
        '/images/projects/sandalwood-brookside/3I9A7660.JPG.jpeg',
    ],
    'sandalwood-othaya': [
        '/images/projects/sandalwood-othaya/3I9A8056-2.JPG',
        '/images/projects/sandalwood-othaya/3I9A8066.JPG',
        '/images/projects/sandalwood-othaya/3I9A8078.JPG',
        '/images/projects/sandalwood-othaya/3I9A8108.JPG',
        '/images/projects/sandalwood-othaya/3I9A8117-2.JPG',
        '/images/projects/sandalwood-othaya/3I9A8128.JPG',
        '/images/projects/sandalwood-othaya/3I9A8148.JPG',
        '/images/projects/sandalwood-othaya/3I9A8157-2.JPG',
        '/images/projects/sandalwood-othaya/3I9A8204.JPG',
    ],
    'sandalwood-riverside': [
        '/images/projects/sandalwood-riverside/3I9A0422.JPG',
        '/images/projects/sandalwood-riverside/3I9A0429.JPG',
        '/images/projects/sandalwood-riverside/3I9A0436.JPG',
        '/images/projects/sandalwood-riverside/3I9A0448.JPG',
        '/images/projects/sandalwood-riverside/3I9A0463.JPG',
        '/images/projects/sandalwood-riverside/3I9A0475.JPG',
        '/images/projects/sandalwood-riverside/3I9A0478.JPG',
        '/images/projects/sandalwood-riverside/3I9A0485.JPG',
        '/images/projects/sandalwood-riverside/3I9A0486.JPG',
        '/images/projects/sandalwood-riverside/3I9A0491.JPG',
    ],
    'the-convex': [
        '/images/projects/the-convex/3I9A0304.JPG',
        '/images/projects/the-convex/2.png',
        '/images/projects/the-convex/3I9A0315.JPG',
        '/images/projects/the-convex/3I9A0324.JPG',
        '/images/projects/the-convex/3I9A0335.JPG',
        '/images/projects/the-convex/3I9A0340.JPG',
        '/images/projects/the-convex/3I9A0369.JPG',
        '/images/projects/the-convex/3I9A0403.JPG',
        '/images/projects/the-convex/3I9A0407.JPG',
    ],
    'chilly-breezes': [
        '/images/projects/chilly-breezes/3I9A9604.JPG',
        '/images/projects/chilly-breezes/3I9A9624.JPG',
        '/images/projects/chilly-breezes/3I9A9652.JPG',
        '/images/projects/chilly-breezes/3I9A9691.JPG',
        '/images/projects/chilly-breezes/3I9A9723.JPG',
        '/images/projects/chilly-breezes/3I9A9754.JPG',
        '/images/projects/chilly-breezes/3I9A9764.JPG',
        '/images/projects/chilly-breezes/3I9A9792.JPG',
    ],
    'silver-terraces': [
        '/images/projects/silver-terraces/3I9A0024.JPG',
        '/images/projects/silver-terraces/3I9A0027.JPG',
        '/images/projects/silver-terraces/3I9A0030.JPG',
        '/images/projects/silver-terraces/3I9A0049.JPG',
        '/images/projects/silver-terraces/3I9A0069.JPG',
        '/images/projects/silver-terraces/3I9A0089.JPG',
        '/images/projects/silver-terraces/3I9A0102.JPG',
        '/images/projects/silver-terraces/3I9A0128.JPG',
    ],
};

const withProjectImages = (project: Project): Project => {
    const images = project.slug === 'sandalwood-loresho'
        ? projectImageSets[project.slug]
        : project.images?.length ? project.images : projectImageSets[project.slug];
    return images?.length ? { ...project, image: images[0], images } : project;
};

const projectsToDisplay = computed(() => {
    const projects = props.projects.length > 0 ? [...props.projects] : [...referenceProjects];
    const ivoryTerraces = referenceProjects.find((project) => project.slug === 'ivory-terraces');

    if (ivoryTerraces && !projects.some((project) => project.slug === ivoryTerraces.slug)) {
        projects.push(ivoryTerraces);
    }

    return projects
        .filter((project) => project.images?.length || projectImageSets[project.slug]?.length)
        .map(withProjectImages);
});

const loading = ref(true);

const activeFilter = ref<'all' | 'ongoing' | 'completed'>('all');
const filteredProjects = computed<Project[]>(() => {
    if (activeFilter.value === 'all') {
        return projectsToDisplay.value;
    }

    return projectsToDisplay.value.filter((project) => project.status?.toLowerCase() === activeFilter.value.toLowerCase());
});

const initObserver = () => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.querySelectorAll('.reveal-on-scroll').forEach((el) => el.classList.add('active'));
        return;
    }

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
    transition: opacity 650ms cubic-bezier(0.22, 1, 0.36, 1) var(--reveal-delay, 0ms), transform 650ms cubic-bezier(0.22, 1, 0.36, 1) var(--reveal-delay, 0ms);
}
.reveal-on-scroll.active {
    opacity: 1;
    transform: translateY(0);
}
@media (prefers-reduced-motion: reduce) {
    .reveal-on-scroll { opacity: 1; transform: none; transition: none; }
}
.project-filters button[aria-pressed="true"],
.project-filters button[aria-pressed="true"]:hover,
.project-filters button[aria-pressed="true"]:active {
    background-color: #001221 !important;
    color: #fff !important;
}
.project-filters button[aria-pressed="false"],
.project-filters button[aria-pressed="false"]:hover,
.project-filters button[aria-pressed="false"]:active {
    background-color: #fff !important;
    color: #4b5563 !important;
}
</style>
