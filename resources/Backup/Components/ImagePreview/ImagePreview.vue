<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import Popup from "@/Components/Popup/Popup.vue";
import UlError from "@/Components/UlError.vue";

const props = defineProps({
    formLesson: Object,
    message: Object,
});

const stateImage = useForm({
    imagePreview: props.formLesson.imagePreview,
    imageName: props.formLesson.imagePreview,
    uploadValidate: '',
});

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {

        var allowedExtensions = /(\.jpeg|\.png|\.jpg|\.gif|\.bmp)$/i;

        if (!allowedExtensions.exec(file.name)) {
            stateImage.uploadValidate = 'ファイル形式が正しくありません。JPEG、JPG、PNG、GIF、BMP形式の画像をアップロードしてください';
        } else {
            stateImage.imagePreview = reader.result;
            props.formLesson.imagePreview = reader.result;
            stateImage.imageName = file.name;
            props.formLesson.imageName = file.name;
            stateImage.uploadValidate = '';
        }
    };

    reader.readAsDataURL(file);
};

const resetImagePreview = () => {
    document.getElementById('true-image-upload').value = ''
    stateImage.imagePreview = ''
    props.formLesson.cover_image = ''
    props.formLesson.imagePreview = ''
}
const isOpen = ref(false);
</script>
<template>
    <div
        class="file-name"
        v-if="props.formLesson.imagePreview"
        :style="{'background-image':`url(${props.formLesson.imagePreview})`}"
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
        <span>{{ props.formLesson.imageName.substring(0, 30) + "..." }}</span>
    </div>
    <label
        for="true-image-upload"
        class="file-upload-clone"
        v-if="props.formLesson.imagePreview == ''"
    >
        <svg
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M16.25 4.375H14.0844L13.0195 2.77813C12.9625 2.69262 12.8852 2.6225 12.7946 2.57399C12.704 2.52548 12.6028 2.50006 12.5 2.5H7.5C7.39721 2.50006 7.29602 2.52548 7.2054 2.57399C7.11478 2.6225 7.03752 2.69262 6.98047 2.77813L5.91484 4.375H3.75C3.25272 4.375 2.77581 4.57254 2.42417 4.92417C2.07254 5.27581 1.875 5.75272 1.875 6.25V15C1.875 15.4973 2.07254 15.9742 2.42417 16.3258C2.77581 16.6775 3.25272 16.875 3.75 16.875H16.25C16.7473 16.875 17.2242 16.6775 17.5758 16.3258C17.9275 15.9742 18.125 15.4973 18.125 15V6.25C18.125 5.75272 17.9275 5.27581 17.5758 4.92417C17.2242 4.57254 16.7473 4.375 16.25 4.375ZM16.875 15C16.875 15.1658 16.8092 15.3247 16.6919 15.4419C16.5747 15.5592 16.4158 15.625 16.25 15.625H3.75C3.58424 15.625 3.42527 15.5592 3.30806 15.4419C3.19085 15.3247 3.125 15.1658 3.125 15V6.25C3.125 6.08424 3.19085 5.92527 3.30806 5.80806C3.42527 5.69085 3.58424 5.625 3.75 5.625H6.25C6.35292 5.62507 6.45427 5.59971 6.54504 5.5512C6.63581 5.50268 6.71319 5.43249 6.77031 5.34688L7.83437 3.75H12.1648L13.2297 5.34688C13.2868 5.43249 13.3642 5.50268 13.455 5.5512C13.5457 5.59971 13.6471 5.62507 13.75 5.625H16.25C16.4158 5.625 16.5747 5.69085 16.6919 5.80806C16.8092 5.92527 16.875 6.08424 16.875 6.25V15ZM10 6.875C9.32013 6.875 8.65552 7.07661 8.09023 7.45432C7.52493 7.83204 7.08434 8.3689 6.82416 8.99703C6.56399 9.62515 6.49591 10.3163 6.62855 10.9831C6.76119 11.6499 7.08858 12.2624 7.56932 12.7432C8.05006 13.2239 8.66257 13.5513 9.32938 13.6839C9.99619 13.8166 10.6874 13.7485 11.3155 13.4883C11.9436 13.2282 12.4805 12.7876 12.8582 12.2223C13.2359 11.657 13.4375 10.9924 13.4375 10.3125C13.4365 9.40114 13.074 8.52739 12.4295 7.88296C11.7851 7.23853 10.9114 6.87603 10 6.875ZM10 12.5C9.56735 12.5 9.14442 12.3717 8.78469 12.1313C8.42496 11.891 8.14458 11.5493 7.97901 11.1496C7.81345 10.7499 7.77013 10.3101 7.85453 9.88574C7.93894 9.46141 8.14728 9.07163 8.4532 8.7657C8.75913 8.45978 9.14891 8.25144 9.57324 8.16703C9.99757 8.08263 10.4374 8.12595 10.8371 8.29151C11.2368 8.45708 11.5785 8.73746 11.8188 9.09719C12.0592 9.45692 12.1875 9.87985 12.1875 10.3125C12.1875 10.8927 11.957 11.4491 11.5468 11.8593C11.1366 12.2695 10.5802 12.5 10 12.5Z"
                fill="white"
            />
        </svg>
        <span>画像をアップロード</span>
    </label>
    <input
        type="file"
        @change="handleFileUpload"
        id="true-image-upload"
        name="cover_image"
        hidden
        @input="props.formLesson.cover_image = $event.target.files[0]"
    />
    <UlError :message="props.message" v-show="stateImage.uploadValidate == ''"/>
    <UlError :message="stateImage.uploadValidate" />
    <Popup :isOpen="isOpen" @close="isOpen = false" :state="stateImage" @resetImagePreview="resetImagePreview"/>
</template>
<style lang="scss" scoped>
@import "./_imagePreview.scss";
</style>
