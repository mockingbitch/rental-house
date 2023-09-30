<script setup>
import SubHeader from '../../Components/Common/SubHeader.vue';
import ButtonRequest from '../../Components/Request/ButtonRequest.vue';
import { Link } from '@inertiajs/vue3'


</script>
<template>
    <div>
        <SubHeader showLogoSp />
        <div class="deleted-container d-flex flex-column">
            <img src="../../../../public/img/deleted-account.png" alt="" />
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
<style lang="scss" scoped>
.delete-account-container {
    width: 100%;
    max-width: 400px;
    margin: 0px auto;
    font-family: Noto Sans JP;
    font-size: 12px;
    color: #1b1b1b;
    align-items: center;
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
    .delete-account-modal-container {
        text-align: center;
        font-size: 14px;
        .delete-account-modal-title {
            font-size: 16px;
            font-weight: 700;
        }
        .delete-account-modal-content {
            gap: 16px;
            line-height: 1.6;
            max-width: 275px;
            margin: 0 auto;
            .delete-account-modal-content-btn {
                border-radius: 4px;
                opacity: 0.8;
                background: #f4f4f4;
                padding: 8px 0px;
                font-weight: 700;
                line-height: 160%;
            }
            .delete-account-modal-content-text {
                color: #e71a41;
            }
        }
        .delete-account-modal-btn {
            gap: 16px;
        }
        .submit__button {
            margin-top: 16px;
            height: 50px;
        }
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
}
</style>