<script setup>
import { ref, onMounted, onBeforeUnmount, computed, defineProps } from "vue";
import HeaderDashboard from "@/Components/Header/HeaderDashboard.vue";
import Footer from "@/Components/Footer/Footer.vue";
import DashboardSideMenu from "@/Components/SideMenu/DashboardSideMenu.vue"

// ẩn footer ở các màn
const props = defineProps({
	isHideFooterSp : Boolean,
    isHideSp: Boolean,
})
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
    '/teacher',
    '/course',
]);

const isHideHeaderOnSP = computed(() => {
    return listUrlPageHideHeaderOnSP.value.every(url => currentPath.value.includes(url));
});
onMounted(() => {
    window.addEventListener("resize", handleResize);
});

// Huỷ đăng ký sự kiện resize khi component bị unmounted để tránh memory leak
onBeforeUnmount(() => {
    window.removeEventListener("resize", handleResize);
});

const isShowSideMenu = ref(false);
const handleIsShowSideMenu = (value) => {
    isShowSideMenu.value = value
    localStorage.setItem('isShowSideMenu', value.toString());
}
onMounted(() => {
  const storedValue = localStorage.getItem('isShowSideMenu');
  if (storedValue !== null) {
    isShowSideMenu.value = storedValue === 'true';
  }
});
</script>

<template>
    <HeaderDashboard
        v-if="(!isHideHeaderOnSP || !isMobileScreen) && !props.isHideSp"
        :is-show-side-menu="isShowSideMenu"
        @is-show-side-menu="handleIsShowSideMenu"
    />
    <main
        :class="[ 'main-transition', isShowSideMenu ? 'is-have-side-menu' : 'is-leave-to', props.isHideSp || isHideHeaderOnSP ? 'isHideSp' : '' ]"
    >
        <slot />
    </main>
    <transition name="translateX">
        <DashboardSideMenu v-if="isShowSideMenu" />
    </transition>
    <Footer isDashBoard v-if="!props.isHideFooterSp" />
</template>

<style lang="scss" scoped>
@import './layoutdashboard';
</style>
