<script setup>
import ButtonCommon from "@/Components/Button/ButtonCommon.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, ref, reactive } from "vue";

const props = defineProps({
    step: Number,
    accountInforForm: Object,
    learnerInforForm: Object,
    user: Object,
    ziggy: Object,
});

const form = useForm({
    user: props.user,
    kids: props.learnerInforForm?.kids,
    params: props.ziggy.query,
});

const emit = defineEmits(['prev-step']);

const backToPrevStep = () => {
    emit("prev-step");
};

const confirmInformation = () => {
    form.kids = props.learnerInforForm?.kids;
    form.post(route('completed.info'), {
        preserveScroll: true,
        onSuccess: (response) => {
        },
        onError: (e) => {
            console.log(e);
        }
    });
}
</script>

<template>
    <transition name="slide-fade">
        <form v-show="step === 4"
            class="form[0]"
            method="post"
            action="#"
            @submit.prevent="next"
        >
            <div class="step-container">
                <div
                    class="step-container-header d-flex align-items-center justify-content-center"
                >
                    <span class="step-container-header-content"
                        >登録内容を確認お願いします</span
                    >
                </div>

                <div class="skip-item" style="margin-top: 40px;">
                    <img
                        src="/img/icon/arrownLeft.svg"
                        alt=""
                        @click="backToPrevStep"
                    />
                </div>
                <!-- Account (Parent) Information -->
                <div class="result-content" >
                    <div class="result-content-group first-content">
                        <div class="title-content">Residential Area</div>
                        <div class="filled-content">
                            {{ props.accountInforForm?.country['name_' + $page.props.locale] }}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">Redifential City</div>
                        <div class="filled-content">
                            {{ props.accountInforForm?.city['name_' + $page.props.locale] }}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">Adult Nickname</div>
                        <div class="filled-content">
                            {{ props.accountInforForm?.nickName }}
                        </div>
                    </div>
                    <div class="result-content-group">
                        <div class="title-content">Adult name</div>
                        <div class="filled-content">
                            {{ props.accountInforForm?.firstName }}
                            {{ props.accountInforForm?.lastName }}
                        </div>
                    </div>
                    <div class="result-content-group last-content">
                        <div class="title-content">Birthday</div>
                        <div class="filled-content">
                            {{ props.accountInforForm?.year % 1000 }}/{{
                                props.accountInforForm?.month
                            }}/{{ props.accountInforForm?.day }}
                        </div>
                    </div>
                </div>

                <!-- Learners (kids) information -->
                <div v-if="props.learnerInforForm">
                    <div class="result-content" v-for="(item, index) in props.learnerInforForm.kids" :id="index">
                        <div class="result-content-group first-content">
                            <div class="title-content">Kid Nickname</div>
                            <div class="filled-content">
                                {{ item?.nickName }}
                            </div>
                        </div>
                        <div class="result-content-group">
                            <div class="title-content">Kid name</div>
                            <div class="filled-content">
                                {{ item?.name }}
                            </div>
                        </div>
                        <div class="result-content-group">
                            <div class="title-content">Birthday</div>
                            <div class="filled-content">
                                {{ item?.year % 1000 }}/{{
                                    item?.month
                                }}/{{ item?.day }}
                            </div>
                        </div>
                        <div class="result-content-group last-content">
                            <div class="title-content">Interest Category</div>
                            <div class="filled-content">
                                {{ item?.categories.map((category_id) => {
                                    return $page.props.categories.find((category) => category.id == category_id)['name_' + $page.props.locale];
                                }).join(',') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="button-container">
                    <div class="create__request-button">
                        <div class="lineFull"></div>
                        <ButtonCommon
                            :label="'戻る'"
                            :submit-button="false"
                            class="create__request-button-left"
                            @click="backToPrevStep"
                        />
                        <ButtonCommon
                            :label="'申請する'"
                            :submit-button="true"
                            class="create__request-button-right"
                            @click="confirmInformation"
                        />
                    </div>
                </div>
            </div>
        </form>
    </transition>
</template>

<style lang="scss" scoped>
@import "./_stepconfirm.scss";
</style>
