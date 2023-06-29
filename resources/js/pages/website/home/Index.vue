<template>
    <div class="bg-gray-100 flex flex-col min-h-screen min-w-screen">
        <nav class="flex flex-row justify-end px-6 py-4">
            <ul class="flex flex-row font-medium space-x-4 text-theme-base-contrast">
                <template v-if="loggedIn">
                    <li>
                        <a
                            class="hover:text-theme-primary"
                            :href="$route('admin.index')"
                        >
                            Admin
                        </a>
                    </li>
                </template>
                <template v-else>
                    <li v-if="$routeCheck('login')">
                        <inertia-link
                            class="hover:text-theme-primary"
                            :href="$route('login')"
                        >
                            Login
                        </inertia-link>
                    </li>
                    <li v-if="$routeCheck('register')">
                        <inertia-link
                            class="hover:text-theme-primary"
                            :href="$route('register')"
                        >
                            Register
                        </inertia-link>
                    </li>
                </template>
            </ul>
        </nav>

        <!-- Content Section -->
        <section class="flex flex-1 flex-col items-center justify-center p-8">
            <h1
                class="
                    font-bold text-4xl text-center text-theme-base-contrast
                    md:text-6xl
                "
            >
                Weather Management System
            </h1>
            <h2
                class="
                    font-semibold mt-8 text-center text-l text-theme-base-subtle-contrast
                    md:text-xl
                "
            >
                <template v-if="loggedIn">
                    Go to
                    <inertia-link
                        class="
                            text-theme-primary
                            hover:text-theme-primary-hover
                        "
                        :href="$route('admin.index')"
                    >
                        Admin
                    </inertia-link>
                    to view the weather in your favourite cities!
                </template>

                <template v-else>
                    <template v-if="$routeCheck('login')">
                        <inertia-link
                            class="
                                text-theme-primary
                                hover:text-theme-primary-hover
                            "
                            :href="$route('login')"
                        >
                            Login
                        </inertia-link>
                    </template>

                    <template v-if="$routeCheck('login') && $routeCheck('register')">
                        /
                    </template>

                    <template v-if="$routeCheck('register')">
                        <inertia-link
                            class="
                                text-theme-primary
                                hover:text-theme-primary-hover
                            "
                            :href="$route('register')"
                        >
                            Register
                        </inertia-link>
                    </template>

                    to view the weather in your favourite cities!
                </template>
            </h2>
        </section>
    </div>
</template>

<script>
    export default {
        name: "Index",
        layout: 'website-layout',
        computed: {
            loggedIn() {
                return this.$page.props.auth.user;
            }
        }
    }
</script>