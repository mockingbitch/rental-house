<script setup>
import { ref, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Step1 from "./Step1.vue";
// import Step2 from "./Step2.vue";
// import Step3 from "./Step3.vue";
import Default from "./Default.vue";
import ApplySuccess from "./ApplySuccess.vue";
import ShowResultStep1 from "./ShowResultStep1.vue";
// import showResultStep2 from "@/Components/BecomeTeacher/showResultStep2.vue";
// import showResultStep3 from "@/Components/BecomeTeacher/showResultStep3.vue";

const page = usePage();

const props = defineProps({
    cities: Array,
    countries: Array,
    lessorInformation: Object,
    teacherWorkHistories: Array,
    step: Number,
});

const computedStatus = computed(() => {
    if (props.lessorInformation?.step === 1) {
        return {
            statusStep1: 2,
            statusStep2: null,
            statusStep3: 0,
        };
    } else if (props.lessorInformation?.step === 2) {
        return {
            statusStep1: 2,
            statusStep2: 2,
            statusStep3: null,
        };
    } else if (props.lessorInformation?.step === 3) {
        return {
            statusStep1: 2,
            statusStep2: 2,
            statusStep3: 1,
        };
    } else {
        return {
            statusStep1: null,
            statusStep2: 0,
            statusStep3: 0,
        };
    }
});

const state = ref({
    step: props.step ?? 4,
    showResult: 0,
    status: computedStatus,
});

const dataStep1 = ref({
    ...props.lessorInformation, 
    'firstName': page.props.auth?.user?.first_name,
    'lastName': page.props.auth?.user?.last_name,
    'email': page.props.auth?.user?.email,
    'year': page.props.auth?.user?.year,
    'month': page.props.auth?.user?.month,
    'day': page.props.auth?.user?.day,
    'profileImage': page.props.auth?.user?.avatar,
});
const dataStep3 = ref(props.lessorHouse);
const form = computed(() => {
    return useForm({
        //step1
        firstName: dataStep1.value?.firstName,
        lastName: dataStep1.value?.lastName,
        email: dataStep1.value?.email,
        year: dataStep1.value?.year,
        month: dataStep1.value?.month,
        country: dataStep1.value?.country,
        day: dataStep1.value?.day,
        phone: dataStep1.value?.phone,
        about: dataStep1.value?.about,
        shortVideo: dataStep1.value?.shortVideo,
        profileImage: dataStep1.value?.profileImage,
        // bank_name: dataStep1.value?.bank_name,
        // branch_code: dataStep1.value?.branch_code,
        // account_type: dataStep1.value?.account_type,
        // account_number: dataStep1.value?.account_number,
        // account_name: dataStep1.value?.account_name,
        // profile_image: dataStep1.value?.profile_image,
        // job: dataStep1.value?.job,
        // salary: dataStep1.value?.salary,
        // school: dataStep1.value?.school,
        // major: dataStep1.value?.major,
        // major_specialize: dataStep1.value?.major_specialize,
        // admission_year: dataStep1.value?.admission_year,
        // admission_month: dataStep1.value?.admission_month,
        // admission_day: dataStep1.value?.admission_day,
        // graduation_year: dataStep1.value?.graduation_year,
        // graduation_month: dataStep1.value?.graduation_month,
        // graduation_day: dataStep1.value?.graduation_day,
        // academic_certificate: dataStep1.value?.academic_certificate,
        // work_histories: dataStep3.value,
    });
});


// đổi step
const changeStep1 = (data) => {
    state.value.step = 1;
};

const changeStep2 = (data) => {
    state.value.step = 2;
};

const changeStep3 = (data) => {
    state.value.step = 3;
};

// show result step
const showResult1 = (data) => {
    state.value.showResult = 1;
    state.value.step = 0;
};

const showResult2 = (data) => {
    state.value.showResult = 2;
    state.value.step = 0;
};

const showResult3 = (data) => {
    state.value.showResult = 3;
    state.value.step = 0;
};

//show confirm các step
const showConfirmStep1 = (data) => {
    dataStep1.value = data;
    showResult1();
};

const showConfirmStep2 = (data) => {
    // dataStep2.value = data;
    showResult2();
};

const showConfirmStep3 = (data) => {
    dataStep3.value = data;
    showResult3();
};

// Hoàn thành các step và gửi form data
const step1Success = (data) => {
    state.value.step = 5;
    state.value.status.statusStep1 = 2;
    state.value.status.statusStep2 = null;
    dataStep1.value = data;
    state.value.showResult = 0;
};

const step2Success = () => {
    state.value.step = 5;
    state.value.status.statusStep2 = 2;
    state.value.status.statusStep3 = null;
    state.value.showResult = 0;
};

const step3Success = (data) => {
    state.value.step = 5;
    state.value.status.statusStep3 = 1;
    dataStep3.value = data;
    state.value.showResult = 0;
};

// Quay về màn chính
const backToOnboarding = (data) => {
    state.value.step = 4;
    state.value.showResult = 0;
};

const backToStep = (step) => {
    state.value.step = step;
    state.value.showResult = 0;
};

const hanndleCancel = () => {
    state.value.step = 4;
    state.value.showResult = 0;
    state.value.status.statusStep1 = null;
    state.value.status.statusStep2 = 0;
    state.value.status.statusStep3 = 0;
    dataStep1.value = null;
    dataStep3.value = null;
};

const imageDataStep3 = ref();
const saveImageStep3 = (data) => {
    imageDataStep3.value = data;
};

const saveData = (data) => {
    dataStep1.value = data;
};
const saveDataStep3 = (data) => {
    dataStep3.value = data;
};
</script>
<template>
    <Step1
        v-if="state.step === 1"
        :dataStep1="dataStep1"
        @back-to-default="showConfirmStep1"
        @handle-cancel="hanndleCancel"
    ></Step1>
    <!-- <Step2
        v-if="state.step === 2"
        @back-to-default="showConfirmStep2"
        @handle-cancel="backToOnboarding"
    ></Step2> -->
    <!-- <Step3
        v-if="state.step === 3"
        :dataTeacher="props.lessorInformation"
        :dataStep3="dataStep3"
        :dataImage="imageDataStep3"
        @back-to-default="showConfirmStep3"
        @handle-cancel="backToOnboarding"
        @save-image-step3="saveImageStep3"
    ></Step3> -->
    <Default
        v-if="state.step === 4"
        :step="state.step"
        :status="state.status"
        @changeStep1="changeStep1"
        @changeStep2="changeStep2"
        @changeStep3="changeStep3"
        @showResultStep1="showResult1"
        @showResultStep2="showResult2"
        @showResultStep3="showResult3"
    ></Default>
    <ShowResultStep1
        v-if="state.showResult === 1"
        :cities="props.cities"
        :dataStep1="dataStep1"
        :countries="props.countries"
        @back-to-onboarding="backToStep(1)"
        @confirm-step1="step1Success"
        @save-data="saveData"
        @move-to-onboarding="backToOnboarding"
        :showButtonConfirm="state.status.statusStep1"
    />
    <ApplySuccess
        v-if="state.step === 5"
        @back-to-dashboard="backToOnboarding"
    ></ApplySuccess>
    <!-- <showResultStep1
        v-if="state.showResult === 1"
        :cities="props.cities"
        :dataStep1="dataStep1"
        :countries="props.countries"
        @back-to-onboarding="backToStep(1)"
        @confirm-step1="step1Success"
        @save-data="saveData"
        @move-to-onboarding="backToOnboarding"
        :showButtonConfirm="state.status.statusStep1"
    />
    <showResultStep2
        v-if="state.showResult === 2"
        @back-to-onboarding="backToStep(2)"
        @confirm-step2="step2Success"
        :showButtonConfirm="state.status.statusStep2"
        @move-to-onboarding="backToOnboarding"
    />
    <showResultStep3
        v-if="state.showResult === 3"
        :dataTeacher="props.lessorInformation"
        :dataStep3="dataStep3"
        @back-to-onboarding="backToStep(3)"
        @confirm-step3="step3Success"
        :showButtonConfirm="state.status.statusStep3"
        :saveDataImageStep3="imageDataStep3"
        @save-data="saveDataStep3"
        @move-to-onboarding="backToOnboarding"
        @save-data-image="saveImageStep3"
    /> -->
</template>

<style lang='scss' scoped>
@import './index';
</style>
