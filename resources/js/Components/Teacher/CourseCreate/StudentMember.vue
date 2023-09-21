<script setup>
import moment from "moment";

const props = defineProps({
    lesson: Object,
    update: Boolean,
    totalKidApplied: Object,
});

const appliedSort = (appliedArray) => {
    let newarr = appliedArray.sort((a, b) => {
        return moment(b.applied_date).diff(a.applied_date);
    });
    return newarr
} 
</script>
<template>
    <div
        class="student-member-container d-flex justify-content-center flex-column"
    >
        <div class="student-member-container-title">
            {{ lang().label.lesson_course.students_members }}（{{ props.totalKidApplied().count }}/{{ props.lesson?.max_learner }}）
        </div>
        <div class="student-member-container-info d-flex flex-column" v-for="applied_detail in appliedSort(props.totalKidApplied().appliedKidArr)">
            <div class="student-member-info d-flex justify-content-between">
                <div class="student-member-info-name-age d-flex">
                    <span class="student-name">{{ applied_detail.kids.name }}</span>
                    <span class="student-age">{{ lang().label.lesson_course.age }} {{ applied_detail.kids.birthday }}</span>
                </div>
                <div class="student-member-info-time d-flex">
                    <div class="new-member" v-if="moment(applied_detail.applied_date).format('YYYY/MM/DD') == moment().format('YYYY/MM/DD') ">NEW</div>
                    <div class="time-register">{{ moment(applied_detail.applied_date).format('YYYY/MM/DD HH:mm') }}</div>
                </div>
            </div>
            <div class="student-member-question d-flex">
                <div
                    class="student-member-question-icon d-flex align-items-center"
                >
                    <img
                        src="../../../../../public/img/icon/CourseDetail/Questions.svg"
                        alt=""
                    />
                </div>
                <div class="student-member-question-content">
                    {{ applied_detail.question }}
                </div>
            </div>
        </div>
        <div class="student-member-no-student" v-if="props.totalKidApplied().count === 0">{{ lang().label.lesson_course.empty_state }}</div>
    </div>
</template>
<style lang="scss" scoped>
    @import "../CourseCreate/CourseCreate";
</style>
