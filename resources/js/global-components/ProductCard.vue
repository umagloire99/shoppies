<template>
    <div :class="customClass"
         v-if="product">
        <div class="card border-0">
            <a :href="route('products.show', product.slug)" class="position-relative">
                <img :src="product.img" :alt="product.title">
                <div class="card-img-overlay d-flex p-3 flex-column">
                    <div class="mb-auto d-flex justify-content-center">
                        <div v-if="product.label === 'new'">
                            <span class="badge badge-warning">{{ $t('new') }}</span>
                        </div>
                        <div v-if="product.label === 'sale'">
                            <span class="badge badge-primary">-{{ product.discount * 100 }}%</span>
                        </div>
                    </div>
                </div>
            </a>
            <div class="card-body px-0 pt-4 text-center">
                <p class="card-text font-weight-bold fs-16 mb-1 text-secondary">
                        <span class="fs-13 font-weight-500 text-decoration-through text-body pr-1"
                              v-if="product.label === 'sale'">
                            {{ this.$h.formatPrice(product.price) }}
                        </span>
                    <span>{{ $h.formatPrice(product.discount_price) }}</span>
                </p>
                <h2 class="card-title fs-15 font-weight-500 mb-2">
                    <a :href="route('products.show', product.slug)">{{ product.name }}</a>
                </h2>
                <div class="d-flex align-items-center justify-content-center flex-wrap">
                    <rating-widget :rating="product.rate"/>
                    <span class="card-text fs-14 font-weight-400 pl-2 lh-1">{{ product.reviews_count }} {{
                            $t('reviews')
                        }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-row mt-2">
                    <div class="mr-sm-4 mr-4">
                        <a href="javascript:;" @click="checkout"
                           class="btn btn-secondary bg-hover-primary border-hover-primary px-sm-7 px-3">{{ $t('buy-now') }}</a>
                    </div>
                    <div class="d-flex">
                        <a href="javascript:;" @click="submit" data-toggle="tooltip" data-placement="top" title=""
                           class="add-to-wishlist d-flex align-items-center justify-content-center text-white bg-secondary  bg-hover-secondary w-48px h-48px rounded-circle mr-2"
                           data-original-title="Add to bag">
                            <svg class="icon icon-heart-light fs-24">
                                <use xlink:href="#icon-shopping-bag-open-light"></use>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RatingWidget from "./RatingWidget";
import {Inertia} from "@inertiajs/inertia";
import UserLoadingButton from "./UserLoadingButton";

export default {
    name: "ProductCard",
    components: {UserLoadingButton, RatingWidget},
    props: {
        product: null,
        customClass: {
            type: String,
            default: 'col-lg-3 col-sm-6 mb-5'
        }
    },
    methods: {
        submit() {
            Inertia.post(window.route('cart.add.item', this.product.id), {quantity: 1}, {
                preserveScroll: true,
            })
        },
        checkout() {
            Inertia.post(window.route('cart.add.item', this.product.id), {quantity: 1}, {
                onFinish: () => {
                    if (this.$page.props.flash.success) {
                        Inertia.get(this.route('checkout'))
                    }
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
