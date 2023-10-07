<script setup>
import CourseCreate from "../../Components/Teacher/CourseCreate/CourseCreate.vue";

const props = defineProps({
    lesson: Object,
    course: Object,
    update: Boolean,
    create: Boolean,
});
</script>

<template>
    <CourseCreate :lesson="props.lesson" :update="props.update" :create="props.create" :course="props.course"/>
</template>

<style lang="scss" scoped></style>
