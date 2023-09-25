<script setup>
import { ref } from "vue";
import Step2 from "./StepAccountInformation.vue";
import Step3 from "./StepLearnerInformation.vue";
import Step3Confirm from "./StepConfirmInformation.vue";
import LayoutNoLogin from "@/Layouts/LayoutNoLogin.vue";

const props = defineProps({
    ziggy: Object,
    user: Object,
});

let step = ref(2);
let accountInforForm = null;
let learnerInforForm = null;

const next = (data) => {
    step.value += 1;
};

const prev = () => {
    step.value -= 1;
};
</script>

<template>
    <LayoutNoLogin>
        <div class="signinStep">
            <div class="container">
                <div class="form">
                    <div class="form__wrap">
                        <div class="progress" v-if="step === 2 || step === 3">
                            <h2 class="title green-cl">
                                {{ lang().label.information.index.title }}
                            </h2>
                            <div class="progress__wrap">
                                <div
                                    :class="`progressBar bar-1 ${
                                        step > 1 ? '' : 'green-bar'
                                    }`"
                                ></div>
                                <div
                                    :class="`progressBar bar-2 ${
                                        step > 2 ? '' : 'green-bar'
                                    }`"
                                ></div>
                                <div class="circle finish">
                                    <img
                                        src="/img/icon/StepNumber/NumberOne.png"
                                        alt=""
                                    />
                                    <span>{{
                                        lang().label.information.index
                                            .verification
                                    }}</span>
                                </div>
                                <div
                                    class="circle"
                                    :class="{
                                        active: step === 2,
                                        finish: step > 2,
                                    }"
                                >
                                    <img
                                        v-if="step < 2"
                                        src="/img/icon/StepNumber/NumberTwo-green.png"
                                        alt=""
                                    />
                                    <img
                                        v-else
                                        src="/img/icon/StepNumber/NumberTwo.png"
                                        alt=""
                                    />
                                    <span>{{
                                        lang().label.information.index
                                            .account_info
                                    }}</span>
                                </div>
                                <div
                                    class="circle"
                                    :class="{ active: step === 3 }"
                                >
                                    <img
                                        v-if="step < 3"
                                        src="/img/icon/StepNumber/NumberThree-green.png"
                                        alt=""
                                    />
                                    <img
                                        v-else
                                        src="/img/icon/StepNumber/NumberThree.png"
                                        alt=""
                                    />
                                    <span>{{
                                        lang().label.information.index
                                            .learner_info
                                    }}</span>
                                </div>
                            </div>
                        </div>
                        <StepAccountInformation
                            :step="step"
                            :ziggy="ziggy"
                            :user="props.user"
                            @nextStep="next"
                        />
                        <StepLearnerInformation
                            :step="step"
                            :ziggy="ziggy"
                            :user="props.user"
                            @nextStep="next"
                            @prevStep="prev"
                        />
                        <StepConfirmInformation
                            :step="step"
                            :ziggy="ziggy"
                            :accountInforForm="accountInforForm"
                            :learnerInforForm="learnerInforForm"
                            :user="props.user"
                            @nextStep="next"
                            @prevStep="prev"
                        />
                    </div>
                </div>
            </div>
        </div>
    </LayoutNoLogin>
</template>

<style lang="scss">
@import "./information.scss";
.form {
    padding-bottom: 50px;
}
.green-bar {
    background-color: #5392f9 !important;
}

.progress__wrap .progressBar {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: #b1b1b1;
    height: 2px;
    width: 50%;
    transition: 0.4s ease-in;
}

.bar-1 {
    left: 0;
}
.bar-2 {
    left: 50%;
}
</style>
