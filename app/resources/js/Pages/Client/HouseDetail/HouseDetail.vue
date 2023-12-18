<script setup>
import { ref } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import moment from "moment";
import { houseRating } from "@/Helper/Rating";
import Layout from "@/Layouts/Layout.vue";
import LayoutDashBoard from "@/Layouts/LayoutDashboard.vue";
import Modal from "@/Components/Modal/Modal.vue";
import ButtonDeleteRequest from "@/Components/Request/ButtonDeleteRequest.vue";
import Stars from "@/Components/Rating/Stars.vue";
import ModalSignup from "@/Components/Modal/ModalSignup.vue";
import ShareSocial from "@/Components/Common/ShareSocial.vue";
import Dialog from "@/Components/Dialog/Dialog.vue";
import BaseCard from "@/Components/Teacher/Common/BaseCard.vue";
import { socialItems } from "@/Helper/shareSocial.js";

const props = defineProps({
    house: Object,
    rooms: Array,
    reviews: Array,
});

const formVideo = useForm({
    isOpen: false,
    role: "",
});
const formReason = useForm({
    reason: ''
});
const detailForm = useForm({
    scheduleShow: 4,
    reviewShow: 1,
    moreNote: false,
    moreExperience: false,
    moreDescription: false,
    moreContent: false,
    morePreparation: false,
});

const formUrlIntended = useForm({
    url: "",
});

