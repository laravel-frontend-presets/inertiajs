<template>
    <header class="bg-white shadow">
        <div class="w-full max-w-6xl mx-auto sm:flex sm:justify-between sm:items-center sm:px-4 sm:py-3">
            <div class="flex justify-between items-center px-4 py-3 sm:p-0">
                <div>
                    <inertia-link class="navbar-brand" href="/">Inertia.js</inertia-link>
                </div>

                <div class="sm:hidden">
                    <button @click="isOpen = !isOpen" type="button" class="block text-gray-700 hover:text-gray-600 focus:text-gray-600 focus:outline-none">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path v-if="isOpen" fill-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"/>
                            <path v-if="!isOpen" fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <nav :class="isOpen ? 'block' : 'hidden'" class="px-2 pb-4 sm:flex sm:p-0">
                <inertia-link class="block px-2 py-1 text-gray-700 font-semibold rounded hover:bg-gray-100 focus:bg-gray-100 focus:outline-none" href="/about">About</inertia-link>
                <inertia-link class="mt-1 block px-2 py-1 text-gray-700 font-semibold rounded hover:bg-gray-100 focus:bg-gray-100 focus:outline-none sm:mt-0 sm:ml-2" href="/contact">Contact</inertia-link>
            </nav>
        </div>
    </header>
</template>

<script>
export default {
    data() { 
        return {
            isOpen: false,
        }
    }
}
</script>
