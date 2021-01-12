var fromgroup = 0;
(function () {
    /**
   * 动态加载js文件
   * @param  {string}   url      js文件的url地址
   * @param  {Function} callback 加载完成后的回调函数
   */
    var _getScript = function (url, callback) {
        var head = document.getElementsByTagName('head')[0],
           js = document.createElement('script');
        js.setAttribute('type', 'text/javascript');
        js.setAttribute('src', url);
        head.appendChild(js);
        //执行回调
        var callbackFn = function () {
            if (typeof callback === 'function') {
                callback();
            }
        };
        if (document.all) { //IE
            js.onreadystatechange = function () {
                if (js.readyState == 'loaded' || js.readyState == 'complete') {
                    callbackFn();
                }
            }
        } else {
            js.onload = function () {
                callbackFn();
            }
        }
    }
    //如果使用的是zepto，就添加扩展函数
    if (Zepto) {
        $.getScript = _getScript;
    }
})();


; (function ($) {
    $.extend($.fn, {
        cookie: function (key, value, options) {
            var days, time, result, decode

            // A key and value were given. Set cookie.
            if (arguments.length > 1 && String(value) !== "[object Object]") {
                // Enforce object
                options = $.extend({}, options)

                if (value === null || value === undefined) options.expires = -1

                if (typeof options.expires === 'number') {
                    days = (options.expires * 24 * 60 * 60 * 1000)
                    time = options.expires = new Date()

                    time.setTime(time.getTime() + days)
                }

                value = String(value)

                return (document.cookie = [
                    encodeURIComponent(key), '=',
                    options.raw ? value : encodeURIComponent(value),
                    options.expires ? '; expires=' + options.expires.toUTCString() : '',
                    options.path ? '; path=' + options.path : '',
                    options.domain ? '; domain=' + options.domain : '',
                    options.secure ? '; secure' : ''
                ].join(''))
            }

            // Key and possibly options given, get cookie
            options = value || {}

            decode = options.raw ? function (s) { return s } : decodeURIComponent

            return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null
        }

    })
})(Zepto)


window.onresize = function () {
    $("#date_list").css("height", $(window).height() - 72);
}


//定义全局模块
var HotelmApp = angular.module('HotelmApp', ['ngRoute', 'infinite-scroll', 'ngCookies', 'oc.lazyLoad']); //后添加, 'oc.lazyLoad'

//用于在页面中绑定原生html代码
HotelmApp.filter('trustHtml', function ($sce) {
    return function (input) {
        return $sce.trustAsHtml(input);
    }
});



HotelmApp.directive('onFinishRenderFilters', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    };
});

//单日期指令
HotelmApp.directive('commonSingleDate', function () {
    return {
        restrict: 'EA',
        scope: {
            date: '@'
        },
        templateUrl: '/webapp/views/default/directive/singledate.html',
        link: function (scope, element, attrs) {
            var c = new Calendar(function (day1) {
                scope.Sdate = day1.date;
                scope.Sweek = day1.week;
                scope.InitDate();
            });
            c.fDrawCal.fullHouseClick = function (date) {
                try {
                    //满房计算
                    var i = 0
                    for (i; i < c.fullDate.length; i++) {
                        if (date == c.fullDate[i]) {
                            $("#maxOptional").remove();
                            $("#wwei_dialog_p").remove();
                            $("#dateInclude").remove();
                            $("#fullHouseClick").remove();
                            $("body").append('<p id="fullHouseClick" style="width:40%;height:100px;text-align:center;position: fixed;bottom:10%;left:30%;z-index: 99999;background:rgba(0,0,0,0.6);color:#ffffff;border-radius: 5px;word-break:break-all;"><span style="display: block;margin-top: 30px;">不可以预定，请重新选择！</span></p>');

                            setTimeout(function () {
                                temps = true;
                                $("#fullHouseClick").remove();
                            }, 2000);

                            return false;
                        }
                    }
                } catch (e) {
                    return;
                }
            }
            c.fDrawCal.onSelect = function (ev) {
                var el = ev.currentTarget;
                var date = $(el).attr('date-data');
                if (date != undefined) {
                    var d_Date = new Date();
                    var minsec;
                    if (date) {
                        minsec = Date.parse(date.replace("-", "/").replace("-", "/")) - Date.parse(d_Date);
                    }
                    if (c.fullDate) {
                        if (c.fDrawCal.fullHouseClick(date) == false) {
                            return;
                        }
                    }
                    var _Count = minsec / 1000 / 60 / 60 / 24; //factor: second / minute / hour / day
                    if (_Count < -1)
                        return;
                    else {
                        c.fDrawCal.showDays(date);
                    }
                } else
                    return;
            }

            c.fDrawCal.showDays = function (date) {
                var e = c;
                $(".calendar_select_first").html(parseInt($(".calendar_select_first").html()));
                $(".calendar_select_second").html(parseInt($(".calendar_select_second").html()));
                $(".calendar_day").removeClass("calendar_select").removeClass("calendar_select_first").removeClass("calendar_select_second").removeClass("bg").removeClass("color");
                var strDate = e.getDateString(new Date(date));
                $('#calendar_cell_' + strDate).addClass("calendar_select").addClass("bg").addClass("color");


            }

            c.fDrawCal.onOK = function () {
                var orderday = $('.calendar_select');
                var e = c;
                e.fDrawCal.closeDialog(0);
                var date = orderday.attr('date-data');
                var day1 = {
                    dateStr: e.getDateStringChin(date),
                    week: e.getWeekDayString(date),
                    date: e.getDateString(date)
                };
                scope.Sdate = day1.date;
                scope.Sweek = day1.week;
                scope.InitDate();
            }

            c.fDrawCal.showDialog = function () {
                var e = c;
                e.fDrawCal.showDays(scope.Sdate);
                $('#yd_date').show();
                $("#date_list").css("height", $(window).height() - 72);
                if (e.fullDate) {
                    for (var i = 0; i < e.fullDate.length; i++) {
                        var ele = $("#calendar_cell_" + e.fullDate[i]);
                        if (ele.find("span").length == 0)
                            ele.append("<span style='display:block;line-height:18px;color:red;'>不可订</span>").css("line-height", "18px");
                    }
                }
            }


            //页面时间格式化显示
            scope.InitDate = function () {
                $("#book_date_val").val(scope.Sdate);
                $("#book_date_show").html(new Date(scope.Sdate).format('yyyy年MM月dd日') + " (" + scope.Sweek + ")");
            };


            $("#div_date").on("click", function () {
                c.fDrawCal.showDialog();
            })
            scope.$watch('date', function (newVal) {
                if (attrs.date) {
                    scope.Sdate = attrs.date;
                    scope.Sweek = c.getWeekDayString(attrs.date);
                    var fullDate = new Array();
                    fullDate.push(new Date().format('yyyy-MM-dd'));
                    c.fDrawCal.setFullDate(fullDate);
                }
                else {
                    var _dd = new Date();
                    scope.Sdate = _dd.format('yyyy-MM-dd');
                    scope.Sweek = c.getWeekDayString(_dd);
                }
                c.init(scope.Sdate);
                scope.InitDate();
            });
        }
    }
})

