<script setup>
import { defineProps, defineEmits } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    items: Array,
    isHideSp: Boolean,
});
const emits = defineEmits();

const handleClick = (item) => {
    if (item.isLink) {
        emits("handleClick", item);
    }
};
</script>

<template>
    <div class="d-flex breadcrumb-container" :class="{ isHideSp: isHideSp }">
        <div
            v-for="(item, index) in items"
            :key="index"
            class="bread__item-wrapper"
        >
            <Link
                v-if="item.href && !item.params"
                class="breadcrumb-prev-link"
                :href="route(item.href)"
            >
                {{ item.text }}
            </Link>
            <Link
                v-else-if="item.params"
                class="breadcrumb-prev-link"
                :href="route(item.href, item.params)"
            >
                {{ item.text }}
            </Link>
            <span v-else-if="item.isLink">
                <span
                    class="breadcrumb-prev-link"
                    @click="handleClick(item)"
                >
                    {{ item.text }}
                </span>
            </span>
            <span v-else class="breadcrumb-curr-link">
                {{ item.text }}
            </span>
        </div>
    </div>
</template>

<style lang='scss' scoped>
@import './breadcrumb';
</style>
