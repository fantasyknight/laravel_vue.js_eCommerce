<template>
	<div>
		<div class="order-table-container">
			<table class="table table-order">
				<thead>
					<tr>
						<th class="order-id">Order</th>
						<th class="order-date">Date</th>
						<th class="order-status">Status</th>
						<th class="order-price">Total</th>
						<th class="order-action">Actions</th>
					</tr>
				</thead>
				<tbody>
					<template v-if="orders.length">
						<tr v-for="(order, index) in orders" :key="index">
							<td class="order-id">
								<router-link
									:to="'/pages/account/orders/' + order.id"
									class="btn-link"
									>#{{ order.id }}</router-link
								>
							</td>
							<td class="order-date">
								{{ fullDate(order.created_at) }}
							</td>
							<td class="order-status">
								{{ order.status }}
							</td>
							<td class="order-price">
								<span class="total-price">
									<template
										v-if="order.order_refunded_price < 0"
									>
										<span
											class="order-old-price"
											v-html="
												formatPrice(
													order.order_total_price
												)
											"
										></span>
										<span
											class="order-new-price"
											v-html="
												formatPrice(
													order.order_total_price *
														1.0 +
														order.order_refunded_price *
															1.0
												)
											"
										></span>
									</template>
									<template v-else>
										<span
											v-html="
												formatPrice(
													order.order_total_price
												)
											"
										></span>
									</template>
								</span>
								for
								<span class="total-items"
									>{{ order.order_total_qty }} item{{
										order.order_total_qty > 1 ? "s" : ""
									}}</span
								>
							</td>
							<td class="order-action">
								<router-link
									:to="'/pages/account/orders/' + order.id"
									class="btn btn-primary"
								>
									View
								</router-link>
							</td>
						</tr>
					</template>
					<tr v-else>
						<td class="text-center" colspan="5">
							No Order has been made yet.
						</td>
					</tr>
				</tbody>
			</table>
			<router-link
				v-if="orders.length === 0"
				to="/shop/default"
				class="btn btn-primary text-transform-none mb-2"
				>Go Shop</router-link
			>
		</div>
	</div>
</template>
	
<script>
import { format } from "date-format-parse";
import { mapGetters } from "vuex";

export default {
	data() {
		return {
			orders: [],
		};
	},
	computed: {
		...mapGetters("setting", ["formatPrice"]),
		...mapGetters("user", ["getUser"]),
	},
	created: async function () {
		const response = await window.axios.get(
			"/web/customer-orders/" + this.getUser.email
		);
		this.orders = response.data.orders;
	},
	methods: {
		fullDate: function (date) {
			return format(date, "MMMM DD, YYYY");
		},
	},
};
</script>