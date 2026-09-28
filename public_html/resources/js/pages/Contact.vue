<template>
    <AppLayout>
        <!-- Toast Notifications Container -->
        <!--        <Toast position="top-right" />-->


<!--        &lt;!&ndash; Hero Section &ndash;&gt;-->
<!--        <section class="relative py-10 bg-gray-900 text-white transition-colors duration-300">-->
<!--            <div class="absolute inset-0 bg-black/50"></div>-->
<!--            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">-->
<!--                <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in-up">Contact Us</h1>-->
<!--                <img-->
<!--                    src="/images/logo.png"-->
<!--                    alt="Sandalwood"-->
<!--                    class="h-12 w-auto "-->
<!--                />-->
<!--                <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto animate-fade-in-up delay-200">-->
<!--                    Get in touch with our team to discuss your real estate needs-->
<!--                </p>-->
<!--            </div>-->
<!--        </section>-->
        <section class="py-16 bg-white">
            <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Form Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex gap-6 ">
                            <img
                                src="/images/logo_cropped.png"
                                alt="Sandalwood"
                                class="h-12  w-auto object-contain"
                            />
                            <h2 class="text-2xl pl-5 font-bold text-center text-gray-900 mb-6">

                                GET IN TOUCH
                            </h2>
                        </div>

                        <!-- Form -->
                        <form @submit.prevent="submitForm">
                            <!-- Full Name -->
                            <div class="mb-5">
                                <label class="block text-gray-800 font-medium text-sm mb-1">
                                    FULL NAME <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    v-model="form.fullName"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none  focus:ring-1 "
                                    placeholder="Enter your full name"
                                >
                            </div>

                            <!-- Email Address -->
                            <div class="mb-5">
                                <label class="block text-gray-800 font-medium text-sm mb-1">
                                    EMAIL ADDRESS <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    v-model="form.email"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none  focus:ring-1 "
                                    placeholder="Enter your Email"
                                >
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-5">
                                <label class="block text-gray-800 font-medium text-sm mb-1">
                                    PHONE NUMBER <span class="text-red-500">*</span>
                                </label>
                                <div class="flex">
                                    <div class="px-3 py-2 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md text-gray-700 text-sm">
                                        +254
                                    </div>
                                    <input
                                        type="tel"
                                        v-model="form.phone"
                                        required
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none"
                                        placeholder="Enter your phone number"
                                    >
                                </div>
                            </div>

                            <!-- Keep me updated checkbox -->
                            <div class="mb-6">
                                <label class="flex items-center">
                                    <input
                                        type="checkbox"
                                        v-model="form.keepUpdated"
                                        class="w-4 h-4 text-[#001221] bg-white border-gray-300 rounded focus:ring-[#001221]"
                                    >
                                    <span class="ml-2 text-gray-700 text-sm">
                                    Keep me updated on news and offers
                                </span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                :disabled="submitting"
                                class="w-full bg-[#001221] text-white font-medium py-2 px-4 rounded-md transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span v-if="submitting">SUBMITTING...</span>
                                <span v-else>SUBMIT</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

<!--        &lt;!&ndash; Testimonials Section &ndash;&gt;-->
<!--        <section class="py-20 bg-gray-50 transition-colors duration-300">-->
<!--            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">-->
<!--                <div class="text-center mb-16">-->
<!--                    <h2 class="text-4xl font-bold text-gray-900 mb-4">What Our Clients Say</h2>-->
<!--                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">-->
<!--                        Experience the Sandalwood difference through the words of our satisfied clients.-->
<!--                    </p>-->
<!--                </div>-->

<!--                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">-->
<!--                    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 transition-colors duration-300" v-for="testimonial in testimonials" :key="testimonial.id">-->
<!--                        &lt;!&ndash; Star Rating &ndash;&gt;-->
<!--                        <div class="flex items-center mb-4">-->
<!--                            <div class="flex text-amber-400 mr-3">-->
<!--                                &lt;!&ndash; Full stars &ndash;&gt;-->
<!--                                <span v-for="star in Math.floor(testimonial.rating)" :key="'full-'+star" class="text-lg">★</span>-->

<!--                                &lt;!&ndash; Partial star for decimal part &ndash;&gt;-->
<!--                                <span v-if="testimonial.rating % 1 !== 0" class="text-lg relative">-->
<!--                                    <span class="text-gray-300">★</span>-->
<!--                                    <span class="absolute top-0 left-0 overflow-hidden" :style="{ width: (testimonial.rating % 1 * 100) + '%' }">-->
<!--                                        <span class="text-amber-400">★</span>-->
<!--                                    </span>-->
<!--                                </span>-->

