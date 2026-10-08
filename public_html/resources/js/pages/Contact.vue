<template>
    <AppLayout>
        <main class="bg-white text-[#17242a]">
            <section class="contact-hero relative min-h-[60vh] overflow-visible text-white">
                <div class="relative z-10 mx-auto flex min-h-[60vh] max-w-6xl flex-col justify-center gap-8 px-5 py-12 sm:px-8 lg:flex-row lg:items-center lg:gap-14 lg:py-0">
                    <div class="contact-hero-copy max-w-2xl lg:flex-1">
                        <p class="font-cinzel text-xs font-semibold uppercase tracking-[0.24em] text-[#d6b983]">Sandalwood Properties</p>
                        <h1 class="font-cinzel mt-4 text-4xl font-medium tracking-[0.08em] uppercase sm:text-5xl">Get in touch</h1>
                        <p class="font-cormorant mt-4 max-w-xl text-xl leading-7 text-white/75 sm:text-2xl">Whether you’re searching for a home or exploring an investment, our team is here to help you find your next step.</p>
                    </div>
                </div>
            </section>

            <section class="px-5 pb-12 pt-12 sm:px-8 sm:pb-16 sm:pt-16 lg:pb-20 lg:pt-16">
                <div class="mx-auto max-w-6xl">
                    <p class="font-cinzel text-xs font-semibold uppercase tracking-[0.2em] text-[#9b8152]">Contact information</p>
                    <h2 class="font-cinzel mt-2 text-xl font-medium tracking-[0.08em] uppercase sm:text-2xl">We’d love to hear from you</h2>
                    <p class="font-cormorant mt-2 text-lg text-slate-600">Reach out and a member of our property team will get back to you.</p>
                    <div class="mt-7 grid gap-5 border-y border-slate-200 py-6 sm:grid-cols-3 sm:gap-6">
                        <a :href="`tel:${contact.phone_link}`" class="contact-detail">
                            <span class="contact-icon"><PhoneIcon class="h-5 w-5" /></span>
                            <span><span class="contact-kicker">Call our team</span><span class="contact-value">{{ contact.phone }}</span></span>
                        </a>
                        <a :href="`mailto:${contact.emails.info}`" class="contact-detail">
                            <span class="contact-icon"><EnvelopeIcon class="h-5 w-5" /></span>
                            <span><span class="contact-kicker">Email us</span><span class="contact-value break-all">{{ contact.emails.info }}</span></span>
                        </a>
                        <div class="contact-detail">
                            <span class="contact-icon"><MapPinIcon class="h-5 w-5" /></span>
                            <span><span class="contact-kicker">Visit us</span><span class="contact-value">{{ contact.address.full }}</span></span>
                        </div>
                    </div>
                    <div class="office-hours-row">
                        <ClockIcon class="h-5 w-5 flex-none text-[#001529]" />
                        <span class="font-cinzel text-xs font-semibold uppercase tracking-[0.12em] text-slate-700">Office hours</span>
                        <span class="font-cormorant text-lg text-slate-600">{{ contact.hours }}</span>
                    </div>
                </div>

                <div class="mx-auto mt-12 grid max-w-6xl items-stretch gap-10 lg:mt-16 lg:grid-cols-2 lg:gap-12">
                    <section class="contact-panel h-full rounded-xl p-6 shadow-[0_18px_48px_rgba(20,39,44,0.16)] sm:p-9">
                        <p class="font-cinzel text-xs font-semibold uppercase tracking-[0.2em] text-[#d6b983]">Start a conversation</p>
                        <h2 class="font-cinzel mt-3 text-2xl font-medium tracking-[0.08em] uppercase sm:text-3xl">Tell us what you need</h2>
                        <p class="font-cormorant mt-3 text-lg leading-6 text-white/75">Share a few details and the right person on our team will be in touch.</p>

                        <form class="mt-7 space-y-4" @submit.prevent="submitForm">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="fullName" class="form-label">Full name <span class="text-[#d6b983]">*</span></label>
                                    <input id="fullName" v-model="form.fullName" type="text" autocomplete="name" required class="form-input" placeholder="Your name">
                                    <p v-if="form.errors.fullName" class="form-error">{{ form.errors.fullName }}</p>
                                </div>
                                <div>
                                    <label for="email" class="form-label">Email address <span class="text-[#d6b983]">*</span></label>
                                    <input id="email" v-model="form.email" type="email" autocomplete="email" required class="form-input" placeholder="you@example.com">
                                    <p v-if="form.errors.email" class="form-error">{{ form.errors.email }}</p>
                                </div>
                                <div>
                                    <label for="phone" class="form-label">Phone number <span class="text-[#d6b983]">*</span></label>
                                    <input id="phone" v-model="form.phone" type="tel" autocomplete="tel" required class="form-input" placeholder="+254 7xx xxx xxx">
                                    <p v-if="form.errors.phone" class="form-error">{{ form.errors.phone }}</p>
                                </div>
                                <div>
                                    <label for="service" class="form-label">How can we help? <span class="text-[#d6b983]">*</span></label>
                                    <select id="service" v-model="form.subject" required class="form-input">
                                        <option value="" disabled>Select a service</option>
                                        <option v-for="option in serviceOptions" :key="option" :value="option">{{ option }}</option>
                                    </select>
                                    <p v-if="form.errors.subject" class="form-error">{{ form.errors.subject }}</p>
                                </div>
                            </div>
                            <div>
                                <label for="message" class="form-label">Your message <span class="text-[#d6b983]">*</span></label>
                                <textarea id="message" v-model="form.message" required rows="5" class="form-input resize-y" placeholder="Tell us a little more about what you’re looking for..."></textarea>
                                <p v-if="form.errors.message" class="form-error">{{ form.errors.message }}</p>
                            </div>
                            <label class="flex cursor-pointer items-start gap-3 text-sm leading-5">
                                <input v-model="form.keepUpdated" type="checkbox" class="mt-1 h-4 w-4 rounded border-white/40 text-[#d6b983] focus:ring-[#d6b983]">
                                <span class="font-cormorant text-lg text-white/75">Keep me updated with property news and offers</span>
                            </label>
                            <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-3 rounded-full bg-[#d6b983] px-6 py-3 text-xs font-bold tracking-[0.16em] text-[#17242a] uppercase transition hover:bg-white disabled:cursor-wait disabled:opacity-60">
                                {{ form.processing ? 'Sending…' : 'Send message' }} <span aria-hidden="true">↗</span>
                            </button>
                        </form>
                    </section>

                    <section class="location-panel flex h-full flex-col rounded-xl border border-slate-200 p-6 shadow-[0_12px_40px_rgba(15,23,42,0.07)] sm:p-9">
                        <div class="flex min-h-0 flex-1 flex-col">
                            <p class="font-cinzel text-xs font-semibold uppercase tracking-[0.2em] text-[#9b8152]">Find us</p>
                            <h2 class="font-cinzel mt-2 text-xl font-medium tracking-[0.08em] uppercase sm:text-2xl">Our location</h2>
                            <p class="font-cormorant mt-2 text-lg text-slate-600">Visit our office in Loresho, Nairobi. We look forward to welcoming you.</p>
                            <div class="mt-5 min-h-[280px] flex-1 overflow-hidden rounded-xl border border-slate-200 shadow-sm">
                                <iframe title="Map showing Sandalwood Properties office in Loresho, Nairobi" class="h-full min-h-[280px] w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=Sandalwood%20Loresho%2C%20Nairobi%2C%20Kenya&t=&z=14&ie=UTF8&iwloc=&output=embed"></iframe>
                            </div>
                        </div>
                        <section v-if="socialLinks.length" class="mt-7 flex-none">
                            <h3 class="font-cinzel text-sm font-semibold tracking-[0.12em] uppercase">Follow Sandalwood</h3>
                            <div class="mt-4 flex gap-3">
                                <a v-for="item in socialLinks" :key="item.name" :href="item.url || '#'" :target="item.url && item.url !== '#' ? '_blank' : undefined" :rel="item.url && item.url !== '#' ? 'noopener noreferrer' : undefined" @click="item.url === '#' && $event.preventDefault()" class="social-link">
                                    <span class="sr-only">{{ item.name }}</span>
                                    <FontAwesomeIcon :icon="item.icon" class="h-5 w-5" />
                                </a>
                            </div>
                        </section>
                    </section>
                </div>
            </section>
        </main>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { ClockIcon, EnvelopeIcon, MapPinIcon, PhoneIcon } from '@heroicons/vue/24/outline';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faFacebookF, faInstagram, faLinkedinIn, faXTwitter } from '@fortawesome/free-brands-svg-icons';