//通用评论列表
HotelmApp.directive('commonCommentList', function () {
    return {
        restrict: 'E',
        //scope: {
        //    cmlist: '@'
        //},
        scope: true,
        templateUrl: '/webapp/views/default/directive/commentlist.html',
        link: function (scope, element, attrs) {
            scope.currentlist = [];
            scope.displaylist = [];
            //$("#commentlist_tab").hide();
            scope.$watch('cmlist', function (newVal) {
                if (scope.cmlist) {
                    //if (scope.cmlist.length > 0)
                    //{
                    $("#commentlist_tab").show();
                    //}
                    scope.orignlist = scope.cmlist;
                    scope.currentlist = scope.orignlist.concat();
                    scope.all_count = scope.currentlist.length;
                    scope.setCommentList(1);
                    scope.goodlist = scope.orignlist.filter(function (e) { return e.star > 3 });
                    scope.good_count = scope.goodlist.length;
                    scope.middlelist = scope.orignlist.filter(function (e) { return e.star > 1 && e.star < 4 });
                    scope.middle_count = scope.middlelist.length;
                    scope.badlist = scope.orignlist.filter(function (e) { return e.star < 2 });
                    scope.bad_count = scope.badlist.length;
                }
                else {
                    scope.all_count = 0;
                    scope.good_count = 0;
                    scope.middle_count = 0;
                    scope.bad_count = 0;
                }
            });

            scope.setCommentList = function (v) {
                if (v == 1) scope.displaylist = [];
                scope.displaylist = scope.displaylist.concat(scope.currentlist.splice(0, 2));
                scope.hasMoreComment = scope.currentlist.length > 0 ? true : false;
            }
            scope.tabComment = function (v) {
                $("#commentlist_tab li").removeClass("commentSelectTab").removeClass("color_blue1");
                var ele = $("#commentlist_tab li").eq(v - 1);
                ele.addClass("commentSelectTab").addClass("color_blue1");
                switch (v) {
                    case 1:
                        scope.currentlist = scope.orignlist.concat();
                        break;
                    case 2:
                        scope.currentlist = scope.goodlist.concat();
                        break;
                    case 3:
                        scope.currentlist = scope.middlelist.concat();
                        break;
                    case 4:
                        scope.currentlist = scope.badlist.concat();
                        break;
                }
                scope.setCommentList(1);
            }
        }
    }
})

HotelmApp.directive('lazySrc', ['$window', '$document', function ($window, $document) {
    var doc = $document[0],
        body = doc.body,
        win = $window,
        $win = angular.element(win),
        uid = 0,
        elements = {};

    function getUid(el) {
        return el.__uid || (el.__uid = '' + ++uid);
    }

    function getWindowOffset() {
        var t,
            pageXOffset = (typeof win.pageXOffset == 'number') ? win.pageXOffset : (((t = doc.documentElement) || (t = body.parentNode)) && typeof t.ScrollLeft == 'number' ? t : body).ScrollLeft,
            pageYOffset = (typeof win.pageYOffset == 'number') ? win.pageYOffset : (((t = doc.documentElement) || (t = body.parentNode)) && typeof t.ScrollTop == 'number' ? t : body).ScrollTop;
        return {
            offsetX: pageXOffset,
            offsetY: pageYOffset
        };
    }

    function isVisible(iElement) {
        var elem = iElement[0],
            elemRect = elem.getBoundingClientRect(),
            windowOffset = getWindowOffset(),
            winOffsetX = windowOffset.offsetX,
            winOffsetY = windowOffset.offsetY,
            elemWidth = elemRect.width,
            elemHeight = elemRect.height,
            elemOffsetX = elemRect.left + winOffsetX,
            elemOffsetY = elemRect.top + winOffsetY,
            viewWidth = Math.max(doc.documentElement.clientWidth, win.innerWidth || 0),
            viewHeight = Math.max(doc.documentElement.clientHeight, win.innerHeight || 0),
            xVisible,
            yVisible;

        if (elemOffsetY <= winOffsetY) {
            if (elemOffsetY + elemHeight >= winOffsetY) {
                yVisible = true;
            }
        } else if (elemOffsetY >= winOffsetY) {
            if (elemOffsetY <= winOffsetY + viewHeight) {
                yVisible = true;
            }
        }

        if (elemOffsetX <= winOffsetX) {
            if (elemOffsetX + elemWidth >= winOffsetX) {
                xVisible = true;
            }
        } else if (elemOffsetX >= winOffsetX) {
            if (elemOffsetX <= winOffsetX + viewWidth) {
                xVisible = true;
            }
        }

        return xVisible && yVisible;
    };

    function checkImage() {
        Object.keys(elements).forEach(function (key) {
            var obj = elements[key],
                iElement = obj.iElement,
                $scope = obj.$scope;
            if (isVisible(iElement)) {
                iElement.attr('src', $scope.lazySrc);
            }
        });
    }

    $win.bind('scroll', checkImage);
    $win.bind('resize', checkImage);

    function onLoad() {
        var $el = angular.element(this),
            uid = getUid($el);

        $el.css('opacity', 1);

        if (elements.hasOwnProperty(uid)) {
            delete elements[uid];
        }
    }

    return {
        restrict: 'A',
        scope: {
            lazySrc: '@'
        },
        link: function ($scope, iElement) {

            iElement.bind('load', onLoad);

            $scope.$watch('lazySrc', function () {
                if (isVisible(iElement)) {
                    iElement.attr('src', $scope.lazySrc);
                } else {
                    var uid = getUid(iElement);
                    iElement.css({
                        'opacity': 0,
                        '-webkit-transition': 'opacity 1s',
                        'transition': 'opacity 1s'
                    });
                    elements[uid] = {
                        iElement: iElement,
                        $scope: $scope
                    };
                }
            });

            $scope.$on('$destroy', function () {
                iElement.unbind('load');
            });
        }
    };
}]);


