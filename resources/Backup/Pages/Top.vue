<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import Layout from "../Layouts/Layout.vue";
import Category from "@/Components/Category/Category.vue";
import Banner from "@/Components/Banner/Banner.vue";
import Stars from "@/Components/Rating/Stars.vue";
import Modal from "../Components/Modal/Modal.vue";
import { lessonRating } from "@/Helper/lessonRating";

const props = defineProps({
    lessons: Array,
});
const showModal = ref(false);
let listLessons = ref(props.lessons);

const handleSearch = (category) => {
    if (category) {
        listLessons.value = props.lessons.filter(
            (item) => item.category_id === category.id
        );
    } else {
        listLessons.value = props.lessons;
    }
};

const imageUrlAlt = (event) => {
    return (event.target.src = "https://placehold.co/600x400");
};
</script>

<style lang="scss" scoped>
@import "../../css/_top.scss";
.rating {
    display: flex;
    align-items: center;
    gap: 2px;
    height: 19px;
    margin-top: 10px;
}
</style>

<template>
    <Layout>
        <div class="container">
            <Category @handleFilterCategory="handleSearch" />
            <Banner />
        </div>
        <div class="topScreen">
            <div class="container">
                <div class="topScreen__wrap">
                    <Link
                        class="item"
                        v-for="(lesson, index) in listLessons"
                        :key="index"
                        :href="route('lesson.detail', lesson.id)"
                    >
                        <div class="image">
                            <img
                                :src="lesson.cover_image"
                                @error="imageUrlAlt"
                                alt="lesson"
                            />
                        </div>
                        <div class="rating">
                            <Stars :stars="lessonRating(lesson).toFixed(1)" />
                            <span class="count">
                                {{ lessonRating(lesson).toFixed(1) }} 
                                ({{ lesson.review?.length}})
                            </span>
                        </div>
                        <div class="title">
                            <h2>
                                {{ lesson.title }}
                            </h2>
                        </div>
                        <div class="description">
                            <p>
                                {{
                                    lesson.teacher.first_name +
                                    " " +
                                    lesson.teacher.last_name
                                }}
                            </p>
                        </div>
                        <div class="price">{{ lesson.price }}yen / class</div>
                        <div class="age">
                            <p>
                                Ages {{ lesson.target_age_from }}-{{
                                    lesson.target_age_to
                                }}
                            </p>
                        </div>
                        <div class="lesson-time">
                            {{
                                lesson.lesson_hour
                                    ? lesson.lesson_hour + "h "
                                    : ""
                            }}{{ lesson.lesson_minute }}m
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </Layout>
</template>
<script></script>
