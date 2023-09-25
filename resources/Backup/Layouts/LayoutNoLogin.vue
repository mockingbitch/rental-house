<script setup>
import HeaderNoLogin from '@/Components/HeaderNoLogin.vue';
import Footer from '@/Components/Footer.vue';

</script>

<template>
    <HeaderNoLogin />
    <main id="content">
        <slot />
    </main>
    <Footer />
</template>

<style lang="scss" scoped>
#content {
    min-height: calc(100vh - 100px - 80px);
}
</style>
