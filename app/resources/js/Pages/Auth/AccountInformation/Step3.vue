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
    const form = useForm({
        avatar_preview: props.form.avatar_preview,
        avatar: props.form.avatar,
        avatar_validation: props.form.avatar_validation,
        isUploadNewAvatar: props.form.isUploadNewAvatar,
        province:props.form.province,
        district: props.form.district,
        ward: props.form.ward,
        first_name: props.form.first_name,
        last_name: props.form.last_name,
        year: props.form.year,
        month: props.form.month,
        day: props.form.day,
        birthday: props.form.birthday,
        params: props.ziggy.query,
        confirm: true
    })
    form.post(route('account.info'), {
        preserveScroll: true,
        onSuccess: (response) => {
            window.location.href = "/setup-successfully";
        },
        onError: (e) => {
            console.log(e);
        }
    });
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
                        <div class="title-content">Province</div>
                        <div class="filled-content">
                            {{ props.form?.province.name}}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">District</div>
                        <div class="filled-content">
                            {{ props.form?.district.name }}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">Ward</div>
                        <div class="filled-content">
                            {{ props.form?.ward.name }}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">Name</div>
                        <div class="filled-content">
                            {{ props.form?.first_name }}
                            {{ props.form?.last_name }}
                        </div>
                    </div>
                    <div class="result-content-group last-content">
                        <div class="title-content">Birthday</div>
                        <div class="filled-content">
                            {{ props.form?.year }}/{{
                                props.form?.month
                            }}/{{ props.form?.day }}
                        </div>
                    </div>
                </div>

                <div class="button-container">
                    <div class="create__request-button">
                        <div class="lineFull"></div>
                        <ButtonCommon
                            :label="'Back'"
                            :submit-button="false"
                            class="create__request-button-left"
                            @click="backToPrevStep"
                        />
                        <ButtonCommon
                            :label="'Confirm'"
                            :submit-button="true"
                            class="create__request-button-right"
                            @click="confirmInformation"
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

