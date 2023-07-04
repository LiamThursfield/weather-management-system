<template>
    <inertia-link
        class="
            bg-theme-base-subtle-contrast flex flex-col items-center justify-center opacity-75 px-4 py-32 rounded-lg shadow-lg text-center text-theme-base-subtle
            transition-opacity duration-300 ease-in-out
            hover:opacity-100
            "
        :href="$route('admin.wms.favourite-cities.create')"
    >
        <div class="flex flex-col ">
            <icon-plus class="h-8 mx-auto  w-8" />

            <p class="font-semibold mt-4 text-xl">
                New Favourite City
            </p>
        </div>
    </inertia-link>
</template>

<script>
    export default {
        name: "FavouriteCityCreateCard"
    }
</script>