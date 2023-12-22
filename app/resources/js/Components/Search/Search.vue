<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import {computed, defineEmits, ref} from "vue";
import "@vuepic/vue-datepicker/dist/main.css";
import Modal from "@/Components/Modal/Modal.vue";
// import Dialog from "./Dialog/BaseDialog.vue";
import DatePicker from "@/Components/DatePicker/DatePicker.vue";
import DoubleSelect from "@/Components/DoubleSelect/DoubleSelect.vue";
import TripleSelect from "@/Components/DoubleSelect/TripleSelect.vue";
import SingleSelect from "@/Components/DoubleSelect/SingleSelect.vue";
import SubHeader from "@/Components/SubHeader/SubHeader.vue";
import { priceFormat, revertPriceFormat } from "../../Helper/CurrencyHelper";

// eslint-disable-next-line vue/valid-define-emits
const emits = defineEmits();

let uri = window.location.search.substring(1);
let params = new URLSearchParams(uri);
const provinces = usePage().props.provinces;
const districts = usePage().props.districts;
const wards = usePage().props.wards;
const categories = usePage().props.categories;

const formSearch = useForm({
    keyword: params.get("keyword") ?? "",
    province: params.get("province") ?? "",
    district: params.get("district") ?? "",
    ward: params.get("ward") ?? "",
    province_code: params.get("province_code") ?? "",
    district_code: params.get("district_code") ?? "",
    ward_code: params.get("ward_code") ?? "",
    start_price_range: params.get("start_price_range") ?? null,
    finish_price_range: params.get("finish_price_range") ?? null,
    start_draft_price: null,
    finish_draft_price: null,
    category: params.get("category") ?? "",
    category_id: null
});

let isOpenSelectPrice = ref(false);
let isOpenSelectDate = ref(false);
const selectedStartDate = ref(true);
const selectedEndDate = ref(false);

const priceRange = ref([
    "0",
    "1000000",
    "2000000",
    "3000000",
    "4000000",
    "5000000",
    "6000000",
    "7000000",
    "8000000",
    "9000000",
    "100000000",
]);
const listCategory = computed(() => {
    return categories.map(item => item.name_en)
})
const listProvince = computed(() => {
    return provinces.map(item => item.name);
});
const listDistrict = computed(() => {
   if (formSearch.province) {
       let province = provinces.filter(
           item => item.name === formSearch.province
       );
       let listDistrict = districts.filter(
           item => item.province_code === province[0]?.code
       );
       return listDistrict.map(item => item.name);
   }
   return [];
});
const listWard = computed(() => {
    if (formSearch.district) {
        let district = districts.filter(
            item => item.name === formSearch.district
        );
        console.log(district)
        let listWard = wards.filter(
            item => item.district_code === district[0]?.code
        );
        return listWard.map(item => item.name);
    }
    return [];
});

const minPriceRange = computed(() => {
    if (formSearch.finish_draft_price) {
        let price = priceRange.value.filter(
            (price) => Number(price) < Number(revertPriceFormat(formSearch.finish_draft_price))
        );
        return price.map(item => priceFormat(item));
    }
    return priceRange.value.map(item => priceFormat(item));
});
const maxPriceRange = computed(() => {
    if (formSearch.start_draft_price) {
        let price = priceRange.value.filter(
            (price) => Number(price) > Number(revertPriceFormat(formSearch.start_draft_price))
        );

        return price.map(item => priceFormat(item));
    }
    return priceRange.value.map(item => priceFormat(item));
});

const handleSelectPriceRange = (start, end) => {
    formSearch.start_price_range = start;
    formSearch.finish_price_range = end;
    isOpenSelectPrice.value = !isOpenSelectPrice.value;
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
        handleSelectedEndDate();
    } else if (selectedEndDate.value) {
        formSearch.end_date_draft = selectedDate;
        if (formSearch.start_date_draft === "") {
            handleSelectedStartDate();
        }
    }
};

