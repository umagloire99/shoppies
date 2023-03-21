<template>
    <header class="main-header navbar-light header-sticky header-sticky-smart header-02">
        <div class="topbar bg-primary">
            <div class="container container-xl d-flex justify-content-center align-items-center">
                <p class="mb-0 fs-13 fs-lg-16 font-weight-600 text-white text-center text-uppercase">{{$t('free-shipping')}}</p>
                <div class="font-weight-normal dropdown bg-white mt-1 mb-1 px-2 ml-2">
                    <button class="btn dropdown-toggle p-0" type="button" id="dropdown-english"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="font-weight-normal">
                                            <img :src="'/flags/'+i18n.getLocale().toLowerCase()+'.svg'" alt="flag-02" class="pr-2" width="25"><strong
                                            class="font-weight-500 text-body fs-14">{{ i18n.getLocale().toUpperCase() }}</strong>
                                        </span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdown-english">
                        <a v-for="locale in supportedLanguages" class="dropdown-item" :href="route('locale.set',locale)">
                                    <span class="font-weight-normal">
                                            <img :src="'/flags/'+locale.toLowerCase()+'.svg'" width="25" alt="English flag"
                                                 class="pr-2"><strong
                                        class="font-weight-500 text-body pl-1 fs-14">{{ locale }}</strong>
                                        </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-above py-2 border-bottom d-xl-block">
            <div class="container container-xxl d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center flex-nowrap fs-14 text-body">
                    <a class="pr-4 font-weight-500 text-secondary fs-11 fs-lg-14 text-body"
                       :href="'https://wa.me/'+$page.props.contact.phone_number" target="_blank">
                        <span><img src="/img/whatsapp.svg" alt="flag-02" class="pr-1" style="width: 20px; height: 20px">{{
                                $page.props.contact.phone_number
                            }}</span>
                    </a>
                    <a :href="'mailto:'+$page.props.contact.site_email" target="_blank"
                       class="font-weight-500 text-secondary fs-11 fs-lg-14 text-body">
                        <span><i class="fal fa-envelope pr-1 "></i>{{ $page.props.contact.site_email }}</span>
                    </a>
                </div>
                <ul class="navbar-nav flex-row d-none justify-content-xl-end d-lg-flex flex-wrap text-body py-0 navbar-right">
                    <li class="nav-item">
                        <a class="nav-link position-relative pr-4 menu-cart py-0 d-inline-flex align-items-center mr-n2"
                           href="#" data-canvas="true"
                           data-canvas-options='{"container":".cart-canvas"}'>
                            <span class="mr-2 font-weight-bold fs-15">{{
                                    $h.formatPrice($page.props.cart.total_price)
                                }}</span>
                            <svg class="icon icon-shopping-bag-open-light">
                                <use xlink:href="#icon-shopping-bag-open-light"></use>
                            </svg>
                            <span class="position-absolute number">{{ $page.props.cart.count }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sticky-area-wrap" style="height: 80px;"><div class="sticky-area bg-white">
            <div class="container container-xxl">
                <nav class="navbar navbar-expand-xl px-0 d-block">
                    <div class="d-none d-xl-block">
                        <div class="d-flex align-items-center flex-nowrap">
                            <div class="w-50 menu-bold">
                                <ul class="navbar-nav hover-menu main-menu px-0 mx-xl-n5">
                                    <li  class="nav-item py-2 py-xl-7 px-0 px-xl-5">
                                        <a class="nav-link  p-0" :href="route('home')" >
                                            {{ $t('home') }}
                                            <span class="caret"></span>
                                        </a>
                                    </li>
                                    <li  class="nav-item py-2 py-xl-7 px-0 px-xl-5">
                                        <a class="nav-link  p-0" :href="route('shop.index')+'?highlight=new-arrivals'" >
                                            {{ $t('new-arrivals') }}
                                            <span class="caret"></span>
                                        </a>
                                    </li>
                                    <li  class="nav-item py-2 py-xl-7 px-0 px-xl-5">
                                        <a class="nav-link  p-0" :href="route('shop.index')+'?highlight=best-seller'" >
                                            {{ $t('best-seller') }}
                                            <span class="caret"></span>
                                        </a>
                                    </li>
                                 </ul>
                            </div>
                            <div class="mx-auto flex-shrink-0 px-10 py-5">
                                <div class="d-flex mt-3 mt-xl-0 align-items-center w-100 justify-content-center">
                                    <a class="navbar-brand mx-auto d-inline-block py-0" :href="route('home')">
                                        <img src="/img/logo.png" height="10" alt="Shoppies" style="height: 60px">
                                    </a>
                                </div>
                            </div>
                            <div class="w-50">
                                <form class="d-flex align-items-center h-100" :action="route('shop.index')">
                                    <div class="input-group position-relative mw-487 ml-auto">
                                        <input type="text" class="form-control form-control border-0 pl-8" name="keyword" placeholder="What are you looking for?">
                                        <div class="input-group-append position-absolute pos-fixed-left-center">
                                            <button class="input-group-text bg-transparent border-0 px-0 fs-28 pl-3" type="submit">
                                                <svg class="icon icon-magnifying-glass-light">
                                                    <use xlink:href="#icon-magnifying-glass-light"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center d-xl-none">
                        <button class="navbar-toggler border-0 px-0 canvas-toggle" type="button" data-canvas="true" data-canvas-options="{&quot;width&quot;:&quot;250px&quot;,&quot;container&quot;:&quot;.sidenav&quot;}">
                            <span class="fs-24 toggle-icon"></span>
                        </button>
                        <div class="mx-auto"><a class="navbar-brand d-inline-block mr-0 py-4" :href="route('home')">
                            <img src="/img/logo.png" alt="Shoppies" style="height: 40px">
                        </a></div>
                        <a class="nav-link position-relative menu-cart py-0 d-inline-flex align-items-center"
                           href="#" data-canvas="true"
                           data-canvas-options='{"container":".cart-canvas"}'>
                            <svg class="icon icon-shopping-bag-open-light">
                                <use xlink:href="#icon-shopping-bag-open-light"></use>
                            </svg>
                            <span class="position-absolute number">{{ $page.props.cart.count }}</span>
                        </a>
                    </div>
                </nav>
            </div>
        </div></div>
    </header>
</template>

<script>

import {useI18n} from "vue3-i18n";

export default {
    setup() {
        const i18n = useI18n();
        return {
            i18n
        }
    },
    name: "home-header",
    data() {
        return {
            supportedLanguages: [
                'Fr',
                'En'
            ]
        }
    },
    methods: {
        setLocale(lang) {
            this.$inertia.visit(this.route('locale.set', lang.toString()));
        }
    }
}
</script>

<style scoped>

</style>
