<script setup>
import { usePage, Link, router } from "@inertiajs/vue3";
import { computed, ref, defineProps } from "vue";

const page = usePage();
const isLogin = computed(() => page.props.auth.user);
const user = computed(() => page.props.auth.user);
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
                <p>Copyright © RentalHouse, Inc. All Rights Reserved</p>
            </div>
        </footer>
        <div class="footerMobileBlock"></div>
        <div class="footerMobile">
            <div class="container" v-if="!props.isDashBoard">
                <ul>
                    <Link :href="route('top')">
                        <li :class="{ active: isRouteActive('/') }">
                            <i><img src="/img/icon/home.svg" alt="" /></i>
                            <p>Home</p>
                        </li>
                    </Link>
<!--                    <Link :href="route('top')">-->
<!--                        <li-->
<!--                            :class="{ active: isRouteActive('/reserved') }"-->
<!--                            v-if="isLogin"-->
<!--                        >-->
<!--                            <i><img src="/img/icon/plant.svg" alt="" /></i>-->
<!--                            <p>レッスン</p>-->
<!--                        </li>-->
<!--                    </Link>-->
                    <Link :href="route('request.index')">
                        <li :class="{ active: isRouteActive('/request') }">
                            <i><img src="/img/icon/request.svg" alt="" /></i>
                            <p>Request</p>
                        </li>
                    </Link>
                    <Link :href="route('top')">
                        <li
                            v-if="isLogin"
                            :class="{ active: isRouteActive('/notification') }"
                            class="icon-notification"
                        >
                            <i
                                ><img src="/img/icon/noti.svg" alt="" />
                                <p class="new-notification">
                                    {{ "10" }}
                                </p></i
                            >
                            <p>Notification</p>
                        </li>
                    </Link>
                    <div v-if="!isLogin">
                        <Link :href="route('login.method')">
                            <li>
                                <i
                                    ><img src="/img/icon/account.svg" alt=""
                                /></i>
                                <p>Login</p>
                            </li>
                        </Link>
                    </div>
                    <div v-else>
                        <Link :href="route('top')">
                            <li
                                :class="{ active: navOpen }"
                                @click="navOpen = !navOpen"
                            >
                                <i><img src="/img/icon/account.svg" alt="" /></i>
                                <p>Account</p>
                            </li>
                        </Link>
                        <div id="sidemenu">
                            <transition name="fade" appear>
                                <div
                                    v-if="navOpen"
                                    class="modal-overlay"
                                    @click="navOpen = false"
                                ></div>
                            </transition>
                            <transition name="translateX">
                                <nav v-show="navOpen">
                                    <div class="sidemenu__wrapper">
                                        <ul class="sidemenu__list">
                                            <div v-if="user">
                                                <li
                                                    class="sidemenu__item"
                                                >
                                                    <Link
                                                        :href="route('top')"
                                                    >
                                                        teeasf
                                                    </Link>
                                                </li>
                                                <li
                                                    class="sidemenu__item"
                                                >
                                                    <Link
                                                        :href="route('top')"
                                                    >
                                                        test
                                                    </Link>
                                                </li>
                                                <li
                                                    class="sidemenu__item"
                                                >
                                                    <Link
                                                        :href="route('top')"
                                                    >
                                                        test
                                                    </Link>
                                                </li>
                                            </div>
                                            <li class="sidemenu__item">
                                                <Link :href="route('logout')">
                                                    Logout
                                                </Link>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </transition>
                        </div>
                    </div>
                </ul>
            </div>
            <div v-if="props.isDashBoard" class="container">
                <ul>
                    <Link :href="route('top')">
                        <li class="active">
                            <i>
                                <img
                                    src="/img/icon/TeacherDashboard/pencil.svg"
                                    alt=""
                                />
                            </i>
                            <p class="active">Hold</p>
                        </li>
                    </Link>
                    <Link :href="route('top')">
                        <li v-if="isLogin">
                            <i>
                                <img
                                    src="/img/icon/TeacherDashboard/seed.svg"
                                    alt=""
                                />
                            </i>
                            <p>レッスン管理</p>
                        </li>
                    </Link>
                    <Link :href="route('top')">
                        <li>
                            <i>
                                <img
                                    src="/img/icon/TeacherDashboard/checkbox.svg"
                                    alt=""
                                />
                            </i>
                            <p>リクエスト</p>
                        </li>
                    </Link>
                    <Link>
                        <li v-if="isLogin">
                            <i>
                                <img
                                    src="/img/icon/TeacherDashboard/chatDoc.svg"
                                    alt=""
                                />
                            </i>
                            <p>レビュー管理</p>
                        </li>
                    </Link>
                    <Link :href="route('top')">
                        <li v-if="isLogin">
                            <i>
                                <img
                                    src="/img/icon/TeacherDashboard/chart.svg"
                                    alt=""
                                />
                            </i>
                            <p>売上管理</p>
                        </li>
                    </Link>
                </ul>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import './footer';
</style>
