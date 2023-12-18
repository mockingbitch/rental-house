<script setup>
import {computed} from "vue";
import {Link, usePage} from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import Search from "@/Components/Search/Search.vue";
import Stars from "@/Components/Rating/Stars.vue";
import { houseRating } from "@/Helper/Rating";
import { priceFormat } from "@/Helper/CurrencyHelper";
import { sortArrayByPrice, sortArrayByCapacity } from "@/Helper/SortHelper";

const props = defineProps({
    houses: Array,
    listSuggest: Array,
    dataSearch: Array,
});
// eslint-disable-next-line vue/valid-define-emits
const emits = defineEmits();
const isSearchVisible = ref(false);
let inputSearch = ref("");

const handleSearch = () => {
    return props.houses.filter((item) =>
        item.title.toLowerCase().includes(inputSearch.value.toLowerCase())
    );
};

function convertH2M(start, end) {
    return Number(start) * 60 + Number(end);
}

const imageUrlAlt = (event) => {
    return (event.target.src = "https://placehold.co/600x400");
};
const startPrice = 5;
const finishPrice = 10;

const formatPrice = (value) => {
    let val = (value / 1).toFixed(0).replace(".", ",");
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};
const toggleSearch = () => {
    isSearchVisible.value = !isSearchVisible.value;
};
// const startPrice = computed(() =>
//     props.dataSearch.start_draft_price
//         ? formatPrice(props.dataSearch.start_draft_price)
//         : usePage().props.language.original.label.searchResult.price_default
// );
// const finishPrice = computed(() =>
//     props.dataSearch.finish_draft_price
//         ? formatPrice(props.dataSearch.finish_draft_price)
//         : usePage().props.language.original.label.searchResult.price_default
// );

const rating = props.houses.map((house) => {
    return houseRating(house)
});

const ratingSuggest = props.listSuggest.map((house) => {
    return houseRating(house)
});
</script>
<script>
import { defineComponent, ref } from "vue";
import Flickity from "flickity";

export default defineComponent({
    components: {
        // eslint-disable-next-line vue/no-unused-components
        Flickity,
    },
    data() {
        return {
            flickityOptions: {
                cellAlign: "left",
                freeScroll: true,
                prevNextButtons: false,
                contain: true,
                passive: false,
            },
        };
    },
    mounted() {
        this.initFlickity();
    },
    updated() {
        this.initFlickity();
    },
    beforeDestroy() {
        if (this.carousel) {
            this.carousel.destroy();
        }
    },
    methods: {
        initFlickity() {
            this.$nextTick(() => {
                this.carousel = new Flickity(
                    this.$refs.carousel,
                    this.flickityOptions
                );
                this.carousel.resize();
            });
        },
        handleToggleSearch(data) {
            if (data === false) {
                this.initFlickity();
            }
        },
    },
});
</script>

