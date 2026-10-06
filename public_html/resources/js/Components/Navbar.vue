<template>
    <nav class="fixed top-0 z-50 w-full border-b border-white/10 bg-[#001221] shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">

                <div class="flex items-center">
                    <Link href="/" class="flex items-center">
                        <img
                            src="/images/white-logo.png"
                            alt="Sandalwood"
                            class="h-12 w-auto object-contain"
                        />
                    </Link>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <div class="flex items-center space-x-8">
                        <Link
                            v-for="item in navigationItems"
                            :key="item.path"
                            :href="item.path"
                            class="text-sm font-bold tracking-widest text-white transition-colors hover:text-gray-300"
                        >
                            {{ item.label }}
                        </Link>

                        <div class="group relative">
                            <Link href="/projects" class="inline-flex items-center gap-1 text-sm font-bold tracking-widest text-white transition-colors hover:text-gray-300" aria-haspopup="true">
                                PROJECTS
                                <svg class="h-4 w-4 transition-transform group-hover:rotate-180 group-focus-within:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.22 7.22a.75.75 0 0 1 1.06 0L10 10.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </Link>
                            <div class="invisible absolute right-0 top-full z-50 max-h-[70vh] w-[min(34rem,90vw)] overflow-y-auto border border-white/10 bg-[#071a2d] p-5 opacity-0 shadow-xl transition duration-200 group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">
                                <Link href="/projects" class="mb-4 inline-flex border-b border-white/15 pb-2 text-[11px] font-semibold tracking-[0.16em] text-white/65 uppercase transition hover:text-white">All Projects</Link>
                                <div class="grid grid-cols-2 gap-6">
                                    <div v-for="group in projectGroups" :key="group.title">
                                        <h2 class="mb-2 border-b border-white/10 pb-2 text-[10px] font-semibold tracking-[0.16em] text-[#d6b983] uppercase">{{ group.title }}</h2>
                                        <Link v-for="project in group.projects" :key="project.slug" :href="`/projects/${project.slug}`" class="block rounded-sm px-2 py-1.5 text-[13px] text-white/85 transition-colors hover:bg-white/5 hover:text-white">
                                            {{ project.title }}
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-5 border-l border-white/20 pl-8">

                        <button aria-label="Chat with us on WhatsApp" class="text-white hover:text-gray-300" @click="sendWhatsAppMessage">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </button>
                        <button
                            @click="openContactModal"
                            class="bg-[#001221] px-5 py-2.5 text-xs font-bold tracking-widest text-white uppercase transition-colors hover:bg-[#1a365d]"
                        >
                            Get in Touch
                        </button>
                    </div>
                </div>

                <button aria-label="Toggle navigation menu" @click="toggleMobileMenu" class="p-2 text-white md:hidden">
                    <svg v-if="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div v-if="isMobileMenuOpen" class="border-t border-white/10 bg-[#001221] pb-6 shadow-2xl md:hidden">
                <div class="px-2 pt-2 space-y-1">
                    <Link
                        v-for="item in navigationItems"
                        :key="item.path"
                        :href="item.path"
                        class="block rounded-md px-4 py-3 font-medium text-white hover:bg-white/5"
                        @click="closeMobileMenu"
                    >
                        {{ item.label }}
                    </Link>
                    <details class="group rounded-md px-4 py-2 text-white">
                        <summary class="cursor-pointer list-none py-2 font-medium marker:hidden">
                            <span class="flex items-center justify-between">Projects
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.22 7.22a.75.75 0 0 1 1.06 0L10 10.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </summary>
                        <Link href="/projects" class="block py-2 pl-3 text-sm font-semibold text-white/80" @click="closeMobileMenu">All Projects</Link>
                        <div v-for="group in projectGroups" :key="group.title" class="py-2 pl-3">
                            <h2 class="pb-1 text-[10px] font-semibold tracking-[0.16em] text-white/50 uppercase">{{ group.title }}</h2>
                            <Link v-for="project in group.projects" :key="project.slug" :href="`/projects/${project.slug}`" class="block py-1.5 text-sm text-white/85 hover:text-white" @click="closeMobileMenu">
                                {{ project.title }}
                            </Link>
                        </div>
                    </details>
                    <div class="pt-4 px-4">
                        <button
                            @click="openContactModalFromMobile"
                            class="block w-full bg-white py-3 text-center font-bold tracking-widest text-[#001221] uppercase"
                        >
                            Get in Touch
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="h-20"></div>
    <ContactModal v-model:show="showContactModal" @close="closeContactModal" />
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ContactModal from '@/Components/ContactModal.vue';

interface ProjectNavigationItem {
    title: string;
    slug: string;
    status: string;
}

const page = usePage<{ projectNavigation?: ProjectNavigationItem[] }>();
const projectGroups = computed(() => {
    const projects = page.props.projectNavigation ?? [];
    return [
        { title: 'Under Development', projects: projects.filter((project) => !['completed', 'sold_out'].includes(project.status.toLowerCase())) },
        { title: 'Completed', projects: projects.filter((project) => ['completed', 'sold_out'].includes(project.status.toLowerCase())) },
    ].filter((group) => group.projects.length > 0);
});

const navigationItems = [
    { path: '/', label: 'HOME' },
    { path: '/about', label: 'ABOUT US' },
    { path: '/contact', label: 'CONTACT' },
];

const isMobileMenuOpen = ref(false);
const toggleMobileMenu = () => isMobileMenuOpen.value = !isMobileMenuOpen.value;
const closeMobileMenu = () => isMobileMenuOpen.value = false;
const showContactModal = ref(false);
const whatsappNumber = "254725637456";
const openContactModal = () => {
    showContactModal.value = true;
};

const openContactModalFromMobile = () => {
    closeMobileMenu();
    showContactModal.value = true;
};

const closeContactModal = () => {
    showContactModal.value = false;
};

const sendWhatsAppMessage = () => {
    const url = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent('Hello, I\'m interested in your properties')}`;
    window.open(url, '_blank');
};

</script>
