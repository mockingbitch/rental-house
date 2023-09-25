<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, defineEmits, watch, computed } from "vue";
import Modal from "./Modal/Modal.vue";
import Dialog from "./Dialog/Dialog.vue";
import DatePicker from "./DatePicker.vue";
import DoubleSelect from "@/Components/Request/Common/DoubleSelect.vue";
import "@vuepic/vue-datepicker/dist/main.css";
import moment from "moment";
import CustomSelect from "./Request/Common/CustomSelect.vue";
import SubHeader from "./Common/SubHeader.vue";

const emits = defineEmits();

let uri = window.location.search.substring(1);
let params = new URLSearchParams(uri);
let dayParams = params.getAll("day[]").map((item) => parseInt(item, 10));
const selectedDays = ref(dayParams ?? []);

const formSearch = useForm({
    keyword: params.get("keyword") ?? "",
    min_age: params.get("min_age") ?? null,
    max_age: params.get("max_age") ?? null,
    start_date: params.get("start_date") ?? "",
    end_date: params.get("end_date") ?? "",
    start_date_draft: params.get("start_date_draft") ?? "",
    end_date_draft: params.get("end_date_draft") ?? "",
    start_price_range: params.get("start_price_range") ?? null,
    finish_price_range: params.get("finish_price_range") ?? null,
    start_draft_price: params.get("start_draft_price") ?? null,
    finish_draft_price: params.get("finish_draft_price") ?? null,
    date: params.get("date") ?? null,
    day: selectedDays ?? [],
    start_time: params.get("start_time") ?? null,
    end_time: params.get("end_time") ?? null,
});

let isOpenSelectPrice = ref(false);
let isOpenSelectDate = ref(false);
const selectedStartDate = ref(true);
const selectedEndDate = ref(false);
let ageRange = ref([
    9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25,
]);

const minAgeRange = computed(() => {
    if (formSearch.max_age) {
        const newAgeRange = ageRange.value.filter(
            (age) => age < formSearch.max_age
        );
        return newAgeRange;
    }
    return ageRange.value;
});
const maxAgeRange = computed(() => {
    if (formSearch.min_age) {
        const newAgeRange = ageRange.value.filter(
            (age) => age > formSearch.min_age
        );
        return newAgeRange;
    }
    return ageRange.value;
});

const priceRange = ref(['0', '1000', '2000', '3000', '4000', '5000', '6000', '7000', '8000', '9000', '100000']);

const minPriceRange = computed(() => {
    if (formSearch.finish_draft_price) {
        const newPriceRange = priceRange.value.filter(
            (price) => Number(price) < Number(formSearch.finish_draft_price)
        );
        return newPriceRange;
    }
    return priceRange.value;
});
const maxPriceRange = computed(() => {
    if (formSearch.start_draft_price) {
        const newPriceRange = priceRange.value.filter(
            (price) => Number(price) > Number(formSearch.start_draft_price)
        );
        return newPriceRange;
    }
    return priceRange.value;
});

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
let hours = ref([
    "6:00",
    "7:00",
    "9:00",
    "10:00",
    "11:00",
    "12:00",
    "13:00",
    "14:00",
    "15:00",
    "16:00",
    "17:00",
    "18:00",
    "19:00",
    "20:00",
    "21:00",
    "22:00",
]);

let startHours = ref([...hours.value?.slice(0, hours.value.length - 1)]);
let endHours = ref([...hours.value?.slice(1)]);

const updateStartTimeOptions = (value) => {
    formSearch.end_time = value;
    if (formSearch.end_time) {
        startHours.value = hours.value?.filter((hour) =>
            moment(hour, "HH:mm")?.isBefore(
                moment(formSearch.end_time, "HH:mm")
            )
        );
    }
};

const updateEndTimeOptions = (value) => {
    formSearch.start_time = value;
    if (formSearch.start_time) {
        endHours.value = hours.value?.filter((hour) =>
            moment(hour, "HH:mm")?.isAfter(
                moment(formSearch.start_time, "HH:mm")
            )
        );
    }
};

