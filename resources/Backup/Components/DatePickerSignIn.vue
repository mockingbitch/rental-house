<template>
  <div>
    <VueDatePicker
      class="datepicker form__wrap-item-datepicker"
      :enableTimePicker="false"
      format="yyyy/MM/dd"
      v-model="date"
      @update:modelValue="updateDate"
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
<style scoped>
:deep(.dp__menu_inner) {
  font-size: 14px;
}
:deep(.dp__pointer.dp__input_readonly.dp__input.dp__input_icon_pad.dp__input_reg) {
  font-size: 14px;
  display: flex;
  align-items: center;
  padding: 7.5px 10.5px 7.5px 40px;
}
:deep(.dp__selection_preview) {
  font-size: 14px;
}

@media screen and (max-width: 991px) {
  :deep(.dp__pointer.dp__input_readonly.dp__input.dp__input_icon_pad.dp__input_reg) {
    padding: 12px 10.5px 12px 40px;
  }
}
</style>
