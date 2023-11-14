<!-- 
<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3';

import Layout from '@/Layouts/Layout.vue';
import TeacherProfileBanner from '@/Components/Teacher/Profile/TeacherProfileBanner.vue';
import TeacherProfileContent from '@/Components/Teacher/Profile/TeacherProfileContent.vue';


const props = defineProps({
    teacherInfo: Array,
    lessons: Array,
    listReviews: Array,
    totalScheduleComplete: Number
});

</script>
<template>
    <Layout>
        <div class="teacher-profile-container">
            <TeacherProfileBanner :teacherInfo="props.teacherInfo" />
            <TeacherProfileContent
                :lessons="props.lessons"
                :teacherInfo="props.teacherInfo"
                :listReviews="props.listReviews"
                :totalScheduleComplete="props.totalScheduleComplete"
            />
        </div>
    </Layout>
</template>
<style lang="scss" scoped>
.teacher-profile-container {
    margin: 0 auto;
    max-width: 500px;
    font-size: 14px;
    color: #1b1b1b;
}
@media all and (max-width: 768px) {
    .teacher-profile-container {
    max-width: 375px;}
}
</style> -->