<!--                                &lt;!&ndash; Empty stars to make total of 5 &ndash;&gt;-->
<!--                                <span v-for="star in (5 - Math.ceil(testimonial.rating))" :key="'empty-'+star" class="text-lg text-gray-300">★</span>-->
<!--                            </div>-->
<!--                            <span class="text-2xl font-bold text-gray-900">{{ testimonial.rating }}</span>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Testimonial Text &ndash;&gt;-->
<!--                        <p class="text-gray-600 mb-6 leading-relaxed">-->
<!--                            "{{ testimonial.content }}"-->
<!--                        </p>-->

<!--                        &lt;!&ndash; Client Info &ndash;&gt;-->
<!--                        <div class="flex items-center">-->
<!--                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center mr-4">-->
<!--                                <span class="text-primary font-bold text-sm">{{ testimonial.initials }}</span>-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <h4 class="font-semibold text-gray-900 text-lg">{{ testimonial.name }}</h4>-->
<!--                                <div class="flex flex-col space-y-1 mt-1">-->
<!--                                    <span class="text-gray-500 text-sm flex items-center">-->
<!--                                        <StarIcon class="w-4 h-4 mr-1 text-gray-500" />-->
<!--                                        {{ testimonial.role }}-->
<!--                                    </span>-->
<!--                                    <span class="text-green-600 text-sm flex items-center font-medium">-->
<!--                                        <CheckBadgeIcon class="w-4 h-4 mr-1 text-green-600" />-->
<!--                                        Verified Client-->
<!--                                    </span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->

<!--        &lt;!&ndash; Contact Section &ndash;&gt;-->
<!--        <section class="py-20 bg-white transition-colors duration-300">-->
<!--            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">-->
<!--                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">-->
<!--                    &lt;!&ndash; Contact Form &ndash;&gt;-->
<!--                    <div>-->
<!--                        <h2 class="text-3xl font-bold text-gray-900 mb-8">Send us a Message</h2>-->

<!--                        <form @submit.prevent="submitForm" class="space-y-6">-->
<!--                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">-->
<!--                                <div>-->
<!--                                    <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">-->
<!--                                        First Name *-->
<!--                                    </label>-->
<!--                                    <input-->
<!--                                        type="text"-->
<!--                                        id="firstName"-->
<!--                                        v-model="form.firstName"-->
<!--                                        :class="{'border-red-300': form.errors.firstName}"-->
<!--                                        required-->
<!--                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300"-->
<!--                                        placeholder="Enter your first name"-->
<!--                                    >-->
<!--                                    <div v-if="form.errors.firstName" class="text-red-500 text-sm mt-1 animate-fade-in">-->
<!--                                        {{ form.errors.firstName }}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div>-->
<!--                                    <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">-->
<!--                                        Last Name *-->
<!--                                    </label>-->
<!--                                    <input-->
<!--                                        type="text"-->
<!--                                        id="lastName"-->
<!--                                        v-model="form.lastName"-->
<!--                                        :class="{'border-red-300': form.errors.lastName}"-->
<!--                                        required-->
<!--                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300"-->
<!--                                        placeholder="Enter your last name"-->
<!--                                    >-->
<!--                                    <div v-if="form.errors.lastName" class="text-red-500 text-sm mt-1 animate-fade-in">-->
<!--                                        {{ form.errors.lastName }}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">-->
<!--                                <div>-->
<!--                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">-->
<!--                                        Email Address *-->
<!--                                    </label>-->
<!--                                    <input-->
<!--                                        type="email"-->
<!--                                        id="email"-->
<!--                                        v-model="form.email"-->
<!--                                        :class="{'border-red-300': form.errors.email}"-->
<!--                                        required-->
<!--                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300"-->
<!--                                        placeholder="Enter your email"-->
<!--                                    >-->
<!--                                    <div v-if="form.errors.email" class="text-red-500 text-sm mt-1 animate-fade-in">-->
<!--                                        {{ form.errors.email }}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div>-->
<!--                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">-->
<!--                                        Phone Number *-->
<!--                                    </label>-->
<!--                                    <input-->
<!--                                        type="tel"-->
<!--                                        id="phone"-->
<!--                                        v-model="form.phone"-->
<!--                                        :class="{'border-red-300': form.errors.phone}"-->
<!--                                        required-->
<!--                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300"-->
<!--                                        placeholder="Enter your phone number"-->
<!--                                    >-->
<!--                                    <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1 animate-fade-in">-->
<!--                                        {{ form.errors.phone }}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div>-->
<!--                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">-->
<!--                                    Subject *-->
<!--                                </label>-->
<!--                                <select-->
<!--                                    id="subject"-->
<!--                                    v-model="form.subject"-->
<!--                                    :class="{'border-red-300': form.errors.subject}"-->
<!--                                    required-->
<!--                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300"-->
<!--                                >-->
<!--                                    <option value="">Select a subject</option>-->
<!--                                    <option value="general-inquiry">General Inquiry</option>-->
<!--                                    <option value="property-viewing">Property Viewing</option>-->
<!--                                    <option value="investment-opportunity">Investment Opportunity</option>-->
<!--                                    <option value="partnership">Partnership</option>-->
<!--                                    <option value="careers">Careers</option>-->
<!--                                    <option value="other">Other</option>-->
<!--                                </select>-->
<!--                                <div v-if="form.errors.subject" class="text-red-500 text-sm mt-1 animate-fade-in">-->
<!--                                    {{ form.errors.subject }}-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div>-->
<!--                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">-->
<!--                                    Message *-->
<!--                                </label>-->
<!--                                <textarea-->
<!--                                    id="message"-->
<!--                                    v-model="form.message"-->
<!--                                    :class="{'border-red-300': form.errors.message}"-->
<!--                                    required-->
<!--                                    rows="6"-->
<!--                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300"-->
<!--                                    placeholder="Tell us about your inquiry..."-->
<!--                                ></textarea>-->
<!--                                <div v-if="form.errors.message" class="text-red-500 text-sm mt-1 animate-fade-in">-->
<!--                                    {{ form.errors.message }}-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <button-->
<!--                                type="submit"-->
<!--                                :disabled="form.processing"-->
<!--                                class="w-full bg-primary hover:bg-primary/80 text-white font-bold py-4 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"-->
<!--                            >-->
<!--                                <span v-if="form.processing" class="flex items-center justify-center">-->
<!--                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">-->
<!--                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>-->
<!--                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>-->
<!--                                    </svg>-->
<!--                                    Sending...-->
<!--                                </span>-->
<!--                                <span v-else class="flex items-center justify-center">-->
<!--                                    <EnvelopeIcon class="w-5 h-5 mr-2 text-white" />-->
<!--                                    Send Message-->
<!--                                </span>-->
<!--                            </button>-->
<!--                        </form>-->
<!--                    </div>-->

