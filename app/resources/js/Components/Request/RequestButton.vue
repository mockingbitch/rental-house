<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import Modal from "@/Components/Modal/Modal.vue";
import BaseCard from "@/Components/Card/BaseCard.vue";

defineProps({
    isLoggedIn: Boolean,
    requestedPage: Boolean,
    // eslint-disable-next-line vue/require-default-prop
    requests: Array,
    // eslint-disable-next-line vue/require-default-prop
    listRequest: Array,
});

let isOpenConfirmModal = ref(false);

const closeConfirmModal = () => {
    isOpenConfirmModal.value = !isOpenConfirmModal.value;
};
</script>
<template>
    <Modal
        :show-modal="isOpenConfirmModal"
        :border-custom="true"
        @close="closeConfirmModal"
    >
        <div class="modal__container">
            <div class="modal__title">
                <div>(Tentative) If there is a house you are looking for,</div>
                <div>Make a request!</div>
                <img
                    src="/img/icon/close.svg"
                    alt=""
                    @click="closeConfirmModal"
                />
            </div>
            <BaseCard>
                <div class="modal__content-wrap">
                    <div class="modal__content-title">
                        On the request page？
                    </div>
                    <div class="modal__content-content d-flex flex-column">
                        <div>
                            1.
                            You can request houses that you would like to take.
                        </div>
                        <div>
                            2. Preference from proposal content in response to request
                        </div>
                        <div>
                            3.
                            You can also participate in other requests and suggestions for them.
                        </div>
                    </div>
                </div>
            </BaseCard>
            <div class="modal__btn">
                <Link
                    :href="route('login.method')"
                    class="modal__btn-btn modal__btn-btn-left"
                >
                    Login
                </Link>
                <Link
                    :href="route('register.method')"
                    class="modal__btn-btn modal__btn-btn-right"
                >
                    New registration
                </Link>
            </div>
        </div>
    </Modal>
    <Link
        v-if="
            (isLoggedIn && requests?.length !== 0 && requestedPage) ||
            (isLoggedIn && listRequest?.length !== 0 && !requestedPage)
        "
        class="request__lesson-button"
        :href="route('request.create')"
    >
        <img src="/img/icon/TeacherDashboard/plus.svg" alt="" />
        <div>Request room</div>
    </Link>
    <button
        v-if="!isLoggedIn && !requestedPage"
        class="request__lesson-button"
        @click="isOpenConfirmModal = !isOpenConfirmModal"
    >
        <img src="/img/icon/TeacherDashboard/plus.svg" alt="" />
        <div>Request room</div>
    </button>
</template>
<style scoped lang="scss">
@import "./loginmodal";
.request__lesson-button {
    display: flex;
    font-family: "Noto Sans JP", serif;
    line-height: 160%;
    letter-spacing: -0.14px;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 700;
    padding: 16px 31.5px;
    border-radius: 100px;
    background-color: #418997;
    color: white;
    border: none;
    cursor: pointer;
    position: fixed;
    bottom: 16px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
    height: 54px;
}
@media all and (max-width: 991px) {
    .request__lesson-button {
        bottom: 60px;
    }
}
@media all and (max-width: 640px) {
    .request__lesson-button {
        padding: 8px 15.5px;
        height: 38px;
    }
}

.modal__content-wrap {
    background-color: #f4f4f4;
    border-radius: 8px;
}

.modal__btn {
    margin-top: 16px;
    font-family: "Noto Sans JP", serif;
}
.modal__title {
    max-width: 250px;
}
.modal__container {
    position: relative;
}
.modal__title img {
    position: absolute;
    right: 0;
    top: 0;
    cursor: pointer;
}

.modal__content-content {
    line-height: 19.2px;
    gap: 18.4px;
}
.modal__content-title {
    line-height: 22.4px;
}
</style>
