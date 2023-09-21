<template>
    <div
        class="star d-flex flex-column justify-content-center align-items-center"
    >
        <div class="star-title">{{ props?.title }}</div>
        <div class="star-content">
            <div
                class="d-flex justify-content-center"
                v-for="(content, index) in props?.contents"
                :key="index"
            >
                {{ content }}
            </div>
        </div>
        <div class="star-rating">
            <star-rating
                :rating="rating"
                :star-size="29"
                :increment="1"
                inactive-color="#ffffff"
                :active-color="'#418997'"
                :border-width="5"
                :border-color="'#418997'"
                :show-rating="false"
                :rounded-corners="true"
                :star-points="[
                    23, 2, 17, 17, 0, 19, 12, 31, 7, 50, 23, 40, 38, 50, 34, 31,
                    46, 19, 30, 17,
                ]"
                @update:rating="setRating"
            />
        </div>
        <div
            class="star-note d-flex flex-column align-items-center"
            v-if="rating !== 0"
        >
            <span>(仮)星の数により、どういう評価なのか？</span>
            <span>ある程度例やレベルを表記するもの。</span>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from "vue";
import StarRating from "vue-star-rating";

const props = defineProps({
    title: String,
    contents: Array,
    nameStandard: String,
    data: Number,
});

const emit = defineEmits();

const rating = ref(props.data);
const setRating = (newRating) => {
    rating.value = newRating;
    emit("rating", rating.value, props.nameStandard);
};
watch(
    () => props.data,
    (newValue, oldValue) => {
        rating.value = newValue;
    }
);
</script>

<style lang="scss" scoped>
.star {
    font-family: "Noto Sans JP";
    margin-top: 16px;
    &-title {
        color: #1b1b1b;
        padding: 8px 0;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: 25.6px; /* 25.6px */
        letter-spacing: -0.16px;
    }
    &-content {
        color: #1b1b1b;
        font-size: 12px;
        font-style: normal;
        font-weight: 400;
        line-height: 19.2px; /* 19.2px */
        letter-spacing: -0.12px;
    }
    &-rating {
        padding: 10px 0;
    }
    &-note {
        font-size: 12px;
        font-style: normal;
        font-weight: 400;
        line-height: 19.2px; /* 19.2px */
        letter-spacing: -0.12px;
        color: #418997;
    }
}
:deep(.vue-star-rating) {
    gap: 5px;
    .vue-star-rating-star {
        height: 34px;
    }
}
</style>
