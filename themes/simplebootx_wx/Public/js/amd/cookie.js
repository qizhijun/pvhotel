//! cookie 读写
!function(e,o){function n(e,n,i){if(i=i||{},n===o){var t=null;if(document.cookie&&""!=document.cookie)for(var r=document.cookie.split(";"),a=0;a<r.length;a++){var s=r[a].trim();if(s.substring(0,e.length+1)==e+"="){t=decodeURIComponent(s.substring(e.length+1));break}}return t}var u={path:"/",domain:arguments.callee.domain||location.host,expires:30,secure:!1};for(var p in u)i[p]===o&&(i[p]=u[p]);null===n&&(n="",i.expires=-1);var c="";if(i.expires&&("number"==typeof i.expires||i.expires.toUTCString)){var m;"number"==typeof i.expires?(m=new Date,m.setTime(m.getTime()+24*i.expires*60*60*1e3)):m=i.expires,c="expires="+m.toUTCString()}var s=[e+"="+encodeURIComponent(n)];c&&s.push(c),i.path&&s.push("path="+i.path),i.domain&&s.push("domain="+i.domain),i.secure&&s.push("secure"),document.cookie=s.join("; ")}n.domain=location.host,"function"==typeof define&&define.amd?define("cookie",[],function(){return n}):window.cookie=n}();