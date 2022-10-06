<template>
    <div
        class="order-detail-container"
        v-if="order"
    >
        <div class="order-info mb-4">
            Order #
            <span class="order-id">{{ order.id }}</span> was placed on
            <span class="order-date">{{ fullDate(order.created_at) }}</span> and
            is currently
            <span class="order-status">{{ orderStatus }}.</span>
        </div>
        <div
            class="order-updates mb-3"
            v-if="order.notes.length"
        >
            <h4 class="title text-primary mb-2">Order Updates</h4>
            <div
                class="order-update"
                v-for="(note, index) in order.notes"
                :key="'order-note-' + index"
            >
                <div class="order-update-time">
                    {{ fullDateTime(note.created_at) }}
                </div>
                <p>{{ note.content }}</p>
            </div>
        </div>
        <div
            class="order-downloads mb-3"
            v-if="downloads.length > 0"
        >
            <h4 class="title text-primary mb-2">Downloads</h4>
            <table class="table table-downloads">
                <thead>
                    <tr>
                        <th class="product-name">Product Name</th>
                        <th class="file-name">File Name</th>
                        <th class="download-action">Download</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(download, index) in downloads"
                        :key="'download-' + index"
                    >
                        <td class="product-title">
                            <router-link :to="'/product/default/' + download.slug">{{ download.name }}</router-link>
                        </td>
                        <td>{{ download.fileName }}</td>
                        <td class="donwload-action">
                            <a
                                :href="'/web/download?link=' + download.link"
                                class="btn btn-download btn-primary"
                                title="Download"
                            >
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="order-details mb-3">
            <h4 class="title text-primary mb-3">Order Details</h4>
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
                                <template v-if="itemRefundedQty(item.id)">
                                    <span class="product-old-count">
                                        {{ item.qty }}
                                    </span>
                                    <span class="product-new-count">
                                        {{
											parseInt(item.qty) +
											itemRefundedQty(item.id)
										}}
                                    </span>
                                </template>
                                <template v-else>{{ item.qty }}</template>
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
                    <tr>
                        <th>Shipping:</th>
                        <td class="shipping-method">
                            <span v-html="formatPrice(order.shipping_cost)"></span>
                            <sub>via</sub>
                            {{ order.shipping_method }}
                        </td>
                    </tr>
                    <tr v-if="orderTax > 0">
                        <th>Tax</th>
                        <td
                            class="tax-amount"
                            v-html="formatPrice(orderTax)"
                        ></td>
                    </tr>
                    <tr>
                        <th>Payment method:</th>
                        <td class="payment-method">
                            {{ order.payment_method }}
                        </td>
                    </tr>
                    <tr>
                        <th>Refund:</th>
                        <td
                            class="refunded-price"
                            v-html="formatPrice(order.order_refunded_price)"
                        ></td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td class="total-price">
                            <template v-if="order.order_refunded_price < 0">
                                <span
                                    class="order-old-price"
                                    v-html="
										formatPrice(order.order_total_price)
									"
                                ></span>
                                <span
                                    class="order-new-price"
                                    v-html="
										formatPrice(
											order.order_total_price * 1.0 +
												order.order_refunded_price * 1.0
										)
									"
                                ></span>
                            </template>
                            <template v-else>
                                <span v-html="
										formatPrice(order.order_total_price)
									"></span>
                            </template>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row">
            <div class="address col-md-6">
                <div class="heading d-flex mb-2">
                    <h4 class="title text-primary mb-0">Billing Address</h4>
                </div>
                <div class="address-box">
                    <address v-html="billingAddressHtml"></address>
                </div>
            </div>
            <div class="address col-md-6">
                <div class="heading d-flex mb-2">
                    <h4 class="title text-primary mb-0">Shipping Address</h4>
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
            <h4 class="title text-primary mb-1">Sub Orders</h4>
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
                        <td>{{ subOrder.id }}</td>
                        <td>{{ subOrder.created_at }}</td>
                        <td>{{ subOrder.status }}</td>
                        <td>
                            <span v-html="formatPrice(subOrder.order_total_price)"></span>
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
</template>
<script>
import { mapGetters } from "vuex";
import { format } from "date-format-parse";
import { COUNTRIES } from "../../../../../data/constant";

export default {
    data () {
        return {
            order: null,
            refundedItems: [],
            downloads: [],
        };
    },
    computed: {
        ...mapGetters( "setting", [ "formatPrice" ] ),
        ...mapGetters( "user", [ "getUser" ] ),
        discountPrice: function () {
            if ( this.order.order_type == "suborder" ) {
                return (
                    this.orderSubtotal +
                    this.orderTax * 1.0 -
                    this.order.order_total_price * 1.0
                );
            } else {
                return this.order.coupons.reduce( ( acc, cur ) => {
                    return acc + cur.coupon_amount * 1.0;
                }, 0 );
            }
        },
        orderStatus: function () {
            if ( this.order.status === "on-hold" ) {
                return "On Hold";
            } else {
                return (
                    this.order.status[ 0 ].toUpperCase() +
                    this.order.status.slice( 1 )
                );
            }
        },
        orderSubtotal: function () {
            return this.order.items.reduce( ( acc, cur ) => {
                return acc + cur.net_revenue * 1.0 + cur.coupon_amount * 1.0;
            }, 0 );
        },
        orderTax: function () {
            return this.refundedItems.reduce(
                ( acc, cur ) => {
                    return acc - cur.tax_amount * 1.0;
                },
                this.order.order_tax ? this.order.order_tax : 0
            );
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
    watch: {
        $route: function () {
            this.getOrderDetail();
        },
    },
    created: async function () {
        this.getOrderDetail();
    },
    methods: {
        fullDate: function ( date ) {
            return format( date, "MMMM DD, YYYY" );
        },
        fullDateTime: function ( datetime ) {
            return format( datetime, "dddd D of MMMM YYYY, HH:mmA" );
        },
        itemRefundedQty: function ( itemId ) {
            return this.refundedItems.reduce( ( acc, cur ) => {
                if ( cur.product_id === itemId ) {
                    acc += parseInt( cur.qty );
                }
                return acc;
            }, 0 );
        },
        countryFullName: function ( countryCode ) {
            return COUNTRIES.filter( ( country ) => country.id === countryCode )[ 0 ]
                .text;
        },
        getOrderDetail: async function () {
            await window.axios
                .get( "/web/order-detail/" + this.$route.params.id, {
                    params: {
                        customer: this.getUser.email,
                    },
                } )
                .then( ( response ) => {
                    this.order = response.data.order;
                    this.subOrders = response.data.subOrders;
                    this.refundedItems = response.data.refundedItems;
                    this.downloads = response.data.downloads;
                } )
                .catch( ( error ) => {
                    this.$router.push( "/pages/404" );
                } );
        },
    },
};
</script>