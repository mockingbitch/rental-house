<template>
    <Layout
        :show-result-step="1"
        :title="lang().label.onboarding.label.setting_account"
        @handle-click="handleClickFunction()"
    >
        <Breadcrumb
            :items="breadcrumbItems"
            @handleClick="handleBreadcrumbClick"
        />
        <div class="step-container">
            <div
                class="step-container-header d-flex align-items-center justify-content-center"
            >
                <img
                    src="/img/icon/arrownLeft.svg"
                    alt=""
                    @click="handleClickFunction()"
                />
                <span class="step-container-header-content"
                    >{{ lang().label.onboarding.label.setting_account }}</span
                >
            </div>
            <div class="step-container-title d-flex justify-content-center">
                <span v-if="props.showButtonConfirm !== 2"
                    >申請内容をご確認お願いします。</span
                >
                <span v-else style="color: #418997"
                    >{{ lang().label.onboarding.label.setting_account_title }}</span
                >
            </div>

            <div
                class="result-content d-flex flex-column align-items-center"
                style="height: 146px"
            >
                <div class="result-content-title">{{ lang().label.onboarding.label.upload_image }}</div>
                <div class="result-content-img">
                    <img :src="props.dataStep1?.profile_image_preview || props.dataStep1?.profile_image" alt="" />
                </div>
            </div>
            <div
                class="result-content video-preview d-flex flex-column align-items-center"
                style="height: 202px"
                v-if="props.dataStep1?.childVidPreview"
            >
                <div style="height: 19px">{{ lang().label.onboarding.confirm.introduce_video }}</div>
                <div style="width: 263px; height: 146px">
                    <video
                        :src="props.dataStep1?.childVidPreview"
                        controls
                        style="width: 263px; height: 146px"
                    ></video>
                </div>
            </div>
            <div class="result-content">
                <div class="result-content-group first-content">
                    <div class="title-content">{{ lang().label.onboarding.confirm.name }}</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.first_name }}
                        {{ props.dataStep1?.last_name }}
                    </div>
                </div>
                <div v-if="props.dataStep1?.country_id == 1" class="result-content-group">
                    <div class="title-content">{{ lang().label.onboarding.confirm.nameKana }}</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.first_name_kana }}
                        {{ props.dataStep1?.last_name_kana }}
                    </div>
                </div>
                <div class="result-content-group">
                    <div class="title-content">{{ lang().label.onboarding.label.user_country }}</div>
                    <div class="filled-content">
                        {{
                            props.countries[props.dataStep1?.country_id - 1]
                                ?.name_jp
                        }}
                        {{ props.cities[props.dataStep1.city_id - 1]?.name_jp }}
                    </div>
                </div>
                <div class="result-content-group last-content">
                    <div class="title-content">{{ lang().label.onboarding.confirm.birth_day }}</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.year }}/{{
                            props.dataStep1?.month
                        }}/{{ props.dataStep1?.day }}
                    </div>
                </div>
            </div>
            <div class="result-content">
                <div class="result-content-group first-content">
                    <div class="title-content">{{ lang().label.onboarding.label.user_email }}</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.email }}
                    </div>
                </div>
                <div class="result-content-group last-content">
                    <div class="title-content">{{ lang().label.onboarding.label.user_phone_number }}</div>
                    <div class="filled-content">
                        ({{
                            "+" +
                            props.dataStep1?.country_code
                                ?.split("+")[1]
                                ?.trim()
                        }})

                        {{ formattedPhoneNumber }}
                    </div>
                </div>
            </div>
            <div class="result-content">
                <div class="result-content-group first-content">
                    <div class="title-content">{{ lang().label.onboarding.label.user_job }}</div>
                    <div class="filled-content">
                        {{ jobs[props.dataStep1?.job - 1] }}
                    </div>
                </div>
                <div class="result-content-group">
                    <div class="title-content">{{ lang().label.onboarding.label.user_salary }}</div>
                    <div class="filled-content">
                        {{ salaries[props.dataStep1?.salary - 1] }}
                    </div>
                </div>
                <div class="result-content-group">
                    <div class="title-content">{{ lang().label.onboarding.label.user_headline }}</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.headline }}
                    </div>
                </div>
                <div class="result-content-group last-content">
                    <div class="title-content">{{ lang().label.onboarding.label.user_about_me }}</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.about }}
                    </div>
                </div>
            </div>
            <!-- <div class="result-content">
                <div class="result-content-group first-content">
                    <div>Bank Name</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.bank_name }}
                    </div>
                </div>
                <div class="result-content-group">
                    <div>Branch Code</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.branch_code }}
                    </div>
                </div>
                <div class="result-content-group">
                    <div>Account Type</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.account_type }}
                    </div>
                </div>
                <div class="result-content-group">
                    <div>Account Number</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.account_number }}
                    </div>
                </div>
                <div class="result-content-group last-content">
                    <div>Account Name</div>
                    <div class="filled-content">
                        {{ props.dataStep1?.account_name }}
                    </div>
                </div>
            </div> -->

            <ul class="note" style="margin-top: 16px">
                <li>・(仮)申請から承認までn日ほどかかります。</li>
                <li>・(仮)申請の後、やり直しはできません。</li>
            </ul>
            <div class="button-container">
                <div
                    class="create__request-button"
                    v-if="props.showButtonConfirm !== 2"
                >
                    <div class="lineFull"></div>
                    <ButtonRequest
                        :label="'戻る'"
                        :submit-button="false"
                        class="create__request-button-left"
                        @click="backToOnBoard"
                    />
                    <ButtonRequest
                        :label="'申請する'"
                        :submit-button="true"
                        class="create__request-button-right"
                        @click="confirmStep1"
                    />
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import Layout from "@/Layouts/Layout.vue";
import ButtonRequest from "@/Components/Request/ButtonRequest.vue";
import Breadcrumb from "../Breadcrumb.vue";