//定制和非定制两种路径结构
var viewLocationFormats = ["/{4}{0}/{1}/{2}/{3}", "/{4}{0}/{1}/{3}"];

//路由控制器
HotelmApp.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
    .when('/', {
        templateUrl: "/webapp/views/error.html",
        controller: 'ErrorController'
    })
    .when('/:hid/:dir?/:file?', {
        templateUrl: function ($routeParams) {
            var _hid = parseInt($routeParams.hid);
            //if (parseInt($routeParams.fromgroup) > 0)

            fromgroup = isNaN(parseInt($routeParams.fromgroup)) ? 0 : parseInt($routeParams.fromgroup);

            var tempopenid = zhiding_getCookieValue("wxopenid/" + (fromgroup > 0 ? fromgroup : _hid));
            var firstOpenid = zhiding_getCookieValue("wxfirstopenid/" + (fromgroup > 0 ? fromgroup : _hid));
            var ua = window.navigator.userAgent.toLowerCase();
            if (ua.match(/MicroMessenger/i) == "micromessenger" && ($routeParams.openid == '' || $routeParams.openid == undefined) && !firstOpenid) {
                //console.log(fromgroup,"强授权");
                //alert(fromgroup, _hid);
                if (tempopenid == "undefined" || tempopenid == "" || tempopenid == undefined) {
                    var login_cookie_info = zhiding_getCookieValue("uinfo_" + fromgroup > 0 ? fromgroup : _hid);
                    var cid = 0, cguid = "";
                    if (login_cookie_info) {
                        var cookie_val_arr = login_cookie_info.split("&");
                        for (var i = 0; i < cookie_val_arr.length; i++) {
                            var kv = cookie_val_arr[i].split('=');
                            if (kv[0] == "cid")
                                cid = decodeURIComponent(kv[1]);
                            if (kv[0] == "cguid")
                                cguid = decodeURIComponent(kv[1]);
                        }
                    }
                    cid = isNaN(parseInt(cid)) ? 0 : cid;
                    var url = "http://hotelm.zhiding365.com/api/v1/AccountSecurity/WeiXinAuth?url=" + encodeURIComponent(window.location.href) + "&hid=" + (fromgroup > 0 ? fromgroup : _hid) + "&cid=" + cid + "&cguid=" + cguid;
                    window.location.href = url;

                }
            }
            else if (fromgroup > 0) {
                var login_cookie_info = zhiding_getCookieValue("uinfo_" + fromgroup);

                if (login_cookie_info) {
                    var cookie_val_arr = login_cookie_info.split("&");
                    for (var i = 0; i < cookie_val_arr.length; i++) {
                        var kv = cookie_val_arr[i].split('=');
                        loginInfo[kv[0]] = decodeURIComponent(kv[1]);
                    }
                }

                var unlogincookie = zhiding_getCookieValue("unlogin_" + fromgroup);
                if (unlogincookie) {

                    var cookie_val_arr = unlogincookie.split("&");
                    for (var i = 0; i < cookie_val_arr.length; i++) {
                        var kv = cookie_val_arr[i].split('=');
                        unlogin[kv[0]] = decodeURIComponent(kv[1]);
                    }
                }
            }
            var viewLocations = [];//本次请求可能对应的定制和非定制页面路径

            var _dir = $routeParams.dir || 'home';
            var _file = $routeParams.file || 'index';
            //var _themeid = hotel_basic_info.themeid;//麻屏蔽
            var _themeid = $routeParams.themename ? $routeParams.themename : hotel_basic_info.themeid;//麻改
            var _templateid = hotel_basic_info.templateid;
            var _group = (_hid >= 10000 && _hid <= 20000) ? 'group/' : '';
            fromgroup = (_hid >= 10000 && _hid <= 20000) ? 0 : fromgroup;
            //console.log(hotel_basic_info);
            if (_hid != hotel_basic_info.hid || fromgroup > 0) {
                //if (hotel_basic_info.hasWebsite == 0)
                //hotel_basic_info.fromgroup = hotel_basic_info.groupid;
                hotel_basic_info.fromgroup = fromgroup;
            }
            else if (hotel_basic_info.groupid == 0)
                hotel_basic_info.fromgroup = 0;
            var arrlenth = viewLocationFormats.length;
            if (_dir == 'home' && _file == 'index') {//处理首页模板
                for (var i = 0; i < arrlenth; i++) {
                    viewLocations.push(viewLocationFormats[i].format(_dir, _themeid, _hid, _file, _group));
                }
            } else {//处理二三级模板
                for (var i = 0; i < arrlenth; i++) {
                    viewLocations.push(viewLocationFormats[i].format(_templateid, _dir, _hid, _file, _group));
                }
                if (_templateid != 'default')//酒店二级模板非default，但是此模板文件夹中不存在要访问的文件时，还返回default模板中对应文件
                {
                    for (var i = 0; i < arrlenth; i++) {
                        viewLocations.push(viewLocationFormats[i].format("default", _dir, _hid, _file, _group));
                    }
                }
            }
            for (var i = 0; i < viewLocations.length - 1; i++) {
                if (allfiles.indexOf(viewLocations[i]) > -1)//所有定制路径集合数组中是否存在请求对应的可能定制页面
                {
                    return '/webapp/views' + viewLocations[i] + '.html?v=11.11';
                }
            }

            //返回默认页面
            return '/webapp/views' + viewLocations[viewLocations.length - 1] + '.html?v=11.11';
        },
        resolve: {
            delay: ['$q', '$route', '$rootScope', '$location', '$ocLazyLoad', function ($q, $route, $rootScope, $location, $ocLazyLoad) {//'$ocLazyLoad',$ocLazyLoad后添加
                var delay = $q.defer();
                (function () {
                    var _params = $route.current.params;
                    var _hid = _params.hid;
                    var _dir = _params.dir || 'home';
                    var _file = _params.file || 'index';
                    var _group = (_hid >= 10000 && _hid <= 20000) ? 'group/' : '';
                    var _group1 = _group ? 'group' : '';
                    var _filename = '/webapp/script/controllers/{0}{1}/{2}.js?v=11.11'.format(_group, _dir, _file);
                    var _controllername = '{0}{1}{2}Controller'.format(zhiding_changeCase(_group1), zhiding_changeCase(_dir), zhiding_changeCase(_file));////后添加
                    // var _controllername = '{0}Controller'.format(zhiding_changeCase(_file));////后屏蔽
                    $ocLazyLoad.load(_filename).then(function () {
                        $route.current.controller = eval(_controllername);
                        delay.resolve();
                    });
                    //$.getScript(_filename, function () {//后屏蔽
                    //    $route.current.controller = eval(_controllername);
                    //    delay.resolve();
                    //});
                })();
                return delay.promise;
            }]
        }
    })
    .otherwise({
        redirectTo: '/'
    });
}])
//登陆验证
HotelmApp.run(['$rootScope', '$http', '$location', '$routeParams', function ($rootScope, $http, $location, $routeParams) {
    //首页第一次加载请求到的数据
    $rootScope.hotel_basic_info = hotel_basic_info;//酒店基本信息

    $rootScope.realpath_arr = allfiles;//所有定制路径集合数组

    $rootScope.loginInfo = loginInfo;
    $rootScope.unlogin = unlogin;
    var login_cookie_info = zhiding_getCookieValue("uinfo_" + GetHID());

    if (login_cookie_info) {
        var cookie_val_arr = login_cookie_info.split("&");
        for (var i = 0; i < cookie_val_arr.length; i++) {
            var kv = cookie_val_arr[i].split('=');
            $rootScope.loginInfo[kv[0]] = decodeURIComponent(kv[1]);
        }
    }

    var unlogincookie = zhiding_getCookieValue("unlogin_" + GetHID());
    if (unlogincookie) {

        var cookie_val_arr = unlogincookie.split("&");
        for (var i = 0; i < cookie_val_arr.length; i++) {
            var kv = cookie_val_arr[i].split('=');
            $rootScope.unlogin[kv[0]] = decodeURIComponent(kv[1]);
        }
    }
    var loading_list = ['/room/index', '/restaurant/restaurant', '/meeting/index', '/sports/index', '/member/orderlist', '/member/index', '/restaurant/details', '/meeting/detail', '/sports/sportsdetail'];//是否加大loading
    var checkTo_list = ['/room/order'];
    var checkFrom_list = ['/room/book'];
    var confirmTo_list = ['room/index', 'room', 'room/', 'restaurant/restaurant', 'restaurant/details', 'sports/index', 'sports/', 'sports', 'meeting/index', 'meeting/', 'meeting'];//以下两个是判断填写订单页面返回事件
    var confirmFrom_list = ['room/book', 'restaurant/orderresbook', 'sports/sportsorder', 'meeting/order'];
    var confirmPayTo_list = ['room/book'];//以下两个判断支付返回，但已经被废弃（支付页面已被抽取出去）
    var confirmPayFrom_list = ['room/order'];
    var confirmbackTo_list = ['room/book', 'restaurant/orderresbook', 'sports/sportsorder', "meeting/order"];//订单详情页面返回成功页面，阻止该操作
    var confirmbackFrom_list = ['room/success', 'restaurant/ordersuccess', 'sports/sportssuccess', 'meeting/success'];
    $rootScope.$on('$locationChangeStart', function (event, newUrl, oldUrl) {
        var reg = /#\/(\d+)/ig;
        var regArr = reg.exec(newUrl);
        var _hid = (regArr != null && regArr.length > 1) ? regArr[1] : $rootScope.hotel_basic_info.hid;

        if ($rootScope.myflag && newUrl != oldUrl) {
            var re = /#\/(\d+)\/([^?]*)/ig;
            var regArr1 = re.exec(newUrl);
            var re1 = /#\/(\d+)\/([^?]*)/ig;
            var regArr2 = re1.exec(oldUrl);
            //regArr2[2]获取
            if ((regArr2 != null && regArr1 != null && regArr2.length > 1 && regArr2.length > 1) && ((confirmFrom_list.indexOf(regArr2[2]) > -1 && confirmTo_list.indexOf(regArr1[2]) > -1) || (confirmbackFrom_list.indexOf(regArr2[2]) > -1 && confirmbackTo_list.indexOf(regArr1[2]) > -1))) {
                event.preventDefault();
                if (confirmFrom_list.indexOf(regArr2[2]) > -1 && confirmTo_list.indexOf(regArr1[2]) > -1) {
                    if ($(".modal").length > 0) {
                        $(".modal").remove();
                    }
                    else {
                        $("#sexs").removeClass("blk").addClass("Nones");
                        $(".Bombbox").animate({ "margin-top": -1000 }, 200, function () { $(".mask").hide(); });
                        showMessageBox("您的订单未填写完成，是否确定要离开当前页面？", "离开", "取消", function () {
                            $rootScope.myflag = false;
                            history.go(-1);
                        }, function () { });
                    }
                }
                else {
                    setTimeout(function () { window.history.go(-2); }, 200);

                }
                return;
            }
            //if (confirmPayFrom_list.indexOf(regArr2[2]) > -1 && confirmPayTo_list.indexOf(regArr1[2]) > -1) {
            //    event.preventDefault();
            //    showMessageBox("您的支付尚未完成，是否取消支付？", "取消支付", "继续支付", function () {
            //        $rootScope.myflag = false;
            //        history.go(-1);
            //        //window.location.href = String(newUrl);

            //    }, function () { });
            //    return;
            //}

        }


        for (var i = 0; i < loading_list.length; i++) {
            if (newUrl.indexOf(loading_list[i]) > -1) {
                $(document).trigger("ajaxStart1");
                break;
            }
        }
        $("body").removeAttr("style");
        $("#div_footer_item").children().removeClass("curr");
        if (newUrl.indexOf("/room") > 0) {
            $("#div_footer_item").children().eq(0).addClass("curr");
        }
        else if (newUrl.indexOf("/restaurant") > 0) {
            $("#div_footer_item").children().eq(1).addClass("curr");
        } else if (newUrl.indexOf("/meeting") > 0) {
            $("#div_footer_item").children().eq(2).addClass("curr");
        } else if (newUrl.indexOf("/sports") > 0) {
            $("#div_footer_item").children().eq(3).addClass("curr");
        }
        else if (newUrl.indexOf("/member") > 0) {
            $("#div_footer_item").children().eq(4).addClass("curr");
        }
        if (!($rootScope.hotel_basic_info && $rootScope.hotel_basic_info.hid == _hid)) {
            window.location.reload(true);
            //window.location.href = "/#" + $location.url();

        }

        //if (!$rootScope.isconfirm)
        //{
        //    console.log(newUrl);
        //    $rootScope.isconfirm = true;
        //    event.preventDefault();
        //    return;
        //    var ret = confirm('Are you sure to give it up? ');
        //    if (ret) {
        //        window.location.href = newUrl;
        //        return;
        //    }

        //    return;
        //}

    })

    //换酒店刷新
    //$rootScope.$on('$routeChangeStart', function (evt, current, previous) {
    //    var _url = $location.url();

    //    for (var i = 0; i < loading_list.length; i++) {
    //        if (_url.indexOf(loading_list[i]) > -1) {
    //            $(document).trigger("ajaxStart1");
    //            break;
    //        }
    //    }
    //    $("body").removeAttr("style");




    //    if (!($rootScope.hotel_basic_info && $rootScope.hotel_basic_info.hid == current.params.hid)) {
    //        window.location.reload(true);
    //        //window.location.href = "/#" + $location.url();

    //    }
    //})

    var ignore_footer_list = ['/login/index', '/login/register', '/meeting/order', '/room/order', '/restaurant/orderresbook', '/sports/sportsorder', '/home/index', '/home/default/index', '/test/index', '/home/'];

    $rootScope.$on('$routeChangeSuccess', function (evt, current, previous) {
        $rootScope.hotel_basic_info.realhid = $rootScope.hotel_basic_info.fromgroup > 0 ? $rootScope.hotel_basic_info.fromgroup : $rootScope.hotel_basic_info.hid;
        $rootScope.myflag = true;
        $(document).trigger("ajaxStop1");

        var _url = String(current.loadedTemplateUrl);

        for (var i = 0; i < checkTo_list.length; i++) {
            if (_url.indexOf(checkTo_list[i]) > -1 && _url.indexOf('/room/orderdetail') < 0) {
                if (!previous || (previous && previous.loadedTemplateUrl.indexOf(checkFrom_list[i]) < 0)) {
                    alert("该页面已经失效！");
                    $rootScope.jump("/" + $routeParams.hid + "/member/orderlist?type=1");
                    break;
                }
            }
        }
        if (_url.indexOf("/home/") < 0) {
            $("#div_top_bar").show();
        }
        else {
            $("#div_top_bar").hide();
        }
        var is_footer_hide = false;
        for (var i = 0; i < ignore_footer_list.length; i++) {
            if (_url.indexOf(ignore_footer_list[i]) > -1) {
                $("#div_footer_item").hide();
                $("#p_copyright").hide();
                is_footer_hide = true;
                break;
            }
        }
        if (!is_footer_hide) {
            $("#div_footer_item").show();
            $("#p_copyright").show();
        }
        $(".maincontent").scrollTop(0);
        if ($(".mask").css("display") == "block") {
            $(".mask").hide();
        }
        $("#topnav").hide();
    })
    $rootScope.jump = function (url) {
        //var sUserAgent = navigator.userAgent.toLowerCase();
        //var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
        //if (!bIsIphoneOs)
        //    $location.url(url);
        //else {         
        window.location.href = "/#" + url;
        //}

    }
    $rootScope.go_url = function (_url) {
        //>= 10000 && hotel_basic_info.hid <= 20000)||hotel_basic_info.fromgroup
        ////去掉是为了无微官网客房预订，以此备注
        //if ($rootScope.hotel_basic_info.hasWebsite == 1 && $rootScope.hotel_basic_info.fromgroup == 0) {

        if (_url.indexOf("http://") > -1) {
            window.location.href = _url;
        }
        else {
            $rootScope.jump("/" + $rootScope.hotel_basic_info.hid + _url);
        }
        //} else {

        //    if ($rootScope.hotel_basic_info.fromgroup == 0)
        //        $rootScope.jump("/" + $rootScope.hotel_basic_info.groupid + _url);
        //    else {
        //        $rootScope.jump("/" + $rootScope.hotel_basic_info.fromgroup + _url);
        //    }
        //}
    }

    $rootScope.go_group = function () {
        if ($rootScope.hotel_basic_info.groupid > 0) {
            $rootScope.jump("/" + $rootScope.hotel_basic_info.groupid);
        }
        else {
            $rootScope.jump("/" + $rootScope.hotel_basic_info.hid);
        }

    }
    $rootScope.go_game = function () {
        window.location.href = "http://catagorym.zhiding365.com/hotelgame/list.html?hid=" + $routeParams.hid + "&fromgroup=" + $rootScope.hotel_basic_info.fromgroup;
    }
    $rootScope.go_alliance = function () {

        var star = parseInt($rootScope.hotel_basic_info.star);
        if ($rootScope.hotel_basic_info.zhidingalliance == 1)
            window.location.href = "http://m.zhiding365.com/#/room/alliance?delcity=" + $rootScope.hotel_basic_info.cityid + "&starHotel=" + star;
        else
            window.location.href = "http://m.zhiding365.com/#/";
    }
}
])
HotelmApp.controller('ErrorController', function ($scope, $rootScope) {
    $scope.error = 404;
    $scope.fanhui = function () {
        window.history.go(-1);
    };
});
/********************浮层历史记录堆栈弹出时，执行的方法*******************/
var pop_func = [];
window.onpopstate = function (event) {

    var len = pop_func.length;
    if (len > 0) {
        pop_func[len - 1]();
        pop_func.length = len - 1;
    }
    //console.log(window.history.length,window.history.);
}

