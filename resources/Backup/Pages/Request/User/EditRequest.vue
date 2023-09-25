<template>
    <Layout>
        <SubHeader :label="'リクエストを編集'" href="request.index" is-close show-logo-sp />
        <div class="create__request-container">
            <InputForm
                v-model:message="form.summary"
                :label="lang().label.request_form.field.request_summary"
                :placeholder="'キーワードを入力'"
            />
            <UlError :message="form.errors.summary" />
            <SelectForm
                v-model:selected="form.category_id"
                :label="lang().label.request_form.field.lesson_category"
                :options="props.categories"
                :title="'Other'"
            />
            <UlError :message="form.errors.category_id" />
            <RangeSelectForm
                v-model:selected1="form.min_age"
                v-model:selected2="form.max_age"
                :label="lang().label.request_form.field.age"
                :options1="ageRange"
                :options2="
                    form.min_age
                        ? ageRange.filter((age) => age >= form.min_age)
                        : ageRange
                "
                :title="'example'"
                :icon="'/img/icon/RequestClass/user.svg'"
            />
            <UlError :message="form.errors.min_age" />
            <UlError :message="form.errors.max_age" />
            <RangeSelectForm
                v-model:selected1="form.min_price"
                v-model:selected2="form.max_price"
                :label="lang().label.request_form.field.price_range"
                :options1="minPriceRange"
                :options2="
                    form.min_price
                        ? maxPriceRange.filter(
                              (price) => price > form.min_price
                          )
                        : maxPriceRange
                "
                :title="'example'"
                :icon="'/img/icon/RequestClass/wallet.svg'"
            />
            <UlError :message="form.errors.min_price" />
            <UlError :message="form.errors.max_price" />
            <RangeSelectForm
                v-model:selected1="form.min_time"
                v-model:selected2="form.max_time"
                :label="lang().label.request_form.field.lesson_time"
                :options1="timeRangeLesson"
                :options2="
                    form.min_time
                        ? timeRangeLesson.filter(
                              (time) => time >= form.min_time
                          )
                        : timeRangeLesson
                "
                :title="'example'"
                :icon="'/img/icon/RequestClass/time.svg'"
            />
            <UlError :message="form.errors.min_time" />
            <UlError :message="form.errors.max_time" />
            <div class="form__wrap-item">
                <label for="Title" class="create__request-checkbox">
                    <span>曜日指定</span>
                </label>
                <ul class="list-days">
                    <li
                        v-for="day in dayRange"
                        :key="day.key"
                        class="item"
                        :class="{ checked: selectedDays.includes(day.key) }"
                        @click="toggleDaySelection(day.key)"
                    >
                        <span class="checkbox">
                            <i
                                v-if="selectedDays.includes(day.key)"
                                class="fa-solid fa-check check-icon"
                            ></i>
                        </span>
                        <span class="item-text">{{ day.value }}</span>
                    </li>
                </ul>
            </div>
            <UlError :message="form.errors.weekdays" />
            <!-- custom select timezone -->
            <CustomTimeZone
                :label="lang().label.request_form.field.timezone"
                :start="form.start_time"
                :end="form.end_time"
                @select-start-time="handleSelectStartTime"
                @select-end-time="handleSelectEndTime"
                @fill-start-time="handleSelectEndTime"
                @fill-end-time="handleSelectStartTime"
                @start-time="handleSelectStartTime"
                @end-time="handleSelectEndTime"
            />
            <UlError :message="form.errors.start_time" />
            <UlError :message="form.errors.end_time" />
            <InputForm
                v-model:message="form.language"
                :label="lang().label.request_form.field.language"
                :placeholder="'example'"
                :is-display-icon="false"
            />
            <UlError :message="form.errors.language" />
            <InputForm
                v-model:message="form.about_teacher"
                :label="lang().label.request_form.field.about_teacher"
                :placeholder="'example'"
                :is-display-icon="true"
            />
            <UlError :message="form.errors.about_teacher" />
            <InputForm
                v-model:message="form.detail"
                :label="lang().label.request_form.field.request_detail"
                :placeholder="'example'"
                :is-display-icon="true"
            />
            <UlError :message="form.errors.detail" />
            <div class="create__request-button">
                <ButtonRequest
                    :label="'戻る'"
                    :submit-button="false"
                    class="create__request-button-left"
                    @click="handleClearForm"
                />
                <ButtonRequest
                    v-if="isFormEmpty"
                    :label="'リクエスト登録'"
                    :submit-button="true"
                    class="create__request-button-right create__request-disabled-button"
                />
                <ButtonRequest
                    v-if="!isFormEmpty"
                    :label="'更新する'"
                    :submit-button="true"
                    class="create__request-button-right"
                    @click="handleButtonClick"
                />
            </div>
        </div>
        <Modal :show-modal="isOpenConfirmModal" @close="closeConfirmModal">
            <div class="modal__container">
                <div class="modal__title">
                    <div>{{ lang().label.request_form.modal_title }}</div>
                    <div>{{ lang().label.request_form.modal_note_1 }}</div>
                </div>
                <BaseCard>
                    <div class="modal__content-wrap">
                        <div class="modal__content-title">{{ lang().label.request_form.modal_note_2 }}</div>
                        <div>
                            {{ lang().label.request_form.modal_content_1 }}
                        </div>
                        <div>
                            {{ lang().label.request_form.modal_content_2 }}
                        </div>
                        <div>
                            {{ lang().label.request_form.modal_content_3 }}
                        </div>
                    </div>
                </BaseCard>
                <div class="modal__btn">
                    <button
                        class="modal__btn-btn modal__btn-btn-left"
                        @click="closeConfirmModal"
                    >
                        {{ lang().label.request_form.field.cancel }}
                    </button>
                    <button
                        class="modal__btn-btn modal__btn-btn-right"
                        @click="submitForm"
                    >
                        {{ lang().label.request_form.field.submit }}
                    </button>
                </div>
            </div>
        </Modal>
    </Layout>
