<script setup>
import { computed, ref } from "vue";
import Layout from "../Layouts/Layout.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/free-mode";
import { Link, usePage } from "@inertiajs/vue3";
import Search from "@/Components/Search.vue";
import Stars from "@/Components/Rating/Stars.vue";
import { lessonRating } from "@/Helper/lessonRating";

const props = defineProps({
    lessons: Array,
    listSuggest: Array,
    dataSearch: Array,
});
const emits = defineEmits();
const isSearchVisible = ref(false);
let inputSearch = ref("");
let dayRange = ref([
    {
        key: 2,
        value: usePage().props.language.original.label.week_day.Mon,
    },
    {
        key: 3,
        value: usePage().props.language.original.label.week_day.Tue,
    },
    {
        key: 4,
        value: usePage().props.language.original.label.week_day.Wed,
    },
    {
        key: 5,
        value: usePage().props.language.original.label.week_day.Thu,
    },
    {
        key: 6,
        value: usePage().props.language.original.label.week_day.Fri,
    },
    {
        key: 7,
        value: usePage().props.language.original.label.week_day.Sat,
    },
    {
        key: 8,
        value: usePage().props.language.original.label.week_day.Sun,
    },
]);

const handleSearch = () => {
    return props.lessons.filter((item) =>
        item.title.toLowerCase().includes(inputSearch.value.toLowerCase())
    );
};

function convertH2M(start, end) {
    return Number(start) * 60 + Number(end);
}

const imageUrlAlt = (event) => {
    return (event.target.src = "https://placehold.co/600x400");
};
const snapGridLengthChange = (swiper) => {
    console.log("swiper.snapGrid.length", swiper.snapGrid.length);
};

const onReachEnd = (swiper) => {
    if (swiper.snapGrid.length != swiper.slidesGrid.length) {
        swiper.snapGrid = swiper.slidesGrid.slice(0);
    }
};

const formatPrice = (value) => {
    let val = (value / 1).toFixed(0).replace(".", ",");
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};
const toggleSearch = () => {
    isSearchVisible.value = !isSearchVisible.value;
};
const dayItem = computed(() =>
    dayRange.value.filter((item) =>
        props.dataSearch.day.includes(item.key.toString())
    )
);

const startPrice = computed(() =>
    props.dataSearch.start_draft_price
        ? formatPrice(props.dataSearch.start_draft_price)
        : usePage().props.language.original.label.searchResult.price_default
);
const finishPrice = computed(() =>
    props.dataSearch.finish_draft_price
        ? formatPrice(props.dataSearch.finish_draft_price)
        : usePage().props.language.original.label.searchResult.price_default
);

const rating = props.lessons.map((lesson) => {
    const averageRate = lessonRating(lesson);
    return averageRate
});

