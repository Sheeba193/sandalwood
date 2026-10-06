<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="bg-[#001221] py-14 text-white md:py-16">
            <div class="mx-auto max-w-6xl px-6 text-center md:px-10">
                <p class="font-montserrat mb-3 text-[10px] tracking-[0.2em] text-white/60 uppercase">Legal Information</p>
                <h1 class="font-cinzel mb-4 text-3xl tracking-wide text-white uppercase md:text-5xl">Terms of Service</h1>
                <p class="font-cormorant mx-auto max-w-3xl text-lg leading-relaxed text-white/75 md:text-xl">
                    Guidelines for using our website and services
                </p>
            </div>
        </section>

        <!-- Content Section -->
        <section class="bg-white py-12 md:py-16">
            <div class="mx-auto max-w-5xl px-6 md:px-10">
                <div class="legal-copy">
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
                            <div class="rounded-sm border border-gray-100 bg-gray-50 p-6 space-y-3">
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
                            <div class="legal-note mt-6 rounded-sm border border-[#e9e2d4] bg-[#faf8f4] p-6">
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
.font-montserrat {
    font-family: 'Montserrat', sans-serif;
}

.font-cinzel {
    font-family: 'Cinzel', serif;
}

.font-cormorant {
    font-family: 'Cormorant Garamond', serif;
}

.legal-copy > div:first-child {
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 2.5rem;
    padding-bottom: 1.25rem;
}

.legal-copy > div:first-child p {
    color: #64748b;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.7rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.legal-copy > div:last-child {
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}

.legal-copy h2 {
    color: #1a365d;
    font-family: 'Cinzel', serif;
    font-size: 1.35rem;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 0.85rem;
}

.legal-copy h3 {
    color: #1a365d;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.95rem;
    font-weight: 600;
    letter-spacing: 0.02em;
}

.legal-copy p,
.legal-copy li {
    color: #4b5563;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.15rem;
    line-height: 1.7;
}

.legal-copy ul {
    list-style-position: outside;
    margin-left: 1.2rem;
}

.legal-copy li::marker {
    color: #c9a96e;
}

.legal-copy a {
    color: #1a365d;
    font-weight: 600;
    text-decoration: underline;
    text-decoration-color: #c9a96e;
    text-underline-offset: 3px;
}

.legal-copy .bg-gray-50 {
    background-color: #f8fafc;
    border-left: 3px solid #c9a96e;
}

.legal-copy .legal-note {
    border-left: 3px solid #c9a96e;
}
</style>
