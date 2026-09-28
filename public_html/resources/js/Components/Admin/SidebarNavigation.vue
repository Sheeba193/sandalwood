<template>
    <div class="space-y-2">
        <Link
            href="/admin/dashboard"
            @click="handleNavigation"
            class="group flex items-center space-x-3 rounded-lg px-3 py-2 text-sm font-medium transition duration-200"
            :class="[
                $page.url === '/admin/dashboard'
                    ? 'border border-blue-200 bg-blue-50 text-blue-700'
                    : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900',
            ]"
        >
            <Home class="h-5 w-5" />
            <span>Dashboard</span>
        </Link>
        <Link
            href="/admin/projects"
            @click="handleNavigation"
            class="group flex items-center space-x-3 rounded-lg px-3 py-2 text-sm font-medium transition duration-200"
            :class="[
                $page.url === '/admin/projects'
                    ? 'border border-blue-200 bg-blue-50 text-blue-700'
                    : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900',
            ]"
        >
            <FileText class="h-5 w-5" />
            <span>Projects</span>
        </Link>
        <Link
            href="/admin/amenities"
            @click="handleNavigation"
            class="group flex items-center space-x-3 rounded-lg px-3 py-2 text-sm font-medium transition duration-200"
            :class="[
                $page.url === '/admin/amenities'
                    ? 'border border-blue-200 bg-blue-50 text-blue-700'
                    : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900',
            ]"
        >
            <LucideBrainCog class="h-5 w-5" />
            <span>Amenities</span>
        </Link>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

import { Home, FileText, LucideBrainCog } from 'lucide-vue-next';

const emit = defineEmits(['navigate']);

const handleNavigation = () => {
    emit('navigate');
};
</script>
