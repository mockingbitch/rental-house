<script setup>
import { Link } from '@inertiajs/vue3';
import Layout from '../../Layouts/Layout.vue';
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    data: Array,
})

const saveDraft = () => {
    formLesson.post(route("save.draft.error"), {
        onSuccess: (e) => {
        },
    });
}
const formLesson = useForm(props.data)
</script>
<template>
    <Layout>
        <div class="container">
            <div class="signin">
                <div class="signin__wrap">
                    <img src="/img/create-lesson-fail.png" alt="signin" class="signin__wrap-banner">
                    <div class="signin__wrap-content">
                        <h2 class="title error-msg">{{ lang().label.create_lesson_failed.notification }}</h2>
                        <ul class="content">
                            <li>{{ lang().label.create_lesson_failed.sorry }}</li>
                            <li>{{ lang().label.create_lesson_failed.reason }}</li>
                            <li>{{ lang().label.create_lesson_failed.create_fail }}</li>
                            <li>{{ lang().label.create_lesson_failed.try_again }}</li>
                        </ul>
                        <Link class="mainButton bg-green" :href="route('create.lesson')">
                            <p>{{ lang().label.create_lesson_failed.go_back }}</p>
                        </Link>
                        <Link class="mainButton" @click="saveDraft">
                            <p>{{ lang().label.create_lesson_failed.to_dashboard }}</p>
                        </Link>
                        <div class="line"></div>
                        <span class="textLink">
                            {{ lang().label.create_lesson_failed.contact_us }}
                            <a>{{ lang().label.create_lesson_failed.here }}</a>
                        </span>
                        <span class="subText show-tablet">
                            {{ lang().label.create_lesson_failed.copy_right }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>