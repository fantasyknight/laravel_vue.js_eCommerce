<template>
    <main class="main">
        <div
            class="container order-complete-container mb-5"
            v-if="order"
        >
            <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
                <li class="prev">
                    <router-link
                        to="/pages/cart"
                        exact-active-class="active"
                    >Shopping Cart</router-link>
                </li>
                <li class="prev">
                    <router-link
                        to="/pages/checkout"
                        exact-active-class="active"
                    >Checkout</router-link>
                </li>
                <li>
                    <a
                        href="#"
                        :class="{ active: $route.path.includes('order') }"
                    >Order Complete</a>
                </li>
            </ul>
            <p>Thank you. Your order has been received.</p>
            <ul class="mb-3">
                <li>
                    Order number: <strong>{{ order.id }}</strong>
                </li>
                <li>
                    Date: <strong>{{ fullDate(order.created_at) }}</strong>
                </li>
                <li>
                    Email: <strong>{{ order.customer_email }}</strong>
                </li>
                <li>
                    Total:
                    <strong v-html="formatPrice(order.order_total_price)"></strong>
                </li>
                <li>
                    Payment method: <strong>{{ order.payment_method }}</strong>
                </li>
            </ul>
            <div class="order-details mb-3">
                <h4 class="title mb-0">Order Details</h4>
                <table class="table table-order-detail">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in order.items"
                            :key="'order-item-' + index"
                        >
                            <td>
                                <router-link :to="'/product/default/' + item.product.slug">
                                    <h4 class="product-title">
                                        {{ item.name }} x
                                    </h4>
                                </router-link>
                                <strong class="product-count">
                                    {{ item.qty }}
                                </strong>
                            </td>
                            <td
                                class="product-price"
                                v-html="
									formatPrice(
										item.net_revenue * 1.0 +
											item.coupon_amount * 1.0
									)
								"
                            ></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Subtotal:</th>
                            <td v-html="formatPrice(orderSubtotal)"></td>
                        </tr>
                        <tr v-if="discountPrice > 0">
                            <th>Discount:</th>
                            <td
                                class="discount-price"
                                v-html="formatPrice(-discountPrice)"
                            ></td>
                        </tr>
                        <tr v-if="order.shipping_method">
                            <th>Shipping:</th>
                            <td class="shipping-method">
                                <span v-html="formatPrice(order.shipping_cost)"></span>
                                <sub>via</sub> {{ order.shipping_method }}
                            </td>
                        </tr>
                        <tr v-if="getSetting('enable_tax') === '1'">
                            <th>Tax</th>
                            <td
                                class="tax-amount"
                                v-html="formatPrice(order.order_tax)"
                            ></td>
                        </tr>
                        <tr>
                            <th>Payment method:</th>
                            <td class="payment-method">
                                {{ order.payment_method }}
                            </td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td class="total-price">
                                <span v-html="
										formatPrice(order.order_total_price)
									"></span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row">
                <div class="address col-md-6">
                    <div class="heading d-flex mb-0">
                        <h4 class="title mb-0">Billing Address</h4>
                    </div>
                    <div class="address-box">
                        <address v-html="billingAddressHtml"></address>
                    </div>
                </div>
                <div class="address col-md-6">
                    <div class="heading d-flex mb-0">
                        <h4 class="title mb-0">
                            Shipping Address
                        </h4>
                    </div>
                    <div class="address-box">
                        <address v-html="shippingAddressHtml"></address>
                    </div>
                </div>
            </div>

            <div
                class="order-details mb-3 mt-2"
                v-if="subOrders.length > 0"
            >
                <h4 class="title mb-1">Sub Orders</h4>
                <p>
                    <strong>Note:</strong> This order has products from multiple
                    vendors. Each order will be handled by individual vendor
                    independently.
                </p>
                <table class="table table-order-detail">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(subOrder, index) in subOrders"
                            :key="'order-item-' + index"
                        >
                            <td>
                                {{ subOrder.id }}
                            </td>
                            <td>
                                {{ subOrder.created_at }}
                            </td>
                            <td>
                                {{ subOrder.status }}
                            </td>
                            <td>
                                <span v-html="
										formatPrice(subOrder.order_total_price)
									"></span>
                                for {{ subOrder.order_total_qty }} items(s)
                            </td>
                            <td>
                                <router-link
                                    :to="'/pages/account/orders/' + subOrder.id"
                                    class="btn btn-shop"
                                >View</router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</template>
<script>
import { format } from "date-format-parse";
import { mapGetters } from "vuex";

import { COUNTRIES } from "../../../data/constant";

export default {
    data () {
        return {
            order: null,
            subOrders: []
        };
    },
    computed: {
        ...mapGetters( "cart", [ "billingAddress" ] ),
        ...mapGetters( "user", [ "isCustomer", "getUser" ] ),
        ...mapGetters( "setting", [ "formatPrice", "getSetting" ] ),
        discountPrice: function () {
            return this.order.coupons.reduce( ( acc, cur ) => {
                return acc + cur.coupon_amount * 1.0;
            }, 0 );
        },
        orderSubtotal: function () {
            return this.order.items.reduce( ( acc, cur ) => {
                return acc + cur.net_revenue * 1.0 + cur.coupon_amount * 1.0;
            }, 0 );
        },
        billingAddressHtml: function () {
            let html =
                this.order.billing_first_name +
                " " +
                this.order.billing_last_name +
                "<br />";
            if ( this.order.billing_company ) {
                html += this.order.billing_company + "<br />";
            }
            html += this.order.billing_street_1;
            if ( this.order.billing_street_2 ) {
                html += ", " + this.order.billing_street_2;
            }
            html += "<br />";
            html +=
                this.order.billing_city +
                ", " +
                this.order.billing_state +
                " " +
                this.order.billing_postcode +
                "<br />";
            html += this.countryFullName( this.order.billing_country ) + "<br />";
            html += "<p>" + this.order.billing_phone + "</p>";
            html += "<p>" + this.order.billing_email + "</p>";
            return html;
        },
        shippingAddressHtml: function () {
            let html =
                this.order.shipping_first_name +
                " " +
                this.order.shipping_last_name +
                "<br />";
            if ( this.order.shipping_company ) {
                html += this.order.shipping_company + "<br />";
            }
            html += this.order.shipping_street_1;
            if ( this.order.shipping_street_2 ) {
                html += ", " + this.order.shipping_street_2;
            }
            html += "<br />";
            html +=
                this.order.shipping_city +
                ", " +
                this.order.shipping_state +
                " " +
                this.order.shipping_postcode +
                "<br />";
            html +=
                this.countryFullName( this.order.shipping_country ) + "<br />";
            return html;
        },
    },
    created: async function () {
        await window.axios
            .get( "/web/order-detail/" + this.$route.params.id, {
                params: {
                    customer: this.isCustomer
                        ? this.getUser.email
                        : this.billingAddress.email,
                },
            } )
            .then( ( response ) => {
                this.order = response.data.order;
                this.subOrders = response.data.subOrders;
            } )
            .catch( ( error ) => {
                this.$router.push( "/pages/404" );
            } );
    },
    methods: {
        fullDate: function ( date ) {
            return format( date, "MMMM DD, YYYY" );
        },
        countryFullName: function ( countryCode ) {
            return COUNTRIES.find( ( country ) => country.id === countryCode ).text;
        }
    },
};
</script>