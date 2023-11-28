<!-- <script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
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

const formattedPhoneNumber = computed(() => {
    const phone = props.teacherInformation?.phone || "";
    const phoneNumberString = phone.toString();
    const length = phoneNumberString.length;

    if (length === 9) {
        return `${phoneNumberString.slice(0, 2)}-${phoneNumberString.slice(
            2,
            5
        )}-${phoneNumberString.slice(5)}`;
    } else if (length === 10) {
        return `${phoneNumberString.slice(0, 2)}-${phoneNumberString.slice(
            2,
            6
        )}-${phoneNumberString.slice(6)}`;
    } else if (length === 11) {
        return `${phoneNumberString.slice(0, 3)}-${phoneNumberString.slice(
            3,
            7
        )}-${phoneNumberString.slice(7)}`;
    } else {
        return phoneNumberString;
    }
});

const jobs = [
    "公務員",
    "経営者・役員　",
    "会社員",
    "自営業",
    "自由業",
    "専業主婦",
    "パート・アルバイト",
    "学生",
    "その他",
];
const salaries = [
    "100万円以下",
    "100万円～195万以下",
    "195万円～330万円以下",
    "330万円～695万円以下",
    "695万円～900万円以下",
    "900万円～1800万円以下",
    "1800万円～4000万円以下",
    "4000万円超",
];

const isMobileScreen = computed(() => {
    return windowWidth.value <= 767;
});

const windowWidth = ref(window.innerWidth);
const handleResize = () => {
    windowWidth.value = window.innerWidth;
    isMobileScreen.value = windowWidth.value <= 767;
};
onMounted(() => {
    window.addEventListener("resize", handleResize);
});

onBeforeUnmount(() => {
    window.removeEventListener("resize", handleResize);
});
</script>
<template>
    <LayoutDashBoard isHideFooterSp>
        <div
            v-if="! isDisplayForm && ! isOpenPopup"
            class="teacher-account"
        >
            <SubHeader v-if="!isMobileScreen" :label="lang().label.user_account.label.setting_profile" :is-close="true" href="teacher.dashboard" />
            <SubHeader v-else :label="lang().label.teacher_profile_setting.label.setting_profile" href="user.menu" />
            <div class="teacher-account-title d-flex mt-4">
                <span>{{ lang().label.teacher_profile_setting.label.infomation }}</span>
            </div>
            <div class="result-content d-flex flex-column">
                <ButtonEditProfile @click="toggleForm" :label="'プロフィールを修正'" />
                <div class="d-flex flex-column align-items-center">
                    <div class="result-content-title">{{ lang().label.teacher_profile_setting.label.profile_image }}</div>
                    <div class="result-content-img">
                        <img :src="props.teacherInformation?.profile_image" alt="profile image" />
                    </div>
                </div>
                <BaseCardAccountInfo
                    :label="lang().label.teacher_profile_setting.label.teacher_nickname"
                    :content="props.teacher?.nick_name"
                />
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="lang().label.teacher_profile_setting.label.teacher_name"
                    :content="props.teacher?.first_name + ' ' + props.teacher?.last_name"
                />
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="lang().label.teacher_profile_setting.label.teacher_name_jp"
                    :content="props.teacher?.first_name_kana + ' ' + props.teacher?.last_name_kana"
                />
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="lang().label.teacher_profile_setting.label.birthday"
                    :content="props.teacher?.year + '/' + props.teacher?.month + '/' + props.teacher?.day"
                />
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="lang().label.teacher_profile_setting.label.email"
                    :content="props.teacher?.email"
                />
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="lang().label.teacher_profile_setting.label.phone"
                    :content="
                        '+'
                        + props.teacherInformation?.country_code
                            ?.split('+')[1]
                            ?.trim()
                        + ' '
                        + formattedPhoneNumber
                    "
                />
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="lang().label.teacher_profile_setting.label.job"
                    :content="jobs[props.teacherInformation?.job - 1]"
                />
                <BaseCardAccountInfo
                    :label="lang().label.teacher_profile_setting.label.salary"
                    :content="salaries[props.teacherInformation?.salary - 1]"
                />
                <div>
                    <div>{{ lang().label.teacher_profile_setting.label.headline_of_teacher }}</div>
                    <div class="d-flex chips-wrap">
                        <div v-for="(tag, index) in JSON.parse(props.teacherInformation?.headline)" :key="index">
                            <div>{{ tag }}<span v-if="index !== JSON.parse(props.teacherInformation?.headline).length - 1">,</span></div>
                        </div>
                    </div>
                    
                </div>
                <div class="teacher-account-line"></div>
                <BaseCardAccountInfo
                    :label="lang().label.teacher_profile_setting.label.about_me"
                    :content="props.teacherInformation?.about"
                />
            </div>
            <div
                class="result-content video-preview d-flex flex-column align-items-center"
            >
                <div style="height: 19px">{{ lang().label.teacher_profile_setting.label.introduction_video }}</div>
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
                    {{ lang().label.teacher_profile_setting.label.text_link1 }}
                    <a @click="togglePopup" class="text-link">{{ lang().label.teacher_profile_setting.label.text_link2 }}</a>
                    {{ lang().label.teacher_profile_setting.label.text_link3 }}
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
    font-size: 12px;
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
        color: #418997 !important;
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
    color: #418997;
    cursor: pointer;
}
.chips-wrap {
    font-size: 14px; 
    font-weight: 700; 
    margin-top: 6.5px; 
    flex-wrap: wrap;
}
</style> -->
