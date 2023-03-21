<template>
    <div class="row">
        <product-card v-for="product in products.data" :product="product"/>
    </div>
    <pagination :links="products.links" />
</template>

<script>
import ProductLayout from "./ProductLayout";
import ProductCard from "../../global-components/ProductCard";
import Pagination from "../../Includes/Pagination";

export default {
    name: "Index",
    components: {Pagination, ProductCard},
    layout: ProductLayout,
    props: {
        products: null,
    },
    data() {
        return {
            pageRoutes: [
                {
                    title: this.$t('home'),
                    link: this.route('home')
                }
            ],
        }
    }
}
</script>

<style scoped>

</style>