const ratingSuggest = props.listSuggest.map((lesson) => {
    const averageRate = lessonRating(lesson);
    return averageRate
});
</script>
<template>
    <Layout>
        <main class="searchResult">
            <div class="container">
                <div class="header">
                    <div class="header__wrap">
                        <button class="buttonImage">
                            <img src="/img/icon/arrownLeft.svg" alt="" />
                        </button>
                        <h2>{{ lang().label.searchResult.title }}</h2>
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
                <div class="keyword">
                    <div class="keyword__wrap">
                        <div v-if="lessons.length > 0" class="result-quantity">
                            <span>
                                約 {{ lessons.length }}件
                            </span>
                        </div>
                        <swiper
                            class="swiper"
                            :modules="modules"
                            :space-between="10"
                            :slides-per-view="auto"
                            :free-mode="true"
                            :centered-slides="true"
                            :centered-slides-bounds="true"
                        >
                            <swiper-slide>
                                <div class="keyword__text-wrapper">
                                    <p class="keyword-text">
                                        {{
                                            dataSearch["keyword"] ||
                                            lang().label.searchResult.keyword_default
                                        }}
                                    </p>
                                </div>
                            </swiper-slide>
                            <swiper-slide class="slide filter__wrapper user">
                                <i class="filter__icon"
                                    ><img src="/img/icon/userGray.svg" alt=""
                                /></i>
                                <div class="header-category_item_title">
                                    {{ dataSearch["min_age"] || lang().label.searchResult.age_default }} ~
                                    {{ dataSearch["max_age"] || lang().label.searchResult.age_default }}
                                </div>
                            </swiper-slide>
                            <swiper-slide class="slide filter__wrapper price">
                                <i class="filter__icon"
                                    ><img src="/img/icon/Walet.svg" alt=""
                                /></i>
                                <div class="header-category_item_title">
                                    {{ startPrice }}
                                    ~
                                    {{ finishPrice }}
                                    {{
                                        dataSearch["start_draft_price"] &&
                                        dataSearch["finish_draft_price"]
                                            ? "円"
                                            : ""
                                    }}
                                </div>
                            </swiper-slide>
                            <swiper-slide class="slide filter__wrapper date">
                                <i class="filter__icon"
                                    ><img src="/img/icon/Calender.svg" alt=""
                                /></i>
                                <div class="header-category_item_title">
                                    {{ dataSearch["start_date"] || lang().label.searchResult.date_default }}
                                    ~
                                    {{ dataSearch["end_date"] || lang().label.searchResult.date_default }}
                                </div>
                            </swiper-slide>
                            <swiper-slide
                                v-if="dataSearch['day']"
                                class="slide filter__wrapper"
                            >
                                <i class="filter__icon"
                                    ><img src="/img/icon/Calender.svg" alt=""
                                /></i>
                                <div class="header-category_item_title">
                                    <span
                                        v-for="item in dayItem"
                                        :key="item.key"
                                        class="day-text"
                                    >
                                        {{ item.value }}
                                    </span>
                                </div>
                            </swiper-slide>
                            <swiper-slide v-else class="slide filter__wrapper">
                                <i class="filter__icon"
                                    ><img src="/img/icon/Calender.svg" alt=""
                                /></i>
                                <div class="header-category_item_title">
                                    <span class="day-text"> 指定なし </span>
                                </div>
                            </swiper-slide>
                            <swiper-slide class="slide filter__wrapper">
                                <i class="filter__icon"
                                    ><img src="/img/icon/Clock.svg" alt=""
                                /></i>
                                <div class="header-category_item_title">
                                    {{ dataSearch["start_time"] || "指定なし" }}
                                    ~
                                    {{ dataSearch["end_time"] || "指定なし" }}
                                </div>
                            </swiper-slide>
                        </swiper>
                    </div>
                </div>
                <div class="line__wrapper">
                    <div class="lineFull"></div>
                </div>
                <div v-if="lessons.length > 0" class="result">
                    <Link
                        v-for="(lesson, index) in lessons"
                        :key="index"
                        :href="route('lesson.detail', lesson.id)"
                        class="item"
                    >
                        <div class="item__top">
                            <div class="image">
                                <img :src="lesson.cover_image" alt="" />
                            </div>
                            <div class="result__title-wrapper">
                                <h2 class="result__title-text">
                                    {{ lesson.title }}
                                </h2>
                            </div>
                        </div>
                        <div class="item__bottom">
                            <div class="author">
                                <div class="author__left">
                                    <div class="avatar">
                                        <img
                                            src="/img/icon/avatar.png"
                                            alt=""
                                        />
                                    </div>
                                    <p>Doraemon</p>
                                </div>
                            </div>
                            <div class="result__description-wrapper">
                                <p class="result__description">
                                    {{ lesson.description }}
                                </p>
                            </div>
                            <ul class="search__result-lesson-info">
                                <li class="result__info-box">
                                    <div class="star">
                                        <div class="result__info-top">
                                            <img
                                                src="/img//icon/star.svg"
                                                alt=""
                                            />
                                            <div class="result__rating-text">
                                                <span class="star-ranking"
                                                    >{{ rating[index].toFixed(1) }}</span
                                                >
                                                <span class="quantity-vote">
                                                    ({{ lesson.review?.length }})</span
                                                >
                                            </div>
                                        </div>
                                        <p>{{ lang().label.searchResult.review }}</p>
                                    </div>
                                </li>
                                <li class="result__info-box">
                                    <div class="star">
                                        <div class="result__info-top">
                                            <p>
                                                <span
                                                    >¥
                                                    {{
                                                        formatPrice(
                                                            lesson.price
                                                        )
                                                    }}</span
                                                >
                                            </p>
                                        </div>
                                        <p>{{ lang().label.searchResult.price }}</p>
                                    </div>
                                </li>
                                <li class="result__info-box">
                                    <div class="star">
                                        <div class="result__info-top">
                                            <p>
                                                <span
                                                    >{{
                                                        lesson.target_age_from
                                                    }}~{{
                                                        lesson.target_age_to
                                                    }}</span
                                                >
                                            </p>
                                        </div>
                                        <p>{{ lang().label.searchResult.ages }}</p>
                                    </div>
                                </li>
                                <li class="result__info-box">
                                    <div class="star">
                                        <div class="result__info-top">
                                            <p style="display: flex; text-align: center;">
                                                <span>
                                                    {{ lesson.start_date
                                                    }}<br />
                                                    {{
                                                        lesson.course[0]
                                                            ? lesson.course[0]
                                                                  .start_time
                                                            : ""
                                                    }}
                                                    {{
                                                        lesson.course[0]
                                                            ? "~"
                                                            : ""
                                                    }}
                                                    {{
                                                        lesson.course[0]
                                                            ? lesson.course[0]
                                                                  .end_time
                                                            : ""
                                                    }}
                                                </span>
                                            </p>
                                        </div>
                                        <p>{{ lang().label.searchResult.date }}</p>
                                    </div>
                                </li>
                                <li class="result__info-box">
                                    <div class="star">
                                        <div class="result__info-top">
                                            <p>
                                                <span
                                                    >{{
                                                        convertH2M(
                                                            lesson.lesson_hour,
                                                            lesson.lesson_minute
                                                        )
                                                    }}
                                                    min</span
                                                >
                                            </p>
                                        </div>
                                        <p>{{ lang().label.searchResult.time }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </Link>
                </div>
                <div v-if="lessons.length < 1" class="noData">
                    <div class="top">
                        <div class="noData__img-wrapper">
                            <img src="img/icon/tree.svg" alt="" />
                        </div>
                        <div class="noData__title-wrapper">
                            <h2>No results found</h2>
                        </div>
                        <p class="noData__desc-text">
                            あいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえおあいうえお
                        </p>
                    </div>
                    <div class="bottom">
                        <h2 class="suggest__title-text">
                            {{ lang().label.searchResult.similar_content }}
                        </h2>
                        <div class="topScreen">
                            <div class="topScreen__wrap">
                                <Link
                                    v-for="(lesson, index) in listSuggest"
                                    :key="index"
                                    class="item"
                                    :href="route('lesson.detail', lesson.id)"
                                >
                                    <div class="image">
                                        <img
                                            :src="lesson.cover_image"
                                            alt="lesson"
                                            @error="imageUrlAlt"
                                        />
                                    </div>
                                    <div class="rating">
                                        <Stars :stars="ratingSuggest[index]" />
                                        <span class="count">{{ ratingSuggest[index].toFixed(1) }} ({{ lesson.review?.length }})</span>
                                    </div>
                                    <div class="title">
                                        <h2>
                                            {{ lesson.title }}
                                        </h2>
                                    </div>
                                    <div class="description">
                                        <p>Doraemon</p>
                                    </div>
                                    <div class="price">¥{{ lesson.price }}</div>
                                    <div class="age">
                                        <p>
                                            Ages {{ lesson.target_age_from }}-{{
                                                lesson.target_age_to
                                            }}
                                        </p>
                                    </div>
                                    <div class="lesson-time">
                                        {{
                                            lesson.lesson_hour
                                                ? lesson.lesson_hour + "h "
                                                : ""
                                        }}{{ lesson.lesson_minute }}m
                                    </div>
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
@import "../../css/_top.scss";
@import "../../../public/scss/imports/core/mixins";
@import "../../../public/scss/imports/core/variables";

.keyword {
    display: flex;
    justify-content: center;
    position: relative;
    &__wrap {
        // width: 520px;
        height: 54px;
        display: flex;
        align-items: center;
        p {
            font-size: $fz-text-m;
        }
        .swiper {
            width: 100%;
        }
        .swiper-slide {
            width: auto !important;
        }
        .slide {
            display: flex;
            border: 1px solid #b1b1b1;
            border-radius: 100px;
            padding: 7.5px 10px 7.5px 12px;
            height: 34px;
            align-items: center;
            box-sizing: border-box;

            i {
                margin-right: 6px;
            }

            .header-category_item_title {
                font-size: 12px;
                font-weight: 400;
                line-height: 19px;
                letter-spacing: -0.01em;
                color: #4d4d4d;
            }

            & + & {
                margin-top: 10px;
            }
        }
        @include mobile {
            width: 100%;
        }
    }

    @include mobile {
        margin-right: -16px;
    }
}
.result {
    padding-top: 24px !important;

    @include mobile {
        padding-top: 16px !important;
    }
    .item {
        cursor: pointer;
        position: relative;
    }
}
.item__top {
    h2 {
        @include mobile {
            padding-top: 11px !important;
        }
    }
}
.search__result-lesson-info {
    width: 100%;
}

.rating {
    display: flex;
    align-items: center;
    gap: 2px;
}

.filter__icon {
    display: flex;
    align-items: center;
}
.keyword__text-wrapper {
    display: flex;
    align-items: center;
    height: 34px;
}
.keyword-text {
    font-size: 12px;
    font-weight: 400;
    line-height: 19px;
    letter-spacing: -0.01em;
    color: #4d4d4d;
}
.day-text {
    font-size: 12px;
    font-weight: 400;
    line-height: 19px;
    letter-spacing: -0.01em;

    & + & {
        margin-left: 6px;
    }
}

.line__wrapper {
    position: relative;
}

.result__description-wrapper {
    height: calc(19px * 4);
}
.result__description {
    font-size: 12px;
    font-weight: 400;
    line-height: 19px;
    letter-spacing: -0.01em;
    color: #989898;
    margin-bottom: 20px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 4; /* Số dòng tối đa hiển thị */
    overflow: hidden;

    @include mobile {
        margin-bottom: unset;
    }
}

.noData__img-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 194px;
    background-color: #f4f4f4;
    border-radius: 10px;
    margin-top: 24px;
    margin-bottom: 16px;

    @include mobile {
        margin-top: 16px;
    }
}

