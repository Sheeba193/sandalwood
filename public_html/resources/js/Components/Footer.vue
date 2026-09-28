<template>
    <footer class="bg-gray-50 border-t border-gray-200 text-gray-700 relative font-cormorant">
        <!-- Main Footer Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="mb-6">
                        <img
                            src="/images/logo.png"
                            alt="Sandalwood Properties"
                            class="w-100 object-contain font-cinzel text-4xl md:text-5xl font-bold tracking-wide bg-gradient-to-r from-amber-700 to-amber-500 bg-clip-text text-transparent"
                        />
                    </div>
                    <p class="text-gray-600 mb-6 text-lg leading-relaxed max-w-md">
                        Building dreams, shaping communities, and creating lasting value in Kenya's real estate landscape since 2003.
                    </p>
                    <div class="flex space-x-4">
                        <!-- Facebook -->
                        <a :href="$page.props.contact?.social?.facebook || '#'" target="_blank" rel="noopener noreferrer"
                           class="text-gray-500 hover:text-primary transition-colors duration-300">
                            <span class="sr-only">Facebook</span>
                            <FontAwesomeIcon :icon="['fab', 'facebook']" class="w-6 h-6" />
                        </a>

                        <!-- Twitter/X -->
                        <a :href="$page.props.contact?.social?.twitter || '#'" target="_blank" rel="noopener noreferrer"
                           class="text-gray-500 hover:text-primary transition-colors duration-300">
                            <span class="sr-only">X (Twitter)</span>
                            <FontAwesomeIcon :icon="['fab', 'x-twitter']" class="w-6 h-6" />
                        </a>

                        <!-- Instagram -->
                        <a :href="$page.props.contact?.social?.instagram || '#'" target="_blank" rel="noopener noreferrer"
                           class="text-gray-500 hover:text-primary transition-colors duration-300">
                            <span class="sr-only">Instagram</span>
                            <FontAwesomeIcon :icon="['fab', 'instagram']" class="w-6 h-6" />
                        </a>

                        <!-- LinkedIn -->
                        <a :href="$page.props.contact?.social?.linkedin || '#'" target="_blank" rel="noopener noreferrer"
                           class="text-gray-500 hover:text-primary transition-colors duration-300">
                            <span class="sr-only">LinkedIn</span>
                            <FontAwesomeIcon :icon="['fab', 'linkedin']" class="w-5 h-5" />
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-6 text-primary font-cinzel">Quick Links</h3>
                    <ul class="space-y-3">
                        <li>
                            <Link href="/" class="text-gray-600 hover:text-primary transition-colors duration-300">
                                Home
                            </Link>
                        </li>
                        <li>
                            <Link href="/about" class="text-gray-600 hover:text-primary transition-colors duration-300">
                                About Us
                            </Link>
                        </li>
                        <li>
                            <Link href="/projects" class="text-gray-600 hover:text-primary transition-colors duration-300">
                                Projects
                            </Link>
                        </li>
                        <li>
                            <Link href="/contact" class="text-gray-600 hover:text-primary transition-colors duration-300">
                                Contact
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-6 text-primary font-cinzel">Contact Us</h3>
                    <div class="space-y-4">
                        <!-- Address -->
                        <div class="flex items-start">
                            <MapPinIcon class="w-5 h-5 text-primary mt-1 mr-3 flex-shrink-0" />
                            <span class="text-gray-600">
                                {{ $page.props.contact?.address?.full || 'Westlands Road, The Promenade, 4th Floor, Nairobi, Kenya' }}
                            </span>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-center">
                            <PhoneIcon class="w-5 h-5 text-primary mr-3 flex-shrink-0" />
                            <a :href="`tel:${$page.props.contact?.phone_link || '+254700123456'}`"
                               class="text-gray-600 hover:text-primary transition-colors duration-300">
                                {{ $page.props.contact?.phone || '+254 700 123 456' }}
                            </a>
                        </div>

                        <!-- Email -->
                        <div class="flex items-center">
                            <EnvelopeIcon class="w-5 h-5 text-primary mr-3 flex-shrink-0" />
                            <a :href="`mailto:${$page.props.contact?.emails?.info || 'info@sandalwood.co.ke'}`"
                               class="text-gray-600 hover:text-primary transition-colors duration-300">
                                {{ $page.props.contact?.emails?.info || 'info@sandalwood.co.ke' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-500 text-sm mb-4 md:mb-0 font-cormorant">
                        &copy; {{ new Date().getFullYear() }} Sandalwood Properties. All rights reserved.
                    </div>
                    <div class="flex space-x-6 text-sm text-gray-500">
                        <Link href="/privacy-policy" class="hover:text-primary transition-colors duration-300">Privacy Policy</Link>
                        <Link href="/terms-of-service" class="hover:text-primary transition-colors duration-300">Terms of Service</Link>
                        <Link href="/sitemap" class="hover:text-primary transition-colors duration-300">Sitemap</Link>
                    </div>
                </div>
            </div>
        </div>

        <WhatsAppFloat />
        <AIChatbot />
    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AIChatbot from './AIChatbot.vue';
import WhatsAppFloat from './WhatsAppFloat.vue';
import { MapPinIcon, PhoneIcon, EnvelopeIcon } from '@heroicons/vue/24/outline';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fab } from '@fortawesome/free-brands-svg-icons';

// Add Font Awesome brand icons to the library
library.add(fab);
</script>

<style scoped>
/* Font definitions using Cinzel and Cormorant Garamond */
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap');

.font-cinzel {
    font-family: 'Cinzel', 'Times New Roman', serif;
}

.font-cormorant {
    font-family: 'Cormorant Garamond', 'Georgia', serif;
}

.text-primary {
    color: #b8860b;
}

.hover\:text-primary:hover {
    color: #b8860b !important;
}
</style>
