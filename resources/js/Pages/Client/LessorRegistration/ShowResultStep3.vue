<template>
    <LayoutOnBoarding
        :show-result-step="3"
        :title="'学歴・経歴登録'"
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
                    @click="backToOnBoard"
                />
                <span class="step-container-header-content"
                    >学歴・経歴登録</span
                >
            </div>
            <div class="step-container-title">Final Education Background</div>
            <div
                v-for="(education, index) in props.dataStep3?.final_educations"
                :key="index"
            >
                <div
                    class="result-content d-flex flex-column align-items-center"
                >
                    <div>Academic Certificate</div>
                    <div>
                        <img
                            :src="props.saveDataImageStep3?.imagePreview[index]"
                            alt=""
                            style="width: 263px; height: 146px"
                        />
                    </div>
                </div>
                <div class="result-content">
                    <div class="result-content-group first-content">
                        <div class="title-content">学校</div>
                        <div class="filled-content">
                            {{ education?.school || "入力なし" }}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">学位および学部</div>
                        <div class="filled-content">
                            {{ education?.major || "入力なし" }}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">専攻または学科</div>
                        <div class="filled-content">
                            {{ education?.major_specialize || "入力なし" }}
                        </div>
                    </div>
                    <div
                        class="result-content-group"
                        v-if="
                            education?.admission_year &&
                            education?.admission_month
                        "
                    >
                        <div class="title-content">開始日</div>
                        <div class="filled-content">
                            {{ education?.admission_year }}/{{
                                education?.admission_month
                            }}
                        </div>
                    </div>
                    <div
                        class="result-content-group last-content"
                        v-if="
                            education?.graduation_year &&
                            education?.graduation_month
                        "
                    >
                        <div class="title-content">終了日（卒業予定）</div>
                        <div class="filled-content">
                            {{ education?.graduation_year }}/{{
                                education?.graduation_month
                            }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="step-container-title" style="margin-top: 56px">
                Work History
            </div>
            <div
                class="result-content"
                v-for="(history, index) in props.dataStep3?.work_histories"
                :key="index"
            >
                <div class="result-content-group first-content">
                    <div class="title-content">役職/ポジション/担当業務</div>
                    <div class="filled-content">
                        {{ history.work_position }}
                    </div>
                </div>
                <div class="result-content-group">
                    <div class="title-content">雇用形態</div>
                    <div class="filled-content">
                        {{ recruitmentForm[history.recruitment_form - 1] }}
                    </div>
                </div>
                <div class="result-content-group">
                    <div class="title-content">会社名</div>
                    <div class="filled-content">{{ history.company }}</div>
                </div>
                <div class="result-content-group last-content">
                    <div class="title-content">開始日</div>
                    <div class="filled-content">
                        {{ history.work_start_year }}/{{
                            history.work_start_month
                        }}
                    </div>
                    <div v-if="history.is_still_working">
                        現在、このポジションで働いています。
                    </div>
                </div>
                <div
                    class="result-content-group last-content"
                    v-if="history.work_end_year && history.work_end_month"
                >
                    <div class="title-content">開始日</div>
                    <div class="filled-content">
                        {{ history.work_end_year }}/{{ history.work_end_month }}
                    </div>
                </div>
            </div>
            <div class="button-container">
                <div class="create__request-button">
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
                        @click="confirmStep3"
                    />
                </div>
            </div>
        </div>
    </LayoutOnBoarding>
</template>

<script setup>
// import LayoutOnBoarding from "@/Layouts/LayoutOnBoarding.vue";
// import ButtonRequest from "@/Components/Request/ButtonRequest.vue";
import { defineProps, defineEmits } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Breadcrumb from "../Breadcrumb.vue";

const props = defineProps({
    dataTeacher: Object,
    dataStep3: Object,
    showButtonConfirm: Number,
    saveDataImageStep3: Object,
});
const breadcrumbItems = [
    { text: "Dashboard", isLink: true },
    { text: "学歴・経歴登録", isLink: true },
    { text: "最終確認", isLink: false },
];
const form = useForm({
    step: 3,
    // school: props.dataTeacher?.school || props.dataStep3?.school || "",
    // major: props.dataTeacher?.major || props.dataStep3?.major || "",
    // major_specialize:
    //     props.dataTeacher?.major_specialize ||
    //     props.dataStep3?.major_specialize ||
    //     "",
    // admission_year:
    //     props.dataTeacher?.admission_year ||
    //     props.dataStep3?.admission_year ||
    //     "",
    // admission_month:
    //     props.dataTeacher?.admission_month ||
    //     props.dataStep3?.admission_month ||
    //     "",
    // graduation_year:
    //     props.dataTeacher?.graduation_year ||
    //     props.dataStep3?.graduation_year ||
    //     "",
    // graduation_month:
    //     props.dataTeacher?.graduation_month ||
    //     props.dataStep3?.graduation_month ||
    //     "",
    // academic_certificate: props.dataTeacher?.academic_certificate || "",
    final_educations: props.dataStep3.final_educations || [
        {
            school: "",
            major: "",
            major_specialize: "",
            admission_year: "",
            admission_month: "",
            graduation_year: "",
            graduation_month: "",
            academic_certificate: "",
        },
    ],
    work_histories: props.dataTeacher?.work_histories ||
        props.dataStep3?.work_histories || [
            {
                work_position: "",
                recruitment_form: "",
                company: "",
                work_start_year: "",
                work_start_month: "",
                work_end_year: "",
                work_end_month: "",
                is_still_working: true,
            },
        ],
});
const recruitmentForm = [
    "正社員",
    "契約社員",
    "パート・アルバイト",
    "派遣社員",
    "業務委託",
];
const emits = defineEmits();
const backToOnBoard = () => {
    emits("back-to-onboarding");
    emits("save-data", props.dataStep3);
    emits("save-data-image", props.saveDataImageStep3);
};
const confirmStep3 = () => {
    form.post(route("onboarding.create.step3"), {
        onSuccess: () => {
            if (
                Object.keys(form.errors).length === 0 &&
                form.errors.constructor === Object
            ) {
                emits("confirm-step3", props.dataStep3);
            }
        },
        onError: console.log("error"),
    });
};

const BackToOnboarding = () => {
    emits("move-to-onboarding");
};
const handleBreadcrumbClick = (item) => {
    if (item.isLink === true) {
        if (item.text === "学歴・経歴登録") {
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
