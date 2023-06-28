<template>
    <div>
        <main
            id="website-layout"
        >
            <slot />
        </main>
    </div>
</template>

<script>
    export default {
        name: "WebsiteLayout",
        metaInfo() {
            return {
                title: 'Weather Management System',
                meta: [
                    {
                        name: 'description',
                        content: 'Weather Management System - Powered by Laravel TVI',
                    }
                ]
            }
        },
    }
</script>
