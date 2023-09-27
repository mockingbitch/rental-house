<script setup>
import { ref } from "vue";
import BaseCard from "../Teacher/Common/BaseCard.vue";
import ButtonRequest from "../Request/ButtonRequest.vue";
import Modal from "../Modal/Modal.vue";
import ButtonDeleteRequest from "../Request/ButtonDeleteRequest.vue";
import { Link, useForm } from "@inertiajs/vue3";
import SubHeader from "../Common/SubHeader.vue";
import SelectForm from "@/Components/Request/Common/SelectForm.vue";

const props = defineProps({
    user: Object,
})
const emits = defineEmits();
const form = useForm({
    user: props.user ?? null,
    reason: "レッスン料金が高い",
    reason_other: "",
})

const isOpenDeleteAccount = ref(false);
const isConfirmDelete = ref(false);
const handleOpenDeleteAccountModal = () => {
    isOpenDeleteAccount.value = true;
};
const handleCloseDeleteAccountModal = () => {
    isOpenDeleteAccount.value = false;
};

const handleConfirmDelete = () => {
    form.post(route("account.delete"), {
        onSuccess: (e) => {
            window.location.reload();
        },
        onError: (e) => {
            alert(e.message);
            handleBackToDetail()
        }
    });
    
};
const handleBackToDetail = () => {
    emits("toggle");
};

const options = [
    "レッスン料金が高い",
    "教え方やスタイルが合わない",
    "他の習い事をはじめた",
    "興味がなくなった",
    "その他",
];
</script>
<template>
    <div class="delete-account-container" v-if="!isConfirmDelete">
        <SubHeader
            :label="'アカウント削除'"
            is-close
            @close="handleBackToDetail"
        />
        <div class="delete__account-wrapper" style="padding: 16px 16px 0 16px">
            <div class="mt-4">
                <BaseCard>
                    <div class="delete-account-content">
                        <div class="delete-account-content-title">
                            (仮)注意事項
                        </div>
                        <div>
                            (仮)仮文言アカウントを削除することによるデメリットや注意点をしっかりユーザーに伝えます。
                        </div>
                        <div>
                            仮文言アカウントを削除することによるデメリットや注意点をしっかりユーザーに伝えます。仮文言アカウントを削除することによるデメリットや注意点をしっかりユーザーに伝えます。
                        </div>
                        <div>・アカウント内容が全部なくなる</div>
                        <div>・レッスン予約情報が見れない</div>
                        <div>・レッスンが受けられない</div>
                        <div>・返品などできない　とかとか</div>
                        <div>などなど</div>
                    </div>
                </BaseCard>
            </div>

            <div class="delete-account-btn">
                <ButtonRequest
                    :label="'お問い合わせはこちら'"
                    :submit-button="true"
                    style="
                        width: 100%;
                        max-width: 343px;
                        height: 50px;
                        margin-top: 0px;
                    "
                />
                <ButtonRequest
                    @click="handleBackToDetail"
                    :label="'アカウント削除をキャンセルして、戻る'"
                    style="margin-top: 16px"
                />
                <ButtonRequest
                    :label="'同意して、アカウントを削除する'"
                    style="color: #e71a41; margin-top: 16px"
                    @click="handleOpenDeleteAccountModal"
                />
            </div>
            <Modal
                :show-modal="isOpenDeleteAccount"
                @close="handleCloseDeleteAccountModal"
            >
                <div class="delete-account-modal-container">
                    <div class="delete-account-modal-title">
                        <div>アカウントを削除します。</div>
                    </div>
                    <div class="delete-account-select-form">
                        <SelectForm
                            v-model:selected="form.reason"
                            :label="'理由'"
                            :options="options"
                            :title="'(仮)解除理由を選んだください'"
                        />
                    </div>

                    <div
                        v-if="form.reason === 'その他'"
                        class="delete-account-reason-text mt-4"
                    >
                        <textarea
                            v-model="form.reason_other"
                            rows="4"
                            placeholder="(仮)解除理由を選んだください"
                        />
                    </div>
                    <div class="delete-account-btn d-flex">
                        <ButtonDeleteRequest
                            :label="'キャンセル'"
                            @click="isOpenDeleteAccount = false"
                        />
                        <ButtonDeleteRequest
                            :label="'削除'"
                            :submit-button="true"
                            @click="handleConfirmDelete"
                        />
                    </div>
                </div>
            </Modal>
        </div>
    </div>
    <div v-else>
        <div class="deleted-container d-flex flex-column">
            <img src="" alt="" />
            <div class="deleted-title">
                (仮)
                <span class="deleted-title-right"
                    >アカウント削除を完了しました。</span
                >
            </div>
            <div>
                <div>
                    <div>(仮)ご利用ありがとうございました！</div>
                    <div>あいうえおあいうえおあいうえお</div>
                    <div>あいうえおあいうえおあいうえおあいうえお、</div>
                </div>
                <div class="mt-4">あいうえおあいうえお！</div>
            </div>
            <Link :href="route('top')"
                ><ButtonRequest
                    :label="'RentalHouseのTOPページに移動'"
                    :submit-button="true"
            /></Link>
        </div>
    </div>
</template>
<style scoped lang="scss">
.delete-account-container {
    width: 100%;
    max-width: 400px;
    margin: 0px auto;
    font-family: Noto Sans JP;
    font-size: 12px;
    color: #1b1b1b;
    .delete-account-content {
        padding: 16px;
        line-height: 160%;
        .delete-account-content-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 2px;
        }
    }
    .delete-account-btn {
        text-align: center;
    }
}
.deleted-container {
    width: 100%;
    max-width: 400px;
    margin: 0px auto;
    font-family: Noto Sans JP;
    font-size: 12px;
    color: #1b1b1b;
    gap: 16px;
    text-align: center;
    line-height: 1.6;
    .submit__button {
        background-image: none;
        width: 100%;
        max-width: 343px;
        margin-top: 0px;
    }
    .deleted-title {
        font-size: 16px;
        line-height: 160%;
        letter-spacing: -0.16px;
        .deleted-title-right {
            font-weight: 700;
        }
    }
    img {
        margin-top: 24px;
        width: 400px;
        height: 124px;
    }
}
.delete-account-btn {
    gap: 16px;
}
.delete-account-reason-text {
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
.delete-account-modal-container {
    font-size: 12px;
    font-family: Noto Sans JP;
    .delete-account-modal-title {
        font-size: 16px;
        font-weight: 700;
        line-height: 160%;
        letter-spacing: -0.16px;
        text-align: center;
    }
}
@media all and (max-width: 768px) {
    .delete-account-container,
    .deleted-container {
        img {
            width: 343px;
            margin-top: 16px;
        }
    }
    .delete__account-wrapper {
        padding: 0px 16px;
    }
    :deep(.modal) {
        width: 343px !important;
    }
}
:deep(.modal) {
    padding: 16px !important;
    width: 368px !important;
}

.delete-account-select-form {
    :deep(.request__form-wrap) {
        margin-top: 0;
        width: 100%;
        select {
            padding: 12.5px 10px;
            border-radius: 4px;
            border: 1px solid #e3e3e3;
            margin-top: 8px;
            font-size: 12px;
            height: 44px;
            width: 100%;
        }
        div {
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 19.2px;
            letter-spacing: -0.12px;
            margin-top: 16px;
        }
    }
}
.submit__button {
    margin-top: 16px;
}
</style>
