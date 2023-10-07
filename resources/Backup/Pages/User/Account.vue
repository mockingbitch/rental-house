<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import ButtonEditProfile from "@/Components/Account/ButtonEditProfile.vue";
import BaseCardAccountInfo from "@/Components/Account/BaseCardAccountInfo.vue";
import ParentInfomation from "@/Components/Account/ParentInfomation.vue";
import LearnerInformation from "@/Components/Account/LearnerInformation.vue";
import Modal from "../../Components/Modal/Modal.vue";
import DeleteAccount from "@/Components/Account/DeleteAccount.vue";
import SubHeader from "../../Components/Common/SubHeader.vue";
import moment from "moment";

const props = defineProps({
    cities: Array,
    countries: Array,
    user: Object,
})
const form = useForm({
    delete_kid: '',
    delete_index: '',
});
const SCREEN = {
    detail: "DETAIL",
    parent_info: " PARENT_INFO",
    learner_info: "LEARNER_INFO",
    delete_account: "DELETE_ACCOUNT",
};
const showDeleteDialog = ref(false);
const displayStatus = ref({
    screen: SCREEN.detail,
    account: "",
});
const learnerFormRef = ref(null);
const learnerData = ref([...props.user.kids]);

const handleEditProfile = (screen, account) => {
    displayStatus.value.screen = screen;
    displayStatus.value.account = account;
    window.scrollTo(0, 0);
};
const toggleDeleteModal = (kid, index) => {
    showDeleteDialog.value = !showDeleteDialog.value;
    form.delete_kid = kid;
    form.delete_index = index;
};
const handleUpdateParent = (formValue) => {
    formValue.post(route("parent.update"), {
        onSuccess: (e) => {
            window.location.reload();
        },
    });
};
const handleAddNewLearner = () => {
    const newDataLearner = {
        id: null,
        year: "",
        month: "",
        day: "",
        interest: "",
        nick_name: "",
        first_name: "",
        last_name: "",
    };
    learnerData.value.push(newDataLearner);
};
const onDeleteLearner = (id, index) => {
    if (id) {
        form.post(route("kid.delete"), {
            onSuccess: (e) => {
                window.location.reload();
            },
        });
    } else {
        window.location.reload();
    }
};
const handleBackToDetail = () => {
    displayStatus.value.screen = SCREEN.detail;
    displayStatus.value.id = "";
};
const listCategories = (categories) => {
    let listCategories = []
    for (let i = 0; i < categories.length; i++) {
        listCategories.push(categories[i].category.name_jp)
    }

    return listCategories.join(', ')
}
</script>
<template>
    <Layout>
        <div v-if="displayStatus.screen === SCREEN.detail" class="user-account">
            <SubHeader :label="'プロフィール設定'" :isClose="handleBackToDetail" href="top"/>
            <div class="user__account-content">
                <div class="user-account-title d-flex">
                    <p>Parent Information</p>
                </div>
                <div class="result-content d-flex flex-column">
                    <ButtonEditProfile
                        :label="'プロフィールを修正'"
                        @click="handleEditProfile(SCREEN.parent_info, props.user)"
                    />
                    <BaseCardAccountInfo
                        :label="'Residential Country'"
                        :content="props.user?.country?.name_jp ? props.user?.country?.name_jp : 'ー'"
                    />
                    <div class="user-account-line"></div>
                    <BaseCardAccountInfo
                        :label="'Residential City'"
                        :content="props.user?.city?.name_jp ? props.user?.city?.name_jp : 'ー'"
                    />
                    <div class="user-account-line"></div>
                    <BaseCardAccountInfo
                        :label="'Adult Nickname'"
                        :content="props.user?.nick_name ? props.user?.nick_name : 'ー'"
                    />
                    <div class="user-account-line"></div>
                    <BaseCardAccountInfo
                        :label="'お名前'"
                        :content="(props.user?.first_name && props.user?.last_name) ? (props.user?.first_name +' '+ props.user?.last_name) : 'ー'"
                    />
                    <div class="user-account-line"></div>
                    <BaseCardAccountInfo
                        :label="'お名前（フリガナ）'"
                        :content="(props.user?.first_name_kana && props.user?.last_name_kana) ? (props.user?.first_name_kana +' '+ props.user?.last_name_kana) : 'ー'"
                    />
                    <div class="user-account-line"></div>
                    <BaseCardAccountInfo
                        :label="'email'"
                        :content="props.user?.email ? props.user?.email : 'ー'"
                    />
                    <div class="user-account-line"></div>
                    <BaseCardAccountInfo
                        :label="'Birthday'"
                        :content="props.user?.birthday ? moment(props.user?.birthday).format('YYYY / MM / DD') : 'YYYY / MM / DD'"
                    />
                    <div class="user-account-line"></div>
                    <BaseCardAccountInfo
                        :label="'Interests Category'"
                        :content="props.user?.category ? listCategories(props.user?.category) : 'ー'"
                    />
                </div>
                <div class="user-account-title d-flex mt-8">
                    <p>Learner Information</p>
                </div>
                <div
                    v-for="(kid, index) in learnerData"
                    :key="index"
                    class="result-content d-flex flex-column"
                >
                    <div
                        class="d-flex align-items-center justify-content-center result-content-btn"
                    >
                        <ButtonEditProfile
                            :label="'プロフィールを修正'"
                            @click="handleEditProfile(SCREEN.learner_info, kid)"
                        />

                        <div
                            class="result-content-btn-close"
                            @click="toggleDeleteModal(kid, index)"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                            >
                                <path
                                    d="M16.0672 15.1832C16.1252 15.2412 16.1713 15.3102 16.2027 15.386C16.2342 15.4619 16.2503 15.5432 16.2503 15.6253C16.2503 15.7075 16.2342 15.7888 16.2027 15.8647C16.1713 15.9405 16.1252 16.0095 16.0672 16.0675C16.0091 16.1256 15.9402 16.1717 15.8643 16.2031C15.7884 16.2345 15.7071 16.2507 15.625 16.2507C15.5429 16.2507 15.4615 16.2345 15.3857 16.2031C15.3098 16.1717 15.2409 16.1256 15.1828 16.0675L9.99998 10.8839L4.81717 16.0675C4.69989 16.1848 4.54083 16.2507 4.37498 16.2507C4.20913 16.2507 4.05007 16.1848 3.93279 16.0675C3.81552 15.9503 3.74963 15.7912 3.74963 15.6253C3.74963 15.4595 3.81552 15.3004 3.93279 15.1832L9.11639 10.0003L3.93279 4.81753C3.81552 4.70026 3.74963 4.5412 3.74963 4.37535C3.74963 4.2095 3.81552 4.05044 3.93279 3.93316C4.05007 3.81588 4.20913 3.75 4.37498 3.75C4.54083 3.75 4.69989 3.81588 4.81717 3.93316L9.99998 9.11675L15.1828 3.93316C15.3001 3.81588 15.4591 3.75 15.625 3.75C15.7908 3.75 15.9499 3.81588 16.0672 3.93316C16.1844 4.05044 16.2503 4.2095 16.2503 4.37535C16.2503 4.5412 16.1844 4.70026 16.0672 4.81753L10.8836 10.0003L16.0672 15.1832Z"
                                    fill="#E71A41"
                                />
                            </svg>
                        </div>
                    </div>

                    <BaseCardAccountInfo
                        :label="'Kid’s Nickname'"
                        :content="kid.nick_name || 'ー'"
                    />
                    <div class="user-account-line"></div>
                    <BaseCardAccountInfo
                        :label="'Kid’s Name'"
                        :content="kid.first_name && kid.last_name ? `${kid.first_name} ${kid.last_name}` : 'ー'"
                    />
                    <div class="user-account-line"></div>
                    <BaseCardAccountInfo
                        :label="'Birthday'"
                        :content="kid.origin_birthday ? moment(kid.origin_birthday).format('YYYY / MM / DD') : 'YYYY / MM / DD'"
                    />
                    <div class="user-account-line"></div>
                    <BaseCardAccountInfo
                        :label="'Interests Category'"
                        :content="kid.category ? listCategories(kid.category) : 'ー'"
                    />
                </div>
                <button
                    class="d-flex align-items-center justify-content-center user-account-btn"
                    @click="handleAddNewLearner"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="25"
                        height="24"
                        viewBox="0 0 25 24"
                        fill="none"
                    >
                        <path
                            d="M21.5 12C21.5 12.1989 21.421 12.3897 21.2803 12.5303C21.1397 12.671 20.9489 12.75 20.75 12.75H13.25V20.25C13.25 20.4489 13.171 20.6397 13.0303 20.7803C12.8897 20.921 12.6989 21 12.5 21C12.3011 21 12.1103 20.921 11.9697 20.7803C11.829 20.6397 11.75 20.4489 11.75 20.25V12.75H4.25C4.05109 12.75 3.86032 12.671 3.71967 12.5303C3.57902 12.3897 3.5 12.1989 3.5 12C3.5 11.8011 3.57902 11.6103 3.71967 11.4697C3.86032 11.329 4.05109 11.25 4.25 11.25H11.75V3.75C11.75 3.55109 11.829 3.36032 11.9697 3.21967C12.1103 3.07902 12.3011 3 12.5 3C12.6989 3 12.8897 3.07902 13.0303 3.21967C13.171 3.36032 13.25 3.55109 13.25 3.75V11.25H20.75C20.9489 11.25 21.1397 11.329 21.2803 11.4697C21.421 11.6103 21.5 11.8011 21.5 12Z"
                            fill="#1B1B1B"
                        />
                    </svg>
                    <div>Another Kids</div>
                </button>
                <ul class="note d-flex flex-column" style="margin-top: 16px">
                    <li>・(仮)あいうえおあいうえお、あいうえお。</li>
                    <li>
                        ・(仮)アカウント削除のご希望の方は<span
                            class="note-link"
                            @click="handleEditProfile(SCREEN.delete_account)"
                            >こちら</span
                        >から退会が可能となります。投稿したすべての小説が管理できなくなり、ブックマークやフォローリストも削除となります。
                    </li>
                </ul>
            </div>
        </div>
        <ParentInfomation
            v-if="displayStatus.screen === SCREEN.parent_info"
            :countries="props.countries"
            :account="displayStatus.account"
            :cities="props.cities"
            @backToDetail="handleBackToDetail"
            @submitFormParent="handleUpdateParent"
        />
        <LearnerInformation
            v-if="displayStatus.screen === SCREEN.learner_info"
            :account="displayStatus.account"
            @delete="toggleDeleteModal"
            @backToDetail="handleBackToDetail"
            @submitFormLearner="handleUpdateLearner"
        />
        <DeleteAccount
            v-if="displayStatus.screen === SCREEN.delete_account"
            @toggle="handleBackToDetail"
            :user="props.user"
        />
        <Modal :show-modal="showDeleteDialog" @close="toggleDeleteModal">
            <div class="modal__wrapper d-flex flex-column">
                <div class="modal__title-wrapper">
                    <h2 class="modal__title-text">子供情報を削除します。</h2>
                </div>
                <div class="modal__info-wrapper">
                    <div class="modal__info-name">
                        <span>{{ form.delete_kid.first_name +' '+ form.delete_kid.last_name}}</span>
                    </div>
                    <div class="modal__noti-wrapper">
                        <p style="height: 66px">
                            (仮)削除すると復元ができません。<br />
                            本当によろしいですか？ <br />
                            などなどなどなど
                        </p>
                    </div>
                    <div class="modal__warning-wrapper">
                        <span>※注意点注意点注意点注意点注意点注意点</span>
                    </div>
                </div>
                <div class="modal__btn-wrapper d-flex">
                    <button class="cancel-btn" @click="toggleDeleteModal">
                        キャンセル
                    </button>
                    <button class="submit-btn" @click="onDeleteLearner(form.delete_kid.id, form.delete_index)">
                        削除
                    </button>
                </div>
            </div>
        </Modal>
    </Layout>
