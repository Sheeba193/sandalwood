<template>
    <div class="relative">
        <button
            @click="showUserMenu = !showUserMenu"
            class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                <span class="text-blue-600 font-medium text-sm">
                    {{ $page.props.auth.user.name.split(' ').map(n => n[0]).join('').toUpperCase() }}ww
                </span>
            </div>
        </button>

        <!-- User Dropdown Menu -->
        <div
            v-show="showUserMenu"
            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
        >
            <div class="py-1">
                <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100">
                    Signed in as<br>
                    <span class="font-medium text-gray-900">{{ $page.props.auth.user.name }}</span>
                </div>
                <Link
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                    Your Profile
                </Link>
                <form @submit.prevent="logout">
                    <button
                        type="submit"
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    >
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'

const showUserMenu = ref(false)

// Close dropdown when clicking outside
const closeUserMenu = (e) => {
    if (!e.target.closest('.relative')) {
        showUserMenu.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', closeUserMenu)
})

onUnmounted(() => {
    document.removeEventListener('click', closeUserMenu)
})

const form = useForm({})

const logout = () => {
    form.post(route('admin.logout'))
}
</script>
