<script setup>
import { ref, watch, computed, toRef } from 'vue'
import { useForm } from '@inertiajs/vue3'
import UlError from '@/Components/UlError.vue';
import PError from '@/Components/PError.vue';
import DatePickerSignIn from "@/Components/DatePickerSignIn.vue";
import CustomSelect from "@/Components/Request/Common/CustomSelect.vue";

const props = defineProps({
    step: Number,
    ziggy: Object,
    user: Object,
});

const emit = defineEmits(['nextStep']);
let isOpenSelectStyle = ref(false);
let styleRange = ref(['Interview style', 'Personal style']);
let selectedCategory = ref(0);


const form = useForm({
    kids: props.user?.kids.length ? 
        props.user.kids.map((kid) => {
            return {
                db_id: kid.id ?? null,
                nickName: kid.nick_name ?? '',
                firstName: kid.first_name ?? '',
                lastName: kid.last_name ?? '',
                name: kid.first_name && kid.last_name ? kid.first_name + ' ' + kid.last_name : '',
                year: kid.year ?? '',
                month: kid.month ?? '',
                day: kid.day ?? '',
                birthday: kid.year && kid.month && kid.day ? [kid.year, kid.month, kid.day].join('-') : '',
                categories: kid.categories ? kid.categories.map((category) => category.id) : [],
                learningStyle: null,
            }
        })
        :
        [
            {
                db_id: null,
                nickName: '',
                firstName: '',
                lastName: '',
                name: '',
                year: '',
                month: '',
                day: '',
                birthday: '',
                categories: [],
                learningStyle: null,
            }
        ],
    params: props.ziggy.query,
});

let kidsNum = computed(() => {
    return form.kids.length;
});

// generate array year for each kid
const newestYear = new Date().getFullYear();
const arrayYears = computed(() => {
    let result = [];
    for (let j = 0; j < kidsNum.value; j++) {
        let arrayYearsForKidj = [];
        for (let i = newestYear; i >= newestYear - 100; i--) {
            arrayYearsForKidj.push(i);
        };
        result.push(arrayYearsForKidj);
    }

    return result;
});


// generate array month for each kid
const newestMonth = new Date().getMonth() + 1;
const arrayMonths = computed(() => {
    let result = [];
    for (let j = 0; j < kidsNum.value; j++) {
        let arrrayMonthForKidj = [];
        let maxMonthForKidj = form.kids[j].year == newestYear ? newestMonth : 12;
        for (let i = 1; i <= maxMonthForKidj; i++) {
            i < 10 ? arrrayMonthForKidj.push('0' + i) : arrrayMonthForKidj.push('' + i);
        }
        result.push(arrrayMonthForKidj);
    }
    
    return result;
})


// generate array day for each kid
const newestDay = new Date().getDate();
const getNumDayOfMonth = (year, month) => {
    let maxDay = null;
    let isLeapYear =
        (year % 4 === 0 && year % 100 !== 0) ||
        year % 400 === 0;
    if (year == newestYear && month == newestMonth) {
        maxDay = newestDay;
    } else {
        if (['01', '03', '05', '07', '08', '10', '12'].includes(month)) {
            maxDay = 31;
        } else if (['04', '06', '09', '11'].includes(month)) {
            maxDay = 30;
        } else if (month === "02") {
            maxDay = isLeapYear ? 29 : 28;
        } else {
            maxDay = 30;
        }
    }

    return maxDay;
}
const arrrayDays = computed(() => {
    let result = [];
    for (let j = 0; j < kidsNum.value; j++) {
        let arrrayDaysForKidj = [];
        let monthOfKidj = toRef(form.kids[j].month);
        let yearOfKidj = toRef(form.kids[j].year);
        let maxDayForKidj = getNumDayOfMonth(yearOfKidj.value, monthOfKidj.value);
        for (let i = 1; i <= maxDayForKidj; i++) {
            i < 10 ? arrrayDaysForKidj.push('0' + i) : arrrayDaysForKidj.push('' + i);
        }
        result.push(arrrayDaysForKidj);
    }

    return result;
})

