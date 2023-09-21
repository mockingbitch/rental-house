<script setup>
import { usePage, Link, router } from "@inertiajs/vue3";
import { computed, ref, defineProps } from "vue";

const page = usePage();
const isLogin = computed(() => page.props.auth.user);
const user = computed(() => page.props.auth.user);
const verifyTeacher = computed(() => page.props.verify_teacher);
const userRole = computed(() => page.props.user_role);

const navOpen = ref(false);
const props = defineProps({
    isDashBoard: Boolean,
});

const isRouteActive = (routeName) => {
    return router.page.url === routeName;
};
</script>

<template>
    <div>
        <footer>
            <div class="bottom">
                <p>Copyright © dottree, Inc. All Rights Reserved</p>
            </div>
        </footer>
        <div class="footerMobileBlock"></div>
        <div class="footerMobile">
            <div class="container" v-if="!props.isDashBoard">
                <ul>
                    <Link :href="route('top')">
                        <li :class="{ active: isRouteActive('/') }">
                            <i><img src="/img/icon/home.svg" alt="" /></i>
                            <p>ホーム</p>
                        </li>
                    </Link>
                    <Link :href="route('user.reserved')">
                        <li
                            :class="{ active: isRouteActive('/reserved') }"
                            v-if="isLogin"
                        >
                            <i><img src="/img/icon/plant.svg" alt="" /></i>
                            <p>レッスン</p>
                        </li>
                    </Link>
                    <Link :href="route('request.index')">
                        <li :class="{ active: isRouteActive('/request') }">
                            <i><img src="/img/icon/request.svg" alt="" /></i>
                            <p>リクエスト</p>
                        </li>
                    </Link>
                    <Link :href="route('user.notification')">
                        <li
                            :class="{ active: isRouteActive('/notification') }"
                            v-if="isLogin"
                            class="icon-notification"
                        >
                            <i
                                ><img src="/img/icon/noti.svg" alt="" />
                                <p class="new-notification">
                                    {{ "10" }}
                                </p></i
                            >
                            <p>通知</p>
                        </li>
                    </Link>
                    <div v-if="!isLogin">
                        <Link :href="route('login.method')">
                            <li>
                                <i
                                    ><img src="/img/icon/account.svg" alt=""
                                /></i>
                                <p>ログイン</p>
                            </li>
                        </Link>
                    </div>
                    <div v-else>
                        <li
                            v-on:click="navOpen = !navOpen"
                            v-bind:class="{ active: navOpen }"
                        >
                            <i><img src="/img/icon/account.svg" alt="" /></i>
                            <p>アカウント</p>
                        </li>
                        <div id="sidemenu">
                            <transition name="fade" appear>
                                <div
                                    class="modal-overlay"
                                    v-if="navOpen"
                                    @click="navOpen = false"
                                ></div>
                            </transition>
                            <transition name="translateX">
                                <nav v-show="navOpen">
                                    <div class="sidemenu__wrapper">
                                        <ul class="sidemenu__list">
                                            <div v-if="user">
                                                <li
                                                    v-if="
                                                        user.verify_teacher !=
                                                        verifyTeacher.request_verified
                                                    "
                                                    class="sidemenu__item"
                                                >
                                                    <Link
                                                        :href="
                                                            route(
                                                                'show.form.become-teacher'
                                                            )
                                                        "
                                                        >{{
                                                            lang().label
                                                                .humbeger
                                                                .become_teacher
                                                        }}</Link
                                                    >
                                                </li>
                                                <li
                                                    v-if="
                                                        user.verify_teacher ==
                                                            verifyTeacher.request_verified &&
                                                        user.role ==
                                                            userRole.parent
                                                    "
                                                    class="sidemenu__item"
                                                >
                                                    <Link
                                                        :href="
                                                            route(
                                                                'switch.user.teacher'
                                                            )
                                                        "
                                                        >{{
                                                            lang().label
                                                                .humbeger
                                                                .switch_to_teacher
                                                        }}</Link
                                                    >
                                                </li>
                                                <li
                                                    v-if="
                                                        user.verify_teacher ==
                                                            verifyTeacher.request_verified &&
                                                        user.role ==
                                                            userRole.teacher
                                                    "
                                                    class="sidemenu__item"
                                                >
                                                    <Link
                                                        :href="
                                                            route(
                                                                'switch.teacher.user'
                                                            )
                                                        "
                                                        >{{
                                                            lang().label
                                                                .humbeger
                                                                .switch_to_user
                                                        }}</Link
                                                    >
                                                </li>
                                            </div>
                                            <li class="sidemenu__item">
                                                <Link :href="route('logout')"
                                                    >Logout</Link
                                                >
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </transition>
                        </div>
                    </div>
                </ul>
            </div>
            <div class="container" v-if="props.isDashBoard">
                <ul>
                    <Link :href="route('teacher.dashboard')">
                        <li class="active">
                            <i
                                ><img
                                    src="/img/icon/TeacherDashboard/pencil.svg"
                                    alt=""
                            /></i>
                            <p class="active">ダッシュボード</p>
                        </li>
                    </Link>
                    <Link :href="route('lesson.list')">
                        <li v-if="isLogin">
                            <i
                                ><img
                                    src="/img/icon/TeacherDashboard/seed.svg"
                                    alt=""
                            /></i>
                            <p>レッスン管理</p>
                        </li>
                    </Link>
                    <Link :href="route('teacher.request.list')">
                        <li>
                            <i
                                ><img
                                    src="/img/icon/TeacherDashboard/checkbox.svg"
                                    alt=""
                            /></i>
                            <p>リクエスト</p>
                        </li>
                    </Link>
                    <Link>
                        <li v-if="isLogin">
                            <i
                                ><img
                                    src="/img/icon/TeacherDashboard/chatDoc.svg"
                                    alt=""
                            /></i>
                            <p>レビュー管理</p>
                        </li>
                    </Link>
                    <Link>
                        <li v-if="isLogin">
                            <i
                                ><img
                                    src="/img/icon/TeacherDashboard/chart.svg"
                                    alt=""
                            /></i>
                            <p>売上管理</p>
                        </li>
                    </Link>
                </ul>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
