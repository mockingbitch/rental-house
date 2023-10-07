<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import StarRatingSchedule from "@/Components/Teacher/ScheduleReview/StarRatingSchedule.vue";
import BaseLesson from "@/Components/Teacher/Common/BaseLesson.vue";

const props = defineProps({
    lesson_reviews: Array,
    lesson: Object,
});
const ratePoints = () => {
    let easeOfUnderstanding = 0;
    let beneficial = 0;
    let goodAtTeaching = 0;
    let enjoyable = 0;

    let countEaseOfUnderstanding = 0;
    let countBeneficial = 0;
    let countGoodAtTeaching = 0;
    let countEnjoyable = 0;

    for (let i = 0; i < props.lesson_reviews?.length; i++) {
        if (props.lesson_reviews[i].ease_of_understanding) {
            easeOfUnderstanding +=
                props.lesson_reviews[i].ease_of_understanding;
            countEaseOfUnderstanding++;
        }
        if (props.lesson_reviews[i].beneficial) {
            beneficial += props.lesson_reviews[i].beneficial;
            countBeneficial++;
        }
        if (props.lesson_reviews[i].good_at_teaching) {
            goodAtTeaching += props.lesson_reviews[i].good_at_teaching;
            countGoodAtTeaching++;
        }
        if (props.lesson_reviews[i].enjoyable) {
            enjoyable += props.lesson_reviews[i].enjoyable;
            countEnjoyable++;
        }
    }

    return {
        easeOfUnderstanding: countEaseOfUnderstanding
            ? easeOfUnderstanding / countEaseOfUnderstanding
            : 0,
        beneficial: countBeneficial ? beneficial / countBeneficial : 0,
        goodAtTeaching: countGoodAtTeaching
            ? goodAtTeaching / countGoodAtTeaching
            : 0,
        enjoyable: countEnjoyable ? enjoyable / countEnjoyable : 0,
    };
};
</script>
<template>
    <Layout :is-review-form="true">
        <div class="header__review">
            <div class="logo d-flex justify-content-center align-items-center">
                <div class="icon-review">
                    <img src="/img/icon/CaretLeft.svg" alt="" />
                </div>
            </div>
        </div>
        <div class="review__form">
            <BaseLesson
                :lessons="[props.lesson]"
                :isDisplayIcon="true"
                :maxWidth="true"
            />
            <div class="review__form-confirm">
                <div class="review__form-confirm-title">Review Detail</div>
                <div class="review__form-confirm-info d-flex flex-column">
                    <StarRatingSchedule
                        title="Ease of understanding"
                        :rating="ratePoints().easeOfUnderstanding"
                        :count="ratePoints().easeOfUnderstanding"
                        :is-form-review="true"
                    />
                    <StarRatingSchedule
                        title="Beneficial"
                        :rating="ratePoints().beneficial"
                        :count="ratePoints().beneficial"
                        :is-form-review="true"
                    />
                    <StarRatingSchedule
                        title="Good at teaching"
                        :rating="ratePoints().goodAtTeaching"
                        :count="ratePoints().goodAtTeaching"
                        :is-form-review="true"
                    />
                    <StarRatingSchedule
                        title="Enjoyable"
                        :rating="ratePoints().enjoyable"
                        :count="ratePoints().enjoyable"
                        :is-form-review="true"
                    />
                </div>
                <div
                    class="review__form-confirm-comment"
                    v-for="review in props.lesson_reviews"
                >
                    <div class="review__form-confirm-comment-title">
                        {{ review.created_at }}
                    </div>
                    <div class="review__form-confirm-comment-content">
                        <div class="comment d-flex flex-column">
                            <div class="comment-info d-flex">
                                <img
                                    :src="review.user.avatar"
                                    width="24"
                                    height="24"
                                    style="border-radius: 100%"
                                />
                                <div
                                    class="comment-info-name d-flex align-items-center"
                                >
                                    {{ review.user.nick_name }}
                                </div>
                            </div>
                            <div class="comment-content">
                                {{ review.review }}
                            </div>
                        </div>
                    </div>
                </div>
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
        color: #1b1b1b;
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
                font-size: 16px;
                font-style: normal;
                font-weight: 700;
                line-height: 19.2px; /* 19.2px */
                letter-spacing: -0.12px;
            }
            &-content {
                margin-top: 8px;
                .no-comment {
                    font-size: 16px;
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
                            font-size: 16px;
                            font-style: normal;
                            font-weight: 400;
                            line-height: 160%; /* 19.2px */
                            letter-spacing: -0.12px;
                        }
                    }
                    &-content {
                        margin-top: 2px;
                        color: #000000;
                        font-size: 16px;
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
    height: 54px;
    position: relative;
    margin-top: 24px;
    .logo {
        position: relative;
        max-width: 400px;
        margin: auto;
        .icon-review {
            position: absolute;
            left: 12px;
            top: 12px;
            cursor: pointer;
        }
    }
}

@media all and (max-width: 768px) {
    .review__form {
        padding: 16px;
    }
    .header__review {
        margin-top: 0px;
    }
}
</style>
