<script setup>
import { defineProps } from "vue";
import moment from "moment";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    notifications: Array,
});

const form = useForm({
    notification: null,
})

const handleClickNotification = (noti) => {
    form.notification = noti;
    form.get(route('notification.detail'))
}

</script>
<template>
    <div
        class="notification__container d-flex flex-column"
    >
        <div
            @click="handleClickNotification(noti)"
            class="notification__container-card d-flex"
            v-for="(noti, index) in props.notifications"
            :key="index"
            :style="{
                backgroundColor: noti?.read_at === null ? '#F4F4F4' : '#FFF',
                border: noti?.read_at === null ? '' : '1px solid #F4F4F4',
            }"
            v-if="props.notifications?.length !== 0"
        >
            <div class="noti__logo d-flex align-items-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                >
                    <path
                        d="M17.3281 13.7453C16.8945 12.9984 16.25 10.8852 16.25 8.125C16.25 6.4674 15.5915 4.87769 14.4194 3.70558C13.2473 2.53348 11.6576 1.875 10 1.875C8.34241 1.875 6.7527 2.53348 5.58059 3.70558C4.40849 4.87769 3.75001 6.4674 3.75001 8.125C3.75001 10.8859 3.1047 12.9984 2.6711 13.7453C2.56038 13.9352 2.50168 14.1509 2.50092 14.3707C2.50017 14.5905 2.55739 14.8066 2.66681 14.9973C2.77623 15.1879 2.93398 15.3463 3.12415 15.4565C3.31433 15.5667 3.53021 15.6248 3.75001 15.625H6.93829C7.08249 16.3306 7.46597 16.9647 8.02386 17.4201C8.58176 17.8756 9.27983 18.1243 10 18.1243C10.7202 18.1243 11.4183 17.8756 11.9762 17.4201C12.5341 16.9647 12.9175 16.3306 13.0617 15.625H16.25C16.4697 15.6247 16.6855 15.5665 16.8756 15.4562C17.0657 15.346 17.2233 15.1875 17.3326 14.9969C17.442 14.8063 17.4991 14.5903 17.4983 14.3705C17.4975 14.1508 17.4388 13.9351 17.3281 13.7453ZM10 16.875C9.61237 16.8749 9.23429 16.7546 8.91782 16.5308C8.60135 16.3069 8.36204 15.9905 8.23282 15.625H11.7672C11.638 15.9905 11.3987 16.3069 11.0822 16.5308C10.7657 16.7546 10.3877 16.8749 10 16.875ZM3.75001 14.375C4.35157 13.3406 5.00001 10.9438 5.00001 8.125C5.00001 6.79892 5.52679 5.52715 6.46448 4.58947C7.40216 3.65178 8.67393 3.125 10 3.125C11.3261 3.125 12.5979 3.65178 13.5355 4.58947C14.4732 5.52715 15 6.79892 15 8.125C15 10.9414 15.6469 13.3383 16.25 14.375H3.75001Z"
                        fill="#343330"
                    />
                </svg>
            </div>
            <div class="noti__content d-flex flex-column">
                <div class="noti__content-date d-flex">
                    <div class="date-time d-flex align-items-center">
                        {{ moment(noti?.created_at).format('YYYY/MM/DD') }}
                    </div>
                    <div
                        class="status-noti d-flex align-items-center"
                        v-if="noti?.read_at === null"
                    >
					{{ lang().label.notification.flag_new }}
                    </div>
                </div>
                <div class="noti__content-title">
                    {{ noti?.data?.title }}
                </div>
            </div>
        </div>
        <div v-else>
            <div class="notification__container-no-result d-flex flex-column">
                <div class="no__result-title d-flex justify-content-center">
                    {{ lang().label.notification.no_result }}
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "../Notification/Notification";
</style>
