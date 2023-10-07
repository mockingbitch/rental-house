<script setup>
import { ref, onMounted } from "vue";
import BaseCard from "../Common/BaseCard.vue";
import Stars from "@/Components/Rating/Stars.vue";

const props = defineProps({
    review: Object,
    lesson: Object,
});
onMounted(() => {
    let total = 0;
    let sum = 0;
    if (props.review?.ease_of_understanding !== null) {
        sum += props.review.ease_of_understanding;
        total++;
    }
    if (props.review?.beneficial !== null) {
        sum += props.review.beneficial;
        total++;
    }
    if (props.review?.good_at_teaching !== null) {
        sum += props.review.good_at_teaching;
        total++;
    }
    if (props.review?.enjoyable !== null) {
        sum += props.review.enjoyable;
        total++;
    }
    rating.value = total > 0 ? parseFloat(sum / total).toFixed(1) : 0;
})
const showMore = ref(true);
const handleShowMore = () => {
    showMore.value = !showMore.value;
};
let rating = ref(0);
const today = new Date();
const reviewDate = new Date(props.review?.created_at);
</script>
<template>
    <BaseCard>
        <div class="schedule-review-card-container">
            <div class="schedule-review-card-date d-flex align-items-center">
                <div class="schedule-review-card-date-day">{{ props.review?.created_at }}</div>
                <div
                    v-if="+today.getDate() === +reviewDate.getDate()"
                    class="schedule-review-card-date-status"
                >
                    NEW
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <div
                    class="d-flex align-items-center schedule-review-card-avatar"
                >
                    <img
                        :src="props.review?.user?.avatar"
                        alt=""
                        width="24"
                        height="24"
                        class="schedule-review-card-avatar"
                    />
                    <div>{{ props.review?.user?.first_name + ' ' + props.review?.user?.last_name }}</div>
                </div>
                <div
                    class="d-flex align-items-center schedule-review-card-rating"
                >
                    <Stars :stars="rating" />
                    <div>{{ rating }}</div>
                </div>
            </div>
            <div class="d-flex align-items-center schedule-review-card-content">
                <div
                    class="schedule-review-card-content-short-text"
                    v-if="showMore"
                >
                    {{ props.review?.review }}
                </div>
                <div class="schedule-review-card-content-long-text" v-else>
                    {{ props.review?.review }}
                </div>
                <div class="schedule-review-card-content-btn" v-if="props.review?.review?.length > 30">
                    <div
                        v-if="showMore"
                        @click="handleShowMore"
                        class="schedule-review-card-content-btn-showmore"
                    >
                        show more
                    </div>
                    <div
                        v-else
                        @click="handleShowMore"
                        class="schedule-review-card-content-btn-showless"
                    >
                        show less
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center schedule-review-card-title">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="17"
                    viewBox="0 0 16 17"
                    fill="none"
                >
                    <path
                        d="M15.4763 2.99267C15.4692 2.87035 15.4174 2.75491 15.3307 2.66827C15.2441 2.58163 15.1286 2.52982 15.0063 2.52267C11.7713 2.33517 9.17382 3.31892 8.05757 5.16142C7.32007 6.37955 7.32132 7.85892 8.04757 9.27017C7.6342 9.76227 7.33209 10.3379 7.16195 10.9577L6.14507 9.93705C6.63382 8.91642 6.61507 7.85267 6.08257 6.96892C5.25757 5.60705 3.3532 4.87705 0.988824 5.0158C0.866502 5.02294 0.751062 5.07475 0.66442 5.1614C0.577778 5.24804 0.525967 5.36348 0.518824 5.4858C0.379449 7.85017 1.11007 9.75455 2.47195 10.5795C2.92136 10.8541 3.43779 10.9995 3.96445 10.9995C4.47564 10.9933 4.97887 10.8721 5.43695 10.6452L6.99945 12.2077V13.9995C6.99945 14.1322 7.05213 14.2593 7.1459 14.3531C7.23966 14.4469 7.36684 14.4995 7.49945 14.4995C7.63206 14.4995 7.75923 14.4469 7.853 14.3531C7.94677 14.2593 7.99945 14.1322 7.99945 13.9995V12.1564C7.99722 11.361 8.26791 10.5889 8.76632 9.96892C9.40942 10.305 10.1226 10.4849 10.8482 10.4939C11.5497 10.4962 12.2381 10.3046 12.8376 9.94018C14.6801 8.82518 15.6663 6.22767 15.4763 2.99267ZM2.98757 9.72455C2.02882 9.14393 1.48632 7.76955 1.49945 5.99955C3.26945 5.98455 4.64382 6.52892 5.22445 7.48767C5.52757 7.98767 5.57695 8.5708 5.3782 9.17142L3.85257 7.6458C3.75804 7.55599 3.63217 7.50666 3.50179 7.50833C3.37141 7.51 3.24684 7.56253 3.15463 7.65474C3.06243 7.74694 3.0099 7.87151 3.00823 8.00189C3.00656 8.13227 3.05589 8.25814 3.1457 8.35267L4.67132 9.8783C4.0707 10.077 3.4882 10.0277 2.98757 9.72455ZM12.3194 9.0858C11.4819 9.59268 10.4976 9.63143 9.49757 9.2108L12.8532 5.85455C12.943 5.76002 12.9923 5.63414 12.9907 5.50376C12.989 5.37338 12.9365 5.24881 12.8443 5.15661C12.7521 5.06441 12.6275 5.01187 12.4971 5.01021C12.3667 5.00854 12.2409 5.05787 12.1463 5.14768L8.79007 8.49955C8.36757 7.49955 8.4057 6.51455 8.91507 5.67767C9.78632 4.24017 11.8526 3.43893 14.4982 3.5008C14.5582 6.1458 13.7582 8.21455 12.3194 9.0858Z"
                        fill="#5392F9 "
                    />
                </svg>
                <div>{{ props.lesson?.title }}</div>
            </div>
        </div>
    </BaseCard>
</template>
<style scoped lang="scss">
.schedule-review-card-container {
    font-size: 16px;
    padding: 16px;
    .schedule-review-card-date {
        margin-bottom: 8px;
        gap: 2px;
        .schedule-review-card-date-day {
            font-weight: 700;
        }
        .schedule-review-card-date-status {
            padding: 0px 4px;
            color: #ff5575;
            font-weight: 700;
        }
    }
    .schedule-review-card-avatar {
        gap: 4px;
        img {
            background-color: #ff5575;
            border-radius: 100px;
        }
    }
    .schedule-review-card-rating {
        gap: 2px;
    }
    .schedule-review-card-content {
        position: relative;
        width: 100%;
        .schedule-review-card-content-short-text {
            max-width: 236px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .schedule-review-card-content-long-text {
            word-break: break-all;
            padding-bottom: 16px;
            line-height: 160%;
            letter-spacing: -0.12px;
        }
        .schedule-review-card-content-btn {
            font-weight: 700;
            cursor: pointer;
            .schedule-review-card-content-btn-showmore {
                position: absolute;
                top: 0px;
                right: 0px;
                text-decoration: underline;
            }
            .schedule-review-card-content-btn-showless {
                text-decoration: underline;
                position: absolute;
                bottom: 0px;
                right: 0px;
            }
        }
    }
    .schedule-review-card-title {
        gap: 4px;
        div {
            font-weight: 700;
        }
        margin-top: 8px;
    }
}
</style>
