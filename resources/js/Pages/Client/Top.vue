<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import Category from "@/Components/Category/Category.vue";
import Banner from "@/Components/Banner/Banner.vue";
import Stars from "@/Components/Rating/Stars.vue";
// import Modal from "@/Components/Modal/Modal.vue";
import { houseRating } from "@/Helper/HouseRating";

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
                        class="item"
                        v-for="(house, index) in listHouse"
                        :key="index"
                    >
                        <div class="image">
                            <img
                                :src="house.thumbnail"
                                @error="imageUrlAlt"
                                alt="house"
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
                        <div class="price">
                            {{ house.rooms[0]?.price }} VND
                        </div>
                        <div class="age">
                            <p>
                                Capacity: {{ house.rooms[0]?.capacity }}
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
