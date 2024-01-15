<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative w-full border-0 p-0">
        <input
            class="p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-100 rounded-md shadow-sm border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
            placeholder="Search Artists..."
            v-model="model"
            ref="input"
            autofocus
            required>
        <button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-indigo-700 rounded-e-lg border border-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
            <span class="sr-only">Search</span>
        </button>
    </div>
</template>