//window.onbeforeunload = function (event) {
//    // console.log(event);

//    //window.location.href = 'http://www.sina.com.cn';
//    console.log(window.location);
//    if (window.location.href.indexOf('hotelm')<0)
//        return 'OK';
//}

//字符串首字母大写
function zhiding_changeCase(str) {
    if (str) {
        var firstChar = str.substring(0, 1).toUpperCase();
        var postString = str.substring(1, str.lenth);
        return firstChar + postString;
    } else {
        return "";
    }
}

//公共头部返回键事件
$(document).on("click", "#div_top_bar", function (e) {

    if ($(e.target).hasClass("back")) {

        if ($(".mask").css("display") == "block") {
            $(".mask").hide();
        }

        var _href = String(window.location.href).toLowerCase();
        if (_href.indexOf("/login/index") > -1) {

            history.go(-2);

        } else {
            if (window.history.length > 1) {
                history.go(-1);
            }
            else {
                var reg = /#\/(\d+)/ig;
                var regArr = reg.exec(window.location.href);
                var _hid = regArr[1];
                history.pushState({}, "", "#/" + _hid + "/");
                window.location.href = '/#/' + _hid + "/";
            }
        }
    }
    else if ($(e.target).hasClass("menu") || $(e.target).parent().hasClass("menu")) {
        if ($("#topnav").css("display") == "none")
            $("#topnav").show();
        else
            $("#topnav").hide();
    }
});

