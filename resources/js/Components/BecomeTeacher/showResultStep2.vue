<template>
    <LayoutOnBoarding
        :show-result-step="2"
        :title="'本人確認'"
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
                <span class="step-container-header-content">本人確認</span>
            </div>
            <div class="step-container-title d-flex justify-content-center">
                申請内容をご確認お願いします。
            </div>
            <div class="result-content d-flex flex-column align-items-center">
                <div>書類イメージ1</div>
                <div>
                    <img
                        src="../../../../public/img/icon/ApplyToTeacher/IDCard1.svg"
                        alt=""
                    />
                </div>
            </div>
            <div class="result-content d-flex flex-column align-items-center">
                <div>書類イメージ2</div>
                <div>
                    <img
                        src="../../../../public/img/icon/ApplyToTeacher/IDCard2.svg"
                        alt=""
                    />
                </div>
            </div>
            <ul class="note">
                <li>・(仮)申請から承認までn日ほどかかります。</li>
                <li>・(仮)申請の後、やり直しはできません。</li>
                <li>・(仮)個人情報は〜なんとかなんとか。</li>
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
                        @click="confirmStep2"
                    />
                </div>
            </div>
        </div>
    </LayoutOnBoarding>
</template>

<script setup>
import LayoutOnBoarding from "../../Layouts/LayoutOnBoarding.vue";
import ButtonRequest from "@/Components/Request/ButtonRequest.vue";
import { defineProps, defineEmits } from "vue";
import Breadcrumb from "../Breadcrumb.vue";

const props = defineProps({
    showButtonConfirm: Number,
});
const breadcrumbItems =
    props.showButtonConfirm !== 2
        ? [
              { text: "Dashboard", isLink: true },
              { text: "本人確認", isLink: true },
              { text: "最終確認", isLink: false },
          ]
        : [
              { text: "Dashboard", isLink: true },
              { text: "本人確認", isLink: false },
          ];
const emits = defineEmits();
const backToOnBoard = () => {
    emits("back-to-onboarding");
};
const confirmStep2 = () => {
    emits("confirm-step2");
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
        if (item.text === "本人確認") {
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
