<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import PlaceCard from '@/components/PlaceCard.vue';
import Layout from '@/layouts/Layout.vue';

const places = ref([]);

onMounted(async () => {
    const response = await axios.get('/api/places');
    places.value = response.data.items;
});
</script>

<template>
    <Layout>
        <header class="my-6 text-center">
            <span class="border border-gray-900 bg-gray-100 text-xs rounded-2xl px-2 py-1">København</span>
            <h1 class="text-3xl font-bold my-2">Hvad skal vi se?</h1>
            <p>Et udvalg af spændende og flotte steder at besøge i Hovedstaden.</p>
        </header>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <PlaceCard
                v-for="place in places"
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
