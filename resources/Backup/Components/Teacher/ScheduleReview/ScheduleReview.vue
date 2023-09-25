<script setup>
import { ref, defineProps, onMounted } from "vue";

import StarRatingSchedule from "./StarRatingSchedule.vue";
import ScheduleReviewCard from "./ScheduleReviewCard.vue";
import NoResult from "../Common/NoResult.vue";

const props = defineProps({
    isAllReview: Boolean,
    listReview: Array,
    lesson: Object,
    listReviewOfTeacher: Array,
});
const isFirst = ref(true);
// Fake điều kiện có data
const isEmpty = ref(false);
let totalRatingReview = ref(0);
let totalRatingReviewOfTeacher = ref(0);
let starReview = ref({
    easeOfUnderstanding: {total: 0, rate: 0},
    beneficial: {total: 0, rate: 0},
    goodAtTeaching: {total: 0, rate: 0},
    enjoyable: {total: 0, rate: 0},
});
let starReviewOfTeacher = ref({
    easeOfUnderstanding: {total: 0, rate: 0},
    beneficial: {total: 0, rate: 0},
    goodAtTeaching: {total: 0, rate: 0},
    enjoyable: {total: 0, rate: 0},
});
onMounted(() => {
    let sum = 0;
    let sumTeacher = 0;
    if (props.listReview && props.listReview.length > 0) {
        let totalReview = 0;
        starReview.value.easeOfUnderstanding = countTotal(props.listReview, 'ease_of_understanding');
        starReview.value.beneficial = countTotal(props.listReview, 'beneficial');
        starReview.value.goodAtTeaching = countTotal(props.listReview, 'good_at_teaching');
        starReview.value.enjoyable = countTotal(props.listReview, 'enjoyable');
        sum = parseFloat(starReview.value.easeOfUnderstanding.rate)
            + parseFloat(starReview.value.beneficial.rate)
            + parseFloat(starReview.value.goodAtTeaching.rate)
            + parseFloat(starReview.value.enjoyable.rate);
        if (starReview.value.easeOfUnderstanding.total > 0) {
            totalReview++;
        } if (starReview.value.beneficial.total > 0) {
            totalReview++;
        } if (starReview.value.goodAtTeaching.total > 0) {
            totalReview++;
        } if (starReview.value.enjoyable.total > 0) {
            totalReview++;
        }
        totalRatingReview.value = parseFloat(sum / totalReview).toFixed(1);
    }
    if (props.listReviewOfTeacher && props.listReviewOfTeacher.length > 0) {
        let totalReviewOfTeacher = 0;
        starReviewOfTeacher.value.easeOfUnderstanding = countTotal(props.listReviewOfTeacher, 'ease_of_understanding');
        starReviewOfTeacher.value.beneficial = countTotal(props.listReviewOfTeacher, 'beneficial');
        starReviewOfTeacher.value.goodAtTeaching = countTotal(props.listReviewOfTeacher, 'good_at_teaching');
        starReviewOfTeacher.value.enjoyable = countTotal(props.listReviewOfTeacher, 'enjoyable');
        sumTeacher = parseFloat(starReviewOfTeacher.value.easeOfUnderstanding.rate)
            + parseFloat(starReviewOfTeacher.value.beneficial.rate)
            + parseFloat(starReviewOfTeacher.value.goodAtTeaching.rate)
            + parseFloat(starReviewOfTeacher.value.enjoyable.rate);
        if (starReviewOfTeacher.value.easeOfUnderstanding.total > 0) {
            totalReviewOfTeacher++;
        } if (starReviewOfTeacher.value.beneficial.total > 0) {
            totalReviewOfTeacher++;
        } if (starReviewOfTeacher.value.goodAtTeaching.total > 0) {
            totalReviewOfTeacher++;
        } if (starReviewOfTeacher.value.enjoyable.total > 0) {
            totalReviewOfTeacher++;
        }
        totalRatingReviewOfTeacher.value = parseFloat(sumTeacher / totalReviewOfTeacher).toFixed(1);
    }
    if (
        (
            ! props.isAllReview
            && (! props.listReview || props.listReview.length === 0)
        )
        || (
            props.isAllReview
            && (! props.listReviewOfTeacher || props.listReviewOfTeacher.length === 0)
        )
    ) {
        isEmpty.value = true;
    }
});
const countTotal = (item, condition) => {
    let sum = 0;
    let total = 0;
    for (let i = 0; i < item.length; i++) {
        switch (condition) {
            case 'ease_of_understanding':
                if (item[i].ease_of_understanding !== null) {
                    sum += parseInt(item[i].ease_of_understanding);
                    total++;
                }
                break;
            case 'beneficial':
                if (item[i].beneficial !== null) {
                    sum += parseInt(item[i].beneficial);
                    total++;
                }
                break;
            case 'good_at_teaching':
                if (item[i].good_at_teaching !== null) {
                    sum += parseInt(item[i].good_at_teaching);
                    total++;
                }
                break;
            case 'enjoyable':
                if (item[i].enjoyable !== null) {
                    sum += parseInt(item[i].enjoyable);
                    total++;
                }
                break;
            default:
                break;
        }
    }

    return total > 0 ? {
        total: total,
        rate: parseFloat(sum / total).toFixed(1),
    } : {
        total: 0,
        rate: 0,
    };
}
</script>
<template>
    <!-- Nếu là review tất cả schedule, nhớ thêm điều kiện no result -->
    <div v-if="isAllReview">
        <div class="schedule-review-card-review-wrap d-flex">
            <StarRatingSchedule
                title="TOTAL"
                :rating="totalRatingReviewOfTeacher"
                :count="props.listReviewOfTeacher?.length"
                :isFirst="isFirst"
            />
            <StarRatingSchedule
                title="Ease of understanding"
                :rating="starReviewOfTeacher.easeOfUnderstanding.rate"
                :count="starReviewOfTeacher.easeOfUnderstanding.total"
            />
            <StarRatingSchedule
                title="Beneficial"
                :rating="starReviewOfTeacher.beneficial.rate"
                :count="starReviewOfTeacher.beneficial.total"
            />
            <StarRatingSchedule
                title="Good at teaching"
                :rating="starReviewOfTeacher.goodAtTeaching.rate"
                :count="starReviewOfTeacher.goodAtTeaching.total"
            />
            <StarRatingSchedule
                title="Enjoyable"
                :rating="starReviewOfTeacher.enjoyable.rate"
                :count="starReviewOfTeacher.enjoyable.total"
            />
        </div>
        <div
            v-if="props.listReviewOfTeacher?.length > 0 && isAllReview"
            v-for="review in props.listReviewOfTeacher"
            class=""
        >
            <ScheduleReviewCard :review="review" :lesson="props.lesson" />
        </div>
    </div>
    <!-- Nếu là review riêng từng schedule -->
    <div v-if="!isAllReview && !isEmpty">
        <div class="schedule-review-card-review-wrap d-flex">
            <StarRatingSchedule
                title="lesson TOTAL"
                :rating="totalRatingReview"
                :count="props.listReview?.length"
                :isFirst="isFirst"
            />
            <StarRatingSchedule
                title="Ease of understanding"
                :rating="starReview.easeOfUnderstanding.rate"
                :count="starReview.easeOfUnderstanding.total"
            />
            <StarRatingSchedule
                title="Beneficial"
                :rating="starReview.beneficial.rate"
                :count="starReview.beneficial.total"
            />
            <StarRatingSchedule
                title="Good at teaching"
                :rating="starReview.goodAtTeaching.rate"
                :count="starReview.goodAtTeaching.total"
            />
            <StarRatingSchedule
                title="Enjoyable"
                :rating="starReview.enjoyable.rate"
                :count="starReview.enjoyable.total"
            />
        </div>
        <div
            v-if="props.listReview?.length > 0 && !isAllReview"
            v-for="review in props.listReview"
            class=""
        >
            <ScheduleReviewCard :review="review" :lesson="props.lesson" />
        </div>
    </div>
    <div v-if="isEmpty">
        <NoResult />
    </div>
</template>
<style scoped>
.schedule-review-card-review-wrap {
    flex-direction: column;
    gap: 4px;
    margin-bottom: 16px;
}
</style>
