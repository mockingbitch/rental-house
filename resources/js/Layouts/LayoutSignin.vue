<script setup>
import HeaderSignin from '@/Components/Header/HeaderSignin.vue';
import Footer from '@/Components/Footer/Footer.vue';
</script>

<template>
    <HeaderSignin />
    <main>
        <slot />
    </main>
    <Footer />
</template>

<style lang='scss' scoped>
@import './layoutsignin';
</style>