const toggleDaySelection = (day) => {
    if (selectedDays.value.includes(day)) {
        selectedDays.value = selectedDays.value.filter(
            (selectedDay) => selectedDay !== day
        );
    } else {
        selectedDays.value.push(day);
    }
    formSearch.day = selectedDays.value;
};

const handleSelectPriceRange = (start, end) => {
    formSearch.start_price_range = start;
    formSearch.finish_price_range = end;
    isOpenSelectPrice.value = !isOpenSelectPrice;
    ResetRangePrice();
};

const handleSelectDateRange = (start, end) => {
    formSearch.start_date = start;
    formSearch.end_date = end;
    closeSelectDate();
};

const handleSelectedStartDate = () => {
    selectedStartDate.value = true;
    selectedEndDate.value = false;
};

const handleSelectedEndDate = () => {
    selectedStartDate.value = false;
    selectedEndDate.value = true;
};

const handleDateChange = (selectedDate) => {
    if (selectedStartDate.value) {
        formSearch.start_date_draft = selectedDate;
    } else {
        formSearch.end_date_draft = selectedDate;
    }
};

const openSelectDate = () => {
    isOpenSelectDate.value = !isOpenSelectDate.value;
    formSearch.start_date_draft = formSearch.start_date;
    formSearch.end_date_draft = formSearch.end_date;
};

const closeDialog = () => {
    showModalSelectRangeAge.value = false;
    showModalSelectStartRangePrice.value = false;
    showModalSelectFinishRangePrice.value = false;
};

const submit = () => {
    formSearch.get(route("search"));
};
let showModalSelectRangeAge = ref(false);
const showModalSelectStartRangePrice = ref(false);
const showModalSelectFinishRangePrice = ref(false);

const ResetDatePicker = () => {
    formSearch.start_date_draft = "";
    formSearch.end_date_draft = "";
    selectedStartDate.value = true;
    selectedEndDate.value = false;
};

const ResetRangePrice = () => {
    formSearch.start_draft_price = null;
    formSearch.finish_draft_price = null;
};

const closeSelectDate = () => {
    isOpenSelectDate.value = !isOpenSelectDate.value;
    ResetDatePicker();
};

const closeSelectPrice = () => {
    isOpenSelectPrice.value = !isOpenSelectPrice.value;
    ResetRangePrice();
};

const handleResetForm = () => {
    formSearch.keyword = "";
    formSearch.min_age = null;
    formSearch.max_age = null;
    formSearch.start_date = "";
    formSearch.end_date = "";
    formSearch.start_date_draft = "";
    formSearch.end_date_draft = "";
    formSearch.start_price_range = null;
    formSearch.finish_price_range = null;
    formSearch.start_draft_price = null;
    formSearch.finish_draft_price = null;
    formSearch.date = null;
    formSearch.day = [];
    formSearch.start_time = null;
    formSearch.end_time = null;
    selectedDays.value = [];
};

const handleClose = () => {
    emits("toggleSearch");
}
</script>

