(window.webpackJsonp=window.webpackJsonp||[]).push([[28],{65:function(t,e,r){"use strict";r.r(e);var s=r(20),a={props:{user:Object},methods:{getLocation:function(t,e){var r=s.a.find((function(e){return e.id==t})),a={text:"Unknown"};return r?(a=s.c[t].find((function(t){return t.id==e})))||(a={text:"Unknown"}):r={text:"Unknown"},a.text+", "+r.text}}},n=r(1),i=Object(n.a)(a,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"store-header"},[t.user.vendor?r("div",{staticClass:"store-details"},[r("div",{staticClass:"seller-avatar"},[t.user.vendor.profile?r("img",{directives:[{name:"lazy",rawName:"v-lazy",value:t.$root.getUrl(t.user.vendor.profile.copy_link,!0,100),expression:"\n\t\t\t\t\t$root.getUrl(\n\t\t\t\t\t\tuser.vendor.profile.copy_link, true, 100\n\t\t\t\t\t)\n\t\t\t\t"}],attrs:{alt:"vendor",width:"100",height:"100"}}):r("img",{directives:[{name:"lazy",rawName:"v-lazy",value:t.$root.getUrl("server/images/placeholder-img-100x100.png"),expression:"\n\t\t\t\t\t$root.getUrl(\n\t\t\t\t\t\t'server/images/placeholder-img-100x100.png'\n\t\t\t\t\t)\n\t\t\t\t"}],attrs:{alt:"vendor",width:"100",height:"100"}})]),t._v(" "),r("div",{staticClass:"store-data"},[r("h1",{staticClass:"store-title"},[t._v(t._s(t.user.vendor.store_name))]),t._v(" "),r("ul",{staticClass:"store-info-list"},[r("li",[r("i",{staticClass:"fa fa-map-marker"}),t._v(" "),r("span",{staticClass:"store-address"},[t._v(t._s(t.getLocation(t.user.vendor.country,t.user.vendor.state)))])]),t._v(" "),r("li",[r("i",{staticClass:"fa fa-star"}),t._v("\n\t\t\t\t\t"+t._s(t.user.rating)+" rating from "+t._s(t.user.approved_reviews_count)+" review\n\t\t\t\t")])])])]):t._e()])}),[],!1,null,null,null);e.default=i.exports}}]);