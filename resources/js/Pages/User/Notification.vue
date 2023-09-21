<script setup>
import { defineProps, ref } from "vue";
import Notification from "../../Components/Notification/Notification.vue";
import Layout from "@/Layouts/Layout.vue";

const props = defineProps({
    notifications: Array,
    user: Object,
});
let notifications = ref(
    props.notifications
    ? Object.keys(props.notifications).map((key) => props.notifications[key])
    : []
    );
window.Echo.private(`User.${props.user?.id}`)
    .notification((notification) => {
        window.axios.get(route('api.get.notification', { id: notification.id }))
            .then(response => {
                notifications.value.push(response.data.notification);
            })
            .catch(e => console.log(e));
    });
</script>
<template>
    <Layout>
        <Notification :notifications="notifications" />
    </Layout>
</template>
