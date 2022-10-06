<template>
    <main class="main">
        <div class="container checkout-container">
            <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
                <li class="prev">
                    <router-link to="/pages/cart" exact-active-class="active">Shopping Cart</router-link>
                </li>
                <li>
                    <router-link to="/pages/checkout" exact-active-class="active">Checkout</router-link>
                </li>
                <li>
                    <a href="#" class="disabled">Order Complete</a>
                </li>
            </ul>
            <error-boxes-component :errorMsg="errorMsg"></error-boxes-component>
            <div class="login-form-container mb-1" v-if="!isCustomer">
                <h4>
                    Returning customer?
                    <button
                        type="button"
                        class="btn btn-link btn-toggle"
                        @click="toggleLoginForm = !toggleLoginForm"
                    >Login</button>
                </h4>
                <vue-slide-toggle
                    class="login-section feature-box"
                    :open="toggleLoginForm"
                    :duration="500"
                >
                    <div class="feature-box-content">
                        <form
                            action="#"
                            id="login-form"
                            @submit.prevent="login(loginEmail, loginPassword)"
                        >
                            <p class="mb-2">
                                You already have an account with us. Sign in or
                                continue as guest.
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Email Address
                                            <span class="required">*</span>
                                        </label>
                                        <input
                                            v-model="loginEmail"
                                            type="email"
                                            class="form-control"
                                            required
                                        />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Password
                                            <span class="required">*</span>
                                        </label>
                                        <input
                                            v-model="loginPassword"
                                            type="password"
                                            class="form-control"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer mb-1">
                                <button type="submit" class="btn">LOGIN</button>
                                <router-link
                                    to="/pages/forgot-pwd"
                                    class="forget-pass"
                                >Forgot your password?</router-link>
                            </div>
                        </form>
                    </div>
                </vue-slide-toggle>
            </div>
            <div class="checkout-discount mb-3" v-if="getSetting('enable_coupon') !== '0'">
                <h4 class="mb-3">
                    Have a coupon?
                    <button
                        type="button"
                        class="btn btn-link btn-toggle"
                        @click="toggleCouponForm = !toggleCouponForm"
                    >Enter your code</button>
                </h4>

                <vue-slide-toggle class="feature-box" :open="toggleCouponForm" :duration="500">
                    <div class="feature-box-content">
                        <form action="#" @submit.prevent="couponAdd(coupon)">
                            <div class="input-group">
                                <input
                                    v-model="coupon"
                                    type="text"
                                    class="form-control form-control-sm w-auto mr-2"
                                    placeholder="Enter discount code"
                                    required
                                />
                                <div class="input-group-append">
                                    <button class="btn btn-sm" type="submit">Apply Coupon</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </vue-slide-toggle>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <ul class="checkout-steps">
                        <li>
                            <h2 class="step-title">Billing Details</h2>

                            <form action="#" id="checkout-form" @submit.prevent="placeOrder">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                First Name
                                                <span class="required">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="billing.firstName"
                                                required
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                Last Name
                                                <span class="required">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="billing.lastName"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Company</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="billing.company"
                                    />
                                </div>

                                <div class="form-group">
                                    <label>Country</label>
                                    <Select2
                                        id="billing-country-select"
                                        v-model="billing.country"
                                        :required="true"
                                        :options="billingCountries"
                                    ></Select2>
                                </div>

                                <div class="form-group">
                                    <label>
                                        Street Address
                                        <span class="required">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="billing.streetAddress1"
                                        placeholder="House number and street name"
                                        required
                                    />
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="billing.streetAddress2"
                                        placeholder="Apartment, suite, unite, etc. (optional)"
                                        requireds
                                    />
                                </div>

                                <div class="form-group">
                                    <label>
                                        City
                                        <span class="required">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model.lazy="billing.city"
                                        required
                                    />
                                </div>

                                <div class="form-group">
                                    <label>State/Province</label>
                                    <Select2
                                        v-if="billingStates.length"
                                        key="billing-state-select2"
                                        id="billing-state-select"
                                        v-model="billing.state"
                                        :required="true"
                                        :options="billingStates"
                                    ></Select2>
                                    <input
                                        v-else
                                        key="billing-state-input"
                                        type="text"
                                        class="form-control"
                                        required
                                        v-model.lazy="billing.state"
                                    />
                                </div>

                                <div class="form-group">
                                    <label>
                                        Zip/Postal Code
                                        <span class="required">*</span>
                                    </label>
                                    <input
                                        v-model.lazy="billing.zip"
                                        type="text"
                                        class="form-control"
                                        required
                                    />
                                </div>

                                <div class="form-group">
                                    <label>
                                        Phone Number
                                        <span class="required">*</span>
                                    </label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        v-model="billing.phone"
                                        required
                                    />
                                </div>

                                <div class="form-group">
                                    <label>
                                        Email address
                                        <span class="required">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        v-model="billing.email"
                                        required
                                    />
                                </div>

                                <template
                                    v-if="
										getSetting(
											'default_shipping_address'
										) !== 'force_billing'
									"
                                >
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                class="custom-control-input"
                                                v-model="diffShipping"
                                                @change="shippingMethod = null"
                                                id="different-shipping"
                                            />
                                            <label
                                                class="custom-control-label"
                                                for="different-shipping"
                                            >
                                                Ship to a different
                                                address?
                                            </label>
                                        </div>
                                    </div>

                                    <transition
                                        name="fade"
                                        enter-active-class="fadeInDown"
                                        leave-active-class="fadeOutUp"
                                    >
                                        <div class="shipping-info" v-if="diffShipping">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group required-field">
                                                        <label>First Name</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            v-model="
																shipping.firstName
															"
                                                            required
                                                        />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group required-field">
                                                        <label>Last Name</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            v-model="
																shipping.lastName
															"
                                                            required
                                                        />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Company</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="shipping.company"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label>Country</label>
                                                <Select2
                                                    id="shipping-country-select"
                                                    v-model="shipping.country"
                                                    :required="true"
                                                    :options="shippingCountries"
                                                ></Select2>
                                            </div>

                                            <div class="form-group required-field">
                                                <label>Street Address</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="
														shipping.streetAddress1
													"
                                                    placeholder="House number and street name"
                                                    required
                                                />
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="
														shipping.streetAddress2
													"
                                                    placeholder="Apartment, suite, unite, etc. (optional)"
                                                    requireds
                                                />
                                            </div>

                                            <div class="form-group required-field">
                                                <label>City</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model.lazy="shipping.city"
                                                    required
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label>State/Province</label>
                                                <Select2
                                                    v-if="shippingStates.length"
                                                    key="shipping-state-select2"
                                                    id="shipping-state-select"
                                                    v-model.lazy="
														shipping.state
													"
                                                    :required="true"
                                                    :options="shippingStates"
                                                ></Select2>
                                                <input
                                                    v-else
                                                    key="shipping-state-input"
                                                    type="text"
                                                    class="form-control"
                                                    required
                                                    v-model.lazy="
														shipping.state
													"
                                                />
                                            </div>

                                            <div class="form-group required-field">
                                                <label>Zip/Postal Code</label>
                                                <input
                                                    v-model.lazy="shipping.zip"
                                                    type="text"
                                                    class="form-control"
                                                    required
                                                />
                                            </div>
                                        </div>
                                    </transition>
                                </template>
                            </form>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-5">
                    <div class="order-summary" :class="{ loading: loading }">
                        <div class="d-loading-container" :class="{'d-none' : !loading}"><div class="d-loading"></div></div>
                        <h3>YOUR ORDER</h3>

                        <table class="table table-mini-cart">
                            <thead>
                                <th colspan="2">
                                    <h4>Product</h4>
                                </th>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in cartList" :key="index">
                                    <td class="product-col">
                                        <h2 class="product-title">
                                            {{ product.name }} ×
                                            <span class="product-qty">
                                                {{
                                                product.qty
                                                }}
                                            </span>
                                        </h2>
                                    </td>
                                    <td class="price-col">
                                        <span
                                            v-html="
												formatPrice(
													product.sum +
														(product.tax_amount &&
														showTax
															? product.tax_amount
															: 0)
												)
											"
                                        ></span>
                                        <small v-if="product.tax_amount && showTax">(incl.VAT)</small>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="cart-subtotal">
                                    <th>
                                        <h4>Subtotal</h4>
                                    </th>
                                    <td class="price-col">
                                        <span
                                            v-html="
												formatPrice(
													priceTotal +
														(showTax ? taxTotal : 0)
												)
											"
                                        ></span>
                                        <small v-if="showTax && taxTotal">(incl.VAT)</small>
                                    </td>
                                </tr>
                                <template v-if="appliedCoupons.length">
                                    <tr
                                        class="cart-discount"
                                        v-for="(coupon,
										index) in appliedCoupons"
                                        :key="'coupon' + index"
                                    >
                                        <th>Coupon:{{ coupon.code }}</th>
                                        <td>
                                            <span
                                                v-html="
													formatPrice(
														-coupon.amount -
															(coupon.tax &&
															showTax
																? coupon.tax
																: 0)
													)
												"
                                            ></span>
                                            <a
                                                href="javascript:;"
                                                @click="
													couponRemove(coupon.code)
												"
                                            >[Remove]</a>
                                        </td>
                                    </tr>
                                </template>
                                <tr class="order-shipping" v-if="shippingMethods !== null">
                                    <td class="text-left" colspan="2">
                                        <h4>Shipping</h4>
                                        <ul
                                            v-if="shippingMethods.length"
                                            key="available-shipping-methods"
                                        >
                                            <li
                                                v-for="(availableShippingMethod,
												index) in shippingMethods"
                                                :key="index"
                                            >
                                                <div class="custom-control custom-radio">
                                                    <input
                                                        v-model="shippingMethod"
                                                        type="radio"
                                                        class="custom-control-input"
                                                        name="shipping-method"
                                                        :id="
															'shipping-method-' +
															index
														"
                                                        :value="index"
                                                    />
                                                    <label
                                                        :for="
															'shipping-method-' +
															index
														"
                                                        class="custom-control-label"
                                                    >
                                                        {{
                                                        availableShippingMethod.name
                                                        }}
                                                        <div class="price">
                                                            <span
                                                                v-html="
																	formatPrice(
																		availableShippingMethod.cost *
																			1.0 +
																			(showTax &&
																			availableShippingMethod.tax
																				? availableShippingMethod.tax *
																				  1.0
																				: 0)
																	)
																"
                                                            ></span>
                                                            <small
                                                                v-if="
																	showTax &&
																	availableShippingMethod.tax
																"
                                                            >(incl.VAT)</small>
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                        <div
                                            class="info-box with-icon p-0"
                                            v-else
                                            key="no-shipping-methods"
                                        >
                                            <p>
                                                There are no shipping options
                                                available. Please ensure that
                                                your address has been entered
                                                correctly, or contact us if you
                                                need any help.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr
                                    class="cart-tax"
                                    v-if="
										!showTax &&
										getSetting('enable_tax') === '1'
									"
                                >
                                    <th>
                                        <h4>Tax</h4>
                                    </th>
                                    <td class="price-col" v-html="formatPrice(taxAmount)"></td>
                                </tr>
                                <tr class="order-total">
                                    <th>
                                        <h4>Total</h4>
                                    </th>
                                    <td>
                                        <b class="total-price">
                                            <span v-html="formatPrice(totalPrice)"></span>
                                            <small
                                                v-if="showTax && taxAmount > 0"
                                                v-html="
													'(incl ' +
													formatPrice(taxAmount) +
													' tax)'
												"
                                            ></small>
                                        </b>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="payment-methods mb-5">
                            <h4 class>Payment Methods</h4>
                            <ul v-if="paymentMethods.length" key="available-payment-methods">
                                <li v-for="(payment, index) in paymentMethods" :key="index">
                                    <div class="custom-control custom-radio">
                                        <input
                                            type="radio"
                                            class="custom-control-input"
                                            v-model="paymentMethod"
                                            name="payment-method"
                                            :id="'payment-method-' + payment.id"
                                            :value="payment.id"
                                        />
                                        <label
                                            :for="
												'payment-method-' + payment.id
											"
                                            class="custom-control-label"
                                        >{{ payment.name }}</label>
                                    </div>
                                </li>
                            </ul>
                            <div class="info-box with-icon p-0" v-else key="no-payment-methods">
                                <p>
                                    Sorry, it seems that there are no available
                                    payment methods for your state. Please
                                    contact us if you require assistance or wish
                                    to make alternate arrangements.
                                </p>
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="btn btn-dark btn-place-order"
                            form="checkout-form"
                        >Place order</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import Select2 from "v-select2-component";
