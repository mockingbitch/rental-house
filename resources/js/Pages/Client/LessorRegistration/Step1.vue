<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, watch, computed, toRef } from "vue";
import Layout from "@/Layouts/Layout.vue";
// import ChildVidPreview from "@/Components/ChildVidPreview/ChildVidPreview.vue";
import ButtonCommon from "@/Components/Button/ButtonCommon.vue";
import UlError from "@/Components/Common/UlError.vue";
import PError from '@/Components/Common/PError.vue';
import ArraySelect from "@/Components/Select/ArraySelect.vue";
import CustomSelect from "@/Components/Select/CustomSelect.vue";
import Breadcrumb from "@/Components/Breadcrumb/Breadcrumb.vue";

const breadcrumbItems = [
    { text: "Dashboard", isLink: true },
    { text: usePage().props.language.original.label.onboarding.label.setting_account, isLink: false },
];
const props = defineProps({
    cities: Array,
    countries: Array,
    dataStep1: Object,
    user: Object,
});
const emits = defineEmits();
let phoneCodes = ["JP +81", "VN +84"];
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
let newestYear = new Date().getFullYear();
for (let i = newestYear; i >= newestYear - 100; i--) {
    arrayYears.value.push(i);
}
let isActiveSubmit = ref(false);
const jobs = [
    {
        id: 1,
        name_jp: "公務員",
    },
    {
        id: 2,
        name_jp: "経営者・役員　",
    },
    {
        id: 3,
        name_jp: "会社員",
    },
    {
        id: 4,
        name_jp: "自営業",
    },
    {
        id: 5,
        name_jp: "専業主婦",
    },
    {
        id: 6,
        name_jp: "パート・アルバイト",
    },
    {
        id: 7,
        name_jp: "学生",
    },
    {
        id: 8,
        name_jp: "その他",
    },
];
const salaries = [
    {
        id: 1,
        name_jp: "100万円以下",
    },
    {
        id: 2,
        name_jp: "100万円～195万以下",
    },
    {
        id: 3,
        name_jp: "195万円～330万円以下",
    },
    {
        id: 4,
        name_jp: "330万円～695万円以下",
    },
    {
        id: 5,
        name_jp: "695万円～900万円以下",
    },
    {
        id: 6,
        name_jp: "900万円～1800万円以下",
    },
    {
        id: 7,
        name_jp: "1800万円～4000万円以下",
    },
    {
        id: 8,
        name_jp: "4000万円超",
    },
];

const form = useForm({
    uploadImageValidate: "",
    childVidPreview: props.dataStep1?.childVidPreview || "",
    childVidName: props.dataStep1?.childVidName || "",
    short_video_for_learner_thumbnail:
        props.dataStep1?.short_video_for_learner_thumbnail || "",
    short_video_for_learner: props.dataStep1?.short_video_for_learner || "",
    profile_image: props.dataStep1?.profile_image || "",
    profile_image_preview: props.dataStep1?.profile_image_preview || "",
    first_name: props.dataStep1?.first_name ?? (props.user?.first_name ?? ""),
    first_name_kana: props.dataStep1?.first_name_kana ?? (props.user?.first_name_kana ?? ""),
    last_name: props.dataStep1?.last_name ?? (props.user?.last_name ?? ""),
    last_name_kana: props.dataStep1?.last_name_kana ?? (props.user?.last_name_kana ?? ""),
    country_id: props.dataStep1?.country_id ?? (props.user?.country_id ?? ""),
    city_id: props.dataStep1?.city_id ?? (props.user?.city_id ?? ""),
    year: props.dataStep1?.year ?? (props.user?.year ?? ""),
    month: props.dataStep1?.month ?? (props.user?.month ?? ""),
    day: props.dataStep1?.day ?? (props.user?.day ?? ""),
    birthday: [
        props.dataStep1?.year ?? (props.user?.year ?? ""),
        props.dataStep1?.month ?? (props.user?.month ?? ""),
        props.dataStep1?.day ?? (props.user?.day ?? ""),
    ].join('-'),
    email: props.dataStep1?.email ?? (props.user?.email ?? ""),
    country_code: props.dataStep1?.country_code || "",
    phone: props.dataStep1?.phone || "",
    job: props.dataStep1?.job || null,
    salary: props.dataStep1?.salary || null,
    headline: props.dataStep1?.headline || "",
    about: props.dataStep1?.about || "",
});

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

const handleUploadImage = () => {
    document.getElementById("fileUpload").click();
};

const handleOnchangeProfileImage = (e) => {
    const file = e.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
        var allowedExtensions = /(\.jpeg|\.png|\.jpg|\.gif|\.bmp)$/i;

        if (!allowedExtensions.exec(file.name)) {
            form.uploadImageValidate =
                "ファイル形式が正しくありません。JPEG、JPG、PNG、GIF、BMP形式の画像をアップロードしてください";
        } else {
            form.profile_image_preview = reader.result;
            form.profile_image = e.target.files[0];
            form.uploadImageValidate = "";
        }
    };

    reader.readAsDataURL(file);
};

