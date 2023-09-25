<script setup>
import StarRating from "vue-star-rating";
import { defineProps } from "vue";
defineProps({
    stars: Number,
    bgStar: {
        type: String,
        default: "#ffffff",
    },
});
</script>

<template>
    <div class="stars">
        <star-rating
            :rating="stars"
            :star-size="11"
            :read-only="true"
            :increment="0.01"
            :active-color="'#5392F9 '"
            :inactive-color="bgStar"
            :show-rating="false"
            :border-color="'#b1b1b1'"
            :border-width="1"
            :rounded-corners="true"
        />
    </div>
</template>

<style lang="scss" scoped></style>
