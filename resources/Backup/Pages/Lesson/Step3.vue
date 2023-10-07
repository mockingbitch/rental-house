<script setup>
import InputPreview from "@/Components/InputPreview/InputPreview.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import UlError from "@/Components/UlError.vue";

const page = usePage();

const props = defineProps({
    formLesson: Object,
    message: Object,
});
</script>
<template>
    <div class="upload-material">
        <h2>{{ lang().label.multi_step.step_3 }}</h2>
        <p>Available google slide,ppt....etc... abcdefg12345</p>
        <p>あいうえおあいうえおあいうえおあいうえお</p>
    </div>
    <div
        class="form__wrap-item"
        v-for="item in props.formLesson.file_upload.length"
    >
        <InputPreview
            :item="item"
            :formLesson="props.formLesson"
            :message="
                page.props.errors['file_upload.' + (item - 1)]
                    ? page.props.errors['file_upload.' + (item - 1)]
                    : null
            "
        />
    </div>
    <div @click="$emit('addMoreFile')" class="upload-more-file">
        <svg
            width="25"
            height="24"
            viewBox="0 0 25 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M21.5 12C21.5 12.1989 21.421 12.3897 21.2803 12.5303C21.1397 12.671 20.9489 12.75 20.75 12.75H13.25V20.25C13.25 20.4489 13.171 20.6397 13.0303 20.7803C12.8897 20.921 12.6989 21 12.5 21C12.3011 21 12.1103 20.921 11.9697 20.7803C11.829 20.6397 11.75 20.4489 11.75 20.25V12.75H4.25C4.05109 12.75 3.86032 12.671 3.71967 12.5303C3.57902 12.3897 3.5 12.1989 3.5 12C3.5 11.8011 3.57902 11.6103 3.71967 11.4697C3.86032 11.329 4.05109 11.25 4.25 11.25H11.75V3.75C11.75 3.55109 11.829 3.36032 11.9697 3.21967C12.1103 3.07902 12.3011 3 12.5 3C12.6989 3 12.8897 3.07902 13.0303 3.21967C13.171 3.36032 13.25 3.55109 13.25 3.75V11.25H20.75C20.9489 11.25 21.1397 11.329 21.2803 11.4697C21.421 11.6103 21.5 11.8011 21.5 12Z"
                fill="#1B1B1B"
            />
        </svg>
        <span>{{ lang().label.create_lesson.field.more_lesson }}</span>
    </div>
</template>
<style lang="scss" scoped>
@import "../../../../public/scss/imports/core/mixins";
@import "../../../../public/scss/imports/core/variables";
@import "./_lesson.scss";

:deep(.modal) {
    width: 400px;
    padding: 32px 26.667px 26.667px 26.667px;

    h1 {
        margin-top: 0;
        margin-bottom: 26.67px;
    }
    .pop-up {
        width: 100%;
    }

    .popup-filename {
        margin-bottom: 0;
    }

    #form-wrap-double {
        margin: 10.67px 0;

        label {
            margin: 0;
            max-width: unset;
        }
    }

    .popup-text {
        display: flex;
        width: 350.667px;
        height: 66.667px;
        padding: 0px 21.333px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin: 0;
    }

    .line {
        margin: 21.33px 0;
    }

    .close-pop-up {
        margin: 0;
    }

    .popup-filename {
        height: 61.666px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #form-wrap-double label,
    .close-pop-up {
        height: 66.667px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @include mobile {
        width: 303px;
        padding: 24px 20px 20px 20px;

        .pop-up {
            width: 263px !important;

            h1 {
                color: #1b1b1b;
                font-family: Noto Sans JP;
                font-size: 18px;
                font-style: normal;
                font-weight: 700;
                line-height: 160%; /* 28.8px */
                letter-spacing: -0.18px;
                margin-bottom: 20px;
            }
        }

        .popup-filename,
        #form-wrap-double label,
        .popup-text,
        .close-pop-up {
            height: 50px;
            width: 100%;
        }

        .popup-filename {
            margin-bottom: 0 !important;

            p {
                color: #1b1b1b;
                text-align: center;
                font-family: Noto Sans JP;
                font-size: 16px;
                font-style: normal;
                font-weight: 400;
                line-height: 160%; /* 19.2px */
                letter-spacing: -0.12px;
            }
        }

        #form-wrap-double {
            margin: 8px 0;

            label {
                margin: 0;
            }
        }

        .popup-text {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            height: 50px;
            padding: 0 16px;
            color: #1b1b1b;
            font-family: Noto Sans JP;
            font-size: 14px;
            font-style: normal;
            font-weight: 700;
            line-height: 160%; /* 22.4px */
            letter-spacing: -0.14px;
            text-decoration-line: underline;
        }
        .line {
            border-color: #d9d9d9;
            margin: 16px 0;
        }
        .close-pop-up {
            border-radius: 4px;
        }
    }
}
</style>
