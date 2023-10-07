<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Popup from "@/Components/Popup/Popup.vue";
import UlError from "@/Components/UlError.vue";

const props = defineProps({
    item: Number,
    formLesson: Object,
    message: Object,
});

const isOpen = ref(false);

const state = useForm({
    previewFileName: props.formLesson.previewFileName[props.item - 1],
    uploadValidate: '',
});

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {

        var allowedExtensions = /(\.pdf)$/i;
             
        if (!allowedExtensions.exec(file.name)) {
            state.uploadValidate = 'ファイル形式が正しくありません。PDF形式のファイルをアップロードしてください';
        } else {
            state.previewFileName = file.name;
            props.formLesson.previewFileName[props.item - 1] = file.name;
            props.formLesson.file_upload[props.item - 1] = file;
            state.uploadValidate = '';
        }
    };
    reader.readAsDataURL(file);
};

const resetInput = (item) => {
    state.previewFileName = ''
    props.formLesson.file_upload[item-1] = ''
    props.formLesson.previewFileName[item-1] = ''
} 
</script>
<template>
    <label for="Title">{{ lang().label.create_lesson.field.lesson }} {{ props.item }} </label>
    <div class="file-name" v-if="props.formLesson.previewFileName[props.item - 1]" @click="isOpen = true">
        <svg
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M17.942 6.06754L7.94205 16.0675C7.884 16.1256 7.81507 16.1717 7.7392 16.2032C7.66332 16.2347 7.58199 16.2508 7.49986 16.2508C7.41772 16.2508 7.3364 16.2347 7.26052 16.2032C7.18465 16.1717 7.11572 16.1256 7.05767 16.0675L2.68267 11.6925C2.5654 11.5753 2.49951 11.4162 2.49951 11.2503C2.49951 11.0845 2.5654 10.9254 2.68267 10.8082C2.79995 10.6909 2.95901 10.625 3.12486 10.625C3.29071 10.625 3.44977 10.6909 3.56705 10.8082L7.49986 14.7418L17.0577 5.18316C17.1749 5.06588 17.334 5 17.4999 5C17.6657 5 17.8248 5.06588 17.942 5.18316C18.0593 5.30044 18.1252 5.4595 18.1252 5.62535C18.1252 5.7912 18.0593 5.95026 17.942 6.06754Z"
                fill="white"
            />
        </svg>
        <span>{{ props.formLesson.previewFileName[props.item - 1].substring(0, 30) + "..." }}</span>
    </div>
    <label
        :for="'true-file-upload-' + props.item"
        class="file-upload-clone"
        v-if="props.formLesson.previewFileName[props.item - 1] == ''"
    >
        <svg
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M16.6922 6.43281L12.3172 2.05781C12.2591 1.99979 12.1902 1.95378 12.1143 1.92241C12.0384 1.89105 11.9571 1.87494 11.875 1.875H4.375C4.04348 1.875 3.72554 2.0067 3.49112 2.24112C3.2567 2.47554 3.125 2.79348 3.125 3.125V16.875C3.125 17.2065 3.2567 17.5245 3.49112 17.7589C3.72554 17.9933 4.04348 18.125 4.375 18.125H15.625C15.9565 18.125 16.2745 17.9933 16.5089 17.7589C16.7433 17.5245 16.875 17.2065 16.875 16.875V6.875C16.8751 6.7929 16.859 6.71159 16.8276 6.63572C16.7962 6.55985 16.7502 6.4909 16.6922 6.43281ZM12.5 4.00859L14.7414 6.25H12.5V4.00859ZM15.625 16.875H4.375V3.125H11.25V6.875C11.25 7.04076 11.3158 7.19973 11.4331 7.31694C11.5503 7.43415 11.7092 7.5 11.875 7.5H15.625V16.875ZM13.125 10.625C13.125 10.7908 13.0592 10.9497 12.9419 11.0669C12.8247 11.1842 12.6658 11.25 12.5 11.25H7.5C7.33424 11.25 7.17527 11.1842 7.05806 11.0669C6.94085 10.9497 6.875 10.7908 6.875 10.625C6.875 10.4592 6.94085 10.3003 7.05806 10.1831C7.17527 10.0658 7.33424 10 7.5 10H12.5C12.6658 10 12.8247 10.0658 12.9419 10.1831C13.0592 10.3003 13.125 10.4592 13.125 10.625ZM13.125 13.125C13.125 13.2908 13.0592 13.4497 12.9419 13.5669C12.8247 13.6842 12.6658 13.75 12.5 13.75H7.5C7.33424 13.75 7.17527 13.6842 7.05806 13.5669C6.94085 13.4497 6.875 13.2908 6.875 13.125C6.875 12.9592 6.94085 12.8003 7.05806 12.6831C7.17527 12.5658 7.33424 12.5 7.5 12.5H12.5C12.6658 12.5 12.8247 12.5658 12.9419 12.6831C13.0592 12.8003 13.125 12.9592 13.125 13.125Z"
                fill="white"
            />
        </svg>
        <span>ファイルをアップロード</span>
    </label>
    <input
        type="file"
        @change="handleFileUpload($event, props.item)"
        :id="'true-file-upload-' + props.item"
        name="file"
        hidden
        @input="formLesson.file = $event.target.files[0]"
    />
    <UlError :message="props.message" v-show="state.uploadValidate == ''"/>
    <UlError :message="state.uploadValidate" />
    <ul class="note">
        <li>※ ファイルの形式</li>
        <li>※ ファイルの容量制限</li>
    </ul>
    <Popup :item="props.item" :isOpen="isOpen" @close="isOpen = false" :state="state" @resetInput="resetInput(props.item)"/>
</template>
<style lang="scss" scoped>
@import "./_inputPreview.scss";
</style>
