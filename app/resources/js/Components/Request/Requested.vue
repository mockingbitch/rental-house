<script setup>
import { ref, defineProps } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Link, usePage } from '@inertiajs/vue3';
import moment from "moment";
import BaseCard from "@/Components/Card/BaseCard.vue";
import Modal from "@/Components/Modal/Modal.vue";
import EmptyRequest from "@/Components/Request/EmptyRequest.vue";

const props = defineProps({
    isUser: Boolean,
    // eslint-disable-next-line vue/require-default-prop
    requests: Array,
    isLoggedIn: Boolean,
});

const isOpenConfirmDeleteRequest = ref(false);
const selectedRequest = ref();
const toggleShowFullDetail = (request) => {
    request.showFullDetail = !request.showFullDetail;
};

const shortDetailStyles = {
    display: "-webkit-box",
    "-webkit-line-clamp": "2",
    "-webkit-box-orient": "vertical",
    overflow: "hidden",
};
const handleToggleDelete = (request) => {
    selectedRequest.value = request.id;
    isOpenConfirmDeleteRequest.value = !isOpenConfirmDeleteRequest.value;
};
const handleDeleteRequest = () => {
    Inertia.delete(route("request.delete", selectedRequest.value));
}
</script>

<template>
    <div>
        <Modal
            :show-modal="isOpenConfirmDeleteRequest"
            @close="isOpenConfirmDeleteRequest"
        >
            <div class="modal__container">
                <div class="modal__title">
                    Delete
                </div>
                <div class="modal__content-wrap align-items-center">
                    <p>Once deleted, it cannot be restored.</p>
                </div>
                <div class="modal__btn">
                    <button
                        class="modal__btn-btn modal__btn-btn-left"
                        @click="handleToggleDelete"
                    >
                        Cancel
                    </button>
                    <button
                        class="modal__btn-btn modal__btn-btn-right"
                        @click="handleDeleteRequest()"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </Modal>
        <BaseCard v-for="request in props.requests" :key="request.id">
            <div class="list__request-container">
                <div class="list__request-day">
                    <div>{{ moment(request?.created_at).format('YYYY/MM/DD') }}</div>
                    <div v-if="request?.isNew && request?.status === 1" class="list__request-day-status">
                        New
                    </div>
                    <div v-if="request?.status === 2" class="list__request-draft-status">Draft</div>
                </div>
                <div class="list__request-name">
                    {{ request?.summary }}
                </div>
                <div class="list__request-info">
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">
                            Price
                        </div>
                        <div class="list__request-info-detail">
                            {{ request?.min_price?.toLocaleString() }}
                            ~ {{ request?.max_price?.toLocaleString() }} VND
                        </div>
                    </div>
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">
                            Capacity
                        </div>
                        <div class="list__request-info-detail">
                            {{ request.min_capacity }} ~ {{ request.max_capacity }}
                            persons
                        </div>
                    </div>
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">
                            Type
                        </div>
                        <div class="list__request-info-detail">
                            {{ request?.category?.name_en }}
                        </div>
                    </div>
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">
                            Address
                        </div>
                        <div class="list__request-info-detail">
                            Address
                        </div>
                    </div>
                </div>
                <div class="list__request-detail">
                    <div class="list__request-info-title">
                        Detail
                    </div>
                    <div v-if="request.showFullDetail || request.detail?.length < 50">
                        {{ request?.detail }}
                    </div>
                    <div v-else :style="shortDetailStyles">{{ request.detail }}</div>
                    <div
                        v-if="request.detail?.length >= 50"
                        class="list__request-show-more"
                        @click="toggleShowFullDetail(request)"
                    >
                        {{ request.showFullDetail ? 'Show less' : 'Show more' }}
                    </div>
                </div>
                <div v-if="isUser" class="list__request-actions">
                    <Link
                        href="javascript:"
                        class="list__request-actions-edit disable"
                        @click.prevent
                    >
                    </Link>
                    <div
                        class="list__request-actions-delete"
                        @click="handleToggleDelete(request)"
                    >
                        <img src="/img/icon/TeacherRequest/delete.svg" alt="" />
                        <span>
                            Delete
                        </span>
                    </div>
