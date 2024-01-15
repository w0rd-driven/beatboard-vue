<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SearchBar from '@/Components/SearchBar.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const searchTextInput = ref(null);

const form = useForm({
    search_text: '',
});

const searchArtist = () => {
    form.post(route('artist.search'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
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
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Search for Artists</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Put some useful text here.
            </p>
        </header>

        <form @submit.prevent="searchArtist" class="mt-6 space-y-6">
            <div>
                <InputLabel for="search_text" value="Search" />

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
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
