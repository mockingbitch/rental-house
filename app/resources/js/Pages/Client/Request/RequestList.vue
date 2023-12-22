<script setup>
import { ref } from "vue";
import Layout from "@/Layouts/Layout.vue";
import Requested from "@/Components/Request/Requested.vue";
import ListRequest from "@/Components/Request/ListRequest.vue";
import RequestHeader from "@/Components/Request/RequestHeader.vue";
import RequestButton from "@/Components/Request/RequestButton.vue";
import SubHeader from "@/Components/SubHeader/SubHeader.vue";

const props = defineProps({
    // eslint-disable-next-line vue/require-default-prop
    requests: Array,
    // eslint-disable-next-line vue/require-default-prop
    listRequest: Array,
    isLoggedIn: Boolean,
});

const show = ref(true);
const changeTabRequest = () => {
    show.value = true;
};
const changeTabListRequest = () => {
    show.value = false;
};
</script>
<template>
    <Layout>
        <SubHeader show-logo-sp hide-btn hide-on-pc />
        <div class="user__request-container">
            <RequestHeader
                :is-user="true"
                @changeTabRequest="changeTabRequest"
                @changeTabListRequest="changeTabListRequest"
            />
            <Requested
                v-if="show"
                :is-user="true"
                :requests="props.requests"
                :is-logged-in="props.isLoggedIn"
            />
            <ListRequest
                v-if="!show"
                :is-user="true"
                :list-request="props.listRequest"
                :is-logged-in="props.isLoggedIn"
            />
            <RequestButton
                :is-logged-in="props.isLoggedIn"
                :requested-page="show"
                :requests="props.requests"
                :list-request="props.listRequest"
            />
        </div>
    </Layout>
</template>
<style scoped>
.user__request-container {
    padding: 0;
    max-width: 400px;
    width: 100%;
    margin: 0 auto;
    font-size: 12px;
}
@media all and (max-width: 760px) {
    .user__request-container {
        padding: 0px 16px;
    }
}
</style>
