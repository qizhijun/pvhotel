/*
 AngularJS v1.3.9-local+sha.a3c3bf3
 (c) 2010-2014 Google, Inc. http://angularjs.org
 License: MIT
*/
(function (p, d, C) {
    'use strict'; function v(r, h, g) {
        return {
            restrict: "ECA", terminal: !0, priority: 400, transclude: "element", link: function (a, c, b, f, y) {
                function z() { k && (g.cancel(k), k = null); l && (l.$destroy(), l = null); m && (k = g.leave(m), k.then(function () { k = null }), m = null) } function x() {
                    var b = r.current && r.current.locals; if (d.isDefined(b && b.$template)) {
                        var b = a.$new(), f = r.current; m = y(b, function (b) { g.enter(b, null, m || c).then(function () { !d.isDefined(t) || t && !a.$eval(t) || h() }); z() }); l = f.scope = b; l.$emit("$viewContentLoaded");
                        l.$eval(w)
                    } else z()
                } var l, m, k, t = b.autoscroll, w = b.onload || ""; a.$on("$routeChangeSuccess", x); x()
            }
        }
    } function A(d, h, g) { return { restrict: "ECA", priority: -400, link: function (a, c) { var b = g.current, f = b.locals; c.html(f.$template); var y = d(c.contents()); b.controller && (f.$scope = a, f = h(b.controller, f), b.controllerAs && (a[b.controllerAs] = f), c.data("$ngControllerController", f), c.children().data("$ngControllerController", f)); y(a) } } } p = d.module("ngRoute", ["ng"]).provider("$route", function () {
        function r(a, c) {
            return d.extend(Object.create(a),
            c)
        } function h(a, d) { var b = d.caseInsensitiveMatch, f = { originalPath: a, regexp: a }, g = f.keys = []; a = a.replace(/([().])/g, "\\$1").replace(/(\/)?:(\w+)([\?\*])?/g, function (a, d, b, c) { a = "?" === c ? c : null; c = "*" === c ? c : null; g.push({ name: b, optional: !!a }); d = d || ""; return "" + (a ? "" : d) + "(?:" + (a ? d : "") + (c && "(.+?)" || "([^/]+)") + (a || "") + ")" + (a || "") }).replace(/([\/$\*])/g, "\\$1"); f.regexp = new RegExp("^" + a + "$", b ? "i" : ""); return f } var g = {}; this.when = function (a, c) {
            var b = d.copy(c); d.isUndefined(b.reloadOnSearch) && (b.reloadOnSearch = !0);
            d.isUndefined(b.caseInsensitiveMatch) && (b.caseInsensitiveMatch = this.caseInsensitiveMatch); g[a] = d.extend(b, a && h(a, b)); if (a) { var f = "/" == a[a.length - 1] ? a.substr(0, a.length - 1) : a + "/"; g[f] = d.extend({ redirectTo: a }, h(f, b)) } return this
        }; this.caseInsensitiveMatch = !1; this.otherwise = function (a) { "string" === typeof a && (a = { redirectTo: a }); this.when(null, a); return this }; this.$get = ["$rootScope", "$location", "$routeParams", "$q", "$injector", "$templateRequest", "$sce", function (a, c, b, f, h, p, x) {
            function l(b) {
                var e = s.current;
                (v = (n = k()) && e && n.$$route === e.$$route && d.equals(n.pathParams, e.pathParams) && !n.reloadOnSearch && !w) || !e && !n || a.$broadcast("$routeChangeStart", n, e).defaultPrevented && b && b.preventDefault()
            } function m() {
                var u = s.current, e = n; if (v) u.params = e.params, d.copy(u.params, b), a.$broadcast("$routeUpdate", u); else if (e || u) w = !1, (s.current = e) && e.redirectTo && (d.isString(e.redirectTo) ? c.path(t(e.redirectTo, e.params)).search(e.params).replace() : c.url(e.redirectTo(e.pathParams, c.path(), c.search())).replace()), f.when(e).then(function () {
                    if (e) {
                        var a =
                        d.extend({}, e.resolve), b, c; d.forEach(a, function (b, e) { a[e] = d.isString(b) ? h.get(b) : h.invoke(b, null, null, e) }); d.isDefined(b = e.template) ? d.isFunction(b) && (b = b(e.params)) : d.isDefined(c = e.templateUrl) && (d.isFunction(c) && (c = c(e.params)), c = x.getTrustedResourceUrl(c), d.isDefined(c) && (e.loadedTemplateUrl = c, b = p(c))); d.isDefined(b) && (a.$template = b); return f.all(a)
                    }
                }).then(function (c) { e == s.current && (e && (e.locals = c, d.copy(e.params, b)), a.$broadcast("$routeChangeSuccess", e, u)) }, function (b) {
                    e == s.current && a.$broadcast("$routeChangeError",
                    e, u, b)
                })
            } function k() { var a, b; d.forEach(g, function (f, g) { var q; if (q = !b) { var h = c.path(); q = f.keys; var l = {}; if (f.regexp) if (h = f.regexp.exec(h)) { for (var k = 1, m = h.length; k < m; ++k) { var n = q[k - 1], p = h[k]; n && p && (l[n.name] = p) } q = l } else q = null; else q = null; q = a = q } q && (b = r(f, { params: d.extend({}, c.search(), a), pathParams: a }), b.$$route = f) }); return b || g[null] && r(g[null], { params: {}, pathParams: {} }) } function t(a, b) {
                var c = []; d.forEach((a || "").split(":"), function (a, d) {
                    if (0 === d) c.push(a); else {
                        var f = a.match(/(\w+)(?:[?*])?(.*)/),
                        g = f[1]; c.push(b[g]); c.push(f[2] || ""); delete b[g]
                    }
                }); return c.join("")
            } var w = !1, n, v, s = { routes: g, reload: function () { w = !0; a.$evalAsync(function () { l(); m() }) }, updateParams: function (a) { if (this.current && this.current.$$route) { var b = {}, f = this; d.forEach(Object.keys(a), function (c) { f.current.pathParams[c] || (b[c] = a[c]) }); a = d.extend({}, this.current.params, a); c.path(t(this.current.$$route.originalPath, a)); c.search(d.extend({}, c.search(), b)) } else throw B("norout"); } }; a.$on("$locationChangeStart", l); a.$on("$locationChangeSuccess",
            m); return s
        }]
    }); var B = d.$$minErr("ngRoute"); p.provider("$routeParams", function () { this.$get = function () { return {} } }); p.directive("ngView", v); p.directive("ngView", A); v.$inject = ["$route", "$anchorScroll", "$animate"]; A.$inject = ["$compile", "$controller", "$route"]
})(window, window.angular);
//# sourceMappingURL=angular-route.min.js.map
/*
 AngularJS v1.3.9
 (c) 2010-2014 Google, Inc. http://angularjs.org
 License: MIT
*/
(function (p, f, n) {
    'use strict'; f.module("ngCookies", ["ng"]).factory("$cookies", ["$rootScope", "$browser", function (e, b) { var c = {}, g = {}, h, k = !1, l = f.copy, m = f.isUndefined; b.addPollFn(function () { var a = b.cookies(); h != a && (h = a, l(a, g), l(a, c), k && e.$apply()) })(); k = !0; e.$watch(function () { var a, d, e; for (a in g) m(c[a]) && b.cookies(a, n); for (a in c) d = c[a], f.isString(d) || (d = "" + d, c[a] = d), d !== g[a] && (b.cookies(a, d), e = !0); if (e) for (a in d = b.cookies(), c) c[a] !== d[a] && (m(d[a]) ? delete c[a] : c[a] = d[a]) }); return c }]).factory("$cookieStore",
    ["$cookies", function (e) { return { get: function (b) { return (b = e[b]) ? f.fromJson(b) : b }, put: function (b, c) { e[b] = f.toJson(c) }, remove: function (b) { delete e[b] } } }])
})(window, window.angular);
//# sourceMappingURL=angular-cookies.min.js.map
var mod; mod = angular.module("infinite-scroll", []); mod.directive("infiniteScroll", ["$rootScope", "$window", "$timeout", function ($rootScope, $window, $timeout) { return { link: function (scope, iElement, iAttrs, controller) { var checkWhenEnabled, handler, scrollDistance, scrollEnabled; $window = angular.element($window); scrollDistance = 0; if (iAttrs.infiniteScrollDistance != null) { scope.$watch(iAttrs.infiniteScrollDistance, function (value) { return scrollDistance = parseInt(value, 10) }) } scrollEnabled = true; checkWhenEnabled = false; if (iAttrs.infiniteScrollDisabled != null) { scope.$watch(iAttrs.infiniteScrollDisabled, function (value) { scrollEnabled = !value; if (scrollEnabled && checkWhenEnabled) { checkWhenEnabled = false; return handler() } }) } handler = function () { var elementBottom, remaining, shouldScroll, windowBottom; windowBottom = $(window).height() + $(window).scrollTop(); elementBottom = $(iElement)[0][0].offsetTop + $(iElement)[0][0].offsetHeight; remaining = elementBottom - windowBottom; shouldScroll = remaining <= $(window).height() * scrollDistance; if (shouldScroll && scrollEnabled) { if ($rootScope.$$phase) { return scope.$eval(iAttrs.infiniteScroll) } else { return scope.$apply(iAttrs.infiniteScroll) } } else { if (shouldScroll) { return checkWhenEnabled = true } } }; $window.on("scroll", handler); scope.$on("$destroy", function () { return $window.off("scroll", handler) }); return $timeout((function () { if (iAttrs.infiniteScrollImmediateCheck) { if (scope.$eval(iAttrs.infiniteScrollImmediateCheck)) { return handler() } } else { return handler() } }), 0) } } }]);