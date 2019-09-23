<template>
    <div>
        <navbar />

        <main>
            <div class="w-full max-w-6xl mx-auto p-4">
                <article>
                    <slot />
                </article>
            </div>
        </main>
    </div>
</template>

<script>
import Navbar from '@/Shared/Navbar'

export default {
     components: {
         Navbar,
     }
}
</script>
