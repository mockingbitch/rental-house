<script setup>
import BaseScheduleCard from "../../Components/Teacher/Common/BaseScheduleCard.vue";
import LayoutDashBoard from "@/Layouts/LayoutDashboard.vue";
import { Link } from "@inertiajs/vue3";
import BaseScheduleHeader from "../../Components/Teacher/Common/BaseScheduleHeader.vue";

const props = defineProps({
    schedules: Array,
});
</script>
<template>
    <LayoutDashBoard>
        <div class="teacher-schedule-container">
            <BaseScheduleHeader />
            <div class="teacher-schedule-title">{{ lang().label.schedule.schedule_management }}</div>
            <div v-if="schedules.length > 0">
                <BaseScheduleCard
                    v-for="(schedule, index) in props.schedules"
                    :key="index"
                    :schedule="schedule"
                />
            </div>
            <div class="noData__wrapper" v-else>
                <div class="noData__title-wrapper">
                    <h2>No results found</h2>
                </div>
                <p class="noData__desc-text">
                    あいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえお
                </p>
            </div>
        </div>
    </LayoutDashBoard>
</template>
<style scoped lang="scss">
.teacher-schedule-container {
    width: 100%;
    max-width: 400px;
    margin: 0px auto;
    font-family: Noto Sans JP;
}

.teacher-schedule-header {
    height: 54px;
    position: relative;

    &-tab {
        align-items: center;
        width: 100%;

        &-item {
            height: 100%;
            font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            line-height: 19.2px;
            cursor: pointer;
            color: #4d4d4d;
        }
        .isActive {
            position: relative;
            font-weight: bold;
            color: #5392F9 ;

            &::before {
                position: absolute;
                content: "";
                left: 0;
                right: 0;
                bottom: 0;
                height: 2px;
                background-color: #5392F9 ;
            }
        }
    }
}
.teacher-schedule-title {
    color: #1b1b1b;
    height: 42px;
    font-size: 16px;
    font-style: normal;
    font-weight: 700;
    line-height: 160%;
    letter-spacing: -0.16px;
    line-height: 42px;
    margin-top: 16px;
}
.noData__wrapper {
    margin-top: 16px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 144px;

    .noData__title-wrapper {
        margin-bottom: 16px;

        h2 {
            font-size: 16px;
            font-weight: 700;
            line-height: 26px;
            letter-spacing: -0.01em;
        }

    }
    .noData__desc-text {
        font-size: 12px;
        font-weight: 400;
        line-height: 19px;
        letter-spacing: -0.01em;
        text-align: center;
        color: #767474;
    }
}
@media all and (max-width: 768px) {
    .teacher-schedule-container {
        padding: 0px 16px;
    }
}
</style>
