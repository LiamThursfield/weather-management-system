<template>
    <section>
        <!-- Header -->
        <div
            class="flex flex-row items-center mb-6"
        >
            <h1 class="font-medium mr-auto text-lg">
                Favourite Cities
            </h1>

            <inertia-link
                v-if="userCan('wms.create')"
                class="
                    button button-default-responsive button-primary
                    flex flex-row items-center
                "
                :href="$route('admin.wms.favourite-cities.create')"
            >
                <icon-plus class="w-5 md:mr-2"/>

                <span
                    class="hidden md:inline"
                >
                    Add Favourite City
                </span>
            </inertia-link>
        </div>

        <div class="bg-white py-6 shadow-subtle rounded-lg">
            <h1 class="font-semibold px-6 text-gray-850">
                Search
                <button
                    class="
                        text-sm text-theme-base-subtle-contrast
                        focus:outline-none focus:text-theme-primary
                        hover:text-theme-primary
                    "
                    @click="setSearchOptions"
                >
                    (Clear)
                </button>
            </h1>

            <!-- Search Panel -->
            <div
                class="
                    flex flex-col items-center mt-4 px-6 space-y-4
                    md:flex-row md:space-y-0 md:space-x-8
                "
            >
                <div class="w-full md:w-1/4">
                    <input-group
                        input-autocomplete="favourite_city_name_search"
                        input-class="form-control form-control-short"
                        input-id="favourite_city_name"
                        input-name="favourite_city_name"
                        input-placeholder="City Name"
                        input-type="text"
                        :label-hidden="true"
                        label-text="City Name"
                        v-model="editableSearchOptions.favourite_city_name"
                    />
                </div>

                <div class="w-full md:w-1/4">
                    <input-group
                        input-autocomplete="favourite_city_state_search"
                        input-class="form-control form-control-short"
                        input-id="favourite_city_state"
                        input-name="favourite_city_state"
                        input-placeholder="State"
                        input-type="text"
                        :label-hidden="true"
                        label-text="State"
                        v-model="editableSearchOptions.favourite_city_state"
                    />
                </div>

                <div class="w-full md:w-1/4">
                    <input-group
                        input-autocomplete="favourite_city_country_search"
                        input-class="form-control form-control-short"
                        input-id="favourite_city_country"
                        input-name="favourite_city_country"
                        input-placeholder="Country"
                        input-type="text"
                        :label-hidden="true"
                        label-text="Country"
                        v-model="editableSearchOptions.favourite_city_country"
                    />
                </div>
            </div>

            <!-- No Results -->
            <p
                v-if="!favouriteCitiesData"
                class="bg-theme-base-subtle mt-6 mx-6 px-6 py-4 rounded text-center text-theme-base-subtle-contrast"
            >
                No favourite cities
            </p>

            <!-- Search Results -->
            <template v-else>
                <!-- Search Results -->
                <div class="block mt-8 overflow-x-auto w-full">
                    <table
                        class="table table-hover table-striped w-full"
                    >
                        <thead>
                        <tr>
                            <th v-if="userCan('wms_admin.view')">
                                User
                            </th>
                            <th>Name</th>
                            <th>State</th>
                            <th>Country</th>
                            <th v-if="showFavouriteCitiesActions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="(city, index) in favouriteCitiesData"
                            :key="`city-${city.id}`"
                        >
                            <td v-if="userCan('wms_admin.view')">
                                {{ city.user.name }}
                            </td>
                            <td>
                                {{ city.name }}
                            </td>
                            <td>
                                {{ city.state }}
                            </td>
                            <td>
                                {{ city.country }}
                            </td>
                            <td v-if="showFavouriteCitiesActions">
                                <div class="flex flex-row items-center justify-end -mx-1">
                                    <inertia-link
                                        v-if="userCan('wms.edit')"
                                        class="
                                            flex flex-row items-center inline-flex mx-1 px-2 py-1 rounded text-theme-base-subtle-contrast text-sm tracking-wide
                                            focus:outline-none focus:ring
                                            hover:bg-theme-info hover:text-theme-info-contrast
                                        "
                                        :href="$route('admin.wms.favourite-cities.edit', city.id)"
                                        title="Edit Favourite City"
                                    >
                                        <icon-edit class="w-4" />
                                    </inertia-link>

                                    <button
                                        v-if="userCan('wms.delete')"
                                        class="
                                            flex flex-row items-center inline-flex mx-1 px-2 py-1 rounded text-theme-base-subtle-contrast text-sm tracking-wide
                                            focus:outline-none focus:ring
                                            hover:bg-theme-danger hover:text-theme-danger-contrast
                                        "
                                        title="Delete Favourite City"
                                        @click="checkDelete(city)"
                                    >
                                        <icon-trash class="w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </template>

            <!-- Pagination -->
            <div
                v-if="showPagination"
                class="flex flex-row justify-center mt-12 px-6"
            >
                <pagination :pagination="favouriteCities.pagination" />
            </div>


            <!-- Modals -->
            <confirmation-modal
                confirm-text="Delete"
                confirm-type="danger"
                :show-modal="showDeleteModal"
                :message-text="deleteModalText"
                @cancelAction="cancelDelete"
                @closeModal="cancelDelete"
                @confirmAction="confirmDelete"
            />
        </div>
    </section>
