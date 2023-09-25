<script setup>
import BaseReservedCard from "@/Components/User/BaseReservedCard.vue";
import BaseReservedButton from "@/Components/User/Common/BaseReservedButton.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    course: Object,
});
const hasReviewd = (course) => {
    let count = 0
    for (let i = 0; i < course?.lesson?.review?.length; i++) {
        if (course?.lesson?.review[i].user_id === usePage().props.auth.user.id) {
            count++
        }
    }

    return count
}
</script>
<template>
    <div>
        <BaseReservedCard :course="props.course" />
        <div class="d-flex align-items-center reserved-btn">
            <BaseReservedButton
                :label="hasReviewd(props.course) ? lang().label.user.history.button_show_review : lang().label.user.history.button_input_review"
                :status-button="hasReviewd(props.course) ? 2 : 1"
                :href="hasReviewd(props.course)"
                :history="true"
                :course="props.course"
            />
        </div>
    </div>
</template>
<style scoped lang="scss">
:deep(.request__form-wrap) {
    margin-top: 16px;
    line-height: 160%;
    .request__form-wrap-options {
        padding: 12.5px 8px;
        width: 100%;
        border: 1px solid #b1b1b1;
        border-radius: 4px;
        font-family: Noto Sans JP;
        font-size: 12px;
        margin-top: 8px;
        cursor: pointer;
    }
}
.reserved-btn {
    margin-top: 6px;
    gap: 10px;
    .reserved-btn-right {
        width: 40px;
        height: 40px;
        cursor: pointer;
        position: relative;
    }
}
</style>
