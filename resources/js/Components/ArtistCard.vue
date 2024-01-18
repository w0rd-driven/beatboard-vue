<script setup>
import { Link } from '@inertiajs/vue3';
import { convertRelativeTime } from "@/relativeTime";

const props = defineProps({
    artist: {
        type: Object,
        default: {},
    },
});
</script>

<template>
    <li>
        <Link :href="route('artist.show', artist.id)"
            class="flex border items-center rounded-md cursor-pointer transition duration-500 shadow-sm hover:shadow-md hover:shadow-indigo-400">
            <div class="p-2 shrink-0">
                <img :src="artist.image_url" alt="" class="h-20 w-20 rounded-full">
            </div>
            <div class="p-2">
                <p class="font-semibold text-indigo-800 text-xl">{{ artist.name }}</p>
                <p class="text-gray-600"><span class="font-semibold">Followers</span>: {{ artist.follower_count }}</p>
                <p class="text-gray-600 text-xs">Created: {{ convertRelativeTime(artist.created_at) }} ago</p>
            </div>
        </Link>
    </li>
</template>
