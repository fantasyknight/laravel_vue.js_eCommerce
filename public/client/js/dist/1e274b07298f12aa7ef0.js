(window.webpackJsonp=window.webpackJsonp||[]).push([[11,24],{180:function(t,e,r){var a=r(182);"string"==typeof a&&(a=[[t.i,a,""]]);var s={hmr:!0,transform:void 0,insertInto:void 0};r(56)(a,s);a.locals&&(t.exports=a.locals)},181:function(t,e,r){"use strict";r(180)},182:function(t,e,r){(t.exports=r(21)(!1)).push([t.i,".slide-appear-active {\n  transition: all 0.5s ease;\n}\n.slide-appear {\n  transform: translateY(10px);\n  opacity: 0;\n  visibility: hidden;\n}",""])},22:function(t,e,r){"use strict";r.r(e);function a(t){return function(t){if(Array.isArray(t))return s(t)}(t)||function(t){if("undefined"!=typeof Symbol&&null!=t[Symbol.iterator]||null!=t["@@iterator"])return Array.from(t)}(t)||function(t,e){if(!t)return;if("string"==typeof t)return s(t,e);var r=Object.prototype.toString.call(t).slice(8,-1);"Object"===r&&t.constructor&&(r=t.constructor.name);if("Map"===r||"Set"===r)return Array.from(t);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return s(t,e)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function s(t,e){(null==e||e>t.length)&&(e=t.length);for(var r=0,a=new Array(e);r<e;r++)a[r]=t[r];return a}var n={props:{categories:Array,showCategory:Number},data:function(){return{searchTerm:"",category:"*",suggestions:[],timeouts:[]}},mounted:function(){document.querySelector("body").addEventListener("click",this.closeSearchForm)},methods:{searchProducts:function(){var t=this;if(this.searchTerm.length>2){var e=this.searchTerm;this.timeouts.map((function(t){window.clearTimeout(t)})),this.timeouts.push(setTimeout((function(){window.axios.get("/web/products-search",{params:{search_term:e,category:t.category}}).then((function(e){t.suggestions=a(e.data.products)})).catch((function(t){}))}),500))}else this.timeouts.map((function(t){window.clearTimeout(t)})),this.suggestions=[]},matchEmphasize:function(t){var e=new RegExp(this.searchTerm,"i");return t.replace(e,(function(t){return"<strong>"+t+"</strong>"}))},goProductPage:function(){this.searchTerm="",this.suggestions=[],this.category="*"},searchToggle:function(t){document.querySelector(".header-search").classList.toggle("show"),t.stopPropagation()},showSearchForm:function(){document.querySelector(".header .header-search").classList.add("show")},closeSearchForm:function(t){document.querySelector(".header .header-search").classList.remove("show")}}},o=r(1),i=Object(o.a)(n,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"header-search"},[r("a",{staticClass:"search-toggle",attrs:{href:"#",role:"button"},on:{click:t.searchToggle}},[r("i",{staticClass:"icon-magnifier"})]),t._v(" "),r("form",{attrs:{action:"#",method:"get"},on:{click:function(e){return e.stopPropagation(),t.showSearchForm.apply(null,arguments)},submit:function(e){return e.preventDefault(),t.searchProducts.apply(null,arguments)}}},[r("div",{staticClass:"header-search-wrapper"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.searchTerm,expression:"searchTerm"}],staticClass:"form-control",attrs:{type:"text",autocomplete:"false",placeholder:"Search...",required:""},domProps:{value:t.searchTerm},on:{input:[function(e){e.target.composing||(t.searchTerm=e.target.value)},t.searchProducts]}}),t._v(" "),t.showCategory?r("div",{staticClass:"select-custom"},[r("select",{directives:[{name:"model",rawName:"v-model",value:t.category,expression:"category"}],attrs:{id:"cat",name:"cat"},on:{change:[function(e){var r=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.category=e.target.multiple?r:r[0]},t.searchProducts]}},[r("option",{attrs:{value:"*"}},[t._v("All Categories")]),t._v(" "),t._l(t.categories,(function(e){return r("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)]):t._e(),t._v(" "),r("button",{staticClass:"btn icon-search-3",attrs:{type:"submit"}}),t._v(" "),r("div",{staticClass:"live-search-list"},[t.suggestions.length>0?r("div",{staticClass:"autocomplete-suggestions",on:{click:t.goProductPage}},t._l(t.suggestions,(function(e){return r("router-link",{key:e.id,staticClass:"autocomplete-suggestion",attrs:{to:"/product/default/"+e.slug,"data-index":"0"}},[e.media.length>0?r("img",{directives:[{name:"lazy",rawName:"v-lazy",value:t.$root.getUrl(e.media[0].copy_link,!0,100),expression:"\n\t\t\t\t\t\t\t\t\t$root.getUrl(\n\t\t\t\t\t\t\t\t\t\tproduct.media[0].copy_link,\n\t\t\t\t\t\t\t\t\t\ttrue,\n\t\t\t\t\t\t\t\t\t\t100\n\t\t\t\t\t\t\t\t\t)\n\t\t\t\t\t\t\t\t"}],attrs:{alt:e.media[0].alt_text?e.media[0].alt_text:"product",width:"40",height:"40"}}):r("img",{attrs:{src:t.$root.getUrl("server/images/placeholder-img-100x100"),alt:"product",width:"40",height:"40"}}),t._v(" "),r("div",{staticClass:"search-name",domProps:{innerHTML:t._s(t.matchEmphasize(e.name))}}),t._v(" "),r("span",{staticClass:"search-price"},["simple"==e.type?[e.min_max_price[0]!=e.min_max_price[1]?r("del",{staticClass:"old-price"},[t._v("$"+t._s(e.min_max_price[0]))]):t._e(),t._v(" "),r("span",{staticClass:"product-price"},[t._v("$"+t._s(e.min_max_price[1]))])]:t._e(),t._v(" "),(e.type="variable")?[r("span",{staticClass:"product-price"},[t._v("$"+t._s(e.min_max_price[0]))]),t._v(" "),r("span",{staticClass:"product-price"},[t._v("- $"+t._s(e.min_max_price[1]))])]:t._e()],2)])})),1):t._e()])])])])}),[],!1,null,null,null);e.default=i.exports},24:function(t,e,r){"use strict";r.r(e);var a=r(3),s=r(22),n=r(10),o=r(9),i=r(5);function c(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);e&&(a=a.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,a)}return r}function l(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?c(Object(r),!0).forEach((function(e){u(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):c(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function u(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var d={components:{HeaderSearchTwoComponent:s.default,MainMenuComponent:n.default,StickyHeaderComponent:o.default,LoginModalComponent:i.default},props:{categories:Array},data:function(){return{topNoticeShow:!0}},computed:l(l(l({},Object(a.c)("user",["isCustomer"])),Object(a.c)("setting",["getHeaderSettings"])),{},{cartMenuComponent:function(){return this.getHeaderSettings.cartMenuType&&(t=this.getHeaderSettings.cartMenuType,function(){return r(130)("./".concat(t,".vue")).then((function(t){return t.default||t}))});var t},isIndex:function(){return"/"===this.$route.path}}),methods:{showLoginModal:function(){this.$modal.show(i.default,{},{width:"872",height:"auto",adaptive:!0})},showMobileMenu:function(){document.querySelector("body").classList.add("mmenu-active")}}},h=(r(181),r(1)),m=Object(h.a)(d,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[t.topNoticeShow?r("div",{staticClass:"top-notice text-white bg-dark"},[r("div",{staticClass:"container text-center"},[t._m(0),t._v(" "),r("button",{staticClass:"mfp-close",attrs:{title:"Close (Esc)",type:"button"},on:{click:function(e){e.preventDefault(),t.topNoticeShow=!t.topNoticeShow}}},[t._v("\n\t\t\t\t×\n\t\t\t")])])]):t._e(),t._v(" "),r("header",{staticClass:"header header-two",class:{"header-transparent":t.isIndex}},[r("sticky-header-component",[r("div",{staticClass:"header-middle sticky-header"},[r("transition",{attrs:{name:"slide"}},[r("div",{staticClass:"container"},[r("div",{staticClass:"header-left"},[r("a",{staticClass:"logo",attrs:{href:"index.html"}},[r("img",{attrs:{src:t.$root.getUrl(t.getHeaderSettings.logoImage),alt:t.getHeaderSettings.siteTitle+" Logo",width:t.getHeaderSettings.logoImageWidth,height:t.getHeaderSettings.logoImageHeight}})]),t._v(" "),r("main-menu-component",{staticClass:"font2",attrs:{"is-short":!0,"align-stretch":!1}})],1),t._v(" "),r("div",{staticClass:"header-right"},[r("button",{staticClass:"mobile-menu-toggler mr-4",class:t.getHeaderSettings.mmenuTogglerStyle,attrs:{type:"button"},on:{click:t.showMobileMenu}},[r("i",{staticClass:"icon-menu"})]),t._v(" "),t.isCustomer?r("router-link",{staticClass:"header-icon login-link",class:t.getHeaderSettings.accountIconStyle,attrs:{to:"/pages/account"}},[r("i",{staticClass:"icon-user-2"})]):r("a",{staticClass:"header-icon login-link",class:t.getHeaderSettings.accountIconStyle,attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.showLoginModal.apply(null,arguments)}}},[r("i",{staticClass:"icon-user-2"})]),t._v(" "),r("router-link",{staticClass:"header-icon",attrs:{to:"/pages/wishlist"}},[r("i",{staticClass:"icon-wishlist-2"})]),t._v(" "),r("header-search-two-component",{staticClass:"header-search-popup header-search-category d-none d-sm-block",class:t.getHeaderSettings.searchFormStyle,attrs:{categories:t.categories,"show-category":t.getHeaderSettings.searchFormCategory}}),t._v(" "),r("transition",{attrs:{name:"fade",mode:"out-in"}},[r("keep-alive",[r(t.cartMenuComponent,{tag:"component"})],1)],1)],1)])])],1)])],1)])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("h5",{staticClass:"ls-n-10 mb-0"},[this._v("\n\t\t\t\tGet 10% extra OFF on Porto Summer Sale - Use\n\t\t\t\t"),e("b",[this._v("PORTOSUMMER")]),this._v(" coupon -\n\t\t\t\t"),e("a",{attrs:{href:"category.html"}},[this._v("Shop Now!")])])}],!1,null,null,null);e.default=m.exports}}]);