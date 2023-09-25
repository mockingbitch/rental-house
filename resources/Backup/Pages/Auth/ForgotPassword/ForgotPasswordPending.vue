<script setup>
import { Link } from '@inertiajs/vue3';
import LayoutSignin from '../../../Layouts/LayoutSignin.vue';

defineProps({
    email: String
})
</script>

<template>
    <LayoutSignin>
        <div class="container">
            <div class="signin">
                <div class="signin__wrap">
                    <div class="signin__wrap-content">
                        <h2 class="title">{{ lang().label.forgot_password_pending.reset_password }}</h2>
                        <a class="mainButton bg-gray form__wrap-password-btn" href="#">
                            <p>{{$page.props.email}}</p>
                        </a>
                        <span class="subText">{{ lang().label.forgot_password_pending.expires_in }}</span>
                        <ul class="content">
                            <li>{{ lang().label.forgot_password_pending.reset_not_complete }}</li>
                            <li>{{ lang().label.forgot_password_pending.click_the_url }}</li>
                            <li>{{ lang().label.forgot_password_pending.please_reset }}</li>
                        </ul>
                        <div class="line"></div>
                        <span class="textLink a-black">
                            {{ lang().label.forgot_password_pending.contact_us }}
                            <a>{{ lang().label.forgot_password_pending.here }}</a>
                        </span>
                        <span class="subText">
                            {{ lang().label.forgot_password_pending.copy_right }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </LayoutSignin>
</template>