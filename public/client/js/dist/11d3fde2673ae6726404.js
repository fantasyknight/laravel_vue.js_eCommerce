(window.webpackJsonp=window.webpackJsonp||[]).push([[58,27],{31:function(t,e,r){"use strict";r.r(e);var i=r(3);function n(t){return function(t){if(Array.isArray(t))return a(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return a(t,e);var r=Object.prototype.toString.call(t).slice(8,-1);"Object"===r&&t.constructor&&(r=t.constructor.name);if("Map"===r||"Set"===r)return Array.from(t);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return a(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function a(t,e){(null==e||e>t.length)&&(e=t.length);for(var r=0,i=new Array(e);r<e;r++)i[r]=t[r];return i}function s(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(t);e&&(i=i.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,i)}return r}function o(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?s(Object(r),!0).forEach((function(e){c(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):s(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function c(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var u={props:{product:{type:Object,default:function(){return{type:"simple",sale_schedule:!1,virtual:!1,downloadable:!1,tax_status:"taxable",tax_type_id:1,allow_backorder:"no",stock_status:"in-stock",manage_stock:!1,media:[],tags:[],files:[]}}}},computed:o(o({},Object(i.c)("setting",["formatPrice","priceSuffix"])),{},{media:function(){return this.product.media.slice(0,2)}}),methods:{getPageUrl:function(){return 0==this.product.parent?{path:"/product/default/"+this.product.slug}:{path:"/product/default/"+this.product.slug,query:{termId:JSON.parse(this.product.excerpt).reduce((function(t,e){return[].concat(n(t),[e.termId])}),[])}}}}},l=r(1),p=Object(l.a)(u,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"product-default left-details product-widget"},[r("figure",[t.product.media.length>0?r("router-link",{key:"media-0",attrs:{to:t.getPageUrl()}},t._l(t.media,(function(e,i){return r("img",{directives:[{name:"lazy",rawName:"v-lazy",value:t.$root.getUrl(e.copy_link,!0,300),expression:"$root.getUrl(medium.copy_link, true, 300)"}],key:i,attrs:{width:"300",height:"300",alt:e.alt_text?e.alt_text:"product"}})})),0):r("router-link",{key:"media-1",attrs:{to:t.getPageUrl()}},[r("img",{directives:[{name:"lazy",rawName:"v-lazy",value:t.$root.getUrl("server/images/placeholder-img-300x300.png"),expression:"\n\t\t\t\t\t$root.getUrl(\n\t\t\t\t\t\t'server/images/placeholder-img-300x300.png'\n\t\t\t\t\t)\n\t\t\t\t"}],attrs:{width:"300",height:"300",alt:"product"}})])],1),t._v(" "),r("div",{staticClass:"product-details"},[r("h3",{staticClass:"product-title"},[r("router-link",{attrs:{to:t.getPageUrl()}},[t._v(t._s(t.product.name))])],1),t._v(" "),r("div",{staticClass:"ratings-container"},[r("div",{staticClass:"product-ratings"},[r("span",{staticClass:"ratings",style:"width:"+20*t.product.average_rating+"%"}),t._v(" "),r("span",{staticClass:"tooltiptext tooltip-top"},[t._v(t._s(t.product.average_rating.toFixed(2)))])])]),t._v(" "),"simple"==t.product.type?r("div",{staticClass:"price-box"},[t.product.min_max_price[0]!=t.product.min_max_price[1]?r("del",{staticClass:"old-price"},[r("span",{domProps:{innerHTML:t._s(t.formatPrice(t.product.min_max_price[1])+t.priceSuffix)}})]):t._e(),t._v(" "),r("span",{staticClass:"product-price",domProps:{innerHTML:t._s(t.formatPrice(t.product.min_max_price[0])+t.priceSuffix)}})]):t._e(),t._v(" "),"variable"==t.product.type?r("div",{staticClass:"price-box"},[r("span",{staticClass:"product-price",domProps:{innerHTML:t._s(t.formatPrice(t.product.min_max_price[0])+t.priceSuffix)}}),t._v(" "),t.product.min_max_price[0]!==t.product.min_max_price[1]?r("span",{staticClass:"product-price"},[t._v("\n\t\t\t\t–\n\t\t\t\t"),r("span",{domProps:{innerHTML:t._s(t.formatPrice(t.product.min_max_price[1])+t.priceSuffix)}})]):t._e()]):t._e()])])}),[],!1,null,null,null);e.default=p.exports},39:function(t,e,r){"use strict";r.r(e);var i=r(3),n=r(172),a=r(42),s=r(31);function o(t){return function(t){if(Array.isArray(t))return c(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return c(t,e);var r=Object.prototype.toString.call(t).slice(8,-1);"Object"===r&&t.constructor&&(r=t.constructor.name);if("Map"===r||"Set"===r)return Array.from(t);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return c(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function c(t,e){(null==e||e>t.length)&&(e=t.length);for(var r=0,i=new Array(e);r<e;r++)i[r]=t[r];return i}function u(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(t);e&&(i=i.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,i)}return r}function l(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?u(Object(r),!0).forEach((function(e){p(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):u(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function p(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var d={components:{VueTreeList:n.VueTreeList,VueSlideToggle:a.a,ProductTwoComponent:s.default},data:function(){return{loaded:!0,attributes:[],categories:[],featuredProducts:[],categorySlideOpen:!0,priceSlideOpen:!0,attributeSlideOpen:[],priceValues:[0,1e3],featuredSlideOpen:!0,priceSliderConfig:{connect:!0,step:50,margin:100,range:{min:0,max:1e3}},isResetFilterShow:!1,shouldSticky:!0}},computed:l(l({},Object(i.c)("setting",["getSetting"])),{},{treeData:function(){return new n.Tree(this.categories)},priceRangeText:function(){return"$"+parseInt(this.priceValues[0])+" — $"+parseInt(this.priceValues[1])}}),watch:{$route:function(){this.$route.query.min_price&&this.$route.query.max_price?(this.loaded=!1,this.priceValues=[this.$route.query.min_price,this.$route.query.max_price],this.$nextTick((function(){this.loaded=!0}))):(this.loaded=!1,this.priceValues=[parseInt(this.getSetting("filter_min_price")),parseInt(this.getSetting("filter_max_price"))],this.$nextTick((function(){this.loaded=!0}))),Object.values(this.$route.query).length>0?this.isResetFilterShow=!0:this.isResetFilterShow=!1}},methods:{isColor:function(t){return t.includes("#")},changeAttrFilter:function(t,e,r){r.target.parentNode.classList.toggle("active")},setFilterRouteQuery:function(t){return this.$route.query.attributes?-1==this.$route.query.attributes.split(",").findIndex((function(e){return e==t.slug}))?{path:this.$route.fullPath,query:l(l({},this.$route.query),{},{attributes:[].concat(o(this.$route.query.attributes.split(",")),[t.slug]).join(",")})}:{path:this.$route.fullPath,query:l(l({},this.$route.query),{},{attributes:this.$route.query.attributes.split(",").filter((function(e){return e!==t.slug})).join(",")})}:{path:this.$route.fullPath,query:l(l({},this.$route.query),{},{attributes:t.slug})}},setActiveTerm:function(t){return!(!this.$route.query.attributes||-1==this.$route.query.attributes.split(",").findIndex((function(e){return e==t.slug})))},setActiveCategory:function(t){return!(!this.$route.query.category||this.$route.query.category!=t.slug)},attrSlideChange:function(t){this.attributeSlideOpen=this.attributeSlideOpen.reduce((function(e,r,i){return[].concat(o(e),t==i?[!r]:[r])}),[])},setFilterRoute:function(){return{path:this.$route.path,query:l(l({},this.$route.query),{},{min_price:parseInt(this.priceValues[0]),max_price:parseInt(this.priceValues[1])})}}},created:function(){var t=this;this.$route.query.min_price&&this.$route.query.max_price?this.priceValues=[this.$route.query.min_price,this.$route.query.max_price]:this.priceValues=[parseInt(this.getSetting("filter_min_price")),parseInt(this.getSetting("filter_max_price"))],this.priceSliderConfig=l(l({},this.priceSliderConfig),{},{range:{min:parseInt(this.getSetting("filter_min_price")),max:parseInt(this.getSetting("filter_max_price"))}}),Object.values(this.$route.query).length>0?this.isResetFilterShow=!0:this.isResetFilterShow=!1,window.axios.get("/web/shop/sidebar").then((function(e){t.attributes=e.data.attributes,t.categories=e.data.categories,t.featuredProducts=e.data.featuredProducts,t.attributeSlideOpen=t.attributes.reduce((function(t,e){return[].concat(o(t),[!0])}),[])})).catch((function(t){}))}},f=r(1),g=Object(f.a)(d,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"sidebar-wrapper"},[r("div",{staticClass:"widget widget-product-categories"},[r("h3",{staticClass:"widget-title"},[r("a",{class:{collapsed:!t.categorySlideOpen},attrs:{href:"#"},on:{click:function(e){e.preventDefault(),t.categorySlideOpen=!t.categorySlideOpen}}},[t._v("Categories")])]),t._v(" "),r("vue-slide-toggle",{staticClass:"show",attrs:{open:t.categorySlideOpen,duration:200}},[r("div",{staticClass:"widget-body"},[r("vue-tree-list",{attrs:{model:t.treeData},scopedSlots:t._u([{key:"leafNameDisplay",fn:function(e){return[r("router-link",{class:{active:t.setActiveCategory(e.model)},attrs:{to:{path:t.$route.path,query:{category:e.model.slug}}}},[t._v(t._s(e.model.name)+"\n\t\t\t\t\t\t")]),t._v("\n\t\t\t\t\t\t("+t._s(e.model.count)+")\n\t\t\t\t\t")]}},{key:"treeNodeIcon",fn:function(){return[r("span")]},proxy:!0}])})],1)])],1),t._v(" "),t.isResetFilterShow?r("div",{staticClass:"widget"},[r("router-link",{staticClass:"btn btn-primary reset-filter-btn",attrs:{to:t.$route.path}},[t._v("Reset All Filters")])],1):t._e(),t._v(" "),r("div",{staticClass:"widget"},[r("h3",{staticClass:"widget-title"},[r("a",{class:{collapsed:!t.priceSlideOpen},attrs:{href:"#"},on:{click:function(e){e.preventDefault(),t.priceSlideOpen=!t.priceSlideOpen}}},[t._v("Price")])]),t._v(" "),r("vue-slide-toggle",{staticClass:"show",attrs:{open:t.priceSlideOpen,duration:200}},[r("div",{staticClass:"widget-body"},[r("div",{staticClass:"price-slider-wrapper"},[t.loaded?r("vue-nouislider",{attrs:{config:t.priceSliderConfig,values:t.priceValues,id:"price-slider"}}):t._e()],1),t._v(" "),r("div",{staticClass:"filter-price-action d-flex align-items-center justify-content-between flex-wrap"},[r("div",{staticClass:"filter-price-text"},[t._v("\n\t\t\t\t\t\tPrice:\n\t\t\t\t\t\t"),r("span",{attrs:{id:"filter-price-range"}},[t._v(t._s(t.priceRangeText))])]),t._v(" "),r("router-link",{staticClass:"btn btn-primary",attrs:{to:t.setFilterRoute()}},[t._v("Filter")])],1)])])],1),t._v(" "),t._l(t.attributes,(function(e,i){return r("div",{key:"attr"+e.id,staticClass:"widget"},[r("h3",{staticClass:"widget-title"},[r("a",{class:{collapsed:!t.attributeSlideOpen[i]},attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.attrSlideChange(i)}}},[t._v(t._s(e.name))])]),t._v(" "),r("vue-slide-toggle",{staticClass:"show",attrs:{open:t.attributeSlideOpen[i],duration:200}},[r("div",{staticClass:"product-single-filter mb-0"},[r("div",{staticClass:"widget-body config-size-list"},[r("ul",{staticClass:"mb-0"},t._l(e.terms,(function(e){return r("li",{key:"term"+e.id,class:{active:t.setActiveTerm(e)}},[t.isColor(e.name)?r("router-link",{key:"is-color-1",staticClass:"filter-color border-0",style:"background-color: "+e.name,attrs:{to:t.setFilterRouteQuery(e)}}):r("router-link",{key:"not-color-1",attrs:{to:t.setFilterRouteQuery(e)}},[t._v(t._s(e.name))])],1)})),0)])])])],1)})),t._v(" "),"/shop/horizontal-filter1"!==t.$route.path?r("div",{staticClass:"widget widget-featured-products"},[r("h3",{staticClass:"widget-title"},[r("a",{class:{collapsed:!t.featuredSlideOpen},attrs:{href:"#"},on:{click:function(e){e.preventDefault(),t.featuredSlideOpen=!t.featuredSlideOpen}}},[t._v("Featured Products")])]),t._v(" "),r("vue-slide-toggle",{staticClass:"show",attrs:{open:t.featuredSlideOpen,duration:200}},[r("div",{staticClass:"widget-body"},t._l(t.featuredProducts.slice(0,3),(function(t){return r("product-two-component",{key:"sidebar-featured"+t.id,attrs:{product:t}})})),1)])],1):t._e()],2)}),[],!1,null,null,null);e.default=g.exports}}]);