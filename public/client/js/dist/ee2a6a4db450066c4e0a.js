(window.webpackJsonp=window.webpackJsonp||[]).push([[88],{57:function(e,t,n){"use strict";n.r(t);var s={props:{options:{type:Object,default:function(){return{offset:50,speed:300}}},bgImage:{type:String,required:!0}},mounted:function(){window.addEventListener("scroll",this.scrollHandler,{passive:!0})},destroyed:function(){window.removeEventListener("scroll",this.scrollHandler)},methods:{scrollHandler:function(){var e=this.$el,t=(e.offsetTop-window.pageYOffset)*this.options.speed/e.offsetTop+this.options.offset;e.style.backgroundPositionY=t+"%"}}},o=n(1),i=Object(o.a)(s,(function(){var e=this.$createElement;return(this._self._c||e)("section",{directives:[{name:"lazy",rawName:"v-lazy:background-image",value:this.bgImage,expression:"bgImage",arg:"background-image"}]},[this._t("default")],2)}),[],!1,null,null,null);t.default=i.exports}}]);