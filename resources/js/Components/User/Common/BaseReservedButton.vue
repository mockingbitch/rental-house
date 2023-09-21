<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    label: String,
    statusButton: Number,
    history: Boolean,
    href: Number,
    course: Object,
});

const button1 = {
    backgroundColor: "#418997",
    color: "#fff",
};

const button2 = {
    backgroundColor: "#E1EFF2",
    color: "#418997",
};
</script>

<template>
    <!-- History Button  -->
    <Link v-if="props.history"
        :href="props.href ? route('course.review', props.course.lesson_id) : route('user.review.form', props.course.lesson_id)"
        :style="statusButton == 1 ? button1 : button2"
        class="base-reserved-button"
    >
        {{ label }}
    </Link>

    <!-- Reserved Button -->
    <button v-else
        :style="statusButton == 1 ? button1 : button2"
        class="base-reserved-button"
    >
        {{ label }}
    </button>
</template>
<style lang="scss" scoped>
.base-reserved-button {
    width: 100%;
    display: flex;
    height: 40px;
    padding: 8px;
    justify-content: center;
    align-items: center;
    gap: 4px;
    flex: 1 0 0;
    border-radius: 8px;
    border: none;
    font-family: Noto Sans JP;
    font-size: 12px;
    font-style: normal;
    font-weight: 700;
    line-height: 160%;
    letter-spacing: -0.12px;
    cursor: pointer;
}
</style>
