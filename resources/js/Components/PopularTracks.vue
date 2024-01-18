<script setup>
const props = defineProps({
    tracks: {
        type: Array,
        default: [],
    },
});

function millisecondsToMinutes(millis) {
    var minutes = Math.floor(millis / 60000);
    var seconds = ((millis % 60000) / 1000).toFixed(0);
    return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
}
</script>

<template>
    <div>
        <p class="p-2 text-2xl">Popular</p>
        <ul class="grid gap-2 grid-cols-1 lg:grid-rows-5 lg:grid-flow-col">
            <li v-for="(track, index) in tracks" class="flex justify-content-center items-center gap-x-2 pl-6">
                <div class="text-lg tabular-nums relative shrink-0">
                    <span class="absolute right-1 -top-[12px]">{{ index + 1 }}</span>
                </div>
                <div class="shrink-0"><img :src="track.album_image_url" alt="Album Cover Art" class="h-12 w-12 rounded-2xl"></div>
                <div class="font-extrabold shrink-0">{{ track.name }}</div>
                <div class="ml-auto pr-2 font-medium shrink-0">{{ millisecondsToMinutes(track.duration_ms) }}</div>
            </li>
        </ul>
    </div>
</template>
