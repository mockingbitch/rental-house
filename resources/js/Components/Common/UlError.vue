<script setup>
defineProps(['message']);
</script>

<template>
    <ul v-show="message" class="error-msg">
        <li>{{ message }}</li>
    </ul>
</template>

<style lang='scss' scoped>
@import './ulerror';
</style>