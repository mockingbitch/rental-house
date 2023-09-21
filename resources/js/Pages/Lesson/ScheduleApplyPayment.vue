<script setup>
import Layout from "../../Layouts/Layout.vue";
import { useForm } from '@inertiajs/vue3';
import { Link } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";

const props = defineProps({
    applyForm: Object,
    data: Object,
    symbol: {
        type: String,
        default: "円",
    }
});

const breadcrumbItems = [
    { text: "Lessons", isLink: false, href: 'lesson.detail', params: props.data.lesson.id },
    { text: props.data.lesson.title, isLink: false,  href: `course.apply`, params: props.data.lessonCourse.id },
    { text: 'Check page', isLink: false },
];
</script>
<template>
    <main class="joinLesson">
        <Breadcrumb
            :items="breadcrumbItems"
            @handleClick="handleBreadcrumbClick"
        />
        <div class="container">
            <form class="form">
                <div class="form__wrap">
                    <div class="titlePage">
                        <div class="subTitle">
                            申込内容をご確認お願いします。
                        </div>
                    </div>
                    <div class="detail payment">
                        <div class="center">
                            <div class="miniTitle">Leaners</div>
                            <ul>
                                <li v-for="kid in props.applyForm.applyKids">
                                    <p class="bold">{{ kid.name }}</p>
                                    <p>{{ kid.birthday }} 歳</p>
                                </li>
                                <!-- <li><p>Num of Total Learner</p><p class="bold">420<span class="bold green">(+12)</span></p></li> -->
                                <!-- <li><p>Average per Lesson</p><p class="bold">2,580 yen<span class="red">(-100 yen)</span></p></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="detail payment">
                        <div class="center">
                            <ul class="listQuestions">
                                <li v-for="question in props.applyForm.learnerQuestions">
                                    <span>Question {{ question.id }}</span>
                                    <p>{{ question.question }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="detail payment">
                        <div class="center">
                            <ul>
                                <li><p>Date</p><p class="bold">{{ props.data.lesson.start_date }}　{{ props.data.lessonCourse.start_time }}-{{ props.data.lessonCourse.end_time }}</p></li>
                                <li><p>Title</p><p class="bold">{{ props.data.lesson.title }}</p></li>
                            </ul>
                            <div class="line"></div>
                            <ul>
                                <li>
                                    <p>Price</p>
                                    <p class="bold">{{ (props.data.lesson.price * props.applyForm.applyKids.length).toLocaleString() }}{{ props.symbol }}</p>
                                </li>
                                <li>
                                    <p>tax</p>
                                    <p class="bold">{{ (props.data.lesson.price * props.applyForm.applyKids.length * 10 / 100).toLocaleString() }}{{ props.symbol }}</p>
                                </li>
                                <li>
                                    <p class="green">Total Amount</p>
                                    <p class="bold green">{{ (props.data.lesson.price * props.applyForm.applyKids.length + props.data.lesson.price * props.applyForm.applyKids.length * 10 / 100).toLocaleString() }}{{ props.symbol }}</p>
                                </li>
                            </ul>
                        </div>
                        <div class="policy">
                            <div class="subTitle">
                                Refund Policy
                            </div>
                            <p>samplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesamplesample.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</template>
