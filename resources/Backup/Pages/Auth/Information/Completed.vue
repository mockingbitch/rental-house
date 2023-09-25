<script setup>
import { Link } from '@inertiajs/vue3';
import Layout from '../../../Layouts/Layout.vue'

defineProps({
    email: String,
    ziggy: Array,
    token: String,
});
</script>

<template>
    <Layout>
        <div class="container">
            <div class="signin">
                <div class="signin__wrap">
                    <img src="/img/sign_in_success.png" alt="signin" class="signin__wrap-banner">
                    <div class="signin__wrap-content">
                        <h2 class="title">{{ lang().label.information.completed.title }}</h2>
                        <ul class="content">
                            <li>{{ lang().label.information.completed.thank_you }}</li>
                            <li>{{ lang().label.information.completed.guide_to_teacher }}</li>
                            <li>{{ lang().label.information.completed.alternatively }}</li>
                        </ul>
                        <!-- <div class="line"></div> -->
                        <Link class="mainButton bg-green"
                            :href="route('top')"
                        >
                        <p>{{ lang().label.information.completed.go_to_top_page }}</p>
                        </Link>
                        <Link class="mainButton" 
                            :href="route('onboarding.index')"
                        >
                            <p>{{ lang().label.information.completed.register_teacher }}</p>
                        </Link>
                        <!-- <div class="line"></div>
                        <button class="mainButton" disabled :style="{ opacity: 0.5, cursor: 'default' }">
                            <p>{{ lang().label.information.completed.go_to_top_page }}</p>
                        </button>
                        <span class="subText">{{ lang().label.information.completed.contact_us }}</span> -->
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>