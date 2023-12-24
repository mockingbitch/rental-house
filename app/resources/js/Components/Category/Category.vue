<template>
    <div class="category">
        <swiper
            class="swiper"
            :modules="modules"
            :space-between="50"
            :slides-per-view="numberOfCategories"
            :free-mode="true"
        >
            <swiper-slide
                v-for="category in $page.props.categories"
                class="slide"
                @click="handleSelectCategory(category)"
            >
                <div
                    class="category__box-item"
                    :class="{ isActive: category === isSelected }"
                >
                    <div
                        class="header-category_item_icon thumbContainer"
                        v-html="category.icon"
                    ></div>
                    <div class="header-category_item_title title">
                        {{ page?.locale === 'en' ? category?.name_en : category?.name_vi }}
                    </div>
                </div>
            </swiper-slide>
        </swiper>
        <div class="lineFull"></div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { Pagination, FreeMode } from "swiper";
import { Swiper, SwiperSlide } from "swiper/vue";
import { usePage } from "@inertiajs/vue3";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/free-mode";

const page = usePage().props;

export default defineComponent({
    name: "SwiperExampleFreeMode",
    title: "Free mode / no fixed positions",
    //   url: import.meta.url,
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        return {
            modules: [Pagination, FreeMode],
        };
    },
    data() {
        return {
            numberOfCategories: 0,
            isSelected: null,
        };
    },
    created() {
        window.addEventListener("resize", this.myEventHandler);
        this.myEventHandler();
    },
    destroyed() {
        window.removeEventListener("resize", this.myEventHandler);
    },
    methods: {
        myEventHandler(e) {
            switch (true) {
                case window.innerWidth <= 400:
                    this.numberOfCategories = 3;
                    break;
                case window.innerWidth > 400 && window.innerWidth <= 770:
                    this.numberOfCategories = 5;
                    break;
                case window.innerWidth > 770 && window.innerWidth <= 990:
                    this.numberOfCategories = 8;
                    break;
                default:
                    this.numberOfCategories = 8;
            }
        },

        handleSelectCategory(category) {
            if (this.isSelected && this.isSelected.id === category.id) {
                this.isSelected = null;
                this.$emit("handleFilterCategory", null);
                return;
            }
            this.isSelected = category;
            this.$emit("handleFilterCategory", category);
        },
    },
});
</script>

<style lang="scss" scoped>
@import "./_category.scss";

.category__box-item {
    height: 100%;
    position: relative;

    .title {
        display: flex;
        justify-content: center;
        line-height: 200%; /* 19.2px */
        letter-spacing: -0.3px;
        font-weight: 400;
    }

    &:hover,
    &.isActive {
        &::after {
            position: absolute;
            content: "";
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #5392F9 ;
        }
    }

    &.isActive {
        .header-category_item_title {
            font-weight: 700;
            color: #5392F9 ;
        }
    }
}
</style>
