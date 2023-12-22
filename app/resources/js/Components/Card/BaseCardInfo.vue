<script setup>
import { defineProps } from "vue";
const props = defineProps({
    // eslint-disable-next-line vue/require-default-prop
    label: String,
    // eslint-disable-next-line vue/require-default-prop
    content: String,
});
const checkForLinks = () => {
    const text = props.content;
    if (typeof text === 'string' || text instanceof String) {
        const regex = /https?:\/\/[^\s]+/g;
        const matches = text.match(regex);
        return matches ? matches : [];
    }
    return [];
};
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
                <span v-if="checkForLinks().length === 0">{{ content }}</span>
                <template v-else>
                  <span v-for="(part, index) in content.split(checkForLinks()[0])" :key="index">
                    {{ part }}
                    <a v-if="index < checkForLinks().length" :href="checkForLinks()[index]" target="_blank" rel="noopener" style="color: #1b1b1b; text-decoration: underline">
                      {{ checkForLinks()[index] }}
                    </a>
                  </span>
                </template>
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
            span {
                white-space: pre-line;
            }
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
