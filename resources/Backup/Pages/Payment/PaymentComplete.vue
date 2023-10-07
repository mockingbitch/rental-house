<script setup>
import { ref, onMounted } from "vue";
import { router, Link } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";

const props = defineProps({
    scheduleId: String,
    clientSecret: String,
    publicKey: String,
});

</script>

<template>
    <Layout>
        <div class="container">
            <div class="signin">
                <div class="signin__wrap">
                    <img src="/img/signin.jpg" alt="signin">
                    <div class="signin__wrap-content">
                        <h2 class="title">支払い成功</h2>
                        <ul class="content">
                            <li>私たちのコースにお申し込みいただきありがとうございます。</li>
                            <!-- <li>{{ lang().label.information.completed.guide_to_teacher }}</li>
                            <li>{{ lang().label.information.completed.alternatively }}</li> -->
                        </ul>
                        <div class="line"></div>
                        <Link class="mainButton bg-green"
                            :href="route('top')"
                        >
                            <p>ホームページに戻ります</p>
                        </Link>
                        <!-- <Link class="mainButton" :href="route('top')">
                            <p>{{ lang().label.information.completed.go_to_dashboard }}</p>
                        </Link> -->
                        <div class="line"></div>
                        <button class="mainButton" disabled :style="{ opacity: 0.5, cursor: 'default' }">
                            <p>{{ lang().label.information.completed.go_to_top_page }}</p>
                        </button>
                        <span class="subText">{{ lang().label.information.completed.contact_us }}</span>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>