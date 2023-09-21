<script setup>
import { ref, toRef, computed, defineProps, watch } from "vue";
import InputForm from "../Request/Common/InputForm.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import UlError from "@/Components/UlError.vue";
import CustomSelect from "../Request/Common/CustomSelect.vue";
import SubHeader from "../Common/SubHeader.vue";
import ArraySelect from "@/Components/BecomeTeacher/Common/ArraySelect.vue";
import moment from "moment";

const emits = defineEmits();

const props = defineProps({
    cities: Array,
    countries: Array,
    account: Object,
});
let listCity = ref(props.cities);

let arrayYears = ref([]);
const month = ref([
    "01",
    "02",
    "03",
    "04",
    "05",
    "06",
    "07",
    "08",
    "09",
    "10",
    "11",
    "12",
]);
const katakanaRegex = /^[\u30A0-\u30FF\u31F0-\u31FF]+$/;

let newestYear = new Date().getFullYear();
for (let i = newestYear; i >= newestYear - 100; i--) {
    arrayYears.value.push(i);
}
const userCategories = () => {
    let userCategories = []
    for (let i = 0; i < props.account?.category?.length; i++) {
        userCategories.push({
            id: props.account?.category[i].category.id,
            label: props.account?.category[i].category.name_jp
        })
    }
    
    return userCategories
}
const form = useForm({
    id: props.account.id ? props.account.id : "",
    email: props.account.email ? props.account.email : "",
    country: props.account.country ? props.account.country.id : "",
    city: props.account.city ? props.account.city.id : "",
    nickName: props.account.nick_name ? props.account.nick_name : "",
    firstName: props.account.first_name ? props.account.first_name : "",
    lastName: props.account.last_name ? props.account.last_name : "",
    firstNameKatakana: props.account.first_name_kana ? props.account.first_name_kana : "",
    lastNameKatakana: props.account.last_name_kana ? props.account.last_name_kana : "",
    year: props.account.birthday ? moment(props.account.birthday).format('YYYY') : "",
    month: props.account.birthday ? moment(props.account.birthday).format('MM') : "",
    day: props.account.birthday ? moment(props.account.birthday).format('DD') : "",
    interest: props.account.category ? userCategories() : [],
});

const formValidateMessage = ref({
    countryMessage: "",
    cityMessage: "",
    nickNameMessage: "",
    firstNameMessage: "",
    lastNameMessage: "",
    firstNameKatakanaMessage: "",
    lastNameKatakanaMessage: "",
    birthdayMessage: "",
});

// Check validate
const isValid = (data) => {
    for (const key in data) {
        if (data.hasOwnProperty(key) && data[key] !== "") {
            return false;
        }
    }
    return true;
};
const isValidDataForm = computed(() => isValid(formValidateMessage.value));

