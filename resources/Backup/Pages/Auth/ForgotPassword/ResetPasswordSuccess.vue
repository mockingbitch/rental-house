<script setup>
import { Link } from '@inertiajs/vue3';
import LayoutSignin from '../../../Layouts/LayoutSignin.vue';

defineProps({
})
</script>

<template>
    <LayoutSignin>
        <div class="container">
            <div class="signin">
                <div class="signin__wrap">
                    <div class="signin__wrap-content">
                        <h2 class="title">{{ lang().label.reset_password_success.reset_password }}</h2>
                        <ul class="content">
                            <li>{{ lang().label.reset_password_success.password_has_been_reset }}</li>
                            <li>{{ lang().label.reset_password_success.we_hope }}</li>
                        </ul>
                        <div class="line"></div>
                        <Link class="mainButton bg-green" :href="route('login')">
                            <p>{{ lang().label.reset_password_success.return_login }}</p>
                        </Link>
                        <Link class="mainButton text-green-coral border-black" :href="route('top')">
                            <p>{{ lang().label.reset_password_success.return_top }}</p>
                        </Link>
                        <span class="textLink a-black">
                            {{ lang().label.reset_password_success.contact_us }}
                            <a>{{ lang().label.reset_password_success.here }}</a>
                        </span>
                        <span class="subText">
                            {{ lang().label.reset_password_success.copy_right }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </LayoutSignin>
</template>