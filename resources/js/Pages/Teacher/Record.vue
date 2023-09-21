<script setup>
import { ref } from "vue";
import LayoutDashBoard from "@/Layouts/LayoutDashboard.vue";
import BaseRecordCard from "../../Components/Teacher/Common/BaseRecordCard.vue";
import BaseScheduleHeader from "../../Components/Teacher/Common/BaseScheduleHeader.vue";
import NoResult from "../../Components/Teacher/Common/NoResult.vue";

const props = defineProps({
    lessons: Object,
    total_learner_applied: Object,
});
// Xác định có phải TOTAL hay không 
const isAll = ref(true);
</script>
<template>
    <LayoutDashBoard>
        <div class="teacher-record-container">
            <BaseScheduleHeader />
            <div v-if="props.lessons?.length">
                <div class="teacher-record-title">{{ lang().label.record.lesson_record }}</div>
                <BaseRecordCard
                    :is-all="isAll"
                    :lessons="props.lessons"
                    :total_learner_applied="props.total_learner_applied"
                />
                <div class="teacher-record-line"></div>
                <BaseRecordCard
                    :is-all="!isAll"
                    v-for="lesson in props.lessons.filter(item => item.status == 1)"
                    :lesson="lesson"
                />
            </div>
            <div v-else>
                <NoResult />
            </div>
        </div>
    </LayoutDashBoard>
</template>
<style scoped lang="scss">
.teacher-record-container {
    width: 100%;
    max-width: 400px;
    margin: 0px auto;
    font-family: Noto Sans JP;
}
.teacher-record-title {
    color: #1b1b1b;
    font-size: 16px;
    font-style: normal;
    font-weight: 700;
    line-height: 160%;
    letter-spacing: -0.16px;
    padding: 8px 0px;
    margin-top: 16px;
}
.teacher-record-line {
    height: 1px;
    align-self: stretch;
    background-color: #e3e3e3;
    margin-top: 16px;
}
@media all and (max-width: 768px) {
    .teacher-record-container {
        padding: 0px 16px;
    }
}
</style>
