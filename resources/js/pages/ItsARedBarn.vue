<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title=""></Head>

    <div class="relative min-h-screen">
        <!-- Background -->
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0"
            style="background-image: url('/img/background.jpg');"
        ></div>

        <!-- Content -->
        <div class="relative z-10 text-white p-8">
            <h1 class="text-4xl">Welcome to the site</h1>
        </div>
    </div>
</template>