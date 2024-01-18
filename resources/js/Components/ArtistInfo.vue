<script setup>
import { convertRelativeTime } from "@/relativeTime";

const props = defineProps({
    artist: {
        type: Object,
        default: {},
    },
});
</script>

<template>
    <div class="shrink-0">
        <div class="p-2 shrink-0">
            <img :src="artist.image_url" alt="Artist Art" class="h-60 w-60 rounded-2xl">
        </div>
        <div class="p-2 w-full">
            <p class="text-gray-600"><span class="font-semibold">Followers</span>: {{ artist.follower_count }}</p>
            <p class="text-gray-600 text-xs">Created: {{ convertRelativeTime(artist.created_at) }} ago</p>
        </div>
    </div>
</template>
