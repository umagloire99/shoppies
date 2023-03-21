<template>
    <tr class="position-relative"
        :class="cartItem.is_out_stock ? 'opacity-5' : ''">
        <th scope="row" class="w-xl-695 pl-xl-5 py-4">
            <div class="media align-items-center">
                <input class="checkbox-primary w-15px h-15px" type="checkbox" name="check-product"
                       value="checkbox">
                <div class="ml-3 mr-4">
                    <img :src="cartItem.img"
                         :alt="cartItem.name" class="mw-75px">
                </div>
                <div class="media-body w-128px">
                    <p class="font-weight-500 mb-1 text-secondary">{{ cartItem.name }}</p>
                    <p class="card-text font-weight-bold fs-14 mb-1 text-secondary">
                        <span class="fs-13 font-weight-500 text-decoration-through text-body pr-1" v-if="cartItem.discount">{{ $h.formatPrice(cartItem.price) }}</span>
                        <span>{{  $h.formatPrice(cartItem.discount_price) }}</span>
                    </p>
                </div>
            </div>
            <div class="pos-fix-top-left position-absolute py-1 px-3 bg-muted text-white" v-if="cartItem.is_out_stock ">
                <span class="badge text-uppercase fs-14 letter-spacing-01 p-0">out of stock</span>
            </div>
        </th>
        <td class="align-middle">
            <div class="input-group position-relative w-128px">
                <a  v-if="!cartItem.is_out_stock" @click="updatedCartItem(cartItem.rowId, -1)" href="javascript:;"
                    class="down position-absolute pos-fixed-left-center pl-2 z-index-2"><i
                    class="far fa-minus"></i></a>
                <input name="number[]"  :min="1" type="number" @input="updateValue"
                       class="form-control form-control-sm px-6 fs-16 text-center input-quality border-0 h-35px"
                       :value="cartItem.quantity"
                       :max="cartItem.product_quantity"
                       required>
                <a v-if="!cartItem.is_out_stock" @click="updatedCartItem(cartItem.rowId, 1)" href="javascript:;"
                   class="up position-absolute pos-fixed-right-center pr-2 z-index-2"><i
                    class="far fa-plus"></i>
                </a>
            </div>
        </td>
        <td class="align-middle">
            <p class="mb-0 text-secondary font-weight-bold mr-xl-11">{{ $h.formatPrice(cartItem.discount_price * cartItem.quantity) }}</p>
        </td>
        <td class="align-middle text-right pr-5"><a href="javascript:;" @click="removedCartItem(cartItem.rowId)"  class="d-block"><i
            class="fal fa-times text-body"></i></a></td>
    </tr>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "ShoppingCartCard",
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
