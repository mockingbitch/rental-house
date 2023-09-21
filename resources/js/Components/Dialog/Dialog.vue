<script setup>
import { defineProps, ref, defineEmits, watch } from "vue";
const props = defineProps(["showDialog"]);
const emits = defineEmits(["close-dialog"]); // Declare the custom event here

const isDialogVisible = ref(props.showDialog);

watch(
    () => props.showDialog,
    (newValue) => {
        isDialogVisible.value = newValue;
    }
);

const closeDialogOutside = () => {
    // Emit a custom event to notify the parent component to close the dialog
    emits("close-dialog");
};
</script>

<template>
    <transition name="fade" appear>
        <div
            class="modal-overlay"
            v-if="isDialogVisible"
            @click="closeDialogOutside"
        ></div>
    </transition>
    <transition name="slide" appear>
        <div class="dialog" v-if="isDialogVisible">
            <slot />
        </div>
    </transition>
</template>

<style lang="scss" scoped>
@import "./_dialog.scss";
</style>
