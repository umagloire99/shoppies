<template>
    <main id="content">
        <user-breadcrumb :page-routes="pageRoutes" :active-link="activeLink"/>
        <section class="pt-9">
            <div class="container">
                <h2 class="text-center mb-6">{{ name }}</h2>
                <div class="mb-9" v-html="content">
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import MainLayout from "../layout/MainLayout";
import UserBreadcrumb from "../Includes/user-breadcrumb";

export default {
    name: "Page",
    components: {UserBreadcrumb},
    layout: MainLayout,
    props: {
        content: null,
        name: null
    },
    data() {
        return {
            pageRoutes: [
                {
                    title: 'Home',
                    link: this.route('home')
                },
            ],
            activeLink: this.name,
        }
    }
}
</script>

<style scoped>

</style>
