<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import Modal from "@/Components/Modal/Modal.vue";
import { ref } from "vue";

const props = defineProps({
    isUser: Boolean,
    isLoggedIn: Boolean,
    show: Boolean,
    requests: Array,
});
let isOpenConfirmModal = ref(false);

const closeConfirmModal = () => {
    isOpenConfirmModal.value = !isOpenConfirmModal.value;
};
</script>

<template>
    <Modal
        :showModal="isOpenConfirmModal"
        @close="closeConfirmModal"
        v-if="usePage().props.auth?.user?.role != '2'"
    >
        <div class="modal__container">
            <div class="modal__title">
                <div>リクエストを登録します。</div>
                <div>よろしいですか？</div>
            </div>
            <BaseCard>
                <div class="modal__content-wrap">
                    <div class="modal__content-title">簡単な説明文</div>
                    <div>
                        ①
                        リクエスト内容は、リクエストタブからいつでも確認ができます。
                    </div>
                    <div>
                        ②
                        リクエスト内容はいつでも取り下げが可能です。*また、レッスンが登録されるまでリクエスト内容の変更ができます。
                    </div>
                    <div>
                        ③ リクエストに先生がレッスン登録したら通知が届きます。
                    </div>
                </div>
            </BaseCard>
            <div class="modal__btn">
                <Link
                    :href="route('login.method')"
                    class="modal__btn-btn modal__btn-btn-left"
                >
                    キャンセル
                </Link>
                <Link
                    :href="route('register.method')"
                    class="modal__btn-btn modal__btn-btn-right"
                >
                    登録する
                </Link>
            </div>
        </div>
    </Modal>
    <div
        class="empty__request-container"
        v-if="usePage().props.auth?.user?.role != '2'"
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
                {{ lang().label.request.requested.note }}
            </div>
            <div v-else>
                (仮)探しているレッスンがなければ、Dottreeにログイン（新規登録）をして、リクエストしましょう！
            </div>
        </div>
        <img
            v-if="!props.isLoggedIn && !props.show"
            src="img/signin.jpg"
            alt="signin"
            class="signin__wrap-banner"
        />
        <div class="empty__request-create">
            <button
                v-if="props.isUser && props.show && !props.isLoggedIn"
                @click="isOpenConfirmModal = !isOpenConfirmModal"
                class="empty__request-create-btn empty__request-create-btn-border-none"
            >
                <img src="/img/icon/TeacherDashboard/plus.svg" alt="" />
                <p>{{ lang().label.request.requested.request_lesson }}</p>
            </button>
            <Link
                v-if="props.isLoggedIn && props.isUser"
                :href="route('request.create')"
                class="empty__request-create-btn empty__request-create-btn-border-none"
            >
                <img src="/img/icon/TeacherDashboard/plus.svg" alt="" />
                <p>{{ lang().label.request.requested.request_lesson }}</p>
            </Link>
        </div>
        <div
            class="empty__request-create"
            v-if="props.isUser && !isLoggedIn && !props.show"
        >
            <div class="modal__container">
                <div class="modal__title mt-4">
                    {{ lang().label.request.popup_confirm_delete.no_login_label_two }}
                </div>
                <BaseCard>
                    <div class="modal__content-wrap">
                        <div class="modal__content-title">
                            {{ lang().label.request.popup_confirm_delete.no_login_label_note1 }}
                        </div>
                        <div class="modal__content-text">
                            <div>
								{{ lang().label.request.popup_confirm_delete.no_login_label_note1 }}
                            </div>
                            <div>
                                <div>
                                    {{ lang().label.request.popup_confirm_delete.no_login_label_note2 }}
                                </div>
                                <!-- <div>の先生を選ぶことができます。</div> -->
                            </div>
                            <div>
								{{ lang().label.request.popup_confirm_delete.no_login_label_note3 }}
                            </div>
                        </div>
                    </div>
                </BaseCard>
                <div class="modal__btn">
                    <Link
                        :href="route('login.method')"
                        class="modal__btn-btn modal__btn-btn-left"
                    >
					{{ lang().label.request.popup_confirm_delete.no_login_login }}
                    </Link>
                    <Link
                        :href="route('register.method')"
                        class="modal__btn-btn modal__btn-btn-right"
                    >
					{{ lang().label.request.popup_confirm_delete.no_login_register }}
                    </Link>
                </div>
            </div>
        </div>
        <div v-if="props.show" class="empty__request-avatar">
            <img src="/img/icon/TeacherRequest/tree-gray.svg" alt="" />
        </div>
        <div v-if="props.show" class="empty__request-content">
            <div class="empty__request-content-title">{{ lang().label.user.reserved.no_reserved }}</div>
            <div class="empty__request-content-info">
                {{ lang().label.request.requested.message_no_reserved }}
            </div>
        </div>
    </div>
    <div v-if="usePage().props.auth?.user?.role == '2' && !props.requests">
        <div class="empty__request-avatar">
            <img src="/img/icon/TeacherRequest/tree-gray.svg" alt="" />
        </div>
        <div class="empty__request-content">
            <div class="empty__request-content-title">{{ lang().label.user.reserved.no_reserved }}</div>
            <div class="empty__request-content-info">
                {{ lang().label.request.requested.message_no_reserved }}
            </div>
        </div>
    </div>
</template>
<style scoped lang="scss">
@import "./_logModal.scss";
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
    font-family: "Noto Sans JP";
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
