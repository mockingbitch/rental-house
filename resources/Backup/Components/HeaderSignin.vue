<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

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

const handelBack = () => {
    history.back();
}
</script>

<template>
       <div class="headerSignin">
        <div class="container">
            <div class="navPc">
                <div class="navPc__left">
                    <Link :href="route('top')">
                        <div class="logo">
                            <i><img src="/img/logo/RentalHouses.svg" alt="RentalHouses"></i>
                        </div>
                        <h1>RentalHouses</h1>
                    </Link>
                </div>
                <div class="navPc__search">
                    <button class="buttonImage left">
                        <img src="/img/icon/Search.svg" alt="">
                    </button>
                    <div class="search__wrap">
                        <input class="pc searchInput" type="text" placeholder="日付、年齢、料金、フリーキーワードで検索" readonly/>
                        <textarea class="mobile searchInput" type="text" placeholder="日付、年齢、料金、&#13;&#10;フリーキーワードで検索"></textarea>
                    </div>
                    <button class="buttonImage right">
                        <img src="/img/icon/Category.svg" alt="">
                    </button>
                </div>
                <div class="navPc__right">
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('login.method')"
                        class="buttonHeader"
                        >Sign in</Link
                    >
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('register.method')"
                        class="buttonHeader green"
                        >Join</Link
                    >
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('logout')"
                        class="buttonHeader"
                        >Logout</Link
                    >
                    <!-- <button class="buttonImage">
                        <img src="/img/icon/List.svg" alt="" />
                    </button> -->
                    <Humberger />
                </div>
                <div class="lineFull"></div>
            </div>
            <div class="navMobile">
                <div class="navMobile__wrap">
                    <i @click="handelBack"><img src="/img/icon/arrownLeft.svg" alt="back"></i>
                    <Link :href="route('top')">
                    <div class="logo">
                        <i><img src="/img/logo/dottre.svg" alt="RentalHouses"></i>
                    </div>
                    <h1>RentalHouses</h1>
                    </Link>
                </div>
            </div>
            <div class="lineFull"></div>
        </div>
    </div>
</template>