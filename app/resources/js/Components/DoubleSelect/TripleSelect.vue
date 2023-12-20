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
            <p class="to-text">{{ textTo }}</p>
            <div class="select" style="flex-grow: 1">
                <label class="label" for="Title" style="opacity: 0">
                    <span class="title-text">{{ label2 }}</span>
                </label>
                <CustomSelect
                    :icon="!hideIcon2 && icon"
                    :value-selected="attrs?.selected2"
                    :options="options2"
                    :unit="unit"
                    :place-holder="placeholder2"
                    @selectValue="handleSelect2"
                />
            </div>
            <p class="to-text">{{ textTo }}</p>
            <div class="select" style="flex-grow: 1">
                <label class="label" for="Title" style="opacity: 0">
                    <span class="title-text">{{ label3 }}</span>
                </label>
                <CustomSelect
                    :icon="!hideIcon3 && icon"
                    :value-selected="attrs?.selected3"
                    :options="options3"
                    :unit="unit"
                    :place-holder="placeholder3"
                    @selectValue="handleSelect3"
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
    label2,
    label3,
    options1,
    options2,
    options3,
    textTo,
    icon,
    unit,
    placeholder1,
    placeholder2,
    placeholder3,
    hideIcon2 = false
} = defineProps([
    "label1",
    "label2",
    "label3",
    "options1",
    "options2",
    "options3",
    "textTo",
    "icon",
    "unit",
    "placeholder1",
    "placeholder2",
    "placeholder3",
    "hideIcon2",
    "hideIcon3"
]);
const selected1 = ref(attrs?.selected1 ?? "");
const selected2 = ref(attrs?.selected2 ?? "");
const selected3 = ref(attrs?.selected3 ?? "");

const emit = defineEmits();

watch(selected1, (value) => {
    emit("update:selected1", value);
});
watch(selected2, (value) => {
    emit("update:selected2", value);
});
watch(selected3, (value) => {
    emit("update:selected3", value);
});
const handleSelect1 = (value) => {
    emit("update:selected1", value);
};
const handleSelect2 = (value) => {
    emit("update:selected2", value);
};
const handleSelect3 = (value) => {
    emit("update:selected3", value);
};
</script>

<style lang="scss" scoped>
@import "./doubleselect";
</style>
