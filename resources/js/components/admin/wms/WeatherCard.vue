<template>
   <div class="bg-white flex flex-col p-4 rounded-lg shadow-lg text-center">
       <h1 class="font-semibold text-lg">
           {{ city.name }}
       </h1>
       <h2 class="flex-1 -mt-1 text-theme-base-subtle-contrast">
           {{ subHeading }}
       </h2>

       <div
           v-if="isLoading"
           class="mt-16"
       >
           <icon-loader-circle class="animate-spin-slow h-8 mx-auto opacity-50 w-8"/>
       </div>

       <template
           v-else
       >
           <div class="items-center mt-4">
               <img
                   v-if="icon"
                   class="h-28 mx-auto w-28"
                   :src="`https://openweathermap.org/img/wn/${icon}@4x.png`"
               />
               <p
                   v-if="weatherMain"
                   class="font-semibold mt-4 text-theme-base-contrast"
               >
                   {{ weatherMain }}
               </p>
               <p
                   v-if="weatherDescription"
                   class="text-theme-base-subtle-contrast"
               >
                   {{ weatherDescription }}
               </p>
           </div>

           <p
               v-if="temp !== null"
               class="bg-theme-base font-semibold mt-6 px-4 py-2 rounded-md text-4xl"
           >
               {{ temp }}<span class="ml-1 opacity-75 text-xl">°C</span>
           </p>
       </template>
   </div>
</template>

<script>
    export default {
        name: "WeatherCard",
        props: {
            city: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                isLoading: false,
                weather: null
            }
        },
        computed: {
            icon() {
                try {
                    return this.weather.weather[0].icon
                } catch (e) {
                    return false;
                }
            },
            subHeading() {
                let subHeading = [];

                if (this.city.state) {
                    subHeading.push(this.city.state);
                }

                if (this.city.country) {
                    subHeading.push(this.city.country);
                }

                return subHeading.join(', ');
            },
            temp() {
                try {
                    return this.weather.main.temp;
                } catch (e) {
                    return null;
                }
            },
            weatherMain() {
                try {
                    return this.weather.weather[0].main;
                } catch (e) {
                    return null;
                }
            },
            weatherDescription() {
                try {
                    return this.weather.weather[0].description;
                } catch (e) {
                    return null;
                }
            }
        },
        mounted() {
            this.fetchWeather();
        },
        methods: {
            fetchWeather() {
                this.isLoading = true;

                axios.get(
                    this.$route('api.weather.by-lat-lon', {
                        lat: this.city.lat,
                        lon: this.city.lon
                    }
                    )).then((response) => {
                    this.weather = response.data;
                }).catch((error) => {
                    this.$errorToast('Failed to fetch weather data for ' + this.city.name);
                }).finally(() => {
                    this.isLoading = false;
                });
            }
        }
    }
</script>