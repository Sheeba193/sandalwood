import { ref, onMounted, onUnmounted } from 'vue'

export function useSidebar() {
    const sidebarOpen = ref(false)

    const toggleSidebar = () => {
        sidebarOpen.value = !sidebarOpen.value
    }

    const closeSidebar = () => {
        sidebarOpen.value = false
    }

    const handleEscape = (event: KeyboardEvent) => {
        if (event.key === 'Escape' && sidebarOpen.value) {
            closeSidebar()
        }
    }

    onMounted(() => {
        document.addEventListener('keydown', handleEscape)
    })

    onUnmounted(() => {
        document.removeEventListener('keydown', handleEscape)
    })

    return {
        sidebarOpen,
        toggleSidebar,
        closeSidebar
    }
}
