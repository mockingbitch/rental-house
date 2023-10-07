<template>
    <button
        :style="{
            ...submitDeleteButtonStyles,
        }"
        class="submit__button"
    >
        {{ label }}
    </button>
</template>
<script setup>
import { defineProps } from "vue";

const { label, submitButton } = defineProps(["label", "submitButton"]);

const submitDeleteButtonStyles = {
    backgroundColor: submitButton ? "#E71A41" : "white",
    color: submitButton ? "white" : "#1B1B1B",
    border: submitButton ? "none" : "1px solid black",
};

const emit = defineEmits();
const handleClick = () => {
    emit("click", submitButton);
};
</script>
<style scoped>
.submit__button {
    width: 100%;
    max-width: 179px;
    max-height: 50px;
    padding: 12px 16px;
    border-radius: 4px;
    margin-top: 32px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-family: "Noto Sans JP";
}
</style>
