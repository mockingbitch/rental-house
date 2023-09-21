<script setup>
import BaseLesson from "./Common/BaseLesson.vue";

const props = defineProps({
    lessons: Array,
});

const draftLesson = () => {
    const array = []
    for (let i = 0; i < props.lessons.length; i++) {
        if (props.lessons[i].status == 2) {
            array.push(props.lessons[i])
        }

        if (array.length >= 3 ){
            break
        }
    }
    return array
}
</script>
<template>
    <BaseLesson :lessons="draftLesson()" :draft="true" class="lesson-container"/>
</template>
<style scoped>
.lesson-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
    width: 100%;
}
</style>
