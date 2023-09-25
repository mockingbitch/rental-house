<script setup>
import Step1 from "@/Pages/Lesson/Step1.vue";
import Step2 from "@/Pages/Lesson/Step2.vue";
import Step3 from "@/Pages/Lesson/Step3.vue";
import MultiStep from "@/Components/Multistep/MultiStep.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, onBeforeUnmount } from "vue";
import { Link } from "@inertiajs/vue3";
import Breadcrumb from "../../Components/Breadcrumb.vue";
import LayoutDashboard from "../../Layouts/LayoutDashboard.vue";

const props = defineProps({
    request_id: String,
    draft_lesson: Object,
    previous_page: String,
});
const state = useForm({
    step: 1,
    saveDraft: true,
});
const breadcrumbItems = [
    { text: "Dashboard", isLink: false, href: "teacher.dashboard" },
    { text: "News Lesson", isLink: false },
];

onBeforeUnmount(() => {
    if (state.saveDraft == true) {
        formLesson.post(route("save.draft"), {
            onSuccess: (e) => {},
        });
    }
});

const formFill = computed(() => {
    if (
        state.step == 1 &&
        formLesson.title &&
        formLesson.category_id &&
        formLesson.description &&
        formLesson.target_age_from &&
        formLesson.target_age_to &&
        formLesson.min_learner &&
        formLesson.max_learner &&
        formLesson.language &&
        formLesson.number_of_meets &&
        (formLesson.lesson_hour || formLesson.lesson_hour == 0) &&
        (formLesson.lesson_minute || formLesson.lesson_minute == 0) &&
        formLesson.total_of_meets &&
        formLesson.currency &&
        formLesson.price &&
        formLesson.weekday?.length === formLesson.number_of_meets &&
        formLesson.start_time &&
        formLesson.end_time
    ) {
        if (formLesson.lesson_hour == 0 && formLesson.lesson_minute == 0) {
            return false;
        }
        return true;
    }
    if (
        state.step == 2 &&
        formLesson.cover_image &&
        formLesson.short_video_for_parent &&
        formLesson.lesson_content &&
        formLesson.teacher_experience
    ) {
        return true;
    }
    if (state.step == 3) {
        return true;
    }
});

const previousStep = () => {
    var stepCount = state.step - 1;
    if (state.step <= 1) {
        state.step = 1;
    } else {
        state.step = stepCount;
    }
};

const saveDraft = () => {
    state.saveDraft = false;
    formLesson.post(route("save.draft"), {
        onSuccess: (e) => {},
    });
};

const updateDraft = () => {
    state.saveDraft = false;
    formLesson.post(route("update.draft"), {
        onSuccess: (e) => {},
    });
};

const submit = (e) => {
    if (state.step == 1) {
        state.saveDraft = false;
        formLesson.post(route("create.lesson.step1"), {
            onSuccess: (e) => {
                state.step = 2;
            },
        });
    } else if (state.step == 2) {
        state.saveDraft = false;
        formLesson.post(route("create.lesson.step2"), {
            onSuccess: (e) => {
                state.step = 3;
            },
        });
    } else if (state.step == 3) {
        state.saveDraft = false;
        if (props.draft_lesson?.id) {
            formLesson.post(
                route("update.draft.lesson", props.draft_lesson?.id),
                {
                    onSuccess: (e) => {},
                }
            );
        } else {
            formLesson.post(route("create.lesson.step3"), {
                onSuccess: (e) => {},
            });
        }
    }
};

const formLesson = useForm({
    title: props.draft_lesson ? props.draft_lesson.title : "",
    category_id: props.draft_lesson ? props.draft_lesson.category_id : "",
    description: props.draft_lesson ? props.draft_lesson.description : "",
    target_age_from: props.draft_lesson
        ? props.draft_lesson.target_age_from
        : "",
    target_age_to: props.draft_lesson ? props.draft_lesson.target_age_to : "",
    min_learner: props.draft_lesson ? props.draft_lesson.min_learner : "",
    max_learner: props.draft_lesson ? props.draft_lesson.max_learner : "",
    language: props.draft_lesson ? props.draft_lesson.language : "1",
    style: props.draft_lesson ? props.draft_lesson.style : "1",
    number_of_meets: props.draft_lesson
        ? props.draft_lesson.number_of_meets
        : "",
    lesson_hour: props.draft_lesson ? props.draft_lesson.lesson_hour : "",
    lesson_minute: props.draft_lesson ? props.draft_lesson.lesson_minute : "",
    total_of_meets: props.draft_lesson ? props.draft_lesson.total_of_meets : "",
    currency: props.draft_lesson ? props.draft_lesson.currency : "2",
    price: props.draft_lesson ? props.draft_lesson.price : "",
    cover_image: "",
    short_video_for_parent: "",
    short_video_for_learner: "",
    template: props.draft_lesson ? props.draft_lesson.template : "",
    lesson_content: props.draft_lesson ? props.draft_lesson.lesson_content : "",
    teacher_experience: props.draft_lesson
        ? props.draft_lesson.teacher_experience
        : "",
    note: props.draft_lesson ? props.draft_lesson.note : "",

    file_upload: ["", "", ""],
    previewFileName: ["", "", ""],

    imagePreview: "",
    imageName: "",

    childVidPreview: "",
    childVidName: "",
    short_video_for_learner_thumbnail: "",

    parentVidPreview: "",
    parentVidName: "",
    short_video_for_parent_thumbnail: "",

    weekday: [],
    start_time: "",
    end_time: "",

    request_id: props.request_id,
    previous_page: props.previous_page ? props.previous_page : "",
    lesson_id: props.draft_lesson ? props.draft_lesson.id : "",
});