const handleSearch = () => {
    let province = provinces.filter(item => item.name === formSearch.province);
    let district = districts.filter(item => item.name === formSearch.district);
    let ward = wards.filter(item => item.name === formSearch.ward);
    formSearch.province_code = province[0]?.code;
    formSearch.district_code = district[0]?.code;
    formSearch.ward_code = ward[0]?.code;
    formSearch.start_price_range = formSearch.start_draft_price
        ? revertPriceFormat(formSearch.start_draft_price)
        : null;
    formSearch.finish_price_range = formSearch.finish_draft_price
        ? revertPriceFormat(formSearch.finish_draft_price)
        : null;
    let category = categories.filter(item => item.name_en === formSearch.category);
    formSearch.category_id = category[0]?.id;
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
    formSearch.province = null;
    formSearch.district = null;
    formSearch.ward = null;
    formSearch.province_code = null;
    formSearch.district_code = null;
    formSearch.ward_code = null;
    formSearch.start_price_range = null;
    formSearch.finish_price_range = null;
    formSearch.start_draft_price = null;
    formSearch.finish_draft_price = null;
};

const handleClose = () => {
    emits("toggleSearch");
};
</script>

<template>
    <form class="form form-search" @submit.prevent="submit">
        <div class="form__wrap filter__form-wrapper">
            <SubHeader
                :label="lang().label.search.search"
                is-close
                @close="handleClose"
            />
            <div class="form__wrap-item" style="margin-top: 14.5px">
                <label for="Title">
                    <span class="title-text">{{ lang().label.search.keyword }}</span>
                </label>
                <input
                    v-model="formSearch.keyword"
                    :class="`form__input ${formSearch.keyword && 'fillInput'}`"
                    type="text"
                    name="text-search"
                    :placeholder="lang().label.search.placeholder_keyword"
                />
            </div>
            <TripleSelect
                v-model:selected1="formSearch.province"
                v-model:selected2="formSearch.district"
                v-model:selected3="formSearch.ward"
                :label1="lang().label.search.address"
                :label2="lang().label.search.district"
                :label3="lang().label.search.ward"
                :options1="listProvince"
                :options2="listDistrict"
                :options3="listWard"
                :text-to="'-'"
                icon="/img/icon/address.svg"
                unit=""
                :fill-input-condition1="formSearch.province"
                :fill-input-condition2="formSearch.district"
                :fill-input-condition3="formSearch.ward"
                :placeholder1="lang().label.search.province"
                :placeholder2="lang().label.search.district"
                :placeholder3="lang().label.search.ward"
            />
            <DoubleSelect
                v-model:selected1="formSearch.start_draft_price"
                v-model:selected2="formSearch.finish_draft_price"
                :label1="lang().label.search.min_price"
                :label2="lang().label.search.max_price"
                :options1="minPriceRange"
                :options2="maxPriceRange"
                :text-to="lang().label.search.to"
                icon="/img/icon/Wallet.svg"
                unit=" VND"
                :fill-input-condition1="formSearch.start_draft_price"
                :fill-input-condition2="formSearch.finish_draft_price"
                :placeholder1="lang().label.search.placeholder_min_price"
                :placeholder2="lang().label.search.placeholder_max_price"
            />
            <SingleSelect
                v-model:selected1="formSearch.category"
                :label1="lang().label.search.category"
                :options1="listCategory"
                icon="/img/icon/category-icon.svg"
                unit=""
                :placeholder1="lang().label.search.placeholder_category"
            />

