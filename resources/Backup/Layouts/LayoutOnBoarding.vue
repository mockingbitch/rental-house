<script setup>
import { defineProps, defineEmits } from "vue";
import { Link } from "@inertiajs/vue3";
import Humberger from "@/Components/Humberger/Humberger.vue";

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
                <Humberger :hamburger-color="'white'" />
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
main {
    min-height: calc(100vh - 54px - 80px);
    padding-bottom: 52px;

    @media screen and (max-width: 991px) and (min-height: 500px) {
        min-height: calc(100vh - 54px - 52px);
        padding-bottom: 0;
    }
}
.container {
    background-color: #343434;
    max-width: 100% !important;
}
.navDashboard {
    display: flex;
    justify-content: space-between;
    color: #ffffff;
    min-height: 54px;
    align-items: center;
    .navDashboard__left {
        display: flex;
        align-items: center;
        gap: 8px;
        span {
            font-size: 14px;
            font-weight: 700;
        }
    }
    .navDashboard__right {
        display: flex;
        gap: 20px;
    }
    .navDashBoardCenter {
        .nav-cancel {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }
        .nav-title {
            font-size: 18px;
            font-weight: bold;
            line-height: 160%; /* 28.8px */
            letter-spacing: -0.18px;
            color: #ffffff;
        }
    }
}

@media screen and (min-width: 1200px) {
    .container {
        padding-left: 100px;
        padding-right: 100px;
    }
}

@media screen and (max-width: 768px) {
    .hide-icon {
        display: none;
    }
    .hideNavBar {
        display: none !important;
    }
    .navDashboard {
        position: relative;
    }
    .navCenter {
        justify-content: center;
    }
}

@media screen and (min-width: 768px) {
    .navDashBoardCenter {
        display: none !important;
    }
}
</style>
