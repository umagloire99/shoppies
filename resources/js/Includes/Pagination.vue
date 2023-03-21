<template>
    <nav class="pt-3">
        <ul class="pagination justify-content-center align-items-center mb-0 fs-16 font-weight-600" >
            <li class="page-item fs-18 d-none d-sm-block" v-for="(link, index) in links" :class="link.active ? 'active' : ''">
                <inertia-link v-if="index === 0" class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"
                   :href="link.url" tabindex="-1">
                    <i class="far fa-angle-double-left"></i>
                </inertia-link>
                <inertia-link v-if="index !== 0 && index !== links.length-1 && link.url" class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"
                              :href="link.url">
                    {{ link.label }}
                </inertia-link>
                <inertia-link v-if="index === links.length-1" class="page-link rounded-circle w-40px h-40 p-0 justify-content-center align-items-center d-flex"
                              :href="link.url">
                    <i class="far fa-angle-double-right"></i>
                </inertia-link>
            </li>
        </ul>
    </nav>
</template>

<script>

export default {
    name: "Pagination",
    props: {
        links: Array
    }
}
</script>

<style scoped>

</style>
