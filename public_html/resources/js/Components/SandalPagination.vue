<template>
    <div v-if="pagination.last_page > 0" class="flex items-center justify-center gap-2">
        <!-- Previous Button -->
        <button
            :disabled="currentPage === 1"
            class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white p-0 text-gray-700 transition-all hover:bg-gray-100 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50"
            @click="goToPrevPage"
        >
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd"
                      d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                      fill-rule="evenodd"/>
            </svg>
        </button>

        <!-- First Page -->
        <button
            :class="{
                'h-10 w-10 rounded-lg border border-blue-600 bg-blue-600 p-0 font-medium text-white': currentPage === 1,
                'h-10 w-10 rounded-lg border border-gray-300 bg-white p-0 font-medium text-gray-700 transition-all hover:bg-gray-100 hover:shadow-sm': currentPage !== 1
            }"
            @click="goToPage(1)"
        >
            1
        </button>

        <!-- Ellipsis Before -->
        <span v-if="showEllipsisBefore" class="flex h-10 w-10 items-center justify-center text-gray-500">...</span>

        <!-- Middle Pages -->
        <template v-for="page in visiblePages" :key="page">
            <button
                :class="{
                    'h-10 w-10 rounded-lg border border-blue-600 bg-blue-600 p-0 font-medium text-white': page === currentPage,
                    'h-10 w-10 rounded-lg border border-gray-300 bg-white p-0 font-medium text-gray-700 transition-all hover:bg-gray-100 hover:shadow-sm': page !== currentPage
                }"
                @click="goToPage(page)"
            >
                {{ page }}
            </button>
        </template>

        <!-- Ellipsis After -->
        <span v-if="showEllipsisAfter" class="flex h-10 w-10 items-center justify-center text-gray-500">...</span>

        <!-- Last Page (only show if different from first page) -->
        <button
            v-if="pagination.last_page > 1"
            :class="{
                'h-10 w-10 rounded-lg border border-blue-600 bg-blue-600 p-0 font-medium text-white': currentPage === pagination.last_page,
                'h-10 w-10 rounded-lg border border-gray-300 bg-white p-0 font-medium text-gray-700 transition-all hover:bg-gray-100 hover:shadow-sm': currentPage !== pagination.last_page
            }"
            @click="goToPage(pagination.last_page)"
        >
            {{ pagination.last_page }}
        </button>

        <!-- Next Button -->
        <button
            :disabled="currentPage === pagination.last_page"
            class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white p-0 text-gray-700 transition-all hover:bg-gray-100 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50"
            @click="goToNextPage"
        ><!--test-->
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd"
                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                      fill-rule="evenodd"/>
            </svg>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        pagination: {
            type: Object,
            required: true
        },
        currentPage: {
            type: Number,
            required: true
        }
    },
    computed: {
        visiblePages() {
            const maxVisible = 3;
            const range = [];

            // Don't show middle pages if only one page
            if (this.pagination.last_page <= 1) return range;

            let start = Math.max(2, this.currentPage - 1);
            let end = Math.min(this.pagination.last_page - 1, start + maxVisible - 1);

            // Adjust start if we're at the end
            if (end === this.pagination.last_page - 1) {
                start = Math.max(2, end - maxVisible + 1);
            }

            for (let i = start; i <= end; i++) {
                range.push(i);
            }

            return range;
        },
        showEllipsisBefore() {
            return this.currentPage > 3 && this.pagination.last_page > 5;
        },
        showEllipsisAfter() {
            return this.currentPage < this.pagination.last_page - 2 && this.pagination.last_page > 5;
        }
    },
    methods: {
        goToPage(page) {
            if (page !== this.currentPage) {
                this.$emit('page-changed', page);
            }
        },
        goToPrevPage() {
            if (this.currentPage > 1) {
                this.goToPage(this.currentPage - 1);
            }
        },
        goToNextPage() {
            if (this.currentPage < this.pagination.last_page) {
                this.goToPage(this.currentPage + 1);
            }
        }
    }
};
</script>
