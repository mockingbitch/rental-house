<script setup>
import { ref, computed } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import LayoutDashBoard from "@/Layouts/LayoutDashboard.vue";
import BaseLesson from "../Common/BaseLesson.vue";
import CourseMeetingInfo from "./CourseMeetingInfo.vue";
import StudentMember from "./StudentMember.vue";
import ApplicationDeadline from "./ApplicationDeadline.vue";
import Modal from "../../Modal/Modal.vue";
import Breadcrumb from "../../Breadcrumb.vue";
import SubHeader from "../../Common/SubHeader.vue";

const props = defineProps({
    lesson: Object,
    course: Object,
    update: Boolean,
    create: Boolean,
});

const lang = () => {
    return usePage().props.language.original
}

const breadcrumbItems = [
    { text: "Dashboard", isLink: true },
    { text: "Lesson TITLE Lesson TITLE", isLink: true },
    { text: "Course", isLink: false },
];

const showConfirmFormDeleteCourse = ref(false);

const showConfirmDeleteCourse = () => {
    showConfirmFormDeleteCourse.value = true;
};
const closeConfirmDeleteCourse = () => {
    showConfirmFormDeleteCourse.value = false;
};

const form = useForm({
    weekday: [],
    course_title: props.course ? props.course?.title : lang().label.lesson_course.course_title,
    course_schedules: props.update ? [...props.course?.course_schedules] : [],
    course_deadline: props.update ? props.course?.deadline : "",
});

const formFill = computed(() => {
    if (
        form.course_title &&
        form.course_schedules.length == props.lesson.total_of_meets &&
        form.course_deadline
    ) {
        return true;
    } else {
        return false;
    }
});

const createCourse = () => {
    form.post(route("post.course.create", props.lesson.id), {
        onError: (e) => {
            alert(e.message);
        },
        onSuccess: (e) => {},
    });
};

const updateCourse = () => {
    form.post(route("post.course.edit", props.course.id), {
        onError: (e) => {
            alert(e.message);
        },
        onSuccess: (e) => {},
    });
};

const deleteCourse = () => {
    form.post(route("post.course.delete", props.course.id), {
        onSuccess: (e) => {},
    });
};

const totalKidApplied = () => {
    let count = 0;
    let appliedKidArr = [];
    for (let i = 0; i < props.course?.course_applications?.length; i++) {
        if (props.course?.course_applications[i].status == "1") {
            count +=
                props.course?.course_applications[i].application_details
                    ?.length;
            for (
                let j = 0;
                j <
                props.course.course_applications[i].application_details?.length;
                j++
            ) {
                props.course.course_applications[i].application_details[
                    j
                ].question = JSON.parse(
                    props.course?.course_applications[i].learner_question
                )[0].question;
                props.course.course_applications[i].application_details[
                    j
                ].applied_date = props.course.course_applications[i].created_at;
                appliedKidArr.push(
                    props.course.course_applications[i].application_details[j]
                );
            }
        }
    }

    return { count, appliedKidArr };
};
</script>
<template>
    <LayoutDashBoard>
        <SubHeader
            :label="'コース詳細'"
            href="lesson.list"
            is-close
            is-dashboard
        />
        <Breadcrumb :items="breadcrumbItems" />
        <div
            class="edit-course-container d-flex justify-content-center flex-column"
        >
            <div class="mb-4 edit-course-header">
                <SubHeader
                    :label="'コース詳細'"
                    href="lesson.list"
                    is-close
                    hide-on-sp
                />
            </div>
            <BaseLesson :lessons="[props.lesson]" :is-display-icon="true" />
            <CourseMeetingInfo
                :form="form"
                :lesson="lesson"
                :total-kid-applied="totalKidApplied"
                :update="props.update"
            />
            <StudentMember
                :update="props.update"
                :lesson="lesson"
                :total-kid-applied="totalKidApplied"
            />
            <ApplicationDeadline
                :form="form"
                :total-kid-applied="totalKidApplied"
            />
            <div class="edit-course-container-button d-flex flex-column">
                <div
                    class="double-button d-flex align-items-center justify-content-center"
                >
                    <Link
                        class="double-button-left d-flex justify-content-center"
                        :href="route('lesson.list')"
                    >
                        {{ lang().label.lesson_course.cancel }}
                    </Link>
                    <!-- Button Update -->
                    <div
                        v-if="
                            formFill &&
                            props.update &&
                            totalKidApplied().count == 0
                        "
                        class="double-button-right d-flex justify-content-center align-items-center"
                        @click="updateCourse"
                    >
                        <span class="">{{ lang().label.lesson_course.update }}</span>
                    </div>
                    <div
                        class="double-button-right-disabled d-flex justify-content-center align-items-center"
                        v-if="
                            (!formFill || totalKidApplied().count > 0) &&
                            props.update
                        "
                    >
                        <span class="">{{ lang().label.lesson_course.update }}</span>
                    </div>
                    <!-- Button Create -->
                    <div
                        class="double-button-right d-flex justify-content-center align-items-center"
                        @click="createCourse"
                        v-if="formFill && props.create"
                    >
                        <span class="">{{ lang().label.lesson_course.publish_schedule }}</span>
                    </div>
                    <div
                        class="double-button-right-disabled d-flex justify-content-center align-items-center"
                        v-if="!formFill && props.create"
                    >
                        <span class="">{{ lang().label.lesson_course.publish_schedule }}</span>
                    </div>
                </div>
                <div
                    @click="showConfirmDeleteCourse"
                    class="button-delete d-flex align-items-center justify-content-center"
                >
                    <span
                        class="button-delete-content"
                        v-if="props.update && totalKidApplied().count == 0"
                        >{{ lang().label.lesson_course.delete_course }}</span
                    >
                </div>
            </div>
            <Modal
                :showModal="showConfirmFormDeleteCourse"
                @close="showConfirmFormDeleteCourse = false"
            >
                <div class="modal-container d-flex flex-column">
                    <div class="modal-title d-flex justify-content-center">
                        すべてのコースを削除します。
                    </div>
                    <div
                        class="modal-content d-flex flex-column align-items-center"
                    >
                        <span>(仮)削除すると復元ができません。</span>
                        <span>本当によろしいですか？</span>
                        <span>などなどなどなど</span>
                    </div>
                    <div class="modal-note d-flex justify-content-center">
                        <span class="modal-note-content"
                            >※注意点注意点注意点注意点注意点注意点</span
                        >
                    </div>
                    <div class="modal-btn d-flex">
                        <div
                            class="modal-btn-btn modal-btn-btn-left d-flex align-items-center"
                            @click="closeConfirmDeleteCourse"
                        >
                            {{ lang().label.lesson_course.cancel }}
                        </div>
                        <div
                            class="modal-btn-btn modal-btn-btn-right d-flex align-items-center"
                            @click="deleteCourse"
                        >
                            {{ lang().label.lesson_course.delete_course }}
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </LayoutDashBoard>
</template>
<style lang="scss" scoped>
@import "../CourseCreate/CourseCreate";
</style>
