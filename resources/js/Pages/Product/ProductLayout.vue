<template>
    <main-layout>
        <main id="content">
            <user-breadcrumb :page-routes="pageRoutes" active-link="shop"/>
            <section>
                <div class="banner-category d-none d-xl-block">
                    <div class="py-4 text-center align-items-center justify-content-center" :style="'background-image: linear-gradient( rgba(0,0,0,0.5), rgba(0, 0, 0, 0.5) ), url('+this.$page.props.cover_image+')'" style=" height: 100px; padding: 10px;
                            width: 100%;
                            background-size: cover;
                            background-repeat: no-repeat;
                            background-position: 50%;
                            margin: auto 0;">
                       <h2 class="text-uppercase text-white">{{$page.props.name}}</h2>
                    </div>
                </div>
                <div class="container container-xl mt-7">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <p class="fs-18 font-weight-500 my-lg-0 my-2" style="color: #696969;">{{ $t('we-found') }} <strong
                            class="font-weight-bold text-secondary">{{ $page.props.total_products }}</strong>
                            {{$t('products-available')}}</p>
                        <div class="d-flex align-items-center">
                            <div class="dropdown show lh-1 rounded ml-lg-5 ml-0" style="background-color:#f5f5f5">
                                <a href="javascript:;"
                                   class="dropdown-toggle custom-dropdown-toggle text-decoration-none text-secondary p-3 mw-210 position-relative d-block"
                                   id="dropdownMenuButton" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    {{ $page.props.sortingBy ? $page.props.sortingBy : 'Default Sorting' }}
                                </a>
                                <div class="dropdown-menu custom-dropdown-item" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" @click="linkTo(this.$page.props.highlight, 'high-low')" href="javascript:;">{{$t('high-low')}}</a>
                                    <a class="dropdown-item" @click="linkTo(this.$page.props.highlight, 'low-high')" href="javascript:;">{{$t('low-high')}}</a>
                                    <a class="dropdown-item" @click="linkTo(this.$page.props.highlight, 'random')" href="javascript:;">{{ $t('random') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="mt-7 pb-11 pb-lg-13">
                <div class="container container-xl">
                    <div class="row">
                        <div class="col-lg-3 primary-sidebar sidebar-sticky pr-lg-8 d-lg-block d-none" id="sidebar">
                            <div class="primary-sidebar-inner">
                                <div class="card border-0 mb-6">
                                    <div class="card-header bg-transparent border-0 p-0">
                                        <h4 class="card-title fs-20 mb-3">Categories</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-unstyled mb-0" v-for="category in $page.props.categories">
                                            <li class="mb-2">
                                                <a :href="route('shop.index', category.slug)"
                                                              class="text-uppercase fs-14 letter-spacing-005 font-weight-600 text-body hover-secondary text-decoration-none">
                                                    {{ category.name }}
                                                </a>
                                                <ul class="list-unstyled ml-5 mt-2 mb-5" v-for="c in category.children">
                                                    <li class="mb-1">
                                                        <a :href="route('shop.index', c.slug)" class="text-body hover-secondary">{{ c.name }}</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card border-0 mb-6">
                                    <div class="card-header bg-transparent border-0 p-0">
                                        <h4 class="card-title fs-20 mb-3">Highlight</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2">
                                                <a href="javascript:;" @click="linkTo('best-seller', this.$page.props.sortingBy)" class="text-body hover-secondary" :class="highlight === 'best-seller'? 'text-secondary' : ''">
                                                    {{$t('best-seller')}}
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="javascript:;" @click="linkTo('new-arrivals', this.$page.props.sortingBy)" :class="this.$page.props.highlight === 'new-arrivals'? 'text-secondary' : ''" class="text-body hover-secondary">
                                                    {{ $t('new-arrivals') }}
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="javascript:;" @click="linkTo('flash-sale', this.$page.props.sortingBy)" :class="this.$page.props.highlight === 'flash-sale'? 'text-secondary' : ''" class="text-body hover-secondary">
                                                    {{ $t('sale') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <slot/>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </main-layout>
</template>

<script>

import MainLayout from "../../layout/MainLayout";
import UserBreadcrumb from "../../Includes/user-breadcrumb";
import {Inertia} from '@inertiajs/inertia'

export default {
    name: "ProductLayout",
    components: {MainLayout, UserBreadcrumb},
    data() {
        return {
            pageRoutes: [
                {
                    title: this.$t('home'),
                    link: this.route('home')
                }
            ],
            activeLink: this.$page.props.name
        }
    },
    methods: {
        linkTo(highlight, sortingBy) {
            Inertia.get(this.$page.props.route, {
                highlight: highlight ? highlight : 'default-sorting',
                sortingBy: sortingBy ? sortingBy : 'default-sorting'
            })
        }
    }
}
</script>
