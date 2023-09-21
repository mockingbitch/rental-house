<script setup>
import { Link } from '@inertiajs/vue3';
import PError from '@/Components/PError.vue';
import LayoutSignin from '../../Layouts/LayoutSignin.vue';

defineProps({
    message: String
})
</script>

<template>
    <LayoutSignin>
        <div class="container">
            <div class="signin">
                <div class="signin__wrap">
                    <img src="img/signin.jpg" alt="signin" class="signin__wrap-banner">
                    <div class="signin__wrap-content">
                        <p class="title">{{ lang().label.register_method.title }}</p>
                        <p class="sub-title">{{ lang().label.register_method.for_users }}<br />
                            {{ lang().label.register_method.brief_greeting }}
                        </p>
                        <Link class="mainButton bg-green" :href="route('register')">
                            <i><img src="img/icon/email.svg" alt="email"></i>
                            <p>{{ lang().label.register_method.registration_email }}</p>
                        </Link>
                        <Link class="mainButton" :href="route('login.google')">
                            <i><img src="img/icon/google.svg" alt="google"></i>
                            <p>{{ lang().label.register_method.registration_google }}</p>
                        </Link>
                        <PError :message="message" />
                        <div class="line"></div>
                        <span class="textLink">
                            {{ lang().label.register_method.or }}
                            <Link :href="route('login.method')">
                                {{ lang().label.register_method.login_here }}
                            </Link>
                        </span>
                        
                    </div>
                </div>
            </div>
        </div>
    </LayoutSignin>
</template>