$(document).on("click  touchmove", function (e) {


    if (!($(e.target).hasClass("menu") || $(e.target).parents(".menu").length > 0)) {
        $("#topnav").hide();
    }
})

function zhiding_getCookieValue(cookieName) {
    var cookieValue = document.cookie;
    var cookieStartAt = cookieValue.indexOf("" + cookieName + "=");
    while (cookieStartAt >= 0) {
        cookieStartAt = cookieValue.indexOf("=", cookieStartAt) + 1;
        cookieEndAt = cookieValue.indexOf(";", cookieStartAt);
        if (cookieEndAt == -1) {
            cookieEndAt = cookieValue.length;
        }
        var tmpValue = cookieValue.substring(cookieStartAt, cookieEndAt);
        if (tmpValue)
            return decodeURIComponent(tmpValue);
        else
            cookieStartAt = cookieValue.indexOf("" + cookieName + "=", cookieEndAt);
    }
    return null;
}
//获取cookie  
//function zhiding_getCookieValue(cookieName) {
//    var cookieValue = document.cookie;
//    var cookieStartAt = cookieValue.indexOf("" + cookieName + "=");
//    if (cookieStartAt == -1) {
//        cookieStartAt = cookieValue.indexOf(cookieName + "=");
//    }
//    if (cookieStartAt == -1) {
//        cookieValue = null;
//    }
//    else {
//        cookieStartAt = cookieValue.indexOf("=", cookieStartAt) + 1;
//        cookieEndAt = cookieValue.indexOf(";", cookieStartAt);
//        if (cookieEndAt == -1) {
//            cookieEndAt = cookieValue.length;
//        }
//        cookieValue = decodeURIComponent(cookieValue.substring(cookieStartAt, cookieEndAt));//解码latin-1  
//    }
//    return cookieValue;
//}


