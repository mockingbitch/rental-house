<script setup>
import { defineProps, computed, defineEmits } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

const props = defineProps({
    status: Number,
    step: Number,
});
const emits = defineEmits();

const statusData = computed(() => {
    if (props.status === 1) {
        return {
            image: "img/icon/ApplyToTeacher/CaretRight.svg",
            title: "学歴・経歴登録",
            buttonContent: 'fascasc',
            FunctionButton: null,
        };
    } else if (props.status === null && props.step === 2) {
        return {
            image: "img/icon/ApplyToTeacher/CaretRight.svg",
            title: "振込口座設定&本人確認",
            buttonContent: "Apply Now",
            FunctionButton: ApplyOrReview,
        };
    } else if (props.status === null && props.step === 3) {
        return {
            image: "img/icon/ApplyToTeacher/CaretRight.svg",
            title: "学歴・経歴登録",
            buttonContent: "Apply Now",
            FunctionButton: ApplyOrReview,
        };
    } else if (props.status === 2 && props.step === 1) {
        return {
            image: "img/icon/ApplyToTeacher/Check.svg",
            title: 'teca',
            buttonContent: 'sdaf',
            FunctionButton: ReviewResult,
        };
    } else if (props.status === 2 && props.step === 2) {
        return {
            image: "img/icon/ApplyToTeacher/Check.svg",
            title: "振込口座設定&本人確認（完了)",
            buttonContent: 'test',
            FunctionButton: ReviewResult,
        };
    } else if (props.status === 3) {
        return {
            image: "img/icon/ApplyToTeacher/Warning.svg",
            title: 'test',
            buttonContent: 'test',
            FunctionButton: "",
        };
    } else if (props.status === 0 && props.step === 2) {
        return {
            title: "振込口座設定&本人確認",
        };
    } else if (props.status === 0 && props.step === 3) {
        return {
            title: "学歴・経歴登録",
        };
    } else {
        return {
            image: "img/icon/ApplyToTeacher/CaretRight.svg",
            title: 'test',
            buttonContent: "Apply Now",
            FunctionButton: ApplyOrReview,
        };
    }
});

const contentStep = computed(() => {
    if (props.status === 0 && props.step === 2) {
        return {
            contentStep:
                "Your teacher application has been approved! The next step is to confirm your ID with a selfie. This step helps ensure the safety of the Outschool community. Read more about our teacher identity verification",
        };
    } else if (props.status === 0 && props.step === 3) {
        return {
            contentStep:
                "We'll also need to do your background check. Once it's complete (usually a few days), you’ll be able to join our community of teachers. Read more about our background check process and policies",
        };
    } else {
        return {
            contentStep:
                "Educators must be at least 18 years old and reside full-time in any of the 50 United States, Canada, Australia, New Zealand, England, or Wales. Read more about",
        };
    }
});


const form = useForm({});
const ApplyOrReview = () => {
    if (props.step === 2) {
        form.post(route("onboarding.create.step2"), {
            onFinish: () => {
                if (Object.keys(form.errors).length === 0 && form.errors.constructor === Object) {
                    // emits("confirm-step1", props.dataStep1);
                    console.log('ok');
                }
            },
            onError: console.log('error'),
        });
    } else {
        emits("toggle");
    }
};

const ReviewResult = () => {
    if (props.step === 2) {
        form.post(route("onboarding.stripe.checkdashboard"), {
            onFinish: () => {
                if (Object.keys(form.errors).length === 0 && form.errors.constructor === Object) {
                    // emits("confirm-step1", props.dataStep1);
                }
            },
            onError: console.log('error'),
        });
    } else {
        emits("showResult");
    }
};
</script>1