const addMoreFile = () => {
    formLesson.file_upload.push("");
    formLesson.previewFileName.push("");
};

const updateFormLesson = (value, field) => {
    formLesson[field] = value;
};
</script>
<template>
    <LayoutDashboard>
        <div class="signin2">
            <Breadcrumb :items="breadcrumbItems" />
            <div class="container">
                <form class="form" @submit.prevent="submit">
                    <div class="form__wrap">
                        <div
                            v-if="state.step === 2 || state.step === 3"
                            class="back-btn-mobile"
                        >
                            <label
                                for="Category"
                                style="display: flex; align-items: center"
                            >
                                <span id="close">
                                    <svg
                                        width="14"
                                        height="14"
                                        viewBox="0 0 14 14"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M9.05963 11.0657C9.10028 11.1064 9.13252 11.1546 9.15452 11.2077C9.17652 11.2608 9.18784 11.3178 9.18784 11.3752C9.18784 11.4327 9.17652 11.4897 9.15452 11.5428C9.13252 11.5959 9.10028 11.6441 9.05963 11.6848C9.01898 11.7254 8.97073 11.7577 8.91762 11.7797C8.86451 11.8017 8.80759 11.813 8.7501 11.813C8.69262 11.813 8.63569 11.8017 8.58258 11.7797C8.52947 11.7577 8.48122 11.7254 8.44057 11.6848L4.06557 7.30977C4.02489 7.26914 3.99262 7.22089 3.97061 7.16778C3.94859 7.11467 3.93726 7.05774 3.93726 7.00024C3.93726 6.94275 3.94859 6.88582 3.97061 6.83271C3.99262 6.7796 4.02489 6.73134 4.06557 6.69071L8.44057 2.31571C8.52266 2.23362 8.634 2.1875 8.7501 2.1875C8.8662 2.1875 8.97754 2.23362 9.05963 2.31571C9.14172 2.3978 9.18784 2.50915 9.18784 2.62524C9.18784 2.74134 9.14172 2.85268 9.05963 2.93477L4.99362 7.00024L9.05963 11.0657Z"
                                            fill="#5392F9 "
                                        />
                                    </svg>
                                </span>
                                <span
                                    class="back-btn-text"
                                    @click="previousStep"
                                    >戻る</span
                                >
                            </label>
                        </div>
                        <MultiStep :step="state.step" />
                        <Step1
                            v-if="state.step == 1"
                            :formLesson="formLesson"
                            @updateDataForm="updateFormLesson"
                        />
                        <Step2
                            v-if="state.step == 2"
                            :formLesson="formLesson"
                        />
                        <Step3
                            v-if="state.step == 3"
                            :formLesson="formLesson"
                            @addMoreFile="addMoreFile"
                        />
                        <div class="form__wrap-item">
                            <span
                                class="label-double"
                                for="Category"
                                v-if="state.step === 1"
                            >
                                <span id="close">
                                    <svg
                                        width="14"
                                        height="14"
                                        viewBox="0 0 14 14"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M11.247 10.6282C11.2877 10.6689 11.3199 10.7171 11.3419 10.7702C11.3639 10.8233 11.3752 10.8803 11.3752 10.9377C11.3752 10.9952 11.3639 11.0522 11.3419 11.1053C11.3199 11.1584 11.2877 11.2066 11.247 11.2473C11.2064 11.2879 11.1581 11.3202 11.105 11.3422C11.0519 11.3642 10.995 11.3755 10.9375 11.3755C10.88 11.3755 10.8231 11.3642 10.77 11.3422C10.7169 11.3202 10.6686 11.2879 10.628 11.2473L7 7.61876L3.37203 11.2473C3.28994 11.3294 3.1786 11.3755 3.0625 11.3755C2.9464 11.3755 2.83506 11.3294 2.75297 11.2473C2.67088 11.1652 2.62476 11.0538 2.62476 10.9377C2.62476 10.8216 2.67088 10.7103 2.75297 10.6282L6.38148 7.00024L2.75297 3.37227C2.67088 3.29018 2.62476 3.17884 2.62476 3.06274C2.62476 2.94665 2.67088 2.8353 2.75297 2.75321C2.83506 2.67112 2.9464 2.625 3.0625 2.625C3.1786 2.625 3.28994 2.67112 3.37203 2.75321L7 6.38173L10.628 2.75321C10.7101 2.67112 10.8214 2.625 10.9375 2.625C11.0536 2.625 11.1649 2.67112 11.247 2.75321C11.3291 2.8353 11.3752 2.94665 11.3752 3.06274C11.3752 3.17884 11.3291 3.29018 11.247 3.37227L7.61851 7.00024L11.247 10.6282Z"
                                            fill="#5392F9 "
                                        />
                                    </svg>
                                </span>
                                <Link
                                    id="clear-form"
                                    :href="route('teacher.dashboard')"
                                    @click="state.saveDraft = false"
                                    >{{ lang().label.create_lesson.cancel }}</Link
                                >
                            </span>
                            <label
                                for="Category"
                                v-if="state.step === 2 || state.step === 3"
                            >
                                <span id="close">
                                    <svg
                                        width="14"
                                        height="14"
                                        viewBox="0 0 14 14"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M9.05963 11.0657C9.10028 11.1064 9.13252 11.1546 9.15452 11.2077C9.17652 11.2608 9.18784 11.3178 9.18784 11.3752C9.18784 11.4327 9.17652 11.4897 9.15452 11.5428C9.13252 11.5959 9.10028 11.6441 9.05963 11.6848C9.01898 11.7254 8.97073 11.7577 8.91762 11.7797C8.86451 11.8017 8.80759 11.813 8.7501 11.813C8.69262 11.813 8.63569 11.8017 8.58258 11.7797C8.52947 11.7577 8.48122 11.7254 8.44057 11.6848L4.06557 7.30977C4.02489 7.26914 3.99262 7.22089 3.97061 7.16778C3.94859 7.11467 3.93726 7.05774 3.93726 7.00024C3.93726 6.94275 3.94859 6.88582 3.97061 6.83271C3.99262 6.7796 4.02489 6.73134 4.06557 6.69071L8.44057 2.31571C8.52266 2.23362 8.634 2.1875 8.7501 2.1875C8.8662 2.1875 8.97754 2.23362 9.05963 2.31571C9.14172 2.3978 9.18784 2.50915 9.18784 2.62524C9.18784 2.74134 9.14172 2.85268 9.05963 2.93477L4.99362 7.00024L9.05963 11.0657Z"
                                            fill="#5392F9 "
                                        />
                                    </svg>
                                </span>
                                <span id="clear-form" @click="previousStep"
                                    >戻る</span
                                >
                            </label>
                            <div id="form-wrap-double">
                                <div class="save-draft" @click="saveDraft">
                                    {{ lang().label.create_lesson.save_to_draft }}
                                </div>
                                <button
                                    class="next-step"
                                    :class="formFill ? 'full-fill' : 'un-fill'"
                                >
                                    <div>
                                        <span
                                            v-if="
                                                state.step == 1 ||
                                                state.step == 2
                                            "
                                            >{{ lang().label.create_lesson.next }}</span
                                        >
                                        <span v-if="state.step == 3"
                                            >登録する</span
                                        >
                                        <svg
                                            width="21"
                                            height="20"
                                            viewBox="0 0 21 20"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M14.6922 10.4425L8.44217 16.6925C8.3841 16.7506 8.31516 16.7967 8.23929 16.8281C8.16342 16.8595 8.0821 16.8757 7.99998 16.8757C7.91786 16.8757 7.83654 16.8595 7.76067 16.8281C7.6848 16.7967 7.61586 16.7506 7.55779 16.6925C7.49972 16.6345 7.45366 16.5655 7.42224 16.4897C7.39081 16.4138 7.37463 16.3325 7.37463 16.2503C7.37463 16.1682 7.39081 16.0869 7.42224 16.011C7.45366 15.9352 7.49972 15.8662 7.55779 15.8082L13.3664 10.0003L7.55779 4.19253C7.44052 4.07526 7.37463 3.9162 7.37463 3.75035C7.37463 3.5845 7.44052 3.42544 7.55779 3.30816C7.67507 3.19088 7.83413 3.125 7.99998 3.125C8.16583 3.125 8.32489 3.19088 8.44217 3.30816L14.6922 9.55816C14.7503 9.61621 14.7964 9.68514 14.8278 9.76101C14.8593 9.83688 14.8755 9.91821 14.8755 10.0003C14.8755 10.0825 14.8593 10.1638 14.8278 10.2397C14.7964 10.3156 14.7503 10.3845 14.6922 10.4425Z"
                                                fill="#989898"
                                            />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </LayoutDashboard>
</template>
<style lang="scss" scoped>
@import "../../../../public/scss/imports/core/mixins";
@import "../../../../public/scss/imports/core/variables";
@import "./_lesson.scss";
#form-wrap-double {
    gap: 20px;
}
.back-btn-mobile {
    display: none;

    @include mobile {
        width: 100%;
        height: 50px;
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }
    .back-btn-text {
        margin-left: 10px;
        color: #5392F9 ;
        font-family: Noto Sans JP;
        font-size: 12px;
        font-style: normal;
        font-weight: 400;
        line-height: 160%; /* 19.2px */
        letter-spacing: -0.12px;
        text-decoration-line: underline;
    }
}
</style>
