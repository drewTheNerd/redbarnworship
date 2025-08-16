<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="At The Arena (Live)"></Head>

    <div class="relative min-h-dvh">
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
                        class="w-full h-full object-cover rounded-2xl border-4 border-white shadow-md opacity-0 scale-95 animate-fade-in delay-100"
                    />
                </div>

                <div class="w-full text-black text-center">
                    <h1 class="text-3xl font-helvetica font-black opacity-0 animate-fade-in delay-300">
                        At The Arena (Live)
                    </h1>
                    <p class="text-lg font-helvetica font-regular opacity-0 animate-fade-in delay-300">
                        Live worship album now available!
                    </p>
                </div>

                <div class="w-full text-black text-center px-12 mt-4 space-y-3">

                    <a 
                        href="https://open.spotify.com/album/1XTO9M1CWXLMGY0dUcRfnO"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-700 group"
                    >
                        <img src="/img/spotify_logo_transparent.png" alt="Spotify" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">Spotify</span>
                    </a>

                    <a 
                        href="https://music.apple.com/us/album/homecoming-tremble-single/1825049627"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-800 group"
                    >
                        <img src="/img/apple_music_logo.png" alt="Apple Music" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">Apple Music</span>
                    </a>

                    <a 
                        href="https://youtube.com/watch?v=rz8kiJDpogE"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-900 group"
                    >
                        <img src="/img/youtube_icon.png" alt="YouTube" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">YouTube</span>
                    </a>


                    <!-- <h2
                        class="text-black text-md uppercase tracking-widest font-medium mt-1
                         transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-1000"
                    >
                        More
                    </h2> -->

                    <a 
                        href="/about"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-1000 group mt-4"
                    >
                        <!-- <img src="/img/dm_icon.jpg" alt="Instagram DM Icon" class="w-10 h-10 rounded-full" /> -->
                        <span class="w-58 group-hover:text-black transition py-1">About Red Barn Worship <i class="fa-solid fa-chevron-right pl-2"></i></span>
                    </a>


                </div>

















            </section>
        </main>
    </div>
</template>

<style scoped>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.98); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(1rem); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.7s ease-out forwards;
}

.animate-slide-up {
    animation: slideUp 0.7s ease-out forwards;
}

/* Delay helpers */
.delay-100 { animation-delay: 100ms; }
.delay-300 { animation-delay: 300ms; }
.delay-400  { animation-delay: 400ms; }
.delay-500  { animation-delay: 500ms; }
.delay-600  { animation-delay: 600ms; }
.delay-700  { animation-delay: 700ms; }
.delay-800  { animation-delay: 800ms; }
.delay-900  { animation-delay: 900ms; }
.delay-1000 { animation-delay: 1000ms; }
.delay-1100 { animation-delay: 1100ms; }
.delay-1200 { animation-delay: 1200ms; }
.delay-1300 { animation-delay: 1300ms; }
.delay-1400 { animation-delay: 1400ms; }
.delay-1500 { animation-delay: 1500ms; }
.delay-1600 { animation-delay: 1600ms; }
.delay-1700 { animation-delay: 1700ms; }
.delay-1800 { animation-delay: 1800ms; }
.delay-1900 { animation-delay: 1900ms; }
.delay-2000 { animation-delay: 2000ms; }

body {
    background-color: #7896b4;
}
</style>
