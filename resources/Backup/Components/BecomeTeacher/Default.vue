<template>
    <LayoutOnBoarding>
        <div class="image-header" style="height: 54px">
            <img
                src="../../../../public/img/icon/ApplyToTeacher/DefaultImage.svg"
                alt=""
            />
        </div>
        <div class="step-container">
            <div
                class="step-container-title d-flex justify-content-center"
                style="padding-bottom: 8px; margin-top: 16px"
            >
                Welcome to Dottrees
            </div>
            <div class="d-flex flex-column align-items-center">
                <span
                    >You're only a few steps away from teaching on
                    Dottrees.</span
                >
                <span
                    >Please follow our step-by-step guide to get started!
                </span>
            </div>
            <!-- status tương ứng với trạng thái của các bước hiện tại -->
            <BaseCardStep
                :status="props.status.statusStep1"
                :step="1"
                @toggle="changeStep1"
                @showResult="showResultStep1"
            />
            <BaseCardStep
                :status="props.status.statusStep2"
                :step="2"
                @toggle="changeStep2"
                @showResult="showResultStep2"
            />
            <BaseCardStep
                :status="props.status.statusStep3"
                :step="3"
                @toggle="changeStep3"
                @showResult="showResultStep3"
            />
        </div>
    </LayoutOnBoarding>
</template>

<script setup>
import LayoutOnBoarding from "../../Layouts/LayoutOnBoarding.vue";
import BaseCardStep from "./BaseCardStep.vue";
import { ref, defineEmits } from "vue";

const props = defineProps({
    step: Number,
    status: Object,
});

const emits = defineEmits();

const changeStep1 = () => {
    emits("changeStep1");
};

const changeStep2 = () => {
    emits("changeStep2");
};

const changeStep3 = () => {
    emits("changeStep3");
};

const showResultStep1 = () => {
    emits("showResultStep1");
};

const showResultStep2 = () => {
    emits("showResultStep2");
};

const showResultStep3 = () => {
    emits("showResultStep3");
};
</script>

<style lang="scss" scoped>
@import "../BecomeTeacher/Step";
</style>
