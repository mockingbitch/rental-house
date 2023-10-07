<template>
    <div class="d-flex breadcrumb-container">
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
            <span v-else-if="item.isLink"
                ><span
                    class="breadcrumb-prev-link"
                    @click="handleClick(item)"
                    >{{ item.text }}</span
                >
            </span>
            <span v-else class="breadcrumb-curr-link">{{ item.text }}</span>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    items: Array,
});
const emits = defineEmits();

const handleClick = (item) => {
    if (item.isLink) {
        emits("handleClick", item);
    }
};
</script>

<style scoped lang="scss">
.breadcrumb-container {
    width: 100%;
    background-color: #f4f4f4;
    padding: 16px 100px;
    font-size: 16px;
    gap: 4px;

    .bread__item-wrapper {
        max-width: 145px;
        overflow: hidden;
        white-space: nowrap; /* Ngăn text xuống dòng */
    }
    .bread__item-wrapper + .bread__item-wrapper {
        position: relative;
        padding-left: 9px;

        &::before {
            position: absolute;
            content: "-";
            width: 5px;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }
    }

    .breadcrumb-prev-link {
        text-decoration: underline;
        cursor: pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #000;
    }
    .breadcrumb-curr-link {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}
@media all and (max-width: 768px) {
    .breadcrumb-container {
        padding: 16px;
    }
}
</style>
