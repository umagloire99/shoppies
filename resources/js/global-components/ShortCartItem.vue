<template>
    <div class="mb-4 d-flex">
        <a href="javascript:;" @click="removedCartItem(cartItem.rowId)" class="d-flex align-items-center mr-2 text-muted"><i class="fa fa-times"></i></a>
        <div class="media w-100">
            <div class="w-60px mr-3">
                <img v-lazy="cartItem.img" alt="atural Coconut Cleansing Oil">
            </div>
            <div class="media-body d-flex">
                <div class="cart-price pr-6">
                    <p class="fs-14 font-weight-bold text-secondary mb-1"><span
                        class="font-weight-500 fs-13 text-line-through text-body mr-1"
                        v-if="cartItem.discount"> {{ $h.formatPrice(cartItem.price) }}</span>
                        {{ $h.formatPrice(cartItem.discount_price) }}
                    </p>
                    <a :href="route('products.show', cartItem.slug)" class="text-secondary">{{ cartItem.name }}</a>
                </div>
                <div class="position-relative ml-auto">
                    <div class="input-group">
                        <a @click="updatedCartItem(cartItem.rowId, -1)" href="javascript:;" class="down position-absolute pos-fixed-left-center pl-2"><i
                            class="far fa-minus"></i></a>
                        <input type="number" :max="cartItem.product_quantity" :min="1" @change="updateValue"
                               class="number-cart w-90px px-6 text-center h-40px bg-input border-0"
                               v-model="cartItem.quantity">
                        <a @click="updatedCartItem(cartItem.rowId, 1)" href="javascript:;" class="up position-absolute pos-fixed-right-center pr-2"><i
                            class="far fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "ShortCartItem",
    props: {
        cartItem: Object
    },

    methods: {
        updatedCartItem(rowId, number) {
            let form = {}
            form['quantity'] = this.cartItem.quantity + number
            Inertia.post(this.route('cart.update.item', rowId), form, {
                preserveScroll: true,
            })
        },
        removedCartItem(rowId) {
            Inertia.post(this.route('cart.remove.item', rowId), {}, {
                preserveScroll: true,
            })
        },
        updateValue(event) {
            let form = {}
            form['quantity'] = event.target.value
            Inertia.post(this.route('cart.update.item', this.cartItem.rowId), form, {
                preserveScroll: true,
            })
        }
    }
}
</script>

<style scoped>

</style>
