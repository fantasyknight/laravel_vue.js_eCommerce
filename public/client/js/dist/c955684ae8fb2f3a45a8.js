(window.webpackJsonp=window.webpackJsonp||[]).push([[89],{41:function(t,n,o){"use strict";o.r(n);var i={props:{product:Object,quantity:{type:Number,default:1}},data:function(){return{qty:1}},watch:{product:function(){this.product.qty?this.qty=this.product.qty:this.qty=1}},created:function(){this.product.qty&&(this.qty=this.product.qty)},methods:{countUp:function(){this.product.manage_stock&&this.product.stock_quantity<=this.qty||this.product.sold_individually||(this.qty+=1,this.$emit("change-qty",this.product.id,this.qty,this.product.excerpts))},countDown:function(){1!=this.qty&&(this.qty-=1,this.$emit("change-qty",this.product.id,this.qty,this.product.excerpts))},changeQty:function(){this.$emit("change-qty",this.product.id,this.qty,this.product.excerpts)}}},u=o(1),s=Object(u.a)(i,(function(){var t=this,n=t.$createElement,o=t._self._c||n;return o("div",{staticClass:"product-single-qty"},[o("div",{staticClass:"input-group bootstrap-touchspin bootstrap-touchspin-injected"},[o("span",{staticClass:"input-group-btn input-group-prepend"},[o("button",{staticClass:"btn btn-outline btn-down-icon bootstrap-touchspin-down",attrs:{type:"button"},on:{click:function(n){return n.preventDefault(),t.countDown.apply(null,arguments)}}})]),t._v(" "),o("input",{directives:[{name:"model",rawName:"v-model.number",value:t.qty,expression:"qty",modifiers:{number:!0}}],staticClass:"horizontal-quantity form-control",attrs:{type:"number",max:t.product.manage_stock&&t.product.stock_quantity>0?t.product.stock_quantity:void 0},domProps:{value:t.qty},on:{input:[function(n){n.target.composing||(t.qty=t._n(n.target.value))},t.changeQty],blur:function(n){return t.$forceUpdate()}}}),t._v(" "),o("span",{staticClass:"input-group-btn input-group-append"},[o("button",{staticClass:"btn btn-outline btn-up-icon bootstrap-touchspin-up",attrs:{type:"button"},on:{click:function(n){return n.preventDefault(),t.countUp.apply(null,arguments)}}})])])])}),[],!1,null,null,null);n.default=s.exports}}]);