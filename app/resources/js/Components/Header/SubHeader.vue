<script setup>
import { Link } from "@inertiajs/vue3";

const emits = defineEmits();

const props = defineProps({
    label: {
        type: String,
        default: "",
    },
    showLogoSp: { // true: show the Rentalhouse logo
        type: Boolean,
        default: false,
    },
    hideBtn: {
        type: Boolean,
        default: false,
    },
    hideOnSp: {
        type: Boolean,
        default: false,
    },
    hideOnPc: {
        type: Boolean,
        default: false,
    },
    href: {
        type: String,
        default: "",
    },
    isClose: { //true: display button close / false: display button back
        type: Boolean,
        default: false,
    },
    isDashboard: {
        type: Boolean,
        default: false
    }
});

const handleClose = () => {
    emits("close");
};
</script>

<template>
    <div
        class="create__request-header align-items-center justify-content-center"
        :class="{ dark: isDashboard, hide_on_sp: hideOnSp, hide_on_pc: hideOnPc }"
    >
        <div v-if="!hideBtn">
            <Link v-if="href" :href="route(href)" class="close-btn">
                <div v-if="isDashboard">
                    <img v-if="!isClose" src="/img/icon/CaretLeft.svg" alt="" />
                    <img v-else src="/img/icon/close-white.svg" alt="" />
                </div>
                <div v-else style="height: 32px;">
                    <img v-if="!isClose" src="/img/icon/CaretLeft.svg" alt="" />
                    <img v-else src="/img/icon/close.svg" alt="" />
                </div>
            </Link>
            <button v-else class="close-btn" type="button" @click="handleClose">
                <div v-if="isDashboard">
                    <img v-if="!isClose" src="/img/icon/CaretLeft.svg" alt="" />
                    <img v-else src="/img/icon/close-white.svg" alt="" />
                </div>
                <div v-else style="height: 32px;">
                    <img v-if="!isClose" src="/img/icon/CaretLeft.svg" alt="" />
                    <img v-else src="/img/icon/close.svg" alt="" />
                </div>
            </button>
        </div>
        <div class="create__request-header-title">
            <span :class="showLogoSp ? 'hide-on-mobile' : ''">
                {{ label }}
            </span>
            <img
                v-if="showLogoSp"
                :class="{ logo_sp: showLogoSp }"
                src="/img/logo/RentalHouse.svg"
                alt=""
            />
        </div>
    </div>
</template>

<style scoped lang="scss">
@import './subheader';
</style>
