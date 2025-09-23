<script setup>
import { onMounted, ref, computed } from 'vue';
import axios from 'axios';
import PlaceCard from '@/components/PlaceCard.vue';
import Layout from '@/layouts/Layout.vue';

const places = ref([]);
const selectedTag = ref('Alle');
const availableTags = ref(['Alle', 'Shopping', 'Mad', 'Museum', 'Seværdighed']);

onMounted(async () => {
    const response = await axios.get('/api/places');
    places.value = response.data.items;
});

const allTags = computed(() => {
    const tags = new Set();
    places.value.forEach(place => {
        place.tags.forEach(tag => tags.add(tag));
    });
    return ['Alle', ...Array.from(tags)];
})

const filteredPlaces = computed(() => {
    if (selectedTag.value === 'Alle') {
        return places.value;
    }
    return places.value.filter(place => place.tags.some(tag => tag.toLowerCase().includes(selectedTag.value.toLowerCase())));
})
</script>

<template>
    <Layout>
        <header class="my-6 text-center">
            <span class="border border-gray-900 bg-gray-100 text-xs rounded-2xl px-2 py-1">København</span>
            <h1 class="text-3xl font-bold my-2">Hvad skal vi se?</h1>
            <p>Et udvalg af spændende og flotte steder at besøge i Hovedstaden.</p>
        </header>
        <!-- Tabs -->
        <div class="flex flex-wrap justify-center gap-2 mb-6">
            <button
                v-for="tag in availableTags"
                :key="tag"
                @click="selectedTag = tag"
                class="px-3 py-1 rounded-2xl text-sm border cursor-pointer"
                :class="{
                'bg-gray-900 text-white border-gray-900': selectedTag === tag,
                'bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200': selectedTag !== tag
                }"
            >
                {{ tag }}
            </button>
        </div>
        <!-- Place Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <PlaceCard
                v-for="place in filteredPlaces"
                :key="place.location"
                :title="place.title"
                :description="place.description"
                :location="place.location"
                :image="place.image"
                :tags="place.tags"
            />
        </div>
    </Layout>
</template>
