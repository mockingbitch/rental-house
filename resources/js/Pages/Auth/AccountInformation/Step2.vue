<script setup>
import { ref, watch, computed, toRef } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import UlError from '@/Components/Common/UlError.vue';
import PError from '@/Components/Common/PError.vue';
import DatePicker from "@/Components/DatePicker/DatePicker.vue";
import CustomSelect from "@/Components/Select/CustomSelect.vue";

const props = defineProps({
    step: Number,
    user: Object,
    ziggy: Object,
})
const page = usePage();
const emit = defineEmits(['nextStep'])

const form = useForm({
    firstName: props.user?.first_name ?? '',
    firstNameKana: props.user?.first_name_kana ?? '',
    lastName: props.user?.last_name ?? '',
    lastNameKana: props.user?.last_name_kana ?? '',
    nickName: props.user?.nick_name ?? '',
    year: props.user?.year ?? '',
    month: props.user?.month ?? '',
    day: props.user?.day ?? '',
    birthday: props.user?.birthday ?? '',
    country: props.user?.country ?? {},
    city: props.user?.city ?? {},
    params: props.ziggy.query,
})

let isOpenSelectCity = ref(false);
let isOpenSelectCountry = ref(false);
let listCity = ref(form.country?.id ? page.props.cities.filter(city => city.country_id == form.country.id) : []);

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
})


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
})

// update birday when year, month, day changed
watch(form, (newValue) => {
    form.birthday = [newValue.year, newValue.month, newValue.day].join('-');
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

const displayNameKanaForJapanese = computed(() => {
    return form.country.id === 1 ? true : false;
});

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
}

const handleSelectCountry = (country, cities) => {
    listCity.value = cities.filter(city => city.country_id == country.id);
    
    form.country = country;
    isOpenSelectCountry.value = ! isOpenSelectCountry;
}

const handleSelectCity = (city) => {
    form.city = city;
    isOpenSelectCity.value = ! isOpenSelectCity;
}
</script>
<template>
    <transition name="slide-fade">
        <form v-show="step === 2"
            class="form"
            @submit.prevent="submit"
        >
            <!-- Country -->
            <div class="form__wrap-item" :class="{'error': form.errors.country}" >
                <div>
                    <label for="Country">
                        {{ lang().label.information.account_info.country }}
                        <i class="with-tooltip" :data-tooltip-content="lang().label.information.account_info.country_tooltip" >
                            <img src="img/icon/Question.svg" alt="Question">
                        </i>
                    </label>
                </div>
                <div class="select-btn"
                    :class="{ 'open': isOpenSelectCountry === true }"
                    @click="isOpenSelectCountry = ! isOpenSelectCountry"
                >
                    <span class="btn-text">{{ form.country.name_jp ?? lang().label.information.account_info.country }}</span>
                    <span class="arrow-dwn">
                        <i><img src="img/icon/CaretDown.svg" alt=""></i>
                    </span>
                </div>
                <UlError :message="form.errors.country" />

                <ul class="list-items">
                    <li class="item"
                        :class="{checked: form.country.id === country.id, 'checked-items': form.country.id === country.id}"
                        v-for="country in $page.props.countries"
                        @click="handleSelectCountry(country, $page.props.cities)">
                        <span class="item-text">{{ country['name_' + $page.props.locale] }}</span>
                    </li>
                </ul>
            </div>
            
            <!-- City -->
            <div class="form__wrap-item" :class="{'error': form.errors.city}" >
                <div>
                    <label for="City">
                        {{ lang().label.information.account_info.city }}
                        <i class="with-tooltip" :data-tooltip-content="lang().label.information.account_info.city_tooltip">
                            <img src="img/icon/Question.svg" alt="Question">
                        </i>
                    </label>
                </div>
                <div class="select-btn"
                    :class="{ 'open': isOpenSelectCity === true }"
                    @click="isOpenSelectCity = ! isOpenSelectCity"
                >
                    <span class="btn-text">{{ form.city.name_jp ?? lang().label.information.account_info.city }}</span>
                    <span class="arrow-dwn">
                        <i><img src="img/icon/CaretDown.svg" alt=""></i>
                    </span>
                </div>
                <UlError :message="form.errors.city" />

                <ul class="list-items">
                    <li class="item"
                        :class="{checked: form.city.id === city.id, 'checked-items': form.city.id === city.id }"
                        v-for="city in listCity"
                        @click="handleSelectCity(city)">
                        <span class="item-text">{{ city.name_jp }}</span>
                    </li>
                </ul>
            </div>
            
            <!-- Adult nickname -->
            <div class="form__wrap-item" :class="{'error': form.errors.nickName}">
                <label for="nickname">{{ lang().label.information.account_info.adult_nick_name }}</label>
                <div class="inputWrap">
                    <input type="text" v-model="form.nickName" name="nickName" placeholder="Nickname">
                    <UlError :message="form.errors.nickName" />
                </div>
                <ul class="note">
                    <li>※ {{ lang().label.information.account_info.note_nick_name }}</li>
                </ul>
            </div>

            <!-- First name + Last name -->
            <div class="form__wrap-item twoItem">
                <div :class="{'error': form.errors.firstName}">
                    <label for="firstName">{{ lang().label.information.account_info.adult_first_name }}</label>
                    <div class="inputWrap">
                        <input type="text" v-model="form.firstName" name="firstName" placeholder="name">
                        <UlError :message="form.errors.firstName" />
                    </div>
                </div>
                <div :class="{'error': form.errors.lastName}">
                    <label for="lastName">{{ lang().label.information.account_info.adult_last_name }}</label>
                    <div class="inputWrap">
                        <input type="text" v-model="form.lastName" name="lastName" placeholder="name">
                        <UlError :message="form.errors.lastName" />
                    </div>
                </div>
            </div>

            <!-- First name kana + Last name kana -->
            <div class="form__wrap-item twoItem" v-if="displayNameKanaForJapanese">
                <div :class="{'error': form.errors.firstNameKana}">
                    <label for="firstNameKana">{{ lang().label.information.account_info.adult_first_name_kana }}</label>
                    <div class="inputWrap">
                        <input type="text" v-model="form.firstNameKana" name="firstNameKana" placeholder="name">
                        <UlError :message="form.errors.firstNameKana" />
                    </div>
                </div>
                <div :class="{'error': form.errors.lastNameKana}">
                    <label for="lastNameKana">{{ lang().label.information.account_info.adult_last_name_kana }}</label>
                    <div class="inputWrap">
                        <input type="text" v-model="form.lastNameKana" name="lastNameKana" placeholder="name">
                        <UlError :message="form.errors?.lastNameKana" />
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
@import "./_information.scss";
.error__wrapper {
    .errorMsg2 {
        font-size: 10px;
        background-color: transparent;
        padding: 0px;
    }
}
.form-wrap-tripple {
    margin-bottom: 5px;
}
</style>