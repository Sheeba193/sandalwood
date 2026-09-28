<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo/Brand -->
            <div class="text-center">
                <div class="flex justify-center">
                    <div class="h-16 w-16 bg-gradient-to-r from-amber-500 to-amber-600 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">S</span>
                    </div>
                </div>
                <h2 class="mt-6 text-3xl font-cinzel font-bold text-white">
                    Admin Portal
                </h2>
                <p class="mt-2 text-sm text-gray-400">
                    Sign in to manage your projects
                </p>
            </div>

            <!-- Login Form -->
            <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            placeholder="Email address"
                        />
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input
                            id="password"
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            required
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            placeholder="Password"
                        />
                    </div>

                    <!-- Show/Hide Password Toggle -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="show-password"
                                v-model="showPassword"
                                type="checkbox"
                                class="h-4 w-4 text-amber-500 focus:ring-amber-500 border-gray-600 rounded bg-gray-700"
                            />
                            <label for="show-password" class="ml-2 block text-sm text-gray-400">
                                Show password
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="#" @click.prevent="forgotPassword" class="font-medium text-amber-500 hover:text-amber-400">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div v-if="errorMessage" class="rounded-md bg-red-900/50 border border-red-500 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-300">{{ errorMessage }}</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        :disabled="loading"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                    >
                        <span v-if="!loading" class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-amber-300 group-hover:text-amber-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span v-if="!loading" class="ml-8">Sign in</span>
                        <span v-else class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Signing in...
                        </span>
                    </button>
                </div>

                <!-- Demo Credentials -->
                <div class="text-center text-sm">
                    <p class="text-gray-400">Demo Credentials:</p>
                    <p class="text-xs text-gray-500 mt-1">Email: admin@sandalwood.com | Password: password</p>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const form = ref({
    email: '',
    password: ''
});

const loading = ref(false);
const errorMessage = ref('');
const showPassword = ref(false);

const handleLogin = async () => {
    loading.value = true;
    errorMessage.value = '';

    router.post('/admin/login', form.value, {
        onSuccess: () => {
            // Redirect to admin dashboard on success
            router.visit('/admin/dashboard');
        },
        onError: (errors) => {
            if (errors.email || errors.password) {
                errorMessage.value = 'Invalid email or password';
            } else {
                errorMessage.value = 'An error occurred. Please try again.';
            }
            loading.value = false;
        },
        onFinish: () => {
            loading.value = false;
        }
    });
};

const forgotPassword = () => {
    router.visit('/admin/forgot-password');
};
</script>

<style scoped>
.font-cinzel {
    font-family: 'Cinzel', serif;
}
</style>
