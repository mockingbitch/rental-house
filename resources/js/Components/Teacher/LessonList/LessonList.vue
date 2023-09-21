<script setup>
import LayoutDashBoard from "@/Layouts/LayoutDashboard.vue";
import LessonListHeader from "./LessonListHeader.vue";
import Lesson from "./Lesson.vue";
import NoResult from "../Common/NoResult.vue";
import { computed, ref } from "vue";

const props = defineProps({
    lessons: Object,
    selected: Number,
});

const filterLesson = ref(props.lessons);

const haveResult = computed(() =>
    props.lessons?.length > 0
)

const selectedValue = ref();
const selectedTitle = ref();

const setSelectedValue = (value) => {
    selectedValue.value = value;
    if (value == 7) {
        return (filterLesson.value = props.lessons);
    }

    if (value == 3) {
    filterLesson.value = props.lessons.filter((lesson) => lesson.status == 3 || lesson.status == 4 || lesson.status == 5);
    } else {
        filterLesson.value = props.lessons.filter((lesson) => lesson.status == value);
    }
};

const setSelectedTitle = (value) => {
    selectedTitle.value = value;
    filterLesson.value = props.lessons.filter(
        (lesson) => lesson.title === value
    );
};
</script>
<template>
    <LayoutDashBoard>
        <div
            class="create-course-container d-flex justify-content-center flex-column"
        >
            <LessonListHeader
                :selected='props.selected'
                :lessons="lessons"
                @setSelectedValue="setSelectedValue"
                @setSelectedTitle="setSelectedTitle"
            />
            <Lesson
                v-for="lesson in filterLesson"
                v-if="haveResult"
                :lesson="lesson"
            />
            <NoResult v-else></NoResult>
        </div>
    </LayoutDashBoard>
</template>
<style lang="scss" scoped>
@import "../LessonList/LessonList";
</style>
