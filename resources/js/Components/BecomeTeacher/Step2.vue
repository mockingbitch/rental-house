<template>
    <LayoutOnBoarding
        :step="2"
        :title="'本人確認'"
        @handle-click="handleCancel"
    >
        <BreadcrumbVue
            :items="breadcrumbItems"
            @handleClick="handleBreadcrumbClick"
        />
        <div class="step-container">
            <div
                class="step-container-header d-flex align-items-center justify-content-center"
            >
                <img @click="handleCancel" src="/img/icon/close.svg" alt="" />
                <span class="step-container-header-content">本人確認</span>
            </div>
            <div class="step-container-title d-flex justify-content-center">
                本人確認（申請）
            </div>
            <div class="rules-content d-flex flex-column">
                <div class="rules-content-title d-flex justify-content-center">
                    本人確認の流れ
                </div>
                <SlideStep />
            </div>
            <div class="rules-content d-flex flex-column">
                <div class="rules-content-title">必要な書類</div>
                <span> 提出が可能な書類（いずれか1点） </span>
                <span
                    >下記の本人確認書類（コピー不可）をお手元に準備をお願</span
                >
                <span>いいたします。</span>
                <ul class="note">
                    <li>・運転免許証</li>
                    <li>・パスポート（日本国政府発行のみ）</li>
                    <li>・住民基本台帳</li>
                    <li>・マイナンバーカード</li>
                    <li>・パスポート（日本国政府発行のみ）</li>
                    <li>・運転経歴証明書</li>
                    <li>・特別永住者証明書。</li>
                </ul>
            </div>
            <!-- <div class="form__wrap-item">
                <label for="Title"
                    >Upload image
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                    >
                        <path
                            d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 12C7.85167 12 7.70666 11.956 7.58333 11.8736C7.45999 11.7912 7.36386 11.6741 7.30709 11.537C7.25033 11.4 7.23548 11.2492 7.26441 11.1037C7.29335 10.9582 7.36478 10.8246 7.46967 10.7197C7.57456 10.6148 7.7082 10.5434 7.85368 10.5144C7.99917 10.4855 8.14997 10.5003 8.28701 10.5571C8.42406 10.6139 8.54119 10.71 8.6236 10.8333C8.70602 10.9567 8.75 11.1017 8.75 11.25C8.75 11.4489 8.67098 11.6397 8.53033 11.7803C8.38968 11.921 8.19892 12 8 12ZM8.5 8.955V9C8.5 9.13261 8.44732 9.25979 8.35356 9.35355C8.25979 9.44732 8.13261 9.5 8 9.5C7.86739 9.5 7.74022 9.44732 7.64645 9.35355C7.55268 9.25979 7.5 9.13261 7.5 9V8.5C7.5 8.36739 7.55268 8.24021 7.64645 8.14645C7.74022 8.05268 7.86739 8 8 8C8.82688 8 9.5 7.4375 9.5 6.75C9.5 6.0625 8.82688 5.5 8 5.5C7.17313 5.5 6.5 6.0625 6.5 6.75V7C6.5 7.13261 6.44732 7.25979 6.35356 7.35355C6.25979 7.44732 6.13261 7.5 6 7.5C5.86739 7.5 5.74022 7.44732 5.64645 7.35355C5.55268 7.25979 5.5 7.13261 5.5 7V6.75C5.5 5.50938 6.62125 4.5 8 4.5C9.37875 4.5 10.5 5.50938 10.5 6.75C10.5 7.83625 9.64 8.74563 8.5 8.955Z"
                            fill="#B1B1B1"
                        /></svg
                ></label>
                <div v-for="upload in formUploads" :key="upload.id">
                    <ImagePreview
                        :formLesson="upload.form"
                        :message="upload.form.errors.cover_image"
                        :item="upload.id"
                    />
                    <ul class="note">
                        <li>※ 画像のサイズ制限</li>
                        <li>※ 画像の容量制限</li>
                    </ul>
                </div>
            </div> -->
            <!-- <div
                v-if="isDisplayAddForm"
                @click="handleAddFormUpload"
                class="form__wrap-item from-select-input"
            >
                <div
                    class="d-flex justify-content-center align-item-center another-company-button"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <path
                            d="M21 12C21 12.1989 20.921 12.3897 20.7803 12.5303C20.6397 12.671 20.4489 12.75 20.25 12.75H12.75V20.25C12.75 20.4489 12.671 20.6397 12.5303 20.7803C12.3897 20.921 12.1989 21 12 21C11.8011 21 11.6103 20.921 11.4697 20.7803C11.329 20.6397 11.25 20.4489 11.25 20.25V12.75H3.75C3.55109 12.75 3.36032 12.671 3.21967 12.5303C3.07902 12.3897 3 12.1989 3 12C3 11.8011 3.07902 11.6103 3.21967 11.4697C3.36032 11.329 3.55109 11.25 3.75 11.25H11.25V3.75C11.25 3.55109 11.329 3.36032 11.4697 3.21967C11.6103 3.07902 11.8011 3 12 3C12.1989 3 12.3897 3.07902 12.5303 3.21967C12.671 3.36032 12.75 3.55109 12.75 3.75V11.25H20.25C20.4489 11.25 20.6397 11.329 20.7803 11.4697C20.921 11.6103 21 11.8011 21 12Z"
                            fill="#1B1B1B"
                        />
                    </svg>
                    Another Pictures
                </div>
            </div> -->

            <ul class="note">
                <li>・(仮)申請から承認までn日ほどかかります。</li>
                <li>・(仮)申請の後、やり直しはできません。</li>
                <li>・(仮)個人情報は〜なんとかなんとか。</li>
            </ul>
            <div class="button-container">
                <div class="create__request-button">
                    <div class="lineFull"></div>
                    <ButtonRequest
                        :label="'キャンセル'"
                        :submit-button="false"
                        class="create__request-button-left"
                        @click="handleCancel"
                    />
                    <ButtonRequest
                        :label="'申請する'"
                        :submit-button="true"
                        class="create__request-button-right"
                        @click="handleSubmitForm"
                    />
                </div>
            </div>
        </div>
    </LayoutOnBoarding>
