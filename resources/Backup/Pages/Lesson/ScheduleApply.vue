<script setup>
import Layout from "../../Layouts/Layout.vue";
import ScheduleApplyPayment from "@/Pages/Lesson/ScheduleApplyPayment.vue";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import KidSelect from "@/Components/KidSelect/KidSelect.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";

const props = defineProps({
    oldApplyForm: Object,
    applyKids: Array,
    lesson: Object,
    lessonCourse: Object,
    kids: Array,
    symbol: {
        type: String,
        default: "円",
    }
});

// Form to send to back end
const applyForm = useForm({
    // newKids: props.oldApplyForm?.newKids ?? [],
    applyKids: props.oldApplyForm?.applyKids ?? "",
    learnerQuestions: props.oldApplyForm?.learnerQuestions ?? [
        {
            id: 1,
            question: "",
        },
    ],
    totalPrice: props.oldApplyForm?.totalPrice ?? 0,
    kids: props.oldApplyForm?.kids ?? props.kids,
    lesson: props.oldApplyForm?.lesson ?? props.lesson,
    lessonCourse: props.oldApplyForm?.lessonCourse ?? props.lessonCourse,
});

// state to indicate step
const state = useForm({
    step: 1,
});

// check if have old apply form then go to step 2
props.oldApplyForm ? (state.step = 2) : null;

// check if have old apply form then check for kids
props.kids.forEach((kid) => {
    for (var k of applyForm.applyKids) {
        if (kid.id === k.id) {
            kid.checked = true;
        }
    }
});

// list kid to display
const applyFormData = useForm({
    applyKids: [...props.kids],
});

// func to add kid to list kid to display
const addMoreKid = () => {
    applyFormData.applyKids.push({
        id: null,
        name: "",
        birthday: "",
    });
};

const addMoreQuestion = () => {
    const increateNumber = applyForm.learnerQuestions.length;
    applyForm.learnerQuestions.push({
        id: increateNumber + 1,
        question: "",
    });
};

const toConfirmPage = () => {
    applyForm.totalPrice =
        applyFormData.applyKids.filter((item) => item.checked === true).length *
            props.lesson.price +
        (applyFormData.applyKids.filter((item) => item.checked === true)
            .length *
            props.lesson.price *
            10) /
            100;

    applyForm.applyKids = applyFormData.applyKids.filter(
        (item) => item.checked === true
    );

    applyForm.post(route("course.apply.payment", props.lessonCourse.id), {
        onSuccess: (e) => {
            applyForm.applyKids = e.props.applyKids;
            applyFormData.applyKids = [...e.props.kids];
            props.kids.forEach((kid) => {
                for (var k of applyForm.applyKids) {
                    if (kid.id === k.id) {
                        kid.checked = true;
                    }
                }
            });
            state.step = 2;
        },
    });
};

const toStripePaymentPage = () => {
    applyForm.post(route("payment.initiate", props.lessonCourse.id), {
        onSuccess: (e) => {
            state.step = 2;
        },
    });
};
const appliedKids = () => {
    let count = 0;
    for (let i = 0; i < props.lessonCourse.course_applications.length; i++) {
        if (props.lessonCourse?.course_applications[i].status == "1") {
            count +=
                props.lessonCourse?.course_applications[i]?.application_details
                    .length ?? 0;
        }
    }
    return count;
};

const breadcrumbItems = [
    { text: 'Lessons', isLink: false, href: 'lesson.detail', params: props.lesson.id },
    { text: props.lesson.title, isLink: false },
    { text: '01', isLink: false },
];
</script>

<style lang="scss" scoped>
@import "./_lesson.scss";
.btn-green {
    color: #fff;
    background-color: #5392F9 ;
}
</style>

