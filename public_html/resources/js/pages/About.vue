<script setup>
import { ref, onMounted, computed, nextTick } from 'vue';
import { Link } from '@inertiajs/vue3';
import Lenis from 'lenis';
import AppLayout from '@/Layouts/AppLayout.vue';
import SandalWoodLoader from '@/Components/SandalWoodLoader.vue';

// Define the projects prop passed from the backend
const props = defineProps({
    projects: Array
});

const loading = ref(true);
const currentSlide = ref(0);

const faqCategories = [
    {
        name: 'Our properties',
        questions: [
            { question: 'What types of properties does Sandalwood develop?', answer: 'Our portfolio includes thoughtfully designed residential and office developments. Visit the Projects page to explore current and completed properties.' },
            { question: 'Where can I find details about a specific development?', answer: 'Each property page includes available project information, images, location details, and a way to enquire with our team.' },
            { question: 'How can I compare the available developments?', answer: 'Browse the project pages to review each development’s location and features. If you are deciding between options, tell our team what matters most to you and we can help you explore them.' },
            { question: 'Does Sandalwood have completed projects I can view?', answer: 'The Projects page highlights both current and completed developments. Contact us if you would like information about a particular property or viewing options.' },
            { question: 'Where can I learn about a project’s amenities and features?', answer: 'Check the relevant project page for published features and amenities. You can also contact our team with questions about a specific development.' },
        ],
    },
    {
        name: 'Buying & booking',
        questions: [
            { question: 'How do I enquire about or book a unit?', answer: 'Send us an enquiry through the Contact page and select “Book a unit” or ask about the property you have in mind. Our team will follow up with the relevant information.' },
            { question: 'Can I ask about pricing and payment options?', answer: 'Yes. Contact our team with the development and unit type you are interested in, and we can discuss the applicable pricing and payment information.' },
            { question: 'What should I include in a property enquiry?', answer: 'Let us know which development interests you, the type of unit you are considering, and any questions you have. Sharing your preferred way and time to be contacted can also help us respond.' },
            { question: 'Can I check whether a particular unit is available?', answer: 'Availability can change. Contact our team with the development and unit details you are interested in, and we will help you check the latest information.' },
            { question: 'What happens after I submit an enquiry?', answer: 'Our team reviews your message and gets in touch to discuss your questions and next steps. Include your preferred contact details so we can reach you.' },
        ],
    },
    {
        name: 'Visits & support',
        questions: [
            { question: 'Can I visit a property before making a decision?', answer: 'You can request a site visit through our Contact page. Let us know which development you would like to see and a convenient time, and our team will coordinate with you.' },
            { question: 'How can I get in touch with Sandalwood Properties?', answer: 'Use the Contact page to call, email, or send an enquiry. Choose the topic that best matches your question so we can direct it to the right team.' },
            { question: 'Do I need to arrange a site visit in advance?', answer: 'Please contact us to request a visit and agree on a suitable time. This helps our team coordinate access and give you the right information during your visit.' },
            { question: 'Can I ask a general question if I have not chosen a property yet?', answer: 'Of course. Send us a general enquiry and tell us what you are looking for. Our team can help point you toward developments that may suit your needs.' },
            { question: 'What if my question is not covered here?', answer: 'Use the Contact Us button to send us your question. You can choose “Other” in the enquiry form and our team will direct it appropriately.' },
        ],
    },
];
const activeFaqCategory = ref(faqCategories[0].name);
const activeFaq = ref(0);
const activeFaqItems = computed(() => faqCategories.find(category => category.name === activeFaqCategory.value)?.questions ?? []);

// Statistics from your branding
const stats = [
    { value: '20+', label: 'YEARS OF<br>EXPERIENCE' },
    { value: '15+', label: 'PROJECTS' },
    { value: '2', label: 'PROJECTS UNDER<br>CONSTRUCTION' },
    { value: '10+', label: 'PRIME<br>LOCATIONS' }
];