<!--                    &lt;!&ndash; Contact Information - Updated to use shared data &ndash;&gt;-->
<!--                    <div class="lg:pl-12">-->
<!--                        <h2 class="text-3xl font-bold text-gray-900 mb-8">Get in Touch</h2>-->

<!--                        &lt;!&ndash; Contact Details &ndash;&gt;-->
<!--                        <div class="space-y-8">-->
<!--                            &lt;!&ndash; Phone &ndash;&gt;-->
<!--                            <div class="flex items-start group">-->
<!--                                <div class="flex-shrink-0">-->
<!--                                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors duration-300">-->
<!--                                        <PhoneIcon class="w-6 h-6 text-primary" />-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="ml-4">-->
<!--                                    <h3 class="text-lg font-semibold text-gray-900">Phone</h3>-->
<!--                                    <p class="text-gray-600">-->
<!--                                        <a :href="`tel:${$page.props.contact.phone_link}`" class="hover:text-primary transition-colors duration-300">-->
<!--                                            {{ $page.props.contact.phone }}-->
<!--                                        </a>-->
<!--                                    </p>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            &lt;!&ndash; Email &ndash;&gt;-->
<!--                            <div class="flex items-start group">-->
<!--                                <div class="flex-shrink-0">-->
<!--                                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors duration-300">-->
<!--                                        <EnvelopeIcon class="w-6 h-6 text-primary" />-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="ml-4">-->
<!--                                    <h3 class="text-lg font-semibold text-gray-900">Email</h3>-->
<!--                                    <p class="text-gray-600 mt-1">-->
<!--                                        <a :href="`mailto:${$page.props.contact.emails.info}`" class="hover:text-primary transition-colors duration-300">-->
<!--                                            {{ $page.props.contact.emails.info }}-->
<!--                                        </a>-->
<!--                                    </p>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            &lt;!&ndash; Address &ndash;&gt;-->
<!--                            <div class="flex items-start group">-->
<!--                                <div class="flex-shrink-0">-->
<!--                                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors duration-300">-->
<!--                                        <MapPinIcon class="w-6 h-6 text-primary" />-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="ml-4">-->
<!--                                    <h3 class="text-lg font-semibold text-gray-900">Office Address</h3>-->
<!--                                    <p class="text-gray-600 mt-1">{{ $page.props.contact.address.full }}</p>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            &lt;!&ndash; Hours &ndash;&gt;-->
<!--                            <div class="flex items-start group">-->
<!--                                <div class="flex-shrink-0">-->
<!--                                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors duration-300">-->
<!--                                        <ClockIcon class="w-6 h-6 text-primary" />-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="ml-4">-->
<!--                                    <h3 class="text-lg font-semibold text-gray-900">Business Hours</h3>-->
<!--                                    <p class="text-gray-600 mt-1">Monday - Friday: 8:00 AM - 6:00 PM</p>-->
<!--                                    <p class="text-gray-600">Saturday: 9:00 AM - 4:00 PM</p>-->
<!--                                    <p class="text-gray-600">Sunday: Closed</p>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        &lt;!&ndash; Social Media - Updated with Heroicons &ndash;&gt;-->
<!--                        <div class="mt-12">-->
<!--                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Follow Us</h3>-->
<!--                            <div class="flex space-x-4">-->
<!--                                <a :href="$page.props.contact.social.facebook" target="_blank" rel="noopener noreferrer"-->
<!--                                   class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center text-white hover:bg-primary transition-all duration-300 transform hover:scale-110">-->
<!--                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">-->
<!--                                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>-->
<!--                                    </svg>-->
<!--                                </a>-->
<!--                                <a :href="$page.props.contact.social.twitter" target="_blank" rel="noopener noreferrer"-->
<!--                                   class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center text-white hover:bg-primary transition-all duration-300 transform hover:scale-110">-->
<!--                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">-->
<!--                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>-->
<!--                                    </svg>-->
<!--                                </a>-->
<!--                                <a :href="$page.props.contact.social.instagram" target="_blank" rel="noopener noreferrer"-->
<!--                                   class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center text-white hover:bg-primary transition-all duration-300 transform hover:scale-110">-->
<!--                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">-->
<!--                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>-->
<!--                                    </svg>-->
<!--                                </a>-->
<!--                                <a :href="$page.props.contact.social.linkedin" target="_blank" rel="noopener noreferrer"-->
<!--                                   class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center text-white hover:bg-primary transition-all duration-300 transform hover:scale-110">-->
<!--                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">-->
<!--                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>-->
<!--                                    </svg>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->

