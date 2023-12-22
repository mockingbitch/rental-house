<script setup>
import { ref, defineEmits, defineProps } from "vue";
const appliedTab = ref(true);
const listRequestTab = ref(false);
const emits = defineEmits();
const props = defineProps({
    isUser: Boolean,
});
const changeTabRequest = () => {
    emits("changeTabRequest");
    appliedTab.value = true;
    listRequestTab.value = false;
};
const changeTabListRequest = () => {
    emits("changeTabListRequest");
    appliedTab.value = false;
    listRequestTab.value = true;
};
</script>
<template>
    <div class="request__header-container">
        <div
            class="request__header-item"
            :style="{
                color: appliedTab ? '#418997' : '#4D4D4D',
                fontWeight: appliedTab ? 'bold' : 'normal',
                borderBottom: appliedTab ? '2px solid #418997' : 'none',
            }"
            @click="changeTabRequest"
        >
            Requested
        </div>
        <div
            class="request__header-item"
            :style="{
                color: listRequestTab ? '#418997' : '#4D4D4D',
                fontWeight: listRequestTab ? 'bold' : 'normal',
                borderBottom: listRequestTab ? '2px solid #418997' : 'none',
            }"
            @click="changeTabListRequest"
        >
            List of request
        </div>
    </div>
</template>
<style scoped>
.request__header-container {
    max-height: 54px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #f4f4f4;
}
.request__header-item {
    width: 50%;
    text-align: center;
    font-size: 14px;
    padding: 15px 16px;
    line-height: 1.42;
    cursor: pointer;
}
</style>