// Keep the three featured properties at the start of the showcase.
const orderedProjects = computed(() => {
    const priority = ['sandalwood-loresho', 'sandalwood-kyuna', 'the-colosseum-residences'];
    return [...(props.projects || [])].sort((a, b) => {
        const aIndex = priority.indexOf(a.slug);
        const bIndex = priority.indexOf(b.slug);
        return (aIndex === -1 ? priority.length : aIndex) - (bIndex === -1 ? priority.length : bIndex);
    });
});

// Each slide shows three properties, advancing one property at a time.
const propertyGroups = computed(() => {
    const projects = orderedProjects.value;
    if (projects.length <= 3) return projects.length ? [projects] : [];

    return projects.map((_, start) =>
        Array.from({ length: 3 }, (_, offset) => projects[(start + offset) % projects.length]),
    );
});

const next = () => {
    if (!propertyGroups.value.length) return;
    if (currentSlide.value < propertyGroups.value.length - 1) {
        currentSlide.value++;
    } else {
        currentSlide.value = 0;
    }
};

const prev = () => {
    if (!propertyGroups.value.length) return;
    if (currentSlide.value > 0) {
        currentSlide.value--;
    } else {
        currentSlide.value = propertyGroups.value.length - 1;
    }
};

onMounted(() => {
    // Smooth scrolling initialization
    const lenis = new Lenis({ duration: 1.2 });
    function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
    requestAnimationFrame(raf);

    setTimeout(() => {
        loading.value = false;
        nextTick(() => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => entry.isIntersecting && entry.target.classList.add('active'));
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    }, 1500);
});
</script>

