<template>
    <section>
        <transition
            name="slide-left"
            mode="out-in"
        >
            <!-- City Search -->
            <div
                v-if="showCitySearch"
                key="city-search"
                class="bg-white mt-6 py-6 shadow-subtle rounded-lg"
            >
                <div class="block px-6 w-full">
                    <p class="font-medium mb-4 text-theme-base-contrast tracking-wider">
                        City Search
                    </p>

                    <input-group
                        input-autocomplete="city-name"
                        input-id="city-name"
                        input-name="city-name"
                        input-type="text"
                        input-placeholder="Search for a city"
                        label-text=""
                        v-model="citySearchName"
                        @input="onCitySearchNameChange"
                    />

                    <transition
                        name="fade"
                        mode="out-in"
                    >
                        <template v-if="isLoadingCitySearch">
                            <div class="flex flex-row items-center justify-center text-theme-base-subtle-contrast text-sm py-4 w-full">
                                <span class="flex items-center">
                                    <icon-loader-circle class="animate-spin-slow mr-2 w-5"/>
                                    <span>Loading</span>
                                </span>
                            </div>
                        </template>
                        <template v-else-if="(!cities || !cities.length) && citySearchName && isCitySearchInitialised">
                            <div class="flex flex-row items-center justify-center text-theme-base-subtle-contrast text-sm py-4 w-full">
                                <span>No cities match the search</span>
                            </div>
                        </template>
                        <template v-else-if="cities && cities.length">
                            <ul class="border -mt-1 pt-1 rounded shadow-md">
                                <li
                                    v-for="city in cities"
                                    :key="JSON.stringify(city)"
                                    class="
                                        cursor-pointer p-2 space-x-4
                                        ease-in-out duration-300 transition-all
                                        hover:bg-gray-100
                                    "
                                    @click="selectCity(city)"
                                >
                                    <strong class="font-semibold">{{ city.name }}</strong>, {{ city.state }}, {{ city.country }}
                                </li>
                            </ul>
                        </template>
                    </transition>
                </div>
            </div>

            <!-- City Details -->
            <div
                v-else
                key="city-details"
                class="bg-white mt-6 py-6 shadow-subtle rounded-lg"
            >
                <div class="block px-6 w-full">
                    <p class="font-medium mb-4 text-theme-base-contrast tracking-wider">
                        City Details
                    </p>

                    <input-group
                        input-class="border border-theme-base-subtle font-medium px-3 py-2 rounded-l w-full focus:border-theme-primary focus:outline-none focus:ring-0"
                        :error-message="getPageErrorMessage('name')"
                        input-autocomplete="city-name"
                        :input-disabled="true"
                        input-id="name"
                        input-name="name"
                        input-type="text"
                        input-wrapper-class="flex flex-row items-center"
                        label-text="Name"
                        @errorHidden="clearPageErrorMessage('name')"
                        v-model="selectedCity.name"
                    >

                        <template v-slot:inputAppend>
                            <button
                                class="border border-l-0 border-theme-primary-subtle button button-primary-subtle rounded-l-none"
                                type="button"
                                @click="clearCity"
                            >
                                Clear
                            </button>
                        </template>
                    </input-group>

                    <input-group
                        class="mt-4"
                        :error-message="getPageErrorMessage('state')"
                        input-autocomplete="state"
                        :input-disabled="true"
                        input-id="state"
                        input-name="state"
                        input-type="text"
                        label-text="State"
                        @errorHidden="clearPageErrorMessage('state')"
                        v-model="selectedCity.state"
                    />

                    <input-group
                        class="mt-4"
                        :error-message="getPageErrorMessage('country')"
                        input-autocomplete="country-code"
                        :input-disabled="true"
                        input-id="country"
                        input-name="country"
                        input-type="text"
                        label-text="Country"
                        @errorHidden="clearPageErrorMessage('country')"
                        v-model="selectedCity.country"
                    />

                    <input-group
                        class="mt-4"
                        :error-message="getPageErrorMessage('lat')"
                        input-autocomplete="latidute"
                        :input-disabled="true"
                        input-id="lat"
                        input-name="lat"
                        input-type="number"
                        label-text="Latitude"
                        @errorHidden="clearPageErrorMessage('lat')"
                        v-model="selectedCity.lat"
                    />

                    <input-group
                        class="mt-4"
                        :error-message="getPageErrorMessage('lon')"
                        input-autocomplete="longitude"
                        :input-disabled="true"
                        input-id="lon"
                        input-name="lon"
                        input-type="number"
                        label-text="Longitude"
                        @errorHidden="clearPageErrorMessage('lon')"
                        v-model="selectedCity.lon"
                    />
                </div>
            </div>

        </transition>
    </section>
</template>

<script>
    import _ from 'lodash';

    import InputGroup from "../../core/forms/InputGroup.vue";

    let CancelToken = axios.CancelToken;
    let citiesCancelToken = CancelToken.source();

    export default {
        name: "FavouriteCitySelector",
        components: {
            InputGroup
        },
        model: {
            prop: 'selectedCity'
        },
        props: {
            initialCity: {
                default: null,
                type: Object|null
            }
        },
        data() {
            return {
                cities: [],
                citySearchName: '',
                isLoadingCitySearch: false,
                isCitySearchInitialised: false,
                selectedCity: null,
                showCitySearch: true,
            }
        },
        created() {
            if (this.initialCity && this.initialCity.name) {
                this.showCitySearch = false;
            }

            if (this.initialCity !== null) {
                this.selectedCity = _.cloneDeep(this.initialCity);
            }
        },
        methods: {
            cancelCitiesLoad() {
                if (this.isLoadingCitySearch) {
                    citiesCancelToken.cancel('Cities load canceled');
                    citiesCancelToken = CancelToken.source();
                }
            },
            clearCity() {
                this.selectedCity.name = '';
                this.selectedCity.country = '';
                this.selectedCity.state = '';
                this.selectedCity.lat = '';
                this.selectedCity.lon = '';

                this.citySearchName = '';
                this.isCitySearchInitialised = false;
                this.showCitySearch = true;

                this.$emit('citySelected', _.cloneDeep(this.selectedCity));
            },
            onCitySearchNameChange: _.debounce(function () {
                this.cities = [];
                this.cancelCitiesLoad();

                if (!this.citySearchName) {
                    return;
                }

                this.isLoadingCitySearch = true;
                this.isCitySearchInitialised = true;

                axios.get(
                    this.$route('api.cities.invoke'),
                    {
                        params: {
                            city_name: this.citySearchName,
                        },
                        cancelToken: citiesCancelToken.token,
                    }
                ).then(response => {
                    this.cities = response.data;
                }).catch(error => {
                    if (!axios.isCancel(error)) {
                        this.$errorToast('Failed to load cities');
                    }
                }).then(() => {
                    this.isLoadingCitySearch = false;
                });
            }, 500),
            selectCity(city) {
                this.selectedCity.name = city.name;
                this.selectedCity.country = city.country;
                this.selectedCity.state = city.state;
                this.selectedCity.lat = city.lat;
                this.selectedCity.lon = city.lon;

                this.isCitySearchInitialised = false;
                this.showCitySearch = false;
                this.citySearchName = '';

                this.$emit('citySelected', _.cloneDeep(this.selectedCity));
            },
        },
        watch: {
            citySearchName: {
                handler: 'onCitySearchNameChange',
            }
        }

    }
</script>