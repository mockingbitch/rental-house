<script setup>
import { ref } from "vue";
import BaseCard from "../Teacher/Common/BaseCard.vue";
import ListApply from "../Request/ListApply.vue";
import Modal from "../Modal/Modal.vue";
import { defineProps } from "vue";
import moment from "moment";
import { Inertia } from "@inertiajs/inertia";
import { Link } from '@inertiajs/vue3';
import EmptyRequest from "@/Components/Request/EmptyRequest.vue";

const props = defineProps({
    isUser: Boolean,
    requests: Array,
    isLoggedIn: Boolean,
});

const isOpenConfirmDeleteRequest = ref(false);
const showFullDetail = ref(false);
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

const formatWeekDays = (data) => {
    let weekdays = JSON.parse(data);
    let result = '';
    weekdays = weekdays.sort((a, b) => a - b);
    for (let i = 0; i < weekdays.length; i++) {
        switch (weekdays[i]) {
            case 2:
                result += 'Mon';
                break;
            case 3:
                result += 'Tue';
                break;
            case 4:
                result += 'Wed';
                break;
            case 5:
                result += 'Thu';
                break;
            case 6:
                result += 'Fri';
                break;
            case 7:
                result += 'Sat';
                break;
            case 8:
                result += 'Sun';
                break;
            default:
                break;
        }
        if (i < weekdays.length - 1) {
            result += ', ';
        }
    }

    return result;
}

</script>
<template>
    <div>
        <Modal
            :showModal="isOpenConfirmDeleteRequest"
            @close="isOpenConfirmDeleteRequest"
        >
            <div class="modal__container">
                <div class="modal__title">
                    {{ lang().label.request.popup_confirm_delete.label_one }}
                </div>
                <div class="modal__content-wrap align-items-center">
                    <p>(仮)削除すると復元することはできません。</p>
                    <p>登録済みのレッスンを</p>
                    <p>個別で探さないといけません。</p>
                </div>
                <div class="modal__btn">
                    <button
                        @click="handleToggleDelete"
                        class="modal__btn-btn modal__btn-btn-left"
                    >
					{{ lang().label.request.popup_confirm_delete.cancle }}
                    </button>
                    <button
                        @click="handleDeleteRequest()"
                        class="modal__btn-btn modal__btn-btn-right"
                    >
					{{ lang().label.request.popup_confirm_delete.delete }}
                    </button>
                </div>
            </div>
        </Modal>
        <BaseCard v-for="request in props.requests">
            <div class="list__request-container">
                <div class="list__request-day">
                    <div>{{ moment(request.created_at).format('YYYY/MM/DD') }}</div>
                    <div v-if="request.isNew" class="list__request-day-status">{{ lang().label.request.card_lesson_request.flag_new }}</div>
                </div>
                <div class="list__request-name">
                    {{ request.summary }}
                </div>
                <div class="list__request-info">
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">{{ lang().label.request.card_lesson_request.label_price }}</div>
                        <div class="list__request-info-detail">
                            {{ request.min_price.toLocaleString() }}
                             ~ {{ request.max_price.toLocaleString() }} yen
                        </div>
                    </div>
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">{{ lang().label.request.card_lesson_request.label_class_time }}</div>
                        <div class="list__request-info-detail">
                            {{ request.min_time }} ~ {{ request.max_time }}
                             min
                        </div>
                    </div>
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title"></div>
                        <div class="list__request-info-detail">
                            {{ formatWeekDays(request.weekdays) }}
                             {{ request.start_time }} ~ {{ request.end_time }}
                        </div>
                    </div>
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">{{ lang().label.request.card_lesson_request.label_language }}</div>
                        <div class="list__request-info-detail">
                            {{ request.language }}
                        </div>
                    </div>
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">{{ lang().label.request.card_lesson_request.label_spec }}</div>
                        <div class="list__request-info-detail">
                            {{ request.about_teacher }}
                        </div>
                    </div>
                </div>
                <div class="list__request-detail">
                    <div v-if="request.showFullDetail || request.detail?.length < 50">
                        {{ request.detail }}
                    </div>
                    <div v-else :style="shortDetailStyles">{{ request.detail }}</div>
                    <div
                        class="list__request-show-more"
                        @click="toggleShowFullDetail(request)"
                        v-if="request.detail?.length >= 50"
                    >
                        {{ request.showFullDetail ?lang().label.request.card_lesson_request.show_less : lang().label.request.card_lesson_request.show_more }}
                    </div>
                </div>
                <div class="list__request-actions" v-if="isUser">
                    <div
                        class="list__request-actions-delete"
                        @click="handleToggleDelete(request)"
                    >
                        <img src="/img/icon/TeacherRequest/delete.svg" />
                        <span>{{ lang().label.request.card_lesson_request.delete }}</span>
                    </div>
                    <Link
                        @click.prevent
                        v-if="request.applications.length > 0"
                        href="javascript:"
                        class="list__request-actions-edit disable"
                    >
                        <img src="/img/icon/TeacherRequest/edit-disable.svg" />
                        <span>{{ lang().label.request.card_lesson_request.edit }}</span>
                    </Link>
                    <Link
                        v-if="request.applications.length === 0"
                        :href="route('request.detail', request.id)"
                        class="list__request-actions-edit"
                    >
                        <img src="/img/icon/TeacherRequest/edit.svg" />
                        <span>{{ lang().label.request.card_lesson_request.edit }}</span>
                    </Link>
                </div>
                <div
                    v-if="request.applications && request.applications.length === 0"
                    class="list__request-empty-state"
                >
                    (Emptystates)レッスンが登録されていません。
                </div>
                <ListApply
                    v-if="request.applications && request.applications.length > 0"
                    :lessons="request.applications"
                />
            </div>
        </BaseCard>
    </div>
    <EmptyRequest v-if="props.requests?.length === 0" :show="false" :isUser="true" :isLoggedIn="props.isLoggedIn" />
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
    background-color: #5392F9 ;
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
    color: #5392F9 ;
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
    border: 1px solid #5392F9 ;
    color: #5392F9 ;
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