function zhiding_setCookie(cookiename, cookievalue, hours) {
    var date = new Date();
    date.setTime(date.getTime() + Number(hours) * 3600 * 1000);
    document.cookie = cookiename + "=" + cookievalue + ";expires = " + date.toGMTString();
}

//字符串格式化 eg: var str = "I Love {0}, and You Love {1}!"; alert(a.format("You","Me"));
String.prototype.format = function () {
    var args = arguments;
    return this.replace(/\{(\d+)\}/g,
        function (m, i) {
            return args[i];
        });
}
//判断是否是时间
function checkDate(d) {
    var ds = d.match(/\d+/g), ts = ['getFullYear', 'getMonth', 'getDate'];

    var d = new Date(d.replace(/-/g, '/')), i = 3;

    ds[1]--;

    while (i--) if (ds[i] * 1 != d[ts[i]]()) return false;

    return true;

}

//防注入过滤
function zhiding_stripscript(s) {
    var pattern = new RegExp("[%--`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]")
    var rs = "";
    for (var i = 0; i < s.length; i++) {
        rs = rs + s.substr(i, 1).replace(pattern, '');
    }
    return rs;
}

//日期格式化扩展 eg: var d = Date.Now; console.log(d.format('yyyy-MM-dd'));console.log(d.format('yyyy-MM-dd hh点mm分ss秒SSS毫秒')
Date.prototype.format = function (format) {
    var date = {
        "M+": this.getMonth() + 1,
        "d+": this.getDate(),
        "h+": this.getHours(),
        "m+": this.getMinutes(),
        "s+": this.getSeconds(),
        "q+": Math.floor((this.getMonth() + 3) / 3),
        "S+": this.getMilliseconds()
    };
    if (/(y+)/i.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear() + '').substr(4 - RegExp.$1.length));
    }
    for (var k in date) {
        var prefix = "00";
        if (k == "S+") {
            prefix = "000";
        }
        if (new RegExp("(" + k + ")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1
                   ? date[k] : (prefix + date[k]).substr(("" + date[k]).length));
        }
    }
    return format;
}

