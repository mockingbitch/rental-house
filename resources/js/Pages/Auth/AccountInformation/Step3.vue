<script setup>
import { ref, watch, computed, toRef } from 'vue'
import { useForm } from '@inertiajs/vue3'
import UlError from '@/Components/Common/UlError.vue';
import PError from '@/Components/Common/PError.vue';
import DatePicker from "@/Components/DatePicker/DatePicker.vue";
import CustomSelect from "@/Components/Select/CustomSelect.vue";
import ButtonCommon from "@/Components/Button/ButtonCommon.vue";

const props = defineProps({
    step: Number,
    ziggy: Object,
    user: Object,
    form: Object,
});

const emit = defineEmits(['nextStep']);

const backToPrevStep = () => {
    emit("prev-step");
};
const confirmInformation = () => {
    form.confirm = true;
    // form.post(route('learner.info'), {
    //     preserveScroll: true,
    //     onSuccess: (response) => {
    //         emit('nextStep', form)
    //     },
    //     onError: (e) => {
    //         console.log(e);
    //     }
    // });
}
</script>

<template>
    <transition name="slide-fade">
        <form v-show="step === 3"
            class="form[0]"
            method="post"
            action="#"
            @submit.prevent="next"
        >
            <div class="step-container">
                <div
                    class="step-container-header d-flex align-items-center justify-content-center"
                >
                    <span class="step-container-header-content"
                        >Please check the registration details</span
                    >
                </div>

                <div class="skip-item" style="margin-top: 40px;">
                    <img
                        src="/img/icon/arrownLeft.svg"
                        alt=""
                        @click="backToPrevStep"
                    />
                </div>
                <!-- Account Information -->
                <div class="result-content" >
                    <div class="result-content-group first-content">
                        <div class="title-content">Residential Province</div>
                        <div class="filled-content">
                            {{ props.form?.province.name}}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">Redifential District</div>
                        <div class="filled-content">
                            {{ props.form?.district.name }}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">Redifential Ward</div>
                        <div class="filled-content">
                            {{ props.form?.ward.name }}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">Adult name</div>
                        <div class="filled-content">
                            {{ props.form?.first_name }}
                            {{ props.form?.last_name }}
                        </div>
                    </div>
                    <div class="result-content-group last-content">
                        <div class="title-content">Birthday</div>
                        <div class="filled-content">
                            {{ props.form?.year % 1000 }}/{{
                                props.form?.month
                            }}/{{ props.form?.day }}
                        </div>
                    </div>
                </div>

                <div class="button-container">
                    <div class="create__request-button">
                        <div class="lineFull"></div>
                        <ButtonCommon
                            :label="'戻る'"
                            :submit-button="false"
                            class="create__request-button-left"
                            @click="backToPrevStep"
                        />
                        <ButtonCommon
                            :label="'申請する'"
                            :submit-button="true"
                            class="create__request-button-right"
                            @click="handleConfirmUpdate"
                        />
                    </div>
                </div>
            </div>
        </form>
    </transition>
</template>

<style lang="scss" scoped>
@import "./stepconfirm";
</style>