<!--        &lt;!&ndash; Newsletter Section &ndash;&gt;-->
<!--        <section id="newsletter-section" class="py-20 bg-primary/5 transition-colors duration-300">-->
<!--            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">-->
<!--                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 transition-colors duration-300">-->
<!--                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Stay Updated</h2>-->
<!--                    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">-->
<!--                        Subscribe to our newsletter for exclusive updates on new projects, investment opportunities, and market insights.-->
<!--                    </p>-->

<!--                    <form @submit.prevent="subscribeNewsletter" class="max-w-md mx-auto">-->
<!--                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">-->
<!--                            <div>-->
<!--                                <input-->
<!--                                    type="text"-->
<!--                                    v-model="newsletterForm.name"-->
<!--                                    :class="{'border-red-300': newsletterForm.errors.name}"-->
<!--                                    required-->
<!--                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300"-->
<!--                                    placeholder="Your full name"-->
<!--                                >-->
<!--                                <div v-if="newsletterForm.errors.name" class="text-red-500 text-sm mt-1 animate-fade-in">-->
<!--                                    {{ newsletterForm.errors.name }}-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div>-->
<!--                                <input-->
<!--                                    type="email"-->
<!--                                    v-model="newsletterForm.email"-->
<!--                                    :class="{'border-red-300': newsletterForm.errors.email}"-->
<!--                                    required-->
<!--                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-300"-->
<!--                                    placeholder="Your email address"-->
<!--                                >-->
<!--                                <div v-if="newsletterForm.errors.email" class="text-red-500 text-sm mt-1 animate-fade-in">-->
<!--                                    {{ newsletterForm.errors.email }}-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <button-->
<!--                            type="submit"-->
<!--                            :disabled="newsletterForm.processing"-->
<!--                            class="w-full bg-primary hover:bg-primary/80 text-white font-bold py-4 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"-->
<!--                        >-->
<!--                            <span v-if="newsletterForm.processing" class="flex items-center justify-center">-->
<!--                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">-->
<!--                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>-->
<!--                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>-->
<!--                                </svg>-->
<!--                                Subscribing...-->
<!--                            </span>-->
<!--                            <span v-else class="flex items-center justify-center">-->
<!--                                <EnvelopeIcon class="w-5 h-5 mr-2 text-white" />-->
<!--                                Subscribe to Updates-->
<!--                            </span>-->
<!--                        </button>-->
<!--                        <p class="text-sm text-gray-500 mt-3">-->
<!--                            We respect your privacy. Unsubscribe at any time.-->
<!--                        </p>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->

        <!-- Map Section -->
