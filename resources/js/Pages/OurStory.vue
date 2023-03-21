<template>
    <main id="content">
        <user-breadcrumb :page-routes="pageRoutes" :active-link="activeLink"/>
        <section class="pt-lg-18 pb-lg-17 py-14 bg-img-cover-center" style="background-image: url('/images/bg-about.jpg');">
            <div class="container pt-lg-8 pb-lg-7">
                <p class="text-secondary mb-5 text-uppercase font-weight-600 letter-spacing-015" data-animate="fadeInUp">Introducing</p>
                <h1 class="fs-44 fs-lg-56 lh-121" data-animate="fadeInUp">About HappyCute</h1>
            </div>
        </section>
        <section class="pb-9 pt-7 pt-lg-12 pb-lg-15">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-transparent border-0 text-center">
                            <div class="card-body px-0 pb-10 pb-lg-12 pt-1">
                                <h3 class="card-title fs-34 lh-129 mb-5 mx-auto" style="max-width: 610px" data-animate="fadeInUp">We strive to live with
                                    compassion, kindness and empathy</h3>
                                <p class="cart-text mb-0 mx-auto" style="max-width: 670px" data-animate="fadeInUp">A lot of so-called stretch denim
                                    pants out there are just glorified
                                    sweatpants – they get baggy and lose their shape. Not cool. Our tightly knitted fabric holds
                                    its form after repeated wear. Plus, Aldays dress up or down, no prob. So you can wear them
                                    all day. Get it? </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-9 mb-lg-13">
                    <div class="col-12 col-lg-6 pr-lg-0">
                        <div class="hover-shine hover-zoom-in" data-animate="fadeInUp">
                            <img class="w-100" src="/images/about-us-1.jpeg" alt="Give your skin a healthy glow everyone">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 pl-lg-13 mt-lg-0 mt-8">
                        <h3 class="mr-lg-10 mb-5" data-animate="fadeInUp">Give your skin a healthy glow everyone</h3>
                        <p class="mr-lg-10" data-animate="fadeInUp">Luxe, lightweight, and made with the perfect blend of cashmere and cotton, our
                            Sonoma Pillows and
                            Throws are inspired by the basics we turn to season after season. Get to know the cozy essentials
                            that will elevate your space in an instant.</p>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6 pl-lg-13 mt-lg-0 mt-8 order-lg-1 order-2">
                        <h3 class="mr-lg-10" data-animate="fadeInUp">Our mission</h3>
                        <p class="mr-lg-10" data-animate="fadeInUp">Luxe, lightweight, and made with the perfect blend of cashmere and cotton, our
                            Sonoma Pillows and Throws are inspired by the basics we turn to season after season. Get to know the
                            cozy essentials that will elevate your space in an instant.</p>
                    </div>
                    <div class="col-12 col-lg-6 pl-lg-0 order-lg-2 order-1">
                        <div class="hover-shine hover-zoom-in" data-animate="fadeInUp">
                            <img class="w-100" src="/images/about-us-2.jpeg" alt="Our misstion">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="pt-xl-15 pb-xl-13 py-11" style="background-color: #F5F5F5">
                <div class="container">
                    <div class="slick-slider section-01"
                         data-slick-options='{"slidesToShow": 1,"dots":false,"arrows":false,"asNavFor":".section-02"}'>
                        <div class="box">
                            <h4 class="mx-auto text-center mw-750 mb-11" data-animate="fadeInUp">“ Millions of combinations, meaning you get a totally unique piece of furniture exactly the way you want it.”</h4>
                        </div>
                        <div class="box">
                            <h4 class="mx-auto text-center mw-750 mb-11" data-animate="fadeInUp">“ Great tags, Millie has got used to it, nothing like the old tin tags of years gone by. Light weight and great colours available.”	</h4>
                        </div>
                        <div class="box">
                            <h4 class="mx-auto text-center mw-750 mb-11" data-animate="fadeInUp">“ Amazing product. The results are so transformative in texture and my face feels plump and healthy. Highly recommend! “	</h4>
                        </div>
                        <div class="box">
                            <h4 class="mx-auto text-center mw-750 mb-11" data-animate="fadeInUp">“ Millions of combinations, meaning you get a totally unique piece of furniture exactly the way you want it.”</h4>
                        </div>
                        <div class="box">
                            <h4 class="mx-auto text-center mw-750 mb-11" data-animate="fadeInUp">“ Great tags, Millie has got used to it, nothing like the old tin tags of years gone by. Light weight and great colours available.”	</h4>
                        </div>
                        <div class="box">
                            <h4 class="mx-auto text-center mw-750 mb-11" data-animate="fadeInUp">“ Amazing product. The results are so transformative in texture and my face feels plump and healthy. Highly recommend! “	</h4>
                        </div>
                    </div>
                    <div class="slick-slider section-02 client-logo"
                         data-slick-options='{"slidesToShow": 6,"asNavFor":".section-01","focusOnSelect":true,"dots":false,"arrows":false,"responsive":[{"breakpoint": 992,"settings": {"slidesToShow":4,"dots":true}},{"breakpoint": 768,"settings": {"slidesToShow": 3,"dots":true}},{"breakpoint": 576,"settings": {"slidesToShow": 2,"dots":true}}]}'>
                        <div class="box">
                            <div class="d-block mw-150 mx-auto" data-animate="fadeInUp">
                                <img src="{{ '/images/client-logo-01.png' | document_url }}" alt="Client Logo 01"
                                     class="opacity-3 opacity-hover-10 cursor-pointer">
                            </div>
                        </div>
                        <div class="box">
                            <div class="d-block mw-150 mx-auto" data-animate="fadeInUp">
                                <img src="{{ '/images/client-logo-02.png' | document_url }}" alt="Client Logo 02"
                                     class="opacity-3 opacity-hover-10 cursor-pointer">
                            </div>
                        </div>
                        <div class="box">
                            <div class="d-block mw-150 mx-auto" data-animate="fadeInUp">
                                <img src="{{ '/images/client-logo-03.png' | document_url }}" alt="Client Logo 03"
                                     class="opacity-3 opacity-hover-10 cursor-pointer">
                            </div>
                        </div>
                        <div class="box">
                            <div class="d-block mw-150 mx-auto" data-animate="fadeInUp">
                                <img src="{{ '/images/client-logo-04.png' | document_url }}" alt="Client Logo 04"
                                     class="opacity-3 opacity-hover-10 cursor-pointer">
                            </div>
                        </div>
                        <div class="box">
                            <div class="d-block mw-150 mx-auto" data-animate="fadeInUp">
                                <img src="{{ '/images/client-logo-05.png' | document_url }}" alt="Client Logo 05"
                                     class="opacity-3 opacity-hover-10 cursor-pointer">
                            </div>
                        </div>
                        <div class="box">
                            <div class="d-block mw-150 mx-auto" data-animate="fadeInUp">
                                <img src="{{ '/images/client-logo-06.png' | document_url }}" alt="Client Logo 06"
                                     class="opacity-3 opacity-hover-10 cursor-pointer">
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
import UserBreadcrumb from "../Includes/user-breadcrumb";

export default {
    name: "OurStory",
    layout: MainLayout,
    components: {UserBreadcrumb},
    data() {
        return {
            pageRoutes: [
                {
                    title: 'Home',
                    link: this.route('home')
                },
            ],
            activeLink: 'Our Story',
        }
    }
}
</script>

<style scoped>

</style>
