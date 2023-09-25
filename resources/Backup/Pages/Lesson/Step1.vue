<script setup>
import { ref, defineProps, defineEmits, computed } from "vue";
import UlError from "@/Components/UlError.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import CustomSelect from "../../Components/Request/Common/CustomSelect.vue";

const props = defineProps({
    formLesson: Object,
    message: Object,
});
const emits = defineEmits();

const priceEvent = (evt) => {
    if (
        (evt.which != 8 && evt.which != 0 && evt.which < 48) ||
        evt.which > 57
    ) {
        evt.preventDefault();
    }
};

var numberMaxAge = 8;

var numberMaxLearner = 0;
const ageRange = ref([9, 10, 11, 12, 13, 14, 15]);

const dayRange = ref([usePage().props.language.original.label.week_day.Mon, usePage().props.language.original.label.week_day.Tue, usePage().props.language.original.label.week_day.Wed, usePage().props.language.original.label.week_day.Thu, usePage().props.language.original.label.week_day.Fri, usePage().props.language.original.label.week_day.Sat, usePage().props.language.original.label.week_day.Sun]);

const minAgeRange = computed(() => {
    if (props.formLesson.target_age_to) {
        const newAgeRange = ageRange.value.filter(
            (age) => age < props.formLesson.target_age_to
        );
        return newAgeRange;
    }
    return ageRange.value;
});
const maxAgeRange = computed(() => {
    if (props.formLesson.target_age_from) {
        const newAgeRange = ageRange.value.filter(
            (age) => age > props.formLesson.target_age_from
        );
        return newAgeRange;
    }
    return ageRange.value;
});

const learnerRange = ref([
    1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
]);

const minLearnerRange = computed(() => {
    if (props.formLesson.max_learner) {
        const newLearnerRange = learnerRange.value.filter(
            (age) => age < props.formLesson.max_learner
        );
        return newLearnerRange;
    }
    return learnerRange.value;
});
const maxLearnerRange = computed(() => {
    if (props.formLesson.min_learner) {
        const newLearnerRange = learnerRange.value.filter(
            (age) => age > props.formLesson.min_learner
        );
        return newLearnerRange;
    }
    return learnerRange.value;
});

const selectedDays = ref([]);

const toggleDaySelection = (day) => {
    if (selectedDays.value.includes(day)) {
        selectedDays.value = selectedDays.value.filter(
            (selectedDay) => selectedDay !== day
        );
    } else {
        selectedDays.value.push(day);
    }
    props.formLesson.weekday = selectedDays.value;
};

const step1State = useForm({
    minAge: 0,
    maxAge: 0,
    minLearner: 20,
    maxLearner: 20,
    startTimeError: false,
    endTimeError: false,
});

const updateSelect = (value, index, field) => {
    if (field === "target_age_from") {
        numberMaxAge = numberMaxAge + (value - numberMaxAge - 1);
        step1State.maxAge = 16 - value;
    } else if (field === "target_age_to") {
        step1State.minAge = value - 8;
    } else if (field === "min_learner") {
        numberMaxLearner = numberMaxLearner + (value - numberMaxLearner - 1);
        step1State.maxLearner = 21 - value;
    } else {
        step1State.minLearner = value;
    }

    emits("updateDataForm", value, field);
};

const startTime = (value) => {
    const hour = value.split(":")[0];
    const minute = value.split(":")[1];
    var end_hour_count = props.formLesson.lesson_hour * 1 + hour * 1;
    var end_minute_count = props.formLesson.lesson_minute * 1 + minute * 1;

    if (end_minute_count >= 60) {
        var end_minute = end_minute_count - 60;
        var end_hour = end_hour_count + 1;

        if (end_minute < 10) {
            end_minute = "0" + end_minute;
            props.formLesson.end_time = end_hour + ":" + end_minute;
        }
        if (end_hour < 10) {
            end_hour = "0" + end_hour;
            props.formLesson.end_time = end_hour + ":" + end_minute;
        }
        if (end_hour > 23) {
            props.formLesson.end_time = "";
        }
    } else {
        var end_minute = end_minute_count;
        var end_hour = end_hour_count;

        if (end_minute < 10) {
            end_minute = "0" + end_minute;
            props.formLesson.end_time = end_hour + ":" + end_minute;
        }
        if (end_hour < 10) {
            end_hour = "0" + end_hour;
            props.formLesson.end_time = end_hour + ":" + end_minute;
        }
        if (end_hour > 23) {
            props.formLesson.end_time = "";
        }
    }
};

