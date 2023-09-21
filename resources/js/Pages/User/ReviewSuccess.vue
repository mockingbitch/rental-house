<script setup>
import ReviewSuccess from "@/Components/ReviewSuccess.vue";
import Layout from "@/Layouts/Layout.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    lesson_id: Number,
});
</script>
<template>
    <Layout :isReviewForm="true">
        <div class="header__review">
            <div class="logo d-flex justify-content-center align-items-center">
                <Link :href="route('top')">
                    <i
                        ><img
                            src="../../../../public/img/logo/DotreesReview.svg"
                            alt="DotTrees"
                    /></i>
                </Link>
            </div>

            <div class="lineFull"></div>
        </div>
        <ReviewSuccess :lesson_id="props.lesson_id"/>
    </Layout>
</template>
<style lang="scss" scoped>
.header__review {
    padding: 11px 16px;
    position: relative;
    .logo {
        padding: 8px 0;
        position: relative;
        max-width: 368px;
        margin: auto;
        .icon-review {
            position: absolute;
            left: 0;
            cursor: pointer;
        }
    }
}

.header__review-PC {
    position: relative;
    margin-top: 8px;
    margin-bottom: 16px;
    padding: 11px 0;
}

@media screen and (min-width: 768px) {
    .review__form {
        padding: 16px 0;
    }
    .header__review {
        display: none;
    }
}
@media screen and (max-width: 768px) {
    .header__review-PC {
        display: none;
    }
}
</style>
