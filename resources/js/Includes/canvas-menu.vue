<template>
    <div class="sidenav canvas-sidebar bg-white">
        <div class="canvas-overlay">
        </div>
        <div class="pt-5 pb-7 card border-0 h-100">
            <div class="d-flex align-items-center card-header border-0 py-0 pl-8 pr-7 mb-9 bg-transparent">
                <a :href="route('home')" class="d-block w-100px">
                    <img src="/img/logo.png" alt="Shoppies" style="height: 100px">
                </a>
                <span class="canvas-close d-inline-block text-right fs-24 ml-auto lh-1 text-primary"><i
                    class="fal fa-times"></i></span>
            </div>
            <div class="overflow-y-auto pb-6 pl-8 pr-7 card-body pt-0">
                <ul class="navbar-nav main-menu px-0 ">
                    <li aria-haspopup="true" aria-expanded="false"
                        class="nav-item dropdown py-1 px-0">
                        <a class="nav-link  p-0" :href="route('home')" >
                            {{ $t('home') }}
                            <span class="caret"></span>
                        </a>
                    </li>
                    <li aria-haspopup="true" aria-expanded="false"
                        class="nav-item dropdown py-1 px-0">
                        <a class="nav-link  p-0" :href="route('shop.index')+'?highlight=new-arrivals'">
                            {{ $t('new-arrivals') }}
                            <span class="caret"></span>
                        </a>
                    </li>
                    <li aria-haspopup="true" aria-expanded="false"
                        class="nav-item dropdown py-1 px-0">
                        <a class="nav-link  p-0" :href="route('shop.index')+'?highlight=best-seller'">
                            {{ $t('best-seller') }}
                            <span class="caret"></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-transparent border-0 mt-auto pl-8 pr-7 pb-0 pt-4">
                <ul class="list-inline d-flex align-items-center mb-3">
                    <li class="list-inline-item mr-4">
                        <a :href="$page.props.contact.site_pinterest" class="fs-20 lh-1"><i class="fab fa-pinterest-p"></i></a>
                    </li>
                    <li class="list-inline-item mr-4">
                        <a :href="$page.props.contact.site_facebook" class="fs-20 lh-1"><i
                        class="fab fa-facebook-f"></i></a>
                    </li>
                    <li class="list-inline-item mr-4"><a :href="$page.props.contact.site_instagram" class="fs-20 lh-1"><i
                        class="fab fa-instagram"></i></a></li>
                    <li class="list-inline-item"><a :href="$page.props.contact.site_twitter" class="fs-20 lh-1"><i class="fab fa-twitter"></i></a></li>
                </ul>
                <p class="mb-0 text-gray">
                    © 2022 Shoppies.<br>
                    All rights reserved.
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import NavbarMainCanvas from "./navbar-main-canvas";
export default {
    components: {NavbarMainCanvas}
}
</script>
