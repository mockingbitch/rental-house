<template>
    <div class="step-container d-flex flex-column mt-2">
        <div class="form__wrap-item image-sucess-apply">
            <img src="../../../public/img/ReviewSuccess.svg" alt="" />
        </div>
        <div class="form__wrap-item">
            <div class="title d-flex justify-content-center">
                (仮)レビューを投稿しました。
            </div>
            <div
                class="content d-flex flex-column justify-content-center align-items-center"
            >
                <span>(仮)ご利用ありがとうございました！</span>
                <span> あいうえおあいうえおあいうえお</span>
                <span>あいうえおあいうえおあいうえおあいうえお、</span>
                <span style="margin-top: 26px">あいうえおあいうえお！</span>
            </div>
        </div>
        <div
            class="form__wrap-item button-dashboard-container d-flex justify-content-center align-items-center"
        >
            <Link :href="route('top')">
                <div
                    class="button-return button-dash-board d-flex justify-content-center align-items-center"
                    @click="handleBackToDashboard"
                >
                    DottreesののTOPページに戻る
                </div>
            </Link>
        </div>
        <div
            class="form__wrap-item d-flex justify-content-center align-items-center"
        >
            <Link :href="route('lesson.detail', props.lesson_id)">
                <div
                    class="button-return button-top d-flex flex-column justify-content-center align-items-center"
                >
                    レッスン詳細に戻る
                </div>
            </Link>
            
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { defineEmits, defineProps } from "vue";

const emits = defineEmits();

const handleBackToDashboard = () => {
    emits("back-to-dashboard");
};
const props = defineProps({
    lesson_id: Number,
});
</script>

<style lang="scss" scoped>
@import "../Components/BecomeTeacher/Step";
.title {
    color: #000000;
    font-size: 16px;
    font-style: normal;
    font-weight: 700;
    line-height: 25.6px; /* 25.6px */
    letter-spacing: -0.16px;
}
.content {
    padding: 16px 0;
    color: #1b1b1b;
    line-height: 1.6;
    white-space: nowrap;
    margin-bottom: 0;
    font-size: 12px;
    font-style: normal;
    font-weight: 400;
    line-height: 19.2px; /* 19.2px */
    letter-spacing: -0.12px;
}

.image-sucess-apply {
    padding-top: 32px;
    img {
        height: 124px;
        width: 100%;
        object-fit: cover;
    }
}

@media screen and (max-width: 768px) {
    .image-sucess-apply {
        padding-top: 8px;
    }
}

.button-return {
    height: 50px;
    font-size: 14px;
    border-radius: 4px;
    width: 343px;
    padding: 0 16px;
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
