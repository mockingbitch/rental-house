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

const form = useForm({
    first_name: props.user?.first_name ?? '',
    last_name: props.user?.last_name ?? '',
    year: props.user?.year ?? '',
    month: props.user?.month ?? '',
    day: props.user?.day ?? '',
    birthday: props.user?.birthday ?? '',
    params: props.ziggy.query,
    province: props.user?.province ?? {},
    district: props.user?.district ?? {},
    ward: props.user?.ward ?? {},
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
const arrrayDays = computed(() => {
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
        onSuccess: (response) => {
            emit('nextStep', form);
        },
        onError: (e) => {
            console.log(e);
        }
    })
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
</script>
<template>
    <transition name="slide-fade">
        <form v-show="step === 2"
            class="form"
            @submit.prevent="submit"
        >
            <!-- Province -->
            <div class="form__wrap-item" :class="{'error': form.errors.province}" >
                <div>
                    <label for="Province">
                        {{ lang().label.information.account_info.province }}
                        <i class="with-tooltip" :data-tooltip-content="lang().label.information.account_info.province_tooltip" >
                            <img src="img/icon/Question.svg" alt="Question">
                        </i>
                    </label>
                </div>
                <div class="select-btn"
                    :class="{ 'open': isOpenSelectProvince === true }"
                    @click="isOpenSelectProvince = ! isOpenSelectProvince"
                >
                    <span class="btn-text">
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
                    <span class="btn-text">
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
                    <span class="btn-text">
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
                            :options="arrrayDays"
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
            <button class="mainButton bg-green" @click="submitForm">
                <p>{{ lang().label.information.account_info.next }}</p>
                <i class="after"><img src="/img/icon/CaretRight.svg" alt="CaretRight"></i>
            </button>
        </form>
    </transition>
</template>

<style lang="scss" scoped>
@import './_information.scss';
@import './step2';
</style>
