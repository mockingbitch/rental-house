<template>
    <div class="no-result-container d-flex flex-column justify-content-center">
        <div class="no-result-container-title d-flex justify-content-center">
            {{ lang().label.user.reserved.no_reserved }}
        </div>
        <div
            class="no-result-container-note d-flex flex-column align-items-center"
        >
            <span
                >あいうえおあいうえおあいうえおあいうえおあいうえおあいう
            </span>
            <span>えおあいうえおあいうえおあいうえおあいうえお</span>
        </div>
    </div>
</template>

<script setup></script>

<style lang="scss" scoped>
.no-result-container {
    margin-top: 16px;
    padding: 32px 0;
    gap: 16px;
    &-title {
        font-size: 16px;
        font-weight: bold;
        line-height: 160%;
        letter-spacing: -0.16px;
    }
    &-note {
        font-size: 12px;
        line-height: 1.6;
        letter-spacing: -0.12px;
        font-weight: 400;
        color: #767474;
    }
}
</style>
