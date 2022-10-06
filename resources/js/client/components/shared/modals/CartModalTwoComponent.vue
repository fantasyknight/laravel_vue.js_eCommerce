<template>
    <notifications
        group="addCartSuccess"
        :duration="2000"
        :width="300"
        :max="4"
        animation-name="fade-left"
        position="bottom right"
    >
        <template
            slot="body"
            slot-scope="props"
        >
            <div class="minipopup-box">
                <div class="product">
                    <figure class="product-media">
                        <router-link :to="'/product/default/' + props.item.data.slug">
                            <img
                                v-lazy="
                                    $root.getUrl(
                                        props.item.data.media[0].copy_link,
                                        true,
                                        300
                                    )
                                "
                                alt="product"
                                :width="props.item.data.media[0].width"
                                :height="props.item.data.media[0].height"
                            />
                        </router-link>
                    </figure>

                    <div class="product-detail">
                        <router-link
                            :to="'/product/default/' + props.item.data.slug"
                            class="product-name"
                        >
                            {{ props.item.data.name }}
                        </router-link>

                        <p>{{ props.item.text }}</p>
                    </div>
                </div>

                <div class="product-action">
                    <router-link
                        to="/pages/cart"
                        class="btn viewcart"
                    >View Cart</router-link>
                    <router-link
                        to="/pages/checkout"
                        class="btn btn-dark checkout"
                    >Checkout</router-link>
                </div>

                <button
                    class="mfp-close"
                    @click="props.close"
                ></button>
            </div>
        </template>
    </notifications>
</template>

<script>
export default {
    name: 'Notify',
    data: function () {
        return {
            console: console
        }
    }
};
</script>

<style lang="scss">
.vue-notification-wrapper {
    overflow: unset !important;
}

.fade-left-enter-active,
.fade-left-leave-active,
.fade-left-move {
    transition: all 0.5s;
}

.fade-left-enter,
.fade-left-leave-to {
    opacity: 0;
    transform: translateX(100%);
}
</style>
