<script setup>
import Header from "@/Components/Header.vue";
import Footer from "@/Components/Footer.vue";
import Search from "@/Components/Search.vue";
import { ref, onMounted, onBeforeUnmount, computed, defineProps } from "vue";

const props = defineProps({
    isReviewForm: Boolean,
});

const isSearchVisible = ref(false);
const windowWidth = ref(window.innerWidth);

const toggleSearch = () => {
    isSearchVisible.value = !isSearchVisible.value;
};

const isMobileScreen = computed(() => {
    return windowWidth.value <= 767; // Điều kiện cho màn hình nhỏ hơn 767px
});

const handleResize = () => {
    windowWidth.value = window.innerWidth; // Cập nhật giá trị windowWidth khi resize
    isMobileScreen.value = windowWidth.value <= 767; // Cập nhật giá trị isMobileScreen
};

const currentUrl = window.location.pathname;

// Khi thành phần được mount, kiểm tra kích thước màn hình và thêm sự kiện resize
onMounted(() => {
    window.addEventListener("resize", handleResize);
});

// Huỷ đăng ký sự kiện resize khi component bị unmounted để tránh memory leak
onBeforeUnmount(() => {
    window.removeEventListener("resize", handleResize);
});
</script>

<template>
    <Header
        v-if="
            (currentUrl === '/search' && !isMobileScreen) ||
            (currentUrl !== '/search' && (!isMobileScreen || !isSearchVisible))
        "
        :is-hide-on-mobile="isMobileScreen || props.isReviewForm"
        :is-review-form="props.isReviewForm"
        @toggleSearch="toggleSearch"
    />
    <main>
        <Search v-if="isSearchVisible" @toggleSearch="toggleSearch" />
        <slot v-else />
    </main>
    <Footer v-if="!isSearchVisible" />
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

.hideHeader {
    display: none;
}
</style>
