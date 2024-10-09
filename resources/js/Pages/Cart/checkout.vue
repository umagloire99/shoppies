<template>
  <main id="content">
    <user-breadcrumb :page-routes="pageRoutes" :active-link="activeLink" />
    <section class="pb-lg-13 pb-11">
      <div class="container">
        <h2 class="text-center my-9">{{ $t("checkout") }}</h2>
        <div class="row">
          <div class="col-lg-4 pb-lg-0 pb-11 order-lg-last">
            <div
              class="card border-0"
              style="box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1)"
            >
              <div class="card-header px-0 mx-6 bg-transparent py-5">
                <h4 class="fs-24 mb-5">{{ $t("order-summary") }}</h4>
                <div
                  class="media w-100 mb-4 items-center"
                  v-for="cartItem in $page.props.cart.content"
                >
                  <div class="w-60px mr-3">
                    <img :src="cartItem.img" :alt="cartItem.name" />
                  </div>
                  <div class="media-body d-flex">
                    <div class="cart-price pr-6">
                      <a
                        :href="route('products.show', cartItem.slug)"
                        class="text-secondary pr-6"
                      >
                        {{ cartItem.name }}<br /><span class="text-body">
                          x{{ cartItem.quantity }}</span
                        >
                      </a>
                    </div>
                    <div class="ml-auto">
                      <p class="fs-14 text-secondary mb-0 font-weight-bold">
                        <span
                          class="
                            fs-13
                            font-weight-500
                            text-decoration-through text-body
                            pr-1
                          "
                          v-if="cartItem.discount"
                          >{{ $h.formatPrice(cartItem.price) }}</span
                        ><br />
                        {{ $h.formatPrice(cartItem.discount_price) }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body px-6 pt-5">
                <div class="d-flex align-items-center mb-2">
                  <span>{{ $t("subtotal") }}:</span>
                  <span
                    class="d-block ml-auto text-secondary font-weight-bold"
                    >{{ $h.formatPrice($page.props.cart.total_price) }}</span
                  >
                </div>
                <div class="d-flex align-items-center">
                  <span>{{  $t("shipping") }}:</span
                  >
                  <span
                    class="d-block ml-auto text-secondary font-weight-bold"
                    >0 XAF</span
                  >
                </div>
              </div>
              <div class="card-footer bg-transparent px-0 pb-1 mx-6">
                <div class="d-flex align-items-center font-weight-bold mb-3">
                  <span class="text-secondary">{{ $t("total-price") }}:</span>
                  <span
                    class="
                      d-block
                      ml-auto
                      text-secondary
                      fs-24
                      font-weight-bold
                    ">
                      {{ $h.formatPrice($page.props.cart.total_price) }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 pr-xl-15 order-lg-first form-control-01">
            <form method="post" @submit.prevent="makePayment">
              <h4 class="fs-24 pt-1 mb-4">{{ $t("shipping-information") }}</h4>
              <div class="mb-3">
                <div class="row">
                  <div class="col-md-6 mb-md-0 mb-4">
                    <label
                      class="
                        mb-2
                        fs-13
                        letter-spacing-01
                        font-weight-600
                        text-uppercase
                      "
                      >{{ $t("full-name") }}</label
                    >
                    <text-input
                      :placeholder="$t('name')"
                      :error="errors.name"
                      v-model="form.name"
                      required="required"
                    />
                  </div>
                  <div class="col-md-6 mb-md-0 mb-4">
                    <label
                      class="
                        mb-2
                        fs-13
                        letter-spacing-01
                        font-weight-600
                        text-uppercase
                      "
                      >{{ $t("city") }}</label
                    >
                    <select-input
                      v-model="form.city"
                      :error="errors.city"
                      :placeholder="$t('select-your-city')"
                      :options="cities"
                      label_option="name"
                    />
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="row">
                  <div class="col-md-6 mb-md-0 mb-4">
                    <label
                      class="
                        mb-2
                        fs-13
                        letter-spacing-01
                        font-weight-600
                        text-uppercase
                      "
                      >{{ $t("address") }}</label
                    >
                    <text-input
                      required="required"
                      v-model="form.address"
                      :error="errors.address"
                      :placeholder="$t('address')"
                    />
                  </div>
                  <div class="col-md-6 mb-md-0 mb-4">
                    <label
                      class="
                        mb-2
                        fs-13
                        letter-spacing-01
                        font-weight-600
                        text-uppercase
                      "
                      >{{ $t("phone-number") }}</label
                    >
                    <text-input
                      type="number"
                      v-model="form.phone_one"
                      :error="errors.phone_one"
                      required="required"
                      :placeholder="$t('phone-number')"
                    />
                  </div>
                </div>
              </div>
              <div
                class="payment-box text-info"
                role="alert"
                v-if="pay_code === 'CASH'"
              >
                <p>{{ $t("cash") }}</p>
              </div>
              <div class="alert alert-danger">
                {{ $t('checkout-warning') }}
              </div>

              <div class="payment-box"
                v-if="pay_code === 'MOMO' || pay_code === 'MONETBIL'">
                <div
                  v-if="mtnMessage.text"
                  :class="'alert alert-' + mtnMessage.type"
                  role="alert"
                  v-html="mtnMessage.text"
                ></div>
                <text-input
                  type="number"
                  v-model="form.mtn_phone_number"
                  :error="errors.mtn_phone_number"
                  required="required"
                  :placeholder="
                    pay_code === 'MOMO' ? $t('mtn-phone') : $t('orange-phone')
                  "
                />
              </div>
              <user-loading-button :loading="loading">
                {{ $t("place-order") }}
              </user-loading-button>
            </form>
            <div
              class="card border-0 mt-10"
              style="box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1)"
            >
              <div class="card-body px-6 pt-5 mx-auto">
                <p class="text-center">{{ $t("no-supported-city") }}</p>
                <a
                  :href="'https://wa.me/' + $page.props.contact.phone_number"
                  target="_blank"
                  class="mx-auto"
                >
                  <center>
                    <img
                      src="/img/whatsapp.svg"
                      alt="Whatsapp"
                      class="pr-2"
                      style="width: 80px; height: 80px"
                    />
                  </center>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
import MainLayout from "../../layout/MainLayout";
import UserBreadcrumb from "../../Includes/user-breadcrumb";
import UserLoadingButton from "../../global-components/UserLoadingButton";
import SelectInput from "../../helpers/SelectInput";
import TextInput from "../../helpers/TextInput";
import { Inertia } from "@inertiajs/inertia";

export default {
  name: "checkout",
  components: { TextInput, SelectInput, UserLoadingButton, UserBreadcrumb },
  layout: MainLayout,
  props: {
    cities: Array,
    paymentMethods: Array,
    errors: Object,
  },
  data() {
    return {
      loading: false,
      pay_code: "CASH",
      mtnMessage: {
        type: "info",
        text: null,
      },
      order: null,
      paymentStatus: "PENDING",
      form: {
        mtn_phone_number: null,
        paymentId: null,
        name: this.$page.props.cart.shipping
          ? this.$page.props.cart.shipping.name
          : null,
        address: this.$page.props.cart.shipping
          ? this.$page.props.cart.shipping.address
          : null,
        email: this.$page.props.cart.shipping
          ? this.$page.props.cart.shipping.email
          : null,
        phone_one: this.$page.props.cart.shipping
          ? this.$page.props.cart.shipping.phone_one
          : null,
        phone_two: this.$page.props.cart.shipping
          ? this.$page.props.cart.shipping.phone_two
          : null,
        city_id: null,
        city: this.$page.props.cart.shipping
          ? this.$page.props.cart.shipping.city
          : null,
      },
      pageRoutes: [
        {
          title: this.$t("home"),
          link: this.route("home"),
        },
      ],
      activeLink: this.$t("checkout"),
    };
  },
  methods: {
    sleep(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    },
    makePayment() {
      this.loading = true;
      Inertia.post(this.route("make.payment", this.pay_code), this.form, {
        preserveScroll: true,
        onStart: () => (this.loading = true),
        onFinish: async () => {
          let response = this.$page.props.payment_initialize_result;
          if (response) {
            this.paymentStatus = "PENDING";
            this.mtnMessage.text = response.message;
            if (response.status === "PENDING") {
              this.mtnMessage.type = "info";
              this.mtnMessage.text = response.message;
              let vm = this;
              while (this.paymentStatus === "PENDING") {
                axios.get(
                    this.route("check.momo.payment", [
                      this.pay_code,
                      response.paymentId,
                    ])
                  )
                  .then(function (response) {
                    let result = response.data;
                    vm.paymentStatus = result.status;
                    if (
                      result.status === "COMPLETE" ||
                      result.status === "FAILED"
                    ) {
                      vm.order = result.order;
                      vm.loading = false;
                      vm.mtnMessage.text = result.message;
                      vm.mtnMessage.type =
                        result.status === "FAILED" ? "danger" : "info";
                      if (result.status === "COMPLETE") {
                        Inertia.get(
                          vm.route("payment.success", vm.order.ref_id)
                        );
                      }
                    }
                  })
                  .catch(function (error) {
                    vm.loading = false;
                    vm.mtnMessage.text =
                      "An error occur! Please try again later";
                    vm.mtnMessage.type = "danger";
                  });
                await this.sleep(2000);
              }
            } else {
              this.mtnMessage.type = "danger";
              this.loading = false;
            }
          } else {
              if (this.$page.props.flash && this.$page.props.flash.error) {
                this.loading = false;
              }
          }
        },
      });
    },
  },
};
</script>