const props = defineProps({
    dataStep1: Object,
    cities: Array,
    countries: Array,
    showButtonConfirm: Number,
});

const breadcrumbItems =
    props.showButtonConfirm !== 2
        ? [
            { text: "Dashboard", isLink: true },
            { text: usePage().props.language.original.label.onboarding.label.setting_account, isLink: true },
            { text: "最終確認", isLink: false },
        ]
        : [
            { text: "Dashboard", isLink: true },
            { text: usePage().props.language.original.label.onboarding.label.setting_account, isLink: false },
        ];
const emits = defineEmits();
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

const form = useForm({
    step: 1,
    uploadImageValidate: "",
    childVidPreview: props.dataStep1?.childVidPreview || "",
    childVidName: props.dataStep1?.childVidName || "",
    short_video_for_learner_thumbnail:
        props.dataStep1?.short_video_for_learner_thumbnail || "",
    short_video_for_learner: props.dataStep1?.short_video_for_learner || "",
    profile_image: props.dataStep1?.profile_image || "",
    profile_image_preview: props.dataStep1?.profile_image_preview || "",
    first_name: props.dataStep1?.first_name || "",
    last_name: props.dataStep1?.last_name || "",
    first_name_kana: props.dataStep1?.first_name_kana || "",
    last_name_kana: props.dataStep1?.last_name_kana || "",
    country_id: props.dataStep1?.country_id || "",
    city_id: props.dataStep1?.city_id || "",
    year: props.dataStep1?.year || "",
    month: props.dataStep1?.month || "",
    day: props.dataStep1?.day || "",
    email: props.dataStep1?.email || "",
    country_code: props.dataStep1?.country_code || "",
    phone: props.dataStep1?.phone || "",
    job: props.dataStep1?.job || null,
    salary: props.dataStep1?.salary || null,
    headline: props.dataStep1?.headline || "",
    about: props.dataStep1?.about || "",
});

const formattedPhoneNumber = computed(() => {
    const phone = props.dataStep1?.phone || "";
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

const backToOnBoard = () => {
    emits("back-to-onboarding");
    emits("save-data", props.dataStep1);
};
const confirmStep1 = () => {
    form.post(route("onboarding.confirm.step1"), {
        onFinish: () => {
            if (
                Object.keys(form.errors).length === 0 &&
                form.errors.constructor === Object
            ) {
                emits("confirm-step1", props.dataStep1);
            }
        },
        onError: console.log("error"),
    });
};
const BackToOnboarding = () => {
    emits("move-to-onboarding");
};
const handleClickFunction = () => {
    if (props.showButtonConfirm !== 2) {
        backToOnBoard();
    } else {
        BackToOnboarding();
    }
};

const handleBreadcrumbClick = (item) => {
    if (item.isLink === true && props.showButtonConfirm !== 2) {
        if (item.text === usePage().props.language.original.label.onboarding.label.setting_account) {
            backToOnBoard();
        }
    }
    if (item.text === "Dashboard") {
        BackToOnboarding();
    }
};
</script>

<style lang="scss" scoped>
@import "../BecomeTeacher/Step";
</style>
