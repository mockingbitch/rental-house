<script setup>
import { Link } from "@inertiajs/vue3";
import LayoutDashboard from "@/Layouts/LayoutDashboard.vue";
// import Achievement from "../../Components/Teacher/Achievement.vue";
// import LessonFeedbacks from "../../Components/Teacher/LessonFeedbacks.vue";
// import PublishLesson from "../../Components/Teacher/PublishLesson.vue";
// import DraftLesson from "../../Components/Teacher/DraftLesson.vue";

const props = defineProps({
    // lessons: Object,
    // total_learner_applied: Array,
    // total_lesson: Array,
    // amount_teacher: Array,
    // latest_review: Object,
});
// const latestLesson = () => {
//     for (let i = 0; i < props.lessons?.length; i++) {
//         if (props.lessons[i].id === props.latest_review.lesson_id) {
//             return props.lessons[i]
//         }
//     }
// }
</script>
<template>
    <LayoutDashboard>
        <div class="lessor__dashboard-container">
            <div class="lessor__dashboard-wrap">
                <div class="lessor__dashboard-title">
                    <div class="lessor__dashboard-title-item">{{ lang().label.teacher_dashboard.achievement }}</div>
                    <div class="lessor__dashboard-title-btn" @click="() => {}">
                        {{ lang().label.teacher_dashboard.more_button }}
                    </div>
                </div>
                <div class="lessor__dashboard-lesson">
                    <!-- <Achievement
                        :total_learner_applied="props.total_learner_applied"
                        :total_lesson="props.total_lesson"
                        :amount_teacher="props.amount_teacher"
                    /> -->
                </div>
            </div>
            <div class="lessor__dashboard-wrap">
                <div class="lessor__dashboard-title">
                    <div class="lessor__dashboard-title-item">
                        {{ lang().label.teacher_dashboard.lesson_feedbacks }}
                    </div>
                    <Link class="lessor__dashboard-title-btn" :href="route('top')">
                        {{ lang().label.teacher_dashboard.more_button }}
                    </Link>
                </div>
                <div
                    class="lessor__dashboard-lesson"
                >
                    <!-- <LessonFeedbacks
                        v-if="props.latest_review"
                        :lesson="latestLesson()"
                        :review_id="props.latest_review.id"
                    /> -->
                </div>
            </div>
            <div class="lessor__dashboard-wrap">
                <div class="lessor__dashboard-title">
                    <div class="lessor__dashboard-title-item">
                        {{ lang().label.teacher_dashboard.publish_lesson }}
                    </div>
                    <Link class="lessor__dashboard-title-btn" :href="route('top')">
                        {{ lang().label.teacher_dashboard.more_button }}
                    </Link>
                </div>
                <div class="lessor__dashboard-lesson">
                    <!-- <PublishLesson
                        :lessons="props.lessons"
                    /> -->
                </div>
            </div>
            <div class="lessor__dashboard-wrap">
                <div class="lessor__dashboard-title">
                    <div class="lessor__dashboard-title-item">
                        {{ lang().label.teacher_dashboard.draft_lesson }}
                    </div>
                    <Link class="lessor__dashboard-title-btn" :href="route('top')">
                        {{ lang().label.teacher_dashboard.more_button }}
                    </Link>
                </div>
                <div class="lessor__dashboard-lesson">
                    <!-- <DraftLesson
                        :lessons="props.lessons"
                    /> -->
                </div>
            </div>
        </div>
        <div class="lessor__dashboard-create">
            <Link
                class="lessor__dashboard-create-btn"
                :href="route('top')"
            >
                <img src="/img/icon/TeacherDashboard/plus.svg" alt="" />
                <p>{{ lang().label.teacher_dashboard.new_lesson }}</p>
            </Link>
        </div>
    </LayoutDashboard>
</template>
<style lang="scss" scoped>

</style>
