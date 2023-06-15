<template>
    <main id="content">
        <user-breadcrumb :page-routes="pageRoutes" :active-link="activeLink" />
        <section class="pt-11 pb-9 pb-lg-10 product-details-layout-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 pr-xl-9 mb-8 mb-md-0">
                        <div class="galleries-product galleries-product-01 position-relative d-flex ">
                            <div class="slick-slider slider-for mx-0 pl-xl-5"
                                data-slick-options='{"slidesToShow": 1,"vertical":true, "autoplay":false,"dots":false,"arrows":false,"asNavFor": ".slider-nav","responsive":[{"breakpoint": 1200,"settings": {"vertical": false}}]}'>
                                <div class="box px-0" v-for="file in product.media">
                                    <div class="card p-0 rounded-0 border-0">
                                        <a :href="file.path" class="card-img" data-gtf-mfp="true" target="_blank"
                                            data-gallery-id="02">
                                            <img v-if="file.type === 'image'" :src="file.path" alt="product gallery"
                                                class="w-100" />
                                            <video v-else class="w-100 h-100" controls :poster="file.path">
                                                <source :src="file.path + '#t=2'">
                                            </video>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="slick-slider slider-nav mx-n1 mx-xl-0"
                                data-slick-options='{"slidesToShow": 4,"vertical":true, "autoplay":false,"dots":false,"arrows":false,"asNavFor": ".slider-for","focusOnSelect": true,"responsive":[{"breakpoint": 1200,"settings": {"vertical": false}}]}'>
                                <div class="box px-1 px-xl-0 py-4 pt-xl-0" v-for="file in product.media">
                                    <img v-if="file.type === 'image'" :src="file.path" alt="product gallery"
                                        class="w-100" />
                                    <video v-else class="w-100">
                                        <source :src="file.path + '#t=5'">
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="d-flex align-items-center mb-3">
                            <span class="text-line-through" v-if="product.label === 'sale'">{{ $h.formatPrice(product.price)
                            }}</span>
                            <span class="fs-18 text-secondary font-weight-bold ml-3">{{
                                $h.formatPrice(product.discount_price)
                            }}</span>
                            <span class="badge badge-primary fs-16 ml-4 font-weight-600 px-3"
                                v-if="product.label === 'sale'">{{ product.discount * 100 }}</span>
                        </p>
                        <h2 class="fs-24 mb-2">{{ product.name }}</h2>
                        <div class="d-flex align-items-center flex-wrap mb-3 lh-12">
                            <p class="mb-0 font-weight-600 text-secondary">{{ product.rate }}</p>
                            <rating-widget :rating="product.rate" class="px-3" />
                            <a href="#" class="pl-3 border-left border-gray-2 text-body">Read {{
                                product.reviews_count
                            }} {{ $t('reviews') }}</a>
                        </div>
                        <p class="mb-5" v-html="product.description"></p>

                        <form method="post" @submit.prevent="submit">
                            <div class="row align-items-end no-gutters mx-n2">
                                <div class="col-sm-7 form-group pl-2 mb-6">
                                    <label class="text-secondary font-weight-600 mb-3" for="number">{{ $t('quantity') }}:
                                    </label>
                                    <div class="input-group position-relative w-100">
                                        <a href="javascript:;" @click="form.quantity--"
                                            class="position-absolute pos-fixed-left-center pl-4 z-index-2"><i
                                                class="far fa-minus"></i></a>
                                        <input v-model="form.quantity" :max="product.quantity" name="number" type="number"
                                            id="number"
                                            class="form-control w-100 px-6 text-center input-quality text-secondary h-60 fs-18 font-weight-bold border-0"
                                            required>
                                        <a href="javascript:;" @click="form.quantity++"
                                            class="position-absolute pos-fixed-right-center pr-4 z-index-2"><i
                                                class="far fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-5 mb-6 w-100 px-2" data-toggle="tooltip" data-placement="left"
                                    title="Add to cart">
                                    <user-loading-button
                                        custom-class="btn btn-lg fs-18 btn-secondary btn-block h-60 border-0">
                                        {{ $t('add-to-cart') }}
                                    </user-loading-button>
                                </div>
                                <div class="mb-6 px-2 col-12" data-toggle="tooltip" data-placement="left" title="Buy Now">
                                    <user-loading-button custom-class="px-7 btn-primary btn-lg btn-block h-60 fs-18"
                                        @click="checkout()" :loading="loading" type="button">
                                        {{ $t('buy-now') }}
                                    </user-loading-button>
                                </div>
                            </div>
                        </form>
                        <p class="text-secondary mb-2">
                            <svg class="icon icon-Timer fs-20 mr-2 align-text-bottom">
                                <use xlink:href="#icon-Timer"></use>
                            </svg>
                            {{ $t('remains', { 'count': product.quantity }) }}
                        </p>
                        <p class="mb-5">
                            <span class="text-secondary">
                                <svg class="icon icon-Package fs-20 mr-2 align-text-bottom">
                                    <use xlink:href="#icon-Package"></use>
                                </svg>
                                {{ $t('free-shipping') }}:</span> {{ $t('free-shipping-desc') }}
                        </p>
                        <ul class="list-unstyled border-top pt-5 mt-5">
                            <li class="row mb-2">
                                <span class="d-block col-4 col-lg-2 text-secondary font-weight-600 fs-14">Categories:</span>
                                <span class="d-block col-8 col-lg-10">{{ product.category.name }}</span>
                            </li>
                            <li class="row mb-2">
                                <span class="d-block col-4 col-lg-2 text-secondary font-weight-600 fs-14">Share:</span>
                                <ul class="list-inline d-flex align-items-center mb-0 col-8 col-lg-10">
                                    <li class="list-inline-item mr-4">
                                        <share-network :title="product.title" :description="product.description"
                                            network="twitter" :url="route('products.show', product.slug)"
                                            class="fs-14 lh-1 text-body hover-secondary">
                                            <i class="fab fa-twitter"></i>
                                        </share-network>
                                    </li>
                                    <li class="list-inline-item mr-4">
                                        <share-network :title="product.title" :description="product.description"
                                            network="facebook" :url="route('products.show', product.slug)"
                                            class="fs-14 lh-1 text-body hover-secondary">
                                            <i class="fab fa-facebook-f"></i>
                                        </share-network>
                                    </li>
                                    <li class="list-inline-item mr-4">
                                        <share-network :title="product.title" :description="product.description"
                                            network="instagram" :url="route('products.show', product.slug)"
                                            class="fs-14 lh-1 text-body hover-secondary">
                                            <i class="fab fa-instagram"></i>
                                        </share-network>
                                    </li>
                                    <li class="list-inline-item mr-4">
                                        <share-network :title="product.title" :description="product.description"
                                            network="pinterest" :url="route('products.show', product.slug)"
                                            class="fs-14 lh-1 text-body hover-secondary">
                                            <i class="fab fa-pinterest"></i>
                                        </share-network>
                                    </li>
                                    <li class="list-inline-item">
                                        <share-network :title="product.title" :description="product.description"
                                            network="youtube" :url="route('products.show', product.slug)"
                                            class="fs-14 lh-1 text-body hover-secondary">
                                            <i class="fab fa-youtube"></i>
                                        </share-network>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-10 pt-lg-12 pb-10 pb-md-6 pb-lg-11 border-top">
            <div class="container">
                <div class="collapse-tabs">
                    <ul class="nav nav-pills mb-5 justify-content-center d-md-flex d-none" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show fs-lg-34 fs-24 lh-129 font-weight-600 p-0 mr-md-10 mr-4"
                                id="pills-detail-tab" data-toggle="pill" href="#pills-detail" role="tab"
                                aria-controls="pills-detail" aria-selected="false">{{ $t('product-detail') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-lg-34 fs-24 lh-129 font-weight-600 p-0 mr-md-10 mr-4"
                                id="pills-how-to-use-tab" data-toggle="pill" href="#pills-how-to-use" role="tab"
                                aria-controls="pills-how-to-use" aria-selected="false">{{ $t('how-to-use') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-lg-34 fs-24 lh-129 font-weight-600 p-0" id="pills-ingredients-tab"
                                data-toggle="pill" href="#pills-ingredients" role="tab" aria-controls="pills-ingredients"
                                aria-selected="true">{{ $t('features') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content bg-white-md shadow-none py-md-5 p-0">
                        <div id="collapse-tabs-accordion-01">
                            <div class="tab-pane tab-pane-parent  show active" id="pills-detail" role="tabpanel">
                                <div class="card border-0 bg-transparent">
                                    <div class="card-header border-0 d-block d-md-none bg-transparent px-0 py-1"
                                        id="headingDetails-01">
                                        <h5 class="mb-0">
                                            <button
                                                class="btn lh-2 fs-18 py-1 px-6 shadow-none w-100 collapse-parent border text-primary"
                                                data-toggle="false" data-target="#detail-collapse-01" aria-expanded="true"
                                                aria-controls="detail-collapse-01">
                                                {{ $t('product-detail') }} </button>
                                        </h5>
                                    </div>
                                    <div id="detail-collapse-01" class="collapsible collapse show"
                                        aria-labelledby="headingDetails-01" data-parent="#collapse-tabs-accordion-01"
                                        style="">
                                        <div id="accordion-style-01"
                                            class="accordion accordion-01 border-md-0 border p-md-0 p-6">
                                            <div v-html="product.details">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane tab-pane-parent " id="pills-how-to-use" role="tabpanel">
                                <div class="card border-0 bg-transparent">
                                    <div class="card-header border-0 d-block d-md-none bg-transparent px-0 py-1"
                                        id="headinghow-to-use-01">
                                        <h5 class="mb-0">
                                            <button
                                                class="btn lh-2 fs-18 py-1 px-6 shadow-none w-100 collapse-parent border collapsed text-primary"
                                                data-toggle="collapse" data-target="#how-to-use-collapse-01"
                                                aria-expanded="false" aria-controls="how-to-use-collapse-01">
                                                {{ $t('how-to-use') }}
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="how-to-use-collapse-01" class="collapsible collapse"
                                        aria-labelledby="headinghow-to-use-01" data-parent="#collapse-tabs-accordion-01"
                                        style="">
                                        <div id="accordion-style-01-2"
                                            class="accordion accordion-01 border-md-0 border p-md-0 p-6 ">
                                            <div v-html="product.usages">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane tab-pane-parent " id="pills-ingredients" role="tabpanel">
                                <div class="card border-0 bg-transparent">
                                    <div class="card-header border-0 d-block d-md-none bg-transparent px-0 py-1"
                                        id="headingingredients-01">
                                        <h5 class="mb-0">
                                            <button
                                                class="btn lh-2 fs-18 py-1 px-6 shadow-none w-100 collapse-parent border collapsed text-primary"
                                                data-toggle="collapse" data-target="#ingredients-collapse-01"
                                                aria-expanded="false" aria-controls="ingredients-collapse-01">
                                                {{ $t('features') }} </button>
                                        </h5>
                                    </div>
                                    <div id="ingredients-collapse-01" class="collapsible collapse"
                                        aria-labelledby="headingingredients-01" data-parent="#collapse-tabs-accordion-01"
                                        style="">
                                        <div id="accordion-style-01-3"
                                            class="accordion accordion-01 border-md-0 border p-md-0 p-6">
                                            <div v-html="product.features">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section v-if="relatedProducts && relatedProducts.length !== 0" class="pt-10 pt-lg-13 pb-9 pb-lg-11 border-top">
            <div class="container">
                <h3 class="text-center fs-34 mb-8">{{ $t('you-may-also-like') }}</h3>
                <div class="slick-slider mx-n2"
                    data-slick-options='{"slidesToShow": 4,"dots":false,"arrows":false,"responsive":[{"breakpoint": 1368,"settings": {"arrows":false,"dots":true}},{"breakpoint": 1200,"settings": {"slidesToShow":3,"arrows":false,"dots":true}},{"breakpoint": 992,"settings": {"slidesToShow":2,"arrows":false,"dots":true}},{"breakpoint": 768,"settings": {"slidesToShow": 2,"arrows":false,"dots":true}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":true}}]}'>
                    <product-card v-for="p in relatedProducts" :product="p" custom-class="box" />
                </div>
            </div>
        </section>
        <section class="pt-10 pb-11 py-lg-13 border-top">
            <div class="container">
                <review-product :product="product" />
            </div>
        </section>
        <div class="position-fixed pos-fixed-bottom-right w-100 p-2 z-index-10 bg-white">
            <form method="post" @submit.prevent="submit">
                <div class="row align-items-center justify-content-center no-gutters mx-n2">
                    <div class="form-group pl-2 mb-4 col-4 col-sm-1">
                        <div class="input-group position-relative">
                            <a href="javascript:;" @click="form.quantity--"
                                class="position-absolute pos-fixed-left-center pl-4 z-index-2"><i
                                    class="far fa-minus"></i></a>
                            <input v-model="form.quantity" :max="product.quantity" name="number" type="number-quantity"
                                id="number-quantity"
                                class="form-control px-6 text-center input-quality text-secondary h-60 fs-18 font-weight-bold border-0"
                                required>
                            <a href="javascript:;" @click="form.quantity++"
                                class="position-absolute pos-fixed-right-center pr-4 z-index-2"><i class="far fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mb-4 px-2 col-8 col-sm-4" data-toggle="tooltip" data-placement="left" title="Buy Now">
                        <user-loading-button custom-class="px-7 btn-primary btn-lg btn-block h-60 fs-18" @click="checkout()"
                            :loading="loading" type="button">
                            {{ $t('buy-now') }}
                        </user-loading-button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</template>

<script>
import MainLayout from "../../layout/MainLayout";
import UserBreadcrumb from "../../Includes/user-breadcrumb";
import RatingWidget from "../../global-components/RatingWidget";
import ProductCard from "../../global-components/ProductCard";
import ReviewProduct from "./review-product";
import UserLoadingButton from "../../global-components/UserLoadingButton";
import { Inertia } from '@inertiajs/inertia'

export default {
    name: "Show",
    components: { UserLoadingButton, ReviewProduct, ProductCard, RatingWidget, UserBreadcrumb },
    props: {
        product: Object,
        relatedProducts: Array
    },
    layout: MainLayout,

    data() {
        return {
            form: {
                quantity: 1
            },
            loading: false,
            pageRoutes: [
                {
                    title: this.$t('home'),
                    link: this.route('home')
                },
                {
                    title: this.product.category.name,
                    link: this.route('shop.index', this.product.category.slug)
                }
            ],
            activeLink: this.product.name,
        }
    },
    methods: {
        submit() {
            Inertia.post(window.route('cart.add.item', this.product.id), this.form)
        },
        checkout() {
            Inertia.post(window.route('cart.add.item', this.product.id), this.form, {
                onStart: () => this.loading = true,
                onFinish: () => {
                    if (this.$page.props.flash.success) {
                        Inertia.get(this.route('checkout'))
                    }
                    this.loading = false
                }
            })
        }

    }
}
</script>

<style scoped></style>
