<script setup>
import { ref } from "vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { houseRating } from "@/Helper/Rating";
import { socialItems } from "@/Helper/ShareSocial.js";
import moment from "moment";
import Layout from "@/Layouts/Layout.vue";
import Modal from "@/Components/Modal/Modal.vue";
import ShareSocial from "@/Components/ShareSocial/ShareSocial.vue";
import BaseDialog from "@/Components/Dialog/BaseDialog.vue";
import BaseCard from "@/Components/Card/BaseCard.vue";
import { priceFormat } from "@/Helper/CurrencyHelper";
import {
    sortArrayByCapacity,
    sortArrayByPrice,
} from "@/Helper/SortHelper";

const props = defineProps({
    // eslint-disable-next-line vue/require-default-prop
    house: Object,
    // eslint-disable-next-line vue/require-default-prop
    rooms: Array,
    // eslint-disable-next-line vue/require-default-prop
    reviews: Array,
});
const currentUrl = window.location.href;
const formVideo = useForm({
    isOpen: false,
    role: "",
});
const formReason = useForm({
    reason: "",
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
const validCourses = (courses) => {
    let validCourse = courses;
    if (
        usePage().props.auth?.user?.role === "LESSEE" ||
        !usePage().props.auth?.user
    ) {
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

const isOpenShareSocial = ref(false);
const handleShareSocial = () => {
    isOpenShareSocial.value = true;
};
</script>

<template>
    <div>
        <Layout>
            <main class="detailLesson">
                <div class="container">
                    <div class="form">
                        <div class="form__wrap">
                            <div class="news w-full">
                                <a href="" class="image">
                                    <img
                                        :src="
                                            props.house?.thumbnail ||
                                            '/img/image-holder.png'
                                        "
                                    />
                                </a>
                                <div
                                    class="d-flex align-items-center justify-content-between"
                                    style="height: 40px"
                                >
                                    <div
                                        class="d-flex align-items-center"
                                        style="
                                            color: #5392f9;
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
                                                fill="#5392f9"
                                            />
                                        </svg>
                                        <div>{{ lang().label.house_detail.house }}</div>
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
                                        <BaseDialog
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
                                                    {{ lang().label.house_detail.share_social }}
                                                </div>
                                                <ShareSocial
                                                    :label="'X'"
                                                    :social="'twitter'"
                                                    :url="currentUrl"
                                                    :title="props.house?.name"
                                                    :description="props.house?.description"
                                                />
                                                <ShareSocial
                                                    :label="'Facebook'"
                                                    :social="'facebook'"
                                                    :url="currentUrl"
                                                    :title="props.house?.name"
                                                    :description="props.house?.description"
                                                />
                                                <ShareSocial
                                                    :label="'LINE'"
                                                    :social="'line'"
                                                    :url="currentUrl"
                                                    :title="props.house?.name"
                                                    :description="props.house?.description"
                                                />
                                                <ShareSocial
                                                    :label="'copy'"
                                                    :url-copy="currentUrl"
                                                />
                                            </div>
                                        </BaseDialog>
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
                                            fill="#5392f9"
                                        />
                                    </svg>
                                    <p>
                                        <span>
                                            <!--{{ rating.toFixed(1) }}-->
                                            5.0
                                        </span>
                                        <!--({{ props.house?.reviews?.length }})-->
                                        (100)
                                    </p>
                                </div>
                                <div class="title">
                                    {{ props.house?.name }}
                                </div>
                                <div class="author">
                                    <a
                                        style="color: black"
                                        :href="route('house.detail', ['id', props.house?.lessor?.id])"
                                    >
                                        <div class="author__left">
                                            <div class="avatar">
                                                <img
                                                    :src="
                                                        props.house?.lessor
                                                            ?.avatar ||
                                                        '/img/icon/iconAvatarDefault.svg'
                                                    "
                                                    alt=""
                                                />
                                            </div>
                                            <p>
                                                {{
                                                    props.house?.lessor?.first_name
                                                }}
                                                {{
                                                    props.house?.lessor?.last_name
                                                }}
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
                                    {{ props.house?.description }}
                                </p>
                                <span
                                    v-show="
                                        detailForm.moreContent === false &&
                                        props.house?.description?.length >= 50
                                    "
                                    class="showMore"
                                    @click="detailForm.moreContent = true"
                                >
                                    {{ lang().label.house_detail.show_more }}
                                </span>
                                <span
                                    v-show="detailForm.moreContent"
                                    class="showMore"
                                    @click="detailForm.moreContent = false"
                                >
                                    {{ lang().label.house_detail.show_less }}
                                </span>
                            </div>
                            <div class="attributes">
                                <ul>
                                    <li>
                                        <span
                                            style="height: 34px"
                                            class="d-flex align-items-center justify-content-center"
                                        >
                                            {{
                                                priceFormat(
                                                    sortArrayByPrice(
                                                        house?.rooms
                                                    )[0]?.price
                                                )
                                            }}
                                            -
                                            {{
                                                priceFormat(
                                                    sortArrayByPrice(
                                                        house?.rooms
                                                    )[house?.rooms?.length - 1]
                                                        ?.price
                                                )
                                            }}
                                            VND
                                        </span>
                                        <p>{{ lang().label.house_detail.price }}</p>
                                    </li>
                                    <li>
                                        <span
                                            style="height: 34px"
                                            class="d-flex align-items-center justify-content-center"
                                        >
                                            {{
                                                sortArrayByCapacity(
                                                    house?.rooms
                                                )[0]?.capacity
                                            }}
                                            -
                                            {{
                                                sortArrayByCapacity(
                                                    house?.rooms
                                                )[house?.rooms?.length - 1]
                                                    ?.capacity
                                            }}
                                            {{ lang().label.house_detail.person }}
                                        </span>
                                        <p>{{ lang().label.house_detail.capacity }}</p>
                                    </li>
<!--                                    <li>-->
<!--                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">-->
<!--                                            {{ classDetail(props.house?.description) }}-->
<!--                                        </span>-->
<!--                                        &lt;!&ndash; <span>{{ totalApplied(props.lessons) }}/{{ props.lessons.class_capacity }}名</span> &ndash;&gt;-->
<!--                                        <p>-->
<!--                                            Type-->
<!--                                        </p>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">-->
<!--                                            {{ recommendGradeData(props.lessons.recommend_grade) }}-->
<!--                                        </span>-->
<!--                                        <p>-->
<!--                                            Recommend-->
<!--                                        </p>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <span style="height: 34px" class="d-flex align-items-center justify-content-center">-->
<!--                                            {{ levelLesson(props.lessons.level) }}-->
<!--                                        </span>-->
<!--                                        <p>-->
<!--                                            Tag-->
<!--                                        </p>-->
<!--                                    </li>-->
                                </ul>
                            </div>
                            <div class="d-flex w-full category-wrap">
                                <BaseCard
                                    class="category-info d-flex flex-column align-items-center justify-content-center"
                                >
                                    <div
                                        class="category-info-title d-flex align-items-center justify-content-center"
                                        style="height: 34px"
                                    >
                                        {{ house?.lessor?.phone }}
                                    </div>
                                    <div class="category-info-content">
                                        {{ lang().label.house_detail.contact_phone }}
                                    </div>
                                </BaseCard>
                                <BaseCard
                                    class="category-info d-flex flex-column align-items-center justify-content-center"
                                >
                                    <div
                                        class="category-info-title d-flex align-items-center justify-content-center"
                                        style="height: 34px"
                                    >
                                        <div>
                                            {{ house?.lessor?.email }}
                                        </div>
                                    </div>
                                    <div class="category-info-content">
                                        {{ lang().label.house_detail.contact_email }}
                                    </div>
                                </BaseCard>
                                <BaseCard
                                    class="category-info d-flex flex-column align-items-center justify-content-center"
                                >
                                    <div
                                        class="category-info-title d-flex align-items-center justify-content-center"
                                        style="height: 34px"
                                    >
                                        <div>
                                            {{ house?.province?.name }} -
                                            {{ house?.district?.name }} -
                                            {{ house?.ward?.name }}
                                        </div>
                                    </div>
                                    <div class="category-info-content">
                                        {{ house?.address }}
                                    </div>
                                </BaseCard>
                            </div>
                            <div class="schedule">
                                <p class="subTitle">{{ lang().label.house_detail.rooms }}</p>
                                <div
                                    v-for="room in props.rooms"
                                    :key="room.id"
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
                                                {{ room?.name }}
                                            </div>
                                            <div class="top mt-1">
                                                <div class="date">
                                                    {{ lang().label.house_detail.description }}
                                                </div>
                                                <div class="time d-flex">
                                                    <div>
                                                        {{ room?.description }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="bottom mt-1 align-items-center"
                                                style="padding-top: 0"
                                            >
                                                <div class="seats">
                                                    {{ lang().label.house_detail.capacity }}
                                                </div>
                                                <div class="count">
                                                    {{ room?.capacity }}
                                                </div>
                                            </div>
                                            <div
                                                class="bottom mt-1 align-items-center"
                                                style="padding-top: 0"
                                            >
                                                <div class="seats" style="color: #e71a41">{{ lang().label.house_detail.price }}</div>
                                                <div class="count">
                                                    {{ priceFormat(room?.price) }} VND
                                                </div>
                                            </div>
                                        </div>
                                        <Link
                                            class="item__right pointer"
                                            :href="route('room.detail', room.id)"
                                        >
                                            {{ lang().label.house_detail.check }}
                                        </Link>
                                    </div>
                                </div>
                                <span
                                    class="showMore show-more-button"
                                    @click="showMoreSchedule"
                                >
                                    {{ lang().label.house_detail.show_more }}
                                </span>
                            </div>

                            <div class="reviewWrap">
                                <p class="subTitle">{{ lang().label.house_detail.review }}</p>
                                <!--                                <div-->
                                <!--                                    v-for="review in props.reviews.slice(-->
                                <!--                                        0,-->
                                <!--                                        detailForm.reviewShow-->
                                <!--                                    )"-->
                                <!--                                    class="item"-->
                                <!--                                >-->
                                <!--                                    <div class="time">-->
                                <!--                                        {{ review.created_at }}-->
                                <!--                                    </div>-->
                                <!--                                    <div class="author">-->
                                <!--                                        <div class="author__left">-->
                                <!--                                            <div class="avatar">-->
                                <!--                                                <img-->
                                <!--                                                    :src="-->
                                <!--                                                        review.user.avatar ||-->
                                <!--                                                        '/img/icon/iconAvatarDefault.svg'-->
                                <!--                                                    "-->
                                <!--                                                    alt=""-->
                                <!--                                                />-->
                                <!--                                            </div>-->
                                <!--                                            <p>-->
                                <!--                                                {{ review.user.first_name }}-->
                                <!--                                                {{ review.user.last_name }}-->
                                <!--                                            </p>-->
                                <!--                                        </div>-->
                                <!--                                        <div class="author__right">-->
                                <!--                                            <Stars-->
                                <!--                                                :stars="-->
                                <!--                                                    houseRating(-->
                                <!--                                                        review-->
                                <!--                                                    ).toFixed(1)-->
                                <!--                                                "-->
                                <!--                                                bg-star="#B1B1B1"-->
                                <!--                                            />-->
                                <!--                                            <p-->
                                <!--                                                style="-->
                                <!--                                                    margin-left: 2px;-->
                                <!--                                                    font-size: 12px;-->
                                <!--                                                    font-weight: 400;-->
                                <!--                                                    line-height: 160%;-->
                                <!--                                                "-->
                                <!--                                            >-->
                                <!--                                                {{-->
                                <!--                                                    houseRating(-->
                                <!--                                                        review-->
                                <!--                                                    ).toFixed(1)-->
                                <!--                                                }}-->
                                <!--                                            </p>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                    <div class="content">-->
                                <!--                                        <p-->
                                <!--                                            :id="'reviewNumber' + review.id"-->
                                <!--                                            class="description"-->
                                <!--                                        >-->
                                <!--                                            {{ review.review }}-->
                                <!--                                        </p>-->
                                <!--                                        <span-->
                                <!--                                            :id="'showMoreNumber' + review.id"-->
                                <!--                                            class="showMore show-more-button"-->
                                <!--                                            @click="showFullReview(review.id)"-->
                                <!--                                        >{{-->
                                <!--                                                lang().label.lesson_detail-->
                                <!--                                                    .show_more-->
                                <!--                                            }}</span-->
                                <!--                                        >-->
                                <!--                                    </div>-->
                                <!--                                </div>-->
                            </div>
                            <span
                                v-show="
                                    detailForm.reviewShow <=
                                    props.reviews?.length
                                "
                                class="showMore show-more-button"
                                @click="showMoreReview"
                            >
                                {{ lang().label.house_detail.show_more }}
                            </span>
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
                                        :title="props.house?.name"
                                        :description="props.house?.description"
                                    />
                                </div>
                                <ShareSocial :url-copy="currentUrl" />
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </Layout>
    </div>
</template>
<style scoped lang="scss">
@import "./housedetail";
@import "../../../Components/common";
</style>
