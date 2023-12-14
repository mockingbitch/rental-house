<script setup>
import { ref } from "vue";
import { useForm, Link } from '@inertiajs/vue3'
import Step2 from "./Step2.vue";
import Step3 from "./Step3.vue";
import Modal from "@/Components/Modal/Modal.vue";
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

const step = ref(2);
const isOpenConfirmModal = ref(props.user ? false : true);

const closeConfirmModal = () => {
    console.log('tét');
    window.location.href = '/';
};
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
        <Modal
            :showModal="isOpenConfirmModal"
            @close="closeConfirmModal"
        >
            <div class="modal__container">
                <div class="modal__title">
                    <div>Failed</div>
                    <img src="/img/icon/close.svg" alt="" @click="closeConfirmModal">
                </div>
                <BaseCard>
                    <div class="modal__content-wrap">
                        <div class="modal__content-title">
                            Token has expired. Please try another token
                        </div>
                        <div>
                            1. Your confirmation email has expired
                        </div>
                        <div>
                            2. You are access this screen but wrong token parameters
                        </div>
                        <div>
                            3. You can re-register to generate a new token
                        </div>
                    </div>
                </BaseCard>
                <div class="modal__btn">
                    <Link
                        :href="route('top')"
                        class="modal__btn-btn modal__btn-btn-left"
                    >
                        Back to Top
                    </Link>
                    <Link
                        :href="route('register.method')"
                        class="modal__btn-btn modal__btn-btn-right"
                    >
                        Re-register
                    </Link>
                </div>
            </div>
        </Modal>
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
@import './information';
@import './modal';
</style>
