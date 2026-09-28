<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="relative py-20 bg-gray-900 dark:bg-gray-800 text-white transition-colors duration-300">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in-up">Sitemap</h1>
                <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto animate-fade-in-up delay-200">
                    Navigate our website with ease
                </p>
            </div>
        </section>

        <!-- Sitemap Content -->
        <section class="py-20 bg-white dark:bg-gray-900 transition-colors duration-300">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Main Pages -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-primary">Main Pages</h2>
                        <ul class="space-y-3">
                            <li>
                                <Link href="/" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary/80 transition-colors duration-300 flex items-center">
                                    <svg class="w-4 h-4 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Home
                                </Link>
                            </li>
                            <li>
                                <Link href="/about" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary/80 transition-colors duration-300 flex items-center">
                                    <svg class="w-4 h-4 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    About Us
                                </Link>
                            </li>
                            <li>
                                <Link href="/projects" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary/80 transition-colors duration-300 flex items-center">
                                    <svg class="w-4 h-4 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    All Projects
                                </Link>
                            </li>
                            <li>
                                <Link href="/contact" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary/80 transition-colors duration-300 flex items-center">
                                    <svg class="w-4 h-4 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    Contact Us
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Projects -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-primary">Our Projects</h2>
                        <ul class="space-y-3">
                            <li v-for="project in projects" :key="project.slug">
                                <Link :href="`/projects/${project.slug}`" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary/80 transition-colors duration-300 flex items-center">
                                    <svg class="w-4 h-4 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    {{ project.title }}
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Legal & Support -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-primary">Legal & Support</h2>
                        <ul class="space-y-3">
                            <li>
                                <Link href="/privacy-policy" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary/80 transition-colors duration-300 flex items-center">
                                    <svg class="w-4 h-4 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Privacy Policy
                                </Link>
                            </li>
                            <li>
                                <Link href="/terms-of-service" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary/80 transition-colors duration-300 flex items-center">
                                    <svg class="w-4 h-4 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Terms of Service
                                </Link>
                            </li>
                            <li>
                                <Link href="/sitemap" class="text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary/80 transition-colors duration-300 flex items-center">
                                    <svg class="w-4 h-4 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                    Sitemap
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="mt-16 bg-primary/5 dark:bg-primary/10 rounded-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Website Overview</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div>
                            <div class="text-3xl font-bold text-primary dark:text-primary/90">{{ stats.totalPages }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Total Pages</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-primary dark:text-primary/90">{{ stats.projects }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Projects</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-primary dark:text-primary/90">{{ stats.categories }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Categories</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-primary dark:text-primary/90">{{ stats.lastUpdated }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Last Updated</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

// Get current year dynamically
const currentYear = new Date().getFullYear();

const projects = [
    { title: 'Sandalwood Residences', slug: 'sandalwood-residences' },
    { title: 'Sandalwood Loresho', slug: 'sandalwood-loresho' },
    { title: 'Sandalwood Beach Villas', slug: 'sandalwood-beach-villas' }
];

const stats = {
    totalPages: 8,
    projects: 15,
    categories: 4,
    lastUpdated: currentYear // This will now always show the current year
};
</script>
