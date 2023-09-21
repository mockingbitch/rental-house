<script setup>
import Modal from "../../Modal/Modal.vue";
import { ref, computed, watch } from "vue";
import moment from "moment";
import { useForm } from "@inertiajs/vue3";
import TimeRangeSelect from "../../Common/TimeRangeSelect.vue";
import NoResult from "../Common/NoResult.vue";
import BaseCard from "../Common/BaseCard.vue";

const showConfirmFormDeleteMetting = ref(false);
const showAddMeetingForm = ref(false);
const showConfirmFormModalMetting = () => {
    showConfirmFormDeleteMetting.value = true;
};
const closeModalConfirmDeleteMetting = () => {
    showConfirmFormDeleteMetting.value = false;
};
const openAddMeetingForm = () => {
    showAddMeetingForm.value = true;
};
const closeAddMeetingForm = () => {
    showAddMeetingForm.value = false;
    formSchedule.start_time = "";
    formSchedule.end_time = "";
    formSchedule.year = newestYear;
    formSchedule.month = currentMonth;
    formSchedule.day = currentDay;
};

const props = defineProps({
    form: Object,
    lesson: Object,
    totalKidApplied: Object,
    update: Boolean,
});

const dateValidate = ref(true)

const currentDate = new Date();
const currentDay = currentDate.getDate();
const currentMonth = currentDate.getMonth() + 1;
const months = [
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
];
const arrayYears = ref([]);
const newestYear = new Date().getFullYear();
for (let i = newestYear; i < newestYear + 15; i++) {
    arrayYears.value.push(i);
}

const formSchedule = useForm({
    start_time: "",
    end_time: "",
    year: newestYear,
    month: currentMonth,
    day: currentDay,
    repeat: "0",
});

