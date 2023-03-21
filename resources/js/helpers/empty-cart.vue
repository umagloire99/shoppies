<template>
    <div class="card-body mt-9">
        <div class="col-sm-12 text-center">
            <img :src="'/img/add-to-cart.png'" width="130" height="130" class="img-fluid mb-4 mr-3">
            <h3><strong>{{ $t('empty-cart') }}</strong></h3>
            <h4>{{ $t('add-something') }} :)</h4>
            <a :href="route('home')" class="btn btn-primary cart-btn-transform m-3" data-abc="true">
                {{ $t('continue-shopping') }}
            </a>
        </div>
    </div>
</template>

<script>
export default {
    name: "empty-cart"
}
</script>

<style scoped>

</style>
