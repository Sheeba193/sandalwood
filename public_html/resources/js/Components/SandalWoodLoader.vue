<template>
    <Transition name="fade" appear>
        <div v-if="visible" class="fixed inset-0 z-[9999] flex items-center justify-center bg-white">
            <div class="relative w-[180px] h-[180px] flex items-center justify-center">

                <div class="loader"></div>

                <div class="absolute z-10 w-[100px] h-[100px] flex items-center justify-center rounded-full">
                    <img
                        :src="logoSrc"
                        :alt="brandText"
                        class="h-full w-auto object-contain animate-pulse-logo"
                    />
                </div>

                <div class="absolute top-[115%] text-center w-[300px]">
                    <div class="text-lg tracking-[6px] text-gray-800 uppercase font-normal">
                        {{ brandText }}<span class="loading-dots text-amber-700"></span>
                    </div>
                </div>

            </div>
        </div>
    </Transition>
</template>

<script lang="ts" setup>

const props = defineProps({
    visible: {
        type: Boolean,
        default: true
    },
    logoSrc: {
        type: String,
        default: '/images/image_963ddc.png'
    },
    brandText: {
        type: String,
        default: 'SANDALWOOD'
    }
});
</script>

<style scoped>
/* --- TRANSITIONS (Vue built-in) --- */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.8s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* --- CSS LOADER --- */
.loader {
    position: absolute;
    width: 100%;
    height: 100%;
    display: grid;
    border: 4px solid #0000;
    border-radius: 50%;
    border-right-color: #b8860b; /* Sandalwood Gold */
    animation: l15 1s infinite linear;
    z-index: 1;
}

.loader::before,
.loader::after {
    content: "";
    grid-area: 1/1;
    margin: 2px;
    border: inherit;
    border-radius: 50%;
    animation: l15 2s infinite;
}

.loader::after {
    margin: 8px;
    animation-duration: 3s;
}

@keyframes l15 {
    100% { transform: rotate(1turn) }
}

/* Logo Animation */
@keyframes pulse-logo {
    0%, 100% {
        transform: scale(0.95);
        opacity: 0.8;
        filter: grayscale(100%);
    }
    50% {
        transform: scale(1.05);
        opacity: 1;
        filter: sepia(1) hue-rotate(5deg) saturate(3);
    }
}

.animate-pulse-logo {
    animation: pulse-logo 2s ease-in-out infinite;
}

/* Loading Dots Animation */
.loading-dots::after {
    content: ' .';
    animation: dots 1.5s steps(5, end) infinite;
}

@keyframes dots {
    0%, 20% { content: ' .'; }
    40% { content: ' ..'; }
    60% { content: ' ...'; }
    80%, 100% { content: ''; }
}
</style>
