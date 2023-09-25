<template>
    <div class="request__form-wrap">
        <div>{{ label }}</div>
        <!-- <select v-model="selected" class="request__form-wrap-options">
            <option disabled value="" style="display: none">{{ title }}</option>
            <option v-for="option in options" :value="option.id ? option.id : option" :key="option.id">
                {{ option.name_en ? option.name_en : option }}
            </option>
        </select> -->
        <select v-bind:value="attrs?.selected" v-on:input="selected = $event.target.value" class="request__form-wrap-options" :class="selectClass">
            <option disabled value="" style="display: none">{{ title }}</option>
            <option
                v-for="option in options"
                :value="option.id ? option.id : option"
                :key="option.id"
            >
                {{ option.name_en ? option.name_en : option }}
            </option>
        </select>
    </div>
</template>
<script setup>
import { ref, defineProps, defineEmits, watch, useAttrs, computed } from "vue";

const attrs = useAttrs();
const { label, options, title } = defineProps(["label", "options", "title"]);
const selected = ref(attrs?.selected ?? "");
const emit = defineEmits();

watch(selected, (value) => {
    emit("update:selected", value);
});

const selectClass = computed(() => {
    return {
        "request__form-wrap-options": true,
        "gray-color-class": selected.value === "",
    };
});
</script>

<style scoped>
.request__form-wrap-options {
    background-image: url(../../../../../public/img/CaretDown.svg);
    background-repeat: no-repeat;
    background-position: calc(100% - 0.75rem) center !important;
}

.gray-color-class {
    color: #B1B1B1;
}
</style>
