<script setup>
import { defineProps, ref, defineEmits } from "vue";
import moment from "moment";

const props = defineProps({
    startLabel: String,
    endLabel: String,
    startTime: Date,
    endTime: Date,
});
const emit = defineEmits();

const handleStartTimeChange = (e) => {
    emit("setStartTime", e.target);
};

const handleEndTimeChange = (e) => {
    emit("setEndTime", e.target);
};

const timeRangeError = ref(false);
const timeRangeValidate = () => {
    const minTime = moment("06:00", "HH:mm");
    const maxTime = moment("22:00", "HH:mm");
    const startTime = moment(props.startTime, "HH:mm");
    const endTime = moment(props.endTime, "HH:mm");
    if (
        startTime.isBefore(minTime) ||
        endTime.isAfter(maxTime) ||
        endTime.isBefore(minTime)
    ) {
        timeRangeError.value = true;
    } else {
        timeRangeError.value = false;
    }
    emit("setTimeRangeError", timeRangeError.value);
};
</script>
<template>
    <div>
        <div class="time__range-select d-flex flex-row">
            <div class="wrap-double">
                <label for="Title" class="time__range-select-title"
                    >{{ startLabel }}
                </label>
                <input
                    type="time"
                    :value="props.startTime"
                    class="time__range-select-title-options"
                    @input="handleStartTimeChange"
                    @blur="timeRangeValidate"
                />
            </div>
            <div class="input-to d-flex align-items-center">to</div>
            <div class="wrap-double">
                <label for="Title" class="time__range-select-title"
                    >{{ endLabel }}
                </label>
                <input
                    type="time"
                    :value="props.endTime"
                    class="time__range-select-title-options"
                    @input="handleEndTimeChange"
                    @blur="timeRangeValidate"
                />
            </div>
        </div>
        <div v-if="timeRangeError" class="time__range-handle-error">
            時間は6～22時の間にしてください
        </div>
    </div>
</template>
<style scoped lang="scss">
.time__range-select {
    width: 100%;
    margin-top: 14.5px;

    .wrap-double {
        flex: 1;
    }
    &-title {
        font-size: 16px;
    }
    .input-to {
        margin: 8px 8px;
        transform: translateY(8px);
        font-size: 16px;
    }
}
.time__range-select-title-options {
    padding: 10px;
    height: 44px;
    min-width: 115.6px;
    width: 100%;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    font-family: "Noto Sans JP";
}
.time__range-handle-error {
    color: #e71a41;
    font-size: 10px;
    max-width: 170px;
    margin-left: 4px;
}
@media all and (max-width: 768px) {
    .double-select-title-options {
        min-width: 141px !important;
    }
}
</style>
