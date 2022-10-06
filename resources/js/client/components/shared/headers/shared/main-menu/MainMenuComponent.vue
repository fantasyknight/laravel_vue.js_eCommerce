<template>
  <nav class="main-nav">
    <ul class="menu sf-arrows">
      <li
        :class="{
          active:
            parent.url == $route.path ||
            (parent.url.includes('shop') && $route.path.includes('shop')) ||
            (parent.url.includes('product') && $route.path.includes('product')),
        }"
        v-for="(parent, index) in mainMenu"
        :key="index"
      >
        <router-link :to="parent.url">{{ parent.name }}</router-link>
        <template v-if="parent.children.length > 0">
          <template v-if="parent.megamenu">
            <div class="megamenu megamenu-fixed-width megamenu-3cols">
              <div class="row">
                <div
                  class="col-lg-4"
                  v-for="(child1, index1) in parent.children"
                  :key="index1"
                >
                  <router-link :to="child1.url" v-if="child1.url">{{
                    child1.name
                  }}</router-link>
                  <a href="#" class="nolink" v-else>{{ child1.name }}</a>
                  <ul class="submenu">
                    <li
                      v-for="(child2, index2) in child1.children"
                      :key="index2"
                    >
                      <router-link :to="child2.url" v-if="child2.url">{{
                        child2.name
                      }}</router-link>
                      <a href="#" class="nolink" v-else>{{ child2.name }}</a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-4 p-0" v-if="parent.url.includes('shop')">
                  <div class="menu-banner h-100">
                    <figure class="h-100">
                      <img
                        v-lazy="$root.getUrl('client/images/menu-banner.jpg')"
                        alt="Menu banner"
                        ratio="159.6%"
                      />
                    </figure>

                    <div
                      class="
                        banner-content
                        position-absolute
                        banner-layer-middle
                      "
                    >
                      <h4>
                        <span class>UP TO</span>
                        <br />
                        <b class>50%</b>
                        <i>OFF</i>
                      </h4>
                      <router-link
                        to="/shop/default"
                        class="btn btn-sm btn-dark"
                        >SHOP NOW</router-link
                      >
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 p-0" v-if="parent.url.includes('product')">
                  <img
                    v-lazy="$root.getUrl('client/images/menu-bg.jpg')"
                    alt="Menu banner"
                    ratio="161.1%"
                    class="product-promo"
                  />
                </div>
              </div>
            </div>
          </template>
          <template v-else>
            <ul class="border-top-0 submenu">
              <li v-for="(child1, index1) in parent.children" :key="index1">
                <router-link :to="child1.url">{{ child1.name }}</router-link>
              </li>
            </ul>
          </template>
        </template>
      </li>

      <li :class="{ 'float-right': alignStretch }">
        <a href="#" :class="{ 'pl-5': alignStretch }" target="_blank">
          Buy Porto!
          <span class="tip tip-new tip-top">Hot</span>
        </a>
      </li>
      <li :class="{ 'float-right': alignStretch }" v-if="!isShort">
        <a href="#" :class="{ 'pr-2': alignStretch }">Special Offer!</a>
      </li>
    </ul>
  </nav>
</template>

<script>
import { mainMenu } from "../../../../../../data/menu";
export default {
  props: {
    isShort: {
      type: Boolean,
      default: false,
    },
    alignStretch: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      mainMenu: mainMenu,
    };
  },
};
</script>