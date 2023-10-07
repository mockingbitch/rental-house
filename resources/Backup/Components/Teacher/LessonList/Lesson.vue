<script setup>
import { ref } from "vue";
import Modal from "../../Modal/Modal.vue";
import moment from "moment";
import { Link,useForm } from "@inertiajs/vue3";

import ButtonDeleteRequest from "@/Components/Request/ButtonDeleteRequest.vue";

const props = defineProps({
    lesson: Object,
});

const state = useForm({
    lesson_id: '',
});

const showMore = ref(false);
const showMoreLesson = () => {
    showMore.value = !showMore.value;
};

const isOpenChangeStatusDialog = ref(false)
const handleChangeStatus = (lesson_id) => {
    state.lesson_id = lesson_id
    isOpenChangeStatusDialog.value = true
}

const draftLesson = () => {
    state.post(route("draft.lesson"), {
        onSuccess: (e) => {
            location.reload()
        },
    });
}

const totalApplied = (lesson) => {
    let count = 0 
    for (let i = 0; i < lesson?.course[0]?.course_applications?.length; i++) {
        count += lesson?.course[0]?.course_applications[i]?.application_details?.length
    }

    return count
}
</script>
<template>
    <div class="card-lesson d-flex flex-column">
        <div class="base__lesson-container">
            <div class="base__lesson-content">
                <img
                    v-if="props.lesson?.cover_image"
                    :src="props.lesson?.cover_image"
                    class="base__lesson-avatar"
                />
                <img
                    v-else
                    src="../../../../../public/img/DraftLessonAvatar.png"
                    class="base__lesson-avatar"
                />
                <div class="base__lesson-content-info">
                    <div class="base__lesson-content-title">
                        <div
                            class="base__lesson-content-title-tag draft-lesson"
                            v-show="props.lesson?.status == 2"
                        >
                            Draft
                        </div>
                        <div
                            class="base__lesson-content-title-tag"
                            v-show="props.lesson?.status == 1"
                        >
                            公開
                        </div>
                        <div
                            class="base__lesson-content-title-tag reject-lesson"
                            v-show="props.lesson?.status == 6"
                        >
                            公開停止
                        </div>
                        <div
                            class="base__lesson-content-title-tag pending-lesson"
                            v-show="lesson?.status == 3"
                        >
                            審査中
                        </div>
                        <div
                            class="base__lesson-content-title-tag sendback-lesson"
                            v-show="lesson?.status == 4"
                        >
                            差戻し
                        </div>
                        <div
                            class="base__lesson-content-title-tag recall-lesson"
                            v-show="lesson?.status == 5"
                        >
                            差戻し
                        </div>
                        <div
                            class="base__lesson-content-title-name"
                            v-show="props.lesson?.title"
                        >
                            {{ props.lesson?.title }}
                        </div>
                        <div
                            class="base__lesson-content-title-name base__lesson-content-title-name-empty"
                            v-show="!props.lesson?.title"
                        >
                            （タイトルなし）
                        </div>
                    </div>
                    <div class="base__lesson-content-info1">
                        <div
                            class="base__lesson-content-info1-date"
                            v-show="props.lesson?.start_date"
                        >
                            {{ props.lesson?.start_date }}
                        </div>
                        <div
                            class="base__lesson-content-info1-date"
                            v-show="!props.lesson?.start_date"
                        >
                            {{ lang().label.lesson_course.date }} ー
                        </div>
                        <div
                            class="base__lesson-content-info1-price"
                            v-show="props.lesson?.price"
                        >
                            {{ lang().label.lesson_course.price }} {{ props.lesson?.price }}{{ lang().label.lesson_course.price_unit }}
                        </div>
                        <div
                            class="base__lesson-content-info1-price"
                            v-show="!props.lesson?.price"
                        >
                            {{ lang().label.lesson_course.price }} ー
                        </div>
                    </div>
                    <div class="base__lesson-content-info2">
                        <div class="base__lesson-content-info2-item">
                            <img
                                src="/img/icon/TeacherDashboard/user.svg"
                                alt=""
                            />
                            <div class="base__lesson-number">
                                <span>{{ totalApplied(props.lesson) }}</span>
                                <span>/</span>
                                <span v-show="props.lesson?.max_learner">
                                    {{ props.lesson?.max_learner }}
                                </span>
                                <span v-show="!props.lesson?.max_learner"
                                    >ー</span
                                >
                            </div>
                        </div>
                        <div class="base__lesson-content-info2-item">
                            <img
                                src="/img/icon/TeacherDashboard/eye.svg"
                                alt=""
                            />
                            <div
                                class="base__lesson-number"
                                v-show="props.lesson?.view"
                            >
                                {{ props.lesson?.view }}
                            </div>
                            <div
                                class="base__lesson-number"
                                v-show="!props.lesson?.view"
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
                                <span v-show="props.lesson?.lesson_hour > 0">
                                    {{ props.lesson?.lesson_hour }}h
                                </span>
                                <span v-show="props.lesson?.lesson_hour == 0">
                                </span>
                                <span
                                    v-show="!props.lesson?.lesson_hour == null"
                                >
                                    ー
                                </span>
                                <span v-show="props.lesson?.lesson_minute > 0">
                                    {{ props.lesson?.lesson_minute }}min
                                </span>
                                <span v-show="props.lesson?.lesson_minute == 0">
                                </span>
                                <span
                                    v-show="props.lesson?.lesson_minute == null"
                                >
                                    ー
                                </span>
                            </div>
                        </div>
                        <div
                            class="number-age"
                            v-show="
                                props.lesson?.target_age_from &&
                                props.lesson?.target_age_to
                            "
                        >
                            {{ lang().label.lesson_course.age }}
                            {{
                                props.lesson?.target_age_from +
                                "-" +
                                props.lesson?.target_age_to
                            }}
                        </div>
                        <div
                            class="number-age"
                            v-show="
                                !props.lesson?.target_age_from ||
                                !props.lesson?.target_age_to
                            "
                        >
                            {{ lang().label.lesson_course.age }} ー
                        </div>
                    </div>
                </div>
            </div>
            <Link class="base__lesson-edit" v-if="props.lesson?.status == 2" :href="route('edit.draft.lesson', {id: props.lesson?.id, draft: 'listLesson'})">
                <span class="edit-text">{{ lang().label.lesson_course.edit }}</span>
            </Link>
            <Link class="base__lesson-edit" v-if="props.lesson?.status == 1" :href="route('lesson.detail', props.lesson?.id)">
                <span class="edit-text">{{ lang().label.lesson_course.edit }}</span>
            </Link>
            <div class="base__lesson-edit" v-if="props.lesson?.status == 3" @click="handleChangeStatus(props.lesson?.id)">
                <span class="pending-text">申請取下げ</span>
            </div>
            <Link class="base__lesson-edit" v-if="props.lesson?.status == 4" >
                <span class="sendback-text">{{ lang().label.lesson_course.edit }}</span>
            </Link>
        </div>
        <div
            class="course-infomation d-flex flex-column"
            v-for="course in props.lesson?.course"
            v-if="showMore"
        >
            <div
                class="course-infomation-week d-flex flex-column justify-content-between"
            >
                <div class="label">{{ course.title }}</div>
                <div class="time-class d-flex justify-content-between">
                    <div class="">
                        <ul>
                            <li v-for="schedule in course.course_schedules">
                                {{ moment(schedule.date).format("YYYY/MM/DD") }}
                                {{ schedule.start_time }}~{{
                                    schedule.end_time
                                }}
                            </li>
                        </ul>
                    </div>
                    <div
                        class="base__lesson-edit d-flex justify-content-center align-items-center"
                        @click="() => {}"
                    >
                        <Link class="edit-text" v-if="props.lesson?.status == 1" :href="route('course.edit',course.id)">{{ lang().label.lesson_course.edit }}</Link>
                        <span
                            v-if="props.lesson?.status == 2"
                            class="button-red"
                            @click="showConfirmFormModal"
                        >
                            申請取下げ
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <Link
            v-if="props.lesson?.course?.length === 0 && props.lesson?.status != 2"
            :href="route('course.create', props.lesson.id)"
            class="course-infomation course-create d-flex justify-content-center"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
            >
                <path
                    d="M17.5 10C17.5 10.1658 17.4342 10.3247 17.3169 10.4419C17.1997 10.5592 17.0408 10.625 16.875 10.625H10.625V16.875C10.625 17.0408 10.5592 17.1997 10.4419 17.3169C10.3247 17.4342 10.1658 17.5 10 17.5C9.83424 17.5 9.67527 17.4342 9.55806 17.3169C9.44085 17.1997 9.375 17.0408 9.375 16.875V10.625H3.125C2.95924 10.625 2.80027 10.5592 2.68306 10.4419C2.56585 10.3247 2.5 10.1658 2.5 10C2.5 9.83424 2.56585 9.67527 2.68306 9.55806C2.80027 9.44085 2.95924 9.375 3.125 9.375H9.375V3.125C9.375 2.95924 9.44085 2.80027 9.55806 2.68306C9.67527 2.56585 9.83424 2.5 10 2.5C10.1658 2.5 10.3247 2.56585 10.4419 2.68306C10.5592 2.80027 10.625 2.95924 10.625 3.125V9.375H16.875C17.0408 9.375 17.1997 9.44085 17.3169 9.55806C17.4342 9.67527 17.5 9.83424 17.5 10Z"
                    fill="#5392F9 "
                />
            </svg>
            <span class="course-create-title">{{ lang().label.lesson_course.add_course }}</span>
        </Link>
        <div v-else>
            <Link
                v-if="showMore && props.lesson?.course?.length < props.lesson?.total_of_meets && props.lesson?.status != 2"
                :href="route('course.create', props.lesson.id)"
                class="course-infomation course-create d-flex justify-content-center"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                >
                    <path
                        d="M17.5 10C17.5 10.1658 17.4342 10.3247 17.3169 10.4419C17.1997 10.5592 17.0408 10.625 16.875 10.625H10.625V16.875C10.625 17.0408 10.5592 17.1997 10.4419 17.3169C10.3247 17.4342 10.1658 17.5 10 17.5C9.83424 17.5 9.67527 17.4342 9.55806 17.3169C9.44085 17.1997 9.375 17.0408 9.375 16.875V10.625H3.125C2.95924 10.625 2.80027 10.5592 2.68306 10.4419C2.56585 10.3247 2.5 10.1658 2.5 10C2.5 9.83424 2.56585 9.67527 2.68306 9.55806C2.80027 9.44085 2.95924 9.375 3.125 9.375H9.375V3.125C9.375 2.95924 9.44085 2.80027 9.55806 2.68306C9.67527 2.56585 9.83424 2.5 10 2.5C10.1658 2.5 10.3247 2.56585 10.4419 2.68306C10.5592 2.80027 10.625 2.95924 10.625 3.125V9.375H16.875C17.0408 9.375 17.1997 9.44085 17.3169 9.55806C17.4342 9.67527 17.5 9.83424 17.5 10Z"
                        fill="#5392F9 "
                    />
                </svg>
                <span class="course-create-title">{{ lang().label.lesson_course.add_course }}</span>
            </Link>
            <div
                class="course-infomation course-create d-flex justify-content-center"
                v-if="props.lesson?.status != 2"
            >
                <span class="course-create-showmore" @click="showMoreLesson">
                    <div v-if="showMore">Show less</div>
                    <div v-else>
                        {{ props.lesson?.course?.length }} {{ lang().label.lesson_course.course }} ({{ lang().label.lesson_course.show_more }})
                    </div></span
                >
            </div>
        </div>
        <!-- <Modal :showModal="showConfirmForm" @close="showConfirmForm = false">
            <div class="modal-container d-flex flex-column">
                <div class="modal-title d-flex justify-content-center">
                    審査中のレッスンを申請取下げします。
                </div>
                <div
                    class="modal-content d-flex flex-column align-items-center"
                >
                    <span>Are you sure to withdraw the lesson ?</span>
                    <span>The Lesson status change to draft status.</span>
                </div>
                <div class="modal-btn d-flex">
                    <div
                        class="modal-btn-btn modal-btn-btn-left d-flex align-items-center"
                        @click="closeModalConfirm"
                    >
                        キャンセル
                    </div>
                    <div
                        class="modal-btn-btn modal-btn-btn-right d-flex align-items-center"
                    >
                        申請取下げ
                    </div>
                </div>
            </div>
        </Modal> -->
        <Modal :showModal="isOpenChangeStatusDialog" @close="isOpenChangeStatusDialog = false">
            <div class="lesson-change-status-dialog-container">
                <div class="lesson-change-status-dialog-title">審査中のレッスンを申請取下げします。</div>
                <div class="lesson-change-status-dialog-content">Are you sure to withdraw the lesson ?
                The Lesson status change to draft status.</div>
                <div class="lesson-change-status-dialog-btn">
                    <ButtonDeleteRequest :label="'キャンセル'" @click="isOpenChangeStatusDialog = false" style="border: 1px solid #5392F9 ; color: #5392F9 "/>
                    <ButtonDeleteRequest :label="'申請取下げ'" :submit-button="true"  @click="draftLesson" />
                </div>
            </div>
        </Modal>
    </div>
