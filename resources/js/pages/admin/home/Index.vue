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
            v-if="favouriteCities && favouriteCities.length"
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
        </div>

        <div
            v-else
            class="bg-white p-6 shadow-subtle rounded-lg"
        >
            <h1 class="font-semibold text-gray-850">
                Welcome
            </h1>

            <p class="mt-2">
                Add some favourite cites to view their current weather.
            </p>
        </div>
    </div>
</template>

<script>

    import WeatherCard from "../../../components/admin/wms/WeatherCard.vue";

    export default {
        name: "AdminHomeIndex",
        components: {
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
