<template>
    <div class="row">
        <div class="col-12">
            <h3 class="text-center fs-34 mb-8">{{$t('customer-reviews')}}</h3>
        </div>
        <div class="col-md-4">
            <div class="card border-0 mb-3">
                <div class="d-flex align-items-center">
                    <h4 class="fs-48 mr-6 mb-0">{{ product.rate }}</h4>
                    <div class="card-body p-0">
                        <rating-widget :rating="product.rate"/>
                        <p class="mb-0">{{ product.reviews_count }} {{ $t('reviews') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 text-md-right mb-4 mb-md-0">
            <a href="#"
               class=" btn btn-outline-secondary border border-2x border-hover-secondary write-review fs-16">
                <svg class="icon icon-Pencil">
                    <use xlink:href="#icon-Pencil"></use>
                </svg>
                {{ $t('write-a-review') }}
            </a>
        </div>
        <div class="col-12 overflow-hidden">
            <div class="card border-0 mt-2 mb-7 form-review hide">
                <div class="card-body p-0">
                    <form @submit.prevent="submit">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mb-4">
                                    <label class="text-secondary font-weight-600" for="reviewName">{{ $t('name') }}</label>
                                    <input id="reviewName" required  v-model="form.name" class="form-control border-0" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-4">
                                    <label class="text-secondary font-weight-600" for="reviewEmail">Email</label>
                                    <input id="reviewEmail" required v-model="form.email" type="email" name="email" class="form-control border-0">
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="text-secondary font-weight-600 mb-0 mr-2 mb-2">{{$t('your-rating')}}</p>
                            <div class="form-group mb-3 d-flex justify-content-start">
                                <div class="rate-input">
                                    <input type="radio" id="star5" name="rate" v-model="form.star" value="5">
                                    <label for="star5" title="text" class="mb-0 mr-1 lh-1">
                                        <i class="fa fa-star"></i>
                                    </label>
                                    <input type="radio" id="star4" name="rate"  v-model="form.star" value="4">
                                    <label for="star4" title="text" class="mb-0 mr-1 lh-1">
                                        <i class="fa fa-star"></i>
                                    </label>
                                    <input type="radio" id="star3" name="rate"  v-model="form.star" value="3">
                                    <label for="star3" title="text" class="mb-0 mr-1 lh-1">
                                        <i class="fa fa-star"></i>
                                    </label>
                                    <input type="radio" id="star2" name="rate"  v-model="form.star" value="2">
                                    <label for="star2" title="text" class="mb-0 mr-1 lh-1">
                                        <i class="fa fa-star"></i>
                                    </label>
                                    <input type="radio" id="star1" name="rate"  v-model="form.star" value="1">
                                    <label for="star1" title="text" class="mb-0 mr-1 lh-1">
                                        <i class="fa fa-star"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="text-secondary font-weight-600" for="reviewTitle">{{$t('review-title')}}:</label>
                            <input id="reviewTitle" type="text" required name="title" v-model="form.title" class="form-control border-0">
                        </div>
                        <div class="form-group mb-6">
                            <label class="text-secondary font-weight-600" for="reviewMessage">{{$t('overall')}}</label>
                            <textarea id="reviewMessage" class="form-control border-0"  required v-model="form.message" name="message"
                                      rows="5"></textarea>
                        </div>
                        <div class="justify-content-end d-flex">
                            <div class="mr-4">
                                <div class="input-group align-items-center">
                                    <span class="name-file mr-4"></span>
                                    <label class="btn btn-outline-secondary btn-custom-input-file bg-hover-secondary bg-transparent border border-2x border-hover-secondary fs-16 font-weight-600 mb-0"
                                           for="reviewAddPhoto">
                                        <svg class="icon icon-Camera fs-20">
                                            <use xlink:href="#icon-Camera"></use>
                                        </svg>
                                        {{ $t('add-photos') }}
                                    </label>
                                    <input type="file" accept="image/*"
                                           multiple="multiple" name="img" @change="toggleFileUpload" class="form-control custom-input-file d-none mr-6"
                                           id="reviewAddPhoto" >
                                    <user-loading-button :loading="isLoading" custom-class="px-7 btn-primary">
                                        {{ $t('submit-now') }}
                                    </user-loading-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-6 mt-lg-8">
        <div class="border-bottom pb-4" v-for="review in product.reviews">
            <div class="d-flex align-items-center mb-3">
                <rating-widget :rating="review.rating"/>
                <span class="divider fs-3 mx-2"><i class="fas fa-circle"></i></span>
                <span class="fs-14"> {{ $h.timeAgo(review.created_at) }}</span>
            </div>
            <div class="media mb-2">
                <img :src="review.user.avatar" class="mr-3 rounded-circle" width="60" height="60" alt="Avatar">
                <div class="media-body">
                    <h5 class="mt-0 fs-14 text-uppercase">{{ review.user.name }}</h5>
                    <p>/ {{ review.user.address }}</p>
                </div>
            </div>
            <p class="font-weight-600 text-secondary mb-2">{{ review.title }}</p>
            <p class="mb-6">{{ review.content }}</p>
            <div class="d-md-flex mb-4 align-items-center align-items-md-start">
                <img  v-for="img in review.media" :src="img" alt="review" class="mb-4 review-md-img" width="200" height="100">
            </div>
        </div>
    </div>
</template>

<script>
import RatingWidget from "../../global-components/RatingWidget";
import UserLoadingButton from "../../global-components/UserLoadingButton";
import {Inertia} from '@inertiajs/inertia'

export default {
    name: "review-product",
    components: {UserLoadingButton, RatingWidget},
    props: {
        product: Object
    },
    data() {
        return {
            isLoading: false,
            form: {
                email: null,
                name: null,
                message: null,
                title: null,
                star: null,
                images: null
            }
        }
    },
    methods: {
        toggleFileUpload(e) {
            this.form.images = e.target.files
        },
        submit() {
            Inertia.post(this.route('review.submit', this.product.id), this.form, {
                onStart: () => this.isLoading = true,
                onFinish: () => this.isLoading = false
            })
        }
    }
}
</script>

<style scoped>

</style>
