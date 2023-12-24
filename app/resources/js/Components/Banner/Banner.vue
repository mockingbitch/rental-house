<template>
    <div class="banner">
        <div class="carousel hidden" ref="carousel" touch-action="pan-y">
            <div
                class="carousel-cell"
                v-for="banner in banners"
                :key="banner.id"
            >
                <a href="#">
                    <img
                        :src="banner.image"
                        :alt="banner.name"
                        @load="imageLoaded"
                    />
                </a>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Flickity from "flickity";

export default defineComponent({
    name: "SwiperExampleFreeMode",
    title: "Free mode / no fixed positions",
    components: {
        // eslint-disable-next-line vue/no-unused-components
        Flickity,
    },
    data() {
        return {
            numberOfBanner: 0,
            banners: [
                {
                    id: 0,
                    name: "banner-1",
                    image: "/img/banner/banner-1.jpeg",
                },
                {
                    id: 1,
                    name: "banner-2",
                    image: "/img/banner/homestay.jpeg",
                },
                {
                    id: 2,
                    name: "banner-3",
                    image: "/img/banner/homestay1.png",
                },
                {
                    id: 3,
                    name: "banner-4",
                    image: "/img/banner/homestay2.png",
                },
                {
                    id: 4,
                    name: "banner-5",
                    image: "/img/banner/homestay3.png",
                },
                {
                    id: 5,
                    name: "banner-6",
                    image: "/img/banner/homestay.jpeg",
                },
                {
                    id: 6,
                    name: "banner-6",
                    image: "/img/banner/homestay2.png",
                },
                {
                    id: 7,
                    name: "banner-6",
                    image: "/img/banner/homestay3.png",
                },
            ],
            imagesLoaded: 0,
            flickityOptions: {
                cellAlign: "left",
                freeScroll: true,
                prevNextButtons: false,
                contain: true,
                groupCells: 2,
                passive: false,
            },
        };
    },
    methods: {
        imageLoaded() {
            this.imagesLoaded++;
            if (this.imagesLoaded === this.banners.length) {
                this.initFlickity();
                this.$refs.carousel.classList.remove("hidden");
            }
        },
        initFlickity() {
            this.$nextTick(() => {
                this.carousel = new Flickity(
                    this.$refs.carousel,
                    this.flickityOptions
                );
            });
        },
    },
    beforeDestroy() {
        if (this.carousel) {
            this.carousel.destroy();
        }
    },
});
</script>

<style lang="scss" scoped>
@import "./banner";
</style>
