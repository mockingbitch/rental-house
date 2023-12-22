<script setup>
import { ref, defineProps } from "vue";
import { Link, usePage } from '@inertiajs/vue3';
import BaseCard from "@/Components/Card/BaseCard.vue";
import EmptyRequest from "@/Components/Request/EmptyRequest.vue";

const props = defineProps({
    isUser: Boolean,
    // eslint-disable-next-line vue/require-default-prop
    listRequest: Array,
    // eslint-disable-next-line vue/require-default-prop
    userId: Number,
    isLoggedIn: Boolean,
});
const toggleShowFullDetail = (request) => {
    request.showFullDetail = !request.showFullDetail;
};
const shortDetailStyles = {
    display: "-webkit-box",
    "-webkit-line-clamp": "2",
    "-webkit-box-orient": "vertical",
    overflow: "hidden",
};
const formatPrice = (value) => {
    let val = (value/1).toFixed(0).replace('.', ',')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
};
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('/');
}
</script>
<template>
    <div>
        <!-- <div v-if="!props.isLoggedIn && !props.userId" class="empty__request-note mt-4">
            <img src="/img/icon/TeacherRequest/tree.svg" alt="" />
            <div>
                (仮)探しているレッスンがなければ、Dottreeにログイン（新規登録）をして、リクエストしましょう！
            </div>
        </div> -->
        <!-- <div v-if="props.listRequest?.length && !props.isUser" class="list__request-group-day">2023/08/31</div> -->
        <BaseCard v-for="request in props.listRequest">
            <div class="list__request-container">
                <div class="list__request-day">
                    <div>{{ formatDate(request?.created_at) }}</div>
                    <div
                        v-if="request?.isNew"
                        class="list__request-day-status">
                        New
                    </div>
                </div>
                <div class="list__request-name">
                    {{ request?.summary }}
                </div>
                <div class="list__request-info">
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">
                            Price
                        </div>
                        <div class="list__request-info-detail">
                            {{ formatPrice(request.min_price) }}
                            ~ {{ formatPrice(request.max_price) }} VND
                        </div>
                    </div>
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">
                            Capacity
                        </div>
                        <div class="list__request-info-detail">
                            {{ request.min_capacity }} ~ {{ request.max_capacity }}
                            persons
                        </div>
                    </div>
                    <div class="list__request-info-wrap">
                        <div class="list__request-info-title">
                            Type
                        </div>
                        <div class="list__request-info-detail">
                            {{ request?.category?.name_en }}
                        </div>
                    </div>
                </div>
                <div class="list__request-detail">
                    <div class="list__request-info-title">
                        Detail
                    </div>
                    <div v-if="request.showFullDetail || request.detail?.length < 50">
                        {{ request?.detail }}
                    </div>
                    <div v-else :style="shortDetailStyles">
                        {{ request.detail }}
                    </div>
                    <div
                        v-if="request.detail?.length >= 50"
                        class="list__request-show-more"
                        @click="toggleShowFullDetail(request)"
                    >
                        {{ request.showFullDetail ? 'Show less' : 'Show more' }}
                    </div>
                </div>
                <!-- Hiển thị nếu không có dữ liệu -->
                <div
                    v-if="listRequest.length === 0"
                    class="list__request-empty-state"
                >
                    Empty list request
                </div>
            </div>
        </BaseCard>
    </div>
    <EmptyRequest
        v-if="props.listRequest?.length === 0"
        :show="true"
        :is-user="true"
        :is-logged-in="props.isLoggedIn"
    />
</template>
<style lang="scss" scoped>
.day {
    margin: 16px 0;
    font-size: 16px;
    font-weight: 700;
}
.list__request-container {
    margin-top: 16px;
    padding: 16px;
}
.list__request-group-day {
    margin-top: 16px;
    font-size: 16px;
    font-weight: 700;
}
.list__request-day {
    display: flex;
    align-items: center;
    gap: 4px;
    padding-bottom: 8px;
}
.list__request-day-status {
    font-size: 10px;
    color: #ff5575;
    font-weight: bold;
}
.list__request-name {
    font-size: 14px;
    font-weight: 700;
    padding-bottom: 8px;
    border-bottom: 1px solid #e3e3e3;
    word-break: break-all;
}
.list__request-info-wrap {
    display: flex;
    justify-content: space-between;
    .list__request-info-title {
        width: fit-content;
        white-space: nowrap;
    }
}
.list__request-info {
    margin-top: 8px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.list__request-info-detail {
    font-weight: bold;
    word-break: break-all;
    padding-left: 53px;
}
.list__request-detail {
    word-break: break-all;
    padding: 8px 0px;
    border-bottom: 1px solid #e3e3e3;
}
.list__request-create {
    margin-top: 8px;
    display: flex;
    justify-content: center;
}
.list__request-create-btn {
    display: flex;
    background-color: #418997;
    width: 368px;
    max-height: 50px;
    align-items: center;
    justify-content: center;
    color: white;
    gap: 10px;
    padding: 16px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 4px;
    cursor: pointer;
}
.list__request-show-more {
    background: none;
    border: none;
    color: #1b1b1b;
    cursor: pointer;
    text-decoration: underline;
    font-weight: bold;
}
.list__request-empty-state {
    padding: 16px 7.5px;
    margin-top: 8px;
    font-size: 14px;
    color: #989898;
    letter-spacing: -0.14px;
}
.empty__request-note {
    padding: 8px;
    display: flex;
    gap: 8px;
    background-color: #e1eff2;
    color: #418997;
    border-radius: 4px;
}
@media all and (max-width: 768px) {
    .list__request-create-btn {
        width: 343px;
    }
}
</style>
