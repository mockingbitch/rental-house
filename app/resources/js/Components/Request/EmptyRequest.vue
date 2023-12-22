<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import Modal from "@/Components/Modal/Modal.vue";
import BaseCard from "@/Components/Card/BaseCard.vue";

const props = defineProps({
    isUser: Boolean,
    isLoggedIn: Boolean,
    show: Boolean,
    // eslint-disable-next-line vue/require-default-prop
    requests: Array,
    // eslint-disable-next-line vue/require-default-prop
    listRequests: Array
});
let isOpenConfirmModal = ref(false);
const closeConfirmModal = () => {
    isOpenConfirmModal.value = !isOpenConfirmModal.value;
};
</script>

<template>
    <Modal
        v-if="usePage().props.auth?.user?.role !== 'LESSOR'"
        :show-modal="isOpenConfirmModal"
        @close="closeConfirmModal"
    >
        <div class="modal__container">
            <div class="modal__title">
                <div>Edit request</div>
                <div>Is it okay？</div>
            </div>
            <BaseCard>
                <div class="modal__content-wrap">
                    <div class="modal__content-title">Brief description</div>
                    <div>
                        ①
                        You can check the request details at any time from the request tab.
                    </div>
                    <div>
                        ②
                        You can withdraw your request at any time. *Also, you can change your request until the lesson is registered.
                    </div>
                    <div>
                        ③ You will receive a notification when a lessor registers a house for your request.
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
                    Register
                </Link>
            </div>
        </div>
    </Modal>
    <div
        v-if="usePage().props.auth?.user?.role !== 'LESSOR'"
        class="empty__request-container"
    >
        <div
            v-if="
                (props.isUser && props.show) ||
                (!props.show && props.isLoggedIn)
            "
            class="empty__request-note"
        >
            <img src="/img/icon/TeacherRequest/tree.svg" alt="" />
            <div v-if="props.isLoggedIn">
                Note
            </div>
            <div v-else>
                (Tentative) If you don't find the house you're looking for, log in (new registration) to RentalHouse and request it!
            </div>
        </div>
        <img
            v-if="!props.isLoggedIn && !props.show"
            src="/img/signin.jpg"
            alt="signin"
            class="signin__wrap-banner"
        />
        <div class="empty__request-create">
            <button
                v-if="props.isUser && props.show && !props.isLoggedIn"
                class="empty__request-create-btn empty__request-create-btn-border-none"
                @click="isOpenConfirmModal = !isOpenConfirmModal"
            >
                <img src="/img/icon/TeacherDashboard/plus.svg" alt="" />
                <p>Request house</p>
            </button>
            <Link
                v-if="props.isLoggedIn && props.isUser"
                :href="route('request.create')"
                class="empty__request-create-btn empty__request-create-btn-border-none"
            >
                <img src="/img/icon/TeacherDashboard/plus.svg" alt="" />
                <p>Request house</p>
            </Link>
        </div>
        <div
            v-if="props.isUser && !isLoggedIn && !props.show"
            class="empty__request-create"
        >
            <div class="modal__container">
                <div class="modal__title mt-4">
                    No login
                </div>
                <BaseCard>
                    <div class="modal__content-wrap">
                        <div class="modal__content-title">
                            Request houses of interest
                        </div>
                        <div class="modal__content-text">
                            <div>
                                1. You can request houses that are of interest you.
                            </div>
                            <div>
                                <div>
                                    2. You can check the proposal for your request in advance and choose the house of your choice.
                                </div>
                            </div>
                            <div>
                                3. You can participate in houses suggested on other users' requests.
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
                        Register
                    </Link>
                </div>
            </div>
        </div>
        <div v-if="props.show" class="empty__request-avatar">
            <img src="/img/icon/TeacherRequest/tree-gray.svg" alt="" />
        </div>
        <div v-if="props.show" class="empty__request-content">
            <div class="empty__request-content-title mt-4">
                No reserved
            </div>
            <div class="empty__request-content-info">
                No
            </div>
        </div>
    </div>
</template>
<style scoped lang="scss">
@import "./loginmodal";
.empty__request-container {
    display: flex;
    flex-direction: column;
    width: 100%;
}
.empty__request-note {
    padding: 8px;
    display: flex;
    gap: 8px;
    background-color: #e1eff2;
    color: #418997;
    border-radius: 4px;
    margin-top: 24px;
}
.empty__request-create {
    display: flex;
    justify-content: center;
}
.empty__request-create-btn {
    display: flex;
    background-color: #418997;
    width: 100%;
    max-height: 50px;
    align-items: center;
    justify-content: center;
    color: white;
    gap: 10px;
    padding: 16px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 16px;
}
.empty__request-create-btn-border-none {
    border: none;
}
.empty__request-avatar {
    width: 100%;
    height: 100%;
    min-height: 194px;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 16px;
}
.empty__request-content {
    text-align: center;
}
.empty__request-content-title {
    font-size: 16px;
    font-weight: 700;
}
.empty__request-content-info {
    font-size: 12px;
    margin-top: 16px;
}
.btn-border-none {
    border: none;
}

.modal__container {
    max-width: 400px !important;
    color: #1b1b1b;
}
.modal__title {
    max-width: 100%;
}

.modal__content-wrap {
    background-color: #f4f4f4;
    border-radius: 8px;
    .modal__content-text {
        line-height: 1.6;
        display: flex;
        flex-direction: column;
        gap: 18.25px;
    }
}

.modal__btn {
    margin-top: 16px;
}
.signin__wrap-banner {
    max-height: 124px;
}
.modal__content-title,
.modal__content-title div {
    line-height: 1.6;
    letter-spacing: -0.12px;
}
.modal__btn-btn {
    max-width: 192px;
    width: 100%;
    font-family: "Noto Sans JP", serif;
    font-size: 14px;
}
@media all and (max-width: 768px) {
    .empty__request-create-btn {
        width: 343px;
    }
    .empty__request-note {
        margin-top: 16px;
    }
}
</style>