<!--        <section class="bg-white py-20 transition-colors duration-300">-->
<!--            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">-->
<!--                <div class="text-center mb-12">-->
<!--                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Visit Our Office</h2>-->
<!--                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">-->
<!--                        Located in the heart of Westlands, our office is easily accessible for meetings and consultations.-->
<!--                    </p>-->
<!--                </div>-->

<!--                &lt;!&ndash; Google Maps Embed &ndash;&gt;-->
<!--                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-colors duration-300">-->
<!--                    <div class="h-96 w-full">-->
<!--                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4919.970799173085!2d36.74429797567676!3d-1.2552488111263767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f19007b338919%3A0xb98835a6bb981f00!2sSandalwood%20Loresho!5e0!3m2!1sen!2ske!4v1773423345983!5m2!1sen!2ske" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="100%"-->
<!--                            height="100%"-->
<!--                            class="w-full h-full"-->
<!--                        ></iframe>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { ref } from 'vue';
import {
    MapPinIcon,
    PhoneIcon,
    EnvelopeIcon,
    ClockIcon,
    StarIcon,
    CheckBadgeIcon
} from '@heroicons/vue/24/outline';

const submitting = ref(false);

const form = ref({
    fullName: '',
    email: '',
    phone: '',
    keepUpdated: false
});


const $toast = useToast();



// Newsletter Form
const newsletterForm = useForm({
    name: '',
    email: ''
});

const testimonials = ref([
    {
        id: 1,
        name: 'Salome Mukiri',
        initials: 'SM',
        role: 'Local Guide • 8 Reviews',
        rating: 4.8,
        content: 'Great apartments, they have something for everyone. Affordable, middle range, and luxury housing options. The exemplary customer service truly sets Sandalwood Developers apart from other real estate companies...',
    },
    {
        id: 2,
        name: 'Veronica Koskei',
        initials: 'VK',
        role: 'Property Investor',
        rating: 4.5,
        content: 'Sandalwood Developers offer a wide range of bespoke and affordable housing solutions. Their portfolio caters to different budgets and preferences. I was referred by Peter and couldn\'t be happier with my investment...',
    },
    {
        id: 3,
        name: 'Annie Njeri',
        initials: 'AN',
        role: 'First-time Home Buyer',
        rating: 5.0,
        content: 'Love the affordability without compromising on quality. Sandalwood Developers made homeownership accessible for me as a first-time buyer. James provided excellent guidance throughout the entire process...',
    }
]);

const submitForm = () => {
    submitting.value = true;

    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            $toast.success('Your message has been sent successfully! We will get back to you soon.', {
                position: 'top-right',
                duration: 5000,
                dismissible: true,
            });
        },
        onError: (errors) => {
            $toast.error('There was an error sending your message. Please check the form and try again.', {
                position: 'top-right',
                duration: 5000,
                dismissible: true,
            });

            const firstError = Object.keys(errors)[0];
            if (firstError) {
                const element = document.getElementById(firstError);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    element.focus();
                }
            }
        }
    });
};

const subscribeNewsletter = () => {
    newsletterForm.post('/newsletter/subscribe', {
        preserveScroll: true,
        onSuccess: () => {
            newsletterForm.reset();
            $toast.success('Thank you for subscribing to our newsletter!', {
                position: 'top-right',
                duration: 5000,
                dismissible: true,
            });
        },
        onError: (errors) => {
            $toast.error('There was an error subscribing to the newsletter. Please try again.', {
                position: 'top-right',
                duration: 5000,
                dismissible: true,
            });

            if (Object.keys(errors).length > 0) {
                const newsletterSection = document.querySelector('#newsletter-section');
                if (newsletterSection) {
                    newsletterSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        }
    });
};
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

.animate-fade-in {
    animation: fadeIn 0.5s ease-in-out;
}

.animate-fade-in-scale {
    animation: fadeInScale 0.6s ease-out forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInScale {
    0% {
        opacity: 0;
        transform: scale(0.95) translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

html {
    scroll-behavior: smooth;
}
</style>
