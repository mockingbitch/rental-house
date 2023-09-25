<script setup>
import BaseCard from "./Common/BaseCard.vue";
import moment from "moment";
import { Link } from "@inertiajs/vue3";
import Stars from "@/Components/Rating/Stars.vue";
import { ref } from "vue";
import { lessonRating } from "@/Helper/lessonRating";

const props = defineProps({
    lesson: Object,
    review_id: Number,
});
const newestReview = ref(props.lesson.review[props.lesson.review.length - 1]);
</script>
<template>
    <BaseCard>
        <Link
            class="lesson__feedback-wrap d-flex"
            :href="route('schedule.review', {id: props.lesson?.id ,review_id: props.review_id })"
        >
            <div class="lesson__feedback-day">
                <div>
                    {{
                        moment(newestReview.created_at).format("YYYY/MM/DD")
                    }}
                </div>
                <div
                    class="lesson__feedback-day-status"
                    v-if="newestReview.status == 1"
                >
                    NEW
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between" style="height: 19.2px;">
                <div class="lesson__feedback-rate-item">
                    {{ props.lesson?.title }}
                </div>
                <div class="d-flex align-items-center justify-content-center" style="gap: 2px">
                    <Stars :stars="lessonRating(props.lesson)" />
                    <div style="padding-bottom: 2.4px;">{{ lessonRating(props.lesson).toFixed(1) }}</div>
                </div>
            </div>
        </Link>
    </BaseCard>
</template>
<style scoped lang="scss">
.lesson__feedback-wrap {
    padding: 16px;
    font-size: 12px;
    flex-direction: column;
    gap: 8px;
    color: #1b1b1b;
}
.lesson__feedback-day {
    display: flex;
    align-items: center;
    gap: 4px;
}
.lesson__feedback-day-status {
    font-size: 10px;
    color: #ff5575;
    font-weight: bold;
}
.lesson__feedback-rate {
    display: flex;
    justify-content: space-between;
}
.lesson__feedback-rate-item {
    font-weight: bold;
}

.lesson__feedback-rate-count {
    display: flex;
    gap: 2px;
}
</style>
