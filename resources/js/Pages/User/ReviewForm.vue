<script setup>
import { ref, watch, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import BaseLesson from "@/Components/Teacher/Common/BaseLesson.vue";
import BaseCardReview from "@/Components/Teacher/Common/BaseCardReview.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import ButtonRequest from "@/Components/Request/ButtonRequest.vue";
import StarRatingSchedule from "@/Components/Teacher/ScheduleReview/StarRatingSchedule.vue";

const props = defineProps({
    lesson: Object,
    user: Object,
});
const form = useForm({
    easeOfUnderstanding: 0,
    beneficial: 0,
    goodAtTeaching: 0,
    enjoyable: 0,
    review: "",
});
const isActiveSubmit = ref(false);
const isConfirmSubmit = ref(0);

const listLesson = ref([
    {
        id: 1,
        status: 10,
        title: "授業タイトル授業タイトルタイトルタイ授業タイトル授業タイトルタイトルタイ",
        start_date: "yyyy/mm/dd",
        price: 1400,
        view: 9999,
        lesson_hour: null,
        lesson_minute: null,
        target_age_from: null,
        target_age_to: null,
        max_learner: 10,
        course: [
            {
                course_applications: [{ application_details: [{}, {}] }],
            },
        ],
    },
]);

const standardReview = ref([
    {
        standard: "Ease of understanding",
        content: [
            "(仮)あいうえおあいうえお",
            "あいうえおあいうえお、あいうえお。",
        ],
        rating: "easeOfUnderstanding",
        data: form.easeOfUnderstanding,
    },
    {
        standard: "Beneficial",
        content: [
            "(仮)レッスンの内容が、",
            "どれほど有益だったのか教えてください。",
        ],
        rating: "beneficial",
        data: form.beneficial,
    },
    {
        standard: "Good at teaching",
        content: [
            "(仮)あいうえおあいうえお",
            "あいうえおあいうえお、あいうえお。",
        ],
        rating: "goodAtTeaching",
        data: form.goodAtTeaching,
    },
    {
        standard: "Enjoyable ",
        content: [
            "(仮)あいうえおあいうえお",
            "あいうえおあいうえお、あいうえお。",
        ],
        rating: "enjoyable",
        data: form.enjoyable,
    },
]);

const computedData = computed(() => {
    return standardReview?.value?.map((item) => {
        return {
            ...item,
            data: form[item.rating] || 0,
        };
    });
});

const handleChangeRating = (rating, nameStandard) => {
    form[nameStandard] = rating;
};

watch(form, (newValue, oldValue) => {
    if (
        form.easeOfUnderstanding == 0 &&
        form.beneficial == 0 &&
        form.goodAtTeaching == 0 &&
        form.enjoyable == 0 &&
        form.review === ""
    ) {
        isActiveSubmit.value = false;
    } else {
        isActiveSubmit.value = true;
    }
});

const handleClearForm = () => {
    if (isConfirmSubmit.value === 0) {
        form.easeOfUnderstanding = 0;
        form.beneficial = 0;
        form.goodAtTeaching = 0;
        form.enjoyable = 0;
        form.review = "";
    } else if (isConfirmSubmit.value === 1) {
        isConfirmSubmit.value = 0;
    }
};

const handleSubmitForm = () => {
    if (isConfirmSubmit.value === 0) {
        isConfirmSubmit.value = 1;
    } else if (isConfirmSubmit.value === 1) {
        // isConfirmSubmit.value = 2;
        form.post(route("user.post.review", props.lesson.id), {
            onSuccess: (e) => {
            },
        });
    }
};
</script>
<template>
    <Layout :isReviewForm="true">
        <div class="header__review">
            <div class="logo d-flex justify-content-center align-items-center">
                <Link :href="route('top')">
                    <i
                        ><img src="/img/logo/DotreesReview.svg" alt="DotTrees"
                    /></i>
                </Link>
                <div class="icon-review">
                    <img
                        src="/img/icon/close.svg"
                        alt=""
                        v-if="isConfirmSubmit === 0"
                    />
                    <img
                        src="/img/icon/CaretLeft.svg"
                        alt=""
                        v-if="isConfirmSubmit === 1"
                        @click="handleClearForm"
                    />
                </div>
            </div>

            <div class="lineFull"></div>
        </div>
        <div class="review__form" v-if="isConfirmSubmit !== 2">
            <div class="header__review-PC">
                <div class="icon-review_PC">
                    <img
                        src="/img/icon/close.svg"
                        alt=""
                        v-if="isConfirmSubmit === 0"
                    />
                    <img
                        src="/img/icon/CaretLeft.svg"
                        alt=""
                        v-if="isConfirmSubmit === 1"
                        @click="handleClearForm"
                    />
                </div>
            </div>
            <div
                class="d-flex justify-content-center align-items-center review__form-confirm-title"
                v-if="isConfirmSubmit === 1"
            >
                レビュー内容の確認
            </div>
            <BaseLesson
                :lessons="[props.lesson]"
                :isDisplayIcon="true"
                :maxWidth="true"
                v-if="isConfirmSubmit !== 2"
            />
            <div
                v-for="(rate, index) in computedData"
                :key="index"
                v-if="isConfirmSubmit === 0"
            >
                <BaseCardReview
                    :title="rate.standard"
                    :contents="rate.content"
                    :name-standard="rate.rating"
                    :data="rate.data"
                    @rating="handleChangeRating"
                />
            </div>
            <div
                class="review__form-review d-flex flex-column"
                v-if="isConfirmSubmit === 0"
            >
                <label for="Title">レビューコメント</label>
                <textarea
                    v-model="form.review"
                    placeholder="あいうえおあいうえお、あいうえお。"
                    class="text-area-form"
                    auto-grow
                />
            </div>
            <div class="review__form-confirm" v-if="isConfirmSubmit === 1">
                <div class="review__form-confirm-title">Review Detail</div>
                <div class="review__form-confirm-info d-flex flex-column">
                    <StarRatingSchedule
                        title="Ease of understanding"
                        :rating="form.easeOfUnderstanding"
                        :count="form.easeOfUnderstanding"
                        :isFormReview="true"
                    />
                    <StarRatingSchedule
                        title="Beneficial"
                        :rating="form.beneficial"
                        :count="form.beneficial"
                        :isFormReview="true"
                    />
                    <StarRatingSchedule
                        title="Good at teaching"
                        :rating="form.goodAtTeaching"
                        :count="form.goodAtTeaching"
                        :isFormReview="true"
                    />
                    <StarRatingSchedule
                        title="Enjoyable"
                        :rating="form.enjoyable"
                        :count="form.enjoyable"
                        :isFormReview="true"
                    />
                </div>
                <div class="review__form-confirm-comment">
                    <div class="review__form-confirm-comment-title">
                        レビューコメント
                    </div>
                    <div class="review__form-confirm-comment-content">
                        <div class="no-comment" v-if="form.review === ''">
                            コメントはありません。
                        </div>
                        <div class="comment d-flex flex-column" v-else>
                            <div class="comment-info d-flex">
                                <img :src="props.user.avatar" width="24" height="24" style="border-radius: 100%;"/>
                                <div
                                    class="comment-info-name d-flex align-items-center"
                                >
                                    {{ props.user.nick_name }}
                                </div>
                            </div>
                            <div class="comment-content">
                                {{ form.review }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-container" v-if="isConfirmSubmit !== 2">
                <div class="create__request-button">
                    <ButtonRequest
                        @click="handleClearForm"
                        :label="
                            isConfirmSubmit === 1 ? '戻って修正する' : 'クリア'
                        "
                        :submit-button="false"
                        class="create__request-button-left"
                    />
                    <ButtonRequest
                        @click="handleSubmitForm"
                        :label="
                            isConfirmSubmit === 1 ? 'レビューを登録' : '次へ'
                        "
                        :submit-button="true"
                        class="create__request-button-right"
                        :class="{ btn_disabled: !isActiveSubmit }"
                    />
                </div>
            </div>
            <div
                class="review__form-warning"
                v-if="isConfirmSubmit === 1 && form.review !== ''"
            >
                感想あいうえおあいうえお、あいうえお。感想あいうえおあいうえお、あいうえお。感想あいうえおあいうえお、あいうえお。感想あいうえおあいうえお、あいうえお。感想あいうえおあいうえお、あいうえお。
            </div>
        </div>
    </Layout>
</template>
<style lang="scss" scoped>
.review__form {
    padding: 16px;
    max-width: 400px;
    margin: auto;
    &-confirm-title {
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: 25.6px; /* 25.6px */
        letter-spacing: -0.16px;
        padding: 8px 0;
        margin-bottom: 16px;
        color: #1b1b1b;
    }
    &-review {
        margin-top: 16px;
        gap: 8px;
        label {
            color: #1b1b1b;
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 19.2px; /* 19.2px */
            letter-spacing: -0.12px;
        }
        .text-area-form {
            border-radius: 4px;
            padding: 8px 10px;
            font-family: "Noto Sans JP";
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 19.2px; /* 19.2px */
            letter-spacing: -0.12px;
            min-height: 108px;
            resize: none;
            border-color: #e3e3e3;
        }
        .text-area-form::placeholder {
            color: #b1b1b1;
        }
        .text-area-form:focus-visible {
            outline: #1b1b1b auto 1px !important;
        }
    }
    .create__request-button {
        display: flex;
        flex-direction: row;
        gap: 8px;
        width: 100%;
        justify-content: center;
        align-items: center;
        padding: 16px 0px;
    }
    .create__request-button-left {
        width: 120px;
        max-width: 40%;
        font-size: 14px;
        font-family: "Noto Sans JP";
        line-height: 22.4px;
        letter-spacing: -0.14px;
        white-space: nowrap;
        color: #5392F9  !important;
    }
    .create__request-button-right {
        font-size: 14px;
        min-width: 215px;
        flex: 1;
    }
    .btn_disabled {
        background-color: #cacaca !important;
        cursor: pointer;
        color: #989898 !important;
        background-image: url(img/icon/CaretDownDisabled.svg);
    }
    &-warning {
        color: #e71a41;
        font-size: 12px;
        font-style: normal;
        font-weight: 400;
        line-height: 19.2px; /* 19.2px */
        letter-spacing: -0.12px;
    }
    &-confirm {
        margin-top: 16px;
        &-title {
            color: #1b1b1b;
            font-size: 16px;
            font-style: normal;
            font-weight: 700;
            line-height: 25.6px; /* 25.6px */
            letter-spacing: -0.16px;
            padding: 8px 0;
        }
        &-info {
            gap: 4px;
        }
        &-comment {
            padding: 16px;
            border-radius: 8px;
            margin-top: 16px;
            background-color: #f4f4f4;
            &-title {
                color: #000000;
                font-size: 12px;
                font-style: normal;
                font-weight: 700;
                line-height: 19.2px; /* 19.2px */
                letter-spacing: -0.12px;
            }
            &-content {
                margin-top: 8px;
                .no-comment {
                    font-size: 12px;
                    font-style: normal;
                    font-weight: 400;
                    line-height: 19.2px; /* 19.2px */
                    letter-spacing: -0.12px;
                    color: #7f7f7f;
                }
                .comment {
                    &-info {
                        gap: 4px;
                        &-name {
                            color: #000000;
                            font-size: 12px;
                            font-style: normal;
                            font-weight: 400;
                            line-height: 160%; /* 19.2px */
                            letter-spacing: -0.12px;
                        }
                    }
                    &-content {
                        margin-top: 2px;
                        color: #000000;
                        font-size: 12px;
                        font-style: normal;
                        font-weight: 400;
                        line-height: 19.2px; /* 19.2px */
                        letter-spacing: -0.12px;
                        word-wrap: break-word;
                    }
                }
            }
        }
    }
    :deep(.star-rating-schedule-number) {
        margin-left: 8px;
    }
    :deep(.submit__button) {
        margin-top: 0;
    }
}
.header__review {
    padding: 11px 16px;
    position: relative;
    .logo {
        padding: 8px 0;
        position: relative;
        max-width: 368px;
        margin: auto;
        .icon-review {
            position: absolute;
            left: 0;
            cursor: pointer;
        }
    }
}

.header__review-PC {
    position: relative;
	margin-top: 8px;
	margin-bottom: 16px;
	padding: 11px 0;
}

@media screen and (min-width: 768px) {
    .review__form {
        padding: 16px 0;
    }
    .header__review {
        display: none;
    }
}
@media screen and (max-width: 768px) {
    .header__review-PC {
        display: none;
    }
}
</style>
