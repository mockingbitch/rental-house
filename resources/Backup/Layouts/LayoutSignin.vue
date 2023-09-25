<script setup>
import HeaderSignin from '@/Components/HeaderSignin.vue';
import Footer from '@/Components/Footer.vue';

</script>

<template>
    <HeaderSignin />
    <main>
        <slot />
    </main>
    <Footer />
</template>