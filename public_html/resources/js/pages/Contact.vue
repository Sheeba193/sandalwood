<template>
    <AppLayout>
        <main class="bg-white text-slate-900">
            <section class="contact-map-hero" aria-label="Sandalwood Properties location">
                <iframe title="Map showing Sandalwood Properties office" class="h-[60vh] min-h-[360px] w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=Sandalwood%20Loresho%2C%20Nairobi%2C%20Kenya&t=&z=14&ie=UTF8&iwloc=&output=embed"></iframe>
            </section>

            <section class="px-5 py-10 sm:py-14">
                <div class="mx-auto grid max-w-6xl gap-7 lg:grid-cols-[0.85fr_1.4fr]">
                    <aside class="rounded-2xl border border-slate-100 bg-white p-6 shadow-[0_12px_40px_rgba(15,23,42,0.07)] sm:p-8">
                        <span class="inline-flex items-center gap-2 rounded-full bg-[#001221]/5 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-[#001221]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#001221]"></span> Contact information
                        </span>
                        <h2 class="font-cinzel mt-5 text-xl font-medium tracking-[0.1em] text-slate-900 uppercase sm:text-2xl">We’re here to help</h2>
                        <p class="font-cormorant mt-3 text-lg leading-6 text-slate-600">Reach out and a member of our property team will get back to you as soon as possible.</p>

                        <div class="mt-7 divide-y divide-slate-100">
                            <a :href="`tel:${contact.phone_link}`" class="group flex gap-4 py-5 first:pt-0">
                                <span class="contact-icon"><PhoneIcon class="h-5 w-5" /></span>
                                <span><span class="font-cinzel block text-xs font-semibold tracking-wider text-slate-800 uppercase">Call our team</span><span class="font-cormorant mt-1 block text-lg text-slate-500 group-hover:text-[#001221]">{{ contact.phone }}</span></span>
                            </a>
                            <a :href="`mailto:${contact.emails.info}`" class="group flex gap-4 py-5">
                                <span class="contact-icon"><EnvelopeIcon class="h-5 w-5" /></span>
                                <span><span class="font-cinzel block text-xs font-semibold tracking-wider text-slate-800 uppercase">Email us</span><span class="font-cormorant mt-1 block break-all text-lg text-slate-500 group-hover:text-[#001221]">{{ contact.emails.info }}</span></span>
                            </a>
                            <div class="flex gap-4 py-5">
                                <span class="contact-icon"><MapPinIcon class="h-5 w-5" /></span>
                                <span><span class="font-cinzel block text-xs font-semibold tracking-wider text-slate-800 uppercase">Visit our office</span><span class="font-cormorant mt-1 block text-lg leading-6 text-slate-500">{{ contact.address.full }}</span></span>
                            </div>
                            <div class="flex gap-4 py-5 pb-0">
                                <span class="contact-icon"><ClockIcon class="h-5 w-5" /></span>
                                <span><span class="font-cinzel block text-xs font-semibold tracking-wider text-slate-800 uppercase">Office hours</span><span class="font-cormorant mt-1 block text-lg leading-6 text-slate-500">{{ contact.hours }}</span></span>
                            </div>
                        </div>
                    </aside>

                    <section class="contact-panel rounded-2xl p-6 shadow-[0_12px_40px_rgba(15,23,42,0.14)] sm:p-9">
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-[#d6b983]">
                            <span class="text-base leading-none">✳</span> Get in touch
                        </span>
                        <h2 class="font-cinzel mt-5 text-2xl font-medium tracking-[0.1em] uppercase sm:text-3xl">Tell us what you need</h2>
                        <p class="font-cormorant mt-3 max-w-xl text-lg leading-6 text-white/75">Share a few details and the right person on our team will be in touch.</p>

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
                                <input v-model="form.keepUpdated" type="checkbox" class="mt-0.5 h-4 w-4 rounded border-white/40 text-[#d6b983] focus:ring-[#d6b983]">
                                <span class="font-cormorant text-lg text-white/75">Keep me updated with property news and offers</span>
                            </label>
                            <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-3 bg-white px-6 py-3 text-xs font-bold tracking-[0.16em] text-[#001221] uppercase transition hover:bg-[#d6b983] disabled:cursor-wait disabled:opacity-60">
                                {{ form.processing ? 'Sending…' : 'Send message' }}
                                <span aria-hidden="true">↗</span>
                            </button>
                        </form>
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

const page = usePage<any>();
const contact = page.props.contact;
const serviceOptions = [
    'Ask a question about a property',
    'Book a unit',
    'Schedule a site visit',
    'Explore investment opportunities',
    'Ask about pricing or payment plans',
    'Property management enquiry',
    'Partnership or business enquiry',
    'Careers enquiry',
    'Other',
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
.contact-map-hero { line-height: 0; }
.contact-panel { background: #001221; color: #fff; }
.contact-icon { display: flex; height: 2.75rem; width: 2.75rem; flex: none; align-items: center; justify-content: center; border-radius: 0.85rem; background: #0012210d; color: #001221; }
.form-label { display: block; margin-bottom: 0.45rem; font-family: 'Cinzel', 'Times New Roman', serif; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: #ffffffdd; }
.form-input { width: 100%; border: 1px solid #e2e0dd; border-radius: 0.65rem; background: #fff; padding: 0.75rem 0.9rem; color: #0f172a; font-family: 'Adobe Garamond Pro', Georgia, serif; font-size: 1rem; outline: none; transition: border-color 150ms, box-shadow 150ms; }
.form-input::placeholder { color: #9ca3af; }
.form-input:focus { border-color: #d6b983; box-shadow: 0 0 0 3px #d6b98333; }
.form-error { margin-top: 0.35rem; font-size: 0.75rem; color: #dc2626; }
</style>