</template>
<script setup>
import { ref, computed, watch } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

import Layout from "@/Layouts/Layout.vue";
import InputForm from "@/Components/Request/Common/InputForm.vue";
import SelectForm from "@/Components/Request/Common/SelectForm.vue";
import RangeSelectForm from "@/Components/Request/Common/RangeSelectForm.vue";
import ButtonRequest from "@/Components/Request/ButtonRequest.vue";
import Modal from "@/Components/Modal/Modal.vue";
import BaseCard from "@/Components/Teacher/Common/BaseCard.vue";
import UlError from "@/Components/UlError.vue";
import { timeRangeLesson } from "../../../Helper/timeRangeLesson";
import SubHeader from "../../../Components/Common/SubHeader.vue";
import CustomTimeZone from "@/Components/Request/Common/CustomTimeZone.vue";

const props = defineProps({
    categories: Array,
    request: Object,
});

const form = useForm({
    summary: props.request.summary,
    category_id: props.request.category_id,
    min_age: props.request.min_age,
    max_age: props.request.max_age,
    min_price: props.request.min_price,
    max_price: props.request.max_price,
    min_time: props.request.min_time,
    max_time: props.request.max_time,
    weekdays: props.request.weekdays,
    start_time: props.request.start_time,
    end_time: props.request.end_time,
    language: props.request.language,
    about_teacher: props.request.about_teacher,
    detail: props.request.detail,
});

let selectedDays = ref(props?.request?.weekdays ?? []);
let dayRange = ref([
    {
        key: 2,
        value: usePage().props.language.original.label.week_day.Mon,
    },
    {
        key: 3,
        value: usePage().props.language.original.label.week_day.Tue,
    },
    {
        key: 4,
        value: usePage().props.language.original.label.week_day.Wed,
    },
    {
        key: 5,
        value: usePage().props.language.original.label.week_day.Thu,
    },
    {
        key: 6,
        value: usePage().props.language.original.label.week_day.Fri,
    },
    {
        key: 7,
        value: usePage().props.language.original.label.week_day.Sat,
    },
    {
        key: 8,
        value: usePage().props.language.original.label.week_day.Sun,
    },
]);
const ageRange = [9, 10, 11, 12, 13, 14, 15];
const minPriceRange = [0, 1001, 2001, 3001, 4001, 5001];
const maxPriceRange = [1000, 2000, 3000, 4000, 5000, 10000];

const isFormEmpty = computed(() => {
    return (
        form.summary === "" ||
        form.category_id === null ||
        form.min_age === null ||
        form.max_age === null ||
        form.min_price === null ||
        form.max_price === null ||
        form.min_time === null ||
        form.max_time === null ||
        form.weekdays === null ||
        form.start_time === null ||
        form.end_time === null ||
        form.language === null ||
        form.about_teacher === "" ||
        form.detail === ""
    );
});

let isOpenConfirmModal = ref(false);

const handleButtonClick = () => {
    isOpenConfirmModal.value = !isOpenConfirmModal.value;
};

const handleClearForm = () => {
    form.summary = "";
    form.category_id = "";
    form.min_age = "";
    form.max_age = "";
    form.min_price = "";
    form.max_price = "";
    form.min_time = "";
    form.max_time = "";
    form.weekdays = "";
    form.start_time = "";
    form.end_time = "";
    form.language = "";
    form.about_teacher = "";
    form.detail = "";
    selectedDays.value = [];
};

const toggleDaySelection = (day) => {
    if (selectedDays.value.includes(day)) {
        selectedDays.value = selectedDays.value.filter(
            (selectedDay) => selectedDay !== day
        );
    } else {
        selectedDays.value.push(day);
    }
    form.weekdays = selectedDays.value;
};

const closeConfirmModal = () => {
    isOpenConfirmModal.value = !isOpenConfirmModal.value;
};

const submitForm = () => {
    isOpenConfirmModal.value = !isOpenConfirmModal.value;
    form.post(route("request.edit", props.request.id));
};

const handleSelectStartTime = (data) => {
    form.start_time = data;
};

const handleSelectEndTime = (data) => {
    form.end_time = data;
};
</script>
<style lang="scss">
@import "../../../Components/_header.scss";
@import "./_createRequest.scss";
</style>
<style scoped lang="scss">
.form__wrap-item {
    padding-bottom: 0px !important;
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
</style>
