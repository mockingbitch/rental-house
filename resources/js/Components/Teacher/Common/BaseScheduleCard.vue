<script setup>
import { ref, computed } from "vue";
import Modal from "../../Modal/Modal.vue";
import NoResult from "./NoResult.vue";
import BaseCard from "./BaseCard.vue";
import moment from "moment";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    schedule: Array,
});

const isShowMemberDialog = ref(false);
const handleShowMemberDialog = () => {
    isShowMemberDialog.value = true;
};
const currentTime = moment();
const dateFromData = moment(props.schedule?.date);

const isExpired = computed(() => {
    return (
        dateFromData.isBefore(currentTime) && !dateFromData.isSame(currentTime, 'day')
    );
});

const isDue = computed(() => {
    return (
        dateFromData.isSame(currentTime, 'day')
    );
});

const totalApplied = (application) => {
    let countTotal = 0;
    let countToday = 0;
    let countTodayMinus = 0;
    for (let i = 0; i < application.length; i++) {
        if (application[i].status == '1') {    
            countTotal += application[i].application_details.length;
        }
        for (let j = 0; j < application[i].application_details.length; j++) {
            if (moment(application[i].application_details[j].created_at).format("YYYY/MM/DD") === moment().format("YYYY/MM/DD")) {
                countToday++;
            }

            if (moment(application[i].application_details[j].updated_at).format("YYYY/MM/DD") === moment().format("YYYY/MM/DD") &&
                moment(application[i].application_details[j].created_at).format("YYYY/MM/DD hh:mm") !== moment(application[i].application_details[j].updated_at).format("YYYY/MM/DD hh:mm")) {
                countTodayMinus++;
            }
        }
    }
    return {
        countTotal: countTotal,
        countToday: countToday - countTodayMinus  > 0 ? "+" + (countToday - countTodayMinus) : (countToday - countTodayMinus),
    };
};
const kidApplied = (course) => {
    let kidAppliedArray = [];
    for (let i = 0; i < course.course_applications?.length; i++) {
        if (course.course_applications[i].status == '1'){
            for (let j = 0; j < course.course_applications[i].application_details.length; j++) {
                course.course_applications[i].application_details[j].kids.question = JSON.parse(course.course_applications[i].learner_question)[0].question;
                course.course_applications[i].application_details[j].kids.applied_date = moment(course.course_applications[i].created_at).format("YYYY/MM/DD HH:mm");
                kidAppliedArray.push(course.course_applications[i].application_details[j].kids);
            }
        }
    }
    kidAppliedArray.sort(function (a, b) {
        return new Date(b.applied_date) - new Date(a.applied_date);
    });

    return kidAppliedArray;
};
</script>
<template>
    <div v-if="!isExpired" class="base-schedule-card-container">
        <div class="d-flex align-items-center base-schedule-card-title">
            <img
                src="../../../../../public/img/icon/TeacherDashboard/seed.svg"
                alt=""
                width="18"
                height="18"
            />
            <div class="base-schedule-card-title-text">
                {{ props.schedule?.course?.title }}
            </div>
            <div class="base-schedule-card-title-icon">
                <Link :href="route('lesson.detail', props.schedule?.course?.lesson_id)">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="18"
                        viewBox="0 0 18 18"
                        fill="none"
                    >
                        <path
                            d="M12.7733 9.39828L7.14828 15.0233C7.09602 15.0755 7.03398 15.117 6.96569 15.1453C6.89741 15.1736 6.82422 15.1881 6.75031 15.1881C6.6764 15.1881 6.60322 15.1736 6.53493 15.1453C6.46665 15.117 6.40461 15.0755 6.35234 15.0233C6.30008 14.971 6.25863 14.909 6.23034 14.8407C6.20206 14.7724 6.1875 14.6992 6.1875 14.6253C6.1875 14.5514 6.20206 14.4782 6.23034 14.4099C6.25863 14.3417 6.30008 14.2796 6.35234 14.2273L11.5801 9.00031L6.35234 3.77328C6.2468 3.66773 6.1875 3.52458 6.1875 3.37531C6.1875 3.22605 6.2468 3.08289 6.35234 2.97734C6.45789 2.8718 6.60105 2.8125 6.75031 2.8125C6.89958 2.8125 7.04273 2.8718 7.14828 2.97734L12.7733 8.60234C12.8256 8.65458 12.8671 8.71662 12.8954 8.78491C12.9237 8.8532 12.9383 8.92639 12.9383 9.00031C12.9383 9.07423 12.9237 9.14743 12.8954 9.21572C12.8671 9.284 12.8256 9.34604 12.7733 9.39828Z"
                            fill="#343330"
                        />
                    </svg>
                </Link>
            </div>
        </div>
        <div class="d-flex base-schedule-card-info">
            <div
                class="base-schedule-card-info-item"
                :style="
                    isDue
                        ? 'background-color: #FFF0F3;color:#FF5575;'
                        : 'background-color: #F4F4F4'
                "
            >
                <div class="base-schedule-card-info-item-title">
                    <div>{{ props.schedule?.date }}</div>
                    <div>
                        {{ props.schedule?.start_time }} ~
                        {{ props.schedule?.end_time }}
                    </div>
                </div>
                <div class="base-schedule-card-info-item-subtitle">{{ lang().label.lesson_course.date }}</div>
            </div>
            <div class="base-schedule-card-info-item">
                <div class="base-schedule-card-info-item-title">
                    <div>
                        ({{
                            totalApplied(
                                props.schedule?.course?.course_applications
                            ).countToday
                        }})
                    </div>
                    <div
                        class="base-schedule-card-info-item-title-text"
                        @click="handleShowMemberDialog"
                    >
                        {{
                            totalApplied(
                                props.schedule?.course?.course_applications
                            ).countTotal
                        }}/{{ props.schedule?.course?.max_seat }}
                    </div>
                </div>
                <div class="base-schedule-card-info-item-subtitle">{{ lang().label.schedule.status }}</div>
            </div>
            <div class="base-schedule-card-info-item">
                <div class="base-schedule-card-info-item-title">
                    <div class="base-schedule-card-info-item-title-text">
                        Zoom URL
                    </div>
                </div>
                <div class="base-schedule-card-info-item-subtitle">{{ lang().label.schedule.attend }}</div>
            </div>
        </div>
        <Modal
            :showModal="isShowMemberDialog"
            @close="isShowMemberDialog = false"
        >
            <div class="schedule-modal-container">
                <div class="d-flex align-items-center schedule-modal-title">
                    <div class="schedule-modal-title-text">
                        {{ lang().label.lesson_course.students_members }}
                    </div>
                    <div class="schedule-modal-title-number">
                        {{
                            totalApplied(
                                props.schedule?.course?.course_applications
                            ).countTotal
                        }}/{{ props.schedule?.course?.max_seat }}
                    </div>
                </div>
                <div v-if="kidApplied(props.schedule.course).length">
                    <div class="schedule-modal-has-result-container">
                        <!-- 3 card để test scroll -->
                        <BaseCard
                            v-for="kid in kidApplied(props.schedule.course)"
                        >
                            <div class="schedule-modal-has-result">
                                <div
                                    class="d-flex align-items-center justify-content-between"
                                >
                                    <div
                                        class="d-flex align-items-center schedule-modal-has-result-title"
                                    >
                                        <div>{{ kid.name }}</div>
                                        <div>{{ lang().label.lesson_course.age }} {{ kid.birthday }}</div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center schedule-modal-has-result-date"
                                    >
                                        <div
                                            v-if="
                                                moment(kid.applied_date).format(
                                                    'YYYY/MM/DD'
                                                ) ===
                                                moment().format('YYYY/MM/DD')
                                            "
                                            style="color:#FF5575; font-weight:bold; font-size:10px; line-height:16px;"
                                        >
                                            NEW
                                        </div>
                                        <div>{{ kid.applied_date }}</div>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center schedule-modal-has-result-content"
                                >
                                    <div style="display: flex; justify-content: center; align-items: center;">
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
                                        {{ kid.question }}
                                    </div>
                                </div>
                            </div>
                        </BaseCard>
                    </div>
                </div>
                <div v-else class="schedule-modal-no-result"><NoResult /></div>
                <div class="schedule-modal-btn d-flex">
                    <button
                        @click="isShowMemberDialog = false"
                        class="schedule-modal-btn-left d-flex justify-content-center align-items-center"
                    >
                        閉じる
                    </button>
                    <Link
                        :href="route('course.edit', props.schedule?.course?.id)"
                        class="schedule-modal-btn-right d-flex justify-content-center align-items-center"
                    >
                        コース詳細ページ
                    </Link>
                </div>
            </div>
        </Modal>
    </div>
