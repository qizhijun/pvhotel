//! flextime.js
!function(){function n(n,e,i){function t(u){return u=u||+new Date-o,u>=n&&(u=n),m=u/n,e(u,n,m),u>=n?void(i||a)():void(w=requestAnimationFrame(function(){t()}))}var o=+new Date,a=function(){},m=0,w=null;return t(0),{stop:function(){cancelRequestAnimationFrame(w)},play:t}}window.requestAnimationFrame=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(n){return setTimeout(n,1e3/60)},window.cancelRequestAnimationFrame=window.cancelRequestAnimationFrame||window.webkitCancelAnimationFrame||window.webkitCancelRequestAnimationFrame||window.mozCancelRequestAnimationFrame||window.oCancelRequestAnimationFrame||window.msCancelRequestAnimationFrame||clearTimeout,"function"==typeof define&&define.amd?define("flextime",[],function(){return n}):window.flextime=n}();