const page = usePage<any>();
const contact = page.props.contact;
const socialLinks = [
    { name: 'Facebook', url: contact.social?.facebook, icon: faFacebookF },
    { name: 'Instagram', url: contact.social?.instagram, icon: faInstagram },
    { name: 'X', url: contact.social?.twitter, icon: faXTwitter },
    { name: 'LinkedIn', url: contact.social?.linkedin, icon: faLinkedinIn },
];
const serviceOptions = [
    'Ask a question about a property', 'Book a unit', 'Schedule a site visit',
    'Explore investment opportunities', 'Ask about pricing or payment plans',
    'Property management enquiry', 'Partnership or business enquiry', 'Careers enquiry', 'Other',
];
const form = useForm({ fullName: '', email: '', phone: '', subject: '', message: '', keepUpdated: false });
const toast = useToast();

const submitForm = () => form.post('/contact', {
    preserveScroll: true,
    onSuccess: () => {
        form.reset();
        toast.success('Thanks for reaching out. Your message has been sent to our team.', { position: 'top-right', duration: 5000, dismissible: true });
    },
    onError: () => toast.error('Please check the highlighted fields and try again.', { position: 'top-right', duration: 5000, dismissible: true }),
});
</script>

<style scoped>
.contact-hero { background-image: linear-gradient(90deg, #001529cf 0%, #001529a8 48%, #00152975 100%), url('/images/contact-hero.webp'); background-position: center; background-size: cover; }
.contact-hero-copy { animation: contact-enter 700ms ease-out both; }
.contact-panel { background: #001529; color: #fff; transition: transform 250ms ease, box-shadow 250ms ease; }
.contact-panel:hover { transform: translateY(-4px); box-shadow: 0 24px 55px #00152930; }
.location-panel { background: #fff; }
.contact-detail { display: flex; align-items: flex-start; gap: 0.85rem; color: inherit; }
.contact-detail:hover .contact-icon { transform: translateY(-3px); background: #d6b983; color: #001529; }
.contact-detail:hover .contact-value { color: #9b8152; }
.contact-icon { display: flex; height: 2.75rem; width: 2.75rem; flex: none; align-items: center; justify-content: center; border-radius: 50%; background: #001529; color: #fff; transition: transform 200ms ease, background 200ms ease, color 200ms ease; }
.office-hours-row { display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem 1rem; border-bottom: 1px solid #e2e8f0; padding: 1.25rem 0; }
.contact-kicker { display: block; font-family: 'Cinzel', 'Times New Roman', serif; font-size: 0.7rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: #657276; }
.contact-value { display: block; margin-top: 0.25rem; font-family: 'Cormorant Garamond', Georgia, serif; font-size: 1.15rem; line-height: 1.35; color: #001529; transition: color 150ms; }
.form-label { display: block; margin-bottom: 0.45rem; font-family: 'Cinzel', 'Times New Roman', serif; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: #ffffffdd; }
.form-input { width: 100%; border: 1px solid #ffffff50; border-radius: 0.55rem; background: #ffffff0a; padding: 0.75rem 0.9rem; color: #fff; font-family: 'Cormorant Garamond', Georgia, serif; font-size: 1.05rem; outline: none; transition: border-color 150ms, box-shadow 150ms; }
.form-input option { color: #17242a; }
.form-input::placeholder { color: #ffffff80; }
.form-input:focus { border-color: #d6b983; box-shadow: 0 0 0 3px #d6b98333; }
.form-error { margin-top: 0.35rem; font-size: 0.75rem; color: #fecaca; }
.social-link { display: flex; height: 2.75rem; width: 2.75rem; align-items: center; justify-content: center; border-radius: 0.4rem; background: #001529; color: white; transition: transform 200ms ease, background 150ms, color 150ms; }
.social-link:hover { transform: translateY(-3px); background: #1a365d; color: #fff; }
@keyframes contact-enter { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
@media (prefers-reduced-motion: reduce) {
    .contact-hero-copy { animation: none; }
    .contact-panel, .contact-icon, .social-link { transition: none; }
    .contact-panel:hover, .social-link:hover { transform: none; }
}
</style>
