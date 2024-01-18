<script setup>
import { computed } from "vue";
import ArtistInfo from "@/Components/ArtistInfo.vue";
import PopularTracks from "@/Components/PopularTracks.vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    artist: {
        type: Object,
        default: [],
    },
});

const title = computed(() =>
    `Artist - ${props.artist.name}`
);
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
                        <ArtistInfo :artist="artist" />
                        <PopularTracks :tracks="artist.tracks" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
