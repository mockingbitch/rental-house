<template>
    <div class="form__wrap-item">
        <div id="form-wrap-double">
            <div class="select">
                <label class="label" for="Title">
                    <span class="title-text">{{ label1 }}</span>
                </label>
                <CustomSelect
                    :icon="icon"
                    :value-selected="attrs?.selected1"
                    :options="options1"
                    :unit="unit"
                    :place-holder="placeholder1"
                    @selectValue="handleSelect1"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch, useAttrs } from "vue";
import CustomSelect from "@/Components/CustomSelect/CustomSelect.vue";

const attrs = useAttrs();
const {
    label1,
    options1,
    textTo,
    icon,
    unit,
    placeholder1,
} = defineProps([
    "label1",
    "options1",
    "textTo",
    "icon",
    "unit",
    "placeholder1",
]);
const selected1 = ref(attrs?.selected1 ?? "");

const emit = defineEmits();

watch(selected1, (value) => {
    emit("update:selected1", value);
});
const handleSelect1 = (value) => {
    emit("update:selected1", value);
};
</script>

<style lang="scss" scoped>
@import "./doubleselect";
</style>
