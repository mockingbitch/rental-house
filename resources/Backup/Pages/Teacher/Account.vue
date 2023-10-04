<script setup>
import { ref } from "vue";
import LayoutDashBoard from "@/Layouts/LayoutDashboard.vue";
import ButtonEditProfile from "@/Components/Account/ButtonEditProfile.vue";
import BaseCardAccountInfo from "@/Components/Account/BaseCardAccountInfo.vue";
import TeacherEditInformation from "@/Components/Account/TeacherEditInformation.vue";
import DeleteAccount from "@/Components/Account/DeleteAccount.vue";
import SubHeader from "@/Components/Common/SubHeader.vue";

const props = defineProps({
    teacher: Object,
    teacherInformation: Object,
    cities: Array,
    countries: Array,
})

let isDisplayForm = ref(false);
let isOpenPopup = ref(false);

const toggleForm = () => {
    isDisplayForm.value = !isDisplayForm.value;
};
const togglePopup = () => {
    isOpenPopup.value = !isOpenPopup.value;
};
</script>
<template>
    <LayoutDashBoard>
        <div
            v-if="! isDisplayForm && ! isOpenPopup"
            class="teacher-account"
        >
            <SubHeader :label="'先生プロフィール設定'" />
            <div class="teacher-account-title d-flex mt-4">
                <span>Teacher Profile Information</span>
            </div>
            <div class="result-content d-flex flex-column">
                <ButtonEditProfile @click="toggleForm" :label="'プロフィールを修正'" />
                <div class="d-flex flex-column align-items-center">
                    <div class="result-content-title">Profile Image</div>
                    <div class="result-content-img">
                        <img :src="props.teacherInformation?.profile_image" alt="profile image" />
                    </div>
                </div>
                <BaseCardAccountInfo
                    :label="`Teacher's Nickname`"
                    :content="props.teacher?.nick_name"
                />
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="'お名前'"
                    :content="props.teacher?.first_name + ' ' + props.teacher?.last_name"
                />
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="'お名前（フリガナ）'"
                    content=""
                />
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="'Birthday'"
                    :content="props.teacher?.year + '/' + props.teacher?.month + '/' + props.teacher?.day"
                />
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="'About me'"
                    :content="props.teacherInformation?.about"
                />
            </div>
            <div
                class="result-content video-preview d-flex flex-column align-items-center"
            >
                <div style="height: 19px">Introduce video</div>
                <div style="width: 263px; height: 146px">
                    <video
                        :src="props.teacherInformation?.introduction_video"
                        controls
                        style="width: 263px; height: 146px"
                    ></video>
                </div>
            </div>
            <!-- <div class="result-content">
                <ButtonEditProfile
                    @click="togglePopup"
                    :label="'銀行情報を修正'"
                />
                <BaseCardAccountInfo
                    :label="'Bank name'"
                    :content="'ABCDEFGあいうえお'"
                />
            </div> -->
            <ul class="note" style="margin-top: 16px">
                <li>・(仮)あいうえおあいうえお、あいうえお。</li>
                <li>
                    ・(仮)アカウント削除のご希望の方は
                    <a @click="togglePopup" class="text-link">こちら</a>
                    から退会が可能となります。投稿したすべての小説が管理できなくなり、ブックマークやフォローリストも削除となります。
                </li>
            </ul>
        </div>
        <TeacherEditInformation
            v-if="isDisplayForm"
            :countries="props.countries"
            :cities="props.cities"
            :user="props.teacher"
            :information="props.teacherInformation"
            @toggle="toggleForm"
        />
        <DeleteAccount
            v-if="isOpenPopup"
            @toggle="togglePopup"
            :user="props.teacher"
        />
    </LayoutDashBoard>
</template>
<style lang="scss" scoped>
.teacher-account {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
    padding: 0 16px;
    font-size: 16px;
    line-height: 19.2px;
    color: #1b1b1b;
    margin-bottom: 261px;
    .teacher-account-title {
        font-size: 16px;
        font-weight: 700;
        padding: 8px 0px;
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
    }
    .teacher-account-line {
        height: 1px;
        align-self: stretch;
        background-color: #e3e3e3;
    }
}

@media screen and (min-width: 720px) {
    .teacher-account {
        padding: 0 0;
    }
    .create__request-button {
        padding: 11px 16px !important;
    }
}

@media screen and (min-width: 768px) {
    .teacher-account {
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
.text-link {
    color: #5392F9 ;
    cursor: pointer;
}
</style>
