<script setup>
import { ref, watch, computed, toRef } from 'vue'
import { useForm } from '@inertiajs/vue3'
import UlError from '@/Components/Common/UlError.vue';
import PError from '@/Components/Common/PError.vue';
import DatePicker from "@/Components/DatePicker/DatePicker.vue";
import CustomSelect from "@/Components/Select/CustomSelect.vue";

const props = defineProps({
    step: Number,
    ziggy: Object,
    user: Object,
});

const emit = defineEmits(['nextStep']);

const submitForm = () => {
    form.post(route('learner.info'), {
        preserveScroll: true,
        onSuccess: (response) => {
            emit('nextStep', form)
        },
        onError: (e) => {
            console.log(e);
        }
    });
}

const backToPrevStep = () => {
    emit("prev-step");
};
</script>

<template>
    <transition name="slide-fade">
        <form v-show="step === 3"
            class="form[0]"
            method="post"
            action="#"
            @submit.prevent="next"
        >
            <div class="skip-item">
                <img
                        src="/img/icon/arrownLeft.svg"
                        alt=""
                        @click="backToPrevStep"
                />
                <a href="javascript:void(0)" @click="emit('nextStep', form)" >
                    {{ lang().label.information.learner_info.skip }}
                    <i><img src="img/icon/CaretRightGreenCl.svg" alt="CaretRightGreenCl"></i>
                </a>
            </div>
            <button type="submit" class="mainButton step-3-btn" @click="handleAddChild">
                <p>
                    <img src="img/icon/Plus.svg" alt="Plus">
                    {{ lang().label.information.learner_info.another_kids }}
                </p>
            </button>
            <button type="submit" class="mainButton step-3-btn bg-green" @click="submitForm">
                <p>{{ lang().label.information.learner_info.complete_register }}</p>
                <i class="after"><img src="img/icon/CaretRight.svg" alt="CaretRight"></i>
            </button>
        </form>
    </transition>
</template>

<style lang="scss" scoped>
@import "./_information.scss";
.error__wrapper {
    .errorMsg2 {
        font-size: 10px;
        background-color: transparent;
        padding: 0px;
    }
}
.form-wrap-tripple {
    margin-bottom: 5px;
}
</style>
