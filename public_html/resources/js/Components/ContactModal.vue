<template>
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="show" class="modal-overlay" @click.self="closeModal">
                <!-- Blurry background overlay -->
                <div class="modal-backdrop"></div>

                <!-- Modal Content -->
                <div class="modal-container">
                    <div class="modal-content">
                        <!-- Close Button -->
                        <button @click="closeModal" class="close-button">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Form Card -->
                        <div class="bg-white rounded-xl shadow-2xl">
                            <div class="p-5 md:p-6">
                                <!-- Header -->
                                <div class="flex items-center gap-4 mb-5">
                                    <img
                                        src="/images/logo_cropped.png"
                                        alt="Sandalwood"
                                        class="h-12 w-auto object-contain"
                                    />
                                    <h2 class="text-2xl font-bold font-cinzel text-gray-900">
                                        GET IN TOUCH
                                    </h2>
                                </div>

                                <!-- Form -->
                                <form @submit.prevent="submitForm">
                                    <!-- Full Name -->
                                    <div class="mb-4">
                                        <label class="block text-gray-800 font-cormorant text-sm mb-1">
                                            FULL NAME <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            v-model="form.fullName"
                                            required
                                            class="w-full font-cormorant px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#001221] focus:border-transparent"
                                            placeholder="Enter your full name"
                                        >
                                    </div>

                                    <div class="mb-4">
                                        <label for="inquiryType" class="block text-gray-800 font-cormorant text-sm mb-1">
                                            TYPE OF INQUIRY <span class="text-red-500">*</span>
                                        </label>
                                        <select id="inquiryType" v-model="form.subject" required class="w-full font-cormorant px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#001221]">
                                            <option value="" disabled>Select an inquiry type</option>
                                            <option v-for="option in inquiryOptions" :key="option" :value="option">{{ option }}</option>
                                        </select>
                                        <p v-if="form.errors.subject" class="mt-1 text-sm text-red-600">{{ form.errors.subject }}</p>
                                    </div>

                                    <div class="mb-4">
                                        <label for="inquiryMessage" class="block text-gray-800 font-cormorant text-sm mb-1">
                                            YOUR REQUEST <span class="text-red-500">*</span>
                                        </label>
                                        <textarea id="inquiryMessage" v-model="form.message" required maxlength="5000" rows="3" class="w-full font-cormorant px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#001221]" placeholder="Tell us more about what you need..."></textarea>
                                        <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">{{ form.errors.message }}</p>
                                    </div>

                                    <!-- Email Address -->
                                    <div class="mb-4">
                                        <label class="block text-gray-800 font-cormorant text-sm mb-1">
                                            EMAIL ADDRESS <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            v-model="form.email"
                                            required
                                            class="w-full font-cormorant px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#001221] focus:border-transparent"
                                            placeholder="Enter your Email"
                                        >
                                    </div>

                                    <!-- Phone Number with Country Selector -->
                                    <div class="mb-4">
                                        <label class="block text-gray-800 font-cormorant text-sm mb-1">
                                            PHONE NUMBER <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex relative">
                                            <!-- Country Selector Dropdown -->
                                            <div class="relative flex-shrink-0">
                                                <button
                                                    type="button"
                                                    @click="toggleCountryDropdown"
                                                    class="flex items-center gap-2 px-3 py-2 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md hover:bg-gray-200 transition-colors h-full"
                                                >
                                                    <CountryFlag
                                                        :country="selectedCountry.code.toLowerCase()"
                                                        size="normal"
                                                        class="w-5 h-5 rounded-sm"
                                                    />
                                                    <span class="text-sm font-medium text-gray-700">{{ selectedCountry.dialCode }}</span>
                                                    <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>

                                                <!-- Dropdown Menu -->
                                                <div
                                                    v-if="isDropdownOpen"
                                                    class="absolute top-full left-0 mt-1 w-72 max-h-80 overflow-y-auto bg-white border border-gray-300 rounded-md shadow-lg z-[99999]"
                                                    @click.stop
                                                >
                                                    <div class="sticky top-0 bg-white p-2 border-b border-gray-200 z-10">
                                                        <input
                                                            type="text"
                                                            v-model="searchQuery"
                                                            placeholder="Search countries..."
                                                            class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#001221]"
                                                            @click.stop
                                                        />
                                                    </div>
                                                    <div
                                                        v-for="country in filteredCountries"
                                                        :key="country.code"
                                                        @click="selectCountry(country)"
                                                        class="flex items-center gap-3 px-3 py-2 hover:bg-gray-100 cursor-pointer transition-colors"
                                                        :class="{ 'bg-gray-50': selectedCountry.code === country.code }"
                                                    >
                                                        <CountryFlag
                                                            :country="country.code.toLowerCase()"
                                                            size="normal"
                                                            class="w-6 h-6 rounded-sm flex-shrink-0"
                                                        />
                                                        <span class="text-sm text-gray-700 truncate">{{ country.name }}</span>
                                                        <span class="text-sm text-gray-500 ml-auto flex-shrink-0">{{ country.dialCode }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <input
                                                type="tel"
                                                v-model="form.phone"
                                                required
                                                class="flex-1 font-cormorant px-3 py-2 border border-gray-300 rounded-r-md bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#001221] focus:border-transparent min-w-0"
                                                placeholder="Enter your phone number"
                                            >
                                        </div>
                                    </div>

                                    <!-- Keep me updated - Toggle Switch -->
                                    <!-- Keep me updated - Toggle Switch -->
                                    <div class="mb-4 flex items-center justify-start gap-3">
                                        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                            <input
                                                type="checkbox"
                                                v-model="form.keepUpdated"
                                                class="sr-only peer"
                                            >
                                            <div class="w-14 h-6 bg-gray-300 rounded-full peer-checked:bg-[#001221] transition-colors duration-300 relative shadow-inner">
                                                <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full transition-transform duration-300 ease-in-out shadow-md flex items-center justify-center"
                                                     :class="form.keepUpdated ? 'translate-x-[1.875rem]' : 'translate-x-0'">
                                                    <svg
                                                        v-if="form.keepUpdated"
                                                        class="w-3 h-3 text-[#001221]"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </label>
                                        <span class="text-gray-700 font-cinzel text-sm">
        Keep me updated on news and offers
    </span>
                                    </div>

                                    <!-- Submit Button -->
                                    <button
                                        type="submit"
                                        :disabled="submitting"
                                        class="w-full bg-[#001221] text-white font-medium py-2.5 px-4 rounded-md transition duration-150 hover:bg-[#002a3d] disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        <span v-if="submitting">SUBMITTING...</span>
                                        <span v-else>SUBMIT</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup lang="ts">
import { ref, watch, computed, onMounted, onUnmounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toast-notification';
import CountryFlag from 'vue-country-flag-next';
import 'vue-toast-notification/dist/theme-sugar.css';

const props = defineProps<{
    show: boolean;
}>();

const emit = defineEmits<{
    (e: 'update:show', value: boolean): void;
    (e: 'close'): void;
}>();

const submitting = ref(false);
const $toast = useToast();
const isDropdownOpen = ref(false);
const searchQuery = ref('');
const inquiryOptions = [
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

// All countries with their ISO codes and dial codes
const countries = [
    { code: 'AF', name: 'Afghanistan', dialCode: '+93' },
    { code: 'AL', name: 'Albania', dialCode: '+355' },
    { code: 'DZ', name: 'Algeria', dialCode: '+213' },
    { code: 'AD', name: 'Andorra', dialCode: '+376' },
    { code: 'AO', name: 'Angola', dialCode: '+244' },
    { code: 'AG', name: 'Antigua and Barbuda', dialCode: '+1' },
    { code: 'AR', name: 'Argentina', dialCode: '+54' },
    { code: 'AM', name: 'Armenia', dialCode: '+374' },
    { code: 'AU', name: 'Australia', dialCode: '+61' },
    { code: 'AT', name: 'Austria', dialCode: '+43' },
    { code: 'AZ', name: 'Azerbaijan', dialCode: '+994' },
    { code: 'BS', name: 'Bahamas', dialCode: '+1' },
    { code: 'BH', name: 'Bahrain', dialCode: '+973' },
    { code: 'BD', name: 'Bangladesh', dialCode: '+880' },
    { code: 'BB', name: 'Barbados', dialCode: '+1' },
    { code: 'BY', name: 'Belarus', dialCode: '+375' },
    { code: 'BE', name: 'Belgium', dialCode: '+32' },
    { code: 'BZ', name: 'Belize', dialCode: '+501' },
    { code: 'BJ', name: 'Benin', dialCode: '+229' },
    { code: 'BT', name: 'Bhutan', dialCode: '+975' },
    { code: 'BO', name: 'Bolivia', dialCode: '+591' },
    { code: 'BA', name: 'Bosnia and Herzegovina', dialCode: '+387' },
    { code: 'BW', name: 'Botswana', dialCode: '+267' },
    { code: 'BR', name: 'Brazil', dialCode: '+55' },
    { code: 'BN', name: 'Brunei', dialCode: '+673' },
    { code: 'BG', name: 'Bulgaria', dialCode: '+359' },
    { code: 'BF', name: 'Burkina Faso', dialCode: '+226' },
    { code: 'BI', name: 'Burundi', dialCode: '+257' },
    { code: 'KH', name: 'Cambodia', dialCode: '+855' },
    { code: 'CM', name: 'Cameroon', dialCode: '+237' },
    { code: 'CA', name: 'Canada', dialCode: '+1' },
    { code: 'CV', name: 'Cape Verde', dialCode: '+238' },
    { code: 'CF', name: 'Central African Republic', dialCode: '+236' },
    { code: 'TD', name: 'Chad', dialCode: '+235' },
    { code: 'CL', name: 'Chile', dialCode: '+56' },
    { code: 'CN', name: 'China', dialCode: '+86' },
    { code: 'CO', name: 'Colombia', dialCode: '+57' },
    { code: 'KM', name: 'Comoros', dialCode: '+269' },
    { code: 'CG', name: 'Congo', dialCode: '+242' },
    { code: 'CD', name: 'Congo (DRC)', dialCode: '+243' },
    { code: 'CR', name: 'Costa Rica', dialCode: '+506' },
    { code: 'HR', name: 'Croatia', dialCode: '+385' },
    { code: 'CU', name: 'Cuba', dialCode: '+53' },
    { code: 'CY', name: 'Cyprus', dialCode: '+357' },
    { code: 'CZ', name: 'Czech Republic', dialCode: '+420' },
    { code: 'DK', name: 'Denmark', dialCode: '+45' },
    { code: 'DJ', name: 'Djibouti', dialCode: '+253' },
    { code: 'DM', name: 'Dominica', dialCode: '+1' },
    { code: 'DO', name: 'Dominican Republic', dialCode: '+1' },
    { code: 'EC', name: 'Ecuador', dialCode: '+593' },
    { code: 'EG', name: 'Egypt', dialCode: '+20' },
    { code: 'SV', name: 'El Salvador', dialCode: '+503' },
    { code: 'GQ', name: 'Equatorial Guinea', dialCode: '+240' },
    { code: 'ER', name: 'Eritrea', dialCode: '+291' },
    { code: 'EE', name: 'Estonia', dialCode: '+372' },
    { code: 'ET', name: 'Ethiopia', dialCode: '+251' },
    { code: 'FJ', name: 'Fiji', dialCode: '+679' },
    { code: 'FI', name: 'Finland', dialCode: '+358' },
    { code: 'FR', name: 'France', dialCode: '+33' },
    { code: 'GA', name: 'Gabon', dialCode: '+241' },
    { code: 'GM', name: 'Gambia', dialCode: '+220' },
    { code: 'GE', name: 'Georgia', dialCode: '+995' },
    { code: 'DE', name: 'Germany', dialCode: '+49' },
    { code: 'GH', name: 'Ghana', dialCode: '+233' },
    { code: 'GR', name: 'Greece', dialCode: '+30' },
    { code: 'GD', name: 'Grenada', dialCode: '+1' },
    { code: 'GT', name: 'Guatemala', dialCode: '+502' },
    { code: 'GN', name: 'Guinea', dialCode: '+224' },
    { code: 'GW', name: 'Guinea-Bissau', dialCode: '+245' },
    { code: 'GY', name: 'Guyana', dialCode: '+592' },
    { code: 'HT', name: 'Haiti', dialCode: '+509' },
    { code: 'HN', name: 'Honduras', dialCode: '+504' },
    { code: 'HU', name: 'Hungary', dialCode: '+36' },
    { code: 'IS', name: 'Iceland', dialCode: '+354' },
    { code: 'IN', name: 'India', dialCode: '+91' },
    { code: 'ID', name: 'Indonesia', dialCode: '+62' },
    { code: 'IR', name: 'Iran', dialCode: '+98' },
    { code: 'IQ', name: 'Iraq', dialCode: '+964' },
    { code: 'IE', name: 'Ireland', dialCode: '+353' },
    { code: 'IL', name: 'Israel', dialCode: '+972' },
    { code: 'IT', name: 'Italy', dialCode: '+39' },
    { code: 'JM', name: 'Jamaica', dialCode: '+1' },
    { code: 'JP', name: 'Japan', dialCode: '+81' },
    { code: 'JO', name: 'Jordan', dialCode: '+962' },
    { code: 'KZ', name: 'Kazakhstan', dialCode: '+7' },
    { code: 'KE', name: 'Kenya', dialCode: '+254' },
    { code: 'KI', name: 'Kiribati', dialCode: '+686' },
    { code: 'KW', name: 'Kuwait', dialCode: '+965' },
    { code: 'KG', name: 'Kyrgyzstan', dialCode: '+996' },
    { code: 'LA', name: 'Laos', dialCode: '+856' },
    { code: 'LV', name: 'Latvia', dialCode: '+371' },
    { code: 'LB', name: 'Lebanon', dialCode: '+961' },
    { code: 'LS', name: 'Lesotho', dialCode: '+266' },
    { code: 'LR', name: 'Liberia', dialCode: '+231' },
    { code: 'LY', name: 'Libya', dialCode: '+218' },
    { code: 'LI', name: 'Liechtenstein', dialCode: '+423' },
    { code: 'LT', name: 'Lithuania', dialCode: '+370' },
    { code: 'LU', name: 'Luxembourg', dialCode: '+352' },
    { code: 'MG', name: 'Madagascar', dialCode: '+261' },
    { code: 'MW', name: 'Malawi', dialCode: '+265' },
    { code: 'MY', name: 'Malaysia', dialCode: '+60' },
    { code: 'MV', name: 'Maldives', dialCode: '+960' },
    { code: 'ML', name: 'Mali', dialCode: '+223' },
    { code: 'MT', name: 'Malta', dialCode: '+356' },
    { code: 'MH', name: 'Marshall Islands', dialCode: '+692' },
    { code: 'MR', name: 'Mauritania', dialCode: '+222' },
    { code: 'MU', name: 'Mauritius', dialCode: '+230' },
    { code: 'MX', name: 'Mexico', dialCode: '+52' },
    { code: 'FM', name: 'Micronesia', dialCode: '+691' },
    { code: 'MD', name: 'Moldova', dialCode: '+373' },
    { code: 'MC', name: 'Monaco', dialCode: '+377' },
    { code: 'MN', name: 'Mongolia', dialCode: '+976' },
    { code: 'ME', name: 'Montenegro', dialCode: '+382' },
    { code: 'MA', name: 'Morocco', dialCode: '+212' },
    { code: 'MZ', name: 'Mozambique', dialCode: '+258' },
    { code: 'MM', name: 'Myanmar', dialCode: '+95' },
    { code: 'NA', name: 'Namibia', dialCode: '+264' },
    { code: 'NR', name: 'Nauru', dialCode: '+674' },
    { code: 'NP', name: 'Nepal', dialCode: '+977' },
    { code: 'NL', name: 'Netherlands', dialCode: '+31' },
    { code: 'NZ', name: 'New Zealand', dialCode: '+64' },
    { code: 'NI', name: 'Nicaragua', dialCode: '+505' },
    { code: 'NE', name: 'Niger', dialCode: '+227' },
    { code: 'NG', name: 'Nigeria', dialCode: '+234' },
    { code: 'KP', name: 'North Korea', dialCode: '+850' },
    { code: 'NO', name: 'Norway', dialCode: '+47' },
    { code: 'OM', name: 'Oman', dialCode: '+968' },
    { code: 'PK', name: 'Pakistan', dialCode: '+92' },
    { code: 'PW', name: 'Palau', dialCode: '+680' },
    { code: 'PA', name: 'Panama', dialCode: '+507' },
    { code: 'PG', name: 'Papua New Guinea', dialCode: '+675' },
    { code: 'PY', name: 'Paraguay', dialCode: '+595' },
    { code: 'PE', name: 'Peru', dialCode: '+51' },
    { code: 'PH', name: 'Philippines', dialCode: '+63' },
    { code: 'PL', name: 'Poland', dialCode: '+48' },
    { code: 'PT', name: 'Portugal', dialCode: '+351' },
    { code: 'QA', name: 'Qatar', dialCode: '+974' },
    { code: 'RO', name: 'Romania', dialCode: '+40' },
    { code: 'RU', name: 'Russia', dialCode: '+7' },
    { code: 'RW', name: 'Rwanda', dialCode: '+250' },
    { code: 'KN', name: 'Saint Kitts and Nevis', dialCode: '+1' },
    { code: 'LC', name: 'Saint Lucia', dialCode: '+1' },
    { code: 'VC', name: 'Saint Vincent', dialCode: '+1' },
    { code: 'WS', name: 'Samoa', dialCode: '+685' },
    { code: 'SM', name: 'San Marino', dialCode: '+378' },
    { code: 'ST', name: 'Sao Tome and Principe', dialCode: '+239' },
    { code: 'SA', name: 'Saudi Arabia', dialCode: '+966' },
    { code: 'SN', name: 'Senegal', dialCode: '+221' },
    { code: 'RS', name: 'Serbia', dialCode: '+381' },
    { code: 'SC', name: 'Seychelles', dialCode: '+248' },
    { code: 'SL', name: 'Sierra Leone', dialCode: '+232' },
    { code: 'SG', name: 'Singapore', dialCode: '+65' },
    { code: 'SK', name: 'Slovakia', dialCode: '+421' },
    { code: 'SI', name: 'Slovenia', dialCode: '+386' },
    { code: 'SB', name: 'Solomon Islands', dialCode: '+677' },
    { code: 'SO', name: 'Somalia', dialCode: '+252' },
    { code: 'ZA', name: 'South Africa', dialCode: '+27' },
    { code: 'KR', name: 'South Korea', dialCode: '+82' },
    { code: 'SS', name: 'South Sudan', dialCode: '+211' },
    { code: 'ES', name: 'Spain', dialCode: '+34' },
    { code: 'LK', name: 'Sri Lanka', dialCode: '+94' },
    { code: 'SD', name: 'Sudan', dialCode: '+249' },
    { code: 'SR', name: 'Suriname', dialCode: '+597' },
    { code: 'SZ', name: 'Swaziland', dialCode: '+268' },
    { code: 'SE', name: 'Sweden', dialCode: '+46' },
    { code: 'CH', name: 'Switzerland', dialCode: '+41' },
    { code: 'SY', name: 'Syria', dialCode: '+963' },
    { code: 'TW', name: 'Taiwan', dialCode: '+886' },
    { code: 'TJ', name: 'Tajikistan', dialCode: '+992' },
    { code: 'TZ', name: 'Tanzania', dialCode: '+255' },
    { code: 'TH', name: 'Thailand', dialCode: '+66' },
    { code: 'TL', name: 'Timor-Leste', dialCode: '+670' },
    { code: 'TG', name: 'Togo', dialCode: '+228' },
    { code: 'TO', name: 'Tonga', dialCode: '+676' },
    { code: 'TT', name: 'Trinidad and Tobago', dialCode: '+1' },
    { code: 'TN', name: 'Tunisia', dialCode: '+216' },
    { code: 'TR', name: 'Turkey', dialCode: '+90' },
    { code: 'TM', name: 'Turkmenistan', dialCode: '+993' },
    { code: 'TV', name: 'Tuvalu', dialCode: '+688' },
    { code: 'UG', name: 'Uganda', dialCode: '+256' },
    { code: 'UA', name: 'Ukraine', dialCode: '+380' },
    { code: 'AE', name: 'United Arab Emirates', dialCode: '+971' },
    { code: 'GB', name: 'United Kingdom', dialCode: '+44' },
    { code: 'US', name: 'United States', dialCode: '+1' },
    { code: 'UY', name: 'Uruguay', dialCode: '+598' },
    { code: 'UZ', name: 'Uzbekistan', dialCode: '+998' },
    { code: 'VU', name: 'Vanuatu', dialCode: '+678' },
    { code: 'VA', name: 'Vatican City', dialCode: '+379' },
    { code: 'VE', name: 'Venezuela', dialCode: '+58' },
    { code: 'VN', name: 'Vietnam', dialCode: '+84' },
    { code: 'YE', name: 'Yemen', dialCode: '+967' },
    { code: 'ZM', name: 'Zambia', dialCode: '+260' },
    { code: 'ZW', name: 'Zimbabwe', dialCode: '+263' },
];

// Default to Kenya
const selectedCountry = ref(countries.find(c => c.code === 'KE') || countries[0]);

const filteredCountries = computed(() => {
    if (!searchQuery.value) return countries;
    const query = searchQuery.value.toLowerCase();
    return countries.filter(country =>
        country.name.toLowerCase().includes(query) ||
        country.dialCode.includes(query) ||
        country.code.toLowerCase().includes(query)
    );
});

const toggleCountryDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
    if (isDropdownOpen.value) {
        searchQuery.value = '';
    }
};

const selectCountry = (country: typeof countries[0]) => {
    selectedCountry.value = country;
    isDropdownOpen.value = false;
    searchQuery.value = '';
};

// Handle click outside
const handleClickOutside = (event: MouseEvent) => {
    const target = event.target as HTMLElement;
    if (isDropdownOpen.value && !target.closest('.relative')) {
        isDropdownOpen.value = false;
    }
};

// Prevent scroll on body when dropdown is open
watch(isDropdownOpen, (newVal) => {
    if (newVal) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = props.show ? 'hidden' : 'unset';
    }
});

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
    document.body.style.overflow = 'unset';
});

