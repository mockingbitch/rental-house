<template>
    <Layout>
        <SubHeader :label="'リクエストを登録'" href="request.index" is-close show-logo-sp />
        <div class="create__request-container">
            <InputForm
                :label="lang().label.request_form.field.request_summary"
                :placeholder="'キーワードを入力'"
                v-model:message="form.summary"
            />
            <UlError :message="form.errors.summary" />
            <SelectForm
                :label="lang().label.request_form.field.lesson_category"
                :options="props.categories"
                :title="'Other'"
                v-model:selected="form.category_id"
            />
            <UlError :message="form.errors.category_id" />
            <RangeSelectForm
                :label="lang().label.request_form.field.age"
                :options1="ageRange"
                :options2="
                    form.min_age
                        ? ageRange.filter((age) => age >= form.min_age)
                        : ageRange
                "
                :title="'example'"
                :icon="'/img/icon/RequestClass/user.svg'"
                v-model:selected1="form.min_age"
                v-model:selected2="form.max_age"
                :errorMsg1="form.errors.min_age"
                :errorMsg2="form.errors.max_age"
            />
            <RangeSelectForm
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
                v-model:selected1="form.min_price"
                v-model:selected2="form.max_price"
                :errorMsg1="form.errors.min_price"
                :errorMsg2="form.errors.max_price"
            />
            <RangeSelectForm
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
                v-model:selected1="form.min_time"
                v-model:selected2="form.max_time"
                :errorMsg1="form.errors.min_time"
                :errorMsg2="form.errors.max_time"
            />
            <div class="form__wrap-item">
                <label for="Title" class="create__request-checkbox">
                    <span>曜日指定</span>
                </label>
                <ul class="list-days">
                    <li
                        class="item"
                        v-for="day in dayRange"
                        :key="day.key"
                        :class="{ checked: selectedDays.includes(day.key) }"
                        @click="toggleDaySelection(day.key)"
                    >
                        <span class="checkbox">
                            <i
                                class="fa-solid fa-check check-icon"
                                v-if="selectedDays.includes(day.key)"
                            ></i>
                        </span>
                        <span class="item-text">{{ day.value }}</span>
                    </li>
                </ul>
            </div>
            <UlError :message="form.errors.weekdays" />
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
            <InputForm
                :label="lang().label.request_form.field.language"
                :placeholder="'Language'"
                :isDisplayIcon="false"
                :isShowIconLeft="true"
                :isShowTextRight="'言語を設定'"
                v-model:message="form.language"
            />
            <UlError :message="form.errors.language" />
            <InputForm
                :label="lang().label.request_form.field.about_teacher"
                :placeholder="'example'"
                :isDisplayIcon="true"
                v-model:message="form.about_teacher"
            />
            <UlError :message="form.errors.about_teacher" />
            <InputForm
                :label="lang().label.request_form.field.request_detail"
                :placeholder="'example'"
                :isDisplayIcon="true"
                v-model:message="form.detail"
            />
            <UlError :message="form.errors.detail" />
            <div class="create__request-button">
                <ButtonRequest
                    @click="handleClearForm"
                    :label="'条件をクリア'"
                    :submit-button="false"
                    class="create__request-button-left"
                />
                <ButtonRequest
                    v-if="isFormEmpty"
                    :label="'リクエスト登録'"
                    :submit-button="true"
                    class="create__request-button-right create__request-disabled-button"
                />
                <ButtonRequest
                    v-if="!isFormEmpty"
                    :label="'リクエスト登録'"
                    :submit-button="true"
                    class="create__request-button-right"
                    @click="handleButtonClick"
                />
            </div>
        </div>
        <Modal :showModal="isOpenConfirmModal" @close="closeConfirmModal">
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
                        @click="closeConfirmModal"
                        class="modal__btn-btn modal__btn-btn-left"
                    >
                        {{ lang().label.request_form.field.cancel }}
                    </button>
                    <button
                        @click="submitForm"
                        class="modal__btn-btn modal__btn-btn-right"
                    >
                        {{ lang().label.request_form.field.submit }}
                    </button>
                </div>
            </div>
        </Modal>
    </Layout>
</template>
<script setup>
import { ref, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Layout from "../../../Layouts/Layout.vue";
import InputForm from "@/Components/Request/Common/InputForm.vue";
import SelectForm from "@/Components/Request/Common/SelectForm.vue";
import RangeSelectForm from "@/Components/Request/Common/RangeSelectForm.vue";
import ButtonRequest from "@/Components/Request/ButtonRequest.vue";
import Modal from "@/Components/Modal/Modal.vue";
import BaseCard from "@/Components/Teacher/Common/BaseCard.vue";
import UlError from "@/Components/UlError.vue";
import { timeRangeLesson } from "../../../Helper/timeRangeLesson";
import CustomTimeZone from "@/Components/Request/Common/CustomTimeZone.vue";
import SubHeader from "../../../Components/Common/SubHeader.vue";

const props = defineProps({
    categories: Array,
});

const form = useForm({
    summary: "",
    category_id: null,
    min_age: null,
    max_age: null,
    min_price: null,
    max_price: null,
    min_time: null,
    max_time: null,
    weekdays: null,
    start_time: null,
    end_time: null,
    language: null,
    about_teacher: "",
    detail: "",
    confirm: false,
});

const handleResetForm = () => {
    form.summary = "";
    form.category_id = null;
    form.min_age = null;
    form.max_age = null;
    form.min_price = null;
    form.max_price = null;
    form.min_time = null;
    form.max_time = null;
    form.weekdays = null;
    form.start_time = null;
    form.end_time = null;
    form.language = null;
    form.about_teacher = "";
    form.detail = "";
};
// Fake data
const selectedDays = ref([]);
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

const timeRange = ref([]);
const timeRangeStart = ref([]);

for (let i = 0; i <= 23; i++) {
    for (let j = 0; j < 60; j++) {
        if (j % 30 === 0) {
            let minute = "";
            let hour = "";
            if (j < 10) {
                minute = `0${j}`;
            } else {
                minute = `${j}`;
            }
            if (i < 10) {
                hour = `0${i}`;
            } else {
                hour = `${i}`;
            }
            if (i === 23 && j === 30) {
                timeRange.value.push("23:30");
                break;
            }
            timeRangeStart.value.push(`${hour}:${minute}`);
            timeRange.value.push(`${hour}:${minute}`);
        }
    }
}

let isOpenConfirmModal = ref(false);

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
    form.confirm = true;
    form.post(route("request.create"));
};

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
<style scoped>
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
</style>
