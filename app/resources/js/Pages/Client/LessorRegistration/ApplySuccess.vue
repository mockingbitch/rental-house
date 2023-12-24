<script setup>
import { Link } from "@inertiajs/vue3";
import { defineEmits, defineProps } from "vue";
import Layout from "@/Layouts/Layout.vue";

const props = defineProps({
    dataStep3: Object,
});
const emits = defineEmits();

const handleBackToDashboard = () => {
    emits("back-to-dashboard");
};
</script>

<template>
    <Layout :isSuccess="true">
        <div class="step-container d-flex flex-column mt-2">
            <div class="form__wrap-item image-sucess-apply">
                <!-- <img src="../../../../public/img/icon/applySucess.svg" alt="" /> -->
            </div>
            <div class="form__wrap-item">
                <div class="title d-flex justify-content-center">
                    (Tentative) Application has been completed!！
                </div>
                <div
                    class="content d-flex flex-column justify-content-center align-items-center"
                >
                    <span>Apply success fully</span>
                    <span>Please check your information!</span>
                    <span>Thank for your registration</span>
                </div>
            </div>
            <div
                class="form__wrap-item button-dashboard-container d-flex justify-content-center align-items-center"
            >
                <div
                    class="button-return button-dash-board d-flex justify-content-center align-items-center"
                    @click="handleBackToDashboard"
                >
                    Dashboard
                </div>
            </div>
            <div
                class="form__wrap-item d-flex justify-content-center align-items-center"
            >
                <Link :href="route('top')">
                    <div
                        class="button-return button-top d-flex flex-column justify-content-center align-items-center"
                    >
                        Back to Top
                    </div>
                </Link>
            </div>
        </div>
    </Layout>
</template>

<style lang="scss" scoped>
@import "./resultstep";
@import "./applysuccess";
</style>
