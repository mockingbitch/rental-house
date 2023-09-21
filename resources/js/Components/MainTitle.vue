<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    label: String,
    route: String,
});
</script>
<template>
    <div
        class="main-title-container d-flex align-items-center justify-content-center"
    >
        <Link :href="props.route" class="main-title-img">
            <img src="../../../public/img/icon/close.svg" alt=""
        /></Link>
        <div>{{ props.label }}</div>
    </div>
</template>
<style scoped lang="scss">
.main-title-container {
    position: relative;
    padding: 12px 0px;
    font-size: 18px;
    font-style: normal;
    font-weight: 700;
    line-height: 160%;
    letter-spacing: -0.18px;
    width: 100%;
    height: 54px;
    .main-title-img {
        position: absolute;
        left: 10px;
        top: 10px;
        cursor: pointer;
    }
}
</style>
