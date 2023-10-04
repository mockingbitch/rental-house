<script setup>
import { ref, defineEmits } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import BaseReservedCard from "@/Components/User/BaseReservedCard.vue";
import BaseReservedButton from "@/Components/User/Common/BaseReservedButton.vue";
import Modal from "@/Components/Modal/Modal.vue";
import Dialog from "@/Components/Dialog/Dialog.vue";
import CheckboxForm from "@/Components/Request/Common/CheckboxForm.vue";
import SelectForm from "@/Components/Request/Common/SelectForm.vue";
import ButtonDeleteRequest from "@/Components/Request/ButtonDeleteRequest.vue";
import ButtonRequest from "@/Components/Request/ButtonRequest.vue";
import moment from "moment";

const props = defineProps({
    statusButton: Number,
    label: String,
    course: Object,
});

const emits = defineEmits(["setClickSkipButton", "setClickDeleteButton"]);

let isOpenOffDialog = ref(false);
let isOpenOffListDialog = ref(false);
let isOpenDeleteDialog = ref(false);
let handleOpenOffDialog = () => {
    isOpenOffDialog.value = true;
};
const handleOpenOffListDialog = () => {
    isOpenOffListDialog.value = true;
    isOpenOffDialog.value = false;
};

const closeScheduleList = () => {
    isOpenOffListDialog = false
}
const handleOpenDeleteDialog = () => {
    isOpenDeleteDialog.value = true;
    isOpenOffDialog.value = false;
};

const skippedSchedule = () => {
    let skippedArray = []
    let scheduledArray = []
    for (let i = 0; i < props.course?.course_schedules?.length; i++) {
        scheduledArray.push(props.course?.course_schedules[i].id)
        for (let j = 0; j < props.course?.course_schedules[i].user_schedule.length; j++) {
            if (props.course?.course_schedules[i].user_schedule[j].user_id === usePage().props.auth.user.id &&
                props.course?.course_schedules[i].user_schedule[j].status == '0') {
                    skippedArray.push(props.course?.course_schedules[i].id)
            }
        }
    }

    return {
        skippedArray: skippedArray,
        scheduledArray :scheduledArray
    }
}

const form = useForm({
    reason: "レッスン料金が高い",
    reason_other: "",
    course_id: props.course?.id,
});
const scheduleForm = useForm({
    list_schedule: skippedSchedule().scheduledArray,
    list_id: skippedSchedule().skippedArray,
});
const skipSchedule = () => {
    scheduleForm.post(route("schedule.skip"), {
        onSuccess: (e) => {
            isOpenOffListDialog.value = false;
        },
    });
    isOpenOffListDialog.value = false;
    emits('setClickSkipButton', props.course.lesson.title);
}
const cancelCourse = () => {
    form.post(route("course.cancel"), {
        onSuccess: (e) => {
        },
    });
    isOpenDeleteDialog.value = false;
    emits('setClickDeleteButton', props.course.lesson.title);
}
const pastSchedule = (scheduleDate) => {
    if (moment(scheduleDate).format('YYYY-MM-DD') < moment().format('YYYY-MM-DD')) {
        return false;
    } else {
        return true;
    }
}
const checkUserSchedule = (schedule) => {
    for (let i = 0; i < schedule.user_schedule.length; i++) {
        if (schedule.user_schedule[i].user_id === usePage().props.auth.user.id) {
            return {
                schedule: schedule,
                user_schedule: schedule.user_schedule[i]
            }
        }
    }
}
const isDeadline = () => {
    return moment(props.course.date).subtract(Number(props.course.deadline), "days") > moment();
}

