<script setup>
import Modal from "@/Components/Modal/Modal.vue";

const props = defineProps({
    item: Object,
    isOpen: Boolean,
    previewFileName: Object,
    state: Object,
    title: String,
    resetContent: String,
});
</script>
<template>
    <Modal :showModal="props.isOpen" @close="props.isOpen = false">
        <div class="pop-up" v-show="isOpen">
            <!-- <h1 v-if="props.state.videoPreview">レッスンカバーの画像</h1> -->
            <h1 v-if="props.state.previewFileName">Lesson {{ item }}</h1>
            <h1 v-if="props.state.videoName">
                {{ props.title || "Short video" }}
                <br />
            </h1>
            <div class="popup-filename" v-if="props.state.previewFileName">
                <p>{{ props.state.previewFileName }}</p>
            </div>
            <img
                class="popup-fileimage"
                v-if="props.state.shortVideoThumbnail"
                :src="props.state.shortVideoThumbnail"
            />
            <video
                controls
                class="video-preview"
                v-if="props.state.videoPreview"
                :src="props.state.videoPreview"
            ></video>
            <div id="form-wrap-double" v-if="props.state.previewFileName">
                <label
                    class="file-change"
                    :for="'true-file-upload-' + props.item"
                >
                    <svg
                        width="21"
                        height="21"
                        viewBox="0 0 21 21"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M18 10.5C18 10.6658 17.9342 10.8247 17.8169 10.9419C17.6997 11.0592 17.5408 11.125 17.375 11.125H11.125V17.375C11.125 17.5408 11.0592 17.6997 10.9419 17.8169C10.8247 17.9342 10.6658 18 10.5 18C10.3342 18 10.1753 17.9342 10.0581 17.8169C9.94085 17.6997 9.875 17.5408 9.875 17.375V11.125H3.625C3.45924 11.125 3.30027 11.0592 3.18306 10.9419C3.06585 10.8247 3 10.6658 3 10.5C3 10.3342 3.06585 10.1753 3.18306 10.0581C3.30027 9.94085 3.45924 9.875 3.625 9.875H9.875V3.625C9.875 3.45924 9.94085 3.30027 10.0581 3.18306C10.1753 3.06585 10.3342 3 10.5 3C10.6658 3 10.8247 3.06585 10.9419 3.18306C11.0592 3.30027 11.125 3.45924 11.125 3.625V9.875H17.375C17.5408 9.875 17.6997 9.94085 17.8169 10.0581C17.9342 10.1753 18 10.3342 18 10.5Z"
                            fill="#5392F9 "
                        />
                    </svg>
                    Upload
                </label>
            </div>
            <div id="form-wrap-double" v-if="props.state.videoPreview">
                <label class="file-change" for="true-image-upload">
                    <svg
                        width="21"
                        height="21"
                        viewBox="0 0 21 21"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M18 10.5C18 10.6658 17.9342 10.8247 17.8169 10.9419C17.6997 11.0592 17.5408 11.125 17.375 11.125H11.125V17.375C11.125 17.5408 11.0592 17.6997 10.9419 17.8169C10.8247 17.9342 10.6658 18 10.5 18C10.3342 18 10.1753 17.9342 10.0581 17.8169C9.94085 17.6997 9.875 17.5408 9.875 17.375V11.125H3.625C3.45924 11.125 3.30027 11.0592 3.18306 10.9419C3.06585 10.8247 3 10.6658 3 10.5C3 10.3342 3.06585 10.1753 3.18306 10.0581C3.30027 9.94085 3.45924 9.875 3.625 9.875H9.875V3.625C9.875 3.45924 9.94085 3.30027 10.0581 3.18306C10.1753 3.06585 10.3342 3 10.5 3C10.6658 3 10.8247 3.06585 10.9419 3.18306C11.0592 3.30027 11.125 3.45924 11.125 3.625V9.875H17.375C17.5408 9.875 17.6997 9.94085 17.8169 10.0581C17.9342 10.1753 18 10.3342 18 10.5Z"
                            fill="#5392F9 "
                        />
                    </svg>
                    Upload
                </label>
            </div>
            <p
                class="popup-text"
                @click="$emit('close'), $emit('resetInput')"
                v-if="props.state.previewFileName"
            >
                Clear content
            </p>
            <p
                class="popup-text"
                @click="$emit('close'), $emit('resetvideoPreview')"
                v-if="props.state.videoPreview"
            >
                Close
            </p>
            <p
                class="popup-text"
                @click="$emit('close'), $emit('resetChildVid')"
                v-if="props.state.videoPreview"
            >
                {{ props.resetContent || "Delete video" }}
            </p>
            <div class="line"></div>
            <div class="form__wrap-item">
                <div class="close-pop-up" @click="$emit('close')">
                    <span>OK</span>
                </div>
            </div>
        </div>
    </Modal>
</template>
<style lang="scss" scoped>
@import "./_popup.scss";
</style>
