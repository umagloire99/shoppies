<template>
    <div>
        <section data-animated-id="6" class="my-11 bg-white">
            <div class="container container-xl">
                <div class="row">
                    <div class="col-md-3 mb-2 mb-md-0 px-xl-8">
                        <div class="card border-0 text-center fadeInUp animated" data-animate="fadeInUp">
                            <div class="mx-auto w-md-auto ">
                                <img src="/img/Livraison-Rapide.png" alt="Guaranteed PURE">
                            </div>
                            <h6>{{ $t('fast-shipping') }}</h6>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0 px-xl-8">
                        <div class="card border-0 text-center fadeInUp animated" data-animate="fadeInUp">
                            <div class="mw-102 mx-auto">
                                <img src="/img/paiement-securise.png" alt="Completely Cruelty-Free">
                            </div>
                            <h6>{{ $t('payment-security') }}</h6>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0 px-xl-8">
                        <div class="card border-0 text-center fadeInUp animated" data-animate="fadeInUp">
                            <div class="mw-102 mx-auto">
                                <img src="/img/Service-Client.png" alt="Ingredient Sourcing">
                            </div>
                            <h6>{{ $t('online-support') }}</h6>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0 px-xl-8">
                        <div class="card border-0 text-center fadeInUp animated" data-animate="fadeInUp">
                            <div class="mw-102 mx-auto">
                                <img src="/img/quality.jpeg" alt="Ingredient Sourcing">
                            </div>
                            <h6>{{ $t('high-quality') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="pt-10 pt-lg-14 pb-11 footer" style="background-color: #f7f7f7" >
            <div class="container container-xl">
                <div class="row">
                    <div class="col-lg col-md-4 col-12 mb-7 mb-lg-0">
                        <h3 class="fs-20 mb-3">{{ $t('company') }}</h3>
                        <ul class="list-unstyled mb-0">
                            <li class="py-1"><a href="#" class="text-body lh-175">{{ $t('contact-us') }}</a></li>
                            <li class="pt-1"><a :href="route('privacy-policy')" class="text-body lh-175">{{$t('privacy-policy')}}</a></li>
                            <li class="py-1"><a :href="route('terms-conditions')" class="text-body lh-175">{{$t('terms-conditions')}}</a></li>
                        </ul>
                    </div>
                    <div class="col-lg col-md-4  col-12 mb-7 mb-lg-0">
                        <h3 class="fs-20 mb-3">{{$t('useful-link')}}</h3>
                        <ul class="list-unstyled mb-0">
                            <li class="py-1">
                                <a :href="route('shop.index')+'?highlight=new-arrivals'" class="text-body lh-175">
                                    {{ $t('new-arrivals') }}
                                </a>
                            </li>
                            <li class="py-1">
                                <a :href="route('shop.index')+'?highlight=best-seller'" class="text-body lh-175">
                                    {{ $t('best-seller') }}
                                </a>
                            </li>
                            <li class="py-1">
                                <a :href="route('shop.index')+'?highlight=flash-sale'" class="text-body lh-175">
                                    {{ $t('flash-sale') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg col-md-4 col-12 mb-7 mb-lg-0">
                        <h3 class="fs-20 mb-3">Infomation</h3>
                        <ul class="list-unstyled mb-0">
                            <li class="py-1"><a :href="route('shipping-expedition-fee')" class="text-body lh-175">{{$t('shipping-expedition-fee')}}</a></li>
                            <li class="py-1"><a :href="route('shipping-policy')" class="text-body lh-175">{{$t('shipping-expedition-policy')}}</a></li>
                            <li class="py-1"><a :href="route('faqs')" class="text-body lh-175">{{$t('customer-support-faqs')}}</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-5 col-12 mb-9 mb-lg-0">
                        <h3 class="mb-2">{{$t('good-emails')}}.</h3>
                        <p class="lh-2">{{$t('subscribe-hint')}}</p>
                        <form class="pt-4">
                            <div class="input-group position-relative">
                                <input type="email" class="form-control bg-white rounded-left"
                                       placeholder="Enter your email address">
                                <button type="submit" class="btn btn-secondary bg-hover-primary border-hover-primary">
                                    {{ $t('subscribe') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
<script>
export default {
    name: "main-footer"
}
</script>

<style scoped>

</style>