<!--                    <Link-->
<!--                        v-if="request.status === 1"-->
<!--                        :href="route('request.detail', request.id)"-->
<!--                        class="list__request-actions-edit"-->
<!--                    >-->
<!--                        <img src="/img/icon/TeacherRequest/edit.svg" alt="" />-->
<!--                        <span>Edit</span>-->
<!--                    </Link>-->
<!--                    <Link-->
<!--                        v-if="request.status === 2"-->
<!--                        :href="route('request.detail', request.id)"-->
<!--                        class="list__request-actions-edit"-->
<!--                    >-->
<!--                        <img src="/img/icon/TeacherRequest/edit.svg"  alt=""/>-->
<!--                        <span>To Edit</span>-->
<!--                    </Link>-->
                </div>
            </div>
        </BaseCard>
    </div>
    <EmptyRequest
        v-if="props.requests?.length === 0"
        :show="false"
        :is-user="true"
        :is-logged-in="props.isLoggedIn"
    />
</template>
<style lang="scss" scoped>
.day {
    margin: 16px 0;
    font-size: 16px;
    font-weight: 700;
}
.list__request-container {
    padding: 16px;
    margin-top: 16px;
}
.list__request-day {
    display: flex;
    align-items: center;
    gap: 4px;
    padding-bottom: 8px;
}
.list__request-day-status {
    font-size: 10px;
    color: #ff5575;
    font-weight: bold;
}
.list__request-draft-status {
    font-size: 10px;
    color: #faad14;
    font-weight: bold;
    background-color: #ffedc9;
    border-radius: 4px;
    padding: 2px 4px;
    line-height: 1.6;
}
.list__request-name {
    font-size: 14px;
    font-weight: 700;
    padding-bottom: 8px;
    border-bottom: 1px solid #e3e3e3;
    word-break: break-all;
}
.list__request-info-wrap {
    display: flex;
    justify-content: space-between;
    .list__request-info-title {
        width: fit-content;
        white-space: nowrap;
    }
}
.list__request-info {
    margin-top: 8px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.list__request-info-detail {
    font-weight: bold;
    word-break: break-all;
    padding-left: 53px;
}
.list__request-detail {
    word-break: break-all;
    padding: 8px 0px;
}
.list__request-create {
    margin-top: 8px;
    display: flex;
    justify-content: center;
}
.list__request-create-btn {
    display: flex;
    background-color: #418997;
    width: 343px;
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
}
.list__request-show-more {
    background: none;
    border: none;
    color: #1b1b1b;
    cursor: pointer;
    text-decoration: underline;
    font-weight: bold;
}
.list__request-empty-state {
    padding: 16px 7.5px;
    margin-top: 8px;
    font-size: 14px;
    color: #989898;
    letter-spacing: -0.14px;
}

.list__request-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    font-size: 14px;
    justify-content: space-between;
    padding: 0 16px;
    border-bottom: 1px solid #e3e3e3;
}

.list__request-actions-delete {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #e71a41;
    gap: 4px;
    padding: 14px 15.75px;
    cursor: pointer;
}

.list__request-actions-edit {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #418997;
    gap: 4px;
    padding: 14px 15.75px;
    cursor: pointer;
}
.modal__container {
    max-width: 368px !important;
}
.modal__title {
    font-size: 16px;
    font-weight: 700;
    max-width: 189px;
    letter-spacing: -0.16px;
    line-height: 1.62;
    text-align: center;
    margin: 0 auto;
}
.modal__content-wrap {
    display: flex;
    padding: 16px;
    flex-direction: column;
    justify-content: center;
    align-self: stretch;
    font-size: 14px;
    letter-spacing: -0.14px;
    line-height: 1.6;
    p {
        display: flex;
        justify-content: center;
    }
    gap: 0;
}
.modal__btn {
    display: flex;
    gap: 16px;
    justify-content: center;
}
.modal__btn-btn {
    min-width: 176px;
    min-height: 50px;
    border-radius: 4px;
    font-family: 'Noto Sans JP';
    font-size: 14px;
}
.modal__btn-btn-left {
    border: 1px solid #418997;
    color: #418997;
    background-color: white;
    cursor: pointer;
}
.modal__btn-btn-right {
    background-color: #e71a41;
    color: white;
    border: none;
    cursor: pointer;
}
.disable {
    color: #808080;
    pointer-events: none;
}
@media all and (max-width: 768px) {
    .modal__btn-btn {
        min-width: 147px;
    }
    .modal__container {
        max-width: 343px;
    }
}
</style>
