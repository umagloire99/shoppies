<template>
    <main id="content">
        <user-breadcrumb :page-routes="pageRoutes" :active-link="activeLink"/>
        <section class="pb-11 pb-lg-13" v-if="this.$page.props.cart.count === 0">
            <div class="container">
                <empty-cart/>
            </div>
        </section>
        <section class="pb-11 pb-lg-13" v-if="this.$page.props.cart.count > 0">
            <div class="container">
                <h2 class="text-center mt-9 mb-8">Shopping Cart</h2>

                <form class="table-responsive-md pb-8 pb-lg-10">
                    <table class="table border">
                        <thead style="background-color: #F5F5F5">
                        <tr class="fs-15 letter-spacing-01 font-weight-600 text-uppercase text-secondary">
                            <th scope="col" class="border-1x pl-7">{{ $t('products') }}</th>
                            <th scope="col" class="border-1x">{{ $t('quantity') }}</th>
                            <th colspan="2" class="border-1x">{{ $t('price') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            <shopping-cart-card v-for="cardItem in $page.props.cart.content" :cart-item="cardItem"/>
                        <tr>
                            <td class="pb-6 pl-0 position-relative bg-white" style="left: -1px">
                                <a :href="route('home')" type="submit" value="Countinue Shopping"
                                        class="btn btn-outline-secondary border-2x border mr-5 border-hover-secondary my-3">
                                    {{$t('continue-shopping')}}
                                </a>
                                <a href="javascript:;" @click="clearCart" value="Clear Shopping Cart"
                                        class="btn btn-link p-0 border-0 border-bottom border-secondary rounded-0 my-3"><i
                                    class="fal fa-times mr-2 text-secondary"></i>{{ $t('clear-shopping-cart') }}
                                </a>
                            </td>
                            <td colspan="3" class="text-right pb-6 pr-0 position-relative bg-white" style="right: -2px">
                                <div class="card border-0" style="box-shadow: 0 0 10px 0 rgba(0,0,0,0.1)">
                                    <div class="card-body px-6 pt-5">
                                        <div class="d-flex align-items-center mb-2">
                                            <span>{{ $t('subtotal') }}:</span>
                                            <span class="d-block ml-auto text-secondary font-weight-bold">{{ $h.formatPrice($page.props.cart.total_price) }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span>{{ $t('shipping') }}:</span>
                                            <span class="d-block ml-auto text-secondary font-weight-bold">{{ $h.formatPrice($page.props.cart.shipping ? $page.props.cart.shipping.fee : 0) }}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent px-0 pb-4 mx-6">
                                        <div class="d-flex align-items-center font-weight-bold mb-3">
                                            <span class="text-secondary">{{ $t('total-price') }}:</span>
                                            <span class="d-block ml-auto text-secondary fs-24 font-weight-bold">{{ $h.formatPrice($page.props.cart.total_price) }}</span>
                                        </div>
                                        <a :href="route('checkout')" class="btn btn-secondary btn-block bg-hover-primary border-hover-primary">
                                            {{ $t('checkout') }}
                                        </a>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </section>
    </main>
</template>

<script>
import UserBreadcrumb from "../../Includes/user-breadcrumb";
import ShoppingCartCard from "../../helpers/ShoppingCartCard";
import MainLayout from "../../layout/MainLayout";
import {Inertia} from "@inertiajs/inertia";
import EmptyCart from "../../helpers/empty-cart";

export default {
    name: "Shopping-cart",
    components: {EmptyCart, ShoppingCartCard, UserBreadcrumb},
    layout: MainLayout,
    data() {
        return {
            pageRoutes: [
                {
                    title: 'Home',
                    link: this.route('home')
                },
            ],
            activeLink: 'Shopping Cart',
        }
    },
    methods: {
        clearCart() {
            Inertia.post(this.route('cart.remove.all'))
        }
    }
}
</script>

<style scoped>

</style>
