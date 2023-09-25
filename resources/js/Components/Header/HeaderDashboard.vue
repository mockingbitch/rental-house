<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import Humberger from "@/Components/Humberger/Humberger.vue";
import Notification from "./Notification.vue";
import { computed } from "vue";

const page = usePage();
const notifications = computed(() => page.props?.teacher_notifications);
</script>

<template>
    <div class="container">
        <div class="navDashboard">
            <div class="navDashboard__left">
                <Link :href="route('top')">
                    <img src="/img/icon/TeacherDashboard/dottress.svg" alt="" />
                </Link>
                <span class="">Dashboard</span>
            </div>
            <div class="navDashboard__right">
                <img src="/img/icon/TeacherDashboard/refresh.svg" alt="" />
                <img src="/img/icon/TeacherDashboard/add.svg" alt="" />
                <Notification
                    v-if="$page.props.auth.user"
                    :notifications="notifications"
                    :user="page.props.auth.user"
                    :isDashBoardTeacher="true"
                />
                <Humberger :humberger-color="'white'" />
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "../../../public/scss/imports/core/mixins";
@import "../../../public/scss/imports/core/variables";
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
}

@media screen and (min-width: 1200px) {
    .container {
        padding-left: 100px;
        padding-right: 100px;
    }
}

:deep(.notification-icon) {
    margin: 0;
}
:deep(.notification-svg) {
    display: flex;
}
:deep(.sidemenu__btn) {
    width: 32px !important;
}
</style>