const rating = houseRating(props.house);
const openDialogSuspendLesson = ref(false);
const showTime = ref([]);
const openDialogDeleteLesson = ref(false);
const isOpenPopupLogin = ref(false);
const showShortVideo = () => {
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

const totalTime = (start_date_time, end_date_time) => {
    const start = moment.utc(start_date_time);
    const end = moment.utc(end_date_time);
    return [
        moment.duration(end.diff(start))._data.hours,
        moment.duration(end.diff(start))._data.minutes,
    ];
};

const handleShowMoreTime = (index) => {
    if (!showTime.value.includes(index)) {
        showTime.value.push(index);
    } else {
        showTime.value = showTime.value.filter((num) => num !== index);
    }
    // showTime.value = showTime.value === index ? null : index;
};

const handleDeleteLesson = () => {
    openDialogDeleteLesson.value = true;
};

const handleSuspendLesson = () => {
    openDialogSuspendLesson.value = true;
};

const validCourses = (courses) => {
    let validCourse = courses;
    if (usePage().props.auth?.user?.role === 'LESSEE' || !usePage().props.auth?.user) {
        validCourse = courses.filter(
            (item) =>
                moment(item.start_date_time)
                    .subtract(item.deadline, "days")
                    .format("YYYY-MM-DD") >= moment().format("YYYY-MM-DD")
        );
    }

    validCourse.sort(function (a, b) {
        return moment(a.start_date_time) - moment(b.start_date_time);
    });

    return validCourse;
};

const checkExpired = (endDateTime) => {
    const currentDate = moment();
    const expiredTime = moment(`${endDateTime}`, "YYYY-MM-DD HH:mm");
    if (currentDate.isBefore(expiredTime)) {
        return false;
    } else if (
        currentDate.isSame(expiredTime, "minute") ||
        currentDate.isAfter(expiredTime)
    ) {
        return true;
    } else {
        return false;
    }
};

const handleTogglePopupSignin = (url) => {
    formUrlIntended.url = url;
    formUrlIntended.post(route("url.intended.create"));
    isOpenPopupLogin.value = !isOpenPopupLogin.value;
};

const isOpenShareSocial = ref(false);
const handleShareSocial = () => {
    isOpenShareSocial.value = true;
};
const currentUrl = window.location.href;

const currencySymbol = (currencyId) => {
    let symbol = null;
    switch (currencyId) {
        case '1':
            symbol = '$';
            break;
        case '3':
            symbol = '₫';
            break;
        case '2':
        default:
            symbol = '¥';
    }

    return symbol;
}

//total lesson's applied
const totalApplied = (lesson) => {
    let count = 0
    for (let i = 0; i < lesson?.course?.length; i++) {
        for (let j = 0; j < lesson?.course[i].course_applications.length; j++) {
            if (lesson?.course[i].course_applications[j].status == 1) {
                count += lesson?.course[i].course_applications[j].application_details.length
            }
        }
    }

    return lesson.course?.length ? Math.ceil(count/lesson.course.length) : 0;
}

const classDetail = (type) => {
    let symbol = null
    switch (type) {
        case '2':
            symbol = "1on1";
            break;
        default:
            symbol = "グループレッスン";
    }
    return symbol;
}

const recommendGradeData = (type) => {
    let symbol = null
    switch (type) {
        case '2':
            symbol = "小学5年生";
            break;
        case '3':
            symbol = "小学6年生";
            break;
        case '4':
            symbol = "中学1年生";
            break;
        case '5':
            symbol = "中学2年生";
            break;
        case '6':
            symbol = "中学3年生";
            break;
        default:
            symbol = "小学4年生";
    }
    return symbol;
}

const levelLesson = (type) => {
    let symbol = null
    switch (type) {
        case '2':
            symbol = "中級";
            break;
        case '3':
            symbol = "上級";
            break;
        default:
            symbol = "初級";
    }
    return symbol;
}

</script>

<template>
    <div>
        <Layout v-if="usePage().props.auth.user?.role != 2">
            <main class="detailLesson">
                <div class="container">
                    <div class="form">
                        <div class="form__wrap">
                            <div class="news w-full">
                                <a href="" class="image">
                                    <img :src="props.lessons.cover_image" />
                                </a>
                                <div
                                    class="d-flex align-items-center justify-content-between"
                                    style="height: 40px"
                                >
                                    <div
                                        class="d-flex align-items-center"
                                        style="
                                            color: #418997;
                                            gap: 4px;
                                            cursor: pointer;
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 16 16"
                                            fill="none"
                                        >
                                            <path
                                                d="M14.5001 2C14.5001 1.86739 14.4474 1.74021 14.3536 1.64645C14.2598 1.55268 14.1327 1.5 14.0001 1.5C11.2451 1.5 8.41818 4.60687 6.84818 6.66437C6.28747 6.49265 5.69431 6.45482 5.11633 6.55392C4.53835 6.65302 3.99167 6.88629 3.52019 7.23499C3.04872 7.58369 2.66559 8.0381 2.40158 8.56172C2.13758 9.08535 2.00005 9.66359 2.00005 10.25C2.00005 12.18 0.778804 13.0456 0.720679 13.0856C0.631985 13.1455 0.564847 13.2323 0.52914 13.3332C0.493432 13.4341 0.491038 13.5437 0.52231 13.6461C0.553582 13.7485 0.61687 13.8381 0.702867 13.9018C0.788864 13.9655 0.893032 13.9999 1.00005 14H5.75005C6.33647 14 6.91471 13.8625 7.43833 13.5985C7.96195 13.3345 8.41637 12.9513 8.76506 12.4799C9.11376 12.0084 9.34703 11.4617 9.44613 10.8837C9.54523 10.3057 9.5074 9.71258 9.33568 9.15187C11.3938 7.58187 14.5001 4.755 14.5001 2ZM5.75005 13H2.16443C2.5863 12.4006 3.00005 11.495 3.00005 10.25C3.00005 9.7061 3.16134 9.17442 3.46351 8.72218C3.76569 8.26995 4.19518 7.91747 4.69767 7.70933C5.20017 7.50119 5.7531 7.44673 6.28655 7.55284C6.82 7.65895 7.31 7.92086 7.6946 8.30546C8.07919 8.69005 8.3411 9.18005 8.44721 9.7135C8.55332 10.247 8.49886 10.7999 8.29072 11.3024C8.08258 11.8049 7.73011 12.2344 7.27787 12.5365C6.82564 12.8387 6.29395 13 5.75005 13ZM7.7763 7.09688C7.99047 6.81938 8.20068 6.55792 8.40693 6.3125C8.91176 6.65357 9.34649 7.0883 9.68755 7.59312C9.44172 7.79896 9.18026 8.00917 8.90318 8.22375C8.61181 7.77238 8.22767 7.38824 7.7763 7.09688ZM10.4451 6.92938C10.0676 6.39675 9.60268 5.93185 9.07005 5.55438C11.0563 3.39625 12.5544 2.74187 13.4388 2.56C13.2607 3.445 12.6032 4.94313 10.4451 6.92938Z"
                                                fill="#418997"
                                            />
                                        </svg>
                                        <div>Art</div>
                                    </div>
                                    <div class="share-social-popup">
                                        <div
                                            style="cursor: pointer"
                                            @click="handleShareSocial"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                            >
                                                <path
                                                    d="M16.5002 15.0001C15.9999 14.9999 15.5047 15.1001 15.0438 15.2948C14.5829 15.4895 14.1658 15.7747 13.8171 16.1335L9.49522 13.3557C9.83519 12.4839 9.83519 11.5162 9.49522 10.6444L13.8171 7.86664C14.4663 8.53162 15.3392 8.93187 16.2668 8.98979C17.1943 9.0477 18.1103 8.75915 18.8371 8.18009C19.564 7.60102 20.0499 6.77269 20.2007 5.85569C20.3516 4.93869 20.1565 3.99835 19.6534 3.21698C19.1503 2.43562 18.375 1.86889 17.4778 1.62668C16.5806 1.38447 15.6254 1.48403 14.7975 1.90606C13.9695 2.32809 13.3277 3.04252 12.9966 3.91085C12.6655 4.77917 12.6685 5.73951 13.0052 6.6057L8.68335 9.38351C8.16291 8.84921 7.49496 8.48224 6.76489 8.32952C6.03481 8.1768 5.27578 8.24527 4.58481 8.52617C3.89385 8.80707 3.30235 9.28764 2.88592 9.90645C2.4695 10.5253 2.24707 11.2542 2.24707 12.0001C2.24707 12.746 2.4695 13.4749 2.88592 14.0937C3.30235 14.7125 3.89385 15.1931 4.58481 15.474C5.27578 15.7549 6.03481 15.8233 6.76489 15.6706C7.49496 15.5179 8.16291 15.1509 8.68335 14.6166L13.0052 17.3944C12.7157 18.1412 12.6729 18.961 12.883 19.7339C13.0931 20.5067 13.5451 21.192 14.1729 21.6894C14.8006 22.1867 15.5712 22.47 16.3716 22.4978C17.172 22.5256 17.9603 22.2964 18.621 21.8437C19.2818 21.3911 19.7802 20.7388 20.0434 19.9823C20.3066 19.2259 20.3206 18.4051 20.0836 17.64C19.8465 16.875 19.3707 16.206 18.7259 15.731C18.0811 15.2559 17.3011 14.9998 16.5002 15.0001ZM16.5002 3.00007C16.9452 3.00007 17.3802 3.13203 17.7503 3.37927C18.1203 3.6265 18.4087 3.9779 18.579 4.38904C18.7493 4.80017 18.7938 5.25257 18.707 5.68903C18.6202 6.12548 18.4059 6.5264 18.0912 6.84106C17.7765 7.15573 17.3756 7.37002 16.9392 7.45684C16.5027 7.54366 16.0503 7.4991 15.6392 7.3288C15.2281 7.15851 14.8767 6.87012 14.6294 6.50011C14.3822 6.1301 14.2502 5.69508 14.2502 5.25007C14.2502 4.65334 14.4873 4.08104 14.9092 3.65908C15.3312 3.23713 15.9035 3.00007 16.5002 3.00007ZM6.00023 14.2501C5.55522 14.2501 5.1202 14.1181 4.75019 13.8709C4.38018 13.6236 4.09179 13.2722 3.9215 12.8611C3.7512 12.45 3.70664 11.9976 3.79346 11.5611C3.88028 11.1247 4.09457 10.7238 4.40924 10.4091C4.7239 10.0944 5.12481 9.88012 5.56127 9.79331C5.99773 9.70649 6.45013 9.75105 6.86126 9.92134C7.2724 10.0916 7.6238 10.38 7.87103 10.75C8.11827 11.1201 8.25023 11.5551 8.25023 12.0001C8.25023 12.5968 8.01317 13.1691 7.59122 13.5911C7.16926 14.013 6.59696 14.2501 6.00023 14.2501ZM16.5002 21.0001C16.0552 21.0001 15.6202 20.8681 15.2502 20.6209C14.8802 20.3736 14.5918 20.0222 14.4215 19.6111C14.2512 19.2 14.2066 18.7476 14.2935 18.3111C14.3803 17.8747 14.5946 17.4738 14.9092 17.1591C15.2239 16.8444 15.6248 16.6301 16.0613 16.5433C16.4977 16.4565 16.9501 16.501 17.3613 16.6713C17.7724 16.8416 18.1238 17.13 18.371 17.5C18.6183 17.8701 18.7502 18.3051 18.7502 18.7501C18.7502 19.3468 18.5132 19.9191 18.0912 20.3411C17.6693 20.763 17.097 21.0001 16.5002 21.0001Z"
                                                    fill="#1B1B1B"
                                                />
                                            </svg>
                                        </div>
                                        <Dialog
                                            :show-dialog="isOpenShareSocial"
                                            @close-dialog="
                                                isOpenShareSocial = false
                                            "
                                        >
                                            <div
                                                class="share-social-select d-flex flex-column"
                                            >
                                                <div
                                                    class="share-social-select-title"
                                                >
                                                    シェアする
                                                </div>
                                                <ShareSocial
                                                    :label="'Xに共有'"
                                                    :social="'twitter'"
                                                    :url="currentUrl"
                                                    :title="props.lessons.title"
                                                    :description="
                                                        props.lessons
                                                            .short_description_for_parent
                                                    "
                                                />
                                                <ShareSocial
                                                    :label="'Facebookに共有'"
                                                    :social="'facebook'"
                                                    :url="currentUrl"
                                                    :title="props.lessons.title"
                                                    :description="
                                                        props.lessons
                                                            .short_description_for_parent
                                                    "
                                                />
                                                <ShareSocial
                                                    :label="'LINEに共有'"
                                                    :social="'line'"
                                                    :url="currentUrl"
                                                    :title="props.lessons.title"
                                                    :description="
                                                        props.lessons
                                                            .short_description_for_parent
                                                    "
                                                />
                                                <ShareSocial
                                                    :label="'copy'"
                                                    :url-copy="currentUrl"
                                                />
                                            </div>
                                        </Dialog>
                                    </div>
                                </div>
                                <div class="author__right mt-2">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="14"
                                        height="14"
                                        viewBox="0 0 14 14"
                                        fill="none"
                                    >
                                        <path
                                            d="M12.8242 6.25505L10.3578 8.40755L11.0966 11.6122C11.1357 11.7798 11.1246 11.9551 11.0646 12.1163C11.0046 12.2776 10.8983 12.4175 10.7592 12.5187C10.6201 12.6199 10.4542 12.6778 10.2824 12.6853C10.1105 12.6927 9.94024 12.6493 9.79289 12.5605L6.99781 10.8652L4.20875 12.5605C4.06141 12.6493 3.89115 12.6927 3.71928 12.6853C3.54741 12.6778 3.38154 12.6199 3.24242 12.5187C3.10329 12.4175 2.99709 12.2776 2.93707 12.1163C2.87706 11.9551 2.8659 11.7798 2.905 11.6122L3.64273 8.41083L1.17578 6.25505C1.0453 6.14251 0.950951 5.99396 0.904562 5.82802C0.858172 5.66208 0.861809 5.48613 0.915016 5.32225C0.968223 5.15836 1.06863 5.01384 1.20365 4.90679C1.33867 4.79974 1.50229 4.73494 1.67398 4.72052L4.9257 4.43888L6.195 1.41138C6.26128 1.25252 6.37309 1.11682 6.51634 1.02138C6.65958 0.925929 6.82787 0.875 7 0.875C7.17213 0.875 7.34042 0.925929 7.48366 1.02138C7.62691 1.11682 7.73872 1.25252 7.805 1.41138L9.07812 4.43888L12.3288 4.72052C12.5005 4.73494 12.6641 4.79974 12.7991 4.90679C12.9341 5.01384 13.0345 5.15836 13.0877 5.32225C13.1409 5.48613 13.1446 5.66208 13.0982 5.82802C13.0518 5.99396 12.9574 6.14251 12.827 6.25505H12.8242Z"
                                            fill="#418997"
                                        />
                                    </svg>
                                    <p>
                                        <span>{{ rating.toFixed(1) }}</span> ({{
                                            props.lessons.review?.length
                                        }})
                                    </p>
                                </div>
                                <div class="title">
                                    {{ props.lessons.title }}
                                </div>
                                <div class="author">
                                    <a
style="color:black" :href="route('teacher.profile', props.teacher
                                                            .teacher_information?.teacher_id)">
                                        <div class="author__left">
                                            <div class="avatar">
                                                <img
                                                    :src="
                                                        props.teacher
                                                            .teacher_information
                                                            ?.profile_image ||
                                                        '/img/icon/iconAvatarDefault.svg'
                                                    "
                                                    alt=""
                                                />
                                            </div>
                                            <p>
                                                {{ props.teacher.first_name }}
                                                {{ props.teacher.last_name }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <p
                                    class="description"
                                    :class="{
                                        fullText: detailForm.moreContent,
                                    }"
                                >
                                    {{ props.lessons.class_description }}
                                </p>
                                <span
                                    v-show="detailForm.moreContent == false && props.lessons.class_description?.length >= 50"
                                    class="showMore"
                                    @click="detailForm.moreContent = true"
                                >{{
                                        lang().label.lesson_detail.show_more
                                    }}</span
                                >
                                <span
                                    v-show="detailForm.moreContent"
                                    class="showMore"
                                    @click="detailForm.moreContent = false"
                                >{{
                                        lang().label.lesson_detail.show_less
                                    }}</span
                                >
                            </div>
                            <div class="attributes">
                                <ul>
                                    <li>
                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">
                                            {{
                                                currencySymbol(props.lessons?.currency)
                                            }}{{
                                                props.lessons?.price?.toLocaleString()
                                            }}
                                        </span>
                                        <p>
                                            {{
                                                lang().label.lesson_detail.field
                                                    .price
                                            }}
                                        </p>
                                    </li>
                                    <li>
                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">
                                            {{ props.lessons.target_age_from }}
                                            ~
                                            {{
                                                props.lessons.target_age_to
                                            }}歳</span
                                        >
                                        <p>
                                            {{
                                                lang().label.lesson_detail.field
                                                    .ages
                                            }}
                                        </p>
                                    </li>
                                    <!-- <li>
                                    <span
                                        >
                                        {{ props.lessons.class_capacity }}</span
                                    >
                                    <p>
                                        {{
                                            lang().label.lesson_detail.field
                                                .learners
                                        }}
                                    </p>
                                </li> -->
                                    <!-- <li>
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
                                </li> -->
                                    <li>
                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">{{ classDetail(props.lessons.class_detail) }}</span>
                                        <!-- <span>{{ totalApplied(props.lessons) }}/{{ props.lessons.class_capacity }}名</span> -->
                                        <p>
                                            {{
                                                lang().label.lesson_detail.field
                                                    .type
                                            }}
                                        </p>
                                    </li>
                                    <li>
                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">
                                            {{ recommendGradeData(props.lessons.recommend_grade) }}
                                        </span>
                                        <p>
                                            {{
                                                lang().label.lesson_detail.field
                                                    .recommend
                                            }}
                                        </p>
                                    </li>
                                    <li>
                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">
                                            {{ levelLesson(props.lessons.level) }}
                                        </span>
                                        <p>
                                            {{
                                                lang().label.lesson_detail.field
                                                    .level
                                            }}
                                        </p>
                                    </li>
                                    <li>
                                        <span
                                            v-if="props.lessons.language == 1"
                                            style="height: 34px" class="d-flex align-items-center justify-content-center"
                                        >日本語</span
                                        >
                                        <span
                                            v-if="props.lessons.language == 2"
                                            style="height: 34px" class="d-flex align-items-center justify-content-center"
                                        >英語</span
                                        >
                                        <span
                                            v-if="props.lessons.language == 3"
                                            style="height: 34px" class="d-flex align-items-center justify-content-center"
                                        >ベトナム語</span
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
                            <div class="d-flex w-full category-wrap">
                                <BaseCard
                                    class="category-info d-flex flex-column align-items-center justify-content-center"
                                >
                                    <div class="category-info-title d-flex align-items-center justify-content-center" style="height: 34px">
                                        {{ props.lessons.class_repeat == 2 ? "月1回" : "月" + props.lessons.number_of_meets + "回" }}
                                    </div>
                                    <div class="category-info-content">
                                        {{
                                            lang().label.lesson_detail.field
                                                .schedule
                                        }}
                                    </div>
                                </BaseCard>
                                <BaseCard
                                    class="category-info d-flex flex-column align-items-center justify-content-center"
                                >
                                    <div class="category-info-title d-flex align-items-center justify-content-center" style="height: 34px">
                                        <div
                                            v-if="
                                                props.lessons.lesson_hour !== 0
                                            "
                                        >
                                            {{ props.lessons.lesson_hour }}時
                                        </div>
                                        <div>
                                            {{ props.lessons.lesson_minute }}分
                                        </div>
                                    </div>
                                    <div class="category-info-content">
                                        {{
                                            lang().label.lesson_detail.field
                                                .time
                                        }}
                                    </div>
                                </BaseCard>
                            </div>
                            <div class="videoWarp">
                                <!-- <div class="item">
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
                            </div> -->
                                <div class="item">
                                    <p class="subTitle">
                                        {{ lang().label.lesson_detail.for_kid }}
                                    </p>
                                    <div class="video" @click="showShortVideo">
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
                                    v-for="lesson_course in validCourses(
                                        props.lesson_courses
                                    ).slice(0, detailForm.scheduleShow)"
                                    :key="lesson_course.id"
                                >
                                    <div class="item">
                                        <div class="item__left">
                                            <div
                                                style="
                                                    font-size: 12px;
                                                    font-weight: 700;
                                                    line-height: 1.6;
                                                "
                                            >
                                                {{ lesson_course.title }}
                                            </div>
                                            <div class="top mt-1">
                                                <div class="date">
                                                    {{
                                                        moment(
                                                            lesson_course.start_date_time
                                                        ).format("YYYY/MM/DD")
                                                    }}
                                                </div>
                                                <div class="time d-flex">
                                                    <div>
                                                        {{
                                                            moment(lesson_course.start_date_time).format('HH:mm')
                                                        }}
                                                        ~
                                                        {{
                                                            moment(lesson_course.end_date_time).format('HH:mm')
                                                        }}
                                                        (<span
                                                        v-if="
                                                                totalTime(
                                                                    lesson_course.start_date_time,
                                                                    lesson_course.end_date_time
                                                                )[0] > 0
                                                            "
                                                    >{{
                                                            totalTime(
                                                                lesson_course.start_date_time,
                                                                lesson_course.end_date_time
                                                            )[0]
                                                        }}h
                                                        </span>
                                                        <span
                                                        >{{
                                                                totalTime(
                                                                    lesson_course.start_date_time,
                                                                    lesson_course.end_date_time
                                                                )[1]
                                                            }}m</span
                                                        >)
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                v-if="lesson_course.total_applied != lesson_course.max_seat"
                                                class="bottom mt-1 align-items-center"
                                                style="padding-top: 0px"
                                            >
                                                <div class="seats">
                                                    {{
                                                        lang().label
                                                            .lesson_detail
                                                            .available_seats
                                                    }}
                                                    {{
                                                        lesson_course.max_seat -
                                                        lesson_course.total_applied
                                                    }}
                                                    {{
                                                        lang().label
                                                            .lesson_detail
                                                            .seats
                                                    }}
                                                </div>
                                                <div class="count">
                                                    ({{
                                                        lesson_course.total_applied
                                                    }}/{{
                                                        lesson_course.max_seat
                                                    }})
                                                </div>
                                            </div>
                                            <div
                                                v-if="lesson_course.total_applied == lesson_course.max_seat"
                                                class="bottom mt-1 align-items-center"
                                                style="padding-top: 0px"
                                            >
                                                <div class="seats" style="color: #e71a41">満席</div>
                                                <div class="count">
                                                    ({{
                                                        lesson_course.total_applied
                                                    }}/{{
                                                        lesson_course.max_seat
                                                    }})
                                                </div>
                                            </div>
                                            <div
                                                v-for="schedule in lesson_course.course_schedules"
                                                :key="schedule"
                                                class="mt-2"
                                            >
                                                <div
                                                    v-if="
                                                        showTime.includes(
                                                            lesson_course.id
                                                        )
                                                    "
                                                    class="d-flex align-items-center lesson__detail-schedule"
                                                >
                                                    <img
                                                        v-if="
                                                            checkExpired(
                                                                schedule.end_date_time
                                                            )
                                                        "
                                                        src="/img/icon/check.svg"
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
                                                                schedule?.start_date_time
                                                            ).format(
                                                                "ddd YYYY/MM/DD"
                                                            )
                                                        }}
                                                    </div>
                                                    <div>・</div>
                                                    <div
                                                        class="lesson__detail-schedule-time"
                                                    >
                                                        {{
                                                            moment(schedule?.start_date_time).format('HH:mm')
                                                        }}
                                                        -
                                                        {{ moment(schedule?.end_date_time).format('HH:mm') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                v-if="lesson_course.course_schedules.length > 1"
                                                class="show-button"
                                                @click="
                                                    handleShowMoreTime(
                                                        lesson_course.id
                                                    )
                                                "
                                            >
                                                <div
                                                    v-if="
                                                        showTime.includes(
                                                            lesson_course.id
                                                        )
                                                    "
                                                    style="
                                                        color: #418997;
                                                        font-size: 12px;
                                                        text-decoration-line: underline;
                                                        cursor: pointer;
                                                    "
                                                >
                                                    閉じる
                                                </div>
                                                <div
                                                    v-else
                                                    style="
                                                        color: #418997;
                                                        font-size: 12px;
                                                        text-decoration-line: underline;
                                                        cursor: pointer;
                                                    "
                                                >
                                                    他の日程をみる
                                                </div>
                                            </div>
                                        </div>
                                        <Link
                                            v-if="
                                                lesson_course.total_applied !==
                                                    lesson_course.max_seat &&
                                                usePage().props.auth.user &&
                                                props.lessons.teacher_id !== usePage().props.auth.user.id
                                            "
                                            class="item__right"
                                            :href="
                                                route(
                                                    'course.apply',
                                                    lesson_course.id
                                                )
                                            "
                                        >
{{
                                                lang().label.lesson_detail.apply
                                            }}
</Link
                                        >
                                        <div
                                            v-if="
                                                lesson_course.total_applied !==
                                                    lesson_course.max_seat &&
                                                !usePage().props.auth.user
                                            "
                                            class="item__right pointer"
                                            @click="
                                                handleTogglePopupSignin(
                                                    route(
                                                        'course.apply',
                                                        lesson_course.id
                                                    )
                                                )
                                            "
                                        >
                                            {{
                                                lang().label.lesson_detail.apply
                                            }}
                                        </div>
                                        <div
                                            v-if="
                                                lesson_course.total_applied ===
                                                lesson_course.max_seat
                                            "
                                            :class="{
                                                item__full:
                                                    lesson_course.total_applied ===
                                                    lesson_course.max_seat,
                                            }"
                                            class="item__right"
                                        >
                                            {{
                                                lang().label.lesson_detail.full
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <span
                                    v-show="
                                        detailForm.scheduleShow <
                                        validCourses(props.lesson_courses)
                                            .length
                                    "
                                    class="showMore show-more-button"
                                    @click="showMoreSchedule"
                                >{{
                                        lang().label.lesson_detail.show_more
                                    }}</span
                                >
                            </div>
                            <div class="note noTitle">
                                <p class="subTitle">
                                    {{
                                        lang().label.lesson_detail
                                            .lesson_outline
                                    }}
                                </p>
                                <p
                                    class="description"
                                    :class="{
                                        fullText: detailForm.moreDescription,
                                    }"
                                >
                                    {{
                                        props.lessons
                                            .short_description_for_parent
                                    }}
                                </p>
                                <span
                                    v-show="detailForm.moreDescription == false && props.lessons.short_description_for_parent?.length >= 50"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreDescription = true"
                                >{{
                                        lang().label.lesson_detail.show_more
                                    }}</span
                                >
                                <span
                                    v-show="detailForm.moreDescription"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreDescription = false"
                                >{{
                                        lang().label.lesson_detail.show_less
                                    }}</span
                                >
                            </div>
                            <div class="note">
                                <p class="subTitle">
                                    {{
                                        lang().label.lesson_detail
                                            .teacher_expertise
                                    }}
                                </p>
                                <p
                                    class="description"
                                    :class="{
                                        fullText: detailForm.moreExperience,
                                    }"
                                >
                                    {{ props.lessons.teacher_experience }}
                                </p>
                                <span
                                    v-show="detailForm.moreExperience == false && props.lessons.teacher_experience?.length >= 50"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreExperience = true"
                                >{{
                                        lang().label.lesson_detail.show_more
                                    }}</span
                                >
                                <span
                                    v-show="detailForm.moreExperience"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreExperience = false"
                                >{{
                                        lang().label.lesson_detail.show_less
                                    }}</span
                                >
                            </div>
                            <div class="note noTitle">
                                <p class="subTitle">
                                    addition note
                                </p>
                                <p
                                    class="description"
                                    :class="{ fullText: detailForm.moreNote }"
                                >
                                    prepare
                                </p>
                                <span
                                    v-show="detailForm.moreNote === false && props.lessons.preparation?.length >= 50"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreNote = true"
                                >
                                    show more
                                </span>
                                <span
                                    v-show="detailForm.moreNote"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreNote = false"
                                >
                                    Show less
                                </span>
                            </div>
                            <div class="reviewWrap">
                                <p class="subTitle">
                                    review
                                </p>
                                <div
                                    v-for="review in props.reviews.slice(
                                        0,
                                        detailForm.reviewShow
                                    )"
                                    class="item"
                                >
                                    <div class="time">
                                        {{ review.created_at }}
                                    </div>
                                    <div class="author">
                                        <div class="author__left">
                                            <div class="avatar">
                                                <img
                                                    :src="
                                                        review.user.avatar ||
                                                        '/img/icon/iconAvatarDefault.svg'
                                                    "
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
                                                :stars="
                                                    houseRating(
                                                        review
                                                    ).toFixed(1)
                                                "
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
                                                {{
                                                    houseRating(
                                                        review
                                                    ).toFixed(1)
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <p
                                            :id="'reviewNumber' + review.id"
                                            class="description"
                                        >
                                            {{ review.review }}
                                        </p>
                                        <span
                                            :id="'showMoreNumber' + review.id"
                                            class="showMore show-more-button"
                                            @click="showFullReview(review.id)"
                                        >{{
                                                lang().label.lesson_detail
                                                    .show_more
                                            }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                            <span
                                v-show="
                                    detailForm.reviewShow <=
                                    props.reviews.length
                                "
                                class="showMore show-more-button"
                                @click="showMoreReview"
                            >{{
                                    lang().label.lesson_detail.show_more
                                }}</span
                            >
                            <div
                                class="d-flex justify-content-center align-items-center footer-share-social mt-4"
                            >
                                <div
                                    v-for="socialItem in socialItems"
                                    :key="socialItem.label"
                                >
                                    <ShareSocial
                                        :social="socialItem.social"
                                        :url="currentUrl"
                                        :title="props.lessons.title"
                                        :description="
                                            props.lessons
                                                .short_description_for_parent
                                        "
                                    />
                                </div>
                                <ShareSocial :url-copy="currentUrl" />
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <ModalSignup
                :is-open="isOpenPopupLogin"
                @toggle="handleTogglePopupSignin"
            />
            <Modal
                :show-modal="formVideo.isOpen"
                @close="formVideo.isOpen = false"
            >
                <div class="videoShow">
                    <!-- <video
                    :src="props.lessons.short_video_for_parent"
                    controls
                    v-if="formVideo.role == 'parent'"
                ></video> -->
                    <video
                        v-if="formVideo.role == 'child'"
                        :src="props.lessons.short_video_for_learner"
                        controls
                        autoplay
                    ></video>
                </div>
            </Modal>
        </Layout>
        <LayoutDashBoard v-if="usePage().props.auth.user?.role == 2">
            <main class="detailLesson">
                <div class="container">
                    <div class="form">
                        <div class="form__wrap">
                            <div class="news w-full">
                                <a href="" class="image">
                                    <img :src="props.lessons.cover_image" />
                                </a>
                                <div
                                    class="d-flex align-items-center justify-content-between"
                                    style="height: 40px"
                                >
                                    <div
                                        class="d-flex align-items-center"
                                        style="
                                            color: #418997;
                                            gap: 4px;
                                            cursor: pointer;
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 16 16"
                                            fill="none"
                                        >
                                            <path
                                                d="M14.5001 2C14.5001 1.86739 14.4474 1.74021 14.3536 1.64645C14.2598 1.55268 14.1327 1.5 14.0001 1.5C11.2451 1.5 8.41818 4.60687 6.84818 6.66437C6.28747 6.49265 5.69431 6.45482 5.11633 6.55392C4.53835 6.65302 3.99167 6.88629 3.52019 7.23499C3.04872 7.58369 2.66559 8.0381 2.40158 8.56172C2.13758 9.08535 2.00005 9.66359 2.00005 10.25C2.00005 12.18 0.778804 13.0456 0.720679 13.0856C0.631985 13.1455 0.564847 13.2323 0.52914 13.3332C0.493432 13.4341 0.491038 13.5437 0.52231 13.6461C0.553582 13.7485 0.61687 13.8381 0.702867 13.9018C0.788864 13.9655 0.893032 13.9999 1.00005 14H5.75005C6.33647 14 6.91471 13.8625 7.43833 13.5985C7.96195 13.3345 8.41637 12.9513 8.76506 12.4799C9.11376 12.0084 9.34703 11.4617 9.44613 10.8837C9.54523 10.3057 9.5074 9.71258 9.33568 9.15187C11.3938 7.58187 14.5001 4.755 14.5001 2ZM5.75005 13H2.16443C2.5863 12.4006 3.00005 11.495 3.00005 10.25C3.00005 9.7061 3.16134 9.17442 3.46351 8.72218C3.76569 8.26995 4.19518 7.91747 4.69767 7.70933C5.20017 7.50119 5.7531 7.44673 6.28655 7.55284C6.82 7.65895 7.31 7.92086 7.6946 8.30546C8.07919 8.69005 8.3411 9.18005 8.44721 9.7135C8.55332 10.247 8.49886 10.7999 8.29072 11.3024C8.08258 11.8049 7.73011 12.2344 7.27787 12.5365C6.82564 12.8387 6.29395 13 5.75005 13ZM7.7763 7.09688C7.99047 6.81938 8.20068 6.55792 8.40693 6.3125C8.91176 6.65357 9.34649 7.0883 9.68755 7.59312C9.44172 7.79896 9.18026 8.00917 8.90318 8.22375C8.61181 7.77238 8.22767 7.38824 7.7763 7.09688ZM10.4451 6.92938C10.0676 6.39675 9.60268 5.93185 9.07005 5.55438C11.0563 3.39625 12.5544 2.74187 13.4388 2.56C13.2607 3.445 12.6032 4.94313 10.4451 6.92938Z"
                                                fill="#418997"
                                            />
                                        </svg>
                                        <div>Art</div>
                                    </div>
                                    <div class="share-social-popup">
                                        <div
                                            style="cursor: pointer"
                                            @click="handleShareSocial"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                            >
                                                <path
                                                    d="M16.5002 15.0001C15.9999 14.9999 15.5047 15.1001 15.0438 15.2948C14.5829 15.4895 14.1658 15.7747 13.8171 16.1335L9.49522 13.3557C9.83519 12.4839 9.83519 11.5162 9.49522 10.6444L13.8171 7.86664C14.4663 8.53162 15.3392 8.93187 16.2668 8.98979C17.1943 9.0477 18.1103 8.75915 18.8371 8.18009C19.564 7.60102 20.0499 6.77269 20.2007 5.85569C20.3516 4.93869 20.1565 3.99835 19.6534 3.21698C19.1503 2.43562 18.375 1.86889 17.4778 1.62668C16.5806 1.38447 15.6254 1.48403 14.7975 1.90606C13.9695 2.32809 13.3277 3.04252 12.9966 3.91085C12.6655 4.77917 12.6685 5.73951 13.0052 6.6057L8.68335 9.38351C8.16291 8.84921 7.49496 8.48224 6.76489 8.32952C6.03481 8.1768 5.27578 8.24527 4.58481 8.52617C3.89385 8.80707 3.30235 9.28764 2.88592 9.90645C2.4695 10.5253 2.24707 11.2542 2.24707 12.0001C2.24707 12.746 2.4695 13.4749 2.88592 14.0937C3.30235 14.7125 3.89385 15.1931 4.58481 15.474C5.27578 15.7549 6.03481 15.8233 6.76489 15.6706C7.49496 15.5179 8.16291 15.1509 8.68335 14.6166L13.0052 17.3944C12.7157 18.1412 12.6729 18.961 12.883 19.7339C13.0931 20.5067 13.5451 21.192 14.1729 21.6894C14.8006 22.1867 15.5712 22.47 16.3716 22.4978C17.172 22.5256 17.9603 22.2964 18.621 21.8437C19.2818 21.3911 19.7802 20.7388 20.0434 19.9823C20.3066 19.2259 20.3206 18.4051 20.0836 17.64C19.8465 16.875 19.3707 16.206 18.7259 15.731C18.0811 15.2559 17.3011 14.9998 16.5002 15.0001ZM16.5002 3.00007C16.9452 3.00007 17.3802 3.13203 17.7503 3.37927C18.1203 3.6265 18.4087 3.9779 18.579 4.38904C18.7493 4.80017 18.7938 5.25257 18.707 5.68903C18.6202 6.12548 18.4059 6.5264 18.0912 6.84106C17.7765 7.15573 17.3756 7.37002 16.9392 7.45684C16.5027 7.54366 16.0503 7.4991 15.6392 7.3288C15.2281 7.15851 14.8767 6.87012 14.6294 6.50011C14.3822 6.1301 14.2502 5.69508 14.2502 5.25007C14.2502 4.65334 14.4873 4.08104 14.9092 3.65908C15.3312 3.23713 15.9035 3.00007 16.5002 3.00007ZM6.00023 14.2501C5.55522 14.2501 5.1202 14.1181 4.75019 13.8709C4.38018 13.6236 4.09179 13.2722 3.9215 12.8611C3.7512 12.45 3.70664 11.9976 3.79346 11.5611C3.88028 11.1247 4.09457 10.7238 4.40924 10.4091C4.7239 10.0944 5.12481 9.88012 5.56127 9.79331C5.99773 9.70649 6.45013 9.75105 6.86126 9.92134C7.2724 10.0916 7.6238 10.38 7.87103 10.75C8.11827 11.1201 8.25023 11.5551 8.25023 12.0001C8.25023 12.5968 8.01317 13.1691 7.59122 13.5911C7.16926 14.013 6.59696 14.2501 6.00023 14.2501ZM16.5002 21.0001C16.0552 21.0001 15.6202 20.8681 15.2502 20.6209C14.8802 20.3736 14.5918 20.0222 14.4215 19.6111C14.2512 19.2 14.2066 18.7476 14.2935 18.3111C14.3803 17.8747 14.5946 17.4738 14.9092 17.1591C15.2239 16.8444 15.6248 16.6301 16.0613 16.5433C16.4977 16.4565 16.9501 16.501 17.3613 16.6713C17.7724 16.8416 18.1238 17.13 18.371 17.5C18.6183 17.8701 18.7502 18.3051 18.7502 18.7501C18.7502 19.3468 18.5132 19.9191 18.0912 20.3411C17.6693 20.763 17.097 21.0001 16.5002 21.0001Z"
                                                    fill="#1B1B1B"
                                                />
                                            </svg>
                                        </div>
                                        <Dialog
                                            :show-dialog="isOpenShareSocial"
                                            @close-dialog="
                                                isOpenShareSocial = false
                                            "
                                        >
                                            <div
                                                class="share-social-select d-flex flex-column"
                                            >
                                                <div
                                                    class="share-social-select-title"
                                                >
                                                    シェアする
                                                </div>
                                                <ShareSocial
                                                    :label="'Xに共有'"
                                                    :social="'twitter'"
                                                    :url="currentUrl"
                                                    :title="props.lessons.title"
                                                    :description="
                                                        props.lessons
                                                            .short_description_for_parent
                                                    "
                                                />
                                                <ShareSocial
                                                    :label="'Facebookに共有'"
                                                    :social="'facebook'"
                                                    :url="currentUrl"
                                                    :title="props.lessons.title"
                                                    :description="
                                                        props.lessons
                                                            .short_description_for_parent
                                                    "
                                                />
                                                <ShareSocial
                                                    :label="'LINEに共有'"
                                                    :social="'line'"
                                                    :url="currentUrl"
                                                    :title="props.lessons.title"
                                                    :description="
                                                        props.lessons
                                                            .short_description_for_parent
                                                    "
                                                />
                                                <ShareSocial
                                                    :label="'copy'"
                                                    :url-copy="currentUrl"
                                                />
                                            </div>
                                        </Dialog>
                                    </div>
                                </div>
                                <div class="author__right mt-2">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="14"
                                        height="14"
                                        viewBox="0 0 14 14"
                                        fill="none"
                                    >
                                        <path
                                            d="M12.8242 6.25505L10.3578 8.40755L11.0966 11.6122C11.1357 11.7798 11.1246 11.9551 11.0646 12.1163C11.0046 12.2776 10.8983 12.4175 10.7592 12.5187C10.6201 12.6199 10.4542 12.6778 10.2824 12.6853C10.1105 12.6927 9.94024 12.6493 9.79289 12.5605L6.99781 10.8652L4.20875 12.5605C4.06141 12.6493 3.89115 12.6927 3.71928 12.6853C3.54741 12.6778 3.38154 12.6199 3.24242 12.5187C3.10329 12.4175 2.99709 12.2776 2.93707 12.1163C2.87706 11.9551 2.8659 11.7798 2.905 11.6122L3.64273 8.41083L1.17578 6.25505C1.0453 6.14251 0.950951 5.99396 0.904562 5.82802C0.858172 5.66208 0.861809 5.48613 0.915016 5.32225C0.968223 5.15836 1.06863 5.01384 1.20365 4.90679C1.33867 4.79974 1.50229 4.73494 1.67398 4.72052L4.9257 4.43888L6.195 1.41138C6.26128 1.25252 6.37309 1.11682 6.51634 1.02138C6.65958 0.925929 6.82787 0.875 7 0.875C7.17213 0.875 7.34042 0.925929 7.48366 1.02138C7.62691 1.11682 7.73872 1.25252 7.805 1.41138L9.07812 4.43888L12.3288 4.72052C12.5005 4.73494 12.6641 4.79974 12.7991 4.90679C12.9341 5.01384 13.0345 5.15836 13.0877 5.32225C13.1409 5.48613 13.1446 5.66208 13.0982 5.82802C13.0518 5.99396 12.9574 6.14251 12.827 6.25505H12.8242Z"
                                            fill="#418997"
                                        />
                                    </svg>
                                    <p>
                                        <span>{{ rating.toFixed(1) }}</span> ({{
                                            props.lessons.review?.length
                                        }})
                                    </p>
                                </div>
                                <div class="title">
                                    {{ props.lessons.title }}
                                </div>
                                <div class="author">
                                    <a
style="color:black" :href="route('teacher.profile', props.teacher
                                                            .teacher_information?.teacher_id)">
                                        <div class="author__left">
                                            <div class="avatar">
                                                <img
                                                    :src="
                                                        props.teacher
                                                            .teacher_information
                                                            ?.profile_image ||
                                                        '/img/icon/iconAvatarDefault.svg'
                                                    "
                                                    alt=""
                                                />
                                            </div>
                                            <p>
                                                {{ props.teacher.first_name }}
                                                {{ props.teacher.last_name }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <p
                                    class="description"
                                    :class="{
                                        fullText: detailForm.moreContent,
                                    }"
                                >
                                    {{ props.lessons.class_description }}
                                </p>
                                <span
                                    v-show="detailForm.moreContent == false && props.lessons.class_description?.length >= 50"
                                    class="showMore"
                                    @click="detailForm.moreContent = true"
                                >{{
                                        lang().label.lesson_detail.show_more
                                    }}</span
                                >
                                <span
                                    v-show="detailForm.moreContent"
                                    class="showMore"
                                    @click="detailForm.moreContent = false"
                                >{{
                                        lang().label.lesson_detail.show_less
                                    }}</span
                                >
                            </div>
                            <div class="attributes">
                                <ul>
                                    <li>
                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center"
                                        >{{
                                                currencySymbol(props.lessons?.currency)
                                            }}{{
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
                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center"
                                        >{{ props.lessons.target_age_from }}
                                            ~
                                            {{
                                                props.lessons.target_age_to
                                            }}歳</span
                                        >
                                        <p>
                                            {{
                                                lang().label.lesson_detail.field
                                                    .ages
                                            }}
                                        </p>
                                    </li>
                                    <!-- <li>
                                    <span
                                        >
                                        {{ props.lessons.class_capacity }}</span
                                    >
                                    <p>
                                        {{
                                            lang().label.lesson_detail.field
                                                .learners
                                        }}
                                    </p>
                                </li> -->
                                    <!-- <li>
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
                                </li> -->
                                    <li>
                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">{{ classDetail(props.lessons.class_detail) }}</span>
                                        <!-- <span>{{ totalApplied(props.lessons) }}/ {{ props.lessons.class_capacity }}名</span> -->
                                        <p>
                                            {{
                                                lang().label.lesson_detail.field
                                                    .type
                                            }}
                                        </p>
                                    </li>
                                    <li>
                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">{{ recommendGradeData(props.lessons.recommend_grade) }}</span>
                                        <p>
                                            {{
                                                lang().label.lesson_detail.field
                                                    .recommend
                                            }}
                                        </p>
                                    </li>
                                    <li>
                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">{{ levelLesson(props.lessons.level) }}</span>
                                        <p>
                                            {{
                                                lang().label.lesson_detail.field
                                                    .level
                                            }}
                                        </p>
                                    </li>
                                    <li>
                                        <span
                                            v-if="props.lessons.language == 1"
                                            style="height: 34px" class="d-flex align-items-center justify-content-center"
                                        >日本語</span
                                        >
                                        <span
                                            v-if="props.lessons.language == 2"
                                            style="height: 34px" class="d-flex align-items-center justify-content-center"
                                        >英語</span
                                        >
                                        <span
                                            v-if="props.lessons.language == 3"
                                            style="height: 34px" class="d-flex align-items-center justify-content-center"
                                        >ベトナム語</span
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
                            <div class="d-flex w-full category-wrap">
                                <BaseCard
                                    class="category-info d-flex flex-column align-items-center justify-content-center"
                                >
                                    <div class="category-info-title d-flex align-items-center justify-content-center" style="height: 34px">
                                        {{ props.lessons.class_repeat == 2 ? "月1回" : "月" + props.lessons.number_of_meets + "回" }}
                                    </div>
                                    <div class="category-info-content">
                                        {{
                                            lang().label.lesson_detail.field
                                                .schedule
                                        }}
                                    </div>
                                </BaseCard>
                                <BaseCard
                                    class="category-info d-flex flex-column align-items-center justify-content-center"
                                >
                                    <div class="category-info-title d-flex align-items-center justify-content-center" style="height: 34px">
                                        <div
                                            v-if="
                                                props.lessons.lesson_hour !== 0
                                            "
                                        >
                                            {{ props.lessons.lesson_hour }}時
                                        </div>
                                        <div>
                                            {{ props.lessons.lesson_minute }}分
                                        </div>
                                    </div>
                                    <div class="category-info-content">
                                        {{
                                            lang().label.lesson_detail.field
                                                .time
                                        }}
                                    </div>
                                </BaseCard>
                            </div>
                            <div class="videoWarp">
                                <!-- <div class="item">
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
                            </div> -->
                                <div class="item">
                                    <p class="subTitle">
                                        {{ lang().label.lesson_detail.for_kid }}
                                    </p>
                                    <div class="video" @click="showShortVideo">
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
                                    v-for="lesson_course in validCourses(
                                        props.lesson_courses
                                    ).slice(0, detailForm.scheduleShow)"
                                    :key="lesson_course.id"
                                >
                                    <div class="item">
                                        <div class="item__left">
                                            <div
                                                style="
                                                    font-size: 12px;
                                                    font-weight: 700;
                                                    line-height: 1.6;
                                                "
                                            >
                                                {{ lesson_course.title }}
                                            </div>
                                            <div class="top mt-1">
                                                <div class="date">
                                                    {{
                                                        moment(
                                                            lesson_course.start_date_time
                                                        ).format("YYYY/MM/DD")
                                                    }}
                                                </div>
                                                <div class="time d-flex">
                                                    <div>
                                                        {{
                                                            moment(lesson_course.start_date_time).format('HH:mm')
                                                        }}
                                                        ~
                                                        {{
                                                            moment(lesson_course.end_date_time).format('HH:mm')
                                                        }}
                                                        (<span
                                                        v-if="
                                                                totalTime(
                                                                    lesson_course.start_date_time,
                                                                    lesson_course.end_date_time
                                                                )[0] > 0
                                                            "
                                                    >{{
                                                            totalTime(
                                                                lesson_course.start_date_time,
                                                                lesson_course.end_date_time
                                                            )[0]
                                                        }}h
                                                        </span>
                                                        <span
                                                        >{{
                                                                totalTime(
                                                                    lesson_course.start_date_time,
                                                                    lesson_course.end_date_time
                                                                )[1]
                                                            }}m</span
                                                        >)
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                v-if="lesson_course.total_applied != lesson_course.max_seat"
                                                class="bottom mt-1 align-items-center"
                                                style="padding-top: 0px"
                                            >
                                                <div class="seats">
                                                    {{
                                                        lang().label
                                                            .lesson_detail
                                                            .available_seats
                                                    }}
                                                    {{
                                                        lesson_course.max_seat -
                                                        lesson_course.total_applied
                                                    }}
                                                    {{
                                                        lang().label
                                                            .lesson_detail
                                                            .seats
                                                    }}
                                                </div>
                                                <div class="count">
                                                    ({{
                                                        lesson_course.total_applied
                                                    }}/{{
                                                        lesson_course.max_seat
                                                    }})
                                                </div>
                                            </div>
                                            <div
                                                v-if="lesson_course.total_applied == lesson_course.max_seat"
                                                class="bottom mt-1 align-items-center"
                                                style="padding-top: 0px"
                                            >
                                                <div class="seats" style="color: #e71a41">満席</div>
                                                <div class="count">
                                                    ({{
                                                        lesson_course.total_applied
                                                    }}/{{
                                                        lesson_course.max_seat
                                                    }})
                                                </div>
                                            </div>
                                            <div
                                                v-for="schedule in lesson_course.course_schedules"
                                                :key="schedule"
                                                class="mt-2"
                                            >
                                                <div
                                                    v-if="
                                                        showTime.includes(
                                                            lesson_course.id
                                                        )
                                                    "
                                                    class="d-flex align-items-center lesson__detail-schedule"
                                                >
                                                    <img
                                                        v-if="
                                                            checkExpired(
                                                                schedule.end_date_time
                                                            )
                                                        "
                                                        src="/img/icon/check.svg"
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
                                                                schedule?.start_date_time
                                                            ).format(
                                                                "ddd YYYY/MM/DD"
                                                            )
                                                        }}
                                                    </div>
                                                    <div>・</div>
                                                    <div
                                                        class="lesson__detail-schedule-time"
                                                    >
                                                        {{
                                                            moment(schedule?.start_date_time).format('HH:mm')
                                                        }}
                                                        -
                                                        {{ moment(schedule?.end_date_time).format('HH:mm') }}
                                                    </div>
                                                    <div>AM</div>
                                                </div>
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
                                                        showTime.includes(
                                                            lesson_course.id
                                                        )
                                                    "
                                                    style="
                                                        color: #418997;
                                                        font-size: 12px;
                                                        text-decoration-line: underline;
                                                        cursor: pointer;
                                                    "
                                                >
                                                    閉じる
                                                </div>
                                                <div
                                                    v-else
                                                    style="
                                                        color: #418997;
                                                        font-size: 12px;
                                                        text-decoration-line: underline;
                                                        cursor: pointer;
                                                    "
                                                >
                                                    他の日程をみる
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            v-if="
                                                lesson_course.total_applied !==
                                                    lesson_course.max_seat &&
                                                !usePage().props.auth.user
                                            "
                                            class="item__right pointer"
                                            @click="
                                                handleTogglePopupSignin(
                                                    route(
                                                        'course.apply',
                                                        lesson_course.id
                                                    )
                                                )
                                            "
                                        >
                                            {{
                                                lang().label.lesson_detail.apply
                                            }}
                                        </div>
                                        <div
                                            v-if="
                                                lesson_course.total_applied ===
                                                lesson_course.max_seat
                                            "
                                            class="item__right"
                                            :class="{
                                                item__full:
                                                    lesson_course.total_applied ===
                                                    lesson_course.max_seat,
                                            }"
                                        >
                                            {{
                                                lang().label.lesson_detail.full
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <span
                                    v-show="
                                        detailForm.scheduleShow <
                                        validCourses(props.lesson_courses)
                                            .length
                                    "
                                    class="showMore show-more-button"
                                    @click="showMoreSchedule"
                                >{{
                                        lang().label.lesson_detail.show_more
                                    }}</span
                                >
                            </div>
                            <div class="note noTitle">
                                <p class="subTitle">
                                    {{
                                        lang().label.lesson_detail
                                            .lesson_outline
                                    }}
                                </p>
                                <p
                                    class="description"
                                    :class="{
                                        fullText: detailForm.moreDescription,
                                    }"
                                >
                                    {{ props.lessons.description }}
                                </p>
                                <span
                                    v-show="detailForm.moreDescription == false && props.lessons.description?.length >= 50"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreDescription = true"
                                >{{
                                        lang().label.lesson_detail.show_more
                                    }}</span
                                >
                                <span
                                    v-show="detailForm.moreDescription"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreDescription = false"
                                >{{
                                        lang().label.lesson_detail.show_less
                                    }}</span
                                >
                            </div>
                            <div class="note">
                                <p class="subTitle">
                                    {{
                                        lang().label.lesson_detail
                                            .teacher_expertise
                                    }}
                                </p>
                                <p
                                    class="description"
                                    :class="{
                                        fullText: detailForm.moreExperience,
                                    }"
                                >
                                    {{ props.lessons.teacher_experience }}
                                </p>
                                <span
                                    v-show="detailForm.moreExperience == false && props.lessons.teacher_experience?.length >= 50"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreExperience = true"
                                >{{
                                        lang().label.lesson_detail.show_more
                                    }}</span
                                >
                                <span
                                    v-show="detailForm.moreExperience"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreExperience = false"
                                >{{
                                        lang().label.lesson_detail.show_less
                                    }}</span
                                >
                            </div>
                            <div class="note">
                                <p class="subTitle">Preparation</p>
                                <p
                                    class="description"
                                    :class="{
                                        fullText: detailForm.morePreparation,
                                    }"
                                >
                                    In this art club for animal lovers, learners
                                    will draw a cartoon animal with step by step
                                    instruction. They will practice their
                                    artistic and social skills while creating a
                                    drawing they will be proud of. abcdefg12...
                                </p>
                                <span
                                    v-show="detailForm.morePreparation == false"
                                    class="showMore show-more-button"
                                    @click="detailForm.morePreparation = true"
                                >{{
                                        lang().label.lesson_detail.show_more
                                    }}</span
                                >
                                <span
                                    v-show="detailForm.morePreparation"
                                    class="showMore show-more-button"
                                    @click="detailForm.morePreparation = false"
                                >{{
                                        lang().label.lesson_detail.show_less
                                    }}</span
                                >
                            </div>
                            <div class="note noTitle">
                                <p class="subTitle">
                                    {{
                                        lang().label.lesson_detail
                                            .additional_note
                                    }}
                                </p>
                                <p
                                    class="description"
                                    :class="{ fullText: detailForm.moreNote }"
                                >
                                    {{ props.lessons.note }}
                                </p>
                                <span
                                    v-show="detailForm.moreNote == false && props.lessons.note?.length >= 50"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreNote = true"
                                >{{
                                        lang().label.lesson_detail.show_more
                                    }}</span
                                >
                                <span
                                    v-show="detailForm.moreNote"
                                    class="showMore show-more-button"
                                    @click="detailForm.moreNote = false"
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
                                    v-for="review in props.reviews.slice(
                                        0,
                                        detailForm.reviewShow
                                    )"
                                    class="item"
                                >
                                    <div class="time">
                                        {{ review.created_at }}
                                    </div>
                                    <div class="author">
                                        <div class="author__left">
                                            <div class="avatar">
                                                <img
                                                    :src="
                                                        review.user.avatar ||
                                                        '/img/icon/iconAvatarDefault.svg'
                                                    "
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
                                                :stars="
                                                    houseRating(
                                                        review
                                                    ).toFixed(1)
                                                "
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
                                                {{
                                                    reviewRating(
                                                        review
                                                    ).toFixed(1)
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <p
                                            :id="'reviewNumber' + review.id"
                                            class="description"
                                        >
                                            {{ review.review }}
                                        </p>
                                        <span
                                            :id="'showMoreNumber' + review.id"
                                            class="showMore show-more-button"
                                            @click="showFullReview(review.id)"
                                        >{{
                                                lang().label.lesson_detail
                                                    .show_more
                                            }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                            <span
                                v-show="
                                    detailForm.reviewShow <=
                                    props.reviews.length
                                "
                                class="showMore show-more-button"
                                @click="showMoreReview"
                            >{{
                                    lang().label.lesson_detail.show_more
                                }}</span
                            >
                            <div
                                class="d-flex justify-content-center align-items-center footer-share-social mt-4"
                            >
                                <div
                                    v-for="socialItem in socialItems"
                                    :key="socialItem.label"
                                >
                                    <ShareSocial
                                        :social="socialItem.social"
                                        :url="currentUrl"
                                        :title="props.lessons.title"
                                        :description="props.lessons.description"
                                    />
                                </div>
                                <ShareSocial :url-copy="currentUrl" />
                            </div>
                            <div
                                v-if="
                                    usePage().props.auth.user?.id ==
                                    props.teacher?.id
                                "
                                class="lesson__detail-button-wrap"
                            >
                                <Link :href="route('edit.draft.lesson', {id: props.lessons?.id, draft: 'listLesson'})">
                                    <div class="lesson__detail-button-edit">編集する</div>
                                </Link>
                                <div
                                    class="lesson__detail-button-red"
                                    @click="handleSuspendLesson"
                                >
                                    レッスンを公開停止する
                                </div>
                                <div
                                    class="lesson__detail-button-red no-outline"
                                    @click="handleDeleteLesson"
                                >
                                    レッスンを削除する
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <ModalSignup
                :is-open="isOpenPopupLogin"
                @toggle="handleTogglePopupSignin"
            />
            <Modal
                :show-modal="formVideo.isOpen"
                @close="formVideo.isOpen = false"
            >
                <div class="videoShow">
                    <!-- <video
                    :src="props.lessons.short_video_for_parent"
                    controls
                    v-if="formVideo.role == 'parent'"
                ></video> -->
                    <video
                        v-if="formVideo.role == 'child'"
                        :src="props.lessons.short_video_for_learner"
                        controls
                    ></video>
                </div>
            </Modal>
            <Modal
                v-if="usePage().props.auth.user?.id == props.teacher?.id"
                :show-modal="openDialogDeleteLesson"
                @close="openDialogDeleteLesson = false"
            >
<div class="lesson__detail-delete-modal-wrap">
                    <div class="lesson__detail-delete-modal-title">
                        {{ lang().label.lesson_detail.messenger_confirm }}
                    </div>
                    <div class="lesson__detail-delete-modal-subtitle">
                        {{ lang().label.lesson_detail.messenger_confirm1 }}
                    </div>
                    <div class="lesson__detail-delete-modal-subtitle">
                        {{ lang().label.lesson_detail.messenger_confirm2 }}
                    </div>
                    <textarea v-model="formReason.reason" cols="50" rows="6" class="mt-4 w-full "></textarea>
                    <div class="d-flex lesson__detail-delete-modal-btn">
                        <ButtonDeleteRequest
                            :label="'キャンセル'"
                            @click="openDialogDeleteLesson = false"
                        />
                        <Link
                            :href="route('delete.lesson', {id: props.lessons?.id, reason: formReason.reason})"
                            method="delete"
                        >
                            <ButtonDeleteRequest
                                :label="
                                    lang().label.lesson_detail.button_submit
                                "
                                :submit-button="true"
                            />
                        </Link>
                    </div>
                </div>
            </Modal>
            <Modal
                v-if="usePage().props.auth.user?.id == props.teacher?.id"
                :show-modal="openDialogSuspendLesson"
                @close="openDialogSuspendLesson = false"
            >
                <div class="lesson__detail-delete-modal-wrap">
                    <div class="lesson__detail-delete-modal-title">
                        {{ lang().label.lesson_detail.suspend_lesson.title }}
                    </div>
                    <div class="lesson__detail-delete-modal-subtitle">
                        {{ lang().label.lesson_detail.suspend_lesson.note }}
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
        </LayoutDashBoard>
    </div>
</template>
<style scoped lang="scss">
@import "./housedetail";
@import "../../../Components/common";
</style>
