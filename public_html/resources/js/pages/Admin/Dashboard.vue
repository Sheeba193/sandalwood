<template>
    <AdminLayout>

    </AdminLayout>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const logout = () => {
    router.post('/admin/logout');
};
</script>