</template>

<script>
    import _ from "lodash";
    import { router } from '@inertiajs/vue2';
    import ConfirmationModal from "../../../../components/core/modals/ConfirmationModal";
    import InputGroup from "../../../../components/core/forms/InputGroup";

    export default {
        name: "AdminWmsFavouriteCityIndex",
        components: {
            ConfirmationModal,
            InputGroup
        },
        layout: 'admin-layout',
        props: {
            searchOptions: {
                required: true,
                type: Array | Object,
            },
            favouriteCities: {
                required: true,
                type: Object,
            },
        },
        data() {
            return {
                editableSearchOptions: {
                    favourite_city_country  : null,
                    favourite_city_name     : null,
                    favourite_city_state    : null,
                    per_page                : 15,
                },
                isInitialised: false,
                isLoadingDelete: false,
                showDeleteModal: false,
                favouriteCityToDelete: null,
            }
        },
        computed: {
            favouriteCitiesData() {
                if (!this.favouriteCities || !this.favouriteCities.data || this.favouriteCities.data.length < 1) {
                    return false;
                }

                return this.favouriteCities.data;
            },
            deleteModalText() {
                try {
                    return 'Do you really want to delete \'' + this.favouriteCityToDelete.name + '\'?';
                } catch (e) {
                    return 'Do you really want to delete this favourite?'
                }
            },
            showFavouriteCitiesActions() {
                return this.userCan('wms.edit') || this.userCan('wms.delete');
            },
            showPagination() {
                try {
                    return this.favouriteCities.pagination.last_page > 1;
                } catch (e) {
                    return false;
                }
            },
        },
        mounted() {
            this.setSearchOptions(this.searchOptions);
        },
        methods: {
            cancelDelete() {
                if (!this.isLoadingDelete) {
                    this.showDeleteModal = false;
                    this.favouriteCityToDelete = null;
                }
            },
            checkDelete(favouriteCity) {
                this.showDeleteModal = true;
                this.favouriteCityToDelete = favouriteCity;
            },
            confirmDelete() {
                if (this.isLoadingDelete) {
                    return this.$errorToast('It\'s only possible to delete one favourite at a time.');
                }
                this.$inertia.delete(
                    this.$route('admin.wms.favourite-cities.destroy', this.favouriteCityToDelete.id),
                    {
                        only: [
                            'flash',
                            'favouriteCities'
                        ]
                    }
                );

                this.favouriteCityToDelete = null
                this.showDeleteModal = false;
            },
            onSearchOptionsUpdate: _.debounce(function () {
                if (!this.isInitialised) {
                    this.isInitialised = true;

                    // If there are already search results, don't attempt search
                    if (this.favouriteCitiesData) {
                        return;
                    }
                }

                router.get(
                    this.$route('admin.wms.favourite-cities.index'),
                    this.editableSearchOptions,
                    {
                        only: ['favouriteCities'],
                        preserveState: true,
                    }
                );
            }, 500),
            setSearchOptions(new_options = {}) {
                let options = {
                    favourite_city_country  : '',
                    favourite_city_name     : '',
                    favourite_city_state    : '',
                    per_page                : 15,
                }

                try {
                    // Overwrite the defaults with any new options
                    _.forEach(new_options, (option, key) => {
                        options[key] = option;
                    })
                } catch (e) {
                    console.log(e);
                }

                this.editableSearchOptions = _.cloneDeep(options);
            }
        },
        watch: {
            editableSearchOptions: {
                deep: true,
                handler: 'onSearchOptionsUpdate'
            }
        }
    }
</script>
