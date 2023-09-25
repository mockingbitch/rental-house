<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    articles: Object,
});
</script>

<template>
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.auth.user" :href="route('logout')">Logout</Link>
            <Link v-if="!$page.props.auth.user" :href="route('login')">Login</Link>
        </div>
    </div>
</template>
