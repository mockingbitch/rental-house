<script setup>
import { ref } from "vue";
import LayoutDashboard from "@/Layouts/LayoutDashboard.vue";
import EmptyRequest from "../../../Components/Request/EmptyRequest.vue";
import Requested from "../../../Components/Request/Requested.vue";
import ListRequest from "../../../Components/Request/ListRequest.vue";
import RequestHeader from "../../../Components/Request/RequestHeader.vue";

const show = ref(true);
const requestEmpty = false;
const changeTab = () => {
    show.value = !show.value;
};

const props = defineProps({
    list_request: Array,
    user_id: Number,
});

const isApplied = () => {
    let array = []
    for (let i = 0; i < props.list_request.length; i++) {
        for (let j = 0; j < props.list_request[i].applications.length; j++) {
            if (props.list_request[i].applications[j].lesson.teacher_id == props.user_id) {
                array.push(props.list_request[i])
            }
        }
    }

    return array;
}

</script>
<template>
    <LayoutDashboard>
        <div class="teacher__request-container">
            <RequestHeader @changeTab="changeTab" />
            <Requested v-if="show && !requestEmpty" :requests="isApplied()" />
            <ListRequest v-if="!show && !requestEmpty" :listRequest="props.list_request" :userId="user_id"/>
            <EmptyRequest v-if="requestEmpty" :requests="isApplied()" />
        </div>
    </LayoutDashboard>
</template>
<style scoped>
.teacher__request-container {
    padding: 0px;
    max-width: 400px;
    width: 100%;
    margin: 0 auto;
    font-size: 16px;
}
@media all and (max-width: 768px) {
    .teacher__request-container {
        padding: 0px 16px;
    }
}
</style>
