<template>
    <Layout>
        <Breadcrumb
            :items="breadcrumbItems"
            :is-hide-sp="true"
            @handleClick="handleBreadcrumbClick"
        />
        <div v-if="requestStep === 1" class="create__request-container">
            <SubHeader :label="'Register your request'" href="request.index" is-close show-logo-sp />
            <InputForm
                v-model:message="form.summary"
                :label="'Summary'"
                :placeholder="'Summary'"
            />
            <UlError :message="form.errors.summary" />
            <div class="form__item-wrapper">
                <label for="" style="display: block; font-size: 12px; font-weight: 400; letter-spacing: -0.12px; line-height: 160%; color: #1B1B1B; margin-bottom: 6.5px;">
                    Category
                </label>
                <CustomSelect
                    :value-selected="form.category_id"
                    :options="mappingCategories(props.categories)"
                    place-holder="Other"
                    @selectValue="updateCategoryId"
                />
                <UlError :message="form.errors.category_id" />
            </div>
            <div class="form__item-wrapper">
                <DoubleSelect
                    v-model:selected1="form.min_price"
                    v-model:selected2="form.max_price"
                    :icon="'/img/icon/RequestClass/wallet.svg'"
                    :label1="'Price'"
                    :options1="
                        form.max_price
                            ? minPriceRange.filter(
                                  (price) => price < form.max_price
                              )
                            : minPriceRange
                    "
                    :options2="
                        form.min_price
                            ? maxPriceRange.filter(
                                  (price) => price > form.min_price
                              )
                            : maxPriceRange
                    "
                    text-to="to"
                    placeholder1="example"
                    placeholder2="example"
                    :hide-icon2="true"
                />
            </div>
            <div class="form__item-wrapper">
                <DoubleSelect
                    v-model:selected1="form.min_capacity"
                    v-model:selected2="form.max_capacity"
                    :icon="'/img/icon/RequestClass/time.svg'"
                    :label1="'Capacity'"
                    :options1="form.max_capacity
                            ? capacityRange.filter(
                                  (item) => item < form.max_capacity
                              )
                            : capacityRange"
                    :options2="
                        form.min_capacity
                            ? capacityRange.filter(
                                  (item) => item > form.min_capacity
                              )
                            : capacityRange
                    "
                    text-to="to"
                    placeholder1="example"
                    placeholder2="example"
                    :hide-icon2="true"
                />
            </div>
            <UlError :message="form.errors.weekdays" />
            <div class="create__request-textarea d-flex flex-column mt-4">
                <div class="d-flex align-items-center">
                    <label for="about-teacher">Detail</label>
                    <div style="color: #FE3259;">*</div>
                    <i class="with-tooltip" data-tooltip-content="Detail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 12C7.85167 12 7.70666 11.956 7.58333 11.8736C7.45999 11.7912 7.36386 11.6741 7.30709 11.537C7.25033 11.4 7.23548 11.2492 7.26441 11.1037C7.29335 10.9582 7.36478 10.8246 7.46967 10.7197C7.57456 10.6148 7.7082 10.5434 7.85368 10.5144C7.99917 10.4855 8.14997 10.5003 8.28701 10.5571C8.42406 10.6139 8.54119 10.71 8.6236 10.8333C8.70602 10.9567 8.75 11.1017 8.75 11.25C8.75 11.4489 8.67098 11.6397 8.53033 11.7803C8.38968 11.921 8.19892 12 8 12ZM8.5 8.955V9C8.5 9.13261 8.44732 9.25979 8.35356 9.35355C8.25979 9.44732 8.13261 9.5 8 9.5C7.86739 9.5 7.74022 9.44732 7.64645 9.35355C7.55268 9.25979 7.5 9.13261 7.5 9V8.5C7.5 8.36739 7.55268 8.24021 7.64645 8.14645C7.74022 8.05268 7.86739 8 8 8C8.82688 8 9.5 7.4375 9.5 6.75C9.5 6.0625 8.82688 5.5 8 5.5C7.17313 5.5 6.5 6.0625 6.5 6.75V7C6.5 7.13261 6.44732 7.25979 6.35356 7.35355C6.25979 7.44732 6.13261 7.5 6 7.5C5.86739 7.5 5.74022 7.44732 5.64645 7.35355C5.55268 7.25979 5.5 7.13261 5.5 7V6.75C5.5 5.50938 6.62125 4.5 8 4.5C9.37875 4.5 10.5 5.50938 10.5 6.75C10.5 7.83625 9.64 8.74563 8.5 8.955Z" fill="#B1B1B1" />
                        </svg>
                    </i>
                </div>
                <textarea
                    id="about-teacher"
                    v-model="form.detail"
                    name="about-teacher"
                    maxlength="200"
                    placeholder="example"
                    class="w-full mt-2"
                ></textarea>
                <div class="create__request-textarea-count mt-1">※ 文字制限数：{{ form.detail ? form.detail?.length : 0 }}/200</div>
            </div>
            <UlError :message="form.errors.detail" />
            <div class="d-flex align-items-center mt-4">
                <svg
                    width="14"
                    height="14"
                    viewBox="0 0 14 14"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M11.247 10.6282C11.2877 10.6689 11.3199 10.7171 11.3419 10.7702C11.3639 10.8233 11.3752 10.8803 11.3752 10.9377C11.3752 10.9952 11.3639 11.0522 11.3419 11.1053C11.3199 11.1584 11.2877 11.2066 11.247 11.2473C11.2064 11.2879 11.1581 11.3202 11.105 11.3422C11.0519 11.3642 10.995 11.3755 10.9375 11.3755C10.88 11.3755 10.8231 11.3642 10.77 11.3422C10.7169 11.3202 10.6686 11.2879 10.628 11.2473L7 7.61876L3.37203 11.2473C3.28994 11.3294 3.1786 11.3755 3.0625 11.3755C2.9464 11.3755 2.83506 11.3294 2.75297 11.2473C2.67088 11.1652 2.62476 11.0538 2.62476 10.9377C2.62476 10.8216 2.67088 10.7103 2.75297 10.6282L6.38148 7.00024L2.75297 3.37227C2.67088 3.29018 2.62476 3.17884 2.62476 3.06274C2.62476 2.94665 2.67088 2.8353 2.75297 2.75321C2.83506 2.67112 2.9464 2.625 3.0625 2.625C3.1786 2.625 3.28994 2.67112 3.37203 2.75321L7 6.38173L10.628 2.75321C10.7101 2.67112 10.8214 2.625 10.9375 2.625C11.0536 2.625 11.1649 2.67112 11.247 2.75321C11.3291 2.8353 11.3752 2.94665 11.3752 3.06274C11.3752 3.17884 11.3291 3.29018 11.247 3.37227L7.61851 7.00024L11.247 10.6282Z"
                        fill="#418997"
                    />
                </svg>
                <ButtonRequest
                    :label="'Save draft'"
                    :submit-button="false"
                    class="create__request-button-save-draft"
                    @click="saveDraft"
                />
            </div>
            <div class="create__request-button">
                <ButtonRequest
                    :label="'Clear'"
                    :submit-button="false"
                    class="create__request-button-left"
                    @click="handleClearForm"
                />
                <ButtonRequest
                    v-if="isFormEmpty"
                    :label="'Submit'"
                    :submit-button="true"
                    class="create__request-button-right create__request-disabled-button"
                />
                <ButtonRequest
                    v-if="!isFormEmpty"
                    :label="'Submit'"
                    :submit-button="true"
                    class="create__request-button-right"
                    @click="handleButtonNext"
                />
            </div>
        </div>
        <div v-if="requestStep === 2" class="create__request-container">
            <SubHeader :label="'Check request details'" show-logo-sp @close="requestStep = 1" />
            <div class="create__request-step2-title mt-4">Check request details</div>
            <BaseCard style="margin-top: 16px;">
                <div class="create__request-step2-item-wrap">
                    <BaseCardInfo
                        :label="'Summary'"
                        :content="form.summary"
                    />
                </div>
            </BaseCard>
            <BaseCard>
                <div class="create__request-step2-item-wrap">
                    <BaseCardInfo
                        :label="'Category'"
                        :content="getCategoryName"
                    />
                    <div class="create__request-step2-line"></div>
                    <BaseCardInfo
                        :label="'Price'"
                        :content="`${form.min_price} ~ ${form.max_price}`"
                    />
                    <div class="create__request-step2-line"></div>
                    <BaseCardInfo
                        :label="'Capacity'"
                        :content="`${form.min_capacity} ~ ${form.max_capacity}`"
                    />
                </div>
            </BaseCard>
            <BaseCard>
                <div class="create__request-step2-item-wrap">
                    <BaseCardInfo
                        :label="'Detail'"
                        :content="form.detail"
                    />
                </div>
            </BaseCard>
            <div class="create__request-button step2">
                <ButtonRequest
                    :label="'Back'"
                    :submit-button="false"
                    class="create__request-button-left"
                    @click="handleBackButton"
                />
                <ButtonRequest
                    :label="'Submit'"
                    :submit-button="true"
                    class="create__request-button-right"
                    @click="handleButtonClick"
                />
            </div>
        </div>
        <Modal :show-modal="isOpenConfirmModal" @close="closeConfirmModal">
            <div class="modal__container">
                <div class="modal__title">
                    <div>Register your request.</div>
                    <div>Is it OK?</div>
                </div>
                <BaseCard>
                    <div class="modal__content-wrap">
                        <div class="modal__content-title">
                            Explanation
                        </div>
                        <div>
                            ①You can check the request details at any time from the request tab.
                        </div>
                        <div>
                            ②You can change your request until the lesson is registered.
                        </div>
                        <div>
                            ③You will receive a notification when a teacher adds a lesson to your request.
                        </div>
                    </div>
                </BaseCard>
                <div class="modal__btn">
                    <button
                        class="modal__btn-btn modal__btn-btn-left"
                        @click="closeConfirmModal"
                    >
                        Cancel
                    </button>
                    <button
                        class="modal__btn-btn modal__btn-btn-right"
                        @click="submitForm"
                    >
                        Submit
                    </button>
                </div>
            </div>
        </Modal>

    </Layout>
