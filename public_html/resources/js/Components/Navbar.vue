<template>
    <nav class="fixed top-0 z-50 w-full bg-[#001221] border-b border-white/10 shadow-lg">
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
                        <template v-for="item in navigationItems" :key="item.path">
                            <Link
                                :href="item.path"
                                class="text-sm font-bold tracking-widest text-white hover:text-gray-300 transition-colors"
                            >
                                {{ item.label }}
                            </Link>
                        </template>
                    </div>

                    <div class="flex items-center space-x-5 border-l border-white/20 pl-8">

                        <button class="text-white hover:text-gray-300" @click="sendWhatsAppMessage">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </button>
                        <button
                            @click="openContactModal"
                            class="bg-white text-[#001221] px-5 py-2.5 text-xs font-bold tracking-widest hover:bg-gray-200 transition-colors uppercase"
                        >
                            Get in Touch
                        </button>
                    </div>
                </div>

                <button @click="toggleMobileMenu" class="md:hidden text-white p-2">
                    <svg v-if="!isMobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div v-if="isMobileMenuOpen" class="md:hidden bg-[#001221] border-t border-white/10 pb-6 shadow-2xl">
                <div class="px-2 pt-2 space-y-1">
                    <template v-for="item in navigationItems" :key="item.path">
                        <Link
                            :href="item.path"
                            class="block px-4 py-3 text-white font-medium hover:bg-white/5 rounded-md"
                            @click="closeMobileMenu"
                        >
                            {{ item.label }}
                        </Link>
                    </template>
                    <div class="pt-4 px-4">
                        <button
                            @click="openContactModalFromMobile"
                            class="block w-full text-center bg-white text-[#001221] py-3 font-bold uppercase tracking-widest"
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
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import ContactModal from '@/Components/ContactModal.vue';

const navigationItems = [
    { path: '/', label: 'HOME' },
    { path: '/about', label: 'ABOUT US' },
    { path: '/projects', label: 'PROJECTS' }
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
