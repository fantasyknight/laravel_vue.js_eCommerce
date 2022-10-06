<template>
    <div class="product-nav">
        <div class="product-prev" :class="{ disabled: !prevProduct }">
            <router-link
                :to="{
                    params: {
                        slug: prevProduct.slug,
                    },
                }"
                v-if="prevProduct"
            >
                <span class="product-link"></span>
                <span class="product-popup">
                    <span class="box-content">
                        <img
                            v-lazy="
                                $root.getUrl(
                                    prevProduct.media[0]
                                        .copy_link,
                                    true,
                                    150
                                )
                            "
                            :alt="
                                prevProduct.media[0]
                                    .alt_text
                                    ? prevProduct
                                            .media[0]
                                            .alt_text
                                    : 'product'
                            "
                            width="150"
                            height="150"
                            v-if="
                                prevProduct.media
                                    .length > 0
                            "
                            :key="'product-image'"
                        />
                        <img
                            :src="
                                $root.getUrl(
                                    'server/images/placeholder-img-150x150.png'
                                )
                            "
                            alt="product"
                            width="150"
                            height="150"
                            v-else
                            :key="'placeholder'"
                        />
                        <span>{{ prevProduct.name }}</span>
                    </span>
                </span>
            </router-link>
            <a href="javascript:;" v-else>
                <div class="product-link"></div>
            </a>
        </div>
        <div class="product-next" :class="{ disabled: !nextProduct }">
            <router-link
                :to="{
                    params: {
                        slug: nextProduct.slug,
                    },
                }"
                v-if="nextProduct"
            >
                <span class="product-link"></span>
                <span class="product-popup">
                    <span class="box-content">
                        <img
                            v-lazy="
                                $root.getUrl(
                                    nextProduct.media[0]
                                        .copy_link,
                                    true,
                                    150
                                )
                            "
                            :alt="
                                nextProduct.media[0]
                                    .alt_text
                                    ? nextProduct
                                            .media[0]
                                            .alt_text
                                    : 'product'
                            "
                            width="150"
                            height="150"
                            v-if="
                                nextProduct.media
                                    .length > 0
                            "
                            :key="'product-image'"
                        />
                        <img
                            :src="
                                $root.getUrl(
                                    'server/images/placeholder-img-150x150.png'
                                )
                            "
                            alt="product"
                            width="150"
                            height="150"
                            v-else
                            :key="'placeholder'"
                        />
                        <span>{{ nextProduct.name }}</span>
                    </span>
                </span>
            </router-link>
            <a href="javascript:;" v-else>
                <div class="product-link"></div>
            </a>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        prevProduct: Object,
        nextProduct: Object
    }
}
</script>