Date.prototype.DateAdd = function (strInterval, Number) {
    var dtTmp = this;
    switch (strInterval) {
        case 's': return new Date(Date.parse(dtTmp) + (1000 * Number));
        case 'n': return new Date(Date.parse(dtTmp) + (60000 * Number));
        case 'h': return new Date(Date.parse(dtTmp) + (3600000 * Number));
        case 'd': return new Date(Date.parse(dtTmp) + (86400000 * Number));
        case 'w': return new Date(Date.parse(dtTmp) + ((86400000 * 7) * Number));
        case 'q': return new Date(dtTmp.getFullYear(), (dtTmp.getMonth()) + Number * 3, dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());
        case 'm': return new Date(dtTmp.getFullYear(), (dtTmp.getMonth()) + Number, dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());
        case 'y': return new Date((dtTmp.getFullYear() + Number), dtTmp.getMonth(), dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());
    }
}
//返回日期相差天数
function zhiding_getDays(strDateStart, strDateEnd) {
    var strSeparator = "-"; //日期分隔符
    var oDate1;
    var oDate2;
    var iDays;
    oDate1 = strDateStart.split(strSeparator);
    oDate2 = strDateEnd.split(strSeparator);
    var strDateS = new Date(oDate1[0], oDate1[1] - 1, oDate1[2]);
    var strDateE = new Date(oDate2[0], oDate2[1] - 1, oDate2[2]);
    iDays = parseInt(Math.abs(strDateS - strDateE) / 1000 / 60 / 60 / 24)//把相差的毫秒数转换为天数 
    return iDays;
}

//手机号码验证
function check_mobile(val) {
    var reg = /(^0{0,1}1[3|4|5|6|7|8|9][0-9]{9}$)/;
    if (!reg.test(val)) {
        return false;
    } else {
        return true;
    }
}
//邮箱名验证
function check_mail(mail) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (filter.test(mail)) return true;
    else {
        return false;
    }
}


function check_chinname(val) {
    val = val.replace(/\s+/g, "");
    var reg = /^[\u4E00-\u9FA5]{2,20}$/;
    if (!reg.test(val)) {
        return false;
    } else {
        return true;
    }

}
function check_enname(val) {
    val = val.replace(/\s+/g, "");
    var reg = /^[a-zA-Z]{3,20}$/i;
    if (!reg.test(val)) {
        return false;
    } else {
        return true;
    }

}

function check_name(val) {
    val = val.replace(/\s+/g, "");
    if (!check_chinname(val)) {
        if (!check_enname(val)) {
            var regc = /[\u4E00-\u9FA5]{1,20}/;
            var rege = /[a-zA-Z]{1,20}/i;
            if (regc.test(val) && rege.test(val)) {
                return 0;
            }
            else {
                if (regc.test(val))
                    return -1;
                else
                    return -2;
            }
        }
        return 2;
    }
    else
        return 1;
}
//$(window).resize(function () {
//    alert("?>>");
//    $("#div_top_bar").css({ top: 0, left:0 });
//});

// 判断屏幕是否旋转



