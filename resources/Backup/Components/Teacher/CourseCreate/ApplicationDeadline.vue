<script setup>
    const props = defineProps({
        form: Object,
        totalKidApplied: Object,
    });
</script>
<template>
    <div
        class="application-deadline-container d-flex justify-content-center flex-column"
    >
        <div class="application-deadline-container-title">
            {{ lang().label.lesson_course.application_deadline }}
        </div>
        <div class="application-deadline-container-select-day d-flex">
            <div class="d-flex align-items-center">{{ lang().label.lesson_course.course_note_1 }}</div>
            <div class="day-select">
                <select name="deadline" v-model="props.form.course_deadline" :disabled="props.totalKidApplied().count > 0 ? true : false">
                    <option v-for="deadline in 10">
                        {{ deadline +4 }}
                    </option>
                </select>
            </div>
            <div class="d-flex align-items-center">
                {{ lang().label.lesson_course.course_note_2 }}
            </div>
        </div>
        <div class="application-deadline-container-note">
            <ul>
                <li>
                    ※{{ lang().label.lesson_course.course_note_3}}
                </li>
                <li>※{{ lang().label.lesson_course.course_note_4 }}</li>
                <li>※{{ lang().label.lesson_course.course_note_5 }}</li>
                <li>
                    ※{{ lang().label.lesson_course.course_note_6 }}
                </li>
            </ul>
        </div>
    </div>
</template>
<style lang="scss" scoped>
    @import "../CourseCreate/CourseCreate";
</style>