// Function handleValidate
const handleValidate = (field) => {
    if (field === "country") {
        if (form.country === "") {
            formValidateMessage.value.countryMessage = "必須項目です";
        } else {
            formValidateMessage.value.countryMessage = "";
        }
    } else if (field === "city") {
        if (form.city === "") {
            formValidateMessage.value.cityMessage = "必須項目です";
        } else {
            formValidateMessage.value.cityMessage = "";
        }
    } else if (field == "nickName") {
        if (form.nickName.trim() === "") {
            formValidateMessage.value.nickNameMessage = "必須項目です";
        } else if (form.nickName.length > 100) {
            formValidateMessage.value.nickNameMessage =
                "Adult Nicknameは100文字以内に入力してください";
        } else {
            formValidateMessage.value.nickNameMessage = "";
        }
    } else if (field == "firstName") {
        if (form.firstName.trim() === "") {
            formValidateMessage.value.firstNameMessage = "必須項目です";
        } else if (form.firstName.length > 100) {
            formValidateMessage.value.firstNameMessage =
                "性は100文字以内に入力してください";
        } else {
            formValidateMessage.value.firstNameMessage = "";
        }
    } else if (field == "lastName") {
        if (form.lastName.trim() === "") {
            formValidateMessage.value.lastNameMessage = "必須項目です";
        } else if (form.lastName.length > 100) {
            formValidateMessage.value.lastNameMessage =
                "名は100文字以内に入力してください";
        } else {
            formValidateMessage.value.lastNameMessage = "";
        }
    } else if (field == "firstNameKatakana") {
        if (form.country == '1') {
            if (form.firstNameKatakana.trim() === "") {
                formValidateMessage.value.firstNameKatakanaMessage = "必須項目です";
            } else if (form.firstNameKatakana.length > 100) {
                formValidateMessage.value.firstNameKatakanaMessage =
                    "性（フリガナ）は100文字以内に入力してください";
            } else if (!katakanaRegex.test(form.firstNameKatakana)) {
                formValidateMessage.value.firstNameKatakanaMessage =
                    "性（フリガナ）は全角カタカナで入力してください";
            } else {
                formValidateMessage.value.firstNameKatakanaMessage = "";
            }
        } else {
            formValidateMessage.value.firstNameKatakanaMessage = "";
        }
    } else if (field == "lastNameKatakana") {
        if (form.country == '1') {
            if (form.lastNameKatakana.trim() === "") {
                formValidateMessage.value.lastNameKatakanaMessage = "必須項目です";
            } else if (form.lastNameKatakana.length > 100) {
                formValidateMessage.value.lastNameKatakanaMessage =
                    "名（フリガナ）は100文字以内に入力してください";
            } else if (!katakanaRegex.test(form.lastNameKatakana)) {
                formValidateMessage.value.lastNameKatakanaMessage =
                    "名（フリガナ）は全角カタカナで入力してください";
            } else {
                formValidateMessage.value.lastNameKatakanaMessage = "";
            }
        } else {
            formValidateMessage.value.lastNameKatakanaMessage = "";
        }
    } else if (field === "year" || field === "month" || field === "day") {
        if (!form.day || !form.month || !form.year) {
            formValidateMessage.value.birthdayMessage = "必須項目です";
        } else {
            const birthday =
                form.year && form.month && form.day
                    ? moment(
                          `${form.year}/${form.month}/${form.day}`,
                          "YYYY/MM/DD"
                      )
                    : "";
            const inFuture = birthday ? birthday.isAfter(moment(), "day") : "";

            if (inFuture) {
                formValidateMessage.value.birthdayMessage =
                    "Birthdayは当日より過去日付に入力してください";
            } else {
                formValidateMessage.value.birthdayMessage = "";
            }
        }
    }
};

// Function handle select box
const updateCountry = (value) => {
    form.country = value;

    if (value === "") {
        formValidateMessage.value.countryMessage = "必須項目です";
    } else {
        formValidateMessage.value.countryMessage = "";
    }
};
const updateCity = (value) => {
    form.city = value;

    if (value === "") {
        formValidateMessage.value.cityMessage = "必須項目です";
    } else {
        formValidateMessage.value.cityMessage = "";
    }
};
const updateInterest = (value) => {
    form.interest = value;
};
const updateBirthday = (value, index, field) => {
    form[field] = value;

    if (value === "") {
        formValidateMessage.value.birthdayMessage = "必須項目です";
    } else {
        const birthday =
            form.year && form.month && form.day
                ? moment(`${form.year}/${form.month}/${form.day}`, "YYYY/MM/DD")
                : "";
        const inFuture = birthday ? birthday.isAfter(moment(), "day") : "";

        if (inFuture) {
            formValidateMessage.value.birthdayMessage =
                "Birthdayは当日より過去日付に入力してください";
        } else {
            formValidateMessage.value.birthdayMessage = "";
        }
    }
};

//
const handleChangeArrDays = computed(() => {
    let month = toRef(form.month);
    let year = toRef(form.year);
    let isLeapYear =
        (year.value % 4 === 0 && year.value % 100 !== 0) ||
        year.value % 400 === 0;
    if (
        month.value === "01" ||
        month.value === "03" ||
        month.value === "05" ||
        month.value === "07" ||
        month.value === "08" ||
        month.value === "10" ||
        month.value === "12"
    ) {
        return 31;
    } else if (
        month.value === "04" ||
        month.value === "06" ||
        month.value === "09" ||
        month.value === "11"
    ) {
        return 30;
    } else if (month.value === "02") {
        return isLeapYear ? 29 : 28;
    } else {
        return 30;
    }
});

const mappingForm = (data) => {
    return {
        ...data,
        interest: data.interest.map(interesData => interesData.id)
    }
}

const handleSubmit = () => {
    for (const field in form) {
        handleValidate(field);
    }
    if (isValidDataForm.value) {
        emits("submitFormParent", mappingForm(form));
    }
    return;
};

const handleBackToDetail = () => {
    emits("backToDetail");
};

