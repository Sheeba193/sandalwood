<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="bg-[#001221] py-14 text-white md:py-16">
            <div class="mx-auto max-w-6xl px-6 text-center md:px-10">
                <p class="font-montserrat mb-3 text-[10px] tracking-[0.2em] text-white/60 uppercase">Legal Information</p>
                <h1 class="font-cinzel mb-4 text-3xl tracking-wide text-white uppercase md:text-5xl">Privacy Policy</h1>
                <p class="font-cormorant mx-auto max-w-3xl text-lg leading-relaxed text-white/75 md:text-xl">
                    How we protect and manage your personal information
                </p>
            </div>
        </section>

        <!-- Content Section -->
        <section class="bg-white py-12 md:py-16">
            <div class="mx-auto max-w-5xl px-6 md:px-10">
                <div class="legal-copy">
                    <div class="mb-12">
                        <p class="text-lg text-gray-600 mb-6">
                            Last updated: {{ new Date().getFullYear() }}
                        </p>
                    </div>

                    <div class="space-y-12">
                        <!-- Introduction -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">1. Introduction</h2>
                            <p class="text-gray-600 mb-4">
                                Sandalwood Properties ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our services.
                            </p>
                            <p class="text-gray-600">
                                By using our website, you consent to the data practices described in this policy.
                            </p>
                        </section>

                        <!-- Information We Collect -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">2. Information We Collect</h2>
                            <div class="space-y-4">
                                <h3 class="text-xl font-semibold text-gray-900">Personal Information</h3>
                                <ul class="text-gray-600 list-disc list-inside space-y-2">
                                    <li>Name and contact details (email, phone number, address)</li>
                                    <li>Property preferences and requirements</li>
                                    <li>Communication preferences</li>
                                    <li>Payment information (when applicable)</li>
                                </ul>

                                <h3 class="text-xl font-semibold text-gray-900 mt-6">Automatically Collected Information</h3>
                                <ul class="text-gray-600 list-disc list-inside space-y-2">
                                    <li>IP address and browser type</li>
                                    <li>Pages visited and time spent on site</li>
                                    <li>Referring website information</li>
                                    <li>Device information</li>
                                </ul>
                            </div>
                        </section>

                        <!-- How We Use Your Information -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">3. How We Use Your Information</h2>
                            <ul class="text-gray-600 list-disc list-inside space-y-2">
                                <li>Provide and maintain our real estate services</li>
                                <li>Process your inquiries and property requests</li>
                                <li>Send property updates and marketing communications (with consent)</li>
                                <li>Improve our website and services</li>
                                <li>Comply with legal obligations</li>
                                <li>Protect against fraudulent activities</li>
                            </ul>
                        </section>

                        <!-- Data Sharing -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">4. Data Sharing and Disclosure</h2>
                            <p class="text-gray-600 mb-4">
                                We do not sell your personal information. We may share your information with:
                            </p>
                            <ul class="text-gray-600 list-disc list-inside space-y-2">
                                <li>Service providers who assist in our operations</li>
                                <li>Legal authorities when required by law</li>
                                <li>Professional advisors (lawyers, accountants)</li>
                                <li>In connection with business transfers or mergers</li>
                            </ul>
                        </section>

                        <!-- Data Security -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">5. Data Security</h2>
                            <p class="text-gray-600">
                                We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.
                            </p>
                        </section>

                        <!-- Your Rights -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">6. Your Rights</h2>
                            <p class="text-gray-600 mb-4">You have the right to:</p>
                            <ul class="text-gray-600 list-disc list-inside space-y-2">
                                <li>Access your personal information</li>
                                <li>Correct inaccurate data</li>
                                <li>Request deletion of your data</li>
                                <li>Object to processing of your data</li>
                                <li>Withdraw consent at any time</li>
                                <li>Data portability</li>
                            </ul>
                        </section>

                        <!-- Contact - Updated to use shared data -->
                        <section>
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">7. Contact Us</h2>
                            <p class="text-gray-600 mb-4">
                                If you have any questions about this Privacy Policy, please contact us:
                            </p>
                            <div class="rounded-sm border border-gray-100 bg-gray-50 p-6 space-y-2">
                                <p class="text-gray-600">
                                    <strong>Email:</strong>
                                    <a :href="`mailto:${$page.props.contact.emails.info}`" class="text-primary hover:text-primary/80 transition-colors duration-300 ml-1">
                                        {{ $page.props.contact.emails.info }}
                                    </a>
                                </p>
                                <p class="text-gray-600">
                                    <strong>Phone:</strong>
                                    <a :href="`tel:${$page.props.contact.phone_link}`" class="text-primary hover:text-primary/80 transition-colors duration-300 ml-1">
                                        {{ $page.props.contact.phone }}
                                    </a>
                                </p>
                                <p class="text-gray-600">
                                    <strong>Address:</strong>
                                    <span class="ml-1">{{ $page.props.contact.address.full }}</span>
                                </p>
                            </div>

                            <!-- Additional Privacy-Specific Contact -->
<!--                            <div class="mt-6 bg-primary/5 rounded-lg p-6">-->
<!--                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Data Protection Officer</h3>-->
<!--                                <p class="text-gray-600 mb-2">-->
<!--                                    For privacy-specific inquiries, you can also contact our Data Protection Officer:-->
<!--                                </p>-->
<!--                                <p class="text-gray-600">-->
<!--                                    <strong>Email:</strong>-->
<!--                                    <a :href="`mailto:dpo@sandalwoodproperties.co.ke`" class="text-primary hover:text-primary/80 transition-colors duration-300 ml-1">-->
<!--                                        dpo@sandalwoodproperties.co.ke-->
<!--                                    </a>-->
<!--                                </p>-->
<!--                            </div>-->
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
</style>