<template>
    <form class="form form-search" @submit.prevent="submit">
        <div class="form__wrap filter__form-wrapper">
            <SubHeader :label="lang().label.search.title" is-close @close="handleClose" />
            <div class="form__wrap-item" style="margin-top: 14.5px">
                <label for="Title">
                    <span class="title-text">{{ lang().label.search.field.lesson_title }}</span>
                </label>
                <input
                    v-model="formSearch.keyword"
                    :class="`form__input ${formSearch.keyword && 'fillInput'}`"
                    type="text"
                    name="text-search"
                    :placeholder="lang().label.search.field.lesson_title_placeholder"
                />
            </div>
            <DoubleSelect
                v-model:selected1="formSearch.min_age"
                v-model:selected2="formSearch.max_age"
                :label1="lang().label.search.field.min_age_title"
                :label2="lang().label.search.field.max_age_title"
                :options1="minAgeRange"
                :options2="maxAgeRange"
                icon="/img/icon/birthdayCake.svg"
                unit="歳"
                :fill-input-condition1="formSearch.min_age"
                :fill-input-condition2="formSearch.max_age"
				:placeholder1="lang().label.search.field.min_age_placeholder"
				:placeholder2="lang().label.search.field.max_age_placeholder"
            />
            <DoubleSelect
                v-model:selected1="formSearch.start_draft_price"
                v-model:selected2="formSearch.finish_draft_price"
                :label1="lang().label.search.field.min_price_title"
                :label2="lang().label.search.field.max_price_title"
                :options1="minPriceRange"
                :options2="maxPriceRange"
                icon="/img/icon/Walet.svg"
                unit="円"
                :fill-input-condition1="formSearch.start_draft_price"
                :fill-input-condition2="formSearch.finish_draft_price"
				:placeholder1="lang().label.search.field.min_price_placeholder"
				:placeholder2="lang().label.search.field.max_price_placeholder"
            />
            <div class="form__wrap-item">
                <label for="Title">
                    <span class="title-text">{{ lang().label.search.field.select_date_title }}</span>
                </label>
                <div
                    class="select-btn"
                    :class="{
                        open: isOpenSelectDate === true,
                        fillInput: formSearch.start_date && formSearch.end_date,
                    }"
                    @click="openSelectDate"
                >
                    <span class="icon-select-left">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="20"
                            height="20"
                            viewBox="0 0 20 20"
                            fill="none"
                        >
                            <path
                                d="M16.25 2.5H14.375V1.875C14.375 1.70924 14.3092 1.55027 14.1919 1.43306C14.0747 1.31585 13.9158 1.25 13.75 1.25C13.5842 1.25 13.4253 1.31585 13.3081 1.43306C13.1908 1.55027 13.125 1.70924 13.125 1.875V2.5H6.875V1.875C6.875 1.70924 6.80915 1.55027 6.69194 1.43306C6.57473 1.31585 6.41576 1.25 6.25 1.25C6.08424 1.25 5.92527 1.31585 5.80806 1.43306C5.69085 1.55027 5.625 1.70924 5.625 1.875V2.5H3.75C3.41848 2.5 3.10054 2.6317 2.86612 2.86612C2.6317 3.10054 2.5 3.41848 2.5 3.75V16.25C2.5 16.5815 2.6317 16.8995 2.86612 17.1339C3.10054 17.3683 3.41848 17.5 3.75 17.5H16.25C16.5815 17.5 16.8995 17.3683 17.1339 17.1339C17.3683 16.8995 17.5 16.5815 17.5 16.25V3.75C17.5 3.41848 17.3683 3.10054 17.1339 2.86612C16.8995 2.6317 16.5815 2.5 16.25 2.5ZM5.625 3.75V4.375C5.625 4.54076 5.69085 4.69973 5.80806 4.81694C5.92527 4.93415 6.08424 5 6.25 5C6.41576 5 6.57473 4.93415 6.69194 4.81694C6.80915 4.69973 6.875 4.54076 6.875 4.375V3.75H13.125V4.375C13.125 4.54076 13.1908 4.69973 13.3081 4.81694C13.4253 4.93415 13.5842 5 13.75 5C13.9158 5 14.0747 4.93415 14.1919 4.81694C14.3092 4.69973 14.375 4.54076 14.375 4.375V3.75H16.25V6.25H3.75V3.75H5.625ZM16.25 16.25H3.75V7.5H16.25V16.25Z"
                                fill="#B1B1B1"
                            />
                        </svg>
                    </span>
                    <span class="btn-text">{{ lang().label.search.field.select_date_placeholder }}</span>
                    <span class="content-drop-down">
                        {{
                            formSearch.start_date || formSearch.end_date
                                ? formSearch.start_date +
                                  (!formSearch.start_date && formSearch.end_date
                                      ? " <- "
                                      : "") +
                                  (formSearch.start_date && !formSearch.end_date
                                      ? " -> "
                                      : "") +
                                  (formSearch.start_date && formSearch.end_date
                                      ? "-"
                                      : "") +
                                  formSearch.end_date
                                : lang().label.search.field.select_date_default
                        }}
                    </span>
                </div>
            </div>
            <div class="form__wrap-item">
                <label for="Title">
                    <span class="title-text">{{ lang().label.search.field.week_day_title }}</span>
                </label>
                <ul class="list-days">
                    <li
                        class="item"
                        v-for="day in dayRange"
                        :key="day.key"
                        :class="{ checked: selectedDays.includes(day.key) }"
                        @click="toggleDaySelection(day.key)"
                    >
                        <div class="listday__checkbox-wrapper">
                            <span class="listday__checkbox">
                                <i
                                    class="fa-solid fa-check check-icon"
                                    v-if="selectedDays.includes(day.key)"
                                ></i>
                            </span>
                        </div>
                        <span class="listday__text">{{ day.value }}</span>
                    </li>
                </ul>
            </div>
            <div class="form__wrap-item">
                <div id="form-wrap-double">
                    <div
                        :class="`select ${
                            formSearch.start_time && 'fillInput'
                        }`"
                        style="flex: 1"
                    >
                        <label for="start_time">
                            <span class="title-text">start time</span>
                        </label>
                        <CustomSelect
                            :value-selected="formSearch.start_time"
                            :options="startHours"
                            up-side-down-mobile
                            @selectValue="updateEndTimeOptions"
                        />
                    </div>
                    <p class="to-text">to</p>
                    <div
                        :class="`select ${formSearch.end_time && 'fillInput'}`"
                        style="flex: 1"
                    >
                        <label for="end_time">
                            <span class="title-text">end time</span>
                        </label>
                        <CustomSelect
                            :value-selected="formSearch.end_time"
                            :options="endHours"
                            up-side-down-mobile
                            @selectValue="updateStartTimeOptions"
                        />
                    </div>
                </div>
            </div>
            <div class="space"></div>
            <div class="search-button">
                <a href="#" @click="handleResetForm">{{ lang().label.search.field.button_clear_form }}</a>
                <button type="submit" class="mainButton">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="21"
                        height="20"
                        viewBox="0 0 21 20"
                        fill="none"
                    >
                        <path
                            d="M18.4422 17.0575L14.5305 13.1466C15.6643 11.7854 16.2297 10.0395 16.109 8.27214C15.9883 6.50475 15.1909 4.85192 13.8827 3.65748C12.5744 2.46304 10.856 1.81895 9.08498 1.8592C7.31394 1.89945 5.62659 2.62094 4.37395 3.87358C3.12131 5.12622 2.39982 6.81357 2.35957 8.58462C2.31932 10.3557 2.96341 12.074 4.15785 13.3823C5.35229 14.6906 7.00512 15.488 8.7725 15.6086C10.5399 15.7293 12.2858 15.1639 13.6469 14.0302L17.5579 17.9419C17.6159 17.9999 17.6849 18.046 17.7607 18.0774C17.8366 18.1089 17.9179 18.125 18.0001 18.125C18.0822 18.125 18.1635 18.1089 18.2394 18.0774C18.3152 18.046 18.3842 17.9999 18.4422 17.9419C18.5003 17.8838 18.5464 17.8149 18.5778 17.739C18.6092 17.6631 18.6254 17.5818 18.6254 17.4997C18.6254 17.4176 18.6092 17.3363 18.5778 17.2604C18.5464 17.1845 18.5003 17.1156 18.4422 17.0575ZM3.62506 8.74969C3.62506 7.63717 3.95496 6.54963 4.57304 5.62461C5.19112 4.69958 6.06963 3.97861 7.09746 3.55287C8.1253 3.12712 9.2563 3.01573 10.3474 3.23277C11.4386 3.44981 12.4409 3.98554 13.2275 4.77221C14.0142 5.55888 14.5499 6.56116 14.767 7.65231C14.984 8.74345 14.8726 9.87445 14.4469 10.9023C14.0211 11.9301 13.3002 12.8086 12.3751 13.4267C11.4501 14.0448 10.3626 14.3747 9.25006 14.3747C7.75872 14.373 6.32894 13.7799 5.27441 12.7253C4.21987 11.6708 3.62671 10.241 3.62506 8.74969Z"
                            fill="#FFF"
                        />
                    </svg>
                    <p>{{ lang().label.search.field.button_submit_form }}</p>
                </button>
            </div>
            <Modal :show-modal="isOpenSelectPrice" @close="closeSelectPrice">
                <div class="select-range-price">
                    <div class="select-range-title">
                        <h2>料金</h2>
                    </div>
                    <div id="form-wrap-double">
                        <div class="select">
                            <label for="Title">
                                <span class="modal__sub-title">下限</span>
                            </label>
                            <div
                                id="half_width"
                                name="start_time"
                                @click="
                                    showModalSelectStartRangePrice =
                                        !showModalSelectStartRangePrice
                                "
                            >
                                <span
                                    v-if="!formSearch.start_draft_price"
                                    value=""
                                >
                                    下限なし
                                </span>
                                <span
                                    v-else
                                    :value="formSearch.start_draft_price"
                                    selected
                                >
                                    {{ formSearch.start_draft_price }}
                                </span>
                            </div>
                        </div>
                        <div class="select">
                            <label for="Title">
                                <span class="modal__sub-title">上限</span>
                            </label>
                            <div
                                id="half_width"
                                name="end_time"
                                @click="
                                    showModalSelectFinishRangePrice =
                                        !showModalSelectFinishRangePrice
                                "
                            >
                                <span
                                    v-if="!formSearch.finish_draft_price"
                                    value=""
                                >
                                    上限なし
                                </span>
                                <span
                                    v-else
                                    :value="formSearch.finish_draft_price"
                                    selected
                                >
                                    {{ formSearch.finish_draft_price }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="select-price-button"
                        @click="
                            handleSelectPriceRange(
                                formSearch.start_draft_price,
                                formSearch.finish_draft_price
                            )
                        "
                    >
                        <div>
                            <p>決定</p>
                        </div>
                    </div>
                </div>
            </Modal>
            <Modal :show-modal="isOpenSelectDate" @close="closeSelectDate">
                <div
                    class="select-range-price"
                    style="padding: 8px 4px 4px 4px"
                >
                    <div class="select-range-title">
                        <h2>日付</h2>
                    </div>
                    <div id="form-wrap-double" class="input__date-wrapper">
                        <div class="select">
                            <label for="Title">
                                <span class="select__title-text"
                                    >{{ lang().label.search.field.start_date_title }}</span
                                >
                            </label>
                            <div
                                id="half_width"
                                name="start_time"
                                :class="{ active: selectedStartDate }"
                                @click="handleSelectedStartDate"
                            >
                                <span
                                    v-if="!formSearch.start_date_draft"
                                    value=""
                                    style="font-size: 12px; font-weight: 400;"
                                >
                                    本日
                                </span>
                                <span
                                    v-else
                                    :value="formSearch.start_date_draft"
                                    selected
                                >
                                    {{ formSearch.start_date_draft }}
                                </span>
                            </div>
                        </div>
                        <div class="select" style="margin-left: 8px">
                            <label for="Title">
                                <span class="select__title-text">{{ lang().label.search.field.end_date_title }}</span>
                            </label>
                            <div
                                id="half_width"
                                name="end_time"
                                :class="{ active: selectedEndDate }"
                                @click="handleSelectedEndDate"
                            >
                                <span
                                    v-if="!formSearch.end_date_draft"
                                    value=""
                                    style="font-size: 12px; font-weight: 400;"
                                >
                                    上限なし
                                </span>
                                <span
                                    v-else
                                    :value="formSearch.end_date_draft"
                                    selected
                                >
                                    {{ formSearch.end_date_draft }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <DatePicker
                        :isSelectStartDate="selectedStartDate"
                        :isSelectEndDate="selectedEndDate"
                        :selectedStartDate="formSearch.start_date_draft"
                        :selectedEndDate="formSearch.end_date_draft"
						:clear-select-date="lang().label.search.field.select_date_clear"
                        @update:modelValue="handleDateChange"
                        @reset-date-picker="ResetDatePicker"
                    />
                    <!-- <div v-if="showSelectEndDate">
                        <DatePicker
                            v-model="formSearch.end_date_draft"
                            @update:modelValue="handleEndDateChange"
                            :min="new Date().toISOString().substr(0, 10)"
                        />
                    </div> -->
                    <div
                        class="select-price-button"
                        @click="
                            handleSelectDateRange(
                                formSearch.start_date_draft,
                                formSearch.end_date_draft
                            )
                        "
                    >
                        <div>
                            <p>{{ lang().label.search.field.select_date_confirm }}</p>
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </form>
</template>

<style lang="scss" scoped>
@import '../Header/header';
@import './search';
</style>
