<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="relative py-20 bg-gray-900 text-white transition-colors duration-300">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in-up">Terms of Service</h1>
                <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto animate-fade-in-up delay-200">
                    Guidelines for using our website and services
                </p>
            </div>
        </section>

        <!-- Content Section -->
        <section class="py-20 bg-white transition-colors duration-300">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="prose prose-lg max-w-none">
                    <div class="mb-12">
                        <p class="text-lg text-gray-600 mb-6">
                            Effective Date: {{ new Date().getFullYear() }}
                        </p>
                        <p class="text-gray-600">
                            Please read these Terms of Service carefully before using our website and services.
                        </p>
                    </div>

                    <div class="space-y-12">
                        <!-- Agreement -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">1. Agreement to Terms</h2>
                            <p class="text-gray-600">
                                By accessing and using Sandalwood Properties' website and services, you agree to be bound by these Terms of Service and our Privacy Policy. If you disagree with any part of these terms, you may not access our services.
                            </p>
                        </section>

                        <!-- Services -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">2. Our Services</h2>
                            <p class="text-gray-600 mb-4">
                                Sandalwood Properties provides real estate services including:
                            </p>
                            <ul class="text-gray-600 list-disc list-inside space-y-2">
                                <li>Property listings and information</li>
                                <li>Real estate consultation services</li>
                                <li>Property development information</li>
                                <li>Investment opportunity details</li>
                                <li>Customer support and inquiries</li>
                            </ul>
                        </section>

                        <!-- User Responsibilities -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">3. User Responsibilities</h2>
                            <p class="text-gray-600 mb-4">You agree to:</p>
                            <ul class="text-gray-600 list-disc list-inside space-y-2">
                                <li>Provide accurate and complete information</li>
                                <li>Maintain the security of your account</li>
                                <li>Use our services for lawful purposes only</li>
                                <li>Not engage in fraudulent activities</li>
                                <li>Respect intellectual property rights</li>
                                <li>Not interfere with website operations</li>
                            </ul>
                        </section>

                        <!-- Intellectual Property -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">4. Intellectual Property</h2>
                            <p class="text-gray-600 mb-4">
                                All content on this website, including text, graphics, logos, images, and software, is the property of Sandalwood Properties and is protected by copyright and intellectual property laws.
                            </p>
                            <p class="text-gray-600">
                                You may not reproduce, distribute, or create derivative works without our express written permission.
                            </p>
                        </section>

                        <!-- Property Information -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">5. Property Information</h2>
                            <p class="text-gray-600 mb-4">
                                While we strive to provide accurate property information:
                            </p>
                            <ul class="text-gray-600 list-disc list-inside space-y-2">
                                <li>Property details are subject to change without notice</li>
                                <li>Prices and availability may vary</li>
                                <li>Images are for illustrative purposes</li>
                                <li>We recommend verifying all details before making decisions</li>
                            </ul>
                        </section>

                        <!-- Limitation of Liability -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">6. Limitation of Liability</h2>
                            <p class="text-gray-600">
                                Sandalwood Properties shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use or inability to use our services, including but not limited to property investment decisions made based on website information.
                            </p>
                        </section>

                        <!-- Termination -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">7. Termination</h2>
                            <p class="text-gray-600">
                                We may terminate or suspend your access to our services immediately, without prior notice, for conduct that we believe violates these Terms of Service or is harmful to other users, us, or third parties.
                            </p>
                        </section>

                        <!-- Governing Law -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">8. Governing Law</h2>
                            <p class="text-gray-600">
                                These Terms shall be governed by and construed in accordance with the laws of Kenya, without regard to its conflict of law provisions.
                            </p>
                        </section>

                        <!-- Changes to Terms -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">9. Changes to Terms</h2>
                            <p class="text-gray-600">
                                We reserve the right to modify these terms at any time. We will notify users of any changes by updating the "Effective Date" at the top of this page. Your continued use of our services after changes constitutes acceptance of the new terms.
                            </p>
                        </section>

                        <!-- Contact - Updated to use shared data -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">10. Contact Information</h2>
                            <div class="bg-gray-50 rounded-lg p-6 space-y-3">
                                <p class="text-gray-900 font-semibold text-lg">Sandalwood Properties</p>

                                <!-- Address -->
                                <p class="text-gray-600">
                                    {{ $page.props.contact.address.full }}
                                </p>

                                <!-- Email -->
                                <p class="text-gray-600">
                                    <strong>General Inquiries:</strong>
                                    <a :href="`mailto:${$page.props.contact.emails.info}`" class="text-primary hover:text-primary/80 transition-colors duration-300 ml-1">
                                        {{ $page.props.contact.emails.info }}
                                    </a>
                                </p>



                                <!-- Phone -->
                                <p class="text-gray-600">
                                    <strong>Phone:</strong>
                                    <a :href="`tel:${$page.props.contact.phone_link}`" class="text-primary hover:text-primary/80 transition-colors duration-300 ml-1">
                                        {{ $page.props.contact.phone }}
                                    </a>
                                </p>
                            </div>

                            <!-- Business Hours Note -->
                            <div class="mt-6 bg-primary/5 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Response Time</h3>
                                <p class="text-gray-600">
                                    We aim to respond to all inquiries within 24-48 business hours. For urgent matters, please contact us by phone during business hours: Monday - Friday, 8:00 AM - 6:00 PM.
                                </p>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<style scoped>
.animate-fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.8s ease forwards;
}

.delay-200 {
    animation-delay: 0.2s;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