</template>
<style scoped lang="scss">
.base-schedule-card-container {
    margin-top: 16px;
}
.base-schedule-card-title {
    position: relative;
    color: #1b1b1b;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: 160%;
    letter-spacing: -0.14px;
    gap: 8px;
    margin-bottom: 4px;
    .base-schedule-card-title-text {
        width: 100%;
        max-width: 250px;
        padding-right: 24px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .base-schedule-card-title-icon {
        cursor: pointer;
        position: absolute;
        right: 4px;
    }
}
.base-schedule-card-info {
    gap: 4px;
}
.base-schedule-card-info-item {
    min-width: calc((100% - 8px) / 3);
    background-color: #f4f4f4;
    border-radius: 4px;
    padding: 8px;
    font-size: 12px;
    font-weight: 700;
    text-align: center;
    line-height: 1.5;
    .base-schedule-card-info-item-title {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: calc(100% / 3 * 2);
        .base-schedule-card-info-item-title-text {
            color: #418997;
            text-decoration: underline;
            cursor: pointer;
        }
    }
    .base-schedule-card-info-item-subtitle {
        color: #989898;
        font-weight: 400;
    }
}
// css modal
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
    .schedule-modal-no-result {
        padding: 68px 0px;
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
.teacher__dashboard-card-container {
    margin-bottom: 8px !important;
    border-radius: 4px !important;
}
:deep(.modal) {
    border-radius: 10px !important;
}
</style>
