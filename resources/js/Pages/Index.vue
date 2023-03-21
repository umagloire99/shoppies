<template>
    <main id="content">
        <section class="mx-0 slick-slider slick-dots-light dots-inner-center slider"
                 data-slick-options='{"slidesToShow": 1,"infinite":true,"autoplay":true,"dots":true,"arrows":false,"fade":true,"cssEase":"ease-in-out","speed":600}'>
            <div class="box px-0" v-for="event in events">
                <div class="bg-img-cover-center py-lg-18 py-10" :style="'background-image: url('+event.data.img+')'" style="
                            width: 100%;
                            background-color: #fff;
                            background-size: cover;
                            background-repeat: no-repeat;
                            background-position: 100%;
                            margin: auto 0;
                            height: 100%;">
                </div>
            </div>
        </section>
        <section class="my-lg-13 my-5">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-animate="fadeInUp">
                        <div class="card bg-transparent border-0 text-center mb-6">
                            <div class="w-63px card-img mb-3">
                                <img src="/images/single-image-01.jpg" alt="">
                            </div>
                            <div class="card-body px-0 pt-0">
                                <h3 class="card-title fs-34 lh-129 mb-1 mx-auto" style="max-width: 610px">
                                    {{$t('quality-products')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <product-card v-for="product in products" :product="product"/>
                    <div class="col-12 text-center mt-1" data-animate="fadeInUp">
                        <a :href="route('shop.index')"
                           class=" btn btn-outline-secondary border border-2x border-hover-secondary">
                            {{$t('shop-all-products')}}
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-11 pb-xl-9 pb-5" style="background-color: #f7f7f7" data-animated-id="4">
            <div class="container container-xl">
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-transparent border-0 align-items-center text-center mb-xl-0 mb-6 fadeInUp animated" data-animate="fadeInUp">
                            <div class="card-img">
                                <svg class="icon icon-box-01 fs-70 text-primary"><use xlink:href="#icon-box-01"></use></svg>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="card-title fs-20 mb-2">{{ $t('free-shipping') }}</h3>
                                <p class="cart-text fs-18 mb-0">
                                    {{$t('free-shipping-desc')}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-transparent border-0 align-items-center text-center mb-xl-0 mb-6 fadeInUp animated" data-animate="fadeInUp">
                            <div class="card-img">
                                <svg class="icon icon-box-02 fs-70 text-primary"><use xlink:href="#icon-box-02"></use></svg>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="card-title fs-20 mb-2">{{$t('returns')}}</h3>
                                <p class="cart-text fs-18 mb-0">{{$t('returns-desc')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-transparent border-0 align-items-center text-center mb-xl-0 mb-6 fadeInUp animated" data-animate="fadeInUp">
                            <div class="card-img">
                                <svg class="icon icon-box-03 fs-70 text-primary"><use xlink:href="#icon-box-03"></use></svg>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="card-title fs-20 mb-2">{{ $t('online-support') }}</h3>
                                <p class="cart-text fs-18 mb-0">{{$t('online-support-desc')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-transparent border-0 align-items-center text-center mb-xl-0 mb-6 fadeInUp animated" data-animate="fadeInUp">
                            <div class="card-img">
                                <svg class="icon icon-box-04 fs-70 text-primary"><use xlink:href="#icon-box-04"></use></svg>
                            </div>
                            <div class="card-body text-center">
                                <h3 class="card-title fs-20 mb-2">{{$t('flexible-payment')}}</h3>
                                <p class="cart-text fs-18 mb-0">{{$t('flexible-payment-desc')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import MainLayout from "../layout/MainLayout";
import ProductCard from "../global-components/ProductCard";

export default {
    name: "index",
    components: {ProductCard},
    layout: MainLayout,
    props: {
        events: Array,
        allCategories: Array,
        products: Array,
        product: Object
    }
}
</script>

<style scoped>

</style>
