import { ref } from "vue";

export const timeRangeLesson = ref([]);
const startTime = 5;
const endTime = 120;
const step = 5;

for (let i = startTime; i <= endTime; i += step) {
    timeRangeLesson.value.push(i);
}
