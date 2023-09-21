<template>
    <div class="request__form-wrap">
        <div>{{ label }}</div>
        <div class="request__form-range">
            <div class="request__form-range-container">
                <!-- <select v-model="selected1" class="request__form-range-item">
                    <option disabled value="" style="display: none">
                        {{ title }}
                    </option>
                    <option
                        v-for="option in options1"
                        :value="option"
                        :key="option.id"
                    >
                        {{ option }}
                    </option>
                </select> -->
                <select
                    v-bind:value="attrs?.selected1"
                    v-on:input="selected1 = $event.target.value"
                    class="request__form-range-item"
                    :class="selectClass"
                >
                    <option disabled value="" style="display: none">
                        {{ title }}
                    </option>
                    <option
                        v-for="option in options1"
                        :value="option"
                        :key="option.id"
                    >
                        {{ option }}
                    </option>
                </select>
                <img :src="icon" alt="" />
                <UlError :message="errorMsg1" />
            </div>
            <div>to</div>
            <!-- <select v-model="selected2" class="request__form-range-item">
                <option disabled value="" style="display: none">
                    {{ title }}
                </option>
                <option
                    v-for="option in options2"
                    :value="option"
                    :key="option.id"
                >
                    {{ option }}
                </option>
            </select> -->
            <div class="request__form-range-container">
                <select
                    v-bind:value="attrs?.selected2"
                    v-on:input="selected2 = $event.target.value"
                    class="request__form-range-item"
                    :class="selectClass"
                >
                    <option disabled value="" style="display: none">
                        {{ title }}
                    </option>
                    <option
                        v-for="option in options2"
                        :value="option"
                        :key="option.id"
                    >
                        {{ option }}
                    </option>
                </select>
                <UlError :message="errorMsg2" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch, useAttrs, computed } from "vue";
import UlError from "@/Components/UlError.vue";

const attrs = useAttrs();
const { label, options1, options2, title, icon, errorMsg1, errorMsg2 } =
    defineProps([
        "label",
        "options1",
        "options2",
        "title",
        "icon",
        "errorMsg1",
        "errorMsg2",
    ]);
console.log(errorMsg2);
const selected1 = ref(attrs?.selected1 ?? "");
const selected2 = ref(attrs?.selected2 ?? "");

const emit = defineEmits();

watch(selected1, (value) => {
    emit("update:selected1", value);
});
watch(selected2, (value) => {
    emit("update:selected2", value);
});

const selectClass = computed(() => {
    return {
        "request__form-wrap-options": true,
        "gray-color-class": selected1.value === "" || selected2.value === "",
    };
});
</script>

<style lang="scss" scoped>
.request__form-range-item {
    background-image: url(../../../../../public/img/CaretDown.svg);
    background-repeat: no-repeat;
    background-position: calc(100% - 10px) center !important;
}
.request__form-range-container {
    position: relative;
    width: 100%;
    .request__form-range-item:first-child {
        padding-left: 34px;
    }
    img {
        position: absolute;
        left: 10px;
        top: 55%;
        transform: translateY(-50%);
    }
}
.gray-color-class {
    color: #b1b1b1;
}
</style>
