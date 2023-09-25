<script setup>
import { defineProps, defineEmits } from "vue";
import { Link } from "@inertiajs/vue3";
import Hamburger from "@/Components/Hamburger/Hamburger.vue";

const props = defineProps({
    step: Number,
    showResultStep: Number,
    title: String,
    isSuccess: Boolean,
});

const emits = defineEmits();

const handleClick = () => {
    emits("handle-click");
};
</script>

<template>
    <div class="container">
        <div
            class="navDashboard"
            :class="{
                navCenter:
                    props.step || props.showResultStep || props.isSuccess,
            }"
        >
            <div
                class="navDashboard__left"
                :class="{ hideNavBar: props.step || props.showResultStep }"
            >
                <Link :href="route('top')">
                    <img src="/img/icon/TeacherDashboard/dottress.svg" alt="" />
                </Link>
                <span class="">Dashboard</span>
            </div>
            <div
                class="navDashboard__right"
                :class="{
                    hideNavBar:
                        props.step || props.showResultStep || props.isSuccess,
                }"
            >
                <img src="/img/icon/TeacherDashboard/refresh.svg" alt="" />
                <img
                    src="/img/icon/TeacherDashboard/add.svg"
                    alt=""
                    class="hide-icon"
                />
                <img
                    src="/img/icon/ApplyToTeacher/Bell.svg"
                    alt=""
                    class="hide-icon"
                />
                <Humberger :humberger-color="'white'" />
                <!-- <img src="/img/icon/TeacherDashboard/dot.svg" alt="" /> -->

            </div>
            <div
                class="navDashBoardCenter d-flex justify-content-center align-items-center"
                v-if="props.step || props.showResultStep"
            >
                <img
                    src="/img/icon/ApplyToTeacher/CancelNavBar.svg"
                    alt=""
                    class="nav-cancel"
                    v-if="props.step"
                    @click="handleClick"
                />
                <img
                    src="/img/icon/ApplyToTeacher/BackToOnBoard.svg"
                    alt=""
                    class="nav-cancel"
                    v-if="props.showResultStep"
                    @click="handleClick"
                />
                <span class="nav-title">{{ props.title }}</span>
            </div>
        </div>
    </div>
    <main>
        <slot />
    </main>
</template>

<style lang="scss" scoped>
@import './layoutonboarding';
</style>
