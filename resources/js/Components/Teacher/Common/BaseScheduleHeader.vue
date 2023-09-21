<script setup>
import { Link } from "@inertiajs/vue3";
const currentUrl = window.location.pathname;
</script>
<template>
    <div class="create-course-header d-flex justify-content-center">
        <div
            class="create-course-header-tab d-flex justify-content-center align-items-center"
        >
            <Link
                class="create-course-header-tab-item"
                :class="{ isActive: currentUrl.includes('/teacher/lesson') }"
                :href="route('lesson.list')"
            >
                {{ lang().label.course_header.lesson_course }}
            </Link>
            <Link
                class="create-course-header-tab-item"
                :class="{ isActive: currentUrl.includes('/teacher/schedule') }"
                :href="route('schedule.list')"
                >{{ lang().label.course_header.schedule }}</Link
            >
            <Link
                class="create-course-header-tab-item"
                :class="{ isActive: currentUrl.includes('/teacher/record') }"
                :href="route('record.list', 1)"
                >{{ lang().label.course_header.lesson_record }}</Link
            >
        </div>
        <div class="lineFull"></div>
    </div>
</template>
<style scoped lang="scss">
.create-course-header {
    height: 54px;
    position: relative;
    &-tab {
        width: 100%;
        padding: 15px 0 0;
        &-item {
            display: flex;
            justify-content: center;
            flex: 1;
            flex-grow: 1;
            font-size: 14px;
            padding-bottom: 15px;
            line-height: 19.2px;
            color: #4d4d4d;
            font-weight: 400;
            line-height: 160%;
            letter-spacing: -0.14px;
            cursor: pointer;
        }
        .isActive {
            font-weight: bold;
            color: #418997;
            border-bottom: 2px solid #418997;
        }
    }
}
</style>
