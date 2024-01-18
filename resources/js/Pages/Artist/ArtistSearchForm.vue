<script setup>
import InputError from '@/Components/InputError.vue';
import SearchBar from '@/Components/SearchBar.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

let previousValue = null;
const searchTextInput = ref(null);

const form = useForm({
    search_text: '',
});

const searchArtist = () => {
    form.post(route('artist.search'), {
        preserveScroll: true,
        onSuccess: () => {
            previousValue = form.search_text
            form.reset()
        },
        onError: () => {
            if (form.errors.search_text) {
                form.reset('search_text');
                searchTextInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <form @submit.prevent="searchArtist" class="">
            <div>
                <SearchBar
                    id="search_text"
                    ref="searchTextInput"
                    v-model="form.search_text"
                    type="search"
                    class="mt-1 block w-full"
                    autocomplete="latest-artists"
                    :disabled="form.processing"
                />

                <InputError :message="form.errors.search_text" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">{{ previousValue }} Found.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