const lang = () => {return usePage().props.language.original}
const options = [
    lang().label.user.reserved.popup_select_reason_reason_option1,
    lang().label.user.reserved.popup_select_reason_reason_option2,
    lang().label.user.reserved.popup_select_reason_reason_option3,
    lang().label.user.reserved.popup_select_reason_reason_option4,
	lang().label.user.reserved.popup_select_reason_reason_option5,
];
</script>
<template>
    <div>
        <BaseReservedCard :course="props.course" />
        <div class="d-flex align-items-center reserved-btn">
            <BaseReservedButton
                :label="props.label"
                :status-button="props.statusButton"
            />
            <div
                class="reserved-btn-right d-flex align-items-center justify-content-center"
            >
                <div @click="handleOpenOffDialog"
>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                    >
                        <path
                            d="M8.75 8C8.75 8.14834 8.70601 8.29334 8.6236 8.41668C8.54119 8.54001 8.42406 8.63614 8.28701 8.69291C8.14997 8.74967 7.99917 8.76453 7.85368 8.73559C7.7082 8.70665 7.57456 8.63522 7.46967 8.53033C7.36478 8.42544 7.29335 8.2918 7.26441 8.14632C7.23547 8.00083 7.25033 7.85003 7.30709 7.71299C7.36386 7.57594 7.45999 7.45881 7.58332 7.3764C7.70666 7.29399 7.85166 7.25 8 7.25C8.19891 7.25 8.38968 7.32902 8.53033 7.46967C8.67098 7.61032 8.75 7.80109 8.75 8ZM12.25 7.25C12.1017 7.25 11.9567 7.29399 11.8333 7.3764C11.71 7.45881 11.6139 7.57594 11.5571 7.71299C11.5003 7.85003 11.4855 8.00083 11.5144 8.14632C11.5434 8.2918 11.6148 8.42544 11.7197 8.53033C11.8246 8.63522 11.9582 8.70665 12.1037 8.73559C12.2492 8.76453 12.4 8.74967 12.537 8.69291C12.6741 8.63614 12.7912 8.54001 12.8736 8.41668C12.956 8.29334 13 8.14834 13 8C13 7.80109 12.921 7.61032 12.7803 7.46967C12.6397 7.32902 12.4489 7.25 12.25 7.25ZM3.75 7.25C3.60166 7.25 3.45666 7.29399 3.33332 7.3764C3.20999 7.45881 3.11386 7.57594 3.05709 7.71299C3.00032 7.85003 2.98547 8.00083 3.01441 8.14632C3.04335 8.2918 3.11478 8.42544 3.21967 8.53033C3.32456 8.63522 3.4582 8.70665 3.60368 8.73559C3.74917 8.76453 3.89997 8.74967 4.03701 8.69291C4.17406 8.63614 4.29119 8.54001 4.3736 8.41668C4.45601 8.29334 4.5 8.14834 4.5 8C4.5 7.80109 4.42098 7.61032 4.28033 7.46967C4.13968 7.32902 3.94891 7.25 3.75 7.25Z"
                            fill="#343330"
                        />
                    </svg>
                </div>
                <Dialog :show-dialog="isOpenOffDialog" @close-dialog="isOpenOffDialog = false">
                    <div
                        style="
                            cursor: pointer;
                            padding: 7px 30px;
                            border-bottom: 1px solid #e3e3e3;
                            height: 42px;
                            font-size: 14px;
                        "
                        class="d-flex align-items-center"
                        @click="handleOpenOffListDialog"
                    >
					{{ lang().label.user.reserved.button_skip }}
                    </div>
                    <div
                        style="cursor: pointer; padding: 7px 30px; height: 42px; font-size: 14px;"
                        class="d-flex align-items-center"
                        @click="handleOpenDeleteDialog"
                    >
					{{ lang().label.user.reserved.button_time }}
                    </div>
                </Dialog>
            </div>
        </div>
        <!-- <Modal :show-modal="isOpenOffDialog" @close="isOpenOffDialog = false">
            <div
                style="
                    cursor: pointer;
                    padding: 7px 30px;
                    border-bottom: 1px solid #e3e3e3;
                "
                @click="handleOpenOffListDialog"
            >
			{{ lang().label.user.reserved.button_skip }}
            </div>
            <div
                style="cursor: pointer; padding: 7px 30px"
                @click="handleOpenDeleteDialog"
            >
			{{ lang().label.user.reserved.button_time }}
            </div>
        </Modal> -->
        <Modal
            :show-modal="isOpenOffListDialog"
            @close="isOpenOffListDialog = false"
        >
            <div class="off-list-modal-container">
                <div class="off-list-modal-title">{{ lang().label.user.reserved.popup_select_schedule_label }}</div>
                <div class="off-list-modal-wrap">
                    <div
                        v-for="schedule in props.course.course_schedules"
                        :key="schedule.id"
                        class="d-flex align-items-center mt-4 off-list-modal-item"
                    >
                        <!-- Past Schedule -->
                        <div v-if="!pastSchedule(checkUserSchedule(schedule).schedule.date)" class="d-flex align-items-center w-full">
                            <input type="checkbox" :value="schedule.id" v-model="scheduleForm.list_id" :disabled="true">
                            <div class="off-list-modal-item-left d-flex align-items-center justify-content-between">
                                <div>{{ schedule.date }}　{{ schedule.start_time + "-" + schedule.end_time }}</div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" fill="none">
                                    <path d="M28.7076 9.70708L12.7076 25.7071C12.6147 25.8001 12.5044 25.8738 12.383 25.9241C12.2616 25.9745 12.1315 26.0004 12.0001 26.0004C11.8687 26.0004 11.7385 25.9745 11.6171 25.9241C11.4957 25.8738 11.3854 25.8001 11.2926 25.7071L4.29257 18.7071C4.10493 18.5194 3.99951 18.2649 3.99951 17.9996C3.99951 17.7342 4.10493 17.4797 4.29257 17.2921C4.48021 17.1044 4.7347 16.999 5.00007 16.999C5.26543 16.999 5.51993 17.1044 5.70757 17.2921L12.0001 23.5858L27.2926 8.29208C27.4802 8.10444 27.7347 7.99902 28.0001 7.99902C28.2654 7.99902 28.5199 8.10444 28.7076 8.29208C28.8952 8.47972 29.0006 8.73422 29.0006 8.99958C29.0006 9.26494 28.8952 9.51944 28.7076 9.70708Z" fill="#5392F9 "/>
                                </svg>
                            </div>
                        </div>

                        <!-- Canceled Schedule -->
                        <div v-else-if="checkUserSchedule(schedule).user_schedule.status == 0" class="d-flex align-items-center w-full">
                            <input type="checkbox" :value="schedule.id" v-model="scheduleForm.list_id" v-if="isDeadline()">
                            <input type="checkbox" :value="schedule.id" v-model="scheduleForm.list_id" :disabled="true" v-else>
                            <div class="off-list-modal-item-left d-flex align-items-center justify-content-between">
                                <div>{{ schedule.date }}　{{ schedule.start_time + "-" + schedule.end_time }}</div>
                            </div>
                        </div>

                        <!-- Able Schedule -->
                        <div v-else class="d-flex align-items-center w-full">
                            <input type="checkbox" :value="schedule.id" v-model="scheduleForm.list_id">
                            <div class="off-list-modal-item-left d-flex align-items-center justify-content-between">
                                <div>{{ schedule.date }}　{{ schedule.start_time + "-" + schedule.end_time }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex off-list-btn">
                    <ButtonDeleteRequest
                        :label="lang().label.user.reserved.popup_select_schedule_button_cancel"
                        @click="isOpenOffListDialog = false"
                    />
                    <ButtonRequest
                        :label="lang().label.user.reserved.popup_select_schedule_button_skip"
                        style="background-image: none"
                        :submit-button="true"
                        @click="skipSchedule()"
                    />
                </div>
            </div>
        </Modal>
        <Modal
            :show-modal="isOpenDeleteDialog"
            @close="isOpenDeleteDialog = false"
        >
            <div class="off-list-modal-container">
                <div class="off-list-modal-title">
                    <div>{{ lang().label.user.reserved.popup_select_reason_label }}</div>
                    <!-- <div>よろしいですか？</div> -->
                </div>

                <SelectForm
                    v-model:selected="form.reason"
                    :label="lang().label.user.reserved.popup_select_reason_reason"
                    :options="options"
                    :title="lang().label.user.reserved.popup_select_reason_reason_placeholder"
                />
                <div
                    v-if="form.reason === 'その他'"
                    class="delete-modal-reason-text mt-4"
                >
                    <textarea
                        v-model="form.reason_other"
                        rows="4"
                        :placeholder="lang().label.user.reserved.popup_select_reason_reason_placeholder"
                    />
                </div>
                <div class="delete-modal-btn d-flex">
                    <ButtonDeleteRequest
                        :label="lang().label.user.reserved.popup_select_reason_button_cancle"
                        @click="isOpenDeleteDialog = false"
                    />
                    <ButtonDeleteRequest
                        :label="lang().label.user.reserved.popup_select_reason_button_confirm"
                        :submit-button="true"
                        @click="cancelCourse()"
                    />
                </div>
            </div>
        </Modal>
    </div>
</template>
<style scoped lang="scss">
:deep(.base-reserved-button) {
    max-width: 350px;
}
:deep(.request__form-wrap) {
    margin-top: 16px;
    line-height: 160%;
    .request__form-wrap-options {
        padding: 12.5px 8px;
        width: 100%;
        border: 1px solid #b1b1b1;
        border-radius: 4px;
        font-family: Noto Sans JP;
        font-size: 16px;
        margin-top: 8px;
        cursor: pointer;
    }
}
:deep(.modal) {
    border-radius: 10px;
}
:deep(.checkbox__form-wrap) {
    input {
        width: 16px;
        height: 16px;
    }
}

.reserved-btn {
    margin-top: 6px;
    gap: 10px;
    .reserved-btn-right {
        width: 40px;
        height: 40px;
        cursor: pointer;
        position: relative;
    }
}
.off-list-modal-container {
    min-width: 368px;
    font-size: 16px;
    font-family: Noto Sans JP;
    .off-list-modal-wrap {
        height: 216px;
        overflow-y: scroll;
        scrollbar-width: thin;
        scrollbar-color: #7f7f7f99 #fff;
    }
    .off-list-modal-item {
        padding: 4px 16px;
        .off-list-modal-item-left {
            margin-left: 10px;
            width: 100%;
            svg {
                cursor: pointer;
            }
        }
    }
    .off-list-modal-wrap::-webkit-scrollbar {
        width: 6px;
    }

    .off-list-modal-wrap::-webkit-scrollbar-thumb {
        background-color: #7f7f7f99;
        border-radius: 10px;
    }

    .off-list-modal-wrap::-webkit-scrollbar-track {
        background-color: #fff;
    }

    .off-list-modal-wrap {
        scrollbar-color: #7f7f7f99 #fff;
    }

    .off-list-modal-wrap::-ms-scrollbar {
        width: 6px;
    }

    .off-list-modal-wrap::-ms-scrollbar-thumb {
        background-color: #7f7f7f99;
        border-radius: 10px;
    }

    .off-list-modal-wrap::-ms-scrollbar-track {
        background-color: #fff;
    }
    .off-list-btn {
        gap: 16px;
    }
    .delete-modal-btn {
        gap: 16px;
    }
    .delete-modal-reason-text {
        textarea {
            border: 1px solid #b1b1b1;
            border-radius: 4px;
            height: 108px;
            width: 100%;
            padding: 12.5px 10px;
            font-family: Noto Sans JP;
        }
        textarea::placeholder {
            color: #b1b1b1;
        }
    }
    .off-list-modal-title {
        font-size: 16px;
        font-weight: 700;
        line-height: 160%;
        letter-spacing: -0.16px;
        text-align: center;
    }
}
.submit__button {
    width: 100%;
    height: 50px;
    margin-top: 16px;
}
@media all and (max-width: 768px) {
    .off-list-modal-container {
        min-width: 311px;
    }
}
</style>
