
function HomeIndexController($scope, $http, $timeout, $rootScope, $routeParams, $ocLazyLoad, $location) {

    //$(document).trigger("TemplateStart");
    $("#main_main").hide();
  //  location.reload();
    $(document).trigger("ajaxStart1");
    $("#div_ajax_start1").css({ "display": "none" });
    //版本权获取今年时间(年)
    var time = new Date();
    $scope.year = time.format('yyyy');
 
   

    //require(['/webapp/script/js/iscroll.4.2.2.min.js', '/webapp/script/js/hhSwipe.js', 'webapp/script/js/ImgUrl', 'webapp/script/js/iscroll.5.1.3.min.js?v=1.0', '/webapp/script/js/swipe.js'], function () {//麻
    $ocLazyLoad.load(['/webapp/script/js/hhSwipe.js', '/webapp/script/js/ImgUrl.js', '/webapp/script/js/swipe.js']).then(function () {
     
        var hid = $routeParams.hid;

        $scope.player = 'kobe';
        var hei = $(window).height();
        //$("#p_copyright").show();
        $(".index_top ").height(hei);
        $(".index_top img").height(hei);
        //var level_id = $rootScope.loginInfo.level_id;
        // var themid = $rootScope.hotel_basic_info.themeid;//麻屏蔽
        var themid = $routeParams.themename ? $routeParams.themename : $rootScope.hotel_basic_info.themeid;//麻改
        $scope.count = 0;//轮播图片个数
        $scope.counts = 0;//当前的轮播图片的index
        //屏高，宽
        var width = $(window).width();

        $scope.hid = $routeParams.hid;
        //设置背景颜色和透明度的方法
        var getRGB = function (hex, a) {
            var rgb = [0, 0, 0];
            if (/#(..)(..)(..)/g.test(hex)) {
                rgb = [parseInt(RegExp.$1, 16), parseInt(RegExp.$2, 16), parseInt(RegExp.$3, 16)];
            };

            return "rgba(" + rgb.join(",") + "," + (a / 100).toString() + ")";
        }
        $scope.bg_color = "";
        //转格式
        var TmplHome = "/api/v1/TmplHomePage/TmplHomePageInfo?ThemeENName=" + themid + "&HID=" + hid;
        if (themid != "paintingglass11") {
            $http.get(TmplHome)
            .success(function (data) {
                if (data.has_val) {
                    $scope.TmplHome = data.result;
                    $scope.count = $scope.TmplHome.bg_imgs.length;
                    //此处为中国大饭店所用字段---------------------------------------------
                    $scope.norpages = new Array();
                    for (var i = 1; i < $scope.TmplHome.blocks.length - 4; i++) {
                        $scope.norpages.push($scope.TmplHome.blocks[i]);
                    }
                    //---------------------------------------------------------------------
                    for (var i = 0; i < $scope.TmplHome.blocks.length; i++) {
                        $scope.TmplHome.blocks[i].bg_img = GetImgUrl('Orig', $scope.TmplHome.blocks[i].bg_img);
                    }
                    for (var i = 0; i < $scope.TmplHome.bg_imgs.length; i++) {

                        $scope.TmplHome.bg_imgs[i].img = GetImgUrl('Orig', $scope.TmplHome.bg_imgs[i].img);
                    }
                    $scope.bg_color = $scope.TmplHome.bg_color;
                    //头部
                    $("body").css("background-color", $scope.TmplHome.bg_color);//背景颜色
                    if (themid == "mittagong" || themid == "mittagong2") {//片片枫叶情的三角形的颜色
                        $("#center .zd-ltp").css(" border-left-color", $scope.TmplHome.bg_color);
                        $("#center .zd-rtp").css(" border-right-color", $scope.TmplHome.bg_color);
                    }

                    if (themid == "angel")
                        $("#p_copyright").show();

                    for (var i = 0; i < $scope.TmplHome.blocks.length; i++) {
                        // var ttt = GetImgUrl('S360d', $scope.TmplHome.blocks[i].bg_img);
                        //console.log(ttt);
                        //中间部分
                        //图标位置

                        var finds = $scope.TmplHome.blocks[i].icon.indexOf("px");
                        var stards = $scope.TmplHome.blocks[i].icon.substring(0, finds + 2);
                        var ends = $scope.TmplHome.blocks[i].icon.substring(finds + 2, $scope.TmplHome.blocks[i].icon.length);

                        //  $("#blid" + i).css({"background-color":$scope.TmplHome.blocks[i].title_bg,"background-image":"url("+$scope.TmplHome.blocks[i].bg_img+")","border":$scope.TmplHome.blocks[i].border_color});//小版块的背景颜色
                        $("#blid" + i + " .title_s").css("color", $scope.TmplHome.blocks[i].title_color);//标题颜色
                        if ($scope.TmplHome.blocks[i].bg_opacity != 'null' && $scope.TmplHome.blocks[i].bg_opacity != "") {
                            $("#blid" + i).css("background-color", getRGB($scope.TmplHome.blocks[i].bg_color, $scope.TmplHome.blocks[i].bg_opacity));//背景颜色
                        } else {
                            $("#blid" + i).css("background-color", $scope.TmplHome.blocks[i].bg_color);//小块背景颜色
                            if (themid == "colorfulcolors") {
                                $("#blid" + i).css("color", $scope.TmplHome.blocks[i].title_color);//小块背景颜色
                            }

                        }
                        if (themid == "rich") {
                            var bcolor = getRGB($scope.TmplHome.blocks[i].border_color, 80);
                            $("#blid" + i).css("border-color", bcolor);//边框色
                        } else if (themid == "blueskies" && i > 7) {//碧云天
                            $("#blid" + i).css("border-color", $scope.TmplHome.blocks[i].title_color);//边框色
                        } else if (themid == "goldenclassics") {//金色经典设置无边框
                            $("#blid" + i).css("border-color", "");//边框色
                        }
                        else
                            $("#blid" + i).css("border-color", $scope.TmplHome.blocks[i].border_color);//边框色
                        $("#blid" + i + " .lid_l").css("border-bottom-color", $scope.TmplHome.blocks[i].bg_color);//背景颜色(井然有序模板)
                        //if (themid != "goldenclassics" && themid != "goldenclassics" && themid != "coolsummer" && themid != "magiccube2" && themid != "magiccube3" && themid != "mittagong" && themid != "mittagong2" && themid != "resplendent" && themid != "angelsinworld1" && themid != "coloredroseo" && themid != "resplendent" && themid != "magicvioletcrystal" && themid != "colorfulcolors") {//金色经典 文字
                         
                        //   $("#blid" + i).find(".title_s").text($scope.TmplHome.blocks[i].title);//标题
                        //}
                        //// $("#blid" + i).find(".title_s").text($scope.TmplHome.blocks[i].title);//标题
                        $("#blid" + i + " .icon_s").css({ "background-position": stards + " " + ends });//图标位置及大小, "background-size":$scope.TmplHome.blocks[i].icon_size+"px"
                        if (themid == "auniquesoul" || themid == "blueskies" || themid == "bigblue" || themid == "speeddialsquaredup2" || themid == "goldenclassics" || themid == "contractededition" || themid == "coolsummer" || themid == "elegant" || themid == "magiccube2" || themid == "magiccube3" || themid == "mittagong" || themid == "mittagong2" || themid == "resplendent" || themid == "angelsinworld1" || themid == "coloredroseo" || themid == "magicvioletcrystal" || themid == "colorfulcolors" || themid == "brilliant") {//判断后来HTID>=10059 新加的用文字来显示图标位置 上面的图片位置可有可无 ，
                       
                            $("#blid" + i + " .iconfont").removeAttr("class").addClass($scope.TmplHome.blocks[i].iconclass);

                        }
                        if (themid == "modernstylish" || themid == "fresh") {

                            $("#blid" + i + " .lid_ls_br").css({ "background-color": $scope.TmplHome.blocks[i].bg_color });
                            $("#blid" + i).css("background-color", "rgba(134, 104, 104,0.0)");//背景颜色
                        }
                    }
                }

            });
        }

        $(document).trigger("ajaxStop1");

        $("#main_main").fadeIn();
        //获取默认轮播图
        var HotelImg = "/api/v1/Hotel/HotelImg?hid=" + hid;
        $http.get(HotelImg)
        .success(function (data) {
            if (data.has_val) {
                $scope.hotelimg = data.result;
            }
        });
        ///////////////////
        if (themid == "coloredroseo") {
            var h = $(window).height();
            var mh = $("#main_main").height();
            if (h > mh)
                $("#footer").css("position", "fixed");
            else
                $("#footer").css("position", "relative");
        }

        //获取酒店信息
        var hoteintr = "/api/v1/HotelIntroduce/HotelDetailed?HID=" + $rootScope.hotel_basic_info.hid;
        $http.get(hoteintr)
        .success(function (data) {
            if (data.has_val) {
                $scope.hoteintr = data.result.HotelExt;
                $scope.hoteimg = data.result.hotelInfo_Img;
                //  console.log(data.result);

            }
        });




        var hid = $routeParams.hid;
        $scope.hid = $routeParams.hid;

        //  var themid = $rootScope.hotel_basic_info.themeid;
        ///**************焦点图开始****************/
        var flag = true;//动画结束标记
        var click_flag = true;//手动触发click标记
        var _interval;//定时器
        var coun = 0;//li总数
        var objClass = [0, 0];//动画坐标Style
        var transition_flag = true;//首次触发click时，为li添加动画运行时间

        var _banner_click = function () {
            var _parm = $(this).hasClass("banner-next") ? 1 : -1;
            if (click_flag) {
                window.clearInterval(_interval);
            }
            if (flag) {
                flag = false;
                if (transition_flag) {
                    $("#bannerIndex li").css("-webkit-transition", "800ms");
                    transition_flag = false;
                }
                $("#bannerIndex li").each(function (index, element) {
                    var _index = ($(this).data("index") + _parm + coun) % coun;
                    $(this).data("index", _index);
                    $(this).css(objClass[_index]);
                });
            }
        }
      
        var _func = function () {

            click_flag = false;
            $("#banner-next").trigger("click");
            click_flag = true;

        }

        //////////////////////////////时光静好
        var heib = $(window).height() / 2;
        var widb = $(window).width() / 2;
        var coreH = $(".core").width();
        var topb = heib - widb;
        var coreH = $(".core").width();
        var topb = heib - widb;
        $("#center .core").css("top", topb);
        $(".Icon").css("top", topb + 10);
        var ml = $(window).width() - $(".core").width();
        $(".core").css("height", coreH);
        $(".Icon").css("height", coreH);
        $(".Icon").css("width", coreH);
        $(".Icon").css("margin-left", ml / 2);

        //  $("#banner li").height();
        $("#banner li").height(hei + 75);
        ///**************焦点图开始****************/
        ////////////////////////////时光静好


        $(".index_centers").on("click", ".shp", function () {

            if ($(this).parent().children().eq(2).hasClass("nones")) {
                $(this).parent().children().eq(2).addClass("blk").removeClass("nones");
                $(this).parent().siblings().find("ul").addClass("nones");
            } else {
                $(this).parent().children().eq(2).addClass("nones").removeClass("blk");
            }
        })
        $(".index_top").on("click", "img", function () {
            $("ul").addClass("nones");
        })

        ////执行完是运行
        $scope.$on('ngRepeatFinished', function (ngRepeatFinishedEvent) {
            $("#gz_banner_all .zd-bgtitle").css("display", "block");
            if (themid == "dream") {

                ////////////////////如烟若梦//////////////////////////////////////////////
                if (hei > 533) {
                    $(".container").height(hei)
                }

                coun = $("#bannerIndex").children().length;
                while (coun < 5) {
                    $("#bannerIndex").append($("#bannerIndex").html());
                    coun = $("#bannerIndex").children().length;
                }
                var t_x = $("#bannerIndex").width() - 20;
                var t_x1 = t_x * (1 + Math.cos(78 / 360 * (2 * Math.PI))) - 20;
                objClass = [
                        { "opacity": 0, "visibility": "hidden", "-webkit-transform": "translateX(-" + t_x1 + "px) rotateY(-78deg)", "-webkit-transform-origin": "0% 50%" },
                    { "opacity": 1, "visibility": "visible", "-webkit-transform": "translateX(-" + t_x + "px) rotateY(-65deg)", "-webkit-transform-origin": "100% 50%" },
                    { "opacity": 1, "visibility": "visible", "-webkit-transform": "translateX(0px) rotateY(0deg)", "-webkit-transform-origin": "0% 50%" },
                    { "opacity": 1, "visibility": "visible", "-webkit-transform": "translateX(" + t_x + "px) rotateY(65deg)", "-webkit-transform-origin": "0% 50%" },
                    { "opacity": 0, "visibility": "hidden", "-webkit-transform": "translateX(" + t_x1 + "px) rotateY(78deg)", "-webkit-transform-origin": "0% 50%" }

                ];
                while (objClass.length < coun) {
                    objClass.push(objClass[4]);
                }
                $("#bannerIndex li").each(function (index, element) {
                    $(this).data("index", index);
                    $(this).css(objClass[index]);
                });

                $("#bannerIndex li").bind("webkitTransitionEnd", function () { flag = true; });
                $("#banner-next").click(_banner_click);
                $("#banner-prev").click(_banner_click);
                _interval = window.setInterval(_func, 3000);
                $("#bannerIndex").children().eq(2).find("img").on("load", function () {
                    var heili = $("#bannerIndex").children().eq(2).height();

                    $("#bannerIndex").height(heili);
                })


                //////////////////////如烟若梦//////////////////////////////////////////////
            }
            else if (themid == "brilliant") {

                $("body").css("top", 0)
                ////姹紫嫣红////////////////////////////////////////////////////////////////////
                $(" #bannerindexdot li").eq(0).addClass("curr")
                var bulletsf = $('#bannerindexdot li');
                $("#gz_banner_alldot .banner").height(hei);
                $("#All_top").css("height", hei, "overflow", "hidden");
                var counst = $('#gz_banner_alldot ul').children().length;
                var countxc = $('#bannerindexdot ').children().length;
                var slider = Swipe($('#gz_banner_alldot'), {
                    auto: 3000,
                    continuous: true,
                    callback: function (pos) {
                      
                        if (countxc < 3 ) {
                       
                            bulletsf.removeClass("dq").eq(pos % 2).addClass("dq");
                        } else {
                          
                            bulletsf.removeClass("dq").eq(pos).addClass("dq");
                        }
                       
                    }

                });

                $("#understand").on("click", function () {
                    if ($("body").css("top") == "0px") {
                        $("body").animate({ top: "-288px" }, $("#All_top").removeClass("ovfl"), $("#understand .slide").css("-webkit-transform", "rotate(90deg)"));
                    }
                    else {

                        $("body").animate({ top: "0px" }, $("#All_top").addClass("ovfl"), $("#understand .slide").css("-webkit-transform", "rotate(270deg)"));

                    }
                    
                });

                ////  姹紫嫣红/////////////////////////////////////////////////////////////
            }
            else if (themid == "paintingglass") {
                //////////////////////////////翰墨琉璃
                $("body").css("top", 0)
                $("#All_tops #bannerst li").height(hei - 78);
                $("#All_tops").css("height", hei - 78);

                $("#top_tt").on("touchend", function () {

                    $("body").css("top") == "0px" ? $("body").animate(
                           { top: "-288px" },
                          $("#All_tops").removeClass("ovfl"),
                       // $("#gz_banner_alls .zd-bgtitle").css("top", 169),


                         $("#top_tt").css("-webkit-transform", "rotate(0deg)")

                        )
                    : $("body").animate({ top: "0px" }, $("#All_tops").addClass("ovfl"),
                      
                         $("#top_tt").css("-webkit-transform", "rotate(180deg)")
                        // $("#gz_banner_alls .zd-bgtitle").css("top",200)

                        );
                });
                $("#member_footer_menus").on("click", "li", function () {
                    $(this).addClass("curr").siblings().removeClass("curr");
                })
            } else if (themid == "auniquesoul") {

                $("#bannerindexdot li").eq(0).addClass("curr");
                var bullets = $('#bannerindexdot li');
                var counst = $('#gz_banner_all ul').children().length;
            }
                /////////////////////////////////////////中国大饭店
            else if (themid == "vertical") {//上下滑动
                $("#swipe").height($(window).height());

                $('#swipe').swipe({
                    cur: 0,
                    dir: "vertical",
                });
                for (var i = 1; i < $scope.TmplHome.blocks.length - 4; i++) {
                    if ($scope.TmplHome.blocks[i].has_btn) {
                        $("#swipe ul li").eq(i).find(".slide_bottom").css("background-color", $scope.TmplHome.blocks[i].bg_color);
                    }

                }
                $(".ydkf").css("border-color", $scope.TmplHome.blocks[$scope.TmplHome.blocks.length - 3].border_color);
                $(".ydkf p").css("color", $scope.TmplHome.blocks[$scope.TmplHome.blocks.length - 3].title_color);

                $(".ydct").css("border-color", $scope.TmplHome.blocks[$scope.TmplHome.blocks.length - 2].border_color);
                $(".ydct p").css("color", $scope.TmplHome.blocks[$scope.TmplHome.blocks.length - 2].title_color);

            }

            /////////////////////////////////////////中国大饭店
            $(document).trigger("ajaxStop1");
            $("#main_main").fadeIn();
            //头图片的高
            var top = $("#gz_banner_all .banner").height();
            var centhei = $("#center").height();
            var footerhei = $("#footer").height();
            //宽
            var wid = $(".ones_cent ul li").width();
            var tempH = $(".ones_cent ul li").height();
            var tempP = Math.abs((wid - tempH)) / 2;
            $(".ones_cent ul li").css({ "padding-top": tempP, "padding-bottom": tempP });
                //第一种轮播（半屏带轮播点）
                var bullets = $('#bannerindex1 li');
                //var count = $('#gz_banner_all ul').children().length;
                var slider = Swipe($('#gz_banner_all'), {
                    auto: 3000,
                    continuous: true,
                    callback: function (pos) {
                        //（半屏带轮播点）
                        if (themid == "speeddialsquaredup1" || themid == "blueskies" || themid == "speeddialsquaredup2" || themid == "elegant" || themid == "goldenclassics" || themid == "contractededition" || themid == "coolsummer" || themid == "magiccube2" || themid == "magiccube3" || themid == "mittagong" || themid == "angelsinworld1" || themid == "coloredroseo" || themid == "resplendent" || themid == "colorfulcolors") {//判断后来加的模板是否需要下面的点点
                            if ($scope.count < 3) {
                                $scope.counts = pos % 2;
                                $('#bannerindex1 li').removeClass("dq").eq(pos % 2).addClass("dq");
                            } else {
                                $scope.counts = pos;
                                $('#bannerindex1 li').removeClass("dq").eq(pos).addClass("dq");
                            }
                          
                        } else {//（半屏没带轮播点）
                            if ($scope.count < 3) {
                                $scope.counts = pos % 2;
                            } else {
                                $scope.counts = pos;
                            }
                        }
                    }
                });

            //第二种轮播(全屏)
                $("#gz_banner_alls #banner li").height(hei);
                var slider = Swipe($('#gz_banner_alls'), {
                    auto: 3000,
                    continuous: true,
                    callback: function (pos) {
                        if ($scope.count < 3) {
                            $scope.counts = pos % 2;
                        } else {
                            $scope.counts = pos;

                        }
                    }
                });


            ////第三种轮播(带头部"直订网"全屏)暂时没有
            //$("#gz_banner_allst #banner li").height(hei - 50);
            //var slider = Swipe($('#gz_banner_allst'), {
            //    auto: 3000,
            //    continuous: true,
            //    callback: function (pos) {

            //        if ($scope.count < 3) {
            //            $scope.counts = pos % 2;

            //        } else {
            //            $scope.counts = pos;

            //        }
            //    }
            //});



            if (themid == "yearsummer") {
                var imgtemp = $('#gz_banner_all img').eq(0);
                var h = $(window).height();
                if (imgtemp.height() > 0) {
                    var mh = $("#main_main").height();
                    if (h > mh)
                        $("#main_main").css("margin-top", (h - mh) / 2);
                    else
                        $("#main_main").css("margin-bottom", 12);
                }
                else {
                    imgtemp.on("load", function () {
                        var mh = $("#main_main").height();
                        if (h > mh)
                            $("#main_main").css("margin-top", (h - mh) / 2);
                        else
                            $("#main_main").css("margin-bottom", 12);
                    })
                }
            }

           


            //炫灿华美
            var t = $("#gz_banner_all .banner").height();
            if (t > 220) {
                var ct = (hei - 221) / 3;
                //$("#center .zbox .bt").height(ct - 10);
                $("#center .zbox .box4 .tu1").height(ct - 10);
                $("#center .zbox .box4 .tu2").height(ct - 10);
            }
        });
        //联系酒店
        $scope.getof = function (tel) {
            window.location.href = 'tel:' + tel;
        }
        //第一种轮播（半屏）
        var slider = Swipe($('#gz_banner_all'), {
            auto: 3000,
            continuous: true
        });
        //第二种轮播(全屏)
        $("#gz_banner_alls #banner li").height(hei);
        var slider = Swipe($('#gz_banner_alls'), {
            auto: 3000,
            continuous: true
        });
        //第三种轮播(带头部全屏)
        $("#gz_banner_allst #banner li").height(hei - 50);
        var slider = Swipe($('#gz_banner_allst'), {
            auto: 3000,
            continuous: true,
        });

        //});
        //普通跳转
        var go_url_ft = function (resid) {
            $scope.go_url(resid);
            $scope.$apply();
            $("body").css({ "top": 0, "background-color": "#ffffff" });
        }

        //直订联盟
        $scope.go_zhid = function (url) {
            $scope.go_url(url);
         
            $("body").css({ "top": 0, "background-color": "#ffffff" })
        }
        //联系酒店
        var getof_fl = function (tel) {
            window.location.href = 'tel:' + tel;
            $("body").css({ "top": 0, "background-color": $scope.bg_color });
        }
        $scope.getof = function (tel) {
            window.location.href = 'tel:' + tel;
            $("body").css({ "top": 0, "background-color": "#ffffff" })
        }
        //一键导航
        var gohotelm_ft = function () {
            var gethotel = "/api/v1/hotel/GetHotelBaseInfo?hid=" + $routeParams.hid;

            $http.post(gethotel)
                   .success(function (data) {
                       if (data.has_val) {
                           $scope.hotelinfo = data.result;
                         
                           window.location.href = "http://api.map.baidu.com/marker?location=" + $scope.hotelinfo.lat + "," + $scope.hotelinfo.lng + "&title=" + $scope.hotelinfo.hname + "&content=" + $scope.hotelinfo.hname + "&output=html";
                       }
                   });
        }
        $scope.gohotelm = function () {
            var gethotel = "/api/v1/hotel/GetHotelBaseInfo?hid=" + $routeParams.hid;

            $http.post(gethotel)
                   .success(function (data) {
                       if (data.has_val) {
                           $scope.hotelinfo = data.result;
                           window.location.href = "http://api.map.baidu.com/marker?location=" + $scope.hotelinfo.lat + "," + $scope.hotelinfo.lng + "&title=" + $scope.hotelinfo.hname + "&content=" + $scope.hotelinfo.hname + "&output=html";
                       }
                   });
        }

        //生活服务
        var lifeservice_ft = function () {
            var ttp = "hotelm.zhiding365.com/#/" + hid + "/environment/ ";
            window.location.href = ttp;
            $("body").css({ "top": 0, "background-color": "#ffffff" })
        }
        $scope.lifeservice = function () {
            window.location.href = "hotelm.zhiding365.com/#/" + hid + "/environment/ ";
            $("body").css({ "top": 0, "background-color": "#ffffff" })
        }

        //全景图
        var getofpanorama_ft = function (url) {
            window.location.href = "http://" + url;
            $("body").css({ "top": 0, "background-color": "#ffffff" })
        }
        $scope.getofpanorama = function (url) {
            window.location.href = "http://" + url;
            $("body").css({ "top": 0, "background-color": "#ffffff" })
        }
        //游戏中心
        var getgame_ft = function () {
            window.location.href = "http://catagorym.zhiding365.com/hotelgame/list.html?hid=" + hid;
            $("body").css({ "top": 0, "background-color": "#ffffff" })
        }
        $scope.getgame = function () {
            window.location.href = "http://catagorym.zhiding365.com/hotelgame/list.html?hid=" + hid;
            $("body").css({ "top": 0, "background-color": "#ffffff" })
        }


        //编辑调跳转
        $(".get_dj ").on("click", function () {
            var hiss = $(this).attr("data_tr");
            var url_ids = $(this).attr("data_ids");
            var url_ssl = $(this).attr("data_urlt");

            if (hiss.indexOf("tel:") == -1 && hiss != "http://demo.hotelm.zhiding365.com/#/" + hid + "/" ) {//判断是否是电话//判断是否跳到微官网
                $("body").css({ "top": 0, "background-color": "#ffffff" });
                $("#div_ajax_start1").css({ "display": "block" });
                if (hiss.indexOf("@hid") != -1 || hiss.indexOf("location=@point&title=@hname&content=@content&output=html") != -1) {//默认跳转法（酒店对模板没有进行修改过）
                   
                  
                    if (url_ids.indexOf("zhiding") != -1) {//普通跳转
                        go_url_ft(url_ssl);
                    } else if (url_ids.indexOf("zdgames") != -1) {//游戏跳转
                        getgame_ft();
                    } else if (url_ids.indexOf("zdtels") != -1) {//电话跳转
                        $("body").css({ "top": 0, "background-color": $scope.bg_color });
                    
                        $("#div_ajax_start1").css({ "display": "none" });
                        getof_fl(url_ssl);
                    } else if (url_ids.indexOf("zdmaps") != -1) {//一键导航
                        gohotelm_ft();
                    } else if (url_ids.indexOf("lifeservi") != -1) {//生活服务
                        lifeservice_ft();
                    } else if (url_ids.indexOf("zd_qjin") != -1) {//全景看房
                        getofpanorama_ft(url_ssl);
                    }
                } else if (!hiss) {//没有进行任何跳转
                    if (themid == "paintingglass11") {
                        if (url_ids.indexOf("zdtels") != -1) {
                            $("body").css({ "top": 0, "background-color": $scope.bg_color });

                            $("#div_ajax_start1").css({ "display": "none" });
                            getof_fl(url_ssl);
                        }
                        else
                        $scope.go_url(url_ssl);
                    }

                    $("body").css({ "top": 0, "background-color": $scope.bg_color });
                }
                else {
                   
                    window.location.href = hiss;
                }



            } else if (hiss == "http://demo.hotelm.zhiding365.com/#/" + hid + "/" && $routeParams.themename ) {//跳到本来设置好的微官网 && $routeParams.themename
              
                window.location.href = hiss;
                location.reload();
            } else if (hiss.indexOf("tel:") != -1) {//没有进行任何跳转（拨打电话）
                window.location.href = hiss;
            } else {//没有进行任何跳转（跳到微官网本页面拨打电话）
              
                $("body").css({ "top": 0, "background-color": $scope.bg_color });
            }
        });


        //点击轮播图片跳转
        $("#banner").on("click", function () {
            var url = $(this).children().eq($scope.counts).attr("data_tr");
            if (url) {
               
                $("body").css({ "top": 0, "background-color": "#ffffff" });
                $("#div_ajax_start1").css({ "display": "block" });
                window.location.href = url;
            }
        });




        //function IsTelephone(obj)// 正则判断
        //{
        //    var pattern = /(^[0-9]{3,4}\-[0-9]{3,8}$)|(^[0-9]{3,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)/;
        //    if (pattern.test(obj)) {
        //        return true;
        //    }
        //    else {
        //        return false;
        //    }
        //}





        //幻灯片跳转
        $scope.yuding = function (event) {
            var hr = $(event.target).attr("data_tr");
            if (hr) {
                window.location.href = hr;
                $("body").css({ "top": 0, "background-color": "#ffffff" })
            }
        }





    })




}