const handleClearForm = () => {
    form.uploadImageValidate = "";
    form.childVidPreview = "";
    form.childVidName = "";
    form.short_video_for_learner_thumbnail = "";
    form.profile_image_preview = "";
    form.profile_image = "";
    form.first_name = "";
    form.last_name = "";
    form.country_id = "";
    form.city_id = "";
    form.year = "";
    form.month = "";
    form.day = "";
    form.email = "";
    form.country_code = "";
    form.phone = "";
    form.job = null;
    form.salary = null;
    form.headline = "";
    form.about = "";
    form.birthday = "";
    form.first_name_kana = "";
    form.last_name_kana = "";
};

watch(
    form,
    (value) => {
        if (form.country_id !== "") {
            listCity.value = props.cities.filter(
                (c) => c.country_id == form.country_id
            );
        }
        if (
            form.profile_image === "" ||
            form.first_name === "" ||
            form.last_name === "" ||
            (
                form.country_id == 1 &&
                (
                    form.first_name_kana === "" ||
                    form.last_name_kana === ""
                )
            ) ||
            form.country_id === "" ||
            form.city_id === "" ||
            form.year === "" ||
            form.month === "" ||
            form.day === "" ||
            form.country_code === "" ||
            form.phone === "" ||
            form.job === null ||
            form.salary === null ||
            form.headline === "" ||
            form.about === "" || 
            form.short_video_for_learner === "" 
        ) {
            isActiveSubmit.value = false;
        } else {
            isActiveSubmit.value = true;
        }

        form.birthday = [value.year, value.month, value.day].join('-');
    },
    { immediate: true }
);

watch(handleChangeArrDays, (value) => {
    if (form.day > handleChangeArrDays.value) {
        form.day = handleChangeArrDays.value;
    }
});

const handleOnChangeCountry = (e) => {
    form.country_id = e.target.value;
    form.country_code = e.target.value;
};

const updateCountryId = (data) => {
    form.country_id = data;
};

const updateCityId = (data) => {
    form.city_id = data;
};

const updateJob = (data) => {
    form.job = data;
};

const updateSalary = (data) => {
    form.salary = data;
};

const updateBirthDayYear = (data) => {
    form.year = data;
};
const updateMonth = (data) => {
    form.month = data;
};

const updateDays = (data) => {
    form.day = data;
};

const updatePhoneCode = (data) => {
    form.country_code = data;
};

const handleButtonClick = () => {
    form.post(route("onboarding.create.step1"), {
        onFinish: () => {
            if (
                Object.keys(form.errors).length === 0 &&
                form.errors.constructor === Object
            ) {
                emits("back-to-default", form);
            }
        },
        onError: console.log("error"),
    });
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
    handleClearForm();
};
</script>