<template>
    <Layout>
        <main class="joinLesson" v-show="state.step === 1">
            <Breadcrumb
                :items="breadcrumbItems"
                @handleClick="handleBreadcrumbClick"
            />
            <div class="container">
                <form class="form">
                    <div class="form__wrap">
                        <div class="titlePage">
                            <div class="subTitle">
                                レッスンに申し込みします！
                            </div>
                        </div>
                        <div class="information">
                            <div class="subTitle">Leaners Information</div>
                            <div class="listItems">
                                <div v-for="kid in applyFormData.applyKids">
                                    <KidSelect
                                        :kid="kid"
                                        :lesson="props.lesson"
                                    />
                                </div>
                                <div class="mainButton" @click="addMoreKid">
                                    <p>
                                        <img
                                            src="/img/icon/Plus.svg"
                                            alt="Plus"
                                        />
                                        Another Learners
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="questions">
                            <div class="subTitle">Leaners Questions</div>
                            <div class="listQuestions">
                                <div
                                    class="item"
                                    v-for="question in applyForm.learnerQuestions"
                                >
                                    <div class="input">
                                        <label for=""
                                            >Question {{ question.id }}</label
                                        >
                                        <input
                                            type="text"
                                            :placeholder="
                                                'Question ' + question.id
                                            "
                                            v-model="
                                                applyForm.learnerQuestions[
                                                    question.id - 1
                                                ].question
                                            "
                                        />
                                    </div>
                                </div>
                                <div
                                    class="mainButton"
                                    @click="addMoreQuestion"
                                >
                                    <p>
                                        <img
                                            src="/img/icon/Plus.svg"
                                            alt="Plus"
                                        />
                                        Another Questions
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="detail">
                            <div class="subTitle">Lesson Detail</div>
                            <div class="top">
                                <div class="image">
                                    <img :src="props.lesson.cover_image" />
                                </div>
                                <h2 class="d-flex align-items-center">
                                    {{ props.lesson.title }}
                                </h2>
                            </div>
                            <div class="center">
                                <ul>
                                    <li>
                                        <p>Date</p>
                                        <p class="bold">
                                            {{ props.lesson.start_date }}　{{
                                                props.lessonCourse?.start_time
                                            }}-{{
                                                props.lessonCourse?.end_time
                                            }}
                                        </p>
                                    </li>
                                    <li>
                                        <p>Title</p>
                                        <p class="bold">
                                            {{ props.lesson.title }}
                                        </p>
                                    </li>
                                </ul>
                                <div class="line"></div>
                                <ul>
                                    <li>
                                        <p>Price</p>
                                        <p class="bold">
                                            {{
                                                (
                                                    applyFormData.applyKids.filter(
                                                        (item) =>
                                                            item.checked ===
                                                            true
                                                    ).length *
                                                    props.lesson.price
                                                ).toLocaleString()
                                            }}{{ props.symbol }}
                                        </p>
                                    </li>
                                    <li>
                                        <p>tax</p>
                                        <p class="bold">
                                            {{
                                                (
                                                    (applyFormData.applyKids.filter(
                                                        (item) =>
                                                            item.checked ===
                                                            true
                                                    ).length *
                                                        props.lesson.price *
                                                        10) /
                                                    100
                                                ).toLocaleString()
                                            }}{{ props.symbol }}
                                        </p>
                                    </li>
                                    <li>
                                        <p class="green">Total Amount</p>
                                        <p class="bold green">
                                            {{
                                                (
                                                    applyFormData.applyKids.filter(
                                                        (item) =>
                                                            item.checked ===
                                                            true
                                                    ).length *
                                                        props.lesson.price +
                                                    (applyFormData.applyKids.filter(
                                                        (item) =>
                                                            item.checked ===
                                                            true
                                                    ).length *
                                                        props.lesson.price *
                                                        10) /
                                                        100
                                                ).toLocaleString()
                                            }}{{ props.symbol }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="policy">
                                <div class="subTitle">Refund Policy</div>
                                <p>
                                    samplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesample.
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        <ScheduleApplyPayment
            :applyForm="applyForm"
            :data="props"
            :symbol="props.symbol"
            v-show="state.step === 2"
        />
        <div class="buttonFucBlock"></div>
        <div class="buttonFun">
            <div class="container">
                <div class="buttonFun__wrap">
                    <!-- Button return left -->
                    <Link
                        :href="route('lesson.detail', props.lesson.id)"
                        v-if="state.step === 1"
                        >キャンセル</Link
                    >
                    <a
                        href="javascript:void(0)"
                        v-if="state.step === 2"
                        @click="state.step = 1"
                        >キャンセル</a
                    >

                    <!-- Button apply right -->
                    <div
                        type="submit"
                        class="mainButton btn-green"
                        @click="toConfirmPage"
                        v-show="
                            state.step === 1 &&
                            applyFormData.applyKids.filter(
                                (item) => item.checked === true
                            ).length &&
                            applyFormData.applyKids.filter(
                                (item) => item.checked === true
                            ).length <=
                                props.lesson.max_learner - appliedKids()
                        "
                    >
                        <p>Apply</p>
                        <i class="after"
                            ><img
                                src="/img/icon/CaretRight.svg"
                                alt="CaretRight"
                        /></i>
                    </div>
                    <div
                        class="mainButton inactive"
                        v-show="
                            (state.step === 1 &&
                                !applyFormData.applyKids.filter(
                                    (item) => item.checked === true
                                ).length) ||
                            applyFormData.applyKids.filter(
                                (item) => item.checked === true
                            ).length >
                                props.lesson.max_learner - appliedKids()
                        "
                    >
                        <p>Apply</p>
                        <i class="after"
                            ><img
                                src="/img/icon/CaretRightDark.svg"
                                alt="CaretRight"
                        /></i>
                    </div>

                    <!-- Button submit payment -->
                    <form
                        @submit.prevent="toStripePaymentPage"
                        v-show="state.step === 2"
                    >
                        <button class="mainButton bg-green" type="submit">
                            <p>決済に進む</p>
                            <i class="after"
                                ><img
                                    src="/img/icon/CaretRight.svg"
                                    alt="CaretRight"
                            /></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>
