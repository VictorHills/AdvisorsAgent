<template>
  <div style="min-height:100vh; display:flex; flex-direction:column;">
    <Navbar />
    <main style="flex:1;">
      <div class="container" style="padding:20px;">
        <router-view />
      </div>
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';
</script>
