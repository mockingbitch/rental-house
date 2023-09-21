<script setup>
import { Link } from "@inertiajs/vue3";
import Achievement from "../../Components/Teacher/Achievement.vue";
import LessonFeedbacks from "../../Components/Teacher/LessonFeedbacks.vue";
import PublishLesson from "../../Components/Teacher/PublishLesson.vue";
import DraftLesson from "../../Components/Teacher/DraftLesson.vue";
import LayoutDashboard from "../../Layouts/LayoutDashboard.vue";

const props = defineProps({
    lessons: Object,
    total_learner_applied: Object,
    latest_review: Object,
});
const latestLesson = () => {
    for (let i = 0; i < props.lessons?.length; i++) {
        if (props.lessons[i].id === props.latest_review.lesson_id) {
            return props.lessons[i]
        }
    }
}
</script>
<template>
    <LayoutDashboard>
        <div class="teacher__dashboard-container">
            <div class="teacher__dashboard-wrap">
                <div class="teacher__dashboard-title">
                    <div class="teacher__dashboard-title-item">{{ lang().label.teacher_dashboard.achievement }}</div>
                    <div class="teacher__dashboard-title-btn" @click="() => {}">
                        {{ lang().label.teacher_dashboard.more_button }}
                    </div>
                </div>
                <div class="teacher__dashboard-lesson">
                    <Achievement
                        :lessons="props.lessons"
                        :total_learner_applied="props.total_learner_applied"
                    />
                </div>
            </div>
            <div class="teacher__dashboard-wrap">
                <div class="teacher__dashboard-title">
                    <div class="teacher__dashboard-title-item">
                        {{ lang().label.teacher_dashboard.lesson_feedbacks }}
                    </div>
                    <Link class="teacher__dashboard-title-btn" :href="route('total.review')">
                        {{ lang().label.teacher_dashboard.more_button }}
                    </Link>
                </div>
                <div
                    class="teacher__dashboard-lesson"
                >
                    <LessonFeedbacks
                        v-if="props.latest_review"
                        :lesson="latestLesson()"
                        :review_id="props.latest_review.id"
                    />
                </div>
            </div>
            <div class="teacher__dashboard-wrap">
                <div class="teacher__dashboard-title">
                    <div class="teacher__dashboard-title-item">
                        {{ lang().label.teacher_dashboard.publish_lesson }}
                    </div>
                    <Link class="teacher__dashboard-title-btn" :href="route('lesson.list', {selected: 1})">
                        {{ lang().label.teacher_dashboard.more_button }}
                    </Link>
                </div>
                <div class="teacher__dashboard-lesson">
                    <PublishLesson
                        :lessons="props.lessons"
                    />
                </div>
            </div>
            <div class="teacher__dashboard-wrap">
                <div class="teacher__dashboard-title">
                    <div class="teacher__dashboard-title-item">
                        {{ lang().label.teacher_dashboard.draft_lesson }}
                    </div>
                    <Link class="teacher__dashboard-title-btn" :href="route('lesson.list', {selected: 2})">
                        {{ lang().label.teacher_dashboard.more_button }}
                    </Link>
                </div>
                <div class="teacher__dashboard-lesson">
                    <DraftLesson
                        :lessons="props.lessons"
                    />
                </div>
            </div>
        </div>
        <div class="teacher__dashboard-create">
            <Link
                class="teacher__dashboard-create-btn"
                :href="route('create.lesson')"
            >
                <img src="/img/icon/TeacherDashboard/plus.svg" alt="" />
                <p>{{ lang().label.teacher_dashboard.new_lesson }}</p>
            </Link>
        </div>
    </LayoutDashboard>
</template>
<style lang="scss" scoped>
.teacher__dashboard-container {
    padding: 16px;
    font-size: 14px;
    max-width: 505px;
    margin: 0 auto;
}
.teacher__dashboard-wrap {
    padding-bottom: 40px;
}
.teacher__dashboard-lesson {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.teacher__dashboard-title {
    display: flex;
    justify-content: space-between;
    padding-bottom: 24px;
}
.teacher__dashboard-title-item {
    font-size: 16px;
    font-weight: bold;
}
.teacher__dashboard-title-btn {
    text-decoration: underline;
    cursor: pointer;
    color: #1b1b1b;
}
.teacher__dashboard-create {
    display: flex;
    justify-content: center;
}
.teacher__dashboard-create-btn {
    position: fixed;
    bottom: 86px;
    border-radius: 100px;

    display: flex;
    background-color: #418997;
    width: 250px;
    max-height: 50px;
    align-items: center;
    justify-content: center;
    color: white;
    gap: 10px;
    padding: 16px;
    font-size: 16px;
    z-index: 100;
    font-weight: bold;
    line-height: 1.6;
    letter-spacing: -0.14px;
}
@media all and (max-width: 991px) {
    .teacher__dashboard-create-btn {
        bottom: 60px;
    }
}
@media all and (max-width: 768px) {
    .teacher__dashboard-create-btn {
        max-width: 145px;
        max-height: 38px;
        font-size: 14px;
        padding: 8px 16px;
        font-size: 14px;
        gap: 6px;
    }
}
</style>