</template>

<script setup>
import LayoutOnBoarding from "../../Layouts/LayoutOnBoarding.vue";
import ImagePreview from "@/Components/ImagePreview/ImagePreview.vue";
import ButtonRequest from "@/Components/Request/ButtonRequest.vue";
import SlideStep from "@/Components/BecomeTeacher/slideStep.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, defineEmits } from "vue";
import BreadcrumbVue from "../Breadcrumb.vue";

const breadcrumbItems = [
    { text: "Dashboard", isLink: true },
    { text: "本人確認", isLink: false },
];
let isDisplayAddForm = ref(true);
const emits = defineEmits();

let formUploads = ref([
    {
        id: 1,
        form: useForm({
            id: 1,
            imagePreview: "",
            imageName: "",
            short_video_for_learner_thumbnail: "",
            cover_image: "",
        }),
    },
]);

const handleAddFormUpload = () => {
    if (formUploads.value.length < 2) {
        const newFormId = formUploads.value.length + 1;
        formUploads.value.push({
            id: newFormId,
            form: useForm({
                id: newFormId,
                imagePreview: "",
                imageName: "",
                short_video_for_learner_thumbnail: "",
                cover_image: "",
            }),
        });

        if (formUploads.value.length === 2) {
            isDisplayAddForm.value = false;
        }
    }
};

const handleSubmitForm = () => {
    emits("back-to-default");
};

const handleBreadcrumbClick = (item) => {
    if (item.isLink === true) {
        if (item.text === "Dashboard") {
            handleCancel();
        }
    }
};

const handleCancel = () => {
    emits("handle-cancel");
};
</script>

<style lang="scss" scoped>
@import "../BecomeTeacher/Step";
</style>
