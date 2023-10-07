<template>
    <div
        ref="selectWrapper"
        style="position: relative"
        class="notification-icon d-flex align-items-center"
    >
        <div
            style="cursor: pointer"
            @click="handleShowNotification"
            class="notification-svg d-flex align-items-center"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="32"
                height="32"
                viewBox="0 0 32 32"
                fill="none"
                v-if="!props.isDashBoardTeacher"
            >
                <path
                    d="M27.7255 21.9925C27.0318 20.7975 26.0005 17.4163 26.0005 13C26.0005 10.3478 24.9469 7.8043 23.0716 5.92893C21.1962 4.05357 18.6527 3 16.0005 3C13.3483 3 10.8048 4.05357 8.92944 5.92893C7.05407 7.8043 6.0005 10.3478 6.0005 13C6.0005 17.4175 4.968 20.7975 4.27425 21.9925C4.09709 22.2963 4.00317 22.6415 4.00196 22.9931C4.00076 23.3448 4.09231 23.6906 4.26738 23.9956C4.44245 24.3006 4.69485 24.5541 4.99914 24.7304C5.30342 24.9068 5.64882 24.9997 6.0005 25H11.1018C11.3325 26.1289 11.946 27.1436 12.8387 27.8722C13.7313 28.6009 14.8482 28.9989 16.0005 28.9989C17.1528 28.9989 18.2697 28.6009 19.1623 27.8722C20.055 27.1436 20.6685 26.1289 20.8993 25H26.0005C26.3521 24.9995 26.6973 24.9064 27.0014 24.73C27.3055 24.5535 27.5578 24.3 27.7327 23.9951C27.9076 23.6901 27.9991 23.3444 27.9978 22.9928C27.9965 22.6412 27.9026 22.2962 27.7255 21.9925ZM16.0005 27C15.3803 26.9998 14.7754 26.8074 14.269 26.4492C13.7626 26.0911 13.3797 25.5848 13.173 25H18.828C18.6213 25.5848 18.2384 26.0911 17.732 26.4492C17.2257 26.8074 16.6207 26.9998 16.0005 27ZM6.0005 23C6.963 21.345 8.0005 17.51 8.0005 13C8.0005 10.8783 8.84336 8.84344 10.3436 7.34315C11.8439 5.84285 13.8788 5 16.0005 5C18.1222 5 20.1571 5.84285 21.6574 7.34315C23.1576 8.84344 24.0005 10.8783 24.0005 13C24.0005 17.5063 25.0355 21.3412 26.0005 23H6.0005Z"
                    fill="#1B1B1B"
                />
            </svg>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="32"
                height="32"
                viewBox="0 0 32 32"
                fill="none"
                v-if="props.isDashBoardTeacher"
            >
                <path
                    d="M27.7255 21.9925C27.0318 20.7975 26.0005 17.4163 26.0005 13C26.0005 10.3478 24.9469 7.8043 23.0716 5.92893C21.1962 4.05357 18.6527 3 16.0005 3C13.3483 3 10.8048 4.05357 8.92944 5.92893C7.05407 7.8043 6.0005 10.3478 6.0005 13C6.0005 17.4175 4.968 20.7975 4.27425 21.9925C4.09709 22.2963 4.00317 22.6415 4.00196 22.9931C4.00076 23.3448 4.09231 23.6906 4.26738 23.9956C4.44245 24.3006 4.69485 24.5541 4.99914 24.7304C5.30342 24.9068 5.64882 24.9997 6.0005 25H11.1018C11.3325 26.1289 11.946 27.1436 12.8387 27.8722C13.7313 28.6009 14.8482 28.9989 16.0005 28.9989C17.1528 28.9989 18.2697 28.6009 19.1623 27.8722C20.055 27.1436 20.6685 26.1289 20.8993 25H26.0005C26.3521 24.9995 26.6973 24.9064 27.0014 24.73C27.3055 24.5535 27.5578 24.3 27.7327 23.9951C27.9076 23.6901 27.9991 23.3444 27.9978 22.9928C27.9965 22.6412 27.9026 22.2962 27.7255 21.9925ZM16.0005 27C15.3803 26.9998 14.7754 26.8074 14.269 26.4492C13.7626 26.0911 13.3797 25.5848 13.173 25H18.828C18.6213 25.5848 18.2384 26.0911 17.732 26.4492C17.2257 26.8074 16.6207 26.9998 16.0005 27ZM6.0005 23C6.963 21.345 8.0005 17.51 8.0005 13C8.0005 10.8783 8.84336 8.84344 10.3436 7.34315C11.8439 5.84285 13.8788 5 16.0005 5C18.1222 5 20.1571 5.84285 21.6574 7.34315C23.1576 8.84344 24.0005 10.8783 24.0005 13C24.0005 17.5063 25.0355 21.3412 26.0005 23H6.0005Z"
                    fill="white"
                />
            </svg>
            <p class="new-notification" v-if="unReadNotification !== 0">
                {{ unReadNotification }}
            </p>
        </div>
        <div
            v-if="isShowNotification"
            style="position: absolute"
            class="show-notification"
            @click="handlePopupClick"
        >
            <div
                class="notification-title d-flex justify-content-center align-items-center"
            >
                {{ lang().label.notification.notification_title }}
                <div class="close-popup" @click="handleShowNotification">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="22"
                        height="22"
                        viewBox="0 0 22 22"
                        fill="none"
                    >
                        <path
                            d="M17.6743 16.701C17.7382 16.7649 17.7888 16.8407 17.8234 16.9242C17.858 17.0076 17.8758 17.0971 17.8758 17.1874C17.8758 17.2777 17.858 17.3672 17.8234 17.4506C17.7888 17.5341 17.7382 17.6099 17.6743 17.6738C17.6104 17.7377 17.5346 17.7883 17.4511 17.8229C17.3677 17.8575 17.2782 17.8753 17.1879 17.8753C17.0975 17.8753 17.0081 17.8575 16.9246 17.8229C16.8412 17.7883 16.7654 17.7377 16.7015 17.6738L11.0004 11.9718L5.29929 17.6738C5.17029 17.8028 4.99532 17.8753 4.81288 17.8753C4.63044 17.8753 4.45548 17.8028 4.32648 17.6738C4.19747 17.5448 4.125 17.3698 4.125 17.1874C4.125 17.005 4.19747 16.83 4.32648 16.701L10.0284 10.9999L4.32648 5.2988C4.19747 5.1698 4.125 4.99483 4.125 4.81239C4.125 4.62996 4.19747 4.45499 4.32648 4.32599C4.45548 4.19698 4.63044 4.12451 4.81288 4.12451C4.99532 4.12451 5.17029 4.19698 5.29929 4.32599L11.0004 10.0279L16.7015 4.32599C16.8305 4.19698 17.0054 4.12451 17.1879 4.12451C17.3703 4.12451 17.5453 4.19698 17.6743 4.32599C17.8033 4.45499 17.8758 4.62996 17.8758 4.81239C17.8758 4.99483 17.8033 5.1698 17.6743 5.2988L11.9723 10.9999L17.6743 16.701Z"
                            fill="#343330"
                        />
                    </svg>
                </div>
            </div>
            <Notification :notifications="notifications.slice(0, 4)" />
            <Link
                v-if="!isDashBoardTeacher"
                :href="route('user.notification')"
                class="show-full-notification d-flex justify-content-center"
            >
                {{ lang().label.notification.notification_detail }}
            </Link>
            <Link
                v-if="isDashBoardTeacher"
                :href="route('teacher.notification')"
                class="show-full-notification d-flex justify-content-center"
            >
                {{ lang().label.notification.notification_detail }}
            </Link>
        </div>
    </div>
