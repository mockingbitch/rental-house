<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    course: Object,
});

const totalApplied = (application) => {
    let count = 0;
    for (let i = 0; i < application.length; i++) {
        if (application[i].status == '1') {
            count += application[i].application_details.length;
        }
    }

    return count;
};

</script>
<template>
    <div>
        <Link class="base__reserved-container" :href="route('lesson.detail', props.course?.lesson?.id)">
            <div class="base__reserved-content">
                <img :src="props.course?.lesson?.cover_image" class="base__reserved-avatar" />
                <div class="base__reserved-content-info">
                    <div class="base__reserved-content-title">
                        <div
                            class="base__reserved-content-title-tag"
                            v-show="props.course?.lesson?.status == 1"
                        >
						{{ lang().label.user.reserved.lesson_status_public }}
                        </div>
                        <div
                            class="base__reserved-content-title-tag ended-lesson"
                            v-show="props.course?.lesson?.status == 8"
                        >
                            終了
                        </div>
                        <div
                            class="base__reserved-content-title-name"
                            v-show="props.course?.lesson?.title"
                        >
                            {{ props.course?.lesson?.title }}
                        </div>
                        <div
                            class="base__reserved-content-title-name"
                            v-show="!props.course?.lesson?.title"
                        >
                            （タイトルなし）
                        </div>
                    </div>
                    <div class="base__reserved-content-info1">
                        <div
                            class="base__reserved-content-info1-date d-flex align-items-center"
                            v-show="props.course?.lesson?.teacher.nick_name"
                        >
                            <img :src="props.course?.lesson?.teacher.avatar" width="20" height="20" />
                            <div>{{ props.course?.lesson?.teacher.nick_name }}</div>
                        </div>
                        <div
                            class="base__reserved-content-info1-date"
                            v-show="!props.course?.lesson?.teacher.nick_name"
                        >
                            Teacher name ー
                        </div>
                    </div>
                    <div class="base__reserved-content-info2">
                        <div class="base__reserved-content-info2-item">
                            <img
                                src="/img/icon/TeacherDashboard/user.svg"
                                alt=""
                            />
                            <div class="base__reserved-number">
                                <span>{{ totalApplied(props.course?.course_applications) }}</span>
                                <span>/</span>
                                <span v-show="props.course?.max_seat">
                                    {{ props.course?.max_seat }}
                                </span>
                                <span v-show="!props.course?.max_seat">ー</span>
                            </div>
                        </div>
                        <div class="base__reserved-content-info2-item">
                            <img
                                src="/img/icon/TeacherDashboard/clock.svg"
                                alt=""
                            />
                            <div class="base__reserved-number">
                                <span v-show="props.course?.lesson.lesson_hour > 0">
                                    {{ props.course?.lesson.lesson_hour }}h
                                </span>
                                <span v-show="props.course?.lesson.lesson_hour == 0"> </span>
                                <span v-show="!props.course?.lesson.lesson_hour == null">
                                    ー
                                </span>
                                <span v-show="props.course?.lesson.lesson_minute > 0">
                                    {{ props.course?.lesson.lesson_minute }}{{ lang().label.user.reserved.label_time }}
                                </span>
                                <span v-show="props.course?.lesson.lesson_minute == 0">
                                </span>
                                <span v-show="props.course?.lesson.lesson_minute == null">
                                    ー
                                </span>
                            </div>
                        </div>
                        <div
                            class="number-age"
                            v-show="
                                props.course?.lesson.target_age_from && props.course?.lesson.target_age_to
                            "
                        >
						{{ lang().label.user.reserved.label_age }}
                            {{
                                props.course?.lesson.target_age_from +
                                "-" +
                                props.course?.lesson.target_age_to
                            }}
                        </div>
                        <div
                            class="number-age"
                            v-show="
                                !props.course?.lesson.target_age_from ||
                                !props.course?.lesson.target_age_to
                            "
                        >
                            Age ー
                        </div>
                    </div>
                </div>
            </div>
            <div class="base__reserved-footer" @click="() => {}">
                <img src="/img/icon/TeacherDashboard/next.svg" alt="" />
            </div>
        </Link>
    </div>
</template>
<style lang="scss" scoped>
.base__reserved-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 6px;
    color: black;
}
.base__reserved-container:hover {
    cursor: pointer;
}
.base__reserved-content {
    display: flex;
    align-items: center;
    gap: 6px;
}
.base__reserved-content-title {
    display: flex;
    align-items: center;
    gap: 4px;
}
.base__reserved-content-title-tag {
    padding: 2px 4px;
    background-color: #e1eff2;
    border-radius: 4px;
    font-size: 10px;
    color: #5392F9 ;
}
.ended-lesson {
    background-color: #989898 !important;
    color: #fff !important;
}
.base__reserved-content-title-name {
    font-weight: bold;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 16px;
    color: #1b1b1b;
}
.base__reserved-content-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    line-height: 1.6;
    white-space: nowrap;
    max-width: 250px;
}
@media all and (max-width: 480px) {
    .base__reserved-content-info {
        max-width: 200px;
    }
}
@media all and (max-width: 340px) {
    .base__reserved-content-info {
        max-width: 150px;
    }
}
.base__reserved-content-info1 {
    display: flex;
    gap: 10px;
}

.base__reserved-content-info1-date {
    font-size: 10px;
    gap: 4px;
    img {
        border-radius: 100%;
    }
}

.base__reserved-content-info2 {
    display: flex;
    gap: 10px;
    color: #989898;
}
.base__reserved-content-info2-item {
    display: flex;
    align-items: center;
    gap: 2px;
    .base__reserved-number {
        font-size: 10px;
    }
}

.number-age {
    font-size: 10px;
}
.base__reserved-avatar {
    width: 64px;
    height: 64px;
    background-color: rgba(255, 230, 234, 0.678);
    border-radius: 8px;
}
.base__reserved-footer {
    cursor: pointer;
}
</style>
