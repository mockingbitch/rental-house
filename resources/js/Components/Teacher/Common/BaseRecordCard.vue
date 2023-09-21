<script setup>
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
import moment from "moment";
import { lessonRating } from "@/Helper/lessonRating";

const props = defineProps({
    isAll: Boolean,
    lessons: Object,
    lesson: Object,
    total_learner_applied: Object,
});
const totalRevenue = () => {
    let count = 0;
    for (let i = 0; i < props.total_learner_applied?.length; i++) {
        if (props.total_learner_applied[i]?.status == 1) {
            if (props.total_learner_applied[i]?.style == 1) {
                count += (props.total_learner_applied[i]?.price * 70) / 100;
            }
            if (props.total_learner_applied[i]?.style == 2) {
                count += (props.total_learner_applied[i]?.price * 50) / 100;
            }
        }
    }

    return count;
};

const totalReviewScore = () => {
    let countReview = 0;
    let totalReviews = []
    for (let i = 0; i < props.lessons?.length; i++) {
        for (let j = 0; j < props.lessons[i]?.review?.length; j++) {
            countReview++;
            totalReviews.push(props.lessons[i]?.review[j]);
        }
    }

    return {
        countReview:  countReview,
        lesson:{
            review: totalReviews
        }
    }
}

const scheduleCount = () => {
    let countSchedule = 0;
    for (let i = 0; i < props.lesson?.course?.length; i++) {
        countSchedule += props.lesson?.course[i].course_schedules.length;
    }

    return countSchedule;
};

const lessonAppliedCount = () => {
    let countApplied = 0;
    for (let i = 0; i < props.lesson?.course?.length; i++) {
        for (let j = 0; j < props.lesson?.course[i]?.course_applications.length; j++) {
            if (props.lesson?.course[i]?.course_applications[j].status == '1') {
                countApplied +=  props.lesson?.course[i]?.course_applications[j]?.application_details.length;
            }
        }
    }

    return countApplied;
};

const lessonRevenue = () => {
    let revenue = 0;
    if (props.lesson?.style == 1) {
        revenue = (lessonAppliedCount() * props.lesson?.price * 70) / 100;
    }
    if (props.lesson?.style == 2) {
        revenue = (lessonAppliedCount() * props.lesson?.price * 50) / 100;
    }

    return revenue;
};