const maxDays = ref(30);
const handleChangeArrDays = (e) => {
    if (e) {
        formSchedule.month = e.target.value;
    }
    let month = formSchedule.month;
    let year = formSchedule.year;

    let isLeapYear = (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0;
    if (
        month === "01" ||
        month === "03" ||
        month === "05" ||
        month === "07" ||
        month === "08" ||
        month === "10" ||
        month === "12"
    ) {
        maxDays.value = 31;
    } else if (
        month === "04" ||
        month === "06" ||
        month === "09" ||
        month === "11"
    ) {
        maxDays.value = 30;
    } else if (month === "02") {
        maxDays.value = isLeapYear ? 29 : 28;
    }
};

const totalTime = props.lesson.lesson_hour * 60 + props.lesson.lesson_minute;

let originalStartTime = null;

watch(
    formSchedule,
    (value) => {
        if (formSchedule.month !== "" || formSchedule.year !== "") {
            handleChangeArrDays();
        }

        const startChanged = formSchedule.start_time !== originalStartTime;

        if (startChanged) {
            originalStartTime = formSchedule.start_time;
            const startTime = moment(formSchedule.start_time, "HH:mm");
            const endTime = startTime.clone().add(totalTime, "minutes");
            formSchedule.end_time = endTime.format("HH:mm");
        }

        if (formSchedule.end_time !== "") {
            const endChanged =
                formSchedule.end_time !==
                moment(originalStartTime, "HH:mm")
                    .clone()
                    .add(totalTime, "minutes")
                    .format("HH:mm");

            if (endChanged) {
                const endTime = moment(formSchedule.end_time, "HH:mm");
                const startTime = endTime
                    .clone()
                    .subtract(totalTime, "minutes");
                formSchedule.start_time = startTime.format("HH:mm");
                originalStartTime = startTime.format("HH:mm");
            }
        }

        if (
            formSchedule.day !== "" ||
            formSchedule.month !== "" ||
            formSchedule.year !== ""
        ) {
            const yearInt = parseInt(formSchedule.year);
            const monthInt = parseInt(formSchedule.month);
            const dayInt = parseInt(formSchedule.day);

            if (
                yearInt > newestYear ||
                (yearInt === newestYear && monthInt > currentMonth) ||
                (yearInt === newestYear &&
                    monthInt === currentMonth &&
                    dayInt > currentDay)
            ) {
                dateValidate.value = false;
            } else if (
                yearInt === newestYear &&
                monthInt === currentMonth &&
                dayInt === currentDay
            ) {
                dateValidate.value = false;
            } else {
                dateValidate.value = true;
            }
        }
    },
    { immediate: true }
);

const addSchedules = () => {
    if (formSchedule.repeat == "0") {
        const weekdayFormat = Number(
            moment(
                formSchedule.year +
                    "/" +
                    formSchedule.month +
                    "/" +
                    formSchedule.day
            ).format("d")
        );
        props.form.weekday.push(weekdayFormat === 0 ? 8 : weekdayFormat + 1);
        props.form.course_schedules.push({
            date: moment(
                formSchedule.year +
                    "/" +
                    formSchedule.month +
                    "/" +
                    formSchedule.day
            ).format("YYYY/MM/DD"),
            start_time: formSchedule.start_time,
            end_time: formSchedule.end_time,
            weekday: moment(
                formSchedule.year +
                    "/" +
                    formSchedule.month +
                    "/" +
                    formSchedule.day
            ).day(),
            repeat: formSchedule.repeat,
        });
    }
    if (formSchedule.repeat == "1") {
        props.form.course_schedules = [];
        props.form.weekday = [];
        const weekdayFormat = Number(
            moment(
                formSchedule.year +
                    "/" +
                    formSchedule.month +
                    "/" +
                    formSchedule.day
            ).format("d")
        );
        props.form.weekday.push(weekdayFormat === 0 ? 8 : weekdayFormat + 1);
        props.form.course_schedules = [];
        for (let i = 0; i < props.lesson.total_of_meets; i++) {
            props.form.course_schedules.push({
                date: moment(
                    formSchedule.year +
                        "/" +
                        formSchedule.month +
                        "/" +
                        formSchedule.day
                )
                    .add(7 * i, "days")
                    .format("YYYY/MM/DD"),
                start_time: formSchedule.start_time,
                end_time: formSchedule.end_time,
                weekday: moment(formSchedule.year+'/'+formSchedule.month+'/'+formSchedule.day).day(),
                repeat: formSchedule.repeat
            })
        }
    }
    if (formSchedule.repeat == "2") {
        props.form.course_schedules = [];
        props.form.weekday = [];
        const weekdayFormat = Number(
            moment(
                formSchedule.year +
                    "/" +
                    formSchedule.month +
                    "/" +
                    formSchedule.day
            ).format("d")
        );
        props.form.weekday.push(weekdayFormat === 0 ? 8 : weekdayFormat + 1);
        props.form.course_schedules = [];
        for (let i = 0; i < props.lesson.total_of_meets; i++) {
            props.form.course_schedules.push({
                date: moment(
                    formSchedule.year +
                        "/" +
                        formSchedule.month +
                        "/" +
                        formSchedule.day
                )
                    .add(14 * i, "days")
                    .format("YYYY/MM/DD"),
                start_time: formSchedule.start_time,
                end_time: formSchedule.end_time,
                weekday: moment(formSchedule.year+'/'+formSchedule.month+'/'+formSchedule.day).day(),
                repeat: formSchedule.repeat
            })
        }
    }
    if (formSchedule.repeat == "3") {
        props.form.course_schedules = [];
        props.form.weekday = [];
        const weekdayFormat = Number(
            moment(
                formSchedule.year +
                    "/" +
                    formSchedule.month +
                    "/" +
                    formSchedule.day
            ).format("d")
        );
        props.form.weekday.push(weekdayFormat === 0 ? 8 : weekdayFormat + 1);
        let prevDate = moment(
            formSchedule.year +
                "/" +
                formSchedule.month +
                "/" +
                formSchedule.day
        ).format("YYYY/MM/DD");
        props.form.course_schedules.push({
            date: prevDate,
            start_time: formSchedule.start_time,
            end_time: formSchedule.end_time,
            weekday: moment(
                formSchedule.year +
                    "/" +
                    formSchedule.month +
                    "/" +
                    formSchedule.day
            ).day(),
            repeat: formSchedule.repeat,
        });
        let drafDate = null;
        let nowDate = null;
        for (let i = 0; i < props.lesson.total_of_meets - 1; i++) {
            drafDate = moment(prevDate).add(28, "days").format("YYYY/MM/DD");

            if (
                prevDate &&
                moment(drafDate).format("M") == moment(prevDate).format("M")
            ) {
                nowDate = moment(drafDate).add(7, "days").format("YYYY/MM/DD");
            } else {
                nowDate = drafDate;
            }

            props.form.course_schedules.push({
                date: nowDate,
                start_time: formSchedule.start_time,
                end_time: formSchedule.end_time,
                weekday: moment(
                    formSchedule.year +
                        "/" +
                        formSchedule.month +
                        "/" +
                        formSchedule.day
                ).day(),
                repeat: formSchedule.repeat,
            });

            prevDate = nowDate;
        }
    }
    closeAddMeetingForm();
};

const hasTimePassed = (date, endTime) => {
    const dateTime = moment(`${date} ${endTime}`, "YYYY/MM/DD HH:mm");
    const now = moment();
    return dateTime.isBefore(now);
};

const showDeletePopup = (index) => {
    showConfirmFormModalMetting();
    scheduleState.index = index;
    scheduleState.date = props.form.course_schedules[index].date;
    scheduleState.start_time = props.form.course_schedules[index].start_time;
    scheduleState.end_time = props.form.course_schedules[index].end_time;
};

const scheduleState = useForm({
    index: "",
    date: "",
    start_time: "",
    end_time: "",
});

const deleteSchedule = () => {
    props.form.course_schedules.splice(scheduleState.index, 1);
    props.form.weekday.splice(scheduleState.index, 1);
    closeModalConfirmDeleteMetting();
};

const formScheduleFill = computed(() => {
    if (
        formSchedule.start_time &&
        formSchedule.end_time &&
        formSchedule.year &&
        formSchedule.month &&
        formSchedule.day &&
        formSchedule.repeat
    ) {
        return true;
    } else {
        return false;
    }
});

const setStartTime = (data) => {
    formSchedule.start_time = data.value;
};
const setEndTime = (data) => {
    formSchedule.end_time = data.value;
};

const checkError = ref(false);
const setTimeRangeError = (data) => {
    checkError.value = data
}

const isShowMemberDialog = ref(-1);
const handleShowMemberDialog = (index) => {
    isShowMemberDialog.value = index;
};

const closeMeetingForm = () => {
    formSchedule.start_time = "";
    formSchedule.end_time = "";
    formSchedule.year = newestYear;
    formSchedule.month = currentMonth;
    formSchedule.day = currentDay;
    showAddMeetingForm.value = false;
};
const kidContinue = (schedule) => {
    let user_id = [];
    let kidContinue = [];
    for (let i = 0; i < schedule.user_schedule?.length; i++) {
        if (schedule.user_schedule[i].status === "1") {
            user_id.push(schedule.user_schedule[i].user_id);
        }
    }
    for (let i = 0; i < props.totalKidApplied().appliedKidArr.length; i++) {
        for (let j = 0; j < user_id.length; j++) {
            if (
                props.totalKidApplied().appliedKidArr[i].kids.parent_id ===
                user_id[j]
            ) {
                kidContinue.push(props.totalKidApplied().appliedKidArr[i]);
            }
        }
    }

    return kidContinue
}

const appliedSort = (appliedArray) => {
    let newarr = appliedArray.sort((a, b) => {
        return moment(b.applied_date).diff(a.applied_date);
    });

    return newarr
}
</script>
<template>
    <div
        class="course-metting-info-container d-flex justify-content-center flex-column"
    >
        <div class="course-metting-info-container-title">{{ lang().label.lesson_course.course }}</div>
        <div class="course-metting-info-container-content">
            <div class="content-title">
                <input
                    type="text"
                    :placeholder="props.form.course_title"
                    class="content-title-input"
                    v-model="props.form.course_title"
                    :disabled="props.update ? true : false"
                />
            </div>
            <div class="list-meeting">
                <div class="list-meeting-title" v-show="props.form.course_schedules.length > 0">{{ lang().label.lesson_course.meeting }}</div>
                <div class="list-meeting-content d-flex justify-content-between" v-for="(schedule, index) in props.form.course_schedules">
                    <div class="d-flex align-items-center" @click="handleShowMemberDialog(index)">
                        <span
                            class="list-meeting-content-time d-flex align-items-center"
                            @click="handleShowMemberDialog"
                        >
                            {{ moment(schedule.date).format("YYYY/MM/DD") }}　
                            {{ schedule.start_time }} ~ {{ schedule.end_time }}
                        </span>
                        <span class="student-quantity" style="margin-left: 8px; transform: translateY(-1px);">
                            ({{ kidContinue(schedule).length }}/{{ props.lesson?.max_learner }})
                        </span>
                    </div>
                    <div class="list-meeting-content-icon" @click="showDeletePopup(index)" v-if="props.totalKidApplied().count == 0">
                        <img
                            src="../../../../../public/img/delete.svg"
                            alt=""
                        />
                    </div>
                    <div
                        class="list-meeting-content-icon"
                        v-else-if="
                            hasTimePassed(schedule.date, schedule.end_time)
                        "
                    >
                        <img
                            src="../../../../../public/img/icon/Checked.svg"
                            alt=""
                        />
                    </div>
                    <div class="list-meeting-content-icon" v-else>
                        <img
                            src="../../../../../public/img/delete.svg"
                            alt=""
                        />
                    </div>
                    <Modal
                        :showModal="isShowMemberDialog === index"
                        @close="isShowMemberDialog === -1"
                    >
                        <div class="schedule-modal-container">
                            <div
                                class="d-flex align-items-center schedule-modal-title"
                            >
                                <div class="schedule-modal-title-text">
                                    {{ lang().label.lesson_course.students_members }}
                                </div>
                                <div class="schedule-modal-title-number">
                                    {{ kidContinue(schedule).length }}/{{
                                        props.lesson?.max_learner
                                    }}
                                </div>
                            </div>
                            <div v-if="kidContinue(schedule).length">
                                <div class="schedule-modal-has-result-container">
                                    <BaseCard  v-for="applied_detail in appliedSort(kidContinue(schedule))">
                                        <div class="schedule-modal-has-result">
                                            <div
                                                class="d-flex align-items-center justify-content-between"
                                            >
                                                <div
                                                    class="d-flex align-items-center schedule-modal-has-result-title"
                                                >
                                                    <div>
                                                        {{
                                                            applied_detail.kids
                                                                .name
                                                        }}
                                                    </div>
                                                    <div>
                                                        {{ lang().label.lesson_course.age }}
                                                        {{
                                                            applied_detail.kids
                                                                .birthday
                                                        }}
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center schedule-modal-has-result-date"
                                                >
                                                    <div
                                                        style="color: red"
                                                        v-if="
                                                            moment(
                                                                applied_detail.applied_date
                                                            ).format(
                                                                'YYYY/MM/DD'
                                                            ) ==
                                                            moment().format(
                                                                'YYYY/MM/DD'
                                                            )
                                                        "
                                                    >
                                                        NEW
                                                    </div>
                                                    <div>
                                                        {{
                                                            moment(
                                                                applied_detail.applied_date
                                                            ).format(
                                                                "YYYY/MM/DD HH:mm"
                                                            )
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex align-items-center schedule-modal-has-result-content"
                                            >
                                                <div>
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="16"
                                                        height="17"
                                                        viewBox="0 0 16 17"
                                                        fill="none"
                                                    >
                                                        <path
                                                            d="M8.75 11.75C8.75 11.8983 8.70602 12.0433 8.6236 12.1667C8.54119 12.29 8.42406 12.3861 8.28701 12.4429C8.14997 12.4997 7.99917 12.5145 7.85368 12.4856C7.7082 12.4566 7.57456 12.3852 7.46967 12.2803C7.36478 12.1754 7.29335 12.0418 7.26441 11.8963C7.23548 11.7508 7.25033 11.6 7.30709 11.463C7.36386 11.3259 7.45999 11.2088 7.58333 11.1264C7.70666 11.044 7.85167 11 8 11C8.19892 11 8.38968 11.079 8.53033 11.2197C8.67098 11.3603 8.75 11.5511 8.75 11.75ZM8 5C6.62125 5 5.5 6.00938 5.5 7.25V7.5C5.5 7.63261 5.55268 7.75979 5.64645 7.85355C5.74022 7.94732 5.86739 8 6 8C6.13261 8 6.25979 7.94732 6.35356 7.85355C6.44732 7.75979 6.5 7.63261 6.5 7.5V7.25C6.5 6.5625 7.17313 6 8 6C8.82688 6 9.5 6.5625 9.5 7.25C9.5 7.9375 8.82688 8.5 8 8.5C7.86739 8.5 7.74022 8.55268 7.64645 8.64645C7.55268 8.74021 7.5 8.86739 7.5 9V9.5C7.5 9.63261 7.55268 9.75979 7.64645 9.85355C7.74022 9.94732 7.86739 10 8 10C8.13261 10 8.25979 9.94732 8.35356 9.85355C8.44732 9.75979 8.5 9.63261 8.5 9.5V9.455C9.64 9.24563 10.5 8.33625 10.5 7.25C10.5 6.00938 9.37875 5 8 5ZM14.5 8.5C14.5 9.78558 14.1188 11.0423 13.4046 12.1112C12.6903 13.1801 11.6752 14.0132 10.4874 14.5052C9.29973 14.9972 7.99279 15.1259 6.73192 14.8751C5.47104 14.6243 4.31285 14.0052 3.40381 13.0962C2.49477 12.1872 1.8757 11.029 1.6249 9.76809C1.37409 8.50721 1.50282 7.20028 1.99479 6.01256C2.48676 4.82484 3.31988 3.80968 4.3888 3.09545C5.45772 2.38122 6.71442 2 8 2C9.72335 2.00182 11.3756 2.68722 12.5942 3.90582C13.8128 5.12441 14.4982 6.77665 14.5 8.5ZM13.5 8.5C13.5 7.4122 13.1774 6.34883 12.5731 5.44436C11.9687 4.53989 11.1098 3.83494 10.1048 3.41866C9.09977 3.00238 7.9939 2.89346 6.92701 3.10568C5.86011 3.3179 4.8801 3.84172 4.11092 4.61091C3.34173 5.3801 2.8179 6.36011 2.60568 7.427C2.39347 8.4939 2.50238 9.59977 2.91867 10.6048C3.33495 11.6098 4.0399 12.4687 4.94437 13.0731C5.84884 13.6774 6.91221 14 8 14C9.45819 13.9983 10.8562 13.4184 11.8873 12.3873C12.9184 11.3562 13.4983 9.95818 13.5 8.5Z"
                                                            fill="#7F7F7F"
                                                        />
                                                    </svg>
                                                </div>
                                                <div>
                                                    {{
                                                        applied_detail.question
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </BaseCard>
                                </div>
                            </div>
                            <div v-else class="schedule-modal-no-result">
                                <NoResult />
                            </div>
                            <div class="schedule-modal-btn d-flex">
                                <button
                                    @click="isShowMemberDialog = false"
                                    class="schedule-modal-btn-left d-flex justify-content-center align-items-center"
                                >
                                    閉じる
                                </button>
                                <button
                                    @click="isShowMemberDialog = false"
                                    class="schedule-modal-btn-right d-flex justify-content-center align-items-center"
                                >
                                    コース詳細ページ
                                </button>
                            </div>
                        </div>
                    </Modal>
                </div>
                <div
                    v-if="
                        props.form.course_schedules.length <
                        props.lesson.total_of_meets
                    "
                    class="list-meeting-add d-flex justify-content-center align-items-center"
                    @click="openAddMeetingForm"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <path
                            d="M21 12C21 12.1989 20.921 12.3897 20.7803 12.5303C20.6397 12.671 20.4489 12.75 20.25 12.75H12.75V20.25C12.75 20.4489 12.671 20.6397 12.5303 20.7803C12.3897 20.921 12.1989 21 12 21C11.8011 21 11.6103 20.921 11.4697 20.7803C11.329 20.6397 11.25 20.4489 11.25 20.25V12.75H3.75C3.55109 12.75 3.36032 12.671 3.21967 12.5303C3.07902 12.3897 3 12.1989 3 12C3 11.8011 3.07902 11.6103 3.21967 11.4697C3.36032 11.329 3.55109 11.25 3.75 11.25H11.25V3.75C11.25 3.55109 11.329 3.36032 11.4697 3.21967C11.6103 3.07902 11.8011 3 12 3C12.1989 3 12.3897 3.07902 12.5303 3.21967C12.671 3.36032 12.75 3.55109 12.75 3.75V11.25H20.25C20.4489 11.25 20.6397 11.329 20.7803 11.4697C20.921 11.6103 21 11.8011 21 12Z"
                            fill="#418997"
                        />
                    </svg>
                    <span class="list-meeting-add-content"
                        >{{ lang().label.lesson_course.add_meeting_slot }}</span
                    >
                </div>
            </div>
        </div>
        <Modal
            :showModal="showConfirmFormDeleteMetting"
            @close="showConfirmFormDeleteMetting = false"
        >
            <div class="modal-container d-flex flex-column">
                <div class="modal-title d-flex justify-content-center">
                    Meetingを削除します。
                </div>
                <div
                    class="modal-content d-flex flex-column align-items-center"
                >
                    <div
                        class="d-flex align-items-center justify-content-center modal-content-date-time"
                    >
                        <div class="date">{{ scheduleState.date }}</div>
                        <div class="time">
                            {{ scheduleState.start_time }} ~
                            {{ scheduleState.end_time }}
                        </div>
                        <div class="count">
                            (0/{{ props.lesson?.max_learner }})
                        </div>
                    </div>
                    <span class="mt-4">(仮)削除すると復元ができません。</span>
                    <span>本当によろしいですか？</span>
                    <span>などなどなどなど</span>
                </div>
                <div class="modal-note d-flex justify-content-center">
                    <span class="modal-note-content"
                        >※注意点注意点注意点注意点注意点注意点</span
                    >
                </div>
                <div class="modal-btn d-flex">
                    <div
                        class="modal-btn-btn modal-btn-btn-left d-flex align-items-center"
                        @click="closeModalConfirmDeleteMetting"
                    >
                        キャンセル
                    </div>
                    <div
                        class="modal-btn-btn modal-btn-btn-right d-flex align-items-center"
                        @click="deleteSchedule"
                    >
                        Meetingを削除
                    </div>
                </div>
            </div>
        </Modal>
        <Modal :showModal="showAddMeetingForm" @close="closeMeetingForm">
            <div class="modal-container d-flex flex-column">
                <div class="modal-title d-flex justify-content-center">
                    Meetingを追加
                </div>
                <div class="tripple-select d-flex flex-column">
                    <label for="Title" class="tripple-select-title"
                        >Date
                    </label>
                    <div class="d-flex form-select-date">
                        <div class="form-wrap-tripple">
                            <select
                                class="select-form"
                                @change="
                                    (e) => (formSchedule.year = e.target.value)
                                "
                            >
                                <option value="" disabled selected hidden>
                                    YYYY
                                </option>
                                <option
                                    v-for="(select, key) in arrayYears"
                                    :value="select"
                                    :key="key"
                                    :selected="formSchedule.year == select"
                                >
                                    {{ select }}
                                </option>
                            </select>
                        </div>
                        <div class="form-wrap-tripple">
                            <select
                                class="select-form"
                                @change="handleChangeArrDays"
                            >
                                <option value="" disabled selected hidden>
                                    MM
                                </option>
                                <option
                                    v-for="select in months"
                                    :value="select"
                                    :key="select"
                                    :selected="formSchedule.month == select"
                                >
                                    {{ select }}
                                </option>
                            </select>
                        </div>
                        <div class="form-wrap-tripple">
                            <select
                                class="select-form"
                                @change="
                                    (e) => (formSchedule.day = e.target.value)
                                "
                            >
                                <option value="" disabled selected hidden>
                                    DD
                                </option>
                                <option
                                    v-for="select in maxDays"
                                    :value="select"
                                    :key="select"
                                    :selected="formSchedule.day == select"
                                >
                                    {{ select }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div v-if="dateValidate" class="course-meeting-date-validate">
                    日付は未来にしてください
                </div>
                <div class="tripple-select d-flex flex-column">
                    <label for="Title" class="tripple-select-title"
                        >Repeat
                    </label>
                    <div class="d-flex form-select-date">
                        <div class="form-wrap-tripple">
                            <select
                                class="select-form"
                                v-model="formSchedule.repeat"
                            >
                                <option value="0">None</option>
                                <option
                                    value="1"
                                    v-if="
                                        props.form?.course_schedules[0]
                                            ?.repeat != 0
                                    "
                                >
                                    Weekly
                                </option>
                                <option
                                    value="2"
                                    v-if="
                                        props.form?.course_schedules[0]
                                            ?.repeat != 0
                                    "
                                >
                                    Bi-Weekly
                                </option>
                                <option
                                    value="3"
                                    v-if="
                                        props.form?.course_schedules[0]
                                            ?.repeat != 0
                                    "
                                >
                                    Month
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <TimeRangeSelect
                    :start-time="formSchedule.start_time"
                    :end-time="formSchedule.end_time"
                    :start-label="'start time'"
                    :end-label="'end time'"
                    @setStartTime="setStartTime"
                    @setEndTime="setEndTime"
                    @setTimeRangeError="setTimeRangeError"
                />
                <div class="modal-note d-flex" style="padding: 0">
                    <ul class="modal-note-ul">
                        <li>
                            ※あいうえおあいうえおあいうえおあいうえおあいうえお。
                        </li>
                        <li>※あいうえおあいうえおあいうえお。</li>
                    </ul>
                </div>
                <div class="modal-btn d-flex">
                    <div
                        class="modal-btn-btn modal-btn-btn-left d-flex align-items-center"
                        @click="closeAddMeetingForm"
                    >
                    {{ lang().label.lesson_course.cancel }}
                    </div>
                    <div
                        class="modal-btn-btn modal-btn-btn-right btn-add d-flex align-items-center course-meeting-info-btn-disabled"
                        v-if="!formScheduleFill || checkError || dateValidate"
                    >
                        Add
                    </div>
                    <div
                        class="modal-btn-btn modal-btn-btn-right btn-add d-flex align-items-center"
                        @click="addSchedules"
                        v-if="formScheduleFill && !checkError && !dateValidate"
                    >
                        Add
                    </div>
                </div>
            </div>
        </Modal>
    </div>
</template>
<style lang="scss" scoped>
    @import "../CourseCreate/CourseCreate";
    .student-quantity {
    color: #418997;
    text-align: center;
    font-family: Noto Sans JP;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: 160%; /* 22.4px */
    letter-spacing: -0.14px;
    user-select: none;
}

    // css modal member
    .schedule-modal-container {
        position: relative;
        min-width: 368px;
        width: 100%;
        min-height: 388px;
        .schedule-modal-title {
            gap: 4px;
            color: #1b1b1b;
            margin-bottom: 8px;
            .schedule-modal-title-text {
                font-size: 14px;
            }
            .schedule-modal-title-number {
                font-size: 14px;
                font-weight: 700;
            }
        }
        .schedule-modal-has-result {
            padding: 8px;
            max-width: 368px;
            .schedule-modal-has-result-title {
                gap: 16px;
                font-size: 14px;
                font-weight: 700;
                color: #1b1b1b;
            }
            .schedule-modal-has-result-date {
                font-size: 12px;
                color: #7f7f7f;
                gap: 4px;
            }
            .schedule-modal-has-result-content {
                font-size: 12px;
                color: #7f7f7f;
                gap: 4px;
                line-height: 160%;
                letter-spacing: -0.12px;
                margin-top: 2px;
                word-break: break-all;
            }
        }
        .schedule-modal-title-number {
            font-size: 14px;
            font-weight: 700;
        }
    }
    .schedule-modal-has-result {
        padding: 8px;
        max-width: 368px;
        .schedule-modal-has-result-title {
            gap: 16px;
            font-size: 14px;
            font-weight: 700;
            color: #1b1b1b;
        }
        .schedule-modal-has-result-date {
            font-size: 12px;
            color: #7f7f7f;
            gap: 4px;
        }
        .schedule-modal-has-result-content {
            font-size: 12px;
            color: #7f7f7f;
            gap: 4px;
            line-height: 160%;
            letter-spacing: -0.12px;
            margin-top: 2px;
            word-break: break-all;
        }
    }
    .schedule-modal-no-result {
        padding: 68px 0px;
	}
    .course-meeting-info-btn-disabled {
        color: #989898 !important;
        background-color: #c4c4c4 !important;
        cursor: no-drop !important;
    }
    .course-meeting-date-validate {
        font-size: 10px;
        color: #E71A41;
        margin-left: 4px;
    }
    .schedule-modal-btn {
        gap: 16px;
        margin-top: 8px;
        position: absolute;
        bottom: 0;
        .schedule-modal-btn-left {
            width: 176px;
            height: 50px;
            cursor: pointer;
            background-color: white;
            border-radius: 4px;
            border: 1px solid #418997;
            color: #418997;
            font-family: "Noto Sans JP";
            font-size: 14px;
        }
        .schedule-modal-btn-right {
            width: 176px;
            height: 50px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            background-color: #418997;
            color: white;
            font-family: "Noto Sans JP";
            font-size: 14px;
        }
    }

.schedule-modal-has-result-container {
    overflow: auto;
    max-height: 276px;
    scrollbar-width: thin;
    scrollbar-color: #ccc #f4f4f4;
    margin: 16px 0px;
}
.schedule-modal-has-result-container::-webkit-scrollbar {
    width: 6px;
}

.schedule-modal-has-result-container::-webkit-scrollbar-thumb {
    border-radius: 100px;
    background: rgba(127, 127, 127, 0.6);
}

.schedule-modal-has-result-container::-webkit-scrollbar-track {
    background-color: #f4f4f4;
}
@media all and (max-width: 768px) {
    .schedule-modal-btn-left,
    .schedule-modal-btn-right {
        width: 147px !important;
    }
    .schedule-modal-container {
        min-width: 310px;
    }
}
.course-meeting-info-btn-disabled {
    color: #989898 !important;
    background-color: #c4c4c4 !important;
    cursor: no-drop !important;
}
.course-meeting-date-validate {
    font-size: 10px;
    color: #e71a41;
    margin-left: 4px;
}
.modal-content-date-time {
    gap: 8px;
    font-weight: 700;
    padding: 8px 0px;
    width: 100%;
    border-radius: 4px;
    opacity: 0.8;
    background-color: #f4f4f4;
    line-height: 160%;
    letter-spacing: -0.14px;
    .count {
        color: #418997;
        font-size: 14px;
    }
}
</style>
