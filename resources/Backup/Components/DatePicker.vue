<template>
    <div class="wrapper">
        <div class="date-picker">
            <div class="date__picker-wrapper">
                <div class="date-picker-header">
                    <button @click="prevMonth">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="17"
                            height="17"
                            viewBox="0 0 17 17"
                            fill="none"
                        >
                            <path
                                d="M13.3541 13.146C13.4006 13.1925 13.4374 13.2476 13.4626 13.3083C13.4877 13.369 13.5007 13.4341 13.5007 13.4998C13.5007 13.5655 13.4877 13.6305 13.4626 13.6912C13.4374 13.7519 13.4006 13.8071 13.3541 13.8535C13.3077 13.9 13.2525 13.9368 13.1918 13.962C13.1311 13.9871 13.0661 14.0001 13.0004 14.0001C12.9347 14.0001 12.8696 13.9871 12.8089 13.962C12.7482 13.9368 12.6931 13.9 12.6466 13.8535L7.64664 8.85354C7.60015 8.8071 7.56328 8.75196 7.53811 8.69126C7.51295 8.63056 7.5 8.5655 7.5 8.49979C7.5 8.43408 7.51295 8.36902 7.53811 8.30832C7.56328 8.24762 7.60015 8.19248 7.64664 8.14604L12.6466 3.14604C12.7405 3.05222 12.8677 2.99951 13.0004 2.99951C13.1331 2.99951 13.2603 3.05222 13.3541 3.14604C13.448 3.23986 13.5007 3.36711 13.5007 3.49979C13.5007 3.63247 13.448 3.75972 13.3541 3.85354L8.70727 8.49979L13.3541 13.146ZM3.70727 8.49979L8.35414 3.85354C8.44796 3.75972 8.50067 3.63247 8.50067 3.49979C8.50067 3.36711 8.44796 3.23986 8.35414 3.14604C8.26032 3.05222 8.13308 2.99951 8.00039 2.99951C7.86771 2.99951 7.74046 3.05222 7.64664 3.14604L2.64664 8.14604C2.60016 8.19248 2.56328 8.24762 2.53811 8.30832C2.51295 8.36902 2.5 8.43408 2.5 8.49979C2.5 8.5655 2.51295 8.63056 2.53811 8.69126C2.56328 8.75196 2.60016 8.8071 2.64664 8.85354L7.64664 13.8535C7.6931 13.9 7.74825 13.9368 7.80895 13.962C7.86964 13.9871 7.9347 14.0001 8.00039 14.0001C8.06609 14.0001 8.13115 13.9871 8.19184 13.962C8.25254 13.9368 8.30769 13.9 8.35414 13.8535C8.4006 13.8071 8.43745 13.7519 8.46259 13.6912C8.48773 13.6305 8.50067 13.5655 8.50067 13.4998C8.50067 13.4341 8.48773 13.369 8.46259 13.3083C8.43745 13.2476 8.4006 13.1925 8.35414 13.146L3.70727 8.49979Z"
                                fill="#1B1B1B"
                            />
                        </svg>
                    </button>
                    <span class="title-date" @click="showMonthYearPopup">{{
                        currentMonth
                    }}</span>
                    <button @click="nextMonth">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="17"
                            height="17"
                            viewBox="0 0 17 17"
                            fill="none"
                        >
                            <path
                                d="M9.35403 8.85354L4.35403 13.8535C4.26021 13.9474 4.13296 14.0001 4.00028 14.0001C3.8676 14.0001 3.74035 13.9474 3.64653 13.8535C3.55271 13.7597 3.5 13.6325 3.5 13.4998C3.5 13.3671 3.55271 13.2399 3.64653 13.146L8.2934 8.49979L3.64653 3.85354C3.55271 3.75972 3.5 3.63247 3.5 3.49979C3.5 3.36711 3.55271 3.23986 3.64653 3.14604C3.74035 3.05222 3.8676 2.99951 4.00028 2.99951C4.13296 2.99951 4.26021 3.05222 4.35403 3.14604L9.35403 8.14604C9.40052 8.19248 9.4374 8.24762 9.46256 8.30832C9.48772 8.36902 9.50067 8.43408 9.50067 8.49979C9.50067 8.5655 9.48772 8.63056 9.46256 8.69126C9.4374 8.75196 9.40052 8.8071 9.35403 8.85354ZM14.354 8.14604L9.35403 3.14604C9.26021 3.05222 9.13296 2.99951 9.00028 2.99951C8.8676 2.99951 8.74035 3.05222 8.64653 3.14604C8.55271 3.23986 8.5 3.36711 8.5 3.49979C8.5 3.63247 8.55271 3.75972 8.64653 3.85354L13.2934 8.49979L8.64653 13.146C8.55271 13.2399 8.5 13.3671 8.5 13.4998C8.5 13.6325 8.55271 13.7597 8.64653 13.8535C8.74035 13.9474 8.8676 14.0001 9.00028 14.0001C9.13296 14.0001 9.26021 13.9474 9.35403 13.8535L14.354 8.85354C14.4005 8.8071 14.4374 8.75196 14.4626 8.69126C14.4877 8.63056 14.5007 8.5655 14.5007 8.49979C14.5007 8.43408 14.4877 8.36902 14.4626 8.30832C14.4374 8.24762 14.4005 8.19248 14.354 8.14604Z"
                                fill="#1B1B1B"
                            />
                        </svg>
                    </button>
                </div>
                <div class="date-picker-body">
                    <table>
                        <thead>
                            <tr>
                                <th v-for="day in daysOfWeek" :key="day">
                                    <p>
                                        {{ day }}
                                    </p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(week, index) in weeks" :key="index">
                                <td
                                    v-for="day in week"
                                    :key="day.date"
                                    @click="selectDate(day)"
                                    :class="{
                                        disabled: day.disabled,
                                        faded: day.faded,
                                        rangeDate: day.isRangeDate,
                                    }"
                                >
                                    <a
                                        :class="{
                                            faded: day.faded,
                                            disabled: day.disabled,
                                            rangeDate: day.isRangeDate,
                                            dateInRage: day.dateInRage,
                                        }"
                                        >{{ day.date }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Month and Year Popup -->

            <div class="button-reset" @click="resetSelectDate">
                <span>{{ clearSelectDate }}</span>
            </div>
        </div>
        <Modal
            :showModal="isShowSelectMonthYear"
            @close="isShowSelectMonthYear = false"
        >
            <div class="form">
                <div class="form__wrap-item">
                    <div class="form-wrap-double">
                        <div class="select">
                            <label for="Title">
                                <span>Month</span>
                            </label>
                            <select
                                name="month"
                                id="half_width"
                                v-model="selectedMonth"
                            >
                                <option
                                    v-for="(month, index) in months"
                                    :key="index"
                                    :value="index + 1"
                                >
                                    {{ month }}
                                </option>
                            </select>
                        </div>
                        <div class="select">
                            <label for="Title">
                                <span>Year</span>
                            </label>
                            <select
                                name="year"
                                id="half_width"
                                v-model="selectedYear"
                            >
                                <option
                                    v-for="year in years"
                                    :key="year"
                                    :value="year"
                                >
                                    {{ year }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <button @click="applyMonthYear">OK</button>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script>
import { ref, computed, onMounted, watch, toRef } from "vue";
import Modal from "./Modal/Modal.vue";
import moment from "moment";

export default {
    components: { Modal },
    props: {
        modelValue: {
            type: String,
            default: "",
        },
        selectedStartDate: {
            type: String,
            default: "",
        },
        selectedEndDate: {
            type: String,
            default: "",
        },
        isSelectStartDate: {
            type: Boolean,
        },
        isSelectEndDate: {
            type: Boolean,
        },
        clearSelectDate: {
            type: String,
        },
    },
    setup(props, context) {
        const isSelectStartDate = toRef(props, "isSelectStartDate");
        const isSelectEndDate = toRef(props, "isSelectEndDate");
		const clearSelectDate = ref(props.clearSelectDate)

        watch(
            [
                () => props.selectedStartDate,
                () => props.selectedEndDate,
                isSelectStartDate,
                isSelectEndDate,
            ],
            () => {
                const startDate = moment(props.selectedStartDate, "YYYY/MM/DD");
                const endDate = moment(props.selectedEndDate, "YYYY/MM/DD");
                const startSelectDate = startDate.isValid()
                    ? new Date(props?.selectedStartDate)
                    : null;
                const endSelectDate = endDate.isValid()
                    ? new Date(props?.selectedEndDate)
                    : null;
                if (
                    (startSelectDate && isSelectStartDate.value) ||
                    (startSelectDate &&
                        endSelectDate === null &&
                        isSelectStartDate.value)
                ) {
                    currentDate = startSelectDate;
                } else if (
                    (endSelectDate && isSelectEndDate.value) ||
                    (endSelectDate &&
                        startSelectDate === null &&
                        isSelectEndDate.value)
                ) {
                    currentDate = endSelectDate;
                } else if (startSelectDate === null) {
                } else if (endSelectDate === null) {
                } else {
                    currentDate = new Date();
                }
                currentDate.setMonth(currentDate.getMonth());
                currentYear.value = currentDate.getFullYear();
                currentMonthNumber.value = currentDate.getMonth();
                updateWeeks();
            }
        );
        const isDatePickerVisible = ref(true);
        const startDate = moment(props.selectedStartDate, "YYYY/MM/DD");
        const endDate = moment(props.selectedEndDate, "YYYY/MM/DD");
        const startSelectDate = startDate.isValid()
            ? new Date(props?.selectedStartDate)
            : null;
        const endSelectDate = endDate.isValid()
            ? new Date(props?.selectedEndDate)
            : null;
        const isSelectingStart = ref(props.isSelectStartDate);
        const isSelectingEnd = ref(props.isSelectEndDate);
        let currentDate;
        let currentYear = ref();
        let currentMonthNumber = ref();
        if (
            (startSelectDate && isSelectingStart.value) ||
            (endSelectDate && isSelectingEnd.value)
        ) {
            currentDate = startSelectDate || endSelectDate;
        } else {
            currentDate = new Date();
        }
        currentYear.value = currentDate.getFullYear();
        currentMonthNumber.value = currentDate.getMonth();
        const currentMonth = computed(() => {
            return `${currentYear.value}年${
                currentMonthNumber.value + 1 < 10
                    ? "0" + (currentMonthNumber.value + 1)
                    : currentMonthNumber.value + 1
            }月`;
        }, [
            currentYear,
            currentMonthNumber,
            isSelectEndDate,
            isSelectStartDate,
        ]);
        const daysOfWeek = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
        const weeks = ref([]);
        const selectedYear = ref(currentYear.value);
        const selectedMonth = ref(currentMonthNumber.value + 1);
        const selectedDate = ref(
            new Date(selectedYear.value, selectedMonth.value - 1, 1)
        );
        const resetSelectDate = () => {
            // Khi click vào "リセット", ta sẽ emit sự kiện "reset-date-picker" lên component cha
            context.emit("reset-date-picker");
        };
        const isShowSelectMonthYear = ref(false);
        // Compute the days of the current month
        const computeDaysOfMonth = () => {
            const firstDayOfMonth = new Date(
                currentYear.value,
                currentMonthNumber.value,
                1
            ).getDay();
            const lastDateOfMonth = new Date(
                currentYear.value,
                currentMonthNumber.value + 1,
                0
            ).getDate();
            const days = [];
            const startDateValue = moment(
                props.selectedStartDate,
                "YYYY/MM/DD"
            );
            const endDateValue = moment(props.selectedEndDate, "YYYY/MM/DD");
            let dayCounter = 1;
            // Add days of the previous month
            const lastDateOfPrevMonth = new Date(
                currentYear.value,
                currentMonthNumber.value,
                0
            ).getDate();
            for (let i = firstDayOfMonth - 1; i >= 0; i--) {
                const date = new Date(
                    currentYear.value,
                    currentMonthNumber.value - 1,
                    lastDateOfPrevMonth - i
                );
                days.push({ date: date.getDate(), active: false, faded: true });
            }
            // Add days of the current month
            for (let i = 1; i <= lastDateOfMonth; i++) {
                const date = new Date(
                    currentYear.value,
                    currentMonthNumber.value,
                    i
                );
                let isDisabled;
                isDisabled =
                    (isSelectStartDate.value || isSelectEndDate.value) &&
                    startDateValue &&
                    endDateValue &&
                    ((isSelectStartDate.value &&
                        moment(date, "YYYY/MM/DD").isAfter(
                            endDateValue,
                            "day"
                        )) ||
                        (isSelectEndDate.value &&
                            moment(date, "YYYY/MM/DD").isBefore(
                                startDateValue,
                                "day"
                            )));
                const isStartDate = moment(date, "YYYY/MM/DD").isSame(
                    startDateValue,
                    "day"
                );
                const isEndDate = moment(date, "YYYY/MM/DD").isSame(
                    endDateValue,
                    "day"
                );
                const isDateInRage =
                    moment(date, "YYYY/MM/DD").isAfter(startDateValue, "day") &&
                    moment(date, "YYYY/MM/DD").isBefore(endDateValue, "day");
                days.push({
                    date: i,
                    faded: false,
                    disabled: isDisabled,
                    dateInRage: isDateInRage,
                    isRangeDate: isStartDate || isEndDate,
                });
                dayCounter++;
            }
            // Add days of the next month
            const remainingDays = 36 - dayCounter;
            for (let i = 1; i <= remainingDays; i++) {
                days.push({ date: i, active: false, faded: true });
            }
            return days;
        };
        const updateWeeks = () => {
            const days = computeDaysOfMonth();
            weeks.value = [];
            let week = [];
            for (const day of days) {
                week.push(day);
                if (week.length === 7) {
                    weeks.value.push(week);
                    week = [];
                }
            }
        };
        const showDatePicker = () => {
            isDatePickerVisible.value = true;
        };
        const selectDate = (day) => {
            if (day.date !== "") {
                selectedDate.value = new Date(
                    currentYear.value,
                    currentMonthNumber.value,
                    day.date
                );

                // Emit the selected date to the parent component
                const formattedDate = `${selectedDate.value.getFullYear()}/${(
                    selectedDate.value.getMonth() + 1
                )
                    .toString()
                    .padStart(2, "0")}/${selectedDate.value
                    .getDate()
                    .toString()
                    .padStart(2, "0")}`;
                context.emit("update:modelValue", formattedDate);
            }
        };
        const prevMonth = (event) => {
            event.preventDefault();
            currentDate.setMonth(currentDate.getMonth() - 1);
            currentYear.value = currentDate.getFullYear();
            currentMonthNumber.value = currentDate.getMonth();
            updateWeeks();
        };
        const nextMonth = (event) => {
            event.preventDefault();
            currentDate.setMonth(currentDate.getMonth() + 1);
            currentYear.value = currentDate.getFullYear();
            currentMonthNumber.value = currentDate.getMonth();
            updateWeeks();
        };
        // Initial update of the weeks
        updateWeeks();
        // Computed property to show the current month
        const displayCurrentMonth = computed(
            () => `${currentMonth.value} ${currentYear.value}`
        );
        onMounted(() => {
            updateWeeks();
        });
        const showMonthYearPopup = () => {
            isShowSelectMonthYear.value = true;
        };
        const applyMonthYear = (e) => {
            e.preventDefault();
            const year = parseInt(selectedYear.value);
            const month = parseInt(selectedMonth.value) - 1;
            if (!isNaN(year) && !isNaN(month) && month >= 0 && month < 12) {
                currentYear.value = year;
                currentMonthNumber.value = month;
                isShowSelectMonthYear.value = false;
            }
            updateWeeks();
        };
        // Array of month names
        const months = computed(() => {
            return [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ];
        });

        // Generate an array of selectable years (you can customize the range)
        const years = computed(() => {
            const startYear = 1950;
            const endYear = 2100;
            const years = [];
            for (let year = startYear; year <= endYear; year++) {
                years.push(year);
            }
            return years;
        });
        return {
            selectedDate,
            isDatePickerVisible,
            displayCurrentMonth,
            daysOfWeek,
            startDate,
            endDate,
            weeks,
            currentMonth,
            showDatePicker,
            selectDate,
            prevMonth,
            nextMonth,
            selectedYear,
            selectedMonth,
            isShowSelectMonthYear,
            showMonthYearPopup,
            applyMonthYear,
            months,
            years,
            resetSelectDate,
			clearSelectDate
        };
    },
};
</script>

<style scoped lang="scss">
.wrapper {
    position: relative;
    display: flex;
    justify-content: center;
}

.date-picker {
    width: 250px;
    height: 280px;
    border-radius: 8px;
    background-color: #fff;
    border: 1px solid #e3e3e3;
}

.date__picker-wrapper {
    padding: 10px;
}
.date-picker-header {
    height: 29px;
    display: flex;
    justify-content: space-between;
    align-items: center;

    button {
        padding: 0;
        width: 16px;
        height: 16px;
    }
}

.date-picker-body {
}

table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
}

tbody {
    height: 160px;
}

th {
    width: 32.86px;
    height: 32px;
    font-size: 14px;
    font-weight: 400;
    line-height: 22px;
    letter-spacing: -0.01em;
    color: #333333;

    p {
        display: flex;
        justify-content: center;
        align-items: center;
        height: inherit;
    }
}

td {
    width: 32.86px;
    height: 32px;
    text-align: center;
    border-radius: 8px;
}

a {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    border-radius: 0.25rem;
    transition: 0.3s all;
    color: #546e7a;
    text-decoration: none;
    font-family: Open Sans;
    font-size: 13px;
    font-weight: 600;
    line-height: 18px;
    letter-spacing: 0em;
    cursor: pointer;
}

a.faded {
    opacity: 0.4;
    pointer-events: none;
}
a.disabled {
    pointer-events: none;
    opacity: 0.4;
}

td.disabled {
    pointer-events: none;
}
td.faded {
    pointer-events: none;
}

td.rangeDate {
    background-color: #5392F9 ;
    border-radius: 8px;
}

a:hover {
    background-color: #5392F9 ;
    border-radius: 8px;
    color: #fff !important;
}

a.active {
    background-color: #009688;
    color: white;
}

a.dateInRage {
    color: #5392F9 ;
}

a.rangeDate {
    color: #fff !important;
}

button {
    cursor: pointer;
    background-color: transparent;
    border: none;
    font-size: 1rem;
}

.title-date {
    font-size: 12px !important;
    font-size: 12px;
    font-weight: 700;
    line-height: 19px;
    letter-spacing: -0.01em;
    color: #1b1b1b;
}

.button-reset {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 39px;
    border-top: 1px solid #e3e3e3;
    cursor: pointer;

    span {
        color: #4d4d4d;
        font-size: 12px;
        font-weight: 400;
        line-height: 19px;
        letter-spacing: -0.01em;
    }
}

.form__wrap-item {
    padding-bottom: 0;
}
.form-wrap-double {
    display: flex;
    justify-content: space-around;
    align-items: center;
    width: 100%;
    gap: 10px;
    margin-bottom: 16px;
    .select {
        width: 100%;
    }
    #half_width {
        border: 1px solid #e3e3e3;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 5px;
        flex: 1;
        background-image: url(../../../public/img/icon/CaretDown.svg);
        background-repeat: no-repeat;
        background-position: calc(100% - 0.75rem) center !important;
        max-height: 50px;
        margin-top: 6.5px;
        cursor: pointer;
        min-width: 100px;
    }
}
</style>
