<template>
    <div class="custom-timezone-title">{{ props.label }}</div>
    <div class="d-flex align-items-center custom-timezone-wrap">
        <!-- start-time -->
        <div v-if="selectStartTime" class="custom-timezone-item">
            <input
                v-model="selectedStartTime"
                type="time"
                @blur="onTimeBlurStart"
            />
            <div
                class="custom-timezone-item-icon"
                @click="handlePickStartTimeZone"
            >
                <img src="../../../../../public/img/icon/CaretDown.svg" />
            </div>
            <div v-if="pickStartTimeZone" class="custom-timezone-dropdown">
                <div
                    v-for="time in filterStartTime"
                    :key="time"
                    @click="selectStartTime(time)"
                >
                    <div
                        style="cursor: pointer"
                        class="custom-timezone-dropdown-time"
                    >
                        {{ time }}
                    </div>
                </div>
            </div>
        </div>
        <!-- to -->
        <div style="margin-bottom: 6px" class="custom-timezone-text">to</div>
        <!-- end-time -->
        <div v-if="selectEndTime" class="custom-timezone-item end-select">
            <input
                v-model="selectedEndTime"
                type="time"
                @blur="onTimeBlurEnd"
            />
            <div
                class="custom-timezone-item-icon"
                @click="handlePickEndTimeZone"
            >
                <img src="../../../../../public/img/icon/CaretDown.svg" />
            </div>
            <div v-if="pickEndTimeZone" class="custom-timezone-dropdown">
                <div
                    v-for="time in filterEndTime"
                    :key="time"
                    @click="selectEndTime(time)"
                >
                    <div class="custom-timezone-dropdown-time">
                        {{ time }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    ref,
    computed,
    watch,
    defineEmits,
    defineProps,
    onBeforeUnmount,
} from "vue";
import moment from "moment";

const emit = defineEmits();

const props = defineProps({
    start: String,
    end: String,
    label: String,
});

const pickStartTimeZone = ref(false);
const pickEndTimeZone = ref(false);
const selectedStartTime = ref(null);
const selectedEndTime = ref(null);
function generateTimezoneArray() {
    const timezones = [];
    for (let hour = 0; hour <= 23; hour++) {
        for (let minute of ["00", "30"]) {
            timezones.push(`${hour.toString().padStart(2, "0")}:${minute}`);
        }
    }
    return timezones;
}

const timezone = generateTimezoneArray();

const handlePickStartTimeZone = () => {
    pickStartTimeZone.value = !pickStartTimeZone.value;
    if (pickStartTimeZone) {
        document.addEventListener("click", handleClickOutsideStart);
    } else {
        document.removeEventListener("click", handleClickOutsideStart);
    }
};
const handlePickEndTimeZone = () => {
    pickEndTimeZone.value = !pickEndTimeZone.value;
    if (pickEndTimeZone) {
        document.addEventListener("click", handleClickOutsideEnd);
    } else {
        document.removeEventListener("click", handleClickOutsideEnd);
    }
};

const filterStartTime = computed(() => {
    if (props.end) {
        return timezone.filter((time) => time < selectedEndTime.value);
    }
    return timezone;
});

const filterEndTime = computed(() => {
    if (props.start) {
        return timezone.filter((time) => time > selectedStartTime.value);
    }
    return timezone;
});

const selectStartTime = (time) => {
    selectedStartTime.value = time;
    emit("select-start-time", time);
    pickStartTimeZone.value = false;
};
const selectEndTime = (time) => {
    selectedEndTime.value = time;
    emit("select-end-time", time);
    pickEndTimeZone.value = false;
};

const onTimeBlurStart = () => {
    console.log(selectedStartTime.value);
    const endTimeMoment = moment(selectedEndTime.value, "HH:mm");
    const startTimeMoment = moment(selectedStartTime.value, "HH:mm");
    if (startTimeMoment.isSameOrAfter(endTimeMoment)) {
        startTimeMoment.add(30, "minutes");
        selectedEndTime.value = startTimeMoment.format("HH:mm");
        emit("fill-start-time", selectedEndTime.value);
    }
    emit("start-time", selectedStartTime.value);
};

const onTimeBlurEnd = () => {
    const endTimeMoment = moment(selectedEndTime.value, "HH:mm");
    const startTimeMoment = moment(selectedStartTime.value, "HH:mm");
    if (endTimeMoment.isSameOrBefore(startTimeMoment)) {
        endTimeMoment.subtract(30, "minute");
        selectedStartTime.value = endTimeMoment.format("HH:mm");
        emit("fill-end-time", selectedStartTime.value);
    }
    emit("end-time", selectedEndTime.value);
};

const handleClickOutsideStart = (event) => {
    const popup = document.querySelector(".custom-timezone-item");
    if (popup && !popup.contains(event.target)) {
        pickStartTimeZone.value = false;
    }
};

const handleClickOutsideEnd = (event) => {
    const popup = document.querySelector(".end-select");
    if (popup && !popup.contains(event.target)) {
        pickEndTimeZone.value = false;
    }
};

watch(
    () => props.start,
    (newValue) => {
        selectedStartTime.value = newValue;
    },
    { immediate: true }
);
watch(
    () => props.end,
    (newValue) => {
        selectedEndTime.value = newValue;
    },
    { immediate: true }
);
</script>

<style lang="scss" scoped>
.custom-timezone-title {
    color: #1b1b1b;
    margin-top: 16px;
    font-size: 12px;
    font-style: normal;
    font-weight: 400;
    line-height: 19.2px; /* 19.2px */
    letter-spacing: -0.12px;
}

.custom-timezone-text {
    color: #000000;
    font-size: 12px;
    font-style: normal;
    font-weight: 400;
    line-height: 19.2px; /* 19.2px */
    letter-spacing: -0.12px;
}
.custom-timezone-wrap {
    gap: 8px;
    margin-top: 8px;
    .custom-timezone-item {
        cursor: pointer;
        position: relative;
        flex: 1;
        input {
            width: 100%;
            height: 44px;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            font-family: Noto Sans JP;
            padding: 12px 32px 12px 12px;
        }
        .custom-timezone-item-icon {
            position: absolute;
            top: 12px;
            right: 12px;
        }
        .custom-timezone-dropdown {
            position: absolute;
            background-color: #fff;
            z-index: 100000;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #7f7f7f99;
            max-height: 200px;
            overflow-y: scroll;
            scrollbar-width: thin;
            scrollbar-color: #7f7f7f99 #fff;
            font-size: 13px;
            .custom-timezone-dropdown-time {
                cursor: pointer;
                padding: 4px 12px;
            }
            .custom-timezone-dropdown-time:hover {
                background-color: #7f7f7f99;
            }
        }
        .custom-timezone-dropdown::-webkit-scrollbar {
            width: 6px;
        }
        .custom-timezone-dropdown::-webkit-scrollbar-thumb {
            border-radius: 100px;
            background: #7f7f7f99;
        }
        .custom-timezone-dropdown::-webkit-scrollbar-track {
            background-color: #f4f4f4;
        }
    }
    input[type="time"]::-webkit-calendar-picker-indicator {
        display: none;
        -webkit-appearance: none;
    }
}

input:focus-visible {
    outline: #1b1b1b auto 1px !important;
}
</style>
