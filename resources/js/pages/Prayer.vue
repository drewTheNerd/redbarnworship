<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="">
        <link rel="preload" as="image" href="/img/barn_bg_vertical.jpg">
    </Head>

    <div class="relative min-h-dvh">
        <!-- Background -->
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0 opacity-40"
            style="background-image: url('/img/barn_bg_vertical.jpg');"
        ></div>

        <main class="relative z-10">
            <section class="max-w-sm mx-auto p-2">
                <a href="/" class="w-full px-12 pt-8">
                    <img
                        src="/img/RBW_logo_transparent.png"
                        alt="Red Barn Worship Logo"
                        class="w-full h-full object-cover rounded-2xl opacity-0 scale-95 animate-fade-in delay-300"
                    />
                </a>

                <div class="w-full text-white text-left py-4">
                    <!-- <h1 class="text-3xl font-helvetica font-black opacity-0 animate-fade-in delay-300">
                        Red Barn Worship
                    </h1> -->
                    <p class="text-md px-4 font-helvetica font-regular opacity-0 animate-fade-in delay-500">
                        Friends, it has come to our immediate attention that there is HEAVINESS on campus from the evil that is lurking right now. It's very real and it's very dark and it is a weight and a shadow over everyone’s hearts. With so many tragedies, murders, and even today being 9/11. It's blindsided all of us. 
                    <br>
                    <br>
                        We feel that there is no other way to invite the Lord to fight this battle on our campus other than to get to His feet in desperation through PRAYER.
                    <br>
                    <br>
                        WE MUST RESPOND. We will be gathering tomorrow at 7pm at The Red Barn to pray over this campus and our nation. 
                    <br>
                    <br>
                        Afterward as The Spirit leads, we will cover every inch of this campus in scripture with chalk! He is the ground we stand on. He is our firm foundation- and we feel that the Lord will use this a reminder that God is not done pursuing the broken. 
                    <br>
                    <br>
                        Please join us in this time of need. It’s bigger than RBW- this is about running to The Father when we need Him most.
                    </p>
                </div>

                <div class="w-full text-black text-center px-12 mt-4 space-y-3">

                    <!-- <a 
                        href="https://www.instagram.com/redbarnworship/"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-700 group"
                    >
                        <img src="/img/instagram_logo.jpg" alt="Instagram" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">Instagram</span>
                    </a> -->

                    <a 
                        href="https://groupme.com/join_group/102740926/1pPZSsMo"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-800 group"
                    >
                        <img src="/img/groupme_logo_2.jpg" alt="GroupMe" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">GroupMe</span>
                    </a>


                    <!-- <h2
                        class="text-white text-md uppercase tracking-widest font-medium mt-3
                         transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-800"
                    >
                        Contact
                    </h2>

                    <a 
                        href="https://ig.me/m/redbarnworship"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-900 group"
                    >
                        <img src="/img/dm_icon.jpg" alt="Instagram DM Icon" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">Send us a DM!</span>
                    </a>

                    <a 
                        href="mailto:redbarnworship@gmail.com"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-1000 group"
                    >
                        <img src="/img/email_icon.jpg" alt="Email Icon" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">Email Us</span>
                    </a>



                    <h2
                        class="text-white text-md uppercase tracking-widest font-medium mt-3
                         transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-1000"
                    >
                        Photos
                    </h2>

                    <a 
                        href="https://www.dropbox.com/scl/fo/ynz8r0xxb8vregrx5423y/AGHCPrYHJoyLU27OFaITuPM?rlkey=ufubzyl28to1gm1ltat3wzue7&st=9kh3nin8&dl=0"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-1100 group"
                    >
                        <img src="/img/sylly_week_photos_cover.jpg" alt="Sylly Week Photo" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">Sylly Week</span>
                    </a>

                    <a 
                        href="https://drive.google.com/drive/folders/1pp20YmiXDiaWfrD4koRAjY0IaVXnZY0W"
                        target="_blank"
                        class="bg-white rounded-full text-md text-black/70 tracking-wide py-1 px-1 inline-flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200 ease-in-out opacity-0 animate-slide-up delay-1200 group"
                    >
                        <img src="/img/back_at_the_barn.jpg" alt="Back At The Barn Photo" class="w-10 h-10 rounded-full" />
                        <span class="w-36 group-hover:text-black transition">Back At The Barn</span>
                    </a> -->

                    <div class="h-48"></div>




                    



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

/* Animation Delay Helpers */
.delay-300  { animation-delay: 300ms; }
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
