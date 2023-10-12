<script setup>
import { ref, watch, computed, toRef } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import UlError from '@/Components/Common/UlError.vue';
import PError from '@/Components/Common/PError.vue';
import CustomSelect from "@/Components/Select/CustomSelect.vue";

const props = defineProps({
    step: Number,
    user: Object,
    ziggy: Object,
})
const page = usePage();
const emit = defineEmits(['nextStep'])
console.log(props.user);
const form = useForm({
    avatar_preview: props.user?.avatar_preview ?? '',
    avatar: props.user?.avatar ?? '',
    avatar_validation: '',
    isUploadNewAvatar: false,
    province: props.user?.province ?? {},
    district: props.user?.district ?? {},
    ward: props.user?.ward ?? {},
    first_name: props.user?.first_name ?? '',
    last_name: props.user?.last_name ?? '',
    year: props.user?.year ?? '',
    month: props.user?.month ?? '',
    day: props.user?.day ?? '',
    birthday: props.user?.birthday ?? '',
    params: props.ziggy.query,
    confirm: false,
})

let isOpenSelectDistrict = ref(false);
let isOpenSelectProvince = ref(false);
let isOpenSelectWard = ref(false);
let listDistrict = ref(page.props.districts);
let listWard = ref(page.props.wards);

// update birday when year, month, day changed
watch(form, (newValue) => {
    form.birthday = [newValue.year, newValue.month, newValue.day].join('-');
    if (form.province) {
        listDistrict.value = page.props?.districts?.filter(
            item => item.province_code == form.province.code
            );
    }
    if (form.district) {
        listWard.value = page.props?.wards?.filter(
            item => item.district_code == form.district.code
            );
    }
});

// generate array year
let arrayYears = ref([]);
const newestYear = new Date().getFullYear();
for (let i = newestYear; i >= newestYear - 100; i--) {
    arrayYears.value.push(i);
};
// generate array month
const newestMonth = new Date().getMonth() + 1
const arrayMonths = computed(() => {
    let result = [];
    let maxMonth = form.year == newestYear ? newestMonth : 12;
    for (let i = 1; i <= maxMonth; i++) {
        i < 10 ? result.push('0' + i) : result.push('' + i);
    }

    return result;
});

