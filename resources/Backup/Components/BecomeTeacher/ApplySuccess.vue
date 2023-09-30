<template>
    <LayoutOnBoarding :isSuccess="true">
        <div class="step-container d-flex flex-column mt-2">
            <div class="form__wrap-item image-sucess-apply">
                <img src="../../../../public/img/icon/applySucess.svg" alt="" />
            </div>
            <div class="form__wrap-item">
                <div class="title d-flex justify-content-center">
                    (仮)申請を完了しました！
                </div>
                <div
                    class="content d-flex flex-column justify-content-center align-items-center"
                >
                    <span>あいうえおあいうえおあいうえおあいうえお </span>
                    <span> あいうえおあいうえおあいうえお</span>
                    <span
                        >あいうえおあいうえおあいうえおあいうえおあいうえお。</span
                    >
                </div>
            </div>
            <div
                class="form__wrap-item button-dashboard-container d-flex justify-content-center align-items-center"
            >
                <div
                    class="button-return button-dash-board d-flex justify-content-center align-items-center"
                    @click="handleBackToDashboard"
                >
                    Dashboardに戻る
                </div>
            </div>
            <div
                class="form__wrap-item d-flex justify-content-center align-items-center"
            >
                <Link :href="route('top')">
                    <div
                        class="button-return button-top d-flex flex-column justify-content-center align-items-center"
                    >
                        RentalHousesののTOPページに戻る
                    </div>
                </Link>
            </div>
        </div>
    </LayoutOnBoarding>
</template>

<script setup>
import LayoutOnBoarding from "../../Layouts/LayoutOnBoarding.vue";
import { Link } from "@inertiajs/vue3";
import { defineEmits, defineProps } from "vue";

const props = defineProps({
    dataStep3: Object,
});
const emits = defineEmits();

const handleBackToDashboard = () => {
    emits("back-to-dashboard");
};
</script>

<style lang="scss" scoped>
@import "../BecomeTeacher/Step";
.title {
    color: #1b1b1b;
    height: 16px;
}
.content {
    padding: 16px 17px 0;
    color: #1b1818;
    line-height: 1.6;
    white-space: nowrap;
    margin-bottom: 0;
}

.image-sucess-apply {
    padding-top: 24px;
    img {
        height: 124px;
        width: 100%;
        object-fit: cover;
    }
}

@media screen and (max-width: 768px) {
    .image-sucess-apply {
        padding-top: 16px;
    }
}

.button-return {
    height: 50px;
    font-size: 14px;
    border-radius: 4px;
    width: 343px;
}
.button-dash-board {
    background-color: #5392F9 ;
    color: #ffffff;
    cursor: pointer;
}
.button-top {
    background-color: #ffffff;
    color: #5392F9 ;
    font-size: 14px;
    border: 1px solid #000;
}

.button-dashboard-container {
    padding-bottom: 8px;
}

.form__wrap-item {
}
</style>