watch(
    form,
    (value) => {
        if (form.country_id !== "") {
            listCity.value = props.cities.filter(
                (c) => c.country_id == form.country
            );
        }
    },
    { immediate: true }
);

const categoriesArray = () => {
    let categoriesArray = []
    for (let i = 0; i < usePage().props.categories.length; i++) {
        const data = {
            id: usePage().props.categories[i].id,
            label: usePage().props.categories[i].name_jp,
        }
        categoriesArray.push(data)
    }
    return categoriesArray
}
</script>
<template>
    <div>
        <SubHeader
            :label="'Parent Information 設定'"
            is-close
            @close="handleBackToDetail"
        />
        <form
            class="user-infomation create__request-container step-container d-flex flex-column"
            @submit.prevent="handleSubmit"
        >
            <div class="user-infomation-title">Parent Information</div>
            <div
                :class="`form__wrap-item user-infomation-category ${
                    formValidateMessage.countryMessage ? 'error' : ''
                }`"
                style="margin-top: 0"
            >
                <label class="label" for="Title" style="height: 19px"
                    >Residential Country
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
                        />
                    </svg>
                </label>
                <ArraySelect
                    :value-selected="
                        props.countries[form.country - 1]?.name_jp || 'example'
                    "
                    :options="props.countries"
                    :data-display="'name_jp'"
                    :is-on-boarding="true"
                    :is-error="!!formValidateMessage.countryMessage"
                    @selectValue="updateCountry"
                />
                <div
                    v-if="formValidateMessage.countryMessage"
                    class="error__wrapper"
                >
                    <UlError :message="formValidateMessage.countryMessage" />
                    <div class="note">
                        <ul>
                            <li>※ ヒントヒントヒントヒントヒント</li>
                            <li>※ 注意事項注意事項注意事項注意事項</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div
                :class="`form__wrap-item user-infomation-category ${
                    error ? 'error' : ''
                }`"
            >
                <label for="Title" style="line-height: 100%; padding-bottom: 0"
                    >Redifential City
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
                        />
                    </svg>
                </label>
                <ArraySelect
                    :value-selected="
                        props.cities[form.city - 1]?.name_jp || 'example'
                    "
                    :options="listCity"
                    :data-display="'name_jp'"
                    :is-on-boarding="true"
                    :is-error="!!formValidateMessage.cityMessage"
                    @selectValue="updateCity"
                />
                <div
                    v-if="formValidateMessage.cityMessage"
                    class="error__wrapper"
                >
                    <UlError :message="formValidateMessage.cityMessage" />
                </div>
            </div>
            <div style="margin-top: 16px">
                <InputForm
                    v-model:message="form.nickName"
                    :label="'Adult Nickname'"
                    :placeholder="'Adult Nickname'"
                    name="nickName"
                    :is-error="!!formValidateMessage.nickNameMessage"
                    @onBlur="handleValidate"
                />
                <div
                    v-if="formValidateMessage.nickNameMessage"
                    class="error__wrapper"
                >
                    <UlError :message="formValidateMessage.nickNameMessage" />
                </div>
                <div class="note">
                    ※
                    仮アカウント作成を完了した後は、メールアドレス変更が可能です。
                </div>
            </div>
            <div class="double-input-form d-flex flex-column">
                <div class="double-input-form-input d-flex">
                    <div style="flex: 1">
                        <InputForm
                            v-model:message="form.firstName"
                            :label="'性'"
                            :placeholder="'金'"
                            name="firstName"
                            :is-error="!!formValidateMessage.firstNameMessage"
                            @onBlur="handleValidate"
                        />
                        <div
                            v-if="formValidateMessage.firstNameMessage"
                            class="error__wrapper"
                        >
                            <UlError
                                :message="formValidateMessage.firstNameMessage"
                            />
                        </div>
                    </div>
                    <div style="flex: 1">
                        <InputForm
                            v-model:message="form.lastName"
                            :label="'名'"
                            :placeholder="'太郎'"
                            name="lastName"
                            :is-error="!!formValidateMessage.lastNameMessage"
                            @onBlur="handleValidate"
                        />
                        <div
                            v-if="formValidateMessage.lastNameMessage"
                            class="error__wrapper"
                        >
                            <UlError
                                :message="formValidateMessage.lastNameMessage"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="double-input-form d-flex flex-column">
                <div class="double-input-form-input d-flex" v-if="form.country == 1">
                    <div style="flex: 1">
                        <InputForm
                            v-model:message="form.firstNameKatakana"
                            :label="'性（フリガナ）'"
                            :placeholder="'キム'"
                            name="firstNameKatakana"
                            :is-error="
                                !!formValidateMessage.firstNameKatakanaMessage
                            "
                            @onBlur="handleValidate"
                        />
                        <div
                            v-if="formValidateMessage.firstNameKatakanaMessage"
                            class="error__wrapper"
                        >
                            <UlError
                                :message="
                                    formValidateMessage.firstNameKatakanaMessage
                                "
                            />
                        </div>
                    </div>
                    <div style="flex: 1">
                        <InputForm
                            v-model:message="form.lastNameKatakana"
                            :label="'名（フリガナ）'"
                            :placeholder="'タロウ'"
                            name="lastNameKatakana"
                            :is-error="
                                !!formValidateMessage.lastNameKatakanaMessage
                            "
                            @onBlur="handleValidate"
                        />
                        <div
                            v-if="formValidateMessage.lastNameKatakanaMessage"
                            class="error__wrapper"
                        >
                            <UlError
                                :message="
                                    formValidateMessage.lastNameKatakanaMessage
                                "
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 16px">
                <InputForm
                    v-model:message="form.email"
                    :label="'email'"
                    :placeholder="'email'"
                    disable
                />
            </div>
            <div class="form__wrap-item">
                <div class="tripple-select d-flex flex-row">
                    <div class="form-wrap-tripple">
                        <label
                            for="Title"
                            style="line-height: 100%; padding-bottom: 0"
                            >Birthday Year
                        </label>
                        <CustomSelect
                            name="year"
                            :value-selected="form.year"
                            :options="arrayYears"
                            :place-holder="'YYYY'"
                            up-side-down-mobile
                            :is-on-boarding="true"
                            :is-error="!!formValidateMessage.birthdayMessage"
                            @selectValue="updateBirthday"
                        />
                    </div>
                    <div class="form-wrap-tripple">
                        <label
                            for="Title"
                            style="line-height: 100%; padding-bottom: 0"
                            >Month
                        </label>
                        <CustomSelect
                            name="month"
                            :value-selected="form.month"
                            :options="month"
                            :place-holder="'MM'"
                            up-side-down-mobile
                            :is-on-boarding="true"
                            :is-error="!!formValidateMessage.birthdayMessage"
                            @selectValue="updateBirthday"
                        />
                    </div>
                    <div class="form-wrap-tripple">
                        <label
                            for="Title"
                            style="line-height: 100%; padding-bottom: 0"
                            >Day
                        </label>
                        <CustomSelect
                            name="day"
                            :value-selected="form.day"
                            :options="handleChangeArrDays"
                            :place-holder="'DD'"
                            up-side-down-mobile
                            :is-on-boarding="true"
                            :is-error="!!formValidateMessage.birthdayMessage"
                            @selectValue="updateBirthday"
                        />
                    </div>
                </div>
                <div
                    v-if="formValidateMessage.birthdayMessage"
                    class="error__wrapper"
                >
                    <UlError :message="formValidateMessage.birthdayMessage" />
                </div>
            </div>
            <div
                :class="`form__wrap-item user-infomation-category ${
                    error ? 'error' : ''
                }`"
            >
                <label for="Title" style="line-height: 100%; padding-bottom: 0"
                    >Interests Category
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
                        />
                    </svg>
                </label>
                <CustomSelect
                    name="interest"
                    :array-value-selected="form.interest"
                    :options="categoriesArray()"
                    :place-holder="'example'"
                    up-side-down-mobile
                    is-on-boarding
                    multiple
                    :limit-select="5"
                    @selectValue="updateInterest"
                />
            </div>
            <div v-if="!isValidDataForm" class="user-infomation-warning">
                グループエラーメッセージグループエラーメッセージグループエラーメッセージ
            </div>
            <button
                type="submit"
                class="form__btn-submit user-infomation-button d-flex justify-content-center align-items-center"
            >
                修正確定
            </button>
        </form>
    </div>
</template>

<style lang="scss" scoped>
@import "../../Pages/Request/User/_createRequest.scss";
@import "../BecomeTeacher/Step";
@import "../Account/_Account.scss";

.label {
    padding-bottom: 0 !important;
    margin-bottom: 6.5px !important;
}
.error__wrapper {
    margin-top: 4px;
}
</style>
