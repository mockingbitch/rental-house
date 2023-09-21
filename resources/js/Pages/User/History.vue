<script setup>
import { ref } from "vue";

import BaseReservedHeader from "@/Components/User/Common/BaseReservedHeader.vue";
import NoResult from "../../Components/Teacher/Common/NoResult.vue";
import Layout from "@/Layouts/Layout.vue";
import HistoryCard from "../../Components/User/HistoryCard.vue";

const props = defineProps({
    course_applied: Array,
});
const isHasLength = ref(true);
</script>
<template>
    <Layout
        ><div class="history-container">
            <BaseReservedHeader />
            <div v-if="Object.entries(props.course_applied).length" v-for="course_date in Object.entries(props.course_applied)" class="d-flex flex-column" style="gap: 16px">
                <div class="history-day mt-4">{{ course_date[0] }}</div>
                <HistoryCard 
                    v-for="course in course_date[1]"
                    :course="course"
                />
            </div>
            <NoResult v-else /></div
    ></Layout>
</template>
<style scoped lang="scss">
.history-container {
    width: 100%;
    max-width: 400px;
    margin: 0px auto;
    font-family: Noto Sans JP;
    color: #1b1b1b;
    .history-day {
        padding: 8px 0px;
        font-size: 16px;
        font-weight: 700;
        line-height: 160%;
        letter-spacing: -0.16px;
    }
}
@media all and (max-width: 768px) {
    .history-container {
        padding: 0px 16px;
    }
}
</style>