</template>
<script setup>
import { ref, defineProps, onBeforeUnmount, watch, computed } from "vue";
import Notification from "@/Components/Notification/Notification.vue";
import { Link } from "@inertiajs/vue3";

const isShowNotification = ref(false);
const unReadNotification = ref(0);
const props = defineProps({
    isDashBoardTeacher: Boolean,
    notifications: Array,
    user: Object,
});
let notifications = ref(
    props.notifications
        ? Object.keys(props.notifications).map(
              (key) => props.notifications[key]
          )
        : []
);

watch(
    notifications.value,
    (value) => {
        unReadNotification.value = notifications.value?.filter(
            (notification) => notification.read_at === null
        )?.length;
    },
    { immediate: true }
);
window.Echo.private(`${props.user?.role == 2 ? 'Teacher' : 'User'}.${props.user?.id}`).notification((notification) => {
    window.axios
        .get(route("api.get.notification", { id: notification.id }))
        .then((response) => {
            notifications.value.unshift(response.data.notification);
        })
        .catch((e) => console.log(e));
});
const handlePopupClick = (event) => {
    event.stopPropagation();
};

const handleClickOutside = (event) => {
    const popup = document.querySelector(".notification-icon");
    if (popup && !popup.contains(event.target)) {
        isShowNotification.value = false;
    }
};

const handleShowNotification = () => {
    isShowNotification.value = !isShowNotification.value;
    if (isShowNotification.value) {
        document.addEventListener("click", handleClickOutside);
    } else {
        document.removeEventListener("click", handleClickOutside);
    }
};

onBeforeUnmount(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>
<style scoped lang="scss">
.notification-icon {
    margin: 0 10px;
}
.show-notification {
    background-color: white;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 0px -0.30914px 2.23268px 0px rgba(0, 0, 0, 0.04),
        0px -0.78184px 5.64662px 0px rgba(0, 0, 0, 0.06),
        0px -1.59488px 11.51857px 0px rgba(0, 0, 0, 0.07),
        0px -3.28515px 23.72607px 0px rgba(0, 0, 0, 0.09),
        0px -9px 65px 0px rgba(0, 0, 0, 0.13);
    max-width: 400px;
    font-size: 14px;
    width: 400px;
    top: 30px;
    left: -325px;
    div {
        cursor: pointer;
    }
    z-index: 999;
}

.notification-title {
    position: relative;
    color: #1b1b1b;
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: 22.4px; /* 22.4px */
    letter-spacing: -0.14px;
}

.close-popup {
    cursor: pointer;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-40%);
}

.show-full-notification {
    color: #1b1b1b;
    cursor: pointer;
    text-decoration: underline;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: 19.2px; /* 19.2px */
    letter-spacing: -0.12px;
}

:deep(.notification__container-card) {
    .noti__content-title {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}

.notification-svg {
    position: relative;
}
.new-notification {
    font-family: "Noto San JP";
    width: 16px;
	height: 16px;
    position: absolute;
    font-size: 10px;
    top: 0;
    right: 0;
    color: #ffffff;
    border-radius: 100px;
    background-color: red;
    font-weight: bold;
    z-index: 10000000000;
	display: flex;
	align-items: center;
	justify-content: center;
}
</style>