const endTime = (value) => {
    const hour = value.split(":")[0];
    const minute = value.split(":")[1];

    if (minute * 1 < props.formLesson.lesson_minute * 1) {
        var end_minute = minute * 1 + 60 - props.formLesson.lesson_minute * 1;
        if (end_minute < 10) {
            end_minute = "0" + end_minute;
            props.formLesson.start_time = end_hour + ":" + end_minute;
        }
        if (hour * 1 > props.formLesson.lesson_hour) {
            var end_hour = hour * 1 - props.formLesson.lesson_hour * 1 - 1;
            if (end_hour < 10) {
                end_hour = "0" + end_hour;
                props.formLesson.start_time = end_hour + ":" + end_minute;
            }
            props.formLesson.start_time = end_hour + ":" + end_minute;
        } else {
            props.formLesson.start_time = "";
        }
    } else {
        var end_minute = minute * 1 - props.formLesson.lesson_minute * 1;
        if (end_minute < 10) {
            end_minute = "0" + end_minute;
            props.formLesson.start_time = end_hour + ":" + end_minute;
        }
        if (hour * 1 > props.formLesson.lesson_hour) {
            var end_hour = hour * 1 - props.formLesson.lesson_hour * 1;
            if (end_hour < 10) {
                end_hour = "0" + end_hour;
                props.formLesson.start_time = end_hour + ":" + end_minute;
            }
            props.formLesson.start_time = end_hour + ":" + end_minute;
        } else {
            props.formLesson.start_time = "";
        }
    }
};
</script>
<template>
    <div class="form__wrap-item">
        <label for="Title"
            >{{ lang().label.create_lesson.field.lesson_title }}
            <span class="required-input">*</span>
            <span>({{ formLesson.title?.length }}/99)</span>
        </label>
        <input
            v-model="formLesson.title"
            class="fs-12"
            type="text"
            name="title"
            placeholder="Tile"
            maxlength="99"
        />
        <UlError :message="formLesson.errors.title" />
    </div>
    <div class="form__wrap-item">
        <label for="Category"
            >{{ lang().label.create_lesson.field.lesson_category }}
            <span class="required-input">*</span>
        </label>
        <div class="select__container">
            <select
                class="fs-12"
                name="category_id"
                v-model="formLesson.category_id"
            >
                <option
                    :value="category.id"
                    v-for:="category in $page.props.categories"
                >
                    {{ category.name_jp }}
                </option>
            </select>
        </div>
        <UlError :message="formLesson.errors.category_id" />
    </div>
    <div class="form__wrap-item mb-8">
        <label for="Category"
            >{{ lang().label.create_lesson.field.short_description }}
            <span class="required-input">*</span>
            <span>({{ formLesson.description?.length }}/99)</span>
            <svg
                width="16"
                height="16"
                viewBox="0 0 16 16"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 12C7.85167 12 7.70666 11.956 7.58333 11.8736C7.45999 11.7912 7.36386 11.6741 7.30709 11.537C7.25033 11.4 7.23548 11.2492 7.26441 11.1037C7.29335 10.9582 7.36478 10.8246 7.46967 10.7197C7.57456 10.6148 7.7082 10.5434 7.85368 10.5144C7.99917 10.4855 8.14997 10.5003 8.28701 10.5571C8.42406 10.6139 8.54119 10.71 8.6236 10.8333C8.70602 10.9567 8.75 11.1017 8.75 11.25C8.75 11.4489 8.67098 11.6397 8.53033 11.7803C8.38968 11.921 8.19892 12 8 12ZM8.5 8.955V9C8.5 9.13261 8.44732 9.25979 8.35356 9.35355C8.25979 9.44732 8.13261 9.5 8 9.5C7.86739 9.5 7.74022 9.44732 7.64645 9.35355C7.55268 9.25979 7.5 9.13261 7.5 9V8.5C7.5 8.36739 7.55268 8.24021 7.64645 8.14645C7.74022 8.05268 7.86739 8 8 8C8.82688 8 9.5 7.4375 9.5 6.75C9.5 6.0625 8.82688 5.5 8 5.5C7.17313 5.5 6.5 6.0625 6.5 6.75V7C6.5 7.13261 6.44732 7.25979 6.35356 7.35355C6.25979 7.44732 6.13261 7.5 6 7.5C5.86739 7.5 5.74022 7.44732 5.64645 7.35355C5.55268 7.25979 5.5 7.13261 5.5 7V6.75C5.5 5.50938 6.62125 4.5 8 4.5C9.37875 4.5 10.5 5.50938 10.5 6.75C10.5 7.83625 9.64 8.74563 8.5 8.955Z"
                    fill="#B1B1B1"
                />
            </svg>
        </label>
        <textarea
            v-model="formLesson.description"
            class="fs-12"
            placeholder="example"
            name="description"
            rows="5"
            maxlength="99"
        ></textarea>
        <UlError :message="formLesson.errors.description" />
        <ul class="note">
            <li>※ ヒントヒントヒントヒントヒント</li>
            <li>※ 注意事項注意事項注意事項注意事項</li>
        </ul>
    </div>
    <div class="form__wrap-item">
        <label for="Category"
            >{{ lang().label.create_lesson.field.target_age }}
            <span class="required-input">*</span>
        </label>
        <div id="form-wrap-double">
            <div class="half_width">
                <CustomSelect
                    :value-selected="formLesson.target_age_from"
                    name="target_age_from"
                    :options="minAgeRange"
                    @selectValue="updateSelect"
                />
            </div>
            <p class="to-text">to</p>
            <div class="half_width">
                <CustomSelect
                    :value-selected="formLesson.target_age_to"
                    name="target_age_to"
                    :options="maxAgeRange"
                    @selectValue="updateSelect"
                />
            </div>
        </div>
        <div id="form-wrap-double-error">
            <UlError :message="formLesson.errors.target_age_from" />
            <UlError :message="formLesson.errors.target_age_to" />
        </div>
    </div>
    <div class="form__wrap-item">
        <label for="Category"
            >{{ lang().label.create_lesson.field.learners }}
            <span class="required-input">*</span>
        </label>
        <div id="form-wrap-double">
            <div class="half_width">
                <CustomSelect
                    :value-selected="formLesson.min_learner"
                    name="min_learner"
                    :options="minLearnerRange"
                    @selectValue="updateSelect"
                />
            </div>
            <p class="to-text">to</p>
            <div class="half_width">
                <CustomSelect
                    :value-selected="formLesson.max_learner"
                    name="max_learner"
                    :options="maxLearnerRange"
                    @selectValue="updateSelect"
                />
            </div>
        </div>
        <div id="form-wrap-double-error">
            <UlError :message="formLesson.errors.min_learner" />
            <UlError :message="formLesson.errors.max_learner" />
        </div>
    </div>
    <div class="form__wrap-item">
        <label for="Category"
            >{{ lang().label.create_lesson.field.language }}
            <span class="required-input">*</span>
        </label>
        <select
            id="medium-select"
            v-model="formLesson.language"
            name="language"
            class="fs-12"
        >
            <option value="1">Japanese</option>
            <option value="2">English</option>
            <option value="3">Vietnamese</option>
        </select>
        <UlError :message="formLesson.errors.language" />
    </div>
    <div class="form__wrap-item mb-8">
        <label for="Category"
            >{{ lang().label.create_lesson.field.lessons_style }}
            <span class="required-input">*</span>
        </label>
        <select
            id="medium-select"
            v-model="formLesson.style"
            name="style"
            class="fs-12"
        >
            <option value="1">Interview</option>
            <option value="2">Personal</option>
        </select>
        <UlError :message="formLesson.errors.style" />
    </div>
    <div class="form__wrap-item">
        <label for="Category"
            >{{ lang().label.create_lesson.field.schedule }}
            <span class="required-input">*</span>
            <svg
                width="16"
                height="16"
                viewBox="0 0 16 16"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 12C7.85167 12 7.70666 11.956 7.58333 11.8736C7.45999 11.7912 7.36386 11.6741 7.30709 11.537C7.25033 11.4 7.23548 11.2492 7.26441 11.1037C7.29335 10.9582 7.36478 10.8246 7.46967 10.7197C7.57456 10.6148 7.7082 10.5434 7.85368 10.5144C7.99917 10.4855 8.14997 10.5003 8.28701 10.5571C8.42406 10.6139 8.54119 10.71 8.6236 10.8333C8.70602 10.9567 8.75 11.1017 8.75 11.25C8.75 11.4489 8.67098 11.6397 8.53033 11.7803C8.38968 11.921 8.19892 12 8 12ZM8.5 8.955V9C8.5 9.13261 8.44732 9.25979 8.35356 9.35355C8.25979 9.44732 8.13261 9.5 8 9.5C7.86739 9.5 7.74022 9.44732 7.64645 9.35355C7.55268 9.25979 7.5 9.13261 7.5 9V8.5C7.5 8.36739 7.55268 8.24021 7.64645 8.14645C7.74022 8.05268 7.86739 8 8 8C8.82688 8 9.5 7.4375 9.5 6.75C9.5 6.0625 8.82688 5.5 8 5.5C7.17313 5.5 6.5 6.0625 6.5 6.75V7C6.5 7.13261 6.44732 7.25979 6.35356 7.35355C6.25979 7.44732 6.13261 7.5 6 7.5C5.86739 7.5 5.74022 7.44732 5.64645 7.35355C5.55268 7.25979 5.5 7.13261 5.5 7V6.75C5.5 5.50938 6.62125 4.5 8 4.5C9.37875 4.5 10.5 5.50938 10.5 6.75C10.5 7.83625 9.64 8.74563 8.5 8.955Z"
                    fill="#B1B1B1"
                />
            </svg>
        </label>
        <div id="form-wrap-multi">
            <p>{{ lang().label.create_lesson.schedule_note_1 }}</p>
            <select
                id="small-select"
                v-model="formLesson.number_of_meets"
                class="fs-12"
                name="number_of_meets"
            >
                <option :value="meetTime" v-for="meetTime in 7">
                    {{ meetTime }}
                </option>
            </select>
            <p>{{ lang().label.create_lesson.schedule_note_2 }}</p>
        </div>
        <div id="form-wrap-multi" v-if="formLesson.errors.number_of_meets">
            <p class="invisible-text">{{ lang().label.create_lesson.schedule_note_1 }}</p>
            <UlError :message="formLesson.errors.number_of_meets" />
        </div>
        <div id="form-wrap-multi">
            <p>{{ lang().label.create_lesson.schedule_note_3 }}</p>
            <select
                id="small-select"
                v-model="formLesson.lesson_hour"
                class="fs-12"
                name="lesson_hour"
            >
                <option :value="classHour - 1" v-for="classHour in 10">
                    {{ classHour - 1 }}
                </option>
            </select>
            <p>{{ lang().label.create_lesson.schedule_note_4 }}</p>
            <select
                id="small-select"
                v-model="formLesson.lesson_minute"
                class="fs-12"
                name="lesson_minute"
            >
                <option
                    :value="(classMinute - 1) * 5"
                    v-for="classMinute in 12"
                >
                    {{ (classMinute - 1) * 5 }}
                </option>
            </select>
            <p>{{ lang().label.create_lesson.schedule_note_5 }}</p>
        </div>
        <div
            id="form-wrap-multi"
            v-if="
                formLesson.errors.lesson_hour || formLesson.errors.lesson_minute
            "
        >
            <p class="invisible-text">{{ lang().label.create_lesson.schedule_note_3 }}</p>
            <UlError :message="formLesson.errors.lesson_hour" />
            <p class="invisible-text">{{ lang().label.create_lesson.schedule_note_4 }}</p>
            <UlError :message="formLesson.errors.lesson_minute" />
        </div>
        <div id="form-wrap-multi">
            <p>{{ lang().label.create_lesson.schedule_note_6 }}</p>
            <select
                id="small-select"
                v-model="formLesson.total_of_meets"
                class="fs-12"
                name="total_of_meets"
            >
                <option :value="timeCourse" v-for="timeCourse in 12">
                    {{ timeCourse }}
                </option>
            </select>
            <p>{{ lang().label.create_lesson.schedule_note_7 }}</p>
        </div>
        <div id="form-wrap-multi" v-if="formLesson.errors.total_of_meets">
            <p class="invisible-text">{{ lang().label.create_lesson.schedule_note_1 }}</p>
            <UlError :message="formLesson.errors.total_of_meets" />
        </div>
    </div>
    <div class="form__wrap-item">
        <label for="Title">
            <span>曜日指定</span>
        </label>
        <ul class="list-days">
            <li
                v-for="(day, index) in dayRange"
                :key="day"
                class="item"
                :class="{ checked: selectedDays.includes(index + 2) }"
                @click="toggleDaySelection(index + 2)"
            >
                <span class="checkbox">
                    <i
                        v-if="selectedDays.includes(index + 2)"
                        class="fa-solid fa-check check-icon"
                    ></i>
                </span>
                <span class="item-text">{{ day }}</span>
            </li>
        </ul>
        <UlError :message="formLesson.errors.weekday" />
    </div>
    <div class="form__wrap-item mb-8">
        <div id="form-wrap-double">
            <input
                id="half_width"
                v-model="formLesson.start_time"
                type="time"
                @change="startTime(formLesson.start_time)"
            />
            <p>to</p>
            <input
                id="half_width"
                v-model="formLesson.end_time"
                type="time"
                @change="endTime(formLesson.end_time)"
            />
        </div>
        <div id="form-wrap-double-error">
            <UlError :message="formLesson.errors.start_time" />
            <UlError :message="formLesson.errors.end_time" />
        </div>
    </div>
    <div class="form__wrap-item mb-8">
        <label for="Category"
            >{{ lang().label.create_lesson.field.price }}
            <span class="required-input">*</span>
        </label>
        <div id="form-wrap-currency">
            <select name="currency" v-model="formLesson.currency">
                <option value="2">¥ {{ lang().label.create_lesson.field.price_unit }}</option>
                <option value="1">$ Dollar</option>
                <option value="3">VND</option>
            </select>
            <input
                id="lesson_price"
                class="fs-12"
                type="number"
                v-model="formLesson.price"
                name="price"
                @keypress="priceEvent"
            />
        </div>
        <div id="form-wrap-currency">
            <div class="currency-error-message">
                <UlError :message="formLesson.errors.currency" />
            </div>
            <div class="price-error-message">
                <UlError :message="formLesson.errors.price" />
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import "./_lesson.scss";
// CSS for each scoped component
.form__wrap-item input,
select {
    padding: 13.5px 10px !important;
    font-family: "Noto Sans JP";
}
#form-wrap-currency select {
    width: 25%;
}
#form-wrap-currency #lesson_price {
    width: 73%;
}

.half_width {
    flex: 1;
}
.to-text {
    padding: 0 8px !important;
    display: flex;
    align-items: center;
}

.fs-12 {
    font-size: 12px;
    color: #1b1b1b;
    font-weight: 400;
    line-height: 160%; /* 19.2px */
    letter-spacing: -0.12px;
}
</style>
