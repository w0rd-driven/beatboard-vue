<script setup>
import { computed } from "vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
dayjs.extend(relativeTime);

const props = defineProps({
    artist: {
        type: Object,
        default: [],
    },
});

const title = computed(() =>
    `Artist - ${props.artist.name}`
);

function convertRelativeTime(date) {
    return dayjs(date).fromNow(true)
}

function millisecondsToMinutes(millis) {
    var minutes = Math.floor(millis / 60000);
    var seconds = ((millis % 60000) / 1000).toFixed(0);
    return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
}
</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <Link :href="route('artist.index')" class="text-indigo-500">Artists</Link>
                <span> > {{ artist.name }}</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex">
                        <div>
                            <div class="p-2 shrink-0">
                                <img :src="artist.image_url" alt="Artist Art" class="h-60 w-60 rounded-2xl">
                            </div>
                            <div class="p-2 w-full">
                                <p class="text-gray-600"><span class="font-semibold">Followers</span>: {{ artist.follower_count }}</p>
                                <p class="text-gray-600 text-xs">Created: {{ convertRelativeTime(artist.created_at) }} ago</p>
                            </div>
                        </div>
                        <div>
                            <p class="p-2 text-2xl">Popular</p>
                            <ul class="grid gap-2 grid-cols-1 md:grid-rows-5 md:grid-flow-col">
                                <li v-for="(track, index) in artist.tracks" class="flex justify-content-center items-center gap-x-2 pl-6">
                                    <div class="text-lg tabular-nums relative">
                                        <span class="absolute right-1 -top-[12px]">{{ index + 1 }}</span>
                                    </div>
                                    <div class=""><img :src="track.album_image_url" alt="Album Cover Art" class="h-12 w-12 rounded-2xl"></div>
                                    <div class="font-extrabold">{{ track.name }}</div>
                                    <div class="ml-auto pr-2 font-medium">{{ millisecondsToMinutes(track.duration_ms) }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
