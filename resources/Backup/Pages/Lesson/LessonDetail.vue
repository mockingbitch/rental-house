<script setup>
import Layout from "../../Layouts/Layout.vue";
import Modal from "../../Components/Modal/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import moment from "moment";
import ButtonDeleteRequest from "../../Components/Request/ButtonDeleteRequest.vue";
import Stars from "@/Components/Rating/Stars.vue";
import { lessonRating } from "@/Helper/lessonRating";
import { reviewRating } from "@/Helper/reviewRating";

const props = defineProps({
    lessons: Array,
    teacher: Array,
    reviews: Array,
    lesson_courses: Array,
});


const formVideo = useForm({
    isOpen: false,
    role: "",
});

const detailForm = useForm({
    scheduleShow: 4,
    reviewShow: 1,
    moreNote: false,
    moreExperience: false,
    moreContent: false,
});

const showParentVid = () => {
    formVideo.isOpen = true;
    formVideo.role = "parent";
};

const showChildVid = () => {
    formVideo.isOpen = true;
    formVideo.role = "child";
};

const showMoreSchedule = () => {
    if (detailForm.scheduleShow < validCourses(props.lesson_courses).length) {
        detailForm.scheduleShow = detailForm.scheduleShow + 4;
    }
};
const showMoreReview = () => {
    if (detailForm.reviewShow < props.reviews.length) {
        detailForm.reviewShow = detailForm.reviewShow + 2;
    }
};

const showFullReview = (id) => {
    document.getElementById(`reviewNumber${id}`).classList.add("fullReview");
    document.getElementById(`showMoreNumber${id}`).style.display = "none";
};

const totalTime = (start_time, end_time) => {
    const start = moment.utc(start_time, "HH:mm");
    const end = moment.utc(end_time, "HH:mm");
    return [
        moment.duration(end.diff(start))._data.hours,
        moment.duration(end.diff(start))._data.minutes,
    ];
};

const showTime = ref(null);
const handleShowMoreTime = (index) => {
    showTime.value = showTime.value === index ? null : index;
};

const openDialogDeleteLesson = ref(false);
const handleDeleteLesson = () => {
    openDialogDeleteLesson.value = true;
};

const openDialogSuspendLesson = ref(false);
const handleSuspendLesson = () => {
    openDialogSuspendLesson.value = true;
};

const validCourses = (courses) => {
    let validCourse = courses;
    if (usePage().props.auth?.user?.role == 3 || !usePage().props.auth?.user) {
        validCourse = courses.filter(
            (item) =>
                moment(item.date)
                    .subtract(item.deadline, "days")
                    .format("YYYY-MM-DD") >= moment().format("YYYY-MM-DD")
        );
    }

    validCourse.sort(function (a, b) {
        return moment(a.date) - moment(b.date);
    });

    return validCourse
}

const checkExpired = (date, endTime) => {
    const currentDate = moment();
    const expiredTime = moment(`${date} ${endTime}`, 'YYYY-MM-DD HH:mm');

    if(currentDate.isBefore(expiredTime)) {
        return false
    } else if (currentDate.isSame(expiredTime, 'minute') || currentDate.isAfter(expiredTime)) {
        return true;
    } else {
        return false;
    }
}
const rating = lessonRating(props.lessons)
</script>

