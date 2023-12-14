<template>
    <div class="slides">
        <div class="carousel hidden" ref="carousel" touch-action="pan-y">
            <div
                class="carousel-cell d-flex flex-column"
                v-for="slide in slides"
                :key="slide.id"
            >
                <div class="d-flex justify-content-center">
                    <img
                        :src="slide.image"
                        :alt="slide.name"
                        @load="imageLoaded"
                    />
                </div>
                <div class="carousel-cell-name d-flex justify-content-center">
                    {{ slide.name }}
                </div>
                <div
                    class="carousel-cell-content d-flex justify-content-center"
                >
                    {{ slide.content }}
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Flickity from "flickity";

export default defineComponent({
    name: "swiper-example-free-mode",
    title: "Free mode / no fixed positions",
    components: {
        Flickity,
    },
    data() {
        return {
            numberOfslide: 0,
            slides: [
                {
                    id: 0,
                    name: "Step1",
                    image: "img/icon/ApplyToTeacher/ImageStep1.svg",
                    content: "書類の準備",
                },
                {
                    id: 1,
                    name: "Step2",
                    image: "img/icon/ApplyToTeacher/ImageStep3.svg",
                    content: "証明書の撮影、アップロード",
                },
                {
                    id: 2,
                    name: "Step3",
                    image: "img/icon/ApplyToTeacher/ImageStep1.svg",
                    content: "審査",
                },
                {
                    id: 3,
                    name: "Step4",
                    image: "img/icon/ApplyToTeacher/ImageStep3.svg",
                    content: "審査結果の通知",
                },
            ],
            imagesLoaded: 0,
            flickityOptions: {
                cellAlign: "left",
                freeScroll: true,
                prevNextButtons: true,
                contain: true,
                groupCells: 1,
                passive: false,
            },
        };
    },
    methods: {
        imageLoaded() {
            this.imagesLoaded++;
            if (this.imagesLoaded === this.slides.length) {
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
@import "../BecomeTeacher/slideStep.scss";
</style>