.noData__title-wrapper {
    display: flex;
    align-items: center;
    height: 26px;
    font-size: 16px;
    font-weight: 700;
    line-height: 26px;
    letter-spacing: -0.01em;
    text-align: center;
}

.noData__desc-text {
    margin-bottom: 32px;
}

.suggest__title-text {
    @include mobile {
        padding-top: 32px !important;
    }
}

.result__title-wrapper {
    flex-grow: 1;
    display: flex;
    align-items: center;
    padding-left: 10px;

    .result__title-text {
        padding: unset !important;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;

        @include mobile {
            -webkit-line-clamp: 4;
        }
    }
}

.result__info-box {
    padding-bottom: 5.5px;
    align-items: end !important;

    .result__info-top {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 38px;
        font-size: 12px;
        font-weight: 700;
        line-height: 19px;
        letter-spacing: -0.01em;
        color: #418997;
    }
}

.result__rating-text {
    display: flex;
    align-items: center;

    .quantity-vote {
        margin-left: 3px;
        font-weight: 400 !important;
        color: #000;
    }
}

.result-quantity {
    display: flex;
    align-items: center;
    margin-right: 10px;

    span {
        color: #4D4D4D;
        font-family: Noto Sans JP;
        font-size: 12px;
        font-style: normal;
        font-weight: 400;
        line-height: 160%; /* 19.2px */
        letter-spacing: -0.12px;
        white-space: nowrap; /* Ngăn text xuống dòng */
        max-width: 100%;
    }
}
</style>