#sidemenu {
    position: relative;

    nav {
        width: fit-content;
        max-height: 250px;
        position: absolute;
        bottom: 62px;
        right: 0;
        z-index: 99;
        background-color: #fff;
        border: 1px solid #000;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.25);
    }

    .sidemenu {
        &__btn {
            display: block;
            width: 50px;
            height: 100%;
            background: none;
            border: none;
            position: relative;
            z-index: 100;
            appearance: none;
            cursor: pointer;
            outline: none;

            // span {
            // 	display: block;
            // 	width: 26px;
            // 	height: 3px;
            // 	margin: auto;
            // 	background: black;
            // 	position: absolute;
            // 	top: 0;
            // 	bottom: 0;
            // 	left: 0;
            // 	right: 0;
            // 	transition: all .4s ease;
            //     border-radius: 2px;

            // 	&.top {
            // 		transform: translateY(-9px);
            // 	}

            // 	&.bottom {
            // 		transform: translateY(9px);
            // 	}
            // }
            // &.active{
            // 	.top {
            // 		transform: rotate(-45deg);
            // 	}
            // 	.mid{
            // 		transform: translateX(-20px) rotate(360deg);
            // 		opacity: 0;
            // 	}
            // 	.bottom {
            // 		transform: rotate(45deg);
            // 	}
            // }
        }

        &__wrapper {
            // padding-top: 50px;
            height: max-content;
        }

        &__list {
            padding-top: 50px;
            list-style: none;
            padding: 0;
            margin: 0;
            height: max-content;
        }

        &__item {
            display: flex;
            padding: 5px 20px;
            align-items: center;
            height: max-content;
            &:hover {
                background: lightgrey;
                color: dimgrey;
            }

            a {
                color: #000;
                font-family: Inter;
                font-size: 14px;
                font-style: normal;
                font-weight: 500;
                line-height: 16px;
                justify-content: left;
            }
        }
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 98;
        background-color: rgba(0, 0, 0, 0);
    }
}

.translateX-enter-active {
    transition: all 0.3s ease-out;
}

.translateX-leave-active {
    transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.translateX-enter-from,
.translateX-leave-to {
    transform: translateX(20px);
    opacity: 0;
}

.container li p {
    font-size: 9px;
    font-weight: 400;
}

:deep(.active) {
    font-weight: 700 !important;
    img {
        svg {
            path {
                fill: #418997 !important;
            }
        }
    }
}

:deep(.icon-notification) {
    position: relative;
}

.new-notification {
    font-family: "Noto San JP";
    position: absolute;
    font-size: 10px !important;
    width: 16px;
    height: 16px;
    color: #ffffff;
    border-radius: 100px;
    top: 0;
    right: 14px;
    background-color: red;
    font-weight: bold;
    z-index: 10000000000;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
