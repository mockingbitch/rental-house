<script setup>
import LayoutSignin from '@/Layouts/LayoutSignin.vue';
</script>

<template>
    <LayoutSignin>
        <div class="container">
            <div class="signin">
                <div class="signin__wrap">
                    <img src="/img/signin.jpg" alt="signin" class="signin__wrap-banner">
                    <div class="signin__wrap-content">
                        <h2 class="title">{{ lang().label.user.update.setup_success }}</h2>
                        <div class="line"></div>
                        <span class="textLink a-black">
                            {{ lang().label.user.update.contact_us }}
                            <a>{{ lang().label.user.update.here }}</a>
                        </span>
                        <span class="subText">
                            {{ lang().label.user.update.copy_right }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </LayoutSignin>
</template>