// update birday when year, month, day changed
// update name when first name, last name changed
watch(form, (newValue) => {
    for (let j = 0; j < kidsNum.value; j++) {
        form.kids[j].birthday = [newValue.kids[j].year, newValue.kids[j].month, newValue.kids[j].day].join('-');
        form.kids[j].name = form.kids[j].firstName + ' ' + form.kids[j].lastName;
    }
});
const updateBirthDayYear = (data, index) => {
    form.kids[index].year = data;
};
const updateMonth = (data, index) => {
    form.kids[index].month = data;
};

const updateDays = (data, index) => {
    form.kids[index].day = data;
};

const handleSelectStyle = (style, id) => {
    form.kids[id].learningStyle = style;
    isOpenSelectStyle.value = ! isOpenSelectStyle.value;
}

const handleSelectCategories = (category, id) => {
    if (form.kids[id].categories.includes(category)) {
        let index = form.kids[id].categories.indexOf(category);

        if (index > -1) {
            form.kids[id].categories.splice(index, 1);
        }
    } else {
        if (form.kids[id].categories.length < 5) {
            form.kids[id].categories.push(category)
        }
    }
    selectedCategory.value = form.kids[id].categories.length;
}

const submitForm = () => {
    form.post(route('learner.info'), {
        preserveScroll: true,
        onSuccess: (response) => {
            emit('nextStep', form)
        },
        onError: (e) => {
            console.log(e);
        }
    });
}

const handleAddChild = () => {
    form.kids.push({
        db_id: null,
        nickName: '',
        firstName: '',
        lastName: '',
        name: '',
        year: '',
        month: '',
        day: '',
        birthday: '',
        categories: [],
        learningStyle: null,
    });
}

const backToPrevStep = () => {
    emit("prev-step");
};
</script>

