<script setup>
import LessonListVue from "../../Components/Teacher/LessonList/LessonList.vue";

const props = defineProps({
    lessons: Object,
    selected: Number,
});
</script>

<template> 
    <LessonListVue :lessons="props.lessons" :selected="props.selected"/>
</template>

<style lang="scss" scoped></style>