</template>
<style lang="scss" scoped>
@import "../../../../public/scss/imports/core/variables";
@import "../../../../public/scss/imports/core/mixins";
.user-account {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
    font-size: 16px;
    line-height: 19.2px;
    color: #1b1b1b;
    .user-account-title {
        padding: 8px 0px;

        p {
            height: 26px;
            font-size: 16px;
            font-weight: 700;
            line-height: 160%;
            letter-spacing: -0.16px;
        }
    }
    &-header {
        position: relative;
        padding-top: 28.5px;
        &-content {
            font-size: 18px;
            font-weight: bold;
        }
        img {
            position: absolute;
            left: 0;
            cursor: pointer;
        }
    }

    .create__request-button {
        display: flex;
        flex-direction: row;
        gap: 16px;
        width: 100%;
        justify-content: center;
        align-items: center;
        padding: 11px 0px;
    }
    .note {
        gap: 8px;
        color: #7f7f7f;
        .note-link {
            text-decoration: underline;
            cursor: pointer;
        }
    }
    @media screen and (max-width: 720px) {
        .button-container {
            position: fixed;
            bottom: 0;
            background-color: white;
            width: 100%;
        }
        .create__request-button {
            max-width: 368px;
            position: relative;
            .lineFull {
                top: 0;
            }
        }
    }
    @media screen and (max-width: 400px) {
        .create__request-button {
            max-width: 91%;
        }
    }
    .create__request-button-left {
        width: 100px;
        max-width: 40%;
        font-size: 14px;
        font-family: "Noto Sans JP";
        line-height: 22.4px;
        letter-spacing: -0.14px;
        white-space: nowrap;
        color: #5392F9  !important;
    }
    .create__request-button-right {
        font-size: 14px;
        min-width: 227px;
        flex: 1;
    }

    //css show result
    .result-content {
        padding: 16px;
        background-color: #f4f4f4;
        border-radius: 8px;
        margin-bottom: 8px;
        gap: 10px;
        &-title {
            height: 16px;
            margin-bottom: 6.5px;
        }
        &-img {
            img {
                width: 90px;
                height: 90px;
                border-radius: 100px;
                background-color: pink;
            }
        }
        .result-content-btn {
            gap: 16px;
            .result-content-btn-close {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 15px 16px;
                cursor: pointer;
            }
        }
    }
    .user-account-line {
        height: 1px;
        align-self: stretch;
        background-color: #e3e3e3;
    }
    .user-account-btn {
        height: 50px;
        width: 100%;
        gap: 4px;
        border: none;
        border-radius: 4px;
        background-color: #f4f4f4;
        cursor: pointer;
        font-family: Noto Sans JP;
        font-size: 14px;
    }
}

