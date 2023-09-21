<script setup>
defineProps({
    showModal: Boolean
})

const emit = defineEmits(['completeTodo']);
</script>

<template>
    <transition name="fade" appear>
        <div class="modal-overlay" v-if="showModal" @click="emit('close')"></div>
    </transition>
    <transition name="slide" appear>
        <div class="modal" v-if="showModal">
            <slot />
        </div>
    </transition>
</template>

<style lang="scss" scoped>
@import './_modal.scss';
</style>