import { VueSlideToggle } from "vue-slide-toggle";

import ErrorBoxesComponent from "../shared/ErrorBoxesComponent";

import { COUNTRIES, STATES } from "../../../data/constant";
import { SET_USER } from "../../store/modules/user/mutation-types";

export default {
    components: {
        Select2,
        VueSlideToggle,
        ErrorBoxesComponent,
    },
    data: function () {
        return {
            // Address and selected method
            billing: {
                firstName: "",
                lastName: "",
                company: "",
                country: "",
                streetAddress1: "",
                streetAddress2: "",
                city: "",
                state: "",
                zip: "",
                phone: "",
                email: "",
            },
            shipping: {
                firstName: "",
                lastName: "",
                company: "",
                country: "",
                streetAddress1: "",
                streetAddress2: "",
                city: "",
                state: "",
                zip: "",
            },
            diffShipping: false,
            paymentMethod: null,
            shippingMethod: null,

            // Extra form
            coupon: "",
            loginEmail: "",
            loginPassword: "",

            // Avaiable methods
            paymentMethods: [],
            shippingMethods: [],
            stripe: null,

            // Toggle form
            toggleLoginForm: false,
            toggleCouponForm: false,
            toggleShippingForm: false,

            errorMsg: [],
            loading: false,
            showTax: false,
        };
    },
    computed: {
        ...mapGetters("cart", [
            "appliedCoupons",
            "appliedCartCoupons",
            "appliedCouponCodes",
            "couponAmount",
            "couponTax",
            "cartList",
            "cartlistOnlyIdQty",
            "cartlistIdQtyName",
            "priceTotal",
            "taxTotal",
            "shippingAddress",
            "billingAddress",
        ]),
        ...mapGetters("setting", ["getSetting", "formatPrice", "getCurrency"]),
        ...mapGetters("user", [
            "getUser",
            "isCustomer",
            "customerBillingAddress",
            "customerShippingAddress",
        ]),
        billingCountries: function () {
            return COUNTRIES.filter((country) => {
                return window.sellableCountries.indexOf(country.id) > -1;
            });
        },
        billingStates: function () {
            return this.billing.country && STATES[this.billing.country]
                ? STATES[this.billing.country]
                : [];
        },
        billingInfoAllEntered: function () {
            return this.billing.city &&
                this.billing.state &&
                this.billing.zip &&
                this.billing.country
                ? this.billing.city +
                      this.billing.state +
                      this.billing.zip +
                      this.billing.country
                : "";
        },
        shippingCountries: function () {
            return COUNTRIES.filter((country) => {
                return window.shippableCountries.indexOf(country.id) > -1;
            });
        },
        shippingStates: function () {
            return this.shipping.country && STATES[this.shipping.country]
                ? STATES[this.shipping.country]
                : [];
        },
        shippingInfoAllEntered: function () {
            return this.shippingInfo.city &&
                this.shippingInfo.state &&
                this.shippingInfo.zip &&
                this.shippingInfo.country
                ? this.shippingInfo.city +
                      this.shippingInfo.state +
                      this.shippingInfo.zip +
                      this.shippingInfo.country
                : "";
        },
        shippingInfo: function () {
            if (this.diffShipping) return this.shipping;
            else
                return {
                    firstName: this.billing.firstName,
                    lastName: this.billing.lastName,
                    company: this.billing.company,
                    country: this.billing.country,
                    streetAddress1: this.billing.streetAddress1,
                    streetAddress2: this.billing.streetAddress2,
                    city: this.billing.city,
                    state: this.billing.state,
                    zip: this.billing.zip,
                };
        },
        addressInfoChanged: function () {
            return this.billingInfoAllEntered || this.shippingInfoAllEntered
                ? this.billingInfoAllEntered + this.shippingInfoAllEntered
                : "";
        },
        taxAmount: function () {
            let sum = this.taxTotal - this.couponTax;
            if (this.shippingMethod != null)
                sum += this.shippingMethods[this.shippingMethod].tax * 1.0;
            if (this.getSetting("tax_round_at_subtotal") !== "0") {
                sum = sum.toFixed(this.getSetting("number_of_decimal"));
            }
            return sum * 1.0;
        },
        totalPrice: function () {
            let total = this.priceTotal - this.couponAmount + this.taxAmount;
            if (this.shippingMethod != null)
                total += this.shippingMethods[this.shippingMethod].cost * 1.0;
            if (this.getSetting("tax_round_at_subtotal") !== "0")
                total = total.toFixed(this.getSetting("number_of_decimal"));
            return total * 1.0;
        },
    },
    watch: {
        addressInfoChanged: async function () {
            await this.getCalculatedItems();
        },
        errorMsg: function () {
            document
                .querySelector(".checkout-progress-bar")
                .scrollIntoView({ behavior: "smooth", block: "end" });
        },
    },
    created: function () {
        var self = this;
        if (this.isCustomer) {
            this.billing = this.customerBillingAddress;
            this.shipping = this.customerShippingAddress;
        } else if (this.getSetting("default_customer_location") === "base") {
            if (this.getSetting("store_country")) {
                let values = this.getSetting("store_country").split(":");
                if (values.length) {
                    this.billing.country = values[1];
                    if (values[0] === "state") this.billing.state = values[2];
                }
            }
            this.billing = {
                ...this.billing,
                streetAddress1: this.getSetting("store_address_line_1"),
                streetAddress2: this.getSetting("store_address_line_2"),
                city: this.getSetting("store_city"),
                zip: this.getSetting("store_postcode"),
            };
            this.shipping = {
                ...this.shipping,
                streetAddress1: this.billing.streetAddress1,
                streetAddress2: this.billing.streetAddress2,
                country: this.billing.country,
                state: this.billing.state,
                city: this.billing.city,
                zip: this.billing.zip,
            };
        }
        this.billing = {
            ...this.billing,
            country: this.billingAddress.country
                ? this.billingAddress.country
                : this.billing.country,
            streetAddress1: this.billingAddress.streetAddress1
                ? this.billingAddress.streetAddress1
                : this.billing.streetAddress1,
            streetAddress2: this.billingAddress.streetAddress2
                ? this.billingAddress.streetAddress2
                : this.billing.streetAddress2,
            city: this.billingAddress.city
                ? this.billingAddress.city
                : this.billing.city,
            state: this.billingAddress.state
                ? this.billingAddress.state
                : this.billing.state,
            zip: this.billingAddress.zip
                ? this.billingAddress.zip
                : this.billing.zip,
        };

        this.shipping = {
            ...this.shipping,
            country: this.shippingAddress.country
                ? this.shippingAddress.country
                : this.shipping.country,
            streetAddress1: this.shippingAddress.streetAddress1
                ? this.shippingAddress.streetAddress1
                : this.shipping.streetAddress1,
            streetAddress2: this.shippingAddress.streetAddress2
                ? this.shippingAddress.streetAddress2
                : this.shipping.streetAddress2,
            city: this.shippingAddress.city
                ? this.shippingAddress.city
                : this.shipping.city,
            state: this.shippingAddress.state
                ? this.shippingAddress.state
                : this.shipping.state,
            zip: this.shippingAddress.zip
                ? this.shippingAddress.zip
                : this.shipping.zip,
        };

        this.diffShipping =
            this.getSetting("default_shipping_address") === "customer_shipping";
        this.showTax =
            this.getSetting("tax_display_in_cart_checkout") === "include";
        window.axios.get("/web/payment-methods").then((response) => {
            this.paymentMethods = [...response.data];
            let stripeDetail = this.paymentMethods.find(
                (item) => item.name == "Stripe"
            );

            if (stripeDetail)
                this.stripe = Stripe(stripeDetail.publishable_key);
        });
    },
    methods: {
        ...mapMutations("cart", {
            updateShippingAddress: "UPDATE_SHIPPING_ADDRESS",
            updateBillingAddress: "UPDATE_BILLING_ADDRESS",
            clearCart: "CLEAR_CART",
        }),
        ...mapMutations("user", {
            setUser: SET_USER,
        }),
        ...mapActions("cart", [
            "applyCoupon",
            "addCoupon",
            "removeCoupon",
            "calcCartItems",
        ]),
        ...mapActions("user", ["login"]),
        couponAdd: async function () {
            this.loading = true;
            const results = await this.addCoupon(this.coupon);
            this.loading = false;

            if (results) {
                this.errorMsg = results.errorMsg;

                if (this.errorMsg.length === 0) {
                    this.shippingMethods = results.shipping;
                    this.coupon = "";
                }
            }
        },
        couponRemove: async function (coupon) {
            this.loading = true;
            const results = await this.removeCoupon(coupon);
            this.loading = false;

            if (results) {
                this.shippingMethods = results.shipping;
            }
        },
        getCalculatedItems: async function (coupon = null) {
            this.updateBillingAddress({
                billingInfo: this.billing,
            });
            this.updateShippingAddress({
                shippingInfo: this.shippingInfo,
            });
            this.loading = true;
            const results = await this.calcCartItems(coupon);
            this.loading = false;
            this.shippingMethod = null;

            if (results) {
                this.shippingMethods = results.shipping;
            }
        },
        placeOrder: async function () {
            this.errorMsg = [];
            if (this.shippingMethods !== null && this.shippingMethod === null) {
                if (
                    this.errorMsg.indexOf(
                        "You have to choose shipping method."
                    ) < 0
                ) {
                    this.errorMsg.push("You have to choose shipping method.");
                }
            }
            if (this.paymentMethod === null) {
                if (
                    this.errorMsg.indexOf(
                        "You have to choose payment method."
                    ) < 0
                ) {
                    this.errorMsg.push("You have to choose payment method.");
                }
            }
            if (this.errorMsg.length > 0) return false;

            this.updateBillingAddress({
                billingInfo: this.billing,
            });
            let payment = this.paymentMethods.find(
                (item) => item.id == this.paymentMethod
            );
            this.loading = true;
            await window.axios
                .post("/web/place-order", {
                    items: this.cartlistIdQtyName,
                    applied_coupons: this.appliedCouponCodes,
                    billing: this.billing,
                    shipping: this.shippingInfo,
                    customer: this.isCustomer ? this.getUser.email : "",
                    shipping_method:
                        this.shippingMethods !== null
                            ? this.shippingMethods[this.shippingMethod].id
                            : null,
                    payment_method: payment,
                })
                .then((response) => {
                    this.clearCart();
                    this.setUser({ user: response.data.user });
                    if (this.paymentMethod == "3") {
                        // cash on delivery
                        this.$router.push(
                            `/pages/order/${response.data.order_id}`
                        );
                    } else if (this.paymentMethod == "1") {
                        // stripe
                        this.stripe.redirectToCheckout({
                            sessionId: response.data.session_id,
                        });
                    } else if (this.paymentMethod == "2") {
                        // paypal
                        window.location.href = response.data.paypal_info;
                    }
                })
                .catch((error) => {
                    if (error.data && error.data.message) {
                        this.errorMsg = error.data.message.split(
                            "/Product-Error/"
                        );
                    }
                });
            this.loading = false;
        }
    },
};
</script>