<template>
    <Layout>
        <main class="detailLesson">
            <div class="container">
                <div class="form">
                    <div class="form__wrap">
                        <div class="news">
                            <a href="" class="image">
                                <img :src="props.lessons.cover_image" />
                            </a>
                            <div class="title">
                                {{ props.lessons.title }}
                            </div>
                            <div class="author">
                                <div class="author__left">
                                    <div class="avatar">
                                        <img
                                            :src="props.teacher.avatar"
                                            alt=""
                                        />
                                    </div>
                                    <p>
                                        {{ props.teacher.first_name }}
                                        {{ props.teacher.last_name }}
                                    </p>
                                </div>
                                <div class="author__right">
                                    <Stars :stars="rating" />
                                    <p><span>{{ rating.toFixed(1) }}</span> ({{ props.lessons.review?.length }})</p>
                                </div>
                            </div>
                            <p
                                class="description"
                                :class="{ fullText: detailForm.moreContent }"
                            >
                                {{ props.lessons.lesson_content }}
                            </p>
                            <span
                                class="showMore"
                                @click="detailForm.moreContent = true"
                                v-show="detailForm.moreContent == false"
                                >{{
                                    lang().label.lesson_detail.show_more
                                }}</span
                            >
                            <span
                                class="showMore"
                                @click="detailForm.moreContent = false"
                                v-show="detailForm.moreContent"
                                >{{
                                    lang().label.lesson_detail.show_less
                                }}</span
                            >
                        </div>
                        <div class="attributes">
                            <ul>
                                <li>
                                    <span
                                        >¥{{
                                            props.lessons?.price?.toLocaleString()
                                        }}</span
                                    >
                                    <p>
                                        {{
                                            lang().label.lesson_detail.field
                                                .price
                                        }}
                                    </p>
                                </li>
                                <li>
                                    <span
                                        >{{ props.lessons.target_age_from }} ~
                                        {{ props.lessons.target_age_to }}</span
                                    >
                                    <p>
                                        {{
                                            lang().label.lesson_detail.field
                                                .ages
                                        }}
                                    </p>
                                </li>
                                <li>
                                    <span
                                        >{{ props.lessons.min_learner }} -
                                        {{ props.lessons.max_learner }}</span
                                    >
                                    <p>
                                        {{
                                            lang().label.lesson_detail.field
                                                .learners
                                        }}
                                    </p>
                                </li>
                                <li>
                                    <span
                                        >{{
                                            props.lessons.number_of_meets
                                        }}
                                        meet</span
                                    >
                                    <p>
                                        {{
                                            lang().label.lesson_detail.field
                                                .week
                                        }}
                                    </p>
                                </li>
                                <li>
                                    <span v-if="props.lessons.lesson_hour !== 0"
                                        >{{ props.lessons.lesson_hour }}h</span
                                    >
                                    <span
                                        >{{
                                            props.lessons.lesson_minute
                                        }}min</span
                                    >
                                    <p>
                                        {{
                                            lang().label.lesson_detail.field
                                                .time
                                        }}
                                    </p>
                                </li>
                                <li>
                                    <span v-if="props.lessons.language == 1"
                                        >Japanese</span
                                    >
                                    <span v-if="props.lessons.language == 2"
                                        >English</span
                                    >
                                    <span v-if="props.lessons.language == 3"
                                        >Vietnamese</span
                                    >
                                    <p>
                                        {{
                                            lang().label.lesson_detail.field
                                                .language
                                        }}
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="videoWarp">
                            <div class="item">
                                <p class="subTitle">
                                    {{ lang().label.lesson_detail.for_parent }}
                                </p>
                                <div class="video" @click="showParentVid">
                                    <video
                                        :src="
                                            props.lessons.short_video_for_parent
                                        "
                                        class="h-full"
                                    ></video>
                                    <div class="icon">
                                        <img
                                            src="/img/icon/PlayCircle.svg"
                                            alt=""
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <p class="subTitle">
                                    {{ lang().label.lesson_detail.for_kid }}
                                </p>
                                <div class="video" @click="showChildVid">
                                    <video
                                        :src="
                                            props.lessons
                                                .short_video_for_learner
                                        "
                                        class="h-full"
                                    ></video>
                                    <div class="icon">
                                        <img
                                            src="/img/icon/PlayCircle.svg"
                                            alt=""
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="schedule">
                            <p class="subTitle">
                                {{ lang().label.lesson_detail.schedule }}
                            </p>
                            <div
                                class="item"
                                v-for="lesson_course in validCourses(
                                    props.lesson_courses
                                ).slice(0, detailForm.scheduleShow)"
                                :key="lesson_course.id"
                                :class="{
                                    item__full:
                                        lesson_course.total_applied ===
                                        lesson_course.max_seat,
                                }"
                            >
                                <div class="item__left">
                                    <div class="top">
                                        <div class="date">
                                            {{
                                                moment(
                                                    lesson_course.date
                                                ).format("YYYY/MM/DD")
                                            }}
                                        </div>
                                        <div class="time d-flex">
                                            <div>
                                                {{ lesson_course.start_time }} ~
                                                {{ lesson_course.end_time }}
                                                (<span
                                                    v-if="
                                                        totalTime(
                                                            lesson_course.start_time,
                                                            lesson_course.end_time
                                                        )[0] > 0
                                                    "
                                                    >{{
                                                        totalTime(
                                                            lesson_course.start_time,
                                                            lesson_course.end_time
                                                        )[0]
                                                    }}h
                                                </span>
                                                <span
                                                    >{{
                                                        totalTime(
                                                            lesson_course.start_time,
                                                            lesson_course.end_time
                                                        )[1]
                                                    }}m</span
                                                >)
                                            </div>
                                            <div
                                                class="show-button"
                                                @click="
                                                    handleShowMoreTime(
                                                        lesson_course.id
                                                    )
                                                "
                                            >
                                                <div
                                                    v-if="
                                                        showTime ===
                                                        lesson_course.id
                                                    "
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="20"
                                                        height="20"
                                                        viewBox="0 0 32 32"
                                                        fill="none"
                                                    >
                                                        <path
                                                            d="M26.7076 20.7073C26.6147 20.8003 26.5044 20.874 26.383 20.9244C26.2616 20.9747 26.1315 21.0006 26.0001 21.0006C25.8687 21.0006 25.7385 20.9747 25.6171 20.9244C25.4957 20.874 25.3854 20.8003 25.2926 20.7073L16.0001 11.4136L6.70757 20.7073C6.51993 20.895 6.26543 21.0004 6.00007 21.0004C5.7347 21.0004 5.48021 20.895 5.29257 20.7073C5.10493 20.5197 4.99951 20.2652 4.99951 19.9998C4.99951 19.7344 5.10493 19.4799 5.29257 19.2923L15.2926 9.29231C15.3854 9.19933 15.4957 9.12557 15.6171 9.07525C15.7385 9.02493 15.8687 8.99902 16.0001 8.99902C16.1315 8.99902 16.2616 9.02493 16.383 9.07525C16.5044 9.12557 16.6147 9.19933 16.7076 9.29231L26.7076 19.2923C26.8005 19.3852 26.8743 19.4955 26.9246 19.6169C26.975 19.7383 27.0009 19.8684 27.0009 19.9998C27.0009 20.1312 26.975 20.2614 26.9246 20.3828C26.8743 20.5041 26.8005 20.6144 26.7076 20.7073Z"
                                                            fill="#7f7f7f"
                                                        />
                                                    </svg>
                                                </div>
                                                <div v-else>
                                                    <img
                                                        src="../../../../public/img/icon/CaretDown.svg"
                                                        alt=""
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        v-if="showTime === lesson_course.id"
                                        class="mt-2"
                                        v-for="schedule in lesson_course.course_schedules"
                                    >
                                        <div
                                            class="d-flex align-items-center lesson__detail-schedule"
                                        >
                                            <img
                                                v-if="checkExpired(schedule.date, schedule.end_time)"
                                                src="../../../../public/img/icon/check.svg"
                                                alt=""
                                                width="20"
                                                height="20"
                                            />
                                            <div
                                                v-else
                                                class="lesson__detail-schedule-no-check"
                                            ></div>
                                            <div
                                                class="lesson__detail-schedule-day"
                                            >
                                                {{
                                                    moment(
                                                        schedule?.date
                                                    ).format("ddd YYYY/MM/DD")
                                                }}
                                            </div>
                                            <div>・</div>
                                            <div
                                                class="lesson__detail-schedule-time"
                                            >
                                                {{ schedule?.start_time }} -
                                                {{ schedule?.end_time }}
                                            </div>
                                            <div>AM</div>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="seats">
                                            {{
                                                lesson_course.max_seat -
                                                lesson_course.total_applied
                                            }}
                                            Available seats
                                        </div>
                                        <div class="count">
                                            ({{
                                                lesson_course.total_applied
                                            }}/{{ lesson_course.max_seat }})
                                        </div>
                                    </div>
                                </div>
                                <Link
                                    v-if="
                                        lesson_course.total_applied !==
                                        lesson_course.max_seat
                                    "
                                    class="item__right"
                                    :href="
                                        route('course.apply', lesson_course.id)
                                    "
                                    >Apply</Link
                                >
                                <div v-else class="item_full-right-btn">
                                    full
                                </div>
                            </div>
                            <span
                                class="showMore"
                                @click="showMoreSchedule"
                                v-show="
                                    detailForm.scheduleShow <
                                    validCourses(props.lesson_courses).length
                                "
                                >{{
                                    lang().label.lesson_detail.show_more
                                }}</span
                            >
                        </div>
                        <div class="note">
                            <p class="subTitle">
                                {{ lang().label.lesson_detail.lesson_outline }}
                            </p>
                            <p
                                class="description"
                                :class="{ fullText: detailForm.moreExperience }"
                            >
                                In this art club for animal...
                            </p>
                            <span class="showMore">{{
                                lang().label.lesson_detail.show_more
                            }}</span>
                        </div>
                        <div class="note">
                            <p class="subTitle">
                                {{
                                    lang().label.lesson_detail.teacher_expertise
                                }}
                            </p>
                            <p
                                class="description"
                                :class="{ fullText: detailForm.moreExperience }"
                            >
                                {{ props.lessons.teacher_experience }}
                            </p>
                            <span
                                class="showMore"
                                @click="detailForm.moreExperience = true"
                                v-show="detailForm.moreExperience == false"
                                >{{
                                    lang().label.lesson_detail.show_more
                                }}</span
                            >
                            <span
                                class="showMore"
                                @click="detailForm.moreExperience = false"
                                v-show="detailForm.moreExperience"
                                >{{
                                    lang().label.lesson_detail.show_less
                                }}</span
                            >
                        </div>
                        <div class="note noTitle">
                            <p class="subTitle">
                                {{ lang().label.lesson_detail.additional_note }}
                            </p>
                            <p
                                class="description"
                                :class="{ fullText: detailForm.moreNote }"
                            >
                                {{ props.lessons.note }}
                            </p>
                            <span
                                class="showMore"
                                @click="detailForm.moreNote = true"
                                v-show="detailForm.moreNote == false"
                                >{{
                                    lang().label.lesson_detail.show_more
                                }}</span
                            >
                            <span
                                class="showMore"
                                @click="detailForm.moreNote = false"
                                v-show="detailForm.moreNote"
                                >{{
                                    lang().label.lesson_detail.show_less
                                }}</span
                            >
                        </div>
                        <div class="reviewWrap">
                            <p class="subTitle">
                                {{ lang().label.lesson_detail.reviews }}
                            </p>
                            <div
                                class="item"
                                v-for="review in props.reviews.slice(
                                    0,
                                    detailForm.reviewShow
                                )"
                            >
                                <div class="time">{{ review.created_at }}</div>
                                <div class="author">
                                    <div class="author__left">
                                        <div class="avatar">
                                            <img
                                                :src="review.user.avatar"
                                                alt=""
                                            />
                                        </div>
                                        <p>
                                            {{ review.user.first_name }}
                                            {{ review.user.last_name }}
                                        </p>
                                    </div>
                                    <div class="author__right">
                                        <Stars
                                            :stars="reviewRating(review).toFixed(1)"
                                            bg-star="#B1B1B1"
                                        />
                                        <p
                                            style="
                                                margin-left: 2px;
                                                font-size: 12px;
                                                font-weight: 400;
                                                line-height: 160%;
                                            "
                                        >
                                            {{ reviewRating(review).toFixed(1) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="content">
                                    <p
                                        class="description"
                                        :id="'reviewNumber' + review.id"
                                    >
                                        {{ review.review }}
                                    </p>
                                    <span
                                        class="showMore"
                                        @click="showFullReview(review.id)"
                                        :id="'showMoreNumber' + review.id"
                                        >{{
                                            lang().label.lesson_detail.show_more
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>
                        <span
                            class="showMore"
                            @click="showMoreReview"
                            v-show="
                                detailForm.reviewShow <= props.reviews.length
                            "
                            >{{ lang().label.lesson_detail.show_more }}</span
                        >
                        <div
                            class="lesson__detail-button-wrap"
                            v-if="
                                usePage().props.auth.user?.id ==
                                    props.teacher?.id &&
                                usePage().props.auth.user?.role == 2
                            "
                        >
                            <div
                                class="lesson__detail-button-red"
                                @click="handleDeleteLesson"
                            >
                                レッスンの公開停止する
                            </div>
                            <div
                                class="lesson__detail-button-red"
                                @click="handleSuspendLesson"
                            >
                                レッスンの公開停止する
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <Modal :showModal="formVideo.isOpen" @close="formVideo.isOpen = false">
            <div class="videoShow">
                <video
                    :src="props.lessons.short_video_for_parent"
                    controls
                    v-if="formVideo.role == 'parent'"
                ></video>
                <video
                    :src="props.lessons.short_video_for_learner"
                    controls
                    v-if="formVideo.role == 'child'"
                ></video>
            </div>
        </Modal>
        <Modal
            :show-modal="openDialogDeleteLesson"
            @close="openDialogDeleteLesson = false"
            v-if="
                usePage().props.auth.user?.id == props.teacher?.id &&
                usePage().props.auth.user?.role == 2
            "
        >
            <div class="lesson__detail-delete-modal-wrap">
                <div class="lesson__detail-delete-modal-title">
                    Definitely delete this lesson?
                </div>
                <div class="lesson__detail-delete-modal-subtitle">
                    Lesson will be deleted
                </div>
                <div class="d-flex lesson__detail-delete-modal-btn">
                    <ButtonDeleteRequest
                        :label="'キャンセル'"
                        @click="openDialogDeleteLesson = false"
                    />
                    <Link
                        :href="route('delete.lesson', props.lessons?.id)"
                        method="delete"
                    >
                        <ButtonDeleteRequest
                            :label="'削除する'"
                            :submit-button="true"
                        />
                    </Link>
                </div>
            </div>
        </Modal>
        <Modal
            :show-modal="openDialogSuspendLesson"
            @close="openDialogSuspendLesson = false"
            v-if="
                usePage().props.auth.user?.id == props.teacher?.id &&
                usePage().props.auth.user?.role == 2
            "
        >
            <div class="lesson__detail-delete-modal-wrap">
                <div class="lesson__detail-delete-modal-title">
                    Definitely suspend this lesson?
                </div>
                <div class="lesson__detail-delete-modal-subtitle">
                    Lesson will be suspended
                </div>
                <div class="d-flex lesson__detail-delete-modal-btn">
                    <ButtonDeleteRequest
                        :label="'キャンセル'"
                        @click="openDialogSuspendLesson = false"
                    />
                    <Link
                        :href="route('suspend.lesson', props.lessons?.id)"
                        method="post"
                    >
                        <ButtonDeleteRequest
                            :label="'削除する'"
                            :submit-button="true"
                            @click="openDialogSuspendLesson = false"
                        />
                    </Link>
                </div>
            </div>
        </Modal>
    </Layout>
</template>
<style scoped lang="scss">
@import "./_lesson.scss";

.detailLesson {
    .form__wrap {
        .news {
            .description {
                // word-break: break-all;
            }
        }
        .note {
            .description {
                // word-break: break-all;
            }
        }
    }
}
.schedule {
    .item {
        .item__left {
            .top {
                .show-button {
                    cursor: pointer;
                }
            }
            .time {
                gap: 4px;
            }
        }
    }
}
.lesson__detail-delete-modal-wrap {
    width: 100%;
    min-width: 368px;
}
@media all and (max-width: 768px) {
    .lesson__detail-delete-modal-wrap {
        min-width: 311px;
    }
}
.lesson__detail-button-wrap {
    width: 100% !important;
    gap: 10px;
    button {
        width: 100%;
    }
    .lesson__detail-button-red {
        color: #e71a41;
        text-decoration: underline;
        padding: 16px;
        margin: 16px 32px 0px;
        cursor: pointer;
        font-size: 14px;
        text-align: center;
    }
}
.item__right {
    color: white;
}
.item__full {
    background-color: #e1eff2 !important;
    color: #7f7f7f !important;
}
.item_full-right-btn {
    font-weight: 700;
}
.lesson__detail-delete-modal-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 16px;
    line-height: 1.6;
    text-align: center;
}
.lesson__detail-delete-modal-subtitle {
    font-size: 14px;
    line-height: 1.6;
    text-align: center;
}
.lesson__detail-delete-modal-btn {
    gap: 10px;
    a {
        width: 100%;
    }
}
.lesson__detail-schedule {
    .lesson__detail-schedule-day {
        width: 90px;
    }
    .lesson__detail-schedule-time {
        margin-right: 2px;
    }
    img {
        margin-right: 4px;
    }
    .lesson__detail-schedule-no-check {
        width: 24px;
        height: 20px;
    }
}
</style>
