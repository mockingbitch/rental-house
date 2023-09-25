<script setup>
import SubHeader from "../Common/SubHeader.vue";
import LearnerForm from "../Common/LearnerForm.vue";

const props = defineProps({
    account: Object,
});
const emits = defineEmits();
const handleSubmit = (formData) => {
    formData.post(route("kid.update"), {
        onSuccess: (e) => {
            window.location.reload();
        },
    });
};

const showDialogDelete = () => {
    emits("delete", props.account);
};

const handleBackToDetail = () => {
    emits("backToDetail");
};
</script>

<template>
    <SubHeader
        :label="'Learner Information 設定'"
        is-close
        @close="handleBackToDetail"
    />
    <div
        class="user-infomation create__request-container step-container d-flex flex-column"
    >
        <div class="user-infomation-title">Learner Information</div>

        <LearnerForm @submitFormLearner="handleSubmit" :formData="props.account"/>
        <div class="d-flex justify-content-center">
            <div
                class="user-infomation-delete d-flex justify-content-center align-items-center"
                style="width: fit-content; user-select: none; cursor: pointer"
                @click="showDialogDelete"
            >
                Learner情報削除
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "../../Pages/Request/User/_createRequest.scss";
@import "../BecomeTeacher/Step";
@import "../Account/_Account.scss";
</style>
