<script setup>
import { MapPin } from 'lucide-vue-next';

const props = defineProps({
    title: String,
    description: String,
    location: String,
    tags: Array,
    image: String,
});
</script>

<template>
    <div class="card flex flex-col gap-2 p-4 border border-gray-200 bg-[#f8f8f8] rounded-lg shadow-md">
        <img class="object-cover w-full h-48 rounded-md" v-if="image" :src="image" :alt="title" />
        <h2 class="text-xl mt-2 font-semibold">{{ title }}</h2>
        <div v-if="tags.length" class="flex flex-wrap gap-2">
            <span
                v-for="tag in tags"
                :key="tag"
                class="px-2 py-1 text-xs rounded-full"
                :class="{
                    'bg-green-200 text-green-800': tag.toLowerCase() === 'shopping',
                    'bg-red-200 text-red-800': tag.toLowerCase() === 'mad',
                    'bg-orange-200 text-orange-800': tag.toLowerCase() === 'museum',
                    'bg-yellow-200 text-yellow-800': tag.toLowerCase() === 'seværdighed',
                    'bg-purple-200 text-purple-800': tag.toLowerCase().includes('entré'),
                }">
                {{ tag }}
            </span>
        </div>
        <p class="text-gray-600 mb-2">{{ description }}</p>
        <a class="px-4 py-3 mt-auto text-sm flex items-center gap-4 justify-between text-white bg-gray-900 rounded" :href="location" target="_blank">
            Find vej til {{ title }}
            <MapPin />
        </a>
    </div>
</template>
