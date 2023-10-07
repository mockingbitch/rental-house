<template>
    <div>
        <VueDatePicker
            :enableTimePicker="false"
            @update:modelValue="updateDate"
            v-model="date"
            class="datepicker form__wrap-item-datepicker"
            format="yyyy/MM/dd"
        />
    </div>
</template>

<script setup>
import { ref } from "vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const date = ref();
const emit = defineEmits(["update:modelValue"]);

const updateDate = newDate => {
    date.value = newDate;
    emit("update:modelValue", newDate);
};
</script>
<style lang='scss' scoped>
@import './datepicker'
</style>
