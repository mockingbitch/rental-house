<script setup>
import { ref } from "vue";
import LayoutDashBoard from "@/Layouts/LayoutDashboard.vue";
import ScheduleReview from "../../Components/Teacher/ScheduleReview/ScheduleReview.vue";
import BaseLesson from "../../Components/Teacher/Common/BaseLesson.vue";
import SubHeader from "../../Components/Common/SubHeader.vue";

// Xác định có phải review toàn bộ schedule hay không
const isAllReview = ref(props.isAllReview);

const props = defineProps({
    lesson: Object,
    listReview: Array,
    listReviewOfTeacher: Array,
    isAllReview: Boolean,
});
const listLesson = ref([props.lesson]);
</script>
<template>
    <LayoutDashBoard>
        <div class="teacher-schedule-review-container">
            <div class="mt-4">
                <SubHeader
                    v-if="isAllReview"
                    :label="'あいうえおあいうえお'"
                    href="record.list"
                />
                <SubHeader v-else :label="'コース設定'" />
            </div>

            <!-- TODO: Nếu là review toàn schedule -->
            <div v-if="isAllReview">
                <div class="teacher-schedule-review-title">Total Review</div>
                <ScheduleReview
                    :is-all-review="isAllReview"
                    :list-review-of-teacher="props.listReviewOfTeacher"
                />
            </div>
            <!-- TODO: Nếu là review 1 schedule cụ thể -->
            <div v-else>
                <div class="mt-4">
                    <BaseLesson :lessons="listLesson" :isDisplayIcon="true" />
                </div>
                <div class="teacher-schedule-review-title">Review Detail</div>
                <ScheduleReview
                    :listReview="props.listReview"
                    :lesson="props.lesson"
                    :listReviewOfTeacher="props.listReviewOfTeacher"
                />
            </div>
        </div>
    </LayoutDashBoard>
</template>
<style scoped lang="scss">
.teacher-schedule-review-container {
    width: 100%;
    max-width: 400px;
    margin: 0px auto;
    font-family: Noto Sans JP;
}
@media all and (max-width: 768px) {
    .teacher-schedule-review-container {
        padding: 0px 16px;
    }
}
.teacher-schedule-review-header {
    height: 54px;
    position: relative;
    &-tab {
        padding: 15px 0 0;
        &-item {
            font-size: 14px;
            width: calc(400px / 3);
            display: flex;
            justify-content: center;
            padding-bottom: 15px;
            line-height: 19.2px;
            cursor: pointer;
        }
        .isActive {
            font-weight: bold;
            color: #418997;
            border-bottom: 2px solid #418997;
        }
    }
}
.teacher-schedule-review-title {
    color: #1b1b1b;
    font-size: 16px;
    font-style: normal;
    font-weight: 700;
    line-height: 160%;
    letter-spacing: -0.16px;
    padding: 8px 0px;
    margin-top: 16px;
}
</style>
