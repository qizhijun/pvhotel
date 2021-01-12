$(function() {
				FastClick.attach(document.body);
				//公共头部事件处理
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
				});
			});