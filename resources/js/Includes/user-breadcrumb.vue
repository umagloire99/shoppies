<template>
    <section class="py-2 bg-gray-2" v-if="pageRoutes != null && pageRoutes.length !== 0">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-site py-0 d-flex justify-content-center">
                    <li v-for="pageRoute in pageRoutes" class="breadcrumb-item pl-0 d-flex align-items-center">
                        <a class="text-decoration-none text-body" :href="pageRoute.link">
                            {{ pageRoute.title }}
                        </a>
                    </li>

                    <li class="breadcrumb-item active pl-0 d-flex align-items-center" aria-current="page">
                        {{ activeLink }}
                    </li>
                </ol>
            </nav>
        </div>
    </section>
</template>

<script>
export default {
    name: "user-breadcrumb",
    props: {
        pageRoutes: {
            type: Array,
            required: false
        },
        activeLink: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>

</style>
