<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { ref, computed, defineProps, defineEmits } from "vue";
import Humberger from "@/Components/Humberger/Humberger.vue";
import MultiLanguage from "./MultiLanguage.vue";
import Notification from "./Notification.vue";

const props = defineProps({
    isReviewForm: Boolean,
    isHideOnMobile: {
        type: Boolean,
        default: false,
    },
});
const page = usePage();
const notifications = computed(() =>
    page.props?.auth?.user?.role == 2
        ? page.props?.teacher_notifications
        : page.props?.user_notifications
);

const emits = defineEmits();

const toggleSearch = () => {
    emits("toggleSearch"); // Emit the 'toggleSearch' event
};
const currentPath = ref(window.location.pathname);

const isSearchPage = computed(() => {
    return currentPath.value === "/search";
});
</script>

<template>
    <div class="headerTop">
        <div class="container">
            <div class="navPc">
                <div class="navPc__left">
                    <Link :href="route('top')">
                        <div class="logo">
                            <i
                                ><img
                                    src="/img/logo/RentalHouses.svg"
                                    alt="RentalHouses"
                            /></i>
                        </div>
                        <h1>RentalHouses</h1>
                    </Link>
                </div>
                <div class="navPc__search" v-if="!props.isReviewForm">
                    <button class="buttonImage left" @click="toggleSearch">
                        <img src="/img/icon/Search.svg" alt="" />
                    </button>
                    <div class="search__wrap" @click="toggleSearch">
                        <input
                            class="pc searchInput"
                            type="text"
                            placeholder="日付、年齢、料金、フリーキーワードで検索"
                            readonly
                        />
                        <textarea
                            class="mobile searchInput"
                            type="text"
                            placeholder="日付、年齢、料金、&#13;&#10;フリーキーワードで検索"
                        ></textarea>
                    </div>
                    <button class="buttonImage right" @click="toggleSearch">
                        <img src="/img/icon/Category.svg" alt="" />
                    </button>
                </div>
                <div class="navPc__right">
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('login.method')"
                        class="buttonHeader"
                        >Sign in</Link
                    >
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('register.method')"
                        class="buttonHeader green"
                        >Đăng ký</Link
                    >
                    <Link
                        v-if="$page.props.auth.user && !props.isReviewForm"
                        :href="route('logout')"
                        class="buttonHeader"
                        >Logout</Link
                    >
                    <!-- <button class="buttonImage">
                        <img src="/img/icon/List.svg" alt="" />
                    </button> -->
                    <!-- multi language -->
                    <MultiLanguage />
                    <Notification
                        v-if="page.props.auth.user"
                        :notifications="notifications"
                        :user="page.props.auth.user"
                        :isDashBoardTeacher="false"
                    />
                    <Humberger :humberger-color="'black'" />
                </div>
                <div v-if="!isSearchPage" class="lineFull"></div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "./header.scss";
.search__wrap {
    cursor: pointer;
}
.searchInput {
    cursor: pointer;
}
</style>