<template>
    <Layout :is-search-visible="isSearchVisible" @toogle-search="handleToggleSearch">
        <main class="searchResult">
            <div class="container">
                <div v-if="!isSearchVisible" class="header">
                    <div class="header__wrap">
                        <button class="buttonImage" @click="toggleSearch">
                            <img src="/img/icon/arrownLeft.svg" alt="" />
                        </button>
                        <h2>Title</h2>
                        <!-- <button class="buttonImage" @click="toggleSearch">
                            <img src="/img//icon/Category.svg" alt="" />
                        </button> -->
                        <button class="buttonImage">
                            <img src="/img//icon/Category.svg" alt="" />
                        </button>
                    </div>
                    <div class="lineFull"></div>
                </div>
                <Search v-if="isSearchVisible" @toggleSearch="toggleSearch" />
                <div v-if="!isSearchVisible" class="keyword">
                    <div class="keyword__wrap">
                        <div v-if="houses.length > 0" class="result-quantity">
                            <span>
                                {{ houses.length }} houses found
                            </span>
                        </div>
                        <div
                            ref="carousel"
                            class="carousel"
                            touch-action="pan-y"
                        >
                            <div
                                class="slide filter__wrapper user carousel-cell"
                                @click="toggleSearch"
                            >
                                <i class="filter__icon">
                                    <img src="/img/icon/userGray.svg" alt="" />
                                </i>
                                <div class="header-category_item_title">
                                    1-2
                                </div>
                            </div>
                            <div
                                class="slide filter__wrapper price carousel-cell"
                                @click="toggleSearch"
                            >
                                <i class="filter__icon">
                                    <img src="/img/icon/Walet.svg" alt="" />
                                </i>
                                <div class="header-category_item_title">
                                    {{ startPrice }}
                                    ~
                                    {{ finishPrice }}
                                    VND
                                </div>
                            </div>
                            <div
                                class="slide filter__wrapper date carousel-cell"
                                @click="toggleSearch"
                            >
                                <i class="filter__icon">
                                    <img src="/img/icon/Calender.svg" alt="" />
                                </i>
                                <div class="header-category_item_title">
                                    5
                                    ~
                                    10
                                </div>
                            </div>
                            <div
                                class="slide filter__wrapper carousel-cell"
                                @click="toggleSearch"
                            >
                                <i class="filter__icon">
                                    <img src="/img/icon/Calender.svg" alt="">
                                </i>
                                <div class="header-category_item_title">
                                    <span class="day-text">
                                        test
                                    </span>
                                </div>
                            </div>
                            <div
                                class="slide filter__wrapper carousel-cell"
                                @click="toggleSearch"
                            >
                                <i class="filter__icon">
                                    <img src="/img/icon/Clock.svg" alt="" />
                                </i>
                                <div class="header-category_item_title">
                                    g
                                    ~
                                    b
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="!isSearchVisible" class="line__wrapper">
                    <div class="lineFull"></div>
                </div>
                <div
                    v-if="houses.length > 0 && !isSearchVisible"
                    class="result"
                >
                    <Link
                        v-for="(house, index) in houses"
                        :key="index"
                        :href="route('house.detail', house.id)"
                        class="item"
                    >
                        <div class="item__top">
                            <div class="image">
                                <img :src="house?.thumbnail || 'https://placehold.co/600x400'" alt="" />
                            </div>
                            <div class="">
                                <div class="d-flex align-items-center rating-section">
                                    <img
                                        src="/img//icon/star.svg"
                                        alt=""
                                    />
                                    <div class="rating-wrap">
                                        <span class="rating-star">
                                            {{ rating[index].toFixed(1) }}
                                        </span>
                                        <span class="rating-count">
                                            ({{ house?.review?.length }})
                                        </span>
                                    </div>
                                </div>
                                <div class="result__title-wrapper">
                                    <h2 class="result__title-text">
                                        {{ house?.name }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="item__bottom">
                            <div class="author">
                                <div class="author__left">
                                    <div class="avatar">
                                        <img
                                            :src="house?.lessor?.avatar || '/img/icon/iconAvatarDefault.svg'"
                                            alt=""
                                        />
                                    </div>
                                    <p>
                                        {{
                                            house?.lessor?.first_name +
                                            " " +
                                            house?.lessor?.last_name
                                        }}
                                    </p>
                                </div>
                            </div>
                            <div class="result__description-wrapper">
                                <p class="result__description">
                                    {{ house?.description }}
                                </p>
                            </div>
                            <ul class="search__result-lesson-info">
                                <li class="result__info-box">
                                    <div class="star">
                                        <div class="result__info-top">
                                            <p>
                                                <span>
                                                    {{ priceFormat(sortArrayByPrice(house.rooms)[0]?.price) }}
                                                    -
                                                    {{ priceFormat(sortArrayByPrice(house.rooms)[house.rooms.length - 1]?.price) }}
                                                    VND
                                                </span>
                                            </p>
                                        </div>
                                        <p>Price</p>
                                    </div>
                                </li>
                                <li class="result__info-box">
                                    <div class="star">
                                        <div class="result__info-top">
                                            <p>
                                                <span>
                                                    {{ sortArrayByCapacity(house.rooms)[0]?.capacity }}
                                                    -
                                                    {{ sortArrayByCapacity(house.rooms)[house.rooms.length - 1]?.capacity }} Person
                                                </span>
                                            </p>
                                        </div>
                                        <p>Capacity</p>
                                    </div>
                                </li>
                                <li class="result__info-box">
                                    <div class="star">
                                        <div class="result__info-top">
                                            <p style="display: flex; text-align: center;">
                                                <span>
                                                    category
                                                </span>
                                            </p>
                                        </div>
                                        <p>Type</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </Link>
                </div>
                <div
                    v-if="houses.length < 1 && !isSearchVisible"
                    class="noData"
                >
                    <div class="top">
                        <div class="noData__img-wrapper">
                            <img src="img/icon/tree.svg" alt="" />
                        </div>
                        <p class="noData__desc-text">
                            No result found
                            <br>
                            No result
                        </p>
                    </div>
                    <div class="bottom">
                        <h2 class="suggest__title-text">
                            Related house
                        </h2>
                        <div class="topScreen">
                            <div class="topScreen__wrap">
                                <Link
                                    v-for="(house, index) in listSuggest"
                                    :key="index"
                                    class="item"
                                    :href="route('house.detail', house.id)"
                                >
                                    <div class="image">
                                        <img
                                            :src="house?.thumbnail || 'https://placehold.co/600x400'"
                                            alt="house"
                                            @error="imageUrlAlt"
                                        />
                                    </div>
                                    <div class="rating">
                                        <Stars :stars="ratingSuggest[index]" />
                                        <span class="count">{{ ratingSuggest[index].toFixed(1) }} (1)</span>
                                    </div>
                                    <div class="title">
                                        <h2>
                                            {{ house?.title }}
                                        </h2>
                                    </div>
                                    <div class="description">
                                        <p>{{ house?.decription }}</p>
                                    </div>
                                    <div class="price">{{ house?.price }}VND</div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </Layout>
</template>
<style lang="scss" scoped>
@import "../../../../css/_top.scss";
@import "../../../../../public/scss/imports/core/mixins";
@import "../../../../../public/scss/imports/core/variables";
@import "./searchresult";
</style>
