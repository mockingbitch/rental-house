<template>
    <div class="form__wrap-item">
        <div id="form-wrap-double">
            <div class="select" style="flex-grow: 1">
                <label for="Title">
                    <span class="title-text">{{ label1 }}</span>
                </label>
                <CustomSelect
                    :icon="icon"
                    :value-selected="attrs?.selected1"
                    :options="options1"
                    :unit="unit"
					:placeHolder="placeholder1"
                    @selectValue="handleSelect1"
                />
            </div>
            <p class="to-text">to</p>
            <div class="select" style="flex-grow: 1">
                <label for="Title">
                    <span class="title-text">{{ label2 }}</span>
                </label>
                <CustomSelect
                    :icon="icon"
                    :value-selected="attrs?.selected2"
                    :options="options2"
                    :unit="unit"
					:placeHolder="placeholder2"
                    @selectValue="handleSelect2"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch, useAttrs } from "vue";
import CustomSelect from "./CustomSelect.vue";

const attrs = useAttrs();
const {
    label1,
    label2,
    options1,
    options2,
    icon,
    unit,
    placeholder1,
    placeholder2,
} = defineProps([
    "label1",
    "label2",
    "options1",
    "options2",
    "icon",
    "unit",
    "placeholder1",
    "placeholder2",
]);
const selected1 = ref(attrs?.selected1 ?? "");
const selected2 = ref(attrs?.selected2 ?? "");

const emit = defineEmits();

watch(selected1, (value) => {
    emit("update:selected1", value);
});
watch(selected2, (value) => {
    emit("update:selected2", value);
});
const handleSelect1 = (value) => {
    emit("update:selected1", value);
};
const handleSelect2 = (value) => {
    emit("update:selected2", value);
};
</script>

<style lang="scss" scoped>
#form-wrap-double {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    .select {
        flex: 1;
        .select__title-text {
            font-size: 16px;
            font-weight: 400;
            line-height: 19px;
            letter-spacing: -0.01em;
            color: #1b1b1b;
        }
    }
    #half_width {
        width: 127.5px;
        display: flex;
        padding: 12.5px 10px 12.5px 36px;
        flex: 1;
        max-height: 44px;
        margin-top: 6.5px;
        border: none;
        color: #b1b1b1;

        &.half-width-big {
            width: 100%;
            margin-top: 0;
            background-image: url(../../../../../public/img/CaretDown.svg);
            background-repeat: no-repeat;
            background-position: calc(100% - 0.75rem) center !important;

            &:hover {
                cursor: pointer;
            }
        }

        &:focus-visible {
            outline: none;
        }
    }
    .active {
        border-color: #1b1b1b !important;
        color: #1b1b1b !important;
    }
    p {
        margin: 35px 0px 10px;
    }
    span {
        display: flex;
        align-items: center;
    }
}
.to-text {
    width: 12px;
    font-size: 16px;
    font-weight: 400;
    line-height: 19px;
    letter-spacing: -0.01em;
    text-align: center;
    margin-right: 8px !important;
    margin-left: 8px !important;
    color: #000;
}
.dbSelect__wrapper {
    .dbSelectIcon {
        position: absolute;
        top: 50%;
        left: 12.5px;
        transform: translateY(-50%);
    }
}

.title-text {
    font-size: 16px;
    font-weight: 400;
    line-height: 19px;
    letter-spacing: -0.01em;
    color: #1b1b1b;
}

.fillInput {
    border-color: #1b1b1b;

    select {
        color: #1b1b1b !important;
    }
}
</style>
