<template>
    <form
        class="max-w-5xl mx-auto"
        autocomplete="off"
        @submit.prevent="submit"
    >
        <!-- Header -->
        <div
            v-if="userCan('wms.edit')"
            class="flex flex-row items-center mb-6"
        >
            <h1 class="font-medium mr-auto text-lg">
                Edit Favourite City
                <span class="ml-2 opacity-75 text-sm">
                    {{ favouriteCity.name }}
                </span>
            </h1>

            <inertia-link
                v-if="userCan('wms.view')"
                class="
                    button button-default-responsive button-primary-subtle
                    flex flex-row items-center mr-2
                "
                :href="$route('admin.wms.favourite-cities.index')"
            >
                <icon-chevron-left class="w-5 md:mr-2"/>

                <span class="hidden md:inline">
                    Back
                </span>
            </inertia-link>

            <button
                class="
                    button button-default-responsive button-primary
                    flex flex-row items-center
                "
                :disabled="!this.formData || !this.formData.name"
                type="submit"
            >
                <icon-save class="w-5 md:mr-2"/>

                <span class="hidden md:inline">
                    Save Changes
                </span>
            </button>
        </div>

        <favourite-city-selector
            :initial-city="formData"
            @citySelected="citySelected($event)"
        />
    </form>
</template>

<script>
    import FavouriteCitySelector from "../../../../components/admin/wms/FavouriteCitySelector.vue";
    import _ from "lodash";

    export default {
        name: "AdminWmsFavouriteCityEdit",
        components: {FavouriteCitySelector},
        layout: 'admin-layout',
        props: {
            favouriteCity: {
                required: true,
                type: Object,
            },
        },
        data() {
            return {
                formData: null,
            }
        },
        created() {
            this.formData =  {
                name: this.favouriteCity.name,
                country: this.favouriteCity.country,
                state: this.favouriteCity.state,
                lat: this.favouriteCity.lat,
                lon: this.favouriteCity.lon
            }
        },
        methods: {
            citySelected(city) {
                this.formData = _.cloneDeep(city);
            },
            submit() {
                this.$inertia.put(
                    this.$route('admin.wms.favourite-cities.update', this.favouriteCity.id),
                    this.formData
                );
            }
        }
    }
</script>
