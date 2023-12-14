<script setup>
import LayoutSignin from '@/Layouts/LayoutSignin.vue';

const props = defineProps({
    email: String
});
</script>

<template>
    <LayoutSignin>
        <div class="container">
            <div class="signin">
                <div class="signin__wrap">
                    <img src="/img/signin.jpg" alt="signin" class="signin__wrap-banner">
                    <div class="signin__wrap-content">
                        <h2 class="title">{{ lang().label.register_success.verify_email }}</h2>
                        <a
                            class="mainButton bg-gray"
                            href="https://mail.google.com"
                            target="_blank"
                        >
                            <p>{{ props.email }}</p>
                        </a>
                        <span class="subText">{{ lang().label.register_success.expires_in }}</span>
                        <ul class="content">
                            <li>{{ lang().label.register_success.registration_not_complete }}</li>
                            <li>{{ lang().label.register_success.click_the_url }}</li>
                            <li>{{ lang().label.register_success.please_authenticate }}</li>
                        </ul>
                        <div class="line"></div>
                        <span class="textLink a-black">
                            {{ lang().label.register_success.contact_us }}
                            <a>{{ lang().label.register_success.here }}</a>
                        </span>
                        <span class="subText">
                            {{ lang().label.register_success.copy_right }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </LayoutSignin>
</template>