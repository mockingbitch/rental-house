<script setup>
import { Link } from "@inertiajs/vue3";
import Modal from "@/Components/Modal/Modal.vue";
import { ref } from "vue";

defineProps({
    isLoggedIn: Boolean,
    requestedPage: Boolean,
})

let isOpenConfirmModal = ref(false);

const closeConfirmModal = () => {
    isOpenConfirmModal.value = !isOpenConfirmModal.value;
};
</script>
<template>
    <Modal :showModal="isOpenConfirmModal" @close="closeConfirmModal">
        <div class="modal__container">
            <div class="modal__title">
                <div>(仮)探しているレッスンがあれば、</div>
                <div>リクエストしましょう！</div>
                <img src="/img/icon/close.svg" alt="" @click="closeConfirmModal">
            </div>
            <BaseCard>
                <div class="modal__content-wrap">
                    <div class="modal__content-title">
                        リクエストページには？
                    </div>
                    <div>
                        1.
                        子供に受けてもらいたい、子供が受けたいレッスンをリクエストすることができます。
                    </div>
                    <div>
                        2. リクエストに対しての提案内容から好み
                        の先生を選ぶことができます。
                    </div>
                    <div>
                        3.
                        他のリクエストおよびそれに対する提案にも参加することができます。
                    </div>
                </div>
            </BaseCard>
            <div class="modal__btn">
                <Link
                    :href="route('login.method')"
                    class="modal__btn-btn modal__btn-btn-left"
                >
                    ログイン
                </Link>
                <Link
                    :href="route('register.method')"
                    class="modal__btn-btn modal__btn-btn-right"
                >
                    簡単新規登録
                </Link>
            </div>
        </div>
    </Modal>
    <Link
        v-if="isLoggedIn"
        class="request__lesson-button"
        :href="route('request.create')"
    >
        <img src="/img/icon/TeacherDashboard/plus.svg" />
        <div>{{ lang().label.request.requested.request_lesson }}</div>
    </Link>
    <button
        @click="isOpenConfirmModal = !isOpenConfirmModal"
        v-if="! isLoggedIn && ! requestedPage"
        class="request__lesson-button"
    >
        <img src="/img/icon/TeacherDashboard/plus.svg" />
        <div>{{ lang().label.request.requested.request_lesson }}</div>
    </button>
</template>
<style scoped lang="scss">
@import "./_logModal.scss";
.request__lesson-button {
    display: flex;
    font-family: 'Noto Sans JP';
    line-height: 160%;
    letter-spacing: -0.14px;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 700;
    padding: 16px 31.5px;
    border-radius: 100px;
    background-color: #5392F9 ;
    color: white;
    border: none;
    cursor: pointer;
    position: fixed;
    bottom: 86px;
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
}

.modal__btn {
    margin-top: 16px;
    font-family: 'Noto Sans JP';
}
.modal__title {
    max-width: 250px;
}
.modal__container {
    position: relative;
}
.modal__title img {
    position: absolute;
    right: 0px;
    top: 0px;
    cursor: pointer;
}
</style>
