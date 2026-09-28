<template>
    <div class="h-screen bg-gray-50 flex overflow-hidden">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col"
               :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full']">

            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-white flex-shrink-0">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600 rounded-lg p-2">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">{{ appName }}</h1>
                        <p class="text-xs text-gray-500">Admin Portal</p>
                    </div>
                </div>

                <!-- Mobile close button -->
                <button @click="toggleSidebar" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>


            <div class="flex-1 overflow-y-auto">
                <nav class="px-4 py-4 space-y-2">
                    <SidebarNavigation @navigate="closeSidebar" />
                </nav>
            </div>

            <!-- Sidebar Footer -->
            <div class="border-t border-gray-200 p-4 flex-shrink-0">
                <form @submit.prevent="logout">
                    <button type="submit" class="flex items-center space-x-3 w-full px-3 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition duration-200 group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div v-if="sidebarOpen" @click="toggleSidebar" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-40 lg:hidden transition-opacity duration-300"></div>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-gray-200 flex-shrink-0">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
                    <div class="flex items-center space-x-4">
                        <button @click="toggleSidebar" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-2">
                                <li v-for="(item, index) in breadcrumbs" :key="index">
                                    <div class="flex items-center">
                                        <span v-if="index > 0" class="mx-2 text-gray-400">/</span>
                                        <Link
                                            v-if="item.href"
                                            :href="item.href"
                                            class="text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-200"
                                            :class="{ 'text-gray-900': index === breadcrumbs.length - 1 }"
                                        >
                                            {{ item.label }}
                                        </Link>
                                        <span v-else class="text-sm font-medium text-gray-900">
                                            {{ item.label }}
                                        </span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition duration-200 relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-3.77-4.31 1 1 0 00-1.47-.93 7.97 7.97 0 005.01 6.01 1 1 0 001.23-.77z"></path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                                    {{ userInitials }}
                                </div>
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $page.props.auth.user?.name || 'Admin' }}
                                </p>
                                <p class="text-xs text-gray-500 capitalize">
                                    {{ $page.props.auth.user?.role || 'administrator' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">
                <div class="p-4 sm:p-6 lg:p-8">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            <slot name="header" />
                        </h2>
                        <p class="mt-1 text-sm text-gray-500" v-if="$slots.description">
                            <slot name="description" />
                        </p>

                        <slot />
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useSidebar } from '@/Composables/useSidebar'
import SidebarNavigation from '@/Components/Admin/SidebarNavigation.vue'
import { route } from 'ziggy-js';

interface BreadcrumbItemType {
    label: string
    href?: string
}

interface Props {
    breadcrumbs?: BreadcrumbItemType[]
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => []
})

const page = usePage()
const { sidebarOpen, toggleSidebar, closeSidebar } = useSidebar()

import { inject } from 'vue';

const appName = inject('appName');

const userInitials = computed(() => {
    const user = page.props.auth.user
    if (!user?.name) return 'A'

    return user.name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
        .slice(0, 2)
})

const form = useForm({})

const logout = () => {
    form.post('/admin/logout');
}
</script>
