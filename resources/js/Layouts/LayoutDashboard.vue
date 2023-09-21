<script setup>
import { ref, onMounted, onBeforeUnmount, computed, defineProps } from "vue";
import HeaderDashboard from "../Components/HeaderDashboard.vue";
import Footer from "@/Components/Footer.vue";

const windowWidth = ref(window.innerWidth);
const currentUrl = ref(window.location.pathname);
const currentPath = computed(() => currentUrl.value);
const isMobileScreen = computed(() => {
    return windowWidth.value <= 767; // Điều kiện cho màn hình nhỏ hơn 767px
});

const handleResize = () => {
    windowWidth.value = window.innerWidth; // Cập nhật giá trị windowWidth khi resize
    isMobileScreen.value = windowWidth.value <= 767; // Cập nhật giá trị isMobileScreen
};

const listUrlPageHideHeaderOnSP = ref([
    'teacher/course/',
])

const isHideHeaderOnSP = computed(() => {
    let isIncludeUrl = false;
    listUrlPageHideHeaderOnSP.value.forEach(url => {
        isIncludeUrl = currentPath.value.indexOf(url) !== -1;
    })

    return isIncludeUrl;
})

onMounted(() => {
    window.addEventListener("resize", handleResize);
});

// Huỷ đăng ký sự kiện resize khi component bị unmounted để tránh memory leak
onBeforeUnmount(() => {
    window.removeEventListener("resize", handleResize);
});
</script>

<template>
    <HeaderDashboard v-if="!isHideHeaderOnSP || !isMobileScreen" />
    <main>
        <slot />
    </main>
    <Footer isDashBoard />
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
</style>
