<script setup>

import { useForm } from '@inertiajs/vue3';
import UlError from '@/Components/UlError.vue';
import PError from '@/Components/PError.vue';
import LayoutSignin from '../../../Layouts/LayoutSignin.vue';

const form = useForm({
    email: '',
})

const submit = () => {
    form.post(route('forgot.password'))
}

defineProps({

});
</script>

<template>
    <LayoutSignin>
        <div class="signin2">
            <div class="container">
                <form class="form" @submit.prevent="submit">
                    <div class="form__wrap form__wrap-password">
                        <h2 class="title form__wrap-password-title">
                            {{ lang().label.forgot_password.reset_password }}
                        </h2>
                        <ul class="content">
                            <li>{{ lang().label.forgot_password.please_enter_email }}</li>
                            <li>{{ lang().label.forgot_password.we_will_send_url }}</li>
                        </ul>
                        <div class="form__wrap-item" :class="{ error: form.errors.email }">
                            <label for="Email">{{ lang().label.user.field.email }}</label>
                            <input type="text" v-model="form.email" name="email" :placeholder="lang().label.user.field.email">
                            <UlError :message="form.errors.email" />
                        </div>
                        <PError :message="form.errors.error_message" />
                        <button type="submit" class="mainButton bg-green mt-0 form__wrap-password-btn">
                            <p>{{ lang().label.forgot_password.button }}</p>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutSignin>
</template>
