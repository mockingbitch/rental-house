<script setup>
import { ref } from "vue";
import { useForm } from '@inertiajs/vue3'
import Step2 from "./Step2.vue";
import Step3 from "./Step3.vue";
import StepConfirmInformation from "./StepConfirmInformation.vue";
import LayoutNoLogin from "@/Layouts/LayoutNoLogin.vue";

const props = defineProps({
    ziggy: Object,
    user: Object,
});

const form = useForm({
    avatar_preview: '',
    avatar: '',
    avatar_validation: '',
    isUploadNewAvatar: false,
    province:{},
    district: {},
    ward: {},
    first_name: '',
    last_name: '',
    year: '',
    month: '',
    day: '',
    birthday: '',
    params: props.ziggy.query,
    confirm: false,
})
let step = ref(2);

const next = (data) => {
    form.avatar_preview = data.avatar_preview;
    form.avatar = data.avatar;
    form.avatar_validation = data.avatar_validation;
    form.isUploadNewAvatar = data.isUploadNewAvatar;
    form.province = data.province;
    form.district = data.district;
    form.ward = data.ward;
    form.first_name = data.first_name;
    form.last_name = data.last_name;
    form.year = data.year;
    form.month = data.month;
    form.day = data.day;
    form.birthday = data.birthday;
    form.confirm = data.confirm;
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
                            <h1 class="title green-cl">
                                {{ lang().label.information.index.title }}
                            </h1>
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
                                    <span>
                                        {{ lang().label.information.index.verification }}
                                    </span>
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
                                    <span>
                                        {{ lang().label.information.index.account_info }}
                                    </span>
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
                                    <span>
                                        {{ lang().label.information.index.learner_info }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <Step2
                            :step="step"
                            :ziggy="ziggy"
                            :user="props.user"
                            @nextStep="next"
                        />
                        <Step3
                            :step="step"
                            :ziggy="ziggy"
                            :user="props.user"
                            @nextStep="next"
                            @prevStep="prev"
                            :form="form"
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
