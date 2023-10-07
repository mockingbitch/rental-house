<script setup>
import BaseLesson from "./Common/BaseLesson.vue";

const props = defineProps({
    lessons: Array,
});

const publishLesson = () => {
    const array = []
    for (let i = 0; i < props.lessons.length; i++) {
        if (props.lessons[i].status == 1 || props.lessons[i].status == 0) {
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
    <BaseLesson :lessons="publishLesson()" class="lession-container"/>
</template>
<style scoped>
.lession-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
    width: 100%;
}
</style>
