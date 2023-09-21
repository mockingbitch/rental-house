<script setup>
import { defineProps } from "vue";
const props = defineProps({
    label: String,
    content: String,
});
</script>
<template>
    <div class="account-info-group">
        <div class="title-content">
            <span>
                {{ label }}
            </span>
        </div>
        <div class="filled-content">
            <p>
                {{ content }}
            </p>
        </div>
    </div>
</template>
<style scoped lang="scss">
.account-info-group {
    text-align: left;
    .filled-content {
        p {
            font-size: 14px;
            font-weight: bold;
            word-wrap: break-word;
            margin-top: 6.5px;
            min-height: 22px;
            line-height: 1.6;
            letter-spacing: -0.14px;
        }
    }
    .title-content {
        height: 16px;

        span {
            color: #1b1b1b;
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 160%; /* 19.2px */
            letter-spacing: -0.12px;
        }
    }
}
</style>
