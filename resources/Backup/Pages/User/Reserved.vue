<script setup>
import { ref } from "vue";
import BaseReservedHeader from "@/Components/User/Common/BaseReservedHeader.vue";
import NoResult from "../../Components/Teacher/Common/NoResult.vue";
import ReservedCard from "@/Components/User/ReservedCard.vue";
import Layout from "@/Layouts/Layout.vue";
import moment from "moment";

const props = defineProps({
    course_applied: Array,
});

const hasSchedule = (course) => {
    for (let i = 0; i < course.course_schedules.length; i++) {
        if (course.course_schedules[i].date == moment().format('YYYY-MM-DD')) {
            return 1
        } else {
            return 2
        }
    }
}

const clickedSkip = ref(false);
const clickedDelete = ref(false);
const title = ref('')

const setClickSkipButton = (value) => {
    clickedSkip.value = true;
    setTimeout(() => {
        clickedSkip.value = false;
    }, 5000);
    title.value = value;
}

const setClickDeleteButton = (value) => {
    clickedDelete.value = true;
    setTimeout(() => {
        clickedDelete.value = false;
    }, 5000);
    title.value = value;
}
</script>
<template>
    <Layout
        >
<div class="reserved-container">
            <BaseReservedHeader />
            <div v-for="course_date in Object.entries(props.course_applied)" v-if="Object.entries(props.course_applied).length">
                <div class="reserved-day mt-4">{{ course_date[0] }}</div>
                <div class="d-flex flex-column" style="gap: 16px">
                    <ReservedCard
                        v-for="course in course_date[1]"
                        :status-button="hasSchedule(course)"
                        :label="course.course_schedules[0]?.start_time + ' ~ ' + course.course_schedules[0]?.end_time + (hasSchedule(course) == 1 ? '　参加する' : '　から開始')"
                        :course="course"
                        @setClickSkipButton="setClickSkipButton(course.lesson.title)"
                        @setClickDeleteButton="setClickDeleteButton(course.lesson.title)"
                    />
                </div>
            </div>
            <NoResult v-else />
            <div v-if="clickedSkip" class="reserved-delete-notice d-flex flex-column justify-content-center mt-4">{{ title }} のレッスンをスキップ設定しました。</div>
            <div v-if="clickedDelete" class="reserved-delete-notice d-flex flex-column justify-content-center mt-4">{{ title }} を解約しました。</div>
        </div>
    </Layout>
</template>
<style scoped lang="scss">
.reserved-container {
    width: 100%;
    max-width: 400px;
    margin: 0px auto;
    font-family: Noto Sans JP;
    color: #1b1b1b;
    .reserved-day {
        padding: 8px 0px;
        font-size: 16px;
        font-weight: 700;
        line-height: 160%;
        letter-spacing: -0.16px;
    }
}
.reserved-delete-notice {
    color: #5392F9 ;
    background-color: #E1EFF2;
    height: 54px;
    padding: 8px;
    font-size: 12px;
    line-height: 160%;
    letter-spacing: -0.12px;
    border-radius: 4px;
}
@media all and (max-width: 768px) {
    .reserved-container {
        padding: 0px 16px;
    }
}
</style>
