<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    lessons: Array,
    draft: Boolean,
    isDisplayIcon: Boolean,
    maxWidth: Boolean,
});

const totalApplied = (lesson) => {
    let count = 0;
    for (let i = 0; i < lesson?.course[0]?.course_applications?.length; i++) {
        count +=
            lesson?.course[0]?.course_applications[i]?.application_details
                ?.length;
    }

    return count;
};
</script>
<template>
    <div>
        <Link
            :href="
                lesson.status == 2
                    ? route('edit.draft.lesson', {
                          id: lesson.id,
                          draft: 'dashboard',
                      })
                    : route('lesson.detail', lesson.id)
            "
            class="base__lesson-container"
            v-for="lesson in props.lessons"
        >
            <div
                class="base__lesson-content"
                :style="props.maxWidth ? 'max-width: 100% !important' : ''"
            >
                <img :src="lesson?.cover_image" class="base__lesson-avatar" />
                <div
                    class="base__lesson-content-info"
                    :style="
                        props.maxWidth
                            ? 'max-width: calc(100% - 70px) !important'
                            : ''
                    "
                >
                    <div class="base__lesson-content-title">
                        <div
                            class="base__lesson-content-title-tag fake-lesson"
                            v-show="lesson?.status == 10"
                        >
                            終了
                        </div>
                        <div
                            class="base__lesson-content-title-tag draft-lesson"
                            v-show="lesson?.status == 2"
                        >
                            Draft
                        </div>
                        <div
                            class="base__lesson-content-title-tag"
                            v-show="lesson?.status == 1"
                        >
                            公開
                        </div>
                        <div
                            class="base__lesson-content-title-tag reject-lesson"
                            v-show="lesson?.status == 6"
                        >
                            公開停止
                        </div>
                        <div
                            class="base__lesson-content-title-name"
                            v-show="lesson?.title"
                        >
                            {{ lesson?.title }}
                        </div>
                        <div
                            class="base__lesson-content-title-name"
                            v-show="!lesson?.title"
                        >
                            （タイトルなし）
                        </div>
                    </div>
                    <div class="base__lesson-content-info1">
                        <div
                            class="base__lesson-content-info1-date"
                            v-show="lesson?.start_date"
                        >
                            {{ lesson?.start_date }}
                        </div>
                        <div
                            class="base__lesson-content-info1-date"
                            v-show="!lesson?.start_date"
                        >
                            date ー
                        </div>
                        <div
                            class="base__lesson-content-info1-price"
                            v-show="lesson?.price"
                        >
                        {{ lang().label.teacher_dashboard.price }} {{ lesson?.price }}{{ lang().label.teacher_dashboard.price_unit }}
                        </div>
                        <div
                            class="base__lesson-content-info1-price"
                            v-show="!lesson?.price"
                        >
                            Price ー
                        </div>
                    </div>
                    <div class="base__lesson-content-info2">
                        <div class="base__lesson-content-info2-item">
                            <img
                                src="/img/icon/TeacherDashboard/user.svg"
                                alt=""
                            />
                            <div class="base__lesson-number">
                                <span>{{ totalApplied(lesson) }}</span>
                                <span>/</span>
                                <span v-show="lesson?.max_learner">
                                    {{ lesson?.max_learner }}
                                </span>
                                <span v-show="!lesson?.max_learner">ー</span>
                            </div>
                        </div>
                        <div class="base__lesson-content-info2-item">
                            <img
                                src="/img/icon/TeacherDashboard/eye.svg"
                                alt=""
                            />
                            <div
                                class="base__lesson-number"
                                v-show="lesson?.view"
                            >
                                {{ lesson?.view }}
                            </div>
                            <div
                                class="base__lesson-number"
                                v-show="!lesson?.view"
                            >
                                0
                            </div>
                        </div>
                        <div class="base__lesson-content-info2-item">
                            <img
                                src="/img/icon/TeacherDashboard/clock.svg"
                                alt=""
                            />
                            <div class="base__lesson-number">
                                <span v-show="lesson?.lesson_hour > 0">
                                    {{ lesson?.lesson_hour }}h
                                </span>
                                <span v-show="lesson?.lesson_hour == 0"> </span>
                                <span v-show="!lesson?.lesson_hour == null">
                                    ー
                                </span>
                                <span v-show="lesson?.lesson_minute > 0">
                                    {{ lesson?.lesson_minute }}{{ lang().label.teacher_dashboard.min }}
                                </span>
                                <span v-show="lesson?.lesson_minute == 0">
                                </span>
                                <span v-show="lesson?.lesson_minute == null">
                                    ー
                                </span>
                            </div>
                        </div>
                        <div
                            class="number-age"
                            v-show="
                                lesson?.target_age_from && lesson?.target_age_to
                            "
                        >
                        {{ lang().label.teacher_dashboard.age }}
                            {{
                                lesson?.target_age_from +
                                "-" +
                                lesson?.target_age_to
                            }}
                        </div>
                        <div
                            class="number-age"
                            v-show="
                                !lesson?.target_age_from ||
                                !lesson?.target_age_to
                            "
                        >
                            Age ー
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="base__lesson-footer"
                @click="() => {}"
                v-if="!props.isDisplayIcon"
            >
                <img src="/img/icon/TeacherDashboard/next.svg" alt="" />
            </div>
        </Link>
    </div>
</template>
<style lang="scss" scoped>
.base__lesson-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 6px;
    color: black;
}
.base__lesson-container:hover {
    cursor: pointer;
}
.base__lesson-content {
    display: flex;
    align-items: center;
    gap: 6px;
}
.base__lesson-content-title {
    display: flex;
    align-items: center;
    gap: 4px;
}
.base__lesson-content-title-tag {
    padding: 2px 4px;
    background-color: #e1eff2;
    border-radius: 4px;
    font-size: 10px;
    color: #418997;
}
.draft-lesson {
    background-color: #ffedc9 !important;
    color: #faad14 !important;
}

.reject-lesson {
    background-color: #e3e3e3 !important;
    color: #1b1b1b !important;
}
.base__lesson-content-title-name {
    font-weight: bold;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 12px;
}
.base__lesson-content-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    line-height: 1.6;
    white-space: nowrap;
    max-width: 250px;
}
@media all and (max-width: 480px) {
    .base__lesson-content-info {
        max-width: 200px;
    }
}
@media all and (max-width: 340px) {
    .base__lesson-content-info {
        max-width: 150px;
    }
}
.base__lesson-content-info1 {
    display: flex;
    gap: 10px;
}

.base__lesson-content-info1-date {
    font-size: 10px;
}

.base__lesson-content-info1-price {
    font-size: 10px;
}
.base__lesson-content-info2 {
    display: flex;
    gap: 10px;
    color: #989898;
}
.base__lesson-content-info2-item {
    display: flex;
    align-items: center;
    gap: 2px;
    .base__lesson-number {
        font-size: 10px;
    }
}

.number-age {
    font-size: 10px;
}
.base__lesson-avatar {
    width: 64px;
    height: 64px;
    background-color: rgba(255, 230, 234, 0.678);
    border-radius: 8px;
}
.base__lesson-footer {
    cursor: pointer;
}

.fake-lesson {
    color: #ffffff;
    background-color: #989898;
}
</style>
