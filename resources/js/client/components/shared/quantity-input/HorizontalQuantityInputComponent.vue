<template>
    <div class="product-single-qty">
        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
            <span class="input-group-btn input-group-prepend">
                <button
                    class="btn btn-outline btn-down-icon bootstrap-touchspin-down"
                    @click.prevent="countDown"
                    type="button"
                ></button>
            </span>
            <input
                class="horizontal-quantity form-control"
                type="number"
                :max="
					product.manage_stock && product.stock_quantity > 0
						? product.stock_quantity
						: undefined
				"
                v-model.number="qty"
                @input="changeQty"
            />
            <span class="input-group-btn input-group-append">
                <button
                    class="btn btn-outline btn-up-icon bootstrap-touchspin-up"
                    @click.prevent="countUp"
                    type="button"
                ></button>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        product: Object,
        quantity: {
            type: Number,
            default: 1,
        },
    },
    data: function () {
        return {
            qty: 1,
        };
    },
    watch: {
        product: function () {
            if (this.product.qty) {
                this.qty = this.product.qty;
            } else {
                this.qty = 1;
            }
        },
    },
    created: function () {
        if (this.product.qty) {
            this.qty = this.product.qty;
        }
    },
    methods: {
        countUp: function () {
            if (
                this.product.manage_stock &&
                this.product.stock_quantity <= this.qty
            ) {
                return;
            }

            if (this.product.sold_individually) return;

            this.qty += 1;
            this.$emit(
                "change-qty",
                this.product.id,
                this.qty,
                this.product.excerpts
            );
        },

        countDown: function () {
            if (this.qty == 1) return;
            this.qty -= 1;
            this.$emit(
                "change-qty",
                this.product.id,
                this.qty,
                this.product.excerpts
            );
        },

        changeQty: function () {
            this.$emit(
                "change-qty",
                this.product.id,
                this.qty,
                this.product.excerpts
            );
        },
    },
};
</script>