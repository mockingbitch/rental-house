<script setup>
defineProps(['message']);
</script>

<template>
    <div v-show="message" class="errorMsg2">
        <p>{{ message }}</p>
    </div>
</template>
