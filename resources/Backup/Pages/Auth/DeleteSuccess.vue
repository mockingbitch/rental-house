<template>
    <LayoutNoLogin>
        <div class="deleted-container d-flex flex-column">
            <img src="" alt="" />
            <div class="deleted-title">
                (仮)
                <span class="deleted-title-right"
                    >アカウント削除を完了しました。</span
                >
            </div>
            <div>
                <div>
                    <div>(仮)ご利用ありがとうございました！</div>
                    <div>あいうえおあいうえおあいうえお</div>
                    <div>あいうえおあいうえおあいうえおあいうえお、</div>
                </div>
                <div class="mt-4">あいうえおあいうえお！</div>
            </div>
            <Link :href="route('top')">
                <ButtonRequest
                    :label="'DottreeのTOPページに移動'"
                    :submit-button="true"
                />
            </Link>
        </div>
    </LayoutNoLogin>
</template>
<script setup>
import LayoutNoLogin from '@/Layouts/LayoutNoLogin.vue';
import { Link } from '@inertiajs/vue3';
import ButtonRequest from '@/Components/Request/ButtonRequest.vue';
</script>