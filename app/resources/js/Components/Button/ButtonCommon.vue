<script setup>
const emit = defineEmits();

const { label, submitButton } = defineProps([
    "label",
    "submitButton"
    ]);

const submitButtonStyles = {
    backgroundColor: submitButton ? "#5392F9 " : "transparent",
    color: submitButton ? "white" : "#5392F9 ",
    textDecoration: submitButton ? "none" : "underline",
};

const handleClick = () => {
    emit("click", submitButton);
};
</script>

<template>
    <button
        :style="{
            ...submitButtonStyles,
        }"
        class="submit__button"
    >
        {{ label }}
    </button>
</template>

<style lang='scss' scoped>
@import './buttoncommon';
</style>