<!--            <div class="form__wrap-item">-->
<!--                <label for="Title">-->
<!--                    <span class="title-text">-->
<!--                        Select date-->
<!--                    </span>-->
<!--                </label>-->
<!--                <div-->
<!--                    class="select-btn"-->
<!--                    :class="{-->
<!--                        open: isOpenSelectDate === true,-->
<!--                        fillInput: formSearch.start_date && formSearch.end_date,-->
<!--                    }"-->
<!--                    @click="openSelectDate"-->
<!--                >-->
<!--                    <span class="icon-select-left">-->
<!--                        <svg-->
<!--                            xmlns="http://www.w3.org/2000/svg"-->
<!--                            width="20"-->
<!--                            height="20"-->
<!--                            viewBox="0 0 20 20"-->
<!--                            fill="none"-->
<!--                        >-->
<!--                            <path-->
<!--                                d="M16.25 2.5H14.375V1.875C14.375 1.70924 14.3092 1.55027 14.1919 1.43306C14.0747 1.31585 13.9158 1.25 13.75 1.25C13.5842 1.25 13.4253 1.31585 13.3081 1.43306C13.1908 1.55027 13.125 1.70924 13.125 1.875V2.5H6.875V1.875C6.875 1.70924 6.80915 1.55027 6.69194 1.43306C6.57473 1.31585 6.41576 1.25 6.25 1.25C6.08424 1.25 5.92527 1.31585 5.80806 1.43306C5.69085 1.55027 5.625 1.70924 5.625 1.875V2.5H3.75C3.41848 2.5 3.10054 2.6317 2.86612 2.86612C2.6317 3.10054 2.5 3.41848 2.5 3.75V16.25C2.5 16.5815 2.6317 16.8995 2.86612 17.1339C3.10054 17.3683 3.41848 17.5 3.75 17.5H16.25C16.5815 17.5 16.8995 17.3683 17.1339 17.1339C17.3683 16.8995 17.5 16.5815 17.5 16.25V3.75C17.5 3.41848 17.3683 3.10054 17.1339 2.86612C16.8995 2.6317 16.5815 2.5 16.25 2.5ZM5.625 3.75V4.375C5.625 4.54076 5.69085 4.69973 5.80806 4.81694C5.92527 4.93415 6.08424 5 6.25 5C6.41576 5 6.57473 4.93415 6.69194 4.81694C6.80915 4.69973 6.875 4.54076 6.875 4.375V3.75H13.125V4.375C13.125 4.54076 13.1908 4.69973 13.3081 4.81694C13.4253 4.93415 13.5842 5 13.75 5C13.9158 5 14.0747 4.93415 14.1919 4.81694C14.3092 4.69973 14.375 4.54076 14.375 4.375V3.75H16.25V6.25H3.75V3.75H5.625ZM16.25 16.25H3.75V7.5H16.25V16.25Z"-->
<!--                                fill="#B1B1B1"-->
<!--                            />-->
<!--                        </svg>-->
<!--                    </span>-->
<!--                    <span class="btn-text">-->
<!--                        Select date-->
<!--                    </span>-->
<!--                    <span class="content-drop-down">-->
<!--                        {{-->
<!--                            formSearch.start_date || formSearch.end_date-->
<!--                                ? formSearch.start_date +-->
<!--                                (!formSearch.start_date && formSearch.end_date-->
<!--                                    ? " <- "-->
<!--                                    : "") +-->
<!--                                (formSearch.start_date && !formSearch.end_date-->
<!--                                    ? " -> "-->
<!--                                    : "") +-->
<!--                                (formSearch.start_date && formSearch.end_date-->
<!--                                    ? "-"-->
<!--                                    : "") +-->
<!--                                formSearch.end_date-->
<!--                                : 'select_date_default'-->
<!--                        }}-->
<!--                    </span>-->
<!--                </div>-->
<!--            </div>-->
            <div class="space"></div>
            <div class="search-button">
                <a href="#" @click="handleResetForm">
                    {{ lang().label.search.clear_form }}
                </a>
                <button type="submit" class="mainButton" @click="handleSearch">
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
                    <p>{{ lang().label.search.search }}</p>
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
                                name="start_date_time"
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
                                name="end_date_time"
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
                            <div
                                id="half_width"
                                name="start_date_time"
                                :class="{ active: selectedStartDate }"
                                @click="handleSelectedStartDate"
                            >
                                <span
                                    v-if="!formSearch.start_date_draft"
                                    value=""
                                    style="font-size: 12px; font-weight: 400"
                                >
                                    本日
                                </span>
                                <span
                                    v-else
                                    :value="formSearch.start_date_draft"
                                    selected
                                    style="font-size: 12px; font-weight: 400"
                                >
                                    {{ formSearch.start_date_draft }}
                                </span>
                            </div>
                        </div>
                        <div class="select" style="margin-left: 8px">
                            <div
                                id="half_width"
                                name="end_date_time"
                                :class="{ active: selectedEndDate }"
                                @click="handleSelectedEndDate"
                            >
                                <span
                                    v-if="!formSearch.end_date_draft"
                                    value=""
                                    style="font-size: 12px; font-weight: 400; opacity: 0"
                                >
                                    上限なし
                                </span>
                                <span
                                    v-else
                                    :value="formSearch.end_date_draft"
                                    selected
                                    style="font-size: 12px; font-weight: 400"
                                >
                                    {{ formSearch.end_date_draft }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <DatePicker
                        :is-select-start-date="selectedStartDate"
                        :is-select-end-date="selectedEndDate"
                        :selected-start-date="formSearch.start_date_draft"
                        :selected-end-date="formSearch.end_date_draft"
                        :clear-select-date="
                            select_date_clear
                        "
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
                            <p>
                               select_date_confirm
                            </p>
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </form>
</template>

<style lang="scss" scoped>
@import "../common";
@import "./search";
</style>