//获取我的位置坐标
function zhiding_getLoaction(geo_callback, http) {
    function load_script(xyUrl, callback) {
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = xyUrl;
        // 借鉴了jQuery的script跨域方法 
        script.onload = script.onreadystatechange = function () {
            if ((!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
                callback && callback();
                // Handle memory leak in IE 
                script.onload = script.onreadystatechange = null;
                if (head && script.parentNode) {
                    head.removeChild(script);
                }
            }
        };
        // Use insertBefore instead of appendChild to circumvent an IE6 bug. 
        head.insertBefore(script, head.firstChild);
    }
    function translate(point, type, callback) {
        var callbackName = 'cbk_' + Math.round(Math.random() * 10000); // 随机函数名 
        var xyUrl = "http://api.map.baidu.com/ag/coord/convert?from=" + type
                + "&to=4&x=" + point.lng + "&y=" + point.lat
                + "&callback=BMap.Convertor." + callbackName;
        // 动态创建script标签 
        load_script(xyUrl);
        BMap.Convertor[callbackName] = function (xyResult) {
            delete BMap.Convertor[callbackName]; // 调用完需要删除改函数 
            var point = new BMap.Point(xyResult.x, xyResult.y);
            callback && callback(point);
        }
    }

    window.BMap = window.BMap || {};
    BMap.Convertor = {};
    BMap.Convertor.translate = translate;
    if (navigator.geolocation) {
        $(document).trigger("ajaxStart");
        navigator.geolocation.getCurrentPosition(function (p) {
            $(document).trigger("ajaxStop");
            var latitude = p.coords.latitude//纬度
            var longitude = p.coords.longitude;

            geo_callback(latitude, longitude, true);
            //createmap(latitude, longitude);
        }, function (e) {//错误信息
            $(document).trigger("ajaxStop");
            geo_callback('', '', false);
            //if (e.code == 1)
            //    alert("您拒绝获取您的位置信息");
            //var aa = e.code + "\n" + e.message;

        }
        );
    }


    //var ua = window.navigator.userAgent.toLowerCase();
    //if (ua.match(/MicroMessenger/i) == "micromessenger") {
    //    var cur_url = window.location.href;
    //    if (cur_url.indexOf('#') > -1)
    //        cur_url = cur_url.substring(0, cur_url.indexOf('#'));

    //    var url_location = '/api/v1/AccountSecurity/WeiXinConf?url=' + encodeURIComponent(cur_url);
    //    alert(url_location);
    //    $(document).trigger("ajaxStart");
    //    var res_location = null;
    //    http.get(url_location)
    //        .success(function (data) {
    //            if (data.has_val) {
    //                var lct = data.result;
    //                callWxLocation(lct.app_id, lct.timestamp, lct.noncestr, lct.signature, function () {
    //                    $(document).trigger("ajaxStop");
    //                    geo_callback(arguments[0], arguments[1], arguments[2]);
    //                })
    //            } else {
    //                $(document).trigger("ajaxStop");
    //            }
    //        }).error(function () {
    //            $(document).trigger("ajaxStop");
    //        });

    //    var callWxLocation = function (appid, timestamp, nonceStr, signature, wx_callback) {

    //        wx.config({
    //            debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    //            appId: appid, // 必填，公众号的唯一标识
    //            timestamp: timestamp, // 必填，生成签名的时间戳
    //            nonceStr: nonceStr, // 必填，生成签名的随机串
    //            signature: signature,// 必填，签名，见附录1
    //            jsApiList: ["getLocation", "openLocation"] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    //        });

    //        wx.ready(function () {
    //            wx.getLocation({
    //                //timestamp: timestamp, // 位置签名时间戳，仅当需要兼容6.0.2版本之前时提供
    //                //nonceStr: noncestr, // 位置签名随机串，仅当需要兼容6.0.2版本之前时提供
    //                //addrSign: addrsign, // 位置签名，仅当需要兼容6.0.2版本之前时提供，详见附录4
    //                success: function (res) {
    //                    alert("141111");
    //                    wx_callback(res.latitude, res.longitude, true);
    //                }, fail: function (res) {
    //                    alert('获取地理位置失败');
    //                    wx_callback('', '', false);
    //                }, cancel: function () {
    //                    alert('您拒绝获取地理位置');
    //                    wx_callback('', '', false);
    //                }
    //            });
    //        });
    //    }

    //} else {

    //    if (window.navigator.geolocation) {
    //        navigator.geolocation.getCurrentPosition(function (p) {
    //            var latitude = p.coords.latitude//纬度
    //            var longitude = p.coords.longitude;
    //            alert(latitude + "," + longitude);
    //            //createmap(latitude, longitude);
    //        }, function (e) {//错误信息
    //            var aa = e.code + "\n" + e.message;
    //            alert(aa);
    //        }
    //      );

    //        //var options = {
    //        //    enableHighAccuracy: true,
    //        //};


    //        //window.navigator.geolocation.getCurrentPosition(function (position) {
    //        //    console.log(position);
    //        //    // 获取到当前位置经纬度   
    //        //    geo_callback(position.coords.latitude, position.coords.longitude, true);
    //        //}, function () { geo_callback('', '', false); }, options);

    //    } else {
    //        geo_callback('', '', false);
    //    }
    //}
}
function newGuid() {
    var guid = "";
    for (var i = 1; i <= 32; i++) {
        var n = Math.floor(Math.random() * 16.0).toString(16);
        guid += n;
        if ((i == 8) || (i == 12) || (i == 16) || (i == 20))
            guid += "-";
    }
    return guid;
}
var tempfirst = false;
var MessageBox = function (options) {
    this.currtar = "block_" + newGuid();
    $(".modal").remove();
    var tempmess = $("<div id='" + this.currtar + "'></div>").appendTo("body").addClass("modal");
    var tempmessmain = $(" <div class='main bg_color_white1'></div>");
    var defaults = {
        content: '',
        cantext: '',
        iscan: true,
        oktext: '',
        ok: function () { },
        cancelfun: function () { }
    };
    this.mOpts = $.extend({}, defaults, options);

    var __method = this;
    if (this.mOpts.content == "") return;

    var btnblock = $('<p class="btn color_blue1"></p>')
    if (!this.mOpts.iscan) {
        btnblock.append($('<span class="ok">' + this.mOpts.oktext + '</span>').on("click", function () {
            __method.tempval = true;
            __method.close();
        }));
    }
    else {
        btnblock.append($('<span class="cancel  lt">' + this.mOpts.cantext + '</span>').on("click", function () {
            __method.tempval = false;
            __method.close();
        })).append($('<span class="ok  rt">' + this.mOpts.oktext + '</span>').on("click", function () {
            __method.tempval = true;
            __method.close();
        }));
    }
    tempmessmain.append('<p class="f18 content"  style="padding: 10px 0px 0; line-height: 36px; text-align: center;">' + this.mOpts.content + '</p>').append(btnblock);
    $("body").css({ "overflow": "hidden", "height": "100%" });
    tempmess.append(tempmessmain).fadeIn(200);
}
MessageBox.prototype.close = function () {
    if (this.tempval)
        this.mOpts.ok();
    else
        this.mOpts.cancelfun();
    $("#" + this.currtar).fadeOut(200, function () { $(".modal").remove("#" + this.currtar) });
    $("body").removeAttr("style");

}

function showMessageBox(content, oktext, cantext, okfun, canfun, iscan) {
    if (iscan == undefined) iscan = true;
    var message = new MessageBox({ content: content, oktext: oktext, ok: okfun, cancelfun: canfun, cantext: cantext, iscan: iscan });
}