<template>
    <div
        class="teacher__dashboard-apply-card-container"
        :data-status="props.status"
    >
        <div class="title-step d-flex">
            <div
                class="icon-step d-flex justify-content-center align-items-center"
            >
                <img :src="statusData.image" alt="" />
            </div>
            <div class="title-content d-flex align-items-center">
                {{ statusData.title }}
            </div>
        </div>
        <div class="warning-content" v-if="props.status === 3">
            <span>NGになった理由とか、</span>
            <span
                >問題により申請がうまくできなかったことを説明する。<a href="#"
                    >お問合せはこちら</a
                ></span
            >
        </div>
        <div class="d-flex flex-column" style="min-height: 95px">
            <span>{{
                props.status === 0
                    ? ""
                    : "Fill out your application to teach with us!"
            }}</span>
            <div class="content-step d-flex flex-column">
                <span>
                    {{ contentStep.contentStep }}
                </span>
                <a href="#">{{
                    props.status === 0
                        ? "here"
                        : "becoming an educator on Dottrees"
                }}</a>
            </div>
            <span
                class="stripe-note"
                v-if="props.step === 2 && props.status === 0"
            >
                ※ Stripe.com
            </span>
            <span
                class="stripe-note"
                v-if="props.step === 2 && props.status !== 0"
                >※ (仮)外部サイトに遷移：Stripe.com</span
            >
        </div>
        <div
            class="button-step d-flex justify-content-center align-items-center"
            @click="statusData.FunctionButton"
        >
            <span>{{ statusData.buttonContent }}</span>
            <img
                src="img/icon/ApplyToTeacher/ArrowSquareOut.svg"
                alt=""
                class="button-step-share"
                v-if="props.step === 2 && props.status === null"
            />
			<img
                src="img/icon/ApplyToTeacher/ArrowSquareOut1.svg"
                alt=""
                class="button-step-share"
                v-if="props.step === 2 && props.status !== null"
            />
        </div>
    </div>
</template>

<style lang="scss" scoped>
.teacher__dashboard-apply-card-container {
    width: 100%;
    background-color: #f4f4f4;
    border-radius: 8px;
    width: 100%;
    margin: 16px 0;
    padding: 16px;
    a {
        color: #418997;
        text-decoration: underline;
        font-weight: 700;
    }
    .title-step {
        gap: 8px;
        margin-bottom: 8px;
        height: 26px;
        .icon-step {
            width: 24px;
            height: 24px;
            background-color: #418997;
            border-radius: 100px;
        }
        .title-content {
            font-size: 16px;
            font-weight: bold;
        }
    }
    .button-step {
        margin-top: 8px;
        font-size: 14px;
        background-color: #418997;
        height: 50px;
        color: #ffffff;
        font-weight: 700;
        cursor: pointer;
        border-radius: 4px;
        position: relative;
        &-share {
            position: absolute;
            right: 16px;
        }
    }
    .stripe-note {
        font-family: Noto Sans JP;
        font-size: 12px;
        font-style: normal;
        font-weight: 400;
        line-height: 160%; /* 19.2px */
        letter-spacing: -0.12px;
        color: #7f7f7f;
        margin-top: 8px;
    }
    @media screen and (min-width: 720px) {
        .content-step {
            display: block !important;
            a {
                margin-left: 3px;
            }
        }
    }
    /* Add styles for status = 0 */
    &[data-status="0"] {
        img,
        .button-step {
            display: none !important;
        }
        color: #b1b1b1;
        .title-step {
            .icon-step {
                background-color: #c4e0e5;
            }
        }
        .content-step {
            display: block !important;
            a {
                margin-left: 3px;
            }
        }
    }
    &[data-status="1"] {
        .button-step {
            background-color: #e3e3e3;
            color: #418997;
        }
        @media screen and (min-width: 720px) {
            .content-step {
                display: block !important;
                a {
                    margin-left: 3px;
                }
            }
        }
    }
    &[data-status="2"] {
        background-color: white;
        border: 1px solid #e3e3e3;
        a {
            color: #1b1b1b;
        }
        .button-step {
            background-color: white;
            color: #418997;
            font-weight: 400;
            text-decoration: underline;
        }
        .title-step {
            .icon-step {
                background-color: white;
                border: 1px solid #418997;
            }
        }
        @media screen and (min-width: 720px) {
            .content-step {
                display: block !important;
                a {
                    margin-left: 3px;
                }
            }
        }
    }
    &[data-status="3"] {
        .warning-content {
            color: #e71a41;
            a {
                color: #e71a41;
            }
        }
        .title-step {
            .icon-step {
                background-color: #e71a41;
            }
            .title-content {
                color: #e71a41;
            }
        }
    }
}
</style>
