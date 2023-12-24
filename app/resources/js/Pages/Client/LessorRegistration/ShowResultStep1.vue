<script setup>
import { useForm } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import ButtonCommon from "@/Components/Button/ButtonCommon.vue";
import Breadcrumb from "@/Components/Breadcrumb/Breadcrumb.vue";

const props = defineProps({
    dataStep1: Object,
    showButtonConfirm: Number,
});

const breadcrumbItems =
    props.showButtonConfirm !== 2
        ? [
            { text: "Dashboard", isLink: true },
            { text: "Confirm", isLink: true },
            { text: "最終確認", isLink: false },
        ]
        : [
            { text: "Dashboard", isLink: true },
            { text: "Confirm", isLink: false },
        ];
const emits = defineEmits();

const form = useForm({
    step: 1,
    confirm: false,
    shortVideoThumbnail: props.dataStep1?.short_video_for_learner_thumbnail || "",
    shortVideo: props.dataStep1?.short_video_for_learner || "",
    profileImage: props.dataStep1?.profileImage || "",
    profileImagePreview: props.dataStep1?.profileImagePreview || "",
    firstName: props.dataStep1?.firstName || "",
    lastName: props.dataStep1?.lastName || "",
    year: props.dataStep1?.year || "",
    month: props.dataStep1?.month || "",
    day: props.dataStep1?.day || "",
    email: props.dataStep1?.email || "",
    phone: props.dataStep1?.phone || "",
    about: props.dataStep1?.about || "",
});

const backToOnBoard = () => {
    emits("back-to-onboarding");
    emits("save-data", props.dataStep1);
};
const confirmStep1 = () => {
    form.confirm = true;
    form.post(route("lessor.register.step1"), {
        onFinish: () => {
            if (
                Object.keys(form.errors).length === 0 &&
                form.errors.constructor === Object
            ) {
            console.log('test');
                emits("confirm-step1", props.dataStep1);
            }
        }
    });
};
const BackToOnboarding = () => {
    emits("move-to-onboarding");
};
const handleClickFunction = () => {
    if (props.showButtonConfirm !== 2) {
        backToOnBoard();
    } else {
        BackToOnboarding();
    }
};

const handleBreadcrumbClick = (item) => {
    if (item.isLink === true && props.showButtonConfirm !== 2) {
        if (item.text === 'setting account') {
            backToOnBoard();
        }
    }
    if (item.text === "Dashboard") {
        BackToOnboarding();
    }
};
</script>

<template>
    <Layout
        :show-result-step="1"
        :title="'Setting Account'"
        @handle-click="handleClickFunction()"
    >
        <Breadcrumb
            :items="breadcrumbItems"
            @handleClick="handleBreadcrumbClick"
        />
        <div class="step-container">
            <div
                class="step-container-header d-flex align-items-center justify-content-center"
            >
                <img
                    src="/img/icon/arrownLeft.svg"
                    alt=""
                    @click="handleClickFunction()"
                />
                <span
                    class="step-container-header-content"
                >
                    Setting Account
                </span>
            </div>
            <div class="step-container-title d-flex justify-content-center">
                <span
                    v-if="props.showButtonConfirm !== 2"
                >
                    Please check your information again
                </span>
                <span
                    v-else style="color: #5392F9"
                >
                    Setting account
                </span>
            </div>

            <div
                class="result-content d-flex flex-column align-items-center"
                style="height: 146px"
            >
                <div class="result-content-title">Profile image</div>
                <div class="result-content-img">
                    <img :src="props.dataStep1?.profileImagePreview || props.dataStep1?.profileImage" alt="" />
                </div>
            </div>
            <div
                class="result-content video-preview d-flex flex-column align-items-center"
                style="height: 202px"
                v-if="props.dataStep1?.videoPreview"
            >
                <div style="height: 19px">Introduction video</div>
                <div style="width: 263px; height: 146px">
                    <video
                        :src="props.dataStep1?.videoPreview"
                        controls
                        style="width: 263px; height: 146px"
                    ></video>
                </div>
            </div>
            <div class="result-content">
                <div class="result-content-group first-content">
                    <div class="title-content">Name</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.firstName }}
                        {{ props.dataStep1?.lastName }}
                    </div>
                </div>
                <div class="result-content-group last-content">
                    <div class="title-content">Birthday</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.year }}/{{
                            props.dataStep1?.month
                        }}/{{ props.dataStep1?.day }}
                    </div>
                </div>
            </div>
            <div class="result-content">
                <div class="result-content-group first-content">
                    <div class="title-content">Email</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.email }}
                    </div>
                </div>
                <div class="result-content-group last-content">
                    <div class="title-content">Phone</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.phone }}
                    </div>
                </div>
            </div>
            <div class="result-content">
                <div class="result-content-group last-content">
                    <div class="title-content">About me</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.about }}
                    </div>
                </div>
            </div>

            <ul class="note" style="margin-top: 16px">
                <li>・(Tentative) It will take about n days from application to approval.</li>
                <li>・(Temporary) Once you apply, you cannot redo it.</li>
                <li>・(Tentative) Personal information is ~ blah blah blah.</li>
            </ul>
            <div class="button-container">
                <div
                    v-if="props.showButtonConfirm !== 2"
                    class="create__request-button"
                >
                    <div class="lineFull"></div>
                    <ButtonCommon
                        :label="'Back'"
                        :submit-button="false"
                        class="create__request-button-left"
                        @click="backToOnBoard"
                    />
                    <ButtonCommon
                        :label="'Confirm'"
                        :submit-button="true"
                        class="create__request-button-right"
                        @click="confirmStep1"
                    />
                </div>
            </div>
        </div>
    </Layout>
</template>

<style lang="scss" scoped>
@import "./resultstep";
</style>
