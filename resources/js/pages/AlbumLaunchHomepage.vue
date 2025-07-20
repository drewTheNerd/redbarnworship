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

        <main class="relative z-10">
            <section class="max-w-sm mx-auto p-2">
                <div class="w-full px-20 py-8">
                    <img
                        src="/img/album_cover.jpg"
                        alt="Album Cover"
                        class="w-full h-full object-cover rounded-2xl border-4 border-white"
                    />
                </div>

                <div class="w-full text-black text-center">
                    <h1 class="text-3xl font-helvetica font-black">
                        At The Arena (Live)
                    </h1>

                    <p class="text-lg font-helvetica font-regular">
                        Live worship album now available!
                    </p>
                </div>

                <div class="w-full text-black text-center px-12 mt-4 space-y-3">

                    <a 
                        href="https://open.spotify.com/album/1XTO9M1CWXLMGY0dUcRfnO"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-widest py-1 px-1 inline-flex items-center justify-center shadow-md"
                    >
                        <img
                            src="/img/spotify_logo_transparent.png"
                            alt="Spotify"
                            class="w-10 h-10 rounded-full"
                        />
                        <span class="w-36">Spotify</span>
                    </a>

                    <a 
                        href="https://music.apple.com/us/album/homecoming-tremble-single/1825049627"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-widest py-1 px-1 inline-flex items-center justify-center shadow-md"
                    >
                        <img
                            src="/img/apple_music_logo.png"
                            alt="Spotify"
                            class="w-10 h-10 rounded-full"
                        />
                        <span class="w-36">Apple Music</span>
                    </a>

                </div>

















            </section>
        </main>
    </div>
</template>