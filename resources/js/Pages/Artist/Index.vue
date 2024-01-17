<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
dayjs.extend(relativeTime);

const props = defineProps({
    artists: {
        type: Array,
        default: [],
    },
});

function convertRelativeTime(date) {
    return dayjs(date).fromNow(true)
}
</script>

<template>
    <Head title="Artists" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Artists</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <ul>
                            <li v-for="artist in artists" class="">
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
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
