<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title=""></Head>

    <div class="relative min-h-dvh">
        <!-- Background -->
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0 opacity-50"
            style="background-image: url('/img/barn_bg_vertical.jpg');"
        ></div>

        <main class="relative z-10">
            <section class="max-w-sm mx-auto p-2">
                <div class="w-full px-12 pt-8">
                    <img
                        src="/img/RBW_logo_transparent.png"
                        alt="Red Barn Worship Logo"
                        class="w-full h-full object-cover rounded-2xl opacity-0 scale-95 animate-fade-in delay-100"
                    />
                </div>

                <div class="w-full text-white text-center py-4">
                    <!-- <h1 class="text-3xl font-helvetica font-black opacity-0 animate-fade-in delay-300">
                        Red Barn Worship
                    </h1> -->
                    <p class="text-lg font-helvetica font-regular opacity-0 animate-fade-in delay-300">
                        Next Worship Night: <br> 7pm, Friday, August 22nd at The Red Barn!
                    </p>
                </div>

                <div class="w-full text-black text-center px-12 mt-4 space-y-3">

                    <a 
                        href="https://www.instagram.com/redbarnworship/"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-700 group"
                    >
                        <img src="/img/instagram_logo.jpg" alt="Instagram" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">Instagram</span>
                    </a>

                    <a 
                        href="https://groupme.com/join_group/102740926/1pPZSsMo"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-700 group"
                    >
                        <img src="/img/groupme_logo_2.jpg" alt="GroupMe" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">GroupMe</span>
                    </a>

                    <a 
                        href="mailto:redbarnworship@gmail.com"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-700 group"
                    >
                        <img src="/img/email_icon.jpg" alt="Email Icon" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">Contact</span>
                    </a>

                    <!-- <a 
                        href="https://open.spotify.com/album/1XTO9M1CWXLMGY0dUcRfnO"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-700 group"
                    >
                        <img src="/img/spotify_logo_transparent.png" alt="Spotify" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">Need a ride?</span>
                    </a> -->


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
.delay-500 { animation-delay: 500ms; }
.delay-700 { animation-delay: 700ms; }
.delay-900 { animation-delay: 900ms; }

body {
    background-color: #7896b4;
}
</style>
