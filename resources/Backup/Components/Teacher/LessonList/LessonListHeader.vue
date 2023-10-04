<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import Dialog from "../../Dialog/Dialog.vue";
import { Link } from "@inertiajs/vue3";
import { ref, computed, defineEmits } from "vue";
import BaseScheduleHeader from "../Common/BaseScheduleHeader.vue";

const props = defineProps({
    lessons: Object,
    selected: Number,
});
const emits = defineEmits(["setSelectedValue", "setSelectedTitle"]);

const formSearch = useForm({
    title: null,
});

const lang = () => {
    return usePage().props.language.original
}
let listTitle = ref([
    { name: lang().label.lesson_course.all, status: 7 },
    { name: lang().label.lesson_course.public, status: 1 },
    { name: lang().label.lesson_course.private, status: 0 },
    { name: lang().label.lesson_course.draft, status: 2 },
    { name: lang().label.lesson_course.suspend, status: 6 },
    // pending, send back, recall
    { name: lang().label.lesson_course.pending, status: 3 },
]);

let selectedStatus = ref(props.selected ? Number(props.selected) : 7);

let showModalSelect = ref(false);

const closeDialog = () => {
    showModalSelect.value = false;
};

const handleSelect = (title) => {
    formSearch.title = formSearch.title === title ? null : title;
    showModalSelect.value = !showModalSelect.value;
    emits("setSelectedTitle", title);
};

const handleCategorySelect = (status) => {
    selectedStatus.value = status;
    formSearch.title = "";
    emits("setSelectedValue", status);
};

if (props.selected) {
    emits("setSelectedValue", Number(props.selected));
}

const filteredTitleLessons = computed(() => {
    if (selectedStatus.value === 7) {
        return props.lessons
            .filter((lesson) => lesson.title !== null && lesson.title !== "" && lesson.title !== undefined)
            .map((lesson) => lesson.title);
    } else {
        const titles = props.lessons
            .filter((lesson) => Number(lesson.status) === Number(selectedStatus.value))
            .map((lesson) => lesson.title);
        const filteredTitles = titles.filter(title => title !== "" && title !== null && title !== undefined);
        return filteredTitles;
    }
});
const handleFilterTitle = () => {
    if (filteredTitleLessons.value?.length) {
        showModalSelect.value = !showModalSelect.value
    }
}
</script>
<template>
    <BaseScheduleHeader />
    <div class="course__category-wrapper d-flex justify-content-center">
        <div class="create-course-category d-flex">
            <div
                :class="[
                    'create-course-category-item',
                    `active${value.status}`,
                    { isSelected: selectedStatus === value.status },
                ]"
                v-for="value in listTitle"
                :key="value.status"
                @click="handleCategorySelect(value.status)"
                :style="
                    value.status === 7 ? 'padding: 8px 28px' : 'padding: 8px 16px'
                "
            >
                {{ value.name }}
            </div>
        </div>
    </div>
    <div class="create-course-filter d-flex flex-column">
        <div class="create-course-filter-label d-flex justify-content-between">
            <div class="label">{{ lang().label.lesson_course.lessons }}</div>
            <Link class="create-lesson-button" :href="route('create.lesson')">+ {{ lang().label.lesson_course.create_lesson }}</Link>
        </div>
        <div class="create-course-filter-select">
            <div class="select-btn" @click="handleFilterTitle">
                <span class="btn-text" v-if="!formSearch.title">
                    {{ "Filter by Lesson Title" }}
                </span>
                <span class="create-course-search-text" v-else>
                    {{ formSearch.title }}
                </span>
            </div>
            <Dialog :showDialog="showModalSelect" @close-dialog="closeDialog">
                <ul class="list-select-item">
                    <li
                        class="item"
                        v-for="title in filteredTitleLessons"
                        :class="{ checked: formSearch.title === title }"
                        @click="handleSelect(title)"
                    >
                        <span class="checkbox">
                            <i class="fa-solid fa-check check-icon"></i>
                        </span>
                        <span class="item-text create-course-search-text">{{
                            title
                        }}</span>
                    </li>
                </ul>
            </Dialog>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import "../LessonList/LessonList";
.create-course-search-text {
    font-size: 16px;
    font-weight: 400;
    line-height: 160%; /* 19.2px */
    letter-spacing: -0.12px;
    white-space: nowrap;
    color: #1B1B1B;
    width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
}
@media (max-width: 400px) {
    .course__category-wrapper {
        margin-right: -16px;
    }
}
</style>
