<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    humbergerColor: {
        type: String,
        default: "black",  
    },
});

const navOpen = ref(false);
const page = usePage();

const user = computed(() => page.props.auth.user);
const verifyTeacher = computed(() => page.props.verify_teacher);
const userRole = computed(() => page.props.user_role);
const isUser = () => {
    if (usePage().props?.auth?.user?.role === '3') {
        return true;
    } else {
        return false;
    }
}
</script>
<template>
    <div id="sidemenu">
        <button class="sidemenu__btn" v-on:click="navOpen=!navOpen" v-bind:class="{active:navOpen}">
            <span class="top" :class="props.humbergerColor"></span>
            <span class="mid" :class="props.humbergerColor"></span>
            <span class="bottom" :class="props.humbergerColor"></span>
        </button>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="navOpen" @click="navOpen=false"></div>
        </transition>
        <transition name="translateX">
            <nav v-show="navOpen">
                <div class="sidemenu__wrapper">
                    <ul class="sidemenu__list">
                        <li class="sidemenu__item"><Link :href="user?.role == userRole.teacher ? route('teacher.request.list') : route('request.index')">リクエスト</Link></li>
                        <li class="sidemenu__item"><Link :href="isUser() ? route('user.account') : route('teacher.account')">アカウント設定</Link></li>
                        <div v-if="user">
                            <li v-if="user.verify_teacher != verifyTeacher.request_verified" class="sidemenu__item"><Link :href="route('onboarding.index')">{{ lang().label.humbeger.become_teacher }}</Link></li>
                            <li v-if="user.verify_teacher == verifyTeacher.request_verified && user.role == userRole.parent" class="sidemenu__item"><Link :href="route('switch.user.teacher')">{{ lang().label.humbeger.switch_to_teacher }}</Link></li>
                            <li v-if="user.verify_teacher == verifyTeacher.request_verified && user.role == userRole.teacher" class="sidemenu__item"><Link :href="route('switch.teacher.user')">{{ lang().label.humbeger.switch_to_user }}</Link></li>
                        </div>
                        <li class="sidemenu__item"><Link :href="route('user.reserved')">レッスン</Link></li>
                        <li class="sidemenu__item"><Link href="">よくある質問</Link></li>
                        <li class="sidemenu__item"><Link href="">お問い合せ</Link></li>
                    </ul>
                </div>
            </nav>
        </transition>
    </div>
</template>

<style lang="scss" scoped>
@import "./_humberger.scss";
</style>