<script setup>
import { useForm } from '@inertiajs/vue3';
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    kid: Object,
    lesson: Object,
});

const ageRange = props.lesson.target_age_to - (props.lesson.target_age_to - props.lesson.target_age_from) - 1

const kidState = useForm({
    targetAge: props.lesson.target_age_to - props.lesson.target_age_from + 1,
});

if(props.kid.name && props.kid.birthday <= props.lesson.target_age_to && props.kid.birthday >= props.lesson.target_age_from) {
    props.kid.checked = true;
}
</script>
<template> 
    <div class="item" :class="(props.kid.checked) ? 'active' : 'un-fill'">
        <div class="left">
            <input type="checkbox" :disabled="true" v-if="props.kid.birthday > props.lesson.target_age_to || props.kid.birthday < props.lesson.target_age_from"/>
            <input type="checkbox" :disabled="true" v-else-if="!props.kid.name"/>
            <input type="checkbox" v-model="props.kid.checked" v-else/>
        </div>
        <div class="input center">
            <label for="">name</label>
            <input type="text" placeholder="name" :value="props.kid.name" v-if="props.kid.id" :readonly="true">
            <input type="text" placeholder="name" v-model="props.kid.name" v-if="!props.kid.id">
        </div>
        <div class="input right">
            <label for="">Ages</label>
            <div class="block" v-if="props.kid.id">
                <select :disabled="true">
                    <option selected :value="props.kid.birthday">{{ props.kid.birthday }}</option>
                </select>
                <i><img src="/img/icon/CaretDown.svg" alt=""></i>
            </div>
            <div class="block" v-if="!props.kid.id">
                <select v-model="props.kid.birthday">
                    <option v-for="age in kidState.targetAge" :value="age + ageRange">{{ age + ageRange }}</option>
                </select>
                <i><img src="/img/icon/CaretDown.svg" alt=""></i>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import "./_kidSelect.scss";
</style>