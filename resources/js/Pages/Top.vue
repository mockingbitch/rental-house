<script setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage();
</script>

<template>
    <div>
        <h1>{{ page.props.auth?.user?.first_name + ' ' + page.props.auth?.user?.last_name }}</h1>
    </div>
</template>

<style>
</style>
