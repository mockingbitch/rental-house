<template>
    <div class="checkbox__form-wrap">
        <input type="checkbox" :id="id" v-model="isChecked"/>
        <label :for="id">{{ label }}</label>
    </div>
</template>
<script setup>
import { ref, defineProps } from "vue";

const { label, value } = defineProps(["label", "value"]);
const id = `checkbox-${label}`;
const isChecked = ref(false);
</script>
<style scoped lang="scss">
.checkbox__form-wrap {
    display: flex;
    flex-direction: row;
    gap: 10px;
    align-items: center;
    input:checked {
        border: none;
    }
}
</style>
