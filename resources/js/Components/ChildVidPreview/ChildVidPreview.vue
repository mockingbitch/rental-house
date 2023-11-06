<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import Popup from "@/Components/Popup/Popup.vue";
import UlError from "@/Components/UlError.vue";

const props = defineProps({
    formLesson: Object,
    message: Object,
    title: String,
    resetContent: String,
});

const stateChild = useForm({
    childVidPreview: props.formLesson.childVidPreview,
    childVidName: props.formLesson.childVidName,
    short_video_for_learner_thumbnail: props.formLesson.short_video_for_learner_thumbnail,
    uploadValidate: "",
});

const snapImage = function (video, url) {
    const canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
    const image = canvas.toDataURL();
    const success = image.length > 100000;
    if (success) {
        props.formLesson.short_video_for_learner_thumbnail = image;
    }

    return success;
};

const handleChildVidUpload = (event) => {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = () => {
        var allowedExtensions = /(\.avi|\.mov|\.mp4|\.webm|\.flv)$/i;

        if (!allowedExtensions.exec(file.name)) {
            stateChild.uploadValidate =
                "ファイル形式が正しくありません。MP4、AVI、MOV、WEBM、FLV形式の画像をアップロードしてください";
        } else {
            stateChild.uploadValidate = "";
            stateChild.childVidName = file.name;
            props.formLesson.childVidName = file.name;
            const blob = new Blob([reader.result], { type: file.type });
            const url = URL.createObjectURL(blob);
            stateChild.childVidPreview = url;
            props.formLesson.childVidPreview = url;

            const video = document.createElement("video");
            const timeupdate = function () {
                if (snapImage(video, url)) {
                    video.removeEventListener("timeupdate", timeupdate);
                    video.pause();
                }
            };
            video.addEventListener("loadeddata", function () {
                if (snapImage(video, url)) {
                    video.removeEventListener("timeupdate", timeupdate);
                }
            });
            video.addEventListener("timeupdate", timeupdate);
            video.preload = "metadata";
            video.src = url;
            // Load video in Safari / IE11
            video.muted = true;
            video.playsInline = true;
            video.play();
        }
    };
    reader.readAsArrayBuffer(file);
};

const isOpen = ref(false);

const resetChildVid = () => {
    document.getElementById("true-file-upload-child").value = "";
    stateChild.childVidPreview = "";
    props.formLesson.short_video_for_learner = "";
    props.formLesson.childVidPreview = "";
};
</script>
<template>
    <div
        class="file-name"
        v-if="props.formLesson.childVidPreview"
        :style="{
            'background-image': `url(${props.formLesson.short_video_for_learner_thumbnail})`,
        }"
        @click="isOpen = true"
    >
        <svg
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M17.9423 6.06754L7.94229 16.0675C7.88425 16.1256 7.81531 16.1717 7.73944 16.2032C7.66357 16.2347 7.58224 16.2508 7.5001 16.2508C7.41797 16.2508 7.33664 16.2347 7.26077 16.2032C7.18489 16.1717 7.11596 16.1256 7.05792 16.0675L2.68292 11.6925C2.56564 11.5753 2.49976 11.4162 2.49976 11.2503C2.49976 11.0845 2.56564 10.9254 2.68292 10.8082C2.80019 10.6909 2.95925 10.625 3.1251 10.625C3.29096 10.625 3.45002 10.6909 3.56729 10.8082L7.5001 14.7418L17.0579 5.18316C17.1752 5.06588 17.3343 5 17.5001 5C17.666 5 17.825 5.06588 17.9423 5.18316C18.0596 5.30044 18.1255 5.4595 18.1255 5.62535C18.1255 5.7912 18.0596 5.95026 17.9423 6.06754Z"
                fill="white"
            />
        </svg>
        <span>{{
            props.formLesson.childVidName.substring(0, 30) + "..."
        }}</span>
    </div>

    <label
        for="true-file-upload-child"
        class="file-upload-clone"
        v-if="props.formLesson.childVidPreview == '' || props.formLesson.childVidPreview == null"
    >
        <svg
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M16.875 3.125H3.125C2.79348 3.125 2.47554 3.2567 2.24112 3.49112C2.0067 3.72554 1.875 4.04348 1.875 4.375V15.625C1.875 15.9565 2.0067 16.2745 2.24112 16.5089C2.47554 16.7433 2.79348 16.875 3.125 16.875H16.875C17.2065 16.875 17.5245 16.7433 17.7589 16.5089C17.9933 16.2745 18.125 15.9565 18.125 15.625V4.375C18.125 4.04348 17.9933 3.72554 17.7589 3.49112C17.5245 3.2567 17.2065 3.125 16.875 3.125ZM3.125 6.875H9.375V13.125H3.125V6.875ZM10.625 5.625V4.375H13.125V5.625H10.625ZM9.375 5.625H6.875V4.375H9.375V5.625ZM9.375 14.375V15.625H6.875V14.375H9.375ZM10.625 14.375H13.125V15.625H10.625V14.375ZM10.625 13.125V6.875H16.875V13.125H10.625ZM16.875 5.625H14.375V4.375H16.875V5.625ZM5.625 4.375V5.625H3.125V4.375H5.625ZM3.125 14.375H5.625V15.625H3.125V14.375ZM16.875 15.625H14.375V14.375H16.875V15.625Z"
                fill="white"
            />
        </svg>
        <span>{{ lang().label.onboarding.button.upload_video }}</span>
    </label>
    <input
        accept="video/*"
        type="file"
        @change="handleChildVidUpload"
        id="true-file-upload-child"
        name="short_video_for_learner"
        hidden
        @input="formLesson.short_video_for_learner = $event.target.files[0]"
    />
    <UlError
        :message="props.message"
        v-show="stateChild.uploadValidate == ''"
    />
    <UlError :message="stateChild.uploadValidate" />
    <Popup
        :isOpen="isOpen"
        @close="isOpen = false"
        :state="stateChild"
        @resetChildVid="resetChildVid"
        :title="props.title"
        :reset-content="props.resetContent"
    />
</template>
<style lang="scss" scoped>
@import "./_childVidPreview.scss";
</style>
