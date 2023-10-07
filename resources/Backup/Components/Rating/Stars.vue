<script setup>
import StarRating from "vue-star-rating";
import { defineProps } from "vue";
defineProps({
    stars: Number,
});
</script>

<template>
    <div class="stars">
        <star-rating
            :rating="stars"
            :star-size="10"
            :read-only="true"
            :increment="0.01"
            :active-color="'#5392F9 '"
            inactive-color="#ffffff"
            :show-rating="false"
			:border-color="'#5392F9 '"
			:border-width="2"
			:rounded-corners="true"
        />
    </div>
</template>

<style lang="scss" scoped></style>
