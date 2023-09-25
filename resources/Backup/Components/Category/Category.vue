<script></script>
<template>
    <div class="category">
        <swiper
            class="swiper"
            :modules="modules"
            :space-between="0"
            :slides-per-view="numberOfCategories"
            :free-mode="true"
        >
            <swiper-slide
                class="slide"
                v-for="category in $page.props.categories"
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
                        {{ category.name_en }}
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
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/free-mode";

const windowWidth = ref(window.innerWidth).value;

export default defineComponent({
    name: "swiper-example-free-mode",
    title: "Free mode / no fixed positions",
    //   url: import.meta.url,
    components: {
        Swiper,
        SwiperSlide,
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
    setup() {
        return {
            modules: [Pagination, FreeMode],
        };
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
                    this.numberOfCategories = 10;
                    break;

                default:
                    this.numberOfCategories = 13;
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
        line-height: 160%; /* 19.2px */
        letter-spacing: -0.12px;
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