</template>
<script setup>
import { ref, computed, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import InputForm from "@/Components/Common/InputForm.vue";
import ButtonRequest from "@/Components/Button/ButtonRequest.vue";
import Modal from "@/Components/Modal/Modal.vue";
import BaseCard from "@/Components/Card/BaseCard.vue";
import UlError from "@/Components/Common/UlError.vue";
import SubHeader from "@/Components/SubHeader/SubHeader.vue";
import CustomSelect from "@/Components/CustomSelect/CustomSelect.vue";
import DoubleSelect from "@/Components/DoubleSelect/DoubleSelect.vue";
import BaseCardInfo from "@/Components/Card/BaseCardInfo.vue";
import Breadcrumb from "@/Components/Breadcrumb/Breadcrumb.vue";

const props = defineProps({
    // eslint-disable-next-line vue/require-default-prop
    categories: Array,
});
const breadcrumbItems = [
    { text: "Request list", isLink: true, href: 'request.index' },
    { text: "Register your request", isLink: false },
]
const mappingCategories = (data) => {
    return data.map(categoryData => {
        return {
            label: categoryData.name_en,
            id: categoryData.id
        }
    })
};
const saveDraft = () => {
    form.draft = true
    form.post(route("request.create.store"), {
        onFinish: () => {
        },
    });
}
const requestStep = ref(1)
const handleButtonNext = () => {
    form.draft = false;
    form.confirm = false;
    form.post(route("request.create.store"), {
        onFinish: () => {
            if (
                Object.keys(form.errors).length === 0 &&
                form.errors.constructor === Object
            ) {
                requestStep.value = 2
            }
        },
    });
}
const handleBackButton = () => {
    requestStep.value = 1
}

const form = useForm({
    summary: "",
    category_id: null,
    min_price: null,
    max_price: null,
    min_capacity: null,
    max_capacity: null,
    detail: "",
    confirm: false,
    draft: false,
});
const updateCategoryId = (value) => {
    form.category_id = value.id;
}
const minPriceRange = [0, 1000000, 2000000, 3000000, 4000000, 5000000];
const maxPriceRange = [1000000, 2000000, 3000000, 4000000, 5000000, 10000000];
const capacityRange = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

let isOpenConfirmModal = ref(false);
const getCategoryName = computed(() => {
    let category = props.categories.find(c => c.id === form.category_id)

    return category.name_en
})
const handleButtonClick = () => {
    form.post(route("request.create"), {
        onFinish: () => {
            if (
                Object.keys(form.errors).length === 0 &&
                form.errors.constructor === Object
            ) {
                isOpenConfirmModal.value = !isOpenConfirmModal.value;
            }
        },
    });
};

const handleClearForm = () => {
    form.summary = "";
    form.category_id = "";
    form.min_price = "";
    form.max_price = "";
    form.min_capacity = "";
    form.max_capacity = "";
    form.detail = "";
};

const closeConfirmModal = () => {
    isOpenConfirmModal.value = !isOpenConfirmModal.value;
};

const submitForm = () => {
    isOpenConfirmModal.value = !isOpenConfirmModal.value;
    form.confirm = true;
    form.post(route("request.create"));
};

const isFormEmpty = computed(() => {
    return (
        form.summary === "" ||
        form.category_id === null ||
        form.min_price === null ||
        form.max_price === null ||
        form.min_capacity === null ||
        form.max_capacity === null ||
        form.detail === ""
    );
});
</script>
<style lang="scss">
@import "../../../Components/Header/header";
@import "./createrequest";
</style>
<style scoped lang="scss">
.form__item-wrapper {
    margin-top: 16px;
}
.form__wrap-item {
    padding-bottom: 0px;
}
.form__wrap-item label {
    padding-bottom: 4px !important;
}
.item {
    margin: 0px !important;
    padding: 16px;
}
.item-text {
    margin: 0px;
}
.list-days {
    display: grid;
    grid-template-columns: auto auto auto auto auto;
    margin-right: 30px;
}
@media all and (max-width: 768px) {
    .list-days {
        grid-template-columns: auto auto auto auto;
    }
}
.create__request-checkbox {
    margin-top: 16px;
}
.create__request-disabled-button {
    background-color: #cacaca !important;
}
.teacher__dashboard-card-container {
    margin-bottom: 16px;
}
.step2 {
    .create__request-button-left.submit__button, .create__request-button-right.submit__button {
        margin-top: 8px !important;
    }
}
.submit__button {
    margin-top: 16px;
}
.create__request-textarea {
    gap: 0;
    line-height: 1.6;
    textarea {
        padding: 12px 10px;
        border: 1px solid #E3E3E3;
        border-radius: 4px;
        min-height: 96px;
        font-size: 12px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #e3e3e3 #fff;
    }
    textarea:focus-visible {
        outline: none;
    }
    .create__request-textarea-count {
        color: #7F7F7F;
        font-size: 10px;
        bottom: -14px;
    }
    textarea::-webkit-scrollbar {
        width: 6px;
    }
    textarea::-webkit-scrollbar-thumb {
        border-radius: 100px;
        background: #7f7f7f99;
    }
    textarea::-webkit-scrollbar-track {
        background-color: #f4f4f4;
    }
}
</style>
