<template>
    <form
        class="max-w-5xl mx-auto"
        autocomplete="off"
        @submit.prevent="submit"
    >
        <!-- Header -->
        <div
            v-if="userCan('wms.create')"
            class="flex flex-row items-center mb-6"
        >
            <h1 class="font-medium mr-auto text-lg">
                Create Favourite City
            </h1>

            <inertia-link
                v-if="userCan('cms.view')"
                class="
                    button button-default-responsive button-primary-subtle
                    flex flex-row items-center mr-2
                "
                :href="$route('admin.wms.favourite-cities.index')"
            >
                <icon-chevron-left
                    class="w-5 md:mr-2"
                />
                <span
                    class="hidden md:inline"
                >
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

                <span
                    class="hidden md:inline"
                >
                    Create Favourite City
                </span>
            </button>
        </div>

        <favourite-city-selector
            v-model="this.formData"
        />
    </form>
</template>

<script>
    import FavouriteCitySelector from "../../../../components/admin/wms/FavouriteCitySelector.vue";

    export default {
        name: "AdminWmsFavouriteCityEdit",
        components: {FavouriteCitySelector},
        layout: 'admin-layout',
        data() {
            return {
                formData: {
                    name: '',
                    country: '',
                    state: '',
                    lat: '',
                    lon: ''
                },
            }
        },
        methods: {
            submit() {
                this.$inertia.post(
                    this.$route('admin.wms.favourite-cities.store'),
                    this.formData
                );
            }
        }
    }
</script>