// generate array day
const newestDay = new Date().getDate();
const arrayDays = computed(() => {
    let month = toRef(form.month);
    let year = toRef(form.year);
    let maxDay = null;
    let result = [];

    let isLeapYear =
        (year.value % 4 === 0 && year.value % 100 !== 0) ||
        year.value % 400 === 0;

    if (year.value == newestYear && month.value == newestMonth) {
        maxDay = newestDay;
    } else {
        if (['01', '03', '05', '07', '08', '10', '12'].includes(month.value)) {
            maxDay = 31;
        } else if (['04', '06', '09', '11'].includes(month.value)) {
            maxDay = 30;
        } else if (month.value === "02") {
            maxDay = isLeapYear ? 29 : 28;
        } else {
            maxDay = 30;
        }
    }

    for (let i = 1; i <= maxDay; i++) {
        i < 10 ? result.push('0' + i) : result.push('' + i);
    }

    return result;
});
const handleUploadAvatar = () => {
    document.getElementById("fileUpload").click();
};
const handleOnchangeAvatar = (e) => {
    const file = e.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
        var allowedExtensions = /(\.jpeg|\.png|\.jpg|\.gif|\.bmp)$/i;

        if (!allowedExtensions.exec(file.name)) {
            form.avatar_validation =
                "File type only accept JPEG、JPG、PNG、GIF、BMP";
        } else {
            form.avatar_preview = reader.result;
            form.avatar = e.target.files[0];
            form.isUploadNewAvatar = true;
            form.avatar_validation = "";
        }
    };

    reader.readAsDataURL(file);
};
const handleSelectProvince = (province) => {
    form.province = province;
    form.district = null;
    form.ward = null;
    isOpenSelectProvince.value = ! isOpenSelectProvince;
};
const handleSelectDistrict = (district) => {
    form.district = district;
    form.ward = null;
    isOpenSelectDistrict.value = ! isOpenSelectDistrict;
};
const handleSelectWard = (ward) => {
    form.ward = ward;
    isOpenSelectWard.value = ! isOpenSelectWard;
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
const submitForm = () => {
    form.post(route('account.info'), {
        preserveScroll: true,
        onFinish: () => {
            if (
                Object.keys(form.errors).length === 0 &&
                form.errors.constructor === Object
            ) {
                emit('nextStep', form);
            }
        },
    })
};
</script>

<template>
    <transition name="slide-fade">
        <form v-show="step === 2"
            class="form"
            @submit.prevent="submit"
        >
            <!-- Profile image -->
            <div class="form__wrap-item">
                <label for="Title">
                    Profile Image
                    <i class="with-tooltip" :data-tooltip-content="lang().label.information.account_info.province_tooltip" >
                        <img src="img/icon/Question.svg" alt="Question">
                    </i>
                    <span class="required-input">*</span>
                </label>
                <div class="upload-image-container">
                    <div class="display-image">
                        <img
                            class="profile-image-preview"
                            v-if="form.avatar_preview || form.avatar"
                            :src="form.avatar_preview || form.avatar"
                            alt=""
                        />
                    </div>
                    <div
                        @click="handleUploadAvatar"
                        class="button-upload-image justify-content-center"
                    >
                        <input
                            @change="handleOnchangeAvatar"
                            id="fileUpload"
                            type="file"
                            hidden
                        />
                        <div
                            class="button-upload align-items-center justify-content-center"
                            :class="{ active: form.avatar_preview || form.avatar }"
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
                                        form.avatar_preview || form.avatar
                                            ? '#5392f9'
                                            : 'white'
                                    "
                                />
                            </svg>
                            {{
                                form.avatar_preview || form.avatar
                                    ? "Upload"
                                    : lang().label.onboarding?.button?.upload_image
                            }}
                        </div>
                    </div>
                    <UlError :message="form.avatar_validation" />
                    <ul class="note">
                        <li>※ Upload your profile image</li>
                    </ul>
                </div>
            </div>

            <!-- Province -->
            <div class="form__wrap-item" :class="{'error': form.errors.province}" >
                <div>
                    <label for="Province">
                        {{ lang().label.information.account_info.province }}
                        <i
                            class="with-tooltip"
                            :data-tooltip-content="lang().label.information.account_info.province_tooltip"
                        >
                            <img src="img/icon/Question.svg" alt="Question">
                        </i>
                    </label>
                </div>
                <div class="select-btn"
                    :class="{ 'open': isOpenSelectProvince === true }"
                    @click="isOpenSelectProvince = ! isOpenSelectProvince"
                >
                    <span :class="{
                            'btn-text': !form.province?.name,
                            'btn-text-active': form.province?.name
                        }"
                    >
                        {{ form.province?.name ?? lang().label.information.account_info.province }}
                    </span>
                    <span class="arrow-dwn">
                        <i><img src="img/icon/CaretDown.svg" alt=""></i>
                    </span>
                </div>
                <UlError :message="form.errors.province" />
                <ul class="list-items">
                    <li class="item"
                        :class="{
                            checked: form.province.code === province.code,
                            'checked-items': form.province.code === province.code
                            }"
                        v-for="province in page.props.provinces"
                        @click="handleSelectProvince(province)">
                        <span class="item-text">{{ province.name }}</span>
                    </li>
                </ul>
            </div>

            <!-- District -->
            <div class="form__wrap-item" :class="{'error': form.errors.district}" >
                <div>
                    <label for="District">
                        {{ lang().label.information.account_info.district }}
                        <i
                            class="with-tooltip"
                            :data-tooltip-content="lang().label.information.account_info.district_tooltip"
                        >
                            <img src="img/icon/Question.svg" alt="Question">
                        </i>
                    </label>
                </div>
                <div class="select-btn"
                    :class="{ 'open': isOpenSelectDistrict === true }"
                    @click="isOpenSelectDistrict = ! isOpenSelectDistrict"
                >
                    <span :class="{
                            'btn-text': !form.district?.name,
                            'btn-text-active': form.district?.name
                        }"
                    >
                        {{ form.district?.name ?? lang().label.information.account_info.district }}
                    </span>
                    <span class="arrow-dwn">
                        <i><img src="img/icon/CaretDown.svg" alt=""></i>
                    </span>
                </div>
                <UlError :message="form.errors.district" />
                <ul class="list-items">
                    <li class="item"
                        :class="{
                            checked: form.district?.code === district.code,
                            'checked-items': form.district?.code === district.code
                            }"
                        v-for="district in listDistrict"
                        @click="handleSelectDistrict(district)">
                        <span class="item-text">{{ district.name }}</span>
                    </li>
                </ul>
            </div>

            <!-- Ward -->
            <div class="form__wrap-item" :class="{'error': form.errors.ward}" >
                <div>
                    <label for="Ward">
                        {{ lang().label.information.account_info.ward }}
                        <i
                            class="with-tooltip"
                            :data-tooltip-content="lang().label.information.account_info.ward_tooltip"
                        >
                            <img src="img/icon/Question.svg" alt="Question">
                        </i>
                    </label>
                </div>
                <div class="select-btn"
                    :class="{ 'open': isOpenSelectWard === true }"
                    @click="isOpenSelectWard = ! isOpenSelectWard"
                >
                    <span :class="{
                            'btn-text': !form.ward?.name,
                            'btn-text-active': form.ward?.name
                        }"
                    >
                        {{ form.ward?.name ?? lang().label.information.account_info.ward }}
                    </span>
                    <span class="arrow-dwn">
                        <i><img src="img/icon/CaretDown.svg" alt=""></i>
                    </span>
                </div>
                <UlError :message="form.errors.ward" />
                <ul class="list-items">
                    <li class="item"
                        :class="{
                            checked: form.ward?.code === ward.code,
                            'checked-items': form.ward?.code === ward.code
                            }"
                        v-for="ward in listWard"
                        @click="handleSelectWard(ward)">
                        <span class="item-text">{{ ward.name }}</span>
                    </li>
                </ul>
            </div>

            <!-- First name + Last name -->
            <div class="form__wrap-item twoItem">
                <div :class="{'error': form.errors.first_name}">
                    <label for="first_name">
                        {{ lang().label.information.account_info.first_name }}
                    </label>
                    <div class="inputWrap">
                        <input
                            type="text"
                            v-model="form.first_name"
                            name="first_name"
                            placeholder="First name"
                        >
                        <UlError :message="form.errors.first_name" />
                    </div>
                </div>
                <div :class="{'error': form.errors.last_name}">
                    <label for="last_name">
                        {{ lang().label.information.account_info.last_name }}
                    </label>
                    <div class="inputWrap">
                        <input
                            type="text"
                            v-model="form.last_name"
                            name="last_name"
                            placeholder="Last name"
                        >
                        <UlError :message="form.errors.last_name" />
                    </div>
                </div>
            </div>

            <!-- Birthday year, month, day -->
            <div class="form__wrap-item">
                <div class="tripple-select d-flex flex-row">
                    <div class="form-wrap-tripple" :class="{'error': form.errors.year}" >
                        <label for="Title">Birthday Year</label>
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
                    <div class="form-wrap-tripple" :class="{'error': form.errors.month}" >
                        <label for="Title">Month</label>
                        <CustomSelect
                            :value-selected="form.month"
                            :options="arrayMonths"
                            :place-holder="'MM'"
                            up-side-down-mobile
                            :isOnBoarding="true"
                            @selectValue="updateMonth"
                        />
                        <UlError :message="form.errors.month" />
                    </div>
                    <div class="form-wrap-tripple" :class="{'error': form.errors.day}" >
                        <label for="Title">Day</label>
                        <CustomSelect
                            :value-selected="form.day"
                            :options="arrayDays"
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
                    <UlError :message="form.errors.birthday" />
                </div>
            </div>
            <PError :message="form.errors.error" />
            <button class="mainButton bg-green" @click="submitForm">
                <p>{{ lang().label.information.account_info.next }}</p>
                <i class="after"><img src="/img/icon/CaretRight.svg" alt="CaretRight"></i>
            </button>
        </form>
    </transition>
</template>

<style lang="scss" scoped>
@import './information';
@import './step2';
</style>