const form = useForm({
    fullName: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
    keepUpdated: false,
    countryCode: 'KE'
});

const closeModal = () => {
    emit('update:show', false);
    emit('close');
    isDropdownOpen.value = false;
};

const submitForm = () => {
    submitting.value = true;

    const formData = {
        fullName: form.fullName,
        email: form.email,
        phone: form.phone,
        subject: form.subject,
        message: form.message,
        keepUpdated: form.keepUpdated,
        countryCode: selectedCountry.value.code,
        dialCode: selectedCountry.value.dialCode,
        fullPhoneNumber: `${selectedCountry.value.dialCode}${form.phone}`
    };

    form.post('/contact', {
        preserveScroll: true,
        data: formData,
        onSuccess: () => {
            form.reset();
            $toast.success('Your message has been sent successfully! We will get back to you soon.', {
                position: 'top-right',
                duration: 5000,
                dismissible: true,
            });
            closeModal();
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
        },
        onFinish: () => {
            submitting.value = false;
        }
    });
};

// Prevent body scroll when modal is open
watch(() => props.show, (newVal) => {
    if (newVal) {
        document.body.style.overflow = 'hidden';
        isDropdownOpen.value = false;
    } else {
        document.body.style.overflow = 'unset';
    }
});
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    box-sizing: border-box;
    overflow-y: auto;
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: -1;
}

.modal-container {
    position: relative;
    width: min(100%, 500px);
    max-width: 500px;
    margin: 0;
    z-index: 10000;
    animation: modalSlideUp 0.3s ease-out;
}

.modal-content {
    position: relative;
    width: 100%;
}

.modal-content input:not([type="checkbox"]),
.modal-content select,
.modal-content textarea {
    font-size: 0.9375rem;
}

.modal-content label {
    font-size: 0.8125rem;
}

.close-button {
    position: absolute;
    top: -12px;
    right: -12px;
    z-index: 10;
    background: #001221;
    border: 2px solid white;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.close-button:hover {
    background: #002a3d;
    transform: scale(1.1);
}

/* Custom scrollbar for dropdown */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Modal Transitions */
.modal-enter-active,
.modal-leave-active {
    transition: all 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
    transform: scale(0.9) translateY(20px);
}

@keyframes modalSlideUp {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .modal-container {
        width: 100%;
    }

    .modal-content .p-6 {
        padding: 1rem;
    }
}
</style>