<template>
    <transition name="slide-fade">
        <form v-show="step === 3"
            class="form[0]"
            method="post"
            action="#"
            @submit.prevent="next"
        >
            <div class="skip-item">
                <img
                        src="/img/icon/arrownLeft.svg"
                        alt=""
                        @click="backToPrevStep"
                />
                <a href="javascript:void(0)" @click="emit('nextStep', form)" >
                    {{ lang().label.information.learner_info.skip }}
                    <i><img src="img/icon/CaretRightGreenCl.svg" alt="CaretRightGreenCl"></i>
                </a>
            </div>
            <div class="bg-gray mt-4" v-for="(item, index) in form.kids" :key="index" >
                <!-- Kid nickname -->
                <div class="form__wrap-item" :class="{'error': form.errors['kids.'+index+'.nickName']}">
                    <label for="nickname">{{ lang().label.information.learner_info.nickname }}</label>
                    <div class="inputWrap">
                        <input type="text" v-model="form.kids[index].nickName" name="nickName" :placeholder="lang().label.information.learner_info.nickname">
                        <UlError :message="form.errors['kids.'+index+'.nickName']" />
                    </div>
                </div>

                <!-- First name + Last name -->
                <div class="form__wrap-item twoItem">
                    <div :class="{'error': form.errors['kids.'+index+'.firstName'] || form.errors['kids.'+index+'.name']}">
                        <label for="firstName">{{ lang().label.information.learner_info.kid_first_name }}</label>
                        <div class="inputWrap">
                            <input type="text" v-model="form.kids[index].firstName" name="firstName" placeholder="name">
                            <UlError :message="form.errors['kids.'+index+'.firstName']" />
                        </div>
                    </div>
                    <div :class="{'error': form.errors['kids.'+index+'.lastName'] || form.errors['kids.'+index+'.name']}">
                        <label for="lastName">{{ lang().label.information.learner_info.kid_last_name }}</label>
                        <div class="inputWrap">
                            <input type="text" v-model="form.kids[index].lastName" name="lastName" placeholder="name">
                            <UlError :message="form.errors['kids.'+index+'.lastName']" />
                        </div>
                    </div>
                    <UlError :message="form.errors['kids.'+index+'.name']" />
                </div>

                <!-- Birthday year, month, day -->
                <div class="form__wrap-item">
                    <div class="tripple-select d-flex flex-row">
                        <div class="form-wrap-tripple" :class="{'error': form.errors['kids.'+index+'.year']}" >
                            <label for="Title">Birthday Year</label>
                            <CustomSelect
                                :value-selected="form.kids[index].year"
                                :options="arrayYears[index]"
                                :place-holder="'YYYY'"
                                up-side-down-mobile
                                :isOnBoarding="true"
                                @selectValue="(data) => updateBirthDayYear(data, index)"
                            />
                            <UlError :message="form.errors['kids.'+index+'.year']" />
                        </div>
                        <div class="form-wrap-tripple" :class="{'error': form.errors['kids.'+index+'.month']}" >
                            <label for="Title">Month</label>
                            <CustomSelect
                                :value-selected="form.kids[index].month"
                                :options="arrayMonths[index]"
                                :place-holder="'MM'"
                                up-side-down-mobile
                                :isOnBoarding="true"
                                @selectValue="(data) => updateMonth(data, index)"
                            />
                            <UlError :message="form.errors['kids.'+index+'.month']" />
                        </div>
                        <div class="form-wrap-tripple" :class="{'error': form.errors['kids.'+index+'.day']}" >
                            <label for="Title">Day</label>
                            <CustomSelect
                                :value-selected="form.kids[index].day"
                                :options="arrrayDays[index]"
                                :place-holder="'DD'"
                                up-side-down-mobile
                                :isOnBoarding="true"
                                @selectValue="(data) => updateDays(data, index)"
                            />
                            <UlError :message="form.errors['kids.'+index+'.day']" />
                        </div>
                    </div>
                    <div
                        v-if="
                            ! form.errors['kids.'+index+'.year']
                            && ! form.errors['kids.'+index+'.month']
                            && ! form.errors['kids.'+index+'.day']
                            && form.errors['kids.'+index+'.birthday']
                        "
                        class="error__wrapper"
                    >
                        <PError :message="form.errors['kids.'+index+'.birthday']" />
                    </div>
                </div>

                <div class="form__wrap-item">
                    <div>
                        <label for="Email">
                            {{ lang().label.information.learner_info.interest_category }}
                            <i>
                                ({{ selectedCategory }}/5) 
                                <i class="with-tooltip" data-tooltip-content="ヒントやTipが表示されます。">
                                    <img src="img/icon/Question.svg" alt="Question">
                                </i>
                            </i>
                        </label>
                    </div>
                    <UlError :message="form.errors['kids.'+index+'.categories']" />
                    <ul class="intersest-items">
                        <li v-for="category in $page.props.categories"
                            :class="{ active: form.kids[index].categories.includes(category.id) }"
                            @click="handleSelectCategories(category.id, index)"
                            :key="category.id"
                        >
                            <span class="item-text">
                                <i :class="{ active: form.kids[index].categories.includes(category.id) }">
                                    <img src="img/icon/tag.svg" alt="">
                                </i>
                                {{ category.name_jp }}
                            </span>
                        </li>
                    </ul>
                    <UlError :message="form.errors['kids.'+index+'.categories']" />
                </div>
            </div>
            <button type="submit" class="mainButton step-3-btn" @click="handleAddChild">
                <p>
                    <img src="img/icon/Plus.svg" alt="Plus">
                    {{ lang().label.information.learner_info.another_kids }}
                </p>
            </button>
            <button type="submit" class="mainButton step-3-btn bg-green" @click="submitForm">
                <p>{{ lang().label.information.learner_info.complete_register }}</p>
                <i class="after"><img src="img/icon/CaretRight.svg" alt="CaretRight"></i>
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