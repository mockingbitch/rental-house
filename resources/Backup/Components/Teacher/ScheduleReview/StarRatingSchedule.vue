<script setup>
import Stars from "@/Components/Rating/Stars.vue";
import { defineProps } from "vue";

const props = defineProps({
    title: String,
    rating: Number,
    count: Number,
    isFirst: Boolean,
	isFormReview: Boolean
});

</script>
<template>
    <div
        class="d-flex star-rating-schedule-container"
        :style="
            isFirst ? 'background-color:#E1EFF2' : 'background-color:#F4F4F4'
        "
    >
        <div
            class="star-rating-schedule-title"
            :style="isFirst ? 'font-weight: 700' : 'font-weight: 400'"
        >
            {{ title }}
        </div>
        <Stars :stars="rating" />
        <div class="d-flex align-items-center star-rating-schedule-number">
            <div class="star-rating-schedule-number-star">{{ rating }}</div>
            <div v-if="!props.isFormReview">({{ count }})</div>
        </div>
    </div>
</template>
<style scoped lang="scss">
.star-rating-schedule-container {
    font-size: 16px;
    line-height: 160%;
    letter-spacing: -0.12px;
    padding: 8px 16px;
    border-radius: 4px;
    .star-rating-schedule-title {
        width: 123px;
        color: #1b1b1b;
        margin-right: 16px;
    }
    .star-rating-schedule-number {
        margin-left: 2px;
        gap: 2px;
        .star-rating-schedule-number-star {
            color: #5392F9 ;
            font-weight: 700;
        }
    }
}

:deep(.vue-star-rating) {
    gap: 2px !important;
}
</style>
