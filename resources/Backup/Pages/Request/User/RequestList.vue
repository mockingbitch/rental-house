<script setup>
import { ref } from "vue";
import Layout from "../../../Layouts/Layout.vue";
import Requested from "../../../Components/Request/Requested.vue";
import ListRequest from "../../../Components/Request/ListRequest.vue";
import RequestHeader from "../../../Components/Request/RequestHeader.vue";
import RequestLessonButton from "../../../Components/Request/RequestLessonButton.vue";
import SubHeader from "../../../Components/Common/SubHeader.vue";

const props = defineProps({
    requests: Array,
    listRequest: Array,
    isLoggedIn: Boolean,
});

const show = ref(true);
const changeTab = () => {
    show.value = !show.value;
};
</script>
<template>
    <Layout>
        <SubHeader show-logo-sp hide-btn hide-on-pc />
        <div class="user__request-container">
            <RequestHeader :is-user="true" @changeTab="changeTab" />
            <Requested
                v-if="show"
                :isUser="true"
                :requests="props.requests"
                :isLoggedIn="props.isLoggedIn"
            />
            <ListRequest
                v-if="!show"
                :isUser="true"
                :listRequest="props.listRequest"
                :isLoggedIn="props.isLoggedIn"
            />
            <RequestLessonButton
                :isLoggedIn="props.isLoggedIn"
                :requestedPage="show"
            />
        </div>
    </Layout>
</template>
<style scoped>
.user__request-container {
    padding: 0px;
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
