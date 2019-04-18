<template>
  <main>
    <header>
      <inertia-link href="/">Home</inertia-link>
      <inertia-link href="/about">About</inertia-link>
      <inertia-link href="/contact">Contact</inertia-link>
    </header>
    <article>
      <slot />
    </article>
  </main>
</template>

<script>
import { InertiaLink } from 'inertia-vue'

export default {
  components: {
    InertiaLink,
  },
}
</script>