</script>
<template>
    <div>
        <!-- Nếu là TOTAL -->
        <div class="d-flex base-record-card-title mt-4" v-if="isAll">
            <div class="">{{ lang().label.record.total }}</div>
            <div class="base-record-card-title-icon">
                <Link :href="route('total.review')">
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
        <!-- Nếu không là TOTAL -->
        <div v-else>
            <div class="base-record-date mt-4">
                {{ moment(props.lesson?.created_at).format("YYYY/MM/DD") }}
            </div>
            <div class="d-flex align-items-center base-record-card-title">
                <img
                    src="../../../../../public/img/icon/TeacherDashboard/seed.svg"
                    alt=""
                    width="18"
                    height="18"
                />
                <div class="base-record-card-title-text">
                    {{ props.lesson?.title }}
                </div>
                <div class="base-record-card-title-icon">
                    <Link :href="route('schedule.review', props.lesson?.id)">
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
        </div>

        <!-- TODO: Nếu là TOTAL -->
        <div v-if="isAll" class="d-flex base-record-card-info">
            <div class="base-record-card-info-item">
                <div class="base-record-card-info-item-title">
                    <div>{{ props.lessons.length }}</div>
                </div>
                <div class="base-record-card-info-item-subtitle">{{ lang().label.record.lessons }}</div>
            </div>
            <div class="base-record-card-info-item">
                <div class="base-record-card-info-item-title">
                    <div>
                        {{
                            props.total_learner_applied.filter(
                                (item) => item.status == 1
                            ).length
                        }}
                    </div>
                </div>
                <div class="base-record-card-info-item-subtitle">{{ lang().label.record.applicant }}</div>
            </div>
            <div class="base-record-card-info-item">
                <div class="base-record-card-info-item-title">
                    <div class="item-title-price">
                        ¥{{ totalRevenue().toLocaleString()  }}
                    </div>
                </div>
                <div class="base-record-card-info-item-subtitle">{{ lang().label.record.price }}</div>
            </div>
            <Link class="base-record-card-info-item" :href="route('total.review')">
                <div class="base-record-card-info-item-title">
                    <div class="d-flex align-items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="13"
                            height="13"
                            viewBox="0 0 13 13"
                            fill="none"
                        >
                            <path
                                d="M11.4926 5.86147L9.37853 7.70647L10.0118 10.4533C10.0453 10.5969 10.0358 10.7472 9.98432 10.8854C9.93288 11.0236 9.84184 11.1436 9.72259 11.2303C9.60334 11.3171 9.46117 11.3667 9.31385 11.3731C9.16653 11.3795 9.0206 11.3423 8.89431 11.2662L6.49853 9.81303L4.1079 11.2662C3.98161 11.3423 3.83568 11.3795 3.68836 11.3731C3.54104 11.3667 3.39887 11.3171 3.27962 11.2303C3.16037 11.1436 3.06933 11.0236 3.01789 10.8854C2.96645 10.7472 2.95689 10.5969 2.9904 10.4533L3.62275 7.70928L1.50821 5.86147C1.39637 5.76501 1.3155 5.63768 1.27574 5.49544C1.23598 5.35321 1.23909 5.2024 1.2847 5.06193C1.33031 4.92145 1.41637 4.79757 1.5321 4.70582C1.64783 4.61407 1.78807 4.55852 1.93524 4.54616L4.72243 4.30475L5.8104 1.70975C5.86722 1.57359 5.96305 1.45728 6.08583 1.37546C6.20862 1.29365 6.35286 1.25 6.5004 1.25C6.64794 1.25 6.79219 1.29365 6.91497 1.37546C7.03775 1.45728 7.13359 1.57359 7.1904 1.70975L8.28165 4.30475L11.0679 4.54616C11.2151 4.55852 11.3553 4.61407 11.471 4.70582C11.5868 4.79757 11.6728 4.92145 11.7184 5.06193C11.7641 5.2024 11.7672 5.35321 11.7274 5.49544C11.6876 5.63768 11.6068 5.76501 11.4949 5.86147H11.4926Z"
                                fill="#418997"
                            />
                        </svg>
                        <div class="base-record-card-info-item-title-text">
                            {{ lessonRating(totalReviewScore().lesson).toFixed(1) }}
                        </div>
                        <div class="item-subtitle-review">
                            ({{ totalReviewScore().countReview }})
                        </div>
                    </div>
                </div>
                <div class="base-record-card-info-item-subtitle">{{ lang().label.record.review }}</div>
            </Link>
        </div>

        <!-- TODO: Nếu không là TOTAL -->
        <div v-else class="d-flex base-record-card-info">
            <div class="base-record-card-info-item">
                <div class="base-record-card-info-item-title">
                    <div>{{ scheduleCount() }}</div>
                </div>
                <div class="base-record-card-info-item-subtitle">{{ lang().label.record.lessons }}</div>
            </div>
            <div class="base-record-card-info-item">
                <div class="base-record-card-info-item-title">
                    <div>{{ lessonAppliedCount() }}</div>
                </div>
                <div class="base-record-card-info-item-subtitle">{{ lang().label.record.applicant }}</div>
            </div>
            <div class="base-record-card-info-item">
                <div class="base-record-card-info-item-title">
                    <div class="">¥{{ lessonRevenue().toLocaleString() }}</div>
                </div>
                <div class="base-record-card-info-item-subtitle">{{ lang().label.record.price }}</div>
            </div>
            <Link class="base-record-card-info-item" :href="route('schedule.review', props.lesson?.id)">
                <div class="base-record-card-info-item-title">
                    <div class="d-flex align-items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="13"
                            height="13"
                            viewBox="0 0 13 13"
                            fill="none"
                        >
                            <path
                                d="M11.4926 5.86147L9.37853 7.70647L10.0118 10.4533C10.0453 10.5969 10.0358 10.7472 9.98432 10.8854C9.93288 11.0236 9.84184 11.1436 9.72259 11.2303C9.60334 11.3171 9.46117 11.3667 9.31385 11.3731C9.16653 11.3795 9.0206 11.3423 8.89431 11.2662L6.49853 9.81303L4.1079 11.2662C3.98161 11.3423 3.83568 11.3795 3.68836 11.3731C3.54104 11.3667 3.39887 11.3171 3.27962 11.2303C3.16037 11.1436 3.06933 11.0236 3.01789 10.8854C2.96645 10.7472 2.95689 10.5969 2.9904 10.4533L3.62275 7.70928L1.50821 5.86147C1.39637 5.76501 1.3155 5.63768 1.27574 5.49544C1.23598 5.35321 1.23909 5.2024 1.2847 5.06193C1.33031 4.92145 1.41637 4.79757 1.5321 4.70582C1.64783 4.61407 1.78807 4.55852 1.93524 4.54616L4.72243 4.30475L5.8104 1.70975C5.86722 1.57359 5.96305 1.45728 6.08583 1.37546C6.20862 1.29365 6.35286 1.25 6.5004 1.25C6.64794 1.25 6.79219 1.29365 6.91497 1.37546C7.03775 1.45728 7.13359 1.57359 7.1904 1.70975L8.28165 4.30475L11.0679 4.54616C11.2151 4.55852 11.3553 4.61407 11.471 4.70582C11.5868 4.79757 11.6728 4.92145 11.7184 5.06193C11.7641 5.2024 11.7672 5.35321 11.7274 5.49544C11.6876 5.63768 11.6068 5.76501 11.4949 5.86147H11.4926Z"
                                fill="#418997"
                            />
                        </svg>
                        <div class="base-record-card-info-item-title-text">
                            {{ lessonRating(props.lesson).toFixed(1) }}
                        </div>
                        <div class="item-subtitle-review">
                            ({{ props.lesson?.review?.length }})
                        </div>
                    </div>
                </div>
                <div class="base-record-card-info-item-subtitle">{{ lang().label.record.review }}</div>
            </Link>
        </div>
    </div>