<template>
    <Layout
        :step="1"
        :title="'test'"
        @handle-click="handleCancel"
    >
        <Breadcrumb
            :items="breadcrumbItems"
            @handleClick="handleBreadcrumbClick"
        />
        <div class="step-container">
            <div
                class="step-container-header d-flex align-items-center justify-content-center"
            >
                <img @click="handleCancel" src="/img/icon/close.svg" alt="" />
                <span class="step-container-header-content">
                    Test
                </span>
            </div>
            <div class="step-container-title d-flex justify-content-center">
                <span>
                    Tests
                </span>
            </div>

            <!-- Profile image -->
            <div class="form__wrap-item">
                <label for="Title">
                    Upload Image
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
                    <span class="required-input">*</span>
                </label>
                <div class="upload-image-container d-flex">
                    <div
                        v-if="
                            !form.profile_image_preview
                            && !form.profile_image
                        "
                        class="display-image"
                    >
                        <svg
                            
                            xmlns="http://www.w3.org/2000/svg"
                            width="90"
                            height="90"
                            viewBox="0 0 90 90"
                            fill="none"
                        >
                            <path
                                d="M45 89.9999C69.8528 89.9999 90 69.8528 90 45C90 20.1472 69.8528 0 45 0C20.1472 0 0 20.1472 0 45C0 69.8528 20.1472 89.9999 45 89.9999Z"
                                fill="#E1EFF2"
                            />
                            <path
                                d="M81.1117 71.8176C76.9149 66.1987 71.4653 61.6362 65.196 58.4927C58.9268 55.3491 52.0108 53.7112 44.9976 53.709C37.9844 53.7068 31.0673 55.3404 24.7961 58.48C18.5249 61.6196 13.0725 66.1787 8.87207 71.7949C13.0511 77.4396 18.4947 82.0265 24.7662 85.1879C31.0378 88.3493 37.9629 89.9971 44.9862 89.9993C52.0095 90.0015 58.9356 88.358 65.2092 85.2006C71.4827 82.0431 76.9292 77.4596 81.1117 71.8176Z"
                                fill="#91C2CB"
                            />
                            <path
                                d="M45 47.9031C54.6205 47.9031 62.4194 40.1042 62.4194 30.4838C62.4194 20.8634 54.6205 13.0645 45 13.0645C35.3796 13.0645 27.5807 20.8634 27.5807 30.4838C27.5807 40.1042 35.3796 47.9031 45 47.9031Z"
                                fill="#91C2CB"
                            />
                        </svg>
                        <img
                            v-if="form.profile_image_preview || form.profile_image"
                            class="profile-image-preview"
                            :src="form.profile_image_preview || form.profile_image"
                            alt=""
                        />
                    </div>
                    <div
                        @click="handleUploadImage"
                        class="button-upload-image d-flex justify-content-center"
                    >
                        <input
                            @change="handleOnchangeProfileImage"
                            id="fileUpload"
                            type="file"
                            hidden
                        />
                        <i
                            :class="{ active: form.profile_image_preview || form.profile_image }"
                            class="button-upload d-flex align-items-center justify-content-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                            >
                                <path
                                    d="M17.5 11.8755V16.2505C17.5 16.582 17.3683 16.9 17.1339 17.1344C16.8995 17.3688 16.5815 17.5005 16.25 17.5005H3.75C3.41848 17.5005 3.10054 17.3688 2.86612 17.1344C2.6317 16.9 2.5 16.582 2.5 16.2505V11.8755C2.5 11.7097 2.56585 11.5508 2.68306 11.4336C2.80027 11.3163 2.95924 11.2505 3.125 11.2505C3.29076 11.2505 3.44973 11.3163 3.56694 11.4336C3.68415 11.5508 3.75 11.7097 3.75 11.8755V16.2505H16.25V11.8755C16.25 11.7097 16.3158 11.5508 16.4331 11.4336C16.5503 11.3163 16.7092 11.2505 16.875 11.2505C17.0408 11.2505 17.1997 11.3163 17.3169 11.4336C17.4342 11.5508 17.5 11.7097 17.5 11.8755ZM7.31719 6.69268L9.375 4.63409V11.8755C9.375 12.0413 9.44085 12.2002 9.55806 12.3174C9.67527 12.4346 9.83424 12.5005 10 12.5005C10.1658 12.5005 10.3247 12.4346 10.4419 12.3174C10.5592 12.2002 10.625 12.0413 10.625 11.8755V4.63409L12.6828 6.69268C12.8001 6.80996 12.9591 6.87584 13.125 6.87584C13.2909 6.87584 13.4499 6.80996 13.5672 6.69268C13.6845 6.5754 13.7503 6.41634 13.7503 6.25049C13.7503 6.08464 13.6845 5.92558 13.5672 5.8083L10.4422 2.6833C10.3841 2.62519 10.3152 2.57909 10.2393 2.54764C10.1635 2.51619 10.0821 2.5 10 2.5C9.91787 2.5 9.83654 2.51619 9.76066 2.54764C9.68479 2.57909 9.61586 2.62519 9.55781 2.6833L6.43281 5.8083C6.31554 5.92558 6.24965 6.08464 6.24965 6.25049C6.24965 6.41634 6.31554 6.5754 6.43281 6.69268C6.55009 6.80996 6.70915 6.87584 6.875 6.87584C7.04085 6.87584 7.19991 6.80996 7.31719 6.69268Z"
                                    :fill="
                                        form.profile_image_preview || form.profile_image
                                            ? '#418997'
                                            : 'white'
                                    "
                                />
                            </svg>
                            {{
                                form.profile_image_preview || form.profile_image
                                    ? "再アップロード"
                                    : 'Tét'
                            }}
                        </i>
                        <UlError :message="form.uploadImageValidate" />
                        <ul class="note">
                            <li>※ (仮)動画の条件、もしくは必須項目など</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- First name + Last name -->
            <div class="form__wrap-item double-input d-flex flex-row">
                <div class="form-wrap-double">
                    <label for="Title">
                        Firstname
                        <span class="required-input">*</span>
                    </label>
                    <input
                        v-model="form.first_name"
                        id="half_width"
                        placeholder="example"
                    />
                    <UlError :message="form.errors.first_name" />
                </div>
                <div class="form-wrap-double">
                    <label for="Title">
                        Lastname
                        <span class="required-input">*</span>
                    </label>
                    <input
                        v-model="form.last_name"
                        id="half_width"
                        placeholder="example"
                    />
                    <UlError :message="form.errors.last_name" />
                </div>
            </div>

            <!-- Country + City -->
            <div
                class="form__wrap-item from-select-input d-flex flex-row"
                style="gap: 8px"
            >
                <div class="from-select-input-selectForm d-flex flex-column">
                    <label for="Title">
                        Province
                        <span class="required-input">*</span>
                    </label>
                    <!-- <ArraySelect
                        :value-selected="
                            props.countries[form.country_id - 1]?.name_jp ||
                            'example'
                        "
                        :options="props.countries"
                        :data-display="'name_jp'"
                        up-side-down-mobile
                        @selectValue="updateCountryId"
                    /> -->
                    <UlError :message="form.errors.country_id" />
                </div>
                <div class="input-form">
                    <label for="Title">
                        District
                        <span class="required-input">*</span>
                    </label>
                    <!-- <ArraySelect
                        :value-selected="
                            props.cities[form.city_id - 1]?.name_jp || 'example'
                        "
                        :options="listCity"
                        :data-display="'name_jp'"
                        up-side-down-mobile
                        @selectValue="updateCityId"
                    /> -->
                    <UlError :message="form.errors.city_id" />
                </div>
            </div>

            <!-- Year + month + day -->
            <div class="form__wrap-item">
                <div class="tripple-select d-flex flex-row">
                    <div class="form-wrap-tripple">
                        <label for="Title">
                            Birth Year
                            <span class="required-input">*</span>
                        </label>
                        <CustomSelect
                            :value-selected="form.year"
                            :options="arrayYears"
                            :place-holder="'YYYY'"
                            up-side-down-mobile
                            :isOnBoarding="true"
                            @selectValue="updateBirthDayYear"
                        />
                        <UlError :message="form.errors.year" />
                    </div>
                    <div class="form-wrap-tripple">
                        <label for="Title">
                            Birth Month
                            <span class="required-input">*</span>
                        </label>
                        <CustomSelect
                            :value-selected="form.month"
                            :options="month"
                            :place-holder="'MM'"
                            up-side-down-mobile
                            :isOnBoarding="true"
                            @selectValue="updateMonth"
                        />
                        <UlError :message="form.errors.month" />
                    </div>
                    <div class="form-wrap-tripple">
                        <label for="Title">
                            Birth Day
                            <span class="required-input">*</span>
                        </label>
                        <CustomSelect
                            :value-selected="form.day"
                            :options="handleChangeArrDays"
                            :place-holder="'DD'"
                            up-side-down-mobile
                            :isOnBoarding="true"
                            @selectValue="updateDays"
                        />
                        <UlError :message="form.errors.day" />
                    </div>
                </div>
                <div
                    v-if="form.errors.birthday"
                    class="error__wrapper"
                >
                    <PError :message="form.errors.birthday" />
                </div>
            </div>
            

            <!-- Email -->
            <div class="form__wrap-item">
                <label for="Title">
                    Email
                </label>
                <input v-model="form.email" placeholder="example@example.com" disabled/>
                <UlError :message="form.errors.email" />
            </div>

            <!-- Phone -->
            <div class="form__wrap-item from-select-input">
                <label for="Title">
                    Phone number
                    <span class="required-input">*</span>
                </label>
                <div class="from-select-input-select d-flex">
                    <input
                        v-model="form.phone"
                        placeholder="example"
                        style="flex: 1"
                        type="number"
                    />
                </div>
                <ul class="video-note">
                    <li>※ ヒントヒントヒントヒントヒント</li>
                    <li>注意事項注意事項注意事項注意事項</li>
                </ul>
                <UlError :message="form.errors.phone" />
            </div>

            <!-- Abbout me -->
            <div class="form__wrap-item">
                <label for="Title">
                    About me
                    <span class="required-input">*</span>
                </label>
                <textarea
                    v-model="form.about"
                    placeholder="example"
                    class="text-area-form"
                />
                <UlError :message="form.errors.about" />
            </div>
            <div></div>
            <div class="button-container">
                <div class="create__request-button">
                    <div class="lineFull"></div>
                    <ButtonCommon
                        @click="handleCancel"
                        :label="lang().label.onboarding.button.cancel"
                        :submit-button="false"
                        class="create__request-button-left"
                    />
                    <ButtonCommon
                        v-if="isActiveSubmit"
                        :label="'申請する'"
                        :submit-button="true"
                        class="create__request-button-right"
                        @click="handleButtonClick"
                    />
                    <ButtonCommon
                        v-if="!isActiveSubmit"
                        :label="'Submit'"
                        :submit-button="true"
                        class="create__request-button-right btn_disabled"
                    />
                </div>
            </div>
        </div>
    </Layout>
</template>

<style lang='scss' scoped>
@import './common';
@import './step1';
</style>
