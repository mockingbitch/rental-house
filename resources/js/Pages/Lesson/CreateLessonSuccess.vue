<script setup>
import { Link } from '@inertiajs/vue3';
import Layout from '../../Layouts/Layout.vue';

const props = defineProps({
    lesson_id: Number,
});
</script>
<template>
    <Layout>
        <div class="container">
            <div class="signin">
                <div class="signin__wrap">
                    <img src="/img/create-lesson-success.png" alt="signin" class="signin__wrap-banner">
                    <div class="signin__wrap-content">
                        <h2 class="title">{{ lang().label.create_lesson_success.notification }}</h2>
                        <ul class="content">
                            <li>{{ lang().label.create_lesson_success.thank_to }}</li>
                        </ul>
                        <Link class="mainButton" :href="route('edit.draft.lesson', props.lesson_id)">
                            <p>{{ lang().label.create_lesson_success.go_back }}</p>
                        </Link>
                        <Link class="mainButton bg-green" :href="route('teacher.dashboard')">
                            <p>{{ lang().label.create_lesson_success.to_dashboard }}</p>
                        </Link>
                        <div class="line"></div>
                        <span class="textLink a-black">
                            {{ lang().label.create_lesson_success.contact_us }}
                            <a>{{ lang().label.create_lesson_success.here }}</a>
                        </span>
                        <span class="subText">
                            {{ lang().label.create_lesson_success.copy_right }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
<style scoped>
.title {
    font-size: 16px !important;
}
.signin__wrap-banner {
    width: 100%;
}
.mainButton {
    border: 1px solid #003E49;
    color: #003E49;
}
.textLink {
    margin: 16px 0px !important;
    padding: 16px !important;
    font-size: 12px;
}
</style>