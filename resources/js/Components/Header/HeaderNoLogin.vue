<script setup>
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Components/Modal/Modal.vue';

const formSearch = useForm({
    keyword: '',
    category: '',
    age: '',
    start_date: '',
    end_date: '',
    price_range: ''
})

const submit = () => {
    formSearch.get(route('search'))
}

const showModalSearch = ref(false);
</script>

<style lang="scss" scoped>
@import './header.scss';
</style>

<template>
    <header>
        <div class="container">
            <div class="navPc">
                <div class="navPc__left">
                    <Link :href="route('top')">
                        <div class="logo">
                            <i><img src="/img/logo/RentalHouse.svg" alt="RentalHouses"></i>
                        </div>
                        <h1>RentalHouse</h1>
                    </Link>
                </div>
            </div>
            <div class="navMobile">
                <div class="navMobile__wrap">
                    <i><img src="/img/icon/arrownLeft.svg" alt="back"></i>
                    <div class="logo">
                        <i><img src="/img/logo/RentalHouse.svg" alt="RentalHouses"></i>
                    </div>
                    <h1>RentalHouse</h1>
                </div>
            </div>
        </div>
    </header>
</template>