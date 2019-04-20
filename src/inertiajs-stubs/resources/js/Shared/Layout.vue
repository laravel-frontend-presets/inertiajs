<template>
  <div>
    <header>
      <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
          <inertia-link class="navbar-brand" href="/">Inertia.js</inertia-link>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="mainNav">

            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <inertia-link class="nav-link" href="/about">About</inertia-link>
              </li>
              <li class="nav-item">
                <inertia-link class="nav-link" href="/contact">Contact</inertia-link>
              </li>
            </ul>
          
          </div>
        </div>
      </nav>
    </header>
    <main class="py-4">
      <div class="container">
        <div class="row">
          <div class="col">
            <article>
              <slot />
            </article>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import { InertiaLink } from 'inertia-vue'

export default {
  components: {
    InertiaLink,
  },
}
</script>
