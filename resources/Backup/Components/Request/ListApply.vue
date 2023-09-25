<script setup>
import { ref } from "vue";
import BaseLesson from "../Teacher/Common/BaseLesson.vue";

const props = defineProps({
    lessons: Array,
});
const showFullTeacher = ref(true);
const showFull = ref(3);
const toggleShowFullTeacher = () => {
    showFullTeacher.value = !showFullTeacher.value;
    showFull.value = showFullTeacher.value ? 3 : queryLessons().length;
    return showFullTeacher.value;
};
const queryLessons = () => {
    let array = [];
    for (let i = 0; i < props.lessons.length; i++) {
        array.push(props.lessons[i].lesson);
    }
    return array;
};
</script>
<template>
    <div>
        <BaseLesson
            :lessons="queryLessons().slice(0, showFull)"
            class="list__apply-container"
        />
        <div
            @click="toggleShowFullTeacher"
            class="list__apply-btn"
            v-if="props.lessons?.length > 3"
        >
            {{ showFullTeacher ? "Show more" : "Show less" }}
        </div>
    </div>
</template>
<style scoped>
.list__apply-container {
    margin-top: 16px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    width: 100%;
}
.list__apply-btn {
    text-align: center;
    margin-top: 8px;
    cursor: pointer;
    color: #989898;
    font-size: 14px;
    text-decoration: underline;
}

@media screen and (min-width: 768px) {
    .list__apply-container {
        margin-top: 24px;
    }
}
</style>
