<script setup>
import HeaderNoLogin from '@/Components/Header/HeaderNoLogin.vue';
import Footer from '@/Components/Footer/Footer.vue';
</script>

<template>
    <HeaderNoLogin />
    <main id="content">
        <slot />
    </main>
    <Footer />
</template>

<style lang="scss" scoped>
@import './layoutnologin';
</style>
