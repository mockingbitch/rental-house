<script setup>
import { Link } from '@inertiajs/vue3';
import LayoutSignin from '../../Layouts/LayoutSignin.vue';
</script>

<template>
    <LayoutSignin>
        <div class="container">
            <div class="signin">
                <div class="signin__wrap">
                    <img src="img/smile.jpg" alt="signin" class="signin__wrap-banner">
                    <div class="signin__wrap-content">
                        <h2 class="title">{{ lang().label.login_method.login }}</h2>
                        <!-- <ul class="content">
                            <li>{{ lang().label.login_method.for_user }}</li>
                            <li>{{ lang().label.login_method.brief_greeting }}</li>
                        </ul> -->
                        <Link class="mainButton bg-green mt-0" :href="route('login')">
                            <i><img src="img/icon/email.svg" alt="email"></i>
                            <p>{{ lang().label.login_method.login_with_email }}</p>
                        </Link>
                        <Link class="mainButton" :href="route('login.google')">
                            <i><img src="img/icon/google.svg" alt="google"></i>
                            <p>{{ lang().label.login_method.login_with_google }}</p>
                        </Link>
                        <span class="textLink">
                            {{ lang().label.login_method.forgot_password }}
                            <Link :href="route('forgot.password')">
                                {{ lang().label.login_method.here }}
                            </Link>
                        </span>
                        <div class="line"></div>
                        <div class="buttonTitle">
                            <p>{{ lang().label.login_method.dont_have_account }}</p>
                            <Link class="mainButton" :href="route('register.method')">
                                <p>{{ lang().label.login_method.new_registration }}</p>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutSignin>
</template>
