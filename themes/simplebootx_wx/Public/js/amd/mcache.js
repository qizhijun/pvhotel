//! mcahce.js
!function(e,t){function n(){return this.init.apply(this,arguments)}var r=":",i={},o=[],c={length:0,setItem:function(e,t){i[e]=t,-1==o.indexOf(e)&&o.push(e),this.length=o.length},getItem:function(e){return i[e]},removeItem:function(e,n){n=o.indexOf(e),n>=0&&o.splice(n,1),i[e]=t,this.length=o.length},clear:function(){i={},queu=[]},key:function(e){return i[o[e]]}},u=function(){try{return window.localStorage._try=1,delete window.localStorage._try,window.localStorage}catch(e){return c}}();n.prototype={name:null,cache:null,init:function(e,t){this.name=e,this.cache=t},set:function(e,t){return this.cache.set([this.name,e].join(r),t)},get:function(e){return this.cache.get([this.name,e].join(r))},remove:function(e){return this.cache.remove([this.name,e].join(r))},clear:function(){var e=this.cache.store;if(e)for(var t,n,i=0,o=e.length;o>i;i++)t=e.key(i),n=t.split(r),n.length>1&&n[0]==this.name&&(this.cache.remove(t),i--,o--)}};var a={store:u,set:function(e,t){return u.setItem(e,JSON.stringify(t))},get:function(e){var t=u.getItem(e);return t?JSON.parse(t):t},list:function(e){return new n(e,a)},remove:function(e){return u?u.removeItem(e):t},clear:function(){return u?u.clear():t}},s={store:c,set:function(e,t){return c.setItem(e,JSON.stringify(t))},get:function(e){var t=c.getItem(e);return t?JSON.parse(t):t},list:function(e){return new n(e,s)},remove:function(e){return c?c.removeItem(e):t},clear:function(){return c?c.clear():t}},h={localCache:a,runtimeCache:s};"function"==typeof define&&define.amd&&define("mcache",[],function(){return h}),"undefined"!=typeof exports?("undefined"!=typeof module&&module.exports&&(exports=module.exports),exports=h):(this[e]=h,this.LocalCache=a,this.RuntimeCache=s)}.call(this,"mCache");