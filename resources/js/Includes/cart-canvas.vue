<template>
    <div class="canvas-sidebar cart-canvas">
        <div class="canvas-overlay">
        </div>
        <div class="card border-0 pt-4 pb-7 h-100">
            <div class="px-6 text-right">
          <span class="canvas-close d-inline-block fs-24 mb-1 ml-auto lh-1 text-primary"><i
              class="fa fa-times text-success"/></span>
            </div>
            <div class="card-header bg-transparent p-0 mx-6">
                <h3 class="fs-24 mb-5">
                    {{$t('shopping-bag')}}
                </h3>
            </div>
            <div class="card-body px-6 pt-7 overflow-y-auto" v-for="cardItem in $page.props.cart.content">
                <short-cart-item :cart-item="cardItem"/>
            </div>
            <div v-if="$page.props.cart.count > 0" class="card-footer mt-auto border-0 bg-transparent px-6 pb-0 pt-5">
                <div class="d-flex align-items-center mb-2">
                    <span class="text-secondary fs-15">{{ $t('total-price') }}:</span>
                    <span class="d-block ml-auto fs-24 font-weight-bold text-secondary"> {{ $h.formatPrice($page.props.cart.total_price)  }}</span>
                </div>
                <a :href="route('checkout')" class="btn btn-secondary btn-block mb-3 bg-hover-primary border-hover-primary">
                    {{$t('checkout')}}</a>
                <a :href="route('shopping-cart')" class="btn btn-outline-secondary btn-block">{{ $t('view-cart') }}</a>
            </div>
            <div v-else>
                <empty-cart/>
            </div>
        </div>
    </div>
</template>

<script>
import ShortCartItem from "../global-components/ShortCartItem";
import EmptyCart from "../helpers/empty-cart";

export default {
    name: "cart-canvas",
    components: {EmptyCart, ShortCartItem}
}
</script>

<style scoped>

</style>
