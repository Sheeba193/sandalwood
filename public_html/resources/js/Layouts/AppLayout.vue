<!-- <template>
    <div>
        <Navbar />
        <main>
            <slot />
        </main>
        <Footer />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
</script> -->


<template>
    <div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300">
        <Navbar />
        <main class="flex-1">
            <slot />
        </main>
        <Footer />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
</script>