.note {
    color: #7f7f7f;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: 160%; /* 19.2px */
}

.modal__wrapper {
    align-items: center;
}
.modal__title-wrapper {
    width: 368px;
    display: flex;
    justify-content: center;

    @include mobile {
        width: 310px;
    }

    .modal__title-text {
        width: 173px;
        height: 26px;
        color: #1b1b1b;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: 160%; /* 25.6px */
        letter-spacing: -0.16px;
    }
}

.modal__info-wrapper {
    width: 275px;
    margin: 16px 0;

    .modal__info-name {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 38px;
        padding: 8px 0px;
        border-radius: 4px;
        opacity: 0.8;
        background: #f4f4f4;

        span {
            color: #1b1b1b;
            text-align: center;
            font-size: 14px;
            font-style: normal;
            font-weight: 700;
            line-height: 160%; /* 22.4px */
            letter-spacing: -0.14px;
        }
    }
    .modal__noti-wrapper {
        display: flex;
        justify-content: center;
        margin: 16px 0;

        p {
            color: #1b1b1b;
            text-align: center;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 160%; /* 22.4px */
            letter-spacing: -0.14px;
        }
    }
    .modal__warning-wrapper {
        height: 22px;
        width: fit-content;

        span {
            color: #e71a41;
            text-align: center;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 160%; /* 22.4px */
            letter-spacing: -0.14px;
        }
    }
}

.modal__btn-wrapper {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 16px;

    button {
        flex: 1;
        height: 50px;
        border-radius: 4px;

        & + & {
            margin-left: 16px;
        }
    }

    .cancel-btn {
        background-color: transparent;
        border: 1px solid #1b1b1b;
        color: #1b1b1b;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 160%; /* 22.4px */
        letter-spacing: -0.14px;
    }
    .submit-btn {
        color: #fff;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 160%; /* 22.4px */
        letter-spacing: -0.14px;
        background: #e71a41;
        border: 1px solid #e71a41;
    }

    .cancel-btn,
    .submit-btn {
        &:hover {
            cursor: pointer;
        }
    }
}

.user__account-content {
    padding-top: 16px;

    @include mobile {
        padding: 16px 16px 0px 16px;
    }
}

@media screen and (min-width: 720px) {
    .user-account {
        padding: 0 0;
    }
    .create__request-button {
        padding: 11px 16px !important;
    }
}

@media screen and (min-width: 768px) {
    .user-account {
        padding: 0 0;
    }
    .image-header {
        display: flex;
        justify-content: center;
        img {
            width: 400px !important;
        }
    }
}

// css đè css global
.form__wrap-item {
    label {
        gap: 2px;
        padding-bottom: 6.5px;
        color: #1b1b1b;
    }
    input {
        padding: 12.5px 10px;
        margin-bottom: 0;
    }
    input:focus-visible {
        outline: #1b1b1b auto 1px !important;
    }
    .video-note {
        font-size: 10px;
    }
}

//css pop up
:deep(.modal) {
    width: 400px;
    padding: 24px 20px 20px;
    border-radius: 10px;
}

:deep(.pop-up) {
    width: 360px;
    video,
    img {
        width: 100%;
        height: 146px;
    }
}

:deep(#form-wrap-double .file-change) {
    padding: 8px 0;
    margin: 0;
    max-width: 100%;
    height: 50px;
    border-radius: 4px;
}

:deep(.popup-text) {
    height: 50px;
    font-size: 14px;
    max-width: 100%;
    align-items: center;
    display: flex;
    justify-content: center;
}

:deep(.form__wrap-item .close-pop-up) {
    max-width: 100%;
    height: 50px;
}

@media screen and (max-width: 768px) {
    :deep(.modal) {
        width: 303px;
    }
    :deep(.pop-up) {
        width: 263px !important;
    }
}

:deep(.file-name span) {
    width: 100%;
    text-align: center;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
}
</style>
