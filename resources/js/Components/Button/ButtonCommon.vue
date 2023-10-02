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
<script setup>
import { defineProps } from "vue";

const { label, submitButton } = defineProps(["label", "submitButton"]);

const submitButtonStyles = {
    backgroundColor: submitButton ? "#5392F9 " : "transparent",
    color: submitButton ? "white" : "#5392F9 ",
    textDecoration: submitButton ? "none" : "underline",
};

const emit = defineEmits();
const handleClick = () => {
    emit("click", submitButton);
};
</script>
<style scoped>
.submit__button {
    max-height: 50px;
    padding: 16px;
    border-radius: 4px;
    margin-top: 32px;
    border: none;
    cursor: pointer;
    background-image: url(../../../../public/img/icon/RequestClass/caretright.svg);
    background-repeat: no-repeat;
    background-position: calc(100% - 16px) center !important;
    font-family: 'Noto Sans JP';
    font-size: 14px;
}
</style>