</template>
<style lang="scss" scoped>
@import "../LessonList/LessonList";
.pending-lesson {
    background-color: #FFEDC9 !important;
    color: #1b1b1b !important;
    font-size: 16px;
}
.sendback-lesson {
    background-color: #FFE8EC !important;
    color: #E71A41 !important;
    font-size: 16px;
}
.recall-lesson {
    background-color: #E1EFF2 !important;
    color: #E71A41 !important;
    font-size: 16px;
}
.pending-text {
    color: #E71A41;
    text-decoration: underline;
    font-weight: 700;
    font-size: 16px;
}
.sendback-text {
    color: #5392F9 ;
    text-decoration: underline;
    font-weight: 700;
    font-size: 16px;
}
.base__lesson-avatar {
    border-radius: 4px !important;
}
.lesson-change-status-dialog-container {
    max-width: 368px;
    width: 100%;
    color: #1b1b1b;
}
.lesson-change-status-dialog-title {
    font-size: 16px;
    font-weight: 700;
    line-height: 160%;
    letter-spacing: -0.16px;
    text-align: center;
    padding: 0px 42px 16px;
}
.lesson-change-status-dialog-content {
    font-size: 14px;
    font-weight: 400;
    line-height: 160%;
    letter-spacing: -0.14px;
    text-align: center;
    padding: 0px 42px;
}
.lesson-change-status-dialog-btn {
    display: flex;
    gap: 16px;
}
.submit__button {
    margin-top: 16px !important;
}
</style>
