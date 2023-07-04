<template>
    <div>
        <div
            class="flex flex-row items-center mb-6"
        >
            <h1 class="font-medium mr-auto text-lg">
                Dashboard
            </h1>
        </div>

        <div
            class="
                gap-4 grid grid-cols-1
                sm:grid-cols-2
                xl:grid-cols-4
            "
        >
            <weather-card
                v-for="city in favouriteCities"
                :key="city.id"
                :city="city"
            />

            <favourite-city-create-card />
        </div>

    </div>
</template>

<script>

    import FavouriteCityCreateCard from "../../../components/admin/wms/FavouriteCityCreateCard.vue";
    import WeatherCard from "../../../components/admin/wms/WeatherCard.vue";

    export default {
        name: "AdminHomeIndex",
        components: {
            FavouriteCityCreateCard,
            WeatherCard
        },
        layout: 'admin-layout',
        props: {
            favouriteCities: {
                type: Array,
                required: true
            }
        },
    }
</script>
