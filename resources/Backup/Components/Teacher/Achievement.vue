<script setup>
import BaseCard from "./Common/BaseCard.vue";
import moment from "moment";
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    lessons: Object,
    total_learner_applied: Object,
});
const achievementState = useForm({
    learnerTotal: props.total_learner_applied.filter(item => item.status == 1).length,
    learnerIncrease: props.total_learner_applied.filter(item => moment(item.created_at).format('YYYY-MM-DD') == moment().format('YYYY-MM-DD')).length,
    learnerReduce: props.total_learner_applied.filter(item => moment(item.updated_at).format('YYYY-MM-DD') == moment().format('YYYY-MM-DD') && moment(item.updated_at).format("YYYY/MM/DD hh:mm") !== moment(item.created_at).format("YYYY/MM/DD hh:mm")).length,
});

const totalRevenue = () => {
    let count = 0
    for (let i = 0; i < props.total_learner_applied?.length; i++) {
        if (props.total_learner_applied[i]?.status == 1) {
            if (props.total_learner_applied[i]?.style == 1) {
                count+= (props.total_learner_applied[i]?.price * 70 / 100)
            } 
            if (props.total_learner_applied[i]?.style == 2) {
                count+= (props.total_learner_applied[i]?.price * 50 / 100)
            }
        }
    }

    return count
}

const totalTodayRevenue = () => {
    let count = 0
    for (let i = 0; i < props.total_learner_applied?.length; i++) {
        if (props.total_learner_applied[i]?.status == 1 && moment(props.total_learner_applied[i]?.created_at).format('YYYY-MM-DD') == moment().format('YYYY-MM-DD')) {
            if (props.total_learner_applied[i]?.style == 1) {
                count+= (props.total_learner_applied[i]?.price * 70 / 100)
            } 
            if (props.total_learner_applied[i]?.style == 2) {
                count+= (props.total_learner_applied[i]?.price * 50 / 100)
            }
        }
    }

    return count
}

const totalRevenueYesterday = totalRevenue() - totalTodayRevenue()
const totalLessonYesterday = (props.lessons.filter(item => item.status == 1).length - props.lessons.filter(item => item.status == 1 && moment(item.created_at).format('YYYY-MM-DD') == moment().format('YYYY-MM-DD')).length)
const averageRevenueChange = (totalRevenue() / props.lessons.filter(item => item.status == 1).length - totalRevenueYesterday / totalLessonYesterday).toFixed(1)
</script>
<template>
    <BaseCard>
        <div class="achievement__wrap">
            <div class="achievement__items">
                <div>{{ lang().label.teacher_dashboard.total_revenue }}</div>
                <div class="achievement__item">
                    <div>{{ totalRevenue().toFixed(1) }} {{ lang().label.teacher_dashboard.price_unit }}</div>
                    <div class="achievement__item__add">
                        (+{{ totalTodayRevenue().toFixed(1) }}{{ lang().label.teacher_dashboard.price_unit }})
                    </div>
                </div>
            </div>
            <div class="achievement__items">
                <div>{{ lang().label.teacher_dashboard.total_lessons }}</div>
                <div class="achievement__item">
                    <div>{{ props.lessons.filter(item => item.status == 1).length }}</div>
                    <div class="achievement__item__add">
                        (+{{ props.lessons.filter(item => item.status == 1 && moment(item.created_at).format('YYYY-MM-DD') == moment().format('YYYY-MM-DD')).length }})
                    </div>
                </div>
            </div>
            <div class="achievement__items">
                <div>{{ lang().label.teacher_dashboard.total_learner }}</div>
                <div class="achievement__item">
                    <div>{{ achievementState.learnerTotal }}</div>
                    <div class="achievement__item__add" v-show="achievementState.learnerIncrease - achievementState.learnerReduce >= 0">
                        (+{{ achievementState.learnerIncrease - achievementState.learnerReduce }})
                    </div>
                    <div class="achievement__item__reduce" v-show="achievementState.learnerIncrease - achievementState.learnerReduce < 0">
                        ({{ achievementState.learnerIncrease - achievementState.learnerReduce }})
                    </div>
                </div>
            </div>
            <div class="achievement__items">
                <div>{{ lang().label.teacher_dashboard.average_per_lesson }}</div>
                <div class="achievement__item">
                    <div v-if="props.lessons.filter(item => item.status == 1).length">{{ (totalRevenue() / props.lessons.filter(item => item.status == 1).length).toFixed(1)  }} {{ lang().label.teacher_dashboard.price_unit }}</div>
                    <div v-else>0 {{ lang().label.teacher_dashboard.price_unit }}</div>
                    <div class="achievement__item__add" v-show="averageRevenueChange >= 0">
                        (+{{ averageRevenueChange }}{{ lang().label.teacher_dashboard.price_unit }})
                    </div>
                    <div class="achievement__item__add" v-show="averageRevenueChange < 0">
                        ({{ averageRevenueChange }}{{ lang().label.teacher_dashboard.price_unit }})
                    </div>
                </div>
            </div>
        </div>
    </BaseCard>
</template>
<style scoped>
.achievement__wrap {
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.achievement__items {
    display: flex;
    justify-content: space-between;
}
.achievement__item {
    display: flex;
    font-weight: bold;
}

.achievement__item__add {
    color: #5392F9 ;
    font-weight: bold;
    margin-left: 2px;
}

.achievement__item__reduce {
    font-weight: bold;
    color: #e71a41;
    margin-left: 2px;
}
</style>
