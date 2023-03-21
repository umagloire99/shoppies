<template>
    <div class="container-3xl px-20">
        <div class="card-body mt-4">
            <div class="col-sm-12 text-center">
                <img :src="'/img/like.png'" width="100" height="100" class="img-fluid mb-4 mr-3">
                <h4>{{ $t('thank-you') }}</h4>
                <h8>{{ $t('thank-you-desc') }}</h8>
                <br/>
                <a :href="route('receipt.show', order.ref_id)" class="btn bg-gray-2 px-8 py-3 mt-5 " >
                    <span class="ml-2 text-primary font-weight-600 fs-16">{{ $t('invoice-details') }}</span>
                </a>
                <br/>
                <a :href="route('home')" class="btn btn-primary m-3" data-abc="true">
                    <span>{{ $t('continue-shopping') }}</span>
                </a>
                <br/>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from "../../layout/MainLayout";
import EmptyCart from "../../helpers/empty-cart";

export default {
    name: "successCheckout",
    components: {EmptyCart},
    layout: MainLayout,
    props: {
        order: Object
    }
}
</script>