</template>
<style scoped lang="scss">
.base-record-card-container {
    margin-top: 16px;
}
.base-record-date {
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 160%;
    letter-spacing: -0.14px;
    color: #7f7f7f;
    margin-bottom: 4px;
}
.base-record-card-title {
    position: relative;
    color: #1b1b1b;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: 160%;
    letter-spacing: -0.14px;
    gap: 8px;
    margin-bottom: 4px;
    .base-record-card-title-text {
        width: 100%;
        max-width: 250px;
        padding-right: 24px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .base-record-card-title-icon {
        cursor: pointer;
        position: absolute;
        right: 4px;
    }
}
.base-record-card-info {
    gap: 4px;
}
.base-record-card-info-item {
    min-width: calc((100% - 12px) / 4);
    background-color: #f4f4f4;
    border-radius: 4px;
    padding: 8px;
    font-size: 12px;
    font-weight: 700;
    text-align: center;
    line-height: 2.25;
    .base-record-card-info-item-title {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: calc((100% - 4px) / 3 * 2);
        .base-record-card-info-item-title-text {
            color: #418997;
            cursor: pointer;
            margin-right: 2px;
        }
    }
    .base-record-card-info-item-subtitle {
        color: #989898;
        font-weight: 400;
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
.item-title-price {
    max-width: 80px !important;
    overflow: hidden;
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
}
.item-subtitle-review {
    color: #4d4d4d;
}
</style>
