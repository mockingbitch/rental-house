<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import Category from "@/Components/Category/Category.vue";
import Banner from "@/Components/Banner/Banner.vue";
import Stars from "@/Components/Rating/Stars.vue";
// import Modal from "@/Components/Modal/Modal.vue";
import { houseRating } from "@/Helper/HouseRating";
import { priceFormat } from "@/Helper/CurrencyHelper";
import { sortArrayByPrice, sortArrayByCapacity } from "@/Helper/SortHelper";

const props = defineProps({
    houses: Array,
});

const showModal = ref(false);
const listHouse = ref(props.houses);

const handleSearch = (category) => {
    if (category) {
        listHouse.value = props.houses.filter(
            (item) => item.category_id === category.id
        );
    } else {
        listHouse.value = props.houses;
    }
};

const imageUrlAlt = (event) => {
    return (event.target.src = "https://placehold.co/600x400");
};
</script>

<template>
    <Layout>
        <div class="container">
            <Category @handleFilterCategory="handleSearch" />
            <Banner />
        </div>
        <div class="topScreen">
            <div class="container">
                <div class="topScreen__wrap">
                    <Link
                        v-for="(house, index) in listHouse"
                        :key="index"
                        class="item"
                    >
                        <div class="image">
                            <img
                                :src="house.thumbnail"
                                alt="house"
                                @error="imageUrlAlt"
                            />
                        </div>
                        <div class="rating">
                            <Stars :stars="houseRating(house).toFixed(1)" />
                            <span class="count">
                                {{ houseRating(house).toFixed(1) }}
                            </span>
                        </div>
                        <div class="title">
                            <h2>
                                {{ house.name }}
                            </h2>
                        </div>
                        <div class="description d-flex">
                            <div class="lessor_avatar">
                                <img
                                    :src="
                                        house.lessor?.avatar
                                        || '/img/icon/iconAvatarDefault.svg'
                                    "
                                    @error="imageUrlAlt"
                                    alt="house"
                                />
                            </div>
                            <p>
                                {{
                                    house.lessor?.first_name
                                    + " " +
                                    house.lessor?.last_name
                                }}
                            </p>
                        </div>
                        <div v-if="house.rooms[0]" class="price">
                            {{ priceFormat(sortArrayByPrice(house.rooms)[0]?.price) }}
                            -
                            {{ priceFormat(sortArrayByPrice(house.rooms)[house.rooms.length - 1]?.price) }}
                            VND
                        </div>
                        <div v-if="house.rooms[0]" class="age">
                            <p>
                                {{ lang().label.top.capacity }}:
                                {{ sortArrayByCapacity(house.rooms)[0]?.capacity }}
                                -
                                {{ sortArrayByCapacity(house.rooms)[house.rooms.length - 1]?.capacity }}
                            </p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style lang='scss' scoped>
@import './top';
</style>
