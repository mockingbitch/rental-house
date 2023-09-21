<script setup>
import { ref, toRef, computed } from "vue";
import InputForm from "../Request/Common/InputForm.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import UlError from "@/Components/UlError.vue";
import CustomSelect from "../Request/Common/CustomSelect.vue";
import moment from "moment";

let arrayYears = ref([]);
const props = defineProps({
    formData: Object,
});
const emits = defineEmits();
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
let newestYear = new Date().getFullYear();
for (let i = newestYear; i >= newestYear - 30; i--) {
    arrayYears.value.push(i);
}
const userCategories = () => {
    let userCategories = []
    for (let i = 0; i < props.formData?.category?.length; i++) {
        userCategories.push({
            id: props.formData?.category[i].category.id,
            label: props.formData?.category[i].category.name_jp
        })
    }
    
    return userCategories
}
const form = useForm({
    id: props.formData.id ? props.formData.id : null,
    year: props.formData.origin_birthday ? moment(props.formData.origin_birthday).format("YYYY") : "",
    month: props.formData.origin_birthday ? moment(props.formData.origin_birthday).format("MM") : "",
    day: props.formData.origin_birthday ? moment(props.formData.origin_birthday).format("DD") : "",
    nickName: props.formData.nick_name ? props.formData.nick_name : "",
    firstName: props.formData.first_name ? props.formData.first_name : "",
    lastName: props.formData.last_name ? props.formData.last_name : "",
    interest: props.formData.category ? userCategories() : [],
});

const formValidateMessage = ref({
    nickNameMessage: "",
    firstNameMessage: "",
    lastNameMessage: "",
    birthdayMessage: "",
    interestMessage: "",
});

const isValid = (data) => {
    for (const key in data) {
        if (data.hasOwnProperty(key) && data[key] !== "") {
            return false;
        }
    }
    return true;
};
const isValidDataForm = computed(() => isValid(formValidateMessage.value));

const handleValidate = (field) => {
    if (field === "nickName") {
        if (form.nickName.trim() === "") {
            formValidateMessage.value.nickNameMessage = "必須項目です";
        } else if (form.nickName.length > 100) {
            formValidateMessage.value.nickNameMessage =
                "Kid Nick nameは100文字以内に入力してください";
        } else {
            formValidateMessage.value.nickNameMessage = "";
        }
    } else if (field === "firstName") {
        if (form.firstName.trim() === "") {
            formValidateMessage.value.firstNameMessage = "必須項目です";
        } else if (form.firstName.length > 100) {
            formValidateMessage.value.firstNameMessage =
                "Kid First nameは100文字以内に入力してください";
        } else {
            formValidateMessage.value.firstNameMessage = "";
        }
    } else if (field === "lastName") {
        if (form.lastName.trim() === "") {
            formValidateMessage.value.lastNameMessage = "必須項目です";
        } else if (form.lastName.length > 100) {
            formValidateMessage.value.lastNameMessage =
                "Kid Last nameは100文字以内に入力してください";
        } else {
            formValidateMessage.value.lastNameMessage = "";
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
    } else {
        if (form.interest.length === 0) {
            formValidateMessage.value.interestMessage = "必須項目です";
        } else {
            formValidateMessage.value.interestMessage = "";
        }
    }
};
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
const updateInterest = (value) => {
    if (value.length === 0) {
        formValidateMessage.value.interestMessage = "必須項目です";
    } else {
        formValidateMessage.value.interestMessage = "";
    }

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

const mappingForm = (data) => {
    return {
        ...data,
        interest: data.interest.map(interesData => interesData.id)
    }
}

const handleSubmit = () => {
    for (const field in form) {
        handleValidate(field);
    } //check validation

    if (isValidDataForm.value) {
        emits("submitFormLearner", mappingForm(form));
    }
    return;
};

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
    <form @submit.prevent="handleSubmit">
        <div class="form__nickName-wrapper">
            <InputForm
                v-model:message="form.nickName"
                :label="'Kid’s Nickname'"
                :placeholder="'Nick name'"
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
                ※ 仮アカウント作成を完了した後は、メールアドレス変更が可能です。
            </div>
        </div>
        <div
            :class="`form__name-wrapper  d-flex flex-column ${
                !!formValidateMessage.firstNameMessage ? 'error' : ''
            }`"
        >
            <label class="form__label">Kid’s Name</label>
            <div class="form__nameInput-wrapper d-flex">
                <div style="flex: 1">
                    <InputForm
                        v-model:message="form.firstName"
                        :placeholder="'子供'"
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
        <div class="learnerForm__item-wrapper">
            <div
                :class="`form__birthday-wrapper tripple-select d-flex flex-row ${
                    !!formValidateMessage.birthdayMessage ? 'error' : ''
                }`"
            >
                <div :class="`form__birthday-item`">
                    <label
                        class="form__label"
                        for="Title"
                        style="margin-bottom: 8px"
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
                <div :class="`form__birthday-item`">
                    <label
                        class="form__label"
                        for="Title"
                        style="margin-bottom: 8px"
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
                <div :class="`form__birthday-item`">
                    <label
                        class="form__label"
                        for="Title"
                        style="margin-bottom: 8px"
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
            :class="`learnerForm__item-wrapper user-infomation-category ${
                !!formValidateMessage.interestMessage ? 'error' : ''
            }`"
        >
            <label class="form__label" for="Title" style="margin-bottom: 8px"
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
                :is-on-boarding="true"
                :is-error="!!formValidateMessage.interestMessage"
                multiple
                :limit-select="5"
                @selectValue="updateInterest"
            />
            <div
                v-if="formValidateMessage.interestMessage"
                class="error__wrapper"
            >
                <UlError :message="formValidateMessage.interestMessage" />
            </div>
        </div>
        <div v-if="!isValidDataForm" class="user-infomation-warning">
            グループエラーメッセージグループエラーメッセージグループエラーメッセージ
        </div>
        <button
            type="submit"
            :class="`form__btn-submit user-infomation-button d-flex justify-content-center align-items-center`"
            @click=""
        >
            修正確定
        </button>
    </form>
</template>

<style lang="scss" scoped>
@import "../Account/_Account.scss";

.learnerForm__item-wrapper {
}

.form__label {
    display: flex;
    align-items: center;
    color: #1b1b1b;
    font-size: 12px;
    font-style: normal;
    font-weight: 400;
    line-height: 160%; /* 19.2px */
    letter-spacing: -0.12px;
}
.note {
    color: #7f7f7f;
    font-size: 10px;
    font-style: normal;
    font-weight: 400;
    line-height: 16px;
    letter-spacing: -0.1px;
    margin-top: 4px;
}
.form__name-wrapper {
    margin-top: 16px;

    .form__nameInput-wrapper {
        gap: 16px;
    }
}
.form__birthday-wrapper {
    gap: 8px;
    justify-content: space-between;
    margin-top: 16px;
}
.form__birthday-item {
    flex: 1;
}
.error__wrapper {
    margin-top: 4px;
}
</style>
