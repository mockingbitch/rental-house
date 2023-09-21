<script setup>
defineProps({
    step: Number,
});
</script>
<template>
    <div class="category">
        <h2 class="green-cl">新しいLessonを登録しましょう！</h2>
    </div>
    <div class="progress">
        <div class="progress__wrap">
            <div
                :class="`progressBar bar-1 ${step > 1 ? '' : 'green-bar'}`"
            ></div>
            <div
                :class="`progressBar bar-2 ${step > 2 ? '' : 'green-bar'}`"
            ></div>
            <div class="circle" :class="step > 1 ? 'finish' : 'active'">
                <img src="/img/icon/StepNumber/NumberOne.png" alt="" />
                <span>{{ lang().label.multi_step.step_1 }}</span>
            </div>
            <div
                class="circle"
                :class="step == 2 ? 'active' : step < 2 ? '' : 'finish'"
            >
                <img
                    v-if="step < 2"
                    src="/img/icon/StepNumber/NumberTwo-green.png"
                    alt=""
                />
                <img v-else src="/img/icon/StepNumber/NumberTwo.png" alt="" />
                <span>{{ lang().label.multi_step.step_2 }}</span>
            </div>
            <div class="circle" :class="step < 3 ? '' : 'active'">
                <img
                    v-if="step < 3"
                    src="/img/icon/StepNumber/NumberThree-green.png"
                    alt=""
                />
                <img v-else src="/img/icon/StepNumber/NumberThree.png" alt="" />
                <span>{{ lang().label.multi_step.step_3 }}</span>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import "./_multistep.scss";
.green-bar {
    background-color: #418997 !important;
}

.progress__wrap .progressBar {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: #b1b1b1;
    height: 2px;
    width: 50%;
    transition: 0.4s ease-in;
}

.bar-1 {
    left: 0;
}
.bar-2 {
    left: 50%;
}
</style>