<template>
    <div class="font-serif selection:bg-gray-200 overflow-x-hidden">
        <div v-if="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-white">
            <SandalWoodLoader />
        </div>

        <div v-else>
            <AppLayout>
                <section class="relative h-[42vh] min-h-[300px] max-h-[620px] bg-[#001221] overflow-hidden">
                    <img src="/images/projects/the-haven/3I9A7215.JPG" class="w-full h-full object-cover object-center opacity-70" alt="Landscaped grounds at a Sandalwood property" />
                    <div class="absolute inset-0 bg-gradient-to-t from-[#001221]/40 via-transparent to-[#001221]/10" aria-hidden="true"></div>
                </section>

                <div class="bg-white relative z-10">
                    <section class="max-w-7xl mx-auto px-6 md:px-12 py-24 reveal">
                        <div class="max-w-4xl mx-auto">
                            <div class="flex items-center space-x-4 mb-6">
                                <span class="text-[12px] tracking-[0.2em] uppercase text-gray-700 font-cinzel">overview</span>
                                <div class="h-[0.5px] w-32 bg-gray-400"></div>
                            </div>
                            <h2 class="text-2xl md:text-4xl tracking-[0.15em] uppercase text-[#001221] mb-8 font-light font-cinzel">
                                ABOUT SANDALWOOD PROPERTIES
                            </h2>
                            <p class="text-[18px] leading-relaxed text-gray-500 font-cormorant text-justify">
                                Sandalwood Properties is a distinguished real estate development company, recognized for its excellence in delivering thoughtfully designed residential and office
                                developments. With a strong foundation built over two decades, Sandalwood Properties combines expertise in design, construction, and project delivery to create
                                exceptional living environments.
                            </p>
                        </div>
                    </section>

                    <section class="bg-[#f1f2f3] py-16 md:py-20 reveal">
                        <div class="max-w-7xl mx-auto px-6 md:px-12 flex flex-wrap justify-between items-center gap-12">
                            <div v-for="(stat, i) in stats" :key="i" class="flex items-center">
                                <div class="flex items-center space-x-6">
                                    <span class="text-5xl md:text-6xl font-cinzel text-[#001221]">{{ stat.value }}</span>
                                    <div class="text-[11px] tracking-[0.2em] uppercase text-gray-600 leading-tight font-cinzel" v-html="stat.label"></div>
                                </div>
                                <div v-if="i !== stats.length - 1" class="h-16 w-[1px] bg-gray-300 ml-12 hidden lg:block"></div>
                            </div>
                        </div>
                    </section>

                    <section class="max-w-7xl mx-auto px-6 md:px-12 py-24 reveal">
                        <div class="max-w-4xl mx-auto">
                        <h3 class="text-2xl tracking-[0.2em] uppercase text-[#001221] font-cinzel mb-16">THE SANDALWOOD STANDARD</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="bg-[#f4f5f7] p-12 flex flex-col items-center text-center">
                                <h4 class="text-lg tracking-[0.15em] uppercase text-[#001221] font-cinzel mb-6">OUR MISSION</h4>
                                <p class="text-[18px] leading-relaxed text-gray-500 font-cormorant text-justify">
                                    To create exceptional developments through innovation, quality, and attention to detail, consistently delivering spaces that surpass expectations.
                                </p>
                            </div>

                            <div class="bg-[#f4f5f7] p-12 flex flex-col items-center text-center">
                                <h4 class="text-lg tracking-[0.15em] uppercase text-[#001221] font-cinzel mb-6">OUR VISION</h4>
                                <p class="text-[18px] leading-relaxed text-gray-500 font-cormorant text-justify">
                                    To set the benchmark in real estate by developing distinctive properties that inspire modern living and lasting value.
                                </p>
                            </div>

                            <div class="bg-[#f4f5f7] p-12 flex flex-col items-center text-center">
                                <h4 class="text-lg tracking-[0.15em] uppercase text-[#001221] font-cinzel mb-6">OUR VALUE</h4>
                                <p class="text-[18px] leading-relaxed text-gray-500 font-cormorant text-justify">
                                    We are driven by integrity, precision, and a steadfast commitment to excellence, ensuring every project upholds the highest standards of quality and trust.
                                </p>
                            </div>
                        </div>
                        </div>
                    </section>

                    <section class="faq-section bg-[#f4f5f7] px-6 py-20 md:px-12 md:py-24 reveal">
                        <div class="mx-auto max-w-6xl">
                            <div class="mx-auto mb-12 max-w-2xl text-center">
                                <span class="font-cinzel text-[11px] tracking-[0.2em] text-gray-600 uppercase">Frequently asked questions</span>
                                <h3 class="font-cinzel mt-4 text-2xl tracking-[0.12em] text-[#001221] uppercase sm:text-3xl">Questions about Sandalwood?</h3>
                                <p class="font-cormorant mt-4 text-lg leading-relaxed text-gray-500">Find answers about our properties, the buying process, and arranging a visit.</p>
                            </div>

                            <div class="grid gap-8 lg:grid-cols-[0.72fr_1.5fr]">
                                <div class="space-y-2">
                                    <button
                                        v-for="category in faqCategories"
                                        :key="category.name"
                                        type="button"
                                        class="faq-category-button flex w-full items-center justify-between border px-5 py-4 text-left transition-colors"
                                        :class="activeFaqCategory === category.name ? 'is-active border-[#d6b983] shadow-[0_8px_24px_rgba(0,18,33,0.10)]' : 'border-gray-200 hover:border-[#d6b983] hover:shadow-md'"
                                        @click="activeFaqCategory = category.name; activeFaq = 0"
                                    >
                                        <span class="font-cinzel text-xs tracking-[0.12em] uppercase">{{ category.name }}</span>
                                        <span aria-hidden="true">→</span>
                                    </button>

                                    <div class="border border-gray-100 border-l-4 border-l-[#d6b983] bg-white p-6 text-[#001221] shadow-[0_8px_24px_rgba(0,18,33,0.08)] sm:p-7">
                                        <h4 class="font-cinzel text-sm tracking-[0.12em] uppercase">Still have a question?</h4>
                                        <p class="font-cormorant mt-2 text-lg leading-6 text-gray-600">Our team is happy to help you find the information you need.</p>
                                        <Link href="/contact" class="mt-5 inline-flex w-full items-center justify-center bg-[#001221] px-5 py-3 text-xs font-semibold tracking-[0.16em] text-white uppercase transition hover:bg-[#1a365d]">Contact us</Link>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <article v-for="(item, index) in activeFaqItems" :key="item.question" class="border border-gray-100 bg-white shadow-[0_6px_20px_rgba(0,18,33,0.07)] transition-shadow hover:shadow-[0_10px_28px_rgba(0,18,33,0.11)]">
                                        <button
                                            type="button"
                                            class="faq-question-button flex w-full items-center justify-between gap-6 px-5 py-5 text-left sm:px-6"
                                            :aria-expanded="activeFaq === index"
                                            @click="activeFaq = activeFaq === index ? -1 : index"
                                        >
                                            <span class="faq-question-text font-cormorant text-lg font-semibold leading-6 text-[#263238] sm:text-xl">{{ item.question }}</span>
                                            <span class="faq-toggle-icon shrink-0 text-xl font-semibold text-[#8b6d3f]" aria-hidden="true">{{ activeFaq === index ? '−' : '+' }}</span>
                                        </button>
                                        <div v-if="activeFaq === index" class="px-5 pb-5 sm:px-6">
                                            <p class="font-cormorant border-t border-gray-100 pt-4 text-lg leading-7 text-gray-600">{{ item.answer }}</p>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </section>


                </div>

                <div class="bg-white relative z-10">

                    <section class="max-w-7xl mx-auto px-6 md:px-12 py-24 reveal">
                        <div class="max-w-4xl mx-auto">
                        <div class="flex justify-between items-end mb-12">
                            <h3 class="text-2xl tracking-[0.15em] uppercase text-[#001221] font-cinzel">SANDALWOOD PROPERTIES</h3>
                            <Link href="/projects" class="text-[14px] bg-[#001221] text-white px-8 py-3 tracking-[0.2em] font-montserrat uppercase">VIEW ALL PROPERTIES</Link>
                        </div>

                        <div class="relative overflow-hidden">
                            <div class="flex transition-transform duration-1000 ease-in-out" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
                                <div v-for="(group, idx) in propertyGroups" :key="idx" class="flex-none w-full grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <Link v-for="prop in group" :key="prop.id" :href="`/projects/${prop.slug}`" class="group block">
                                        <div class="overflow-hidden mb-6 aspect-[4/3] bg-gray-50">
                                            <img :src="prop.image" :alt="prop.title" loading="lazy" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                                        </div>
                                        <h4 class="text-[18px] leading-relaxed text-gray-500 font-cormorant">{{ prop.title }}</h4>
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <div class="mt-16 flex items-center justify-center space-x-12">
                            <button @click="prev" class="opacity-30 hover:opacity-100 transition-opacity">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7"/></svg>
                            </button>

                            <div class="carousel-pagination flex items-center space-x-2">
                                <button
                                    v-for="(_, i) in propertyGroups"
                                    :key="i"
                                    @click="currentSlide = i"
                                    class="w-2.5 h-2.5 transition-all duration-300"
                                    :class="currentSlide === i ? '!bg-black' : '!bg-gray-200'"
                                ></button>
                            </div>

                            <button @click="next" class="opacity-30 hover:opacity-100 transition-opacity">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                        </div>
                    </section>
                </div>
            </AppLayout>
        </div>
    </div>
</template>

<style scoped>
.reveal { opacity: 0; transform: translateY(40px); transition: all 1.2s cubic-bezier(0.22, 1, 0.36, 1); }
.reveal.active { opacity: 1; transform: translateY(0); }
.faq-section .faq-category-button,
.faq-section .faq-question-button { background-color: #fff !important; color: #263238 !important; }
.faq-section .faq-category-button.is-active { border-color: #d6b983 !important; color: #001221 !important; }
.faq-section .faq-question-button:hover { background-color: #fff !important; color: #263238 !important; }
.faq-section .faq-category-button:hover { background-color: #fff !important; color: #001221 !important; }
.faq-section .faq-category-button span { color: #263238 !important; }
.faq-section .faq-category-button.is-active span { color: #001221 !important; }
.faq-section .faq-question-text { color: #263238 !important; }
.faq-section .faq-toggle-icon { color: #8b6d3f !important; }
.carousel-pagination button.bg-black,
.carousel-pagination button.bg-black:active { background-color: #000 !important; }
.carousel-pagination button.bg-gray-200 { background-color: #e5e7eb !important; }
</style>
