$(function () {
    $(".menu ul li").removeClass("active");
    $(".menu ul li").eq(1).addClass("active");
    var mebid = $("#hidMebID").val();
    if (mebid != null && mebid != undefined && mebid > 0) {
        $(".m_help").eq(0).text("切换会员");
    }
    //获取会员可用积分
    getPoint(mebid);
    var nChainID = $("#hidChainID").val();
    var nRoomTypeID = $("#hidRoomType").val();
    if (nRoomTypeID == 2) {
        $("b[preferentialtype='2']").css("margin-top", "5px");
        $("b[preferentialtype='1']").css("display", "none");
    }
    //初始化日期控件
    InitLayDate();

    $("#btn_login").bind("click", function () {
        var userName = $("#tbCode").val();
        var pwd = $("#tbPwd").val();
        var params = new Common.Query.M();
        params.setParameters("userName", userName);
        params.setParameters("pwd", pwd);
        Atour.Ui.Loading("");
        Atour.Ajax.Get({
            Url: "",
            DataParam: params.getString(false),
            Async: true,
            FuncName: "AfterLex"
        });
    });
    $("#selRooms").bind("change", function () {
        var preferentialtypeid = $(".selected").attr("preferentialtype");
        if (preferentialtypeid == 1 && $("#selRooms").val() > 1) {
            Atour.Ui.Alert("使用积分预订，房间数只能为1！");
            $("#selRooms").focus();
            $("#selRooms").val(1);
        }
        reSet();
        ResteMebRoomRate();
    });
    //左侧按钮
    $(".lftselect").bind("click", function () {
        OnLeftorRightClick(-1);
    });
    //右侧按钮
    $(".rghselect").bind("click", function () {
        OnLeftorRightClick(1);
    });
    var nChainID = $("#hidChainID").val();
    var params = new Common.Query.M();
    params.setParameters("chainid", nChainID);
    Atour.Ajax.Get({
        Url: "",
        DataParam: params.getString(false),
        FuncName: "InitChain"
    });

    /********************** 预订日历***********************/
    if ($(".m_help").length > 0) {
        $(".m_bookuser_login").css({ opacity: 0, height: 0 });
        $(".m_help").bind("click", function () {
            $(".m_bookuser_login").removeClass("hide");
            $(".m_bookuser_book").fadeOut();
            $(".m_bookuser_login").animate({ opacity: 1, height: 282 }, 800);
        });
        $("#btn_return").bind("click", function () {
            $(".m_bookuser_login").animate({ opacity: 0, height: 0 }, 800, function () {
                $(".m_bookuser_book").fadeIn();
                $(".m_bookuser_login").addClass("hide");
            });
        });
    }
    if ($(".m_calendar").length > 0) {
        var chainid = $("#hidChainID").val(),
            roomtype = $("#hidRoomType").val(),
            mebtype = $("#hidMebType").val(),
            start = $("#hidStart").val();

        var dt_start = new Date().StringToDate(start.substring(0, 8) + "01");
        //当前选择的月份和日期
        $(".tmonth").each(function (i) {
            var num = i;
            $(this).bind("click", function () {
                Create(dt_start.DateAdd("m", num));
                $(".tmonth").css({ "color": "#000" });
                $(this).css({ "color": "red" });
                //$(".tmonth").eq(num).css({ "color": "red" });
            });
        });
        InitCander(dt_start);
    };

    $(".tblcalendar").on("click", "td", function () {
        if ($(this).hasClass('disabled')) { return false; }
        var date = $(this).attr('endofday');
        var startDate = new Date();
        var MaxDate = startDate.addDay(90).Format("yyyy-MM-dd");
        if (date > MaxDate) {
            Atour.Ui.Msg("只能预订90天内的房 ");
            return;
        }

        if (SelArrDate) {
            SelArrDate = false;
            $('#CheckOutDate').val(date.toDate().addDay(1).Format("yyyy-MM-dd"));
            $('#CheckInDate').val(date);
            //$('.tblcalendar .active:first').addClass('arr_background');
        } else {
            if ($('#CheckInDate').val() >= date) {
                $('#CheckOutDate').val(date.toDate().addDay(1).Format("yyyy-MM-dd"));
                $('#CheckInDate').val(date);
            } else {
                SelArrDate = true;
                $('#CheckOutDate').val(date.toDate().addDay(1).Format("yyyy-MM-dd"));
            }
        };
        RefreshData();
    });
})


SelArrDate = false;

//初始化日期控件
function InitLayDate() {
    laydate.skin('molv');
    var begDate=laydate.now();
    if ($('#CheckInDate').val()) {
        var checkInDate = $('#CheckInDate').val().toDate();
        begDate = checkInDate.Format("yyyy-MM-dd");
	}
    var start = {
        elem: '#CheckInDate',
        format: 'YYYY-MM-DD',
        isclear: false, //是否显示清空
        min: begDate, //设定最小日期为当前日期
        max: laydate.now(+89), //最大日期 
        choose: function (dates) {
            var startDate = dates.toDate();
            var nextDate = startDate.addDay(1).Format("yyyy-MM-dd");
            //var maxDate = startDate.addMonth(3).Format("yyyy-MM-dd");
            end.min = nextDate;//设定最小日期为当前日期
            end.max = laydate.now(+90); //最大日期
            if ($('#CheckOutDate').val() < nextDate) {
                $('#CheckOutDate').val(nextDate).click();
            }
            RefreshData();
        }
    };
    laydate(start);
    var minDate = laydate.now(+1);
    var maxDate = laydate.now(+90);
    if ($('#CheckOutDate').val()) {
//      var checkInDate = $('#CheckInDate').val().toDate();
//      minDate = checkInDate.addDay(1).Format("yyyy-MM-dd");
        // maxDate = checkInDate.addMonth(3).Format("yyyy-MM-dd");
        
        var checkoutdate=$('#CheckOutDate').val().toDate();
        minDate = checkoutdate.Format("yyyy-MM-dd");
    }
    var end = {
        elem: '#CheckOutDate',
        format: 'YYYY-MM-DD',
        isclear: false, //是否显示清空
        istoday: false,//是否显示今天
        min: minDate, //设定最小日期为当前日期
        max: laydate.now(+90), //最大日期 
        choose: function (dates) {
            var startDate = $('#CheckInDate').val().toDate();
            var nextDate = startDate.addDay(1).Format("yyyy-MM-dd");
            var maxDate = startDate.addMonth(3).Format("yyyy-MM-dd");
            if ($('#CheckInDate').val() >= dates) {
                $('#CheckOutDate').val(nextDate);
            }
            if (maxDate < dates) {
                $('#CheckOutDate').val(maxDate);
                Atour.Ui.Alert("入住时间大于三个月，请分多个订单预定。");
            }
            RefreshData();
        }
    };
    laydate(end);

    var checkindate = $("#CheckInDate").val();
    if (checkindate == null || checkindate == undefined || checkindate == "") {
        checkindate = new Date().Format("yyyy-MM-dd");
    }
    $("#CheckInDate").val(checkindate);
    var checkoutdate = $("#CheckOutDate").val();
    if (checkoutdate == null || checkoutdate == undefined || checkoutdate == "") {
        checkoutdate = checkindate.toDate().addDay(1).Format("yyyy-MM-dd");
    }
    $("#CheckOutDate").val(checkoutdate);
}
function RefreshData() {
    $("#tbTotalDays").html(Common.Utils.D.prototype.dayDiff($('#CheckOutDate').val(), $('#CheckInDate').val()));

    var sDate = ($('#CheckInDate').val().substring(0, 8) + "01").toDate();
    var eDate = ($('#CheckOutDate').val().substring(0, 8) + "01").toDate();
    //if ($('#CheckOutDate').val().substring(0, 8) + "01" == $('#CheckOutDate').val()) {eDate.addMonth(-1); }
    $("#hidCurrSelect").val((sDate.Format("yyyy-MM-dd")).toDate().addMonth(-1).Format("yyyy-MM-dd"));
    while (sDate <= eDate) {
        OnLeftorRightClick(1);
        sDate.addMonth(1);
    }
    RefreshSelect();
    reSet();
}


/*会员登录*/
function AfterLex(result) {
    var objData = $.parseJSON(result);
    if (objData != undefined && objData.State == 1) {
        $("#hidMebID").val(objData.Data.MebID);
        $("#hidMebType").val(objData.Data.MebType);
        $("#tbName").val(objData.Data.MebName);
        $("#tbTel").val(objData.Data.Mobile);

        $(".m_help").eq(0).text("切换会员");
        $(".login_place a").eq(0).hide();
        $(".login_place a").eq(1).show();

        $(".m_bookuser_login").animate({ opacity: 0, height: 0 }, 800, function () {
            $(".m_bookuser_book").fadeIn();
            $(".m_bookuser_login").addClass("hide");
        });
        RestRoomRate(objData.Data.MebType);
        ResteMebRoomRate();
        //获取会员可用积分
        getPoint(objData.Data.MebID);
    } else {
        Atour.Ui.Alert("用户登陆失败,请确认用户密码输入正确");
    }
}
function getPoint(mebid) {
    var params = new Common.Query.M();
    params.setParameters("mebid", mebid);
    Atour.Ajax.Get({
        Url: "",
        DataParam: params.getString(false),
        FuncName: "initMebPoint"
    });

}
//初始化积分
function initMebPoint(result) {
    if (result != undefined && result.State == 1) {
        $("#keyon").text(result.Data.PointResidueSum);
        var preferentialtypeid = $(".selected").attr("preferentialtype");
        if (preferentialtypeid == 1 && eval($("#keyon").text()) < eval($("#suoxu").text())) {
            $("#btBook").css("background", "#CCCCCC");
        } else {
            $("#btBook").css("background", "#F75B08");
        }
    }
}

/*日历开始*/
function OnLeftorRightClick(lr) {
    var currDate = $("#hidCurrSelect").val().toDate();
    var serviceDate = $("#hidStart").val().toDate();;
    var show_Date = (lr > 0) ? currDate.DateAdd("m", 1) : currDate.DateAdd("m", -1);//即将要显示的表示
    if (serviceDate.Format("yyyyMM") > show_Date.Format("yyyyMM") && lr < 0) { Atour.Ui.Alert("您选择的时间已经过去很久远了"); return; }
    var show_Month = parseInt(show_Date.Format("yyyyMM"));
    var arrM = [];
    $(".tmonth").each(function (i) {
        var t = parseInt($(this).attr("id"));
        arrM.push(t);
    });
    arrM.sort();
    //Math.Max.Apply(null, arrM);
    var max_Month = Math.max.apply(null, arrM);//获取当前显示排列中最小的值
    var min_Month = Math.min.apply(null, arrM);//获取当前排列中最大的值
    //console.log(min_Month)
    //如果当前选择项目所在为当前可视范围的边界值
    //说明需要对标题进行重新刷新操作
    //增加新的东西的时候，需要为此按钮重新进行事件绑定
    if (min_Month > show_Month || show_Month > max_Month) {
        if (show_Month > max_Month) {
            $("#" + max_Month).after("<b class=\"tmonth\" id=" + show_Month + ">" + show_Date.Format("MM月yyyy") + "</b>");
        }
        if (show_Month < min_Month) {
            $("#" + min_Month).before("<b class=\"tmonth\" id=" + show_Month + ">" + show_Date.Format("MM月yyyy") + "</b>");
        }
        $("#" + show_Month).bind("click", function () {
            Create(show_Date);
            $(".tmonth").css({ "color": "#000" });
            $(this).css({ "color": "red" });
        });
        $(".tmonth").each(function (i) {
            if (i >= 4 && lr < 0)
                $(this).hide();

            if (i < $(".tmonth").length - 4 && lr > 0)
                $(this).hide();
        });
    } else {
        //此时需要判断一下当前元素是否被隐藏
        if ($("#" + show_Month).css("display") == "none") {
            var show_index = $(".tmonth").index($("#" + show_Month));
            $(".tmonth").each(function (i) {
                $(this).hide();

                if (i <= show_index && i > show_index - 4 && lr > 0)
                    $(this).show();

                if (i >= show_index && i < show_index + 4 && lr < 0)
                    $(this).show();
            });
        }
    }
    $("#" + show_Month).click();
}

function InitCander(d_now) {
	var hid =  $("#hidStart").val();
	var dt_start = new Date().StringToDate(hid.substring(0, 8) + "01");
	var ddd = dt_start.Format("yyyyMM");
	var aaa = d_now.Format("yyyyMM");
	if(aaa > ddd){
		var _arDate = [dt_start, dt_start.DateAdd("m", 1), dt_start.DateAdd("m", 2), dt_start.DateAdd("m", 3)]
	}else{
		var _arDate = [d_now, d_now.DateAdd("m", 1), d_now.DateAdd("m", 2), d_now.DateAdd("m", 3)]
		$(".tmonth").each(function (i) {
	        $(this).html(_arDate[i].Format("MM月yyyy"));
	        $(this).attr("id", _arDate[i].Format("yyyyMM"))
	        if (i == 0)
	        	$(this).css({ "color": "red" })
	            //$(this).css({ "color": "red" });
    	});
	}
	
    
    
    Create(d_now);
}

function Create(e) {
    var isFromFirst = true;//是否从当月第一天开始
    if (!e) { return; }
    var f = e.DateAdd("m", 1);
    var _s = e.Format("yyyy-MM-dd");
    var _e = f.Format("yyyy-MM-dd");
    //console.log(_s ,_e);
    $("#hidCurrSelect").val(_s);
    CreateDate(_s, _e);
}

//获取某个房型某个会员类型的价格体系
function CreateDate(e, f) {
    var printDate = new Date(e.replace(/-/g, "/"))
    printDate = new Date(printDate.getFullYear(), printDate.getMonth(), 1);
    var id = printDate.Format("yyyyMM");
    //判断是否已经加载当前月份房态
    if ($("#tbody_0" + id).length > 0) {
        $(".tblcalendar tbody").hide();
        $("#tbody_0" + id).show();
        return;
    }
	var CheckI = $("#CheckInDate").val();
	var CheckO = $("#CheckOutDate").val();
    var nChainID = $("#hidChainID").val();
    var xymcode = $("#xymcode").val();
    nRoomType = $("#hidRoomType").val();
    var selRoom = $("#selRoom").val();
    var roomnum = $("#selRooms").val();
    var id = $("#tbRoomTypeName").attr("ref");
    /***房态度数据加载***/
    var data = new Common.Query.M();
    data.setParameters("chainid", nChainID);
    //暂时取到的是手机官网的图片 主题为2
    data.setParameters("id", id);
    data.setParameters("roomnum", roomnum);
    data.setParameters("CheckI", CheckI);
    data.setParameters("CheckO", CheckO);
    data.setParameters("selRoom", selRoom);
    data.setParameters("xymcode",xymcode);
    data.setParameters("roomtype", nRoomType);
    data.setParameters("start", e);
    data.setParameters("end", f);
    Atour.Ajax.Get({
        Url: "index.php?g=Portal&m=Book&a=GetCanderData",
        DataParam: data.getString(false),
        FuncName: "CreateHtml",
        FuncParams: { d: printDate, isfirst: true, autoselect: true }
    });

}

function CreateHtml(result, d, isfirst, autoselect) {
	var resobj=eval('(' + result + ')');
	$("#tbShowRate").html("门市：￥" + resobj.aaa);
    $("#tbCardMeb").html("官网预订" + "：￥" + resobj.aaa);
	$("#tbPay").html(resobj.aaa + "元");
    $(".m_calendar").calendar(resobj, d, isfirst);
    if (autoselect) {
        RefreshSelect();
    };
}

function RefreshSelect(type) {
    var checkOutDate = $('#CheckOutDate').val();
    var checkInDate = $('#CheckInDate').val();
    $('.tblcalendar td').removeClass("active");
    var t = Common.Utils.D.prototype.dayDiff(checkOutDate, checkInDate);
    $('.tblcalendar td').each(function () {
        if (checkInDate <= $(this).attr('endofday') && $(this).attr('endofday') < checkOutDate) {
            whenTdClick($(this));
        }
    });
    //$(".arr_background").removeClass('arr_background');
    //$(".out_background").removeClass('out_background');
    //if (t > 1) {

    //    $('.tblcalendar .active:first').addClass('arr_background');
    //    $('.tblcalendar .active:last').addClass('out_background');
    //} 
    ResteMebRoomRate();
}

/*----------日历结束*/

function InitChain(result) {
    if (result != undefined && result.State == 1 && result.Data != undefined) {
        $("#bTitle").html(result.Data.ChainName);
    } else { $("#bTitle").html(); }
}

/*----------分店结束*/
/*预订开始*/
var isBook = false;
function Booking() {
    var preferentialtypeid = $(".selected").attr("preferentialtype");
    if (preferentialtypeid == 1 && eval($("#keyon").text()) < eval($("#suoxu").text())) {
        Atour.Ui.Alert("您的可用积分不足");
        return false;
    }
    if (isBook) { Atour.Ui.Alert("请勿重复提交订单"); return; }
    isBook = true;
    var nChainID = $("#hidChainID").val();
    if (!checkMeb()) { isBook = false; return; }
    var f = folio();
    var g = grest();
    var _t = arr();
    if (!checkFolio(f)) {
        isBook = false;
        Atour.Ui.Alert("敬爱的客人，预订的过程中发生错误，请您稍后再试!");
    }
    if (_t == undefined || _t.length == 0) {
        isBook = false;
        Atour.Ui.Alert("您还未选中入住日期");
    }
    var data = { "ChainID": nChainID, "FolioDetail": f, "LsGrest": g, "BookDays": _t }
    var _load = layer.load("订单提交中，请稍后...", 15);
    $.ajax({
        type: 'POST',
        url: "index.php?g=Portal&m=Book&a=Booking",
        success: function (s) {
            var sErr = "";
            var sSucc = "";
            var sTips = "{0}--{1} {2}";
            var sFolioID = 0;
            var arrFolio = [];
            arrFolio.push(0);
            if (s != null && s != undefined) {
                if (s.State == 1) {
                    if (s.Data != undefined) {
                        for (var i = 0; i < s.Data.length; i++) {
                            var __r = s.Data[i];
                            var __arr = new Date().StringToDate(__r.BookDate.ArrDay);
                            var __dep = new Date().StringToDate(__r.BookDate.DepDay);
                            if (parseInt(__r.FolioID) > 0) {
                                sSucc += sTips.formatStr(__arr.Format("yyyy年MM月dd日"), __dep.Format("yyyy年MM月dd日"), "预订成功</br>");
                                arrFolio.push(__r.FolioID);
                            } else {
                                if (__r.IsShow == 1)
                                    sErr += sTips.formatStr(__arr.Format("yyyy年MM月dd日"), __dep.Format("yyyy年MM月dd日"), __r.ErrInfo + "</br>");
                                else
                                    sErr += sTips.formatStr(__arr.Format("yyyy年MM月dd日"), __dep.Format("yyyy年MM月dd日"), "没有足够房间</br>");
                            }
                        }

                        if (sErr != undefined && sErr != "") {
                            isBook = false;
                            Atour.Ui.Alert(sErr);
                        }

                        if (arrFolio.length > 1) {
                            sFolioID = arrFolio.join(",");
                            $("#folioid").val(sFolioID);
                            var _url = "/order/orderprev?t=" + new Date().getTime();
                            $("#fsub")[0].action = _url;
                            if (sErr == "")
                                $("#fsub").submit();
                            else
                                setTimeout(onpost, 3000);

                            return;
                        }

                    }
                } else {
                    isBook = false;
                    if (s.ErrCode == 202)
                        Atour.Ui.Alert(s.ErrMsg);
                    else
                        Atour.Ui.Alert("预订失败");
                }
            } else {
                isBook = false;
                Atour.Ui.Alert("预订失败，请您稍后再试");
            }

            if (sErr != "") {
                isBook = false;
                Atour.Ui.Alert(sErr);
            }
        },
        data: data,
        dataType: "json"
    });
}

function onpost() {
    $("#fsub").submit();
}

function checkFolio(f) {
    if (f == undefined || f == null) { return false; }
    if (f.ChainID <= 0) { return false; }
    if (f.RoomTypeID <= 0) { return false; }
    if (f.nRoomCount <= 0) { return false; }
    if (f.Name == f.Mobile && f.Name == "") { return false; }
    return true;
}

function checkMeb() {
    if (dataBk == undefined || dataBk.length <= 0) {
        Atour.Ui.Alert("请选择入住时间");
        return false;
    }
    if ($("#tbName").val() == "") {
        Atour.Ui.Alert("请填写联系人名称")
        $("#tbName").focus();
        return false;
    }
    if ($("#tbTel").val() == "") {
        Atour.Ui.Alert("联系人手机未填写");
        $("#tbTel").focus();
        return false;
    }
    return true;
}

function folio() {
    var nChainID = $("#hidChainID").val();
    var nRoomTypeID = $("#hidRoomType").val();
    var nMebID = $("#hidMebID").val();
    var nMebType = $("#hidMebType").val();
    var dRoomRate = 0;
    var nRoomCount = $("#selRooms").val();
    var sRoom = $("#hidRooms").val();
    var arrDay = "";
    var depDay = "";
    var sName = $("#tbName").val();
    var sContractName = $("#tbName").val();
    var sMobile = $("#tbTel").val();
    var sEmail = "";
    var sRemark = $("#tbRemark").val();
    var nMark = 0;
    var invoice = Invoice_INFO.invoice;
    var preferentialtypeid = $(".selected").attr("preferentialtype");
    //积分兑换
    if (preferentialtypeid == 1) {
        //市场活动id
        nMark = 33;
        //不开发票
        invoice = "";
    }
    if (nRoomTypeID == 10) { nMark = 3; }


    return {
        "ChainID": nChainID,
        "RoomTypeID": nRoomTypeID,
        "MarketID": nMark,
        "MebID": nMebID,
        "MebTypeID": nMebType,
        "MebProperty": "",
        "MebPropertyTypeID": "0",
        "RoomRate": dRoomRate,
        "RoomCount": nRoomCount,
        "Arrival": arrDay,
        "Depart": depDay,
        "Name": sName,
        "ContractName": sContractName,
        "Mobile": sMobile,
        "EMail": sEmail,
        "Remark": sRemark,
        "SourceID": "0",
        "SubSourceID": "0",
        "RoomNo": sRoom,
        "invoice": invoice
    }
}

function grest() {
    var sContractName = $("#tbName").val();
    var sMobile = $("#tbTel").val();
    var g = []
    g.push({ "Name": sContractName, "Mobile": sMobile });
    return g;
}

function arr() {
    if (dataBk == undefined || dataBk.length <= 0) { return []; }
    var t = []
    var _d = $("#hidCode").val();
    var preferentialtypeid = $(".selected").attr("preferentialtype");
    //积分兑换
    if (preferentialtypeid == 1) {
        _d = "";
    }
    var sDate = $('#CheckInDate').val().toDate();
    var eDate = $('#CheckOutDate').val().toDate();
    t.push({ "ArrDay": sDate.Format("yyyy-MM-dd 18:00:00"), "DepDay": eDate.Format("yyyy-MM-dd 12:00:00"), "DisCode": _d })
    //for (var i = 0; i < dataBk.length; i++) {
    //    var m_day = dataBk[i];
    //    if (i != 0) { _d = ""; }
    //    t.push({ "ArrDay": m_day.b.Format("yyyy-MM-dd 18:00:00"), "DepDay": m_day.e.Format("yyyy-MM-dd 12:00:00"), "DisCode": _d })
    //}
    return t;
}

/*预订结束*/



function whenTdClick(obj, selone) {
    _selectData = []
    var isAdd = 0;
    if (obj.hasClass("full")) { return; }
    if (!selone) {//如果设置只允许一次只传递一个参数
        if (obj.hasClass("active")) {
            obj.removeClass("active");
        } else {
            obj.addClass("active");
        }
    } else {
        //只选择一个
        $(".tblcalendar .active").each(function (i) {
            $(this).removeClass("active");
        });
        obj.addClass("active");
    }

    ////此处计算一下总房价 以及总的房价类型
    var total_dasy = 0;
    $(".tblcalendar .active").each(function (i) {
        var data = $(this).attr("endofday");
        total_dasy++;
        _selectData.push({ endofday: data });
        _selectData.sort();
    });
    //$("#tbTotalDays").html(total_dasy);
    if (total_dasy == 0) {
        $("#tbTips").html("您还没有选择日期 ");
        $("#tbTotalDays").html(" ");

    }
    CreateData();
}

//此处需要存放当前的所有日期
var _selectData = [];
var dataBk = [];
function CreateData() {
    var _dataBk = []
    dataBk = [];
    if (_selectData.length <= 0) { ResteMebRoomRate(); return 0; }
    for (var i = 0; i < _selectData.length; i++) {
        var _codata = new Date().StringToDate(_selectData[i].endofday);
        var __codata = new Date().StringToDate(_selectData[i].endofday);
        __codata.addDay(1)
        var data = { b: _codata, e: __codata, bk: _codata.getTime(), ek: __codata.getTime() };
        _dataBk.push(data);
    }
    _dataBk.sort(function (x, y) { return x.bk > y.bk ? 1 : -1 });

    var sMsg = "";
    var _max = 0;
    for (var j = 0; j < _dataBk.length; j++) {
        var _bk = _dataBk[j];
        if (_bk.bk <= _max) { continue; }
        var _ek = m_GetDate(_bk.ek, _dataBk)
        if (_ek) {
            dataBk.push({ b: _bk.b, e: _ek.e, bk: _bk.bk, ek: _ek.ek });
            _max = _ek.ek;
        } else {
            dataBk.push(_bk);
        }

    }
    dataBk.sort(function (x, y) { return x.bk > y.bk ? 1 : -1 });
    //var tDays = 0;
    for (var __index = 0; __index < dataBk.length; __index++) {
        var _bkmsg = dataBk[__index];
        // tDays += Math.abs(_bkmsg.ek - _bkmsg.bk) / (1000 * 60 * 60 * 24);
        sMsg += _bkmsg.b.Format("yyyy年MM月dd日") + "入住   " + _bkmsg.e.Format("yyyy年MM月dd日") + "离店<br/>";
    }
    ResteMebRoomRate();
    //CreatePrintMsg(sMsg);
}

//组织信息
function CreatePrintMsg(msg) {
    $("#tbTips").html(msg)

}

function m_GetDate(ek, _xd) {
    var obj = null;
    for (var i = 0; i < _xd.length; i++) {
        var c = _xd[i];
        //已经被选则了
        //这样就结束了？ 别开玩笑了。
        if (c.bk == ek) {
            obj = m_GetDate(c.ek, _xd);
            if (obj == null)
                obj = c;
        }
    }
    return obj;
}

//重置TD价格
function RestRoomRate(cal_mebtype) {
    if (cal_mebtype != undefined) {
        //重新设置每个TD的价格
        $(".tblcalendar>tbody>tr>td").each(function () {
            var obj_tag = "notmeb";
            for (var i = 0; i < mt_rate_meb.length; i++) {
                var obj = mt_rate_meb[i];
                if (obj.m == cal_mebtype) {
                    obj_tag = obj.tag;
                    break;
                }
            }
            var _rateoftag = $(this).attr(obj_tag)
            if (_rateoftag != undefined) {
                if (parseInt(_rateoftag) > 0) {
                    $(this).find("b").eq(1).html("￥" + _rateoftag);
                    $(this).attr("mebrate", _rateoftag);
                }
            }
        });
    }
}

function CalDisQune() {
    var nDisType = $("#hidDisType").val();
    var nDisValue = $("#hidDisValue").val();
    //var sCode = $("#hidCode").val();
    //if (sCode != undefined && sCode != "") {
    //    if (nDisType > 0) {
    //        if (nDisType == 1) { return -99999; }
    //        if (nDisType == 2) { return -1 * Math.abs(nDisValue); }
    //    }
    //}
    return parseInt(-1 * nDisValue);
}

//重置会员价格类型
function ResteMebRoomRate() { //此处计算一下总房价 以及总的房价类型
    var total_rate = 0;
    var nMebType = $("#hidMebType").val();
    var total_rate = 0;
    var total_rate_menshi = 0;
    var total_dis = 0;
    var nRoomCount = $("#selRooms").val();
    if (nRoomCount > 5) { nRoomCount = 5; $("#selRooms").val(nRoomCount); }
    total_dis = CalDisQune();
    var mintime = 9919436800000;
    var _firstrate = 0;//首晚房价

    var sleng = $(".tblcalendar .active").length;

    if (sleng > 1) {
        $(".tblcalendar .active").each(function (i) {
            var _mshirate = $(this).attr("mshi");
            var min_date = $(this).attr("endofday");
            var _t = new Date();
            if (_mshirate == undefined)
                _mshirate = 999;
            total_rate_menshi += parseFloat(_mshirate);
            total_rate += parseFloat($(this).attr("mebrate"));
        });
    } else {
        $(".tblcalendar .active").each(function (i) {
            var _mshirate = $(this).attr("mshi");
            var min_date = $(this).attr("endofday");
            var _t = new Date();
            if (_mshirate == undefined)
                _mshirate = 999;
            total_rate_menshi += parseFloat(_mshirate);
            total_rate += parseFloat($(this).attr("mebrate"));
        });
    }

    total_rate_menshi = total_rate_menshi * nRoomCount;
    total_rate_menshi = total_rate.toFixed(1);
    total_rate = total_rate * nRoomCount;
	total_rate = total_rate.toFixed(1);
//  $("#tbShowRate").html("门市：￥" + total_rate_menshi);
//  $("#tbCardMeb").html(getCurrMebName(nMebType) + "：￥" + total_rate);
    var _pay = total_rate;
    var _jieshen = total_rate_menshi - total_rate;
    _pay = total_rate + total_dis;
    if (total_dis == -99999) {
        _pay = total_rate - _firstrate;//免返券，需要这样减去
        _jieshen = total_rate_menshi - _pay;
    }
    else {
        _pay = total_rate + total_dis;
        _jieshen = total_rate_menshi - total_rate - total_dis;
    }
    if (_pay < 0) { _pay = 0; }
    if (_jieshen < 0) { _jieshen = total_rate_menshi; }
//    $("#tbPay").html(_pay + "元");
    $("#tbJie").html("已节省" + _jieshen + "元");
    $("#suoxu").text(total_rate_menshi / 0.04);

    var preferentialtypeid = $(".selected").attr("preferentialtype");
    if (preferentialtypeid == 1 && eval($("#keyon").text()) < eval($("#suoxu").text())) {
        $("#btBook").css("background", "#CCCCCC");
    } else {
        $("#btBook").css("background", "#F75B08");
    }
}
function getCurrMebName(_mebtype) {
    //debugger
    if (mt_rate_meb != undefined) {
        for (var i = 0; i < mt_rate_meb.length; i++) {
            var obj = mt_rate_meb[i];
            if (obj.m == parseInt(_mebtype)) {
                $("#tbMebDesc").html(obj.tips);
                return obj.name;
            }
        }
    }
    return "首次预订";
}

// 查询当前登陆优惠优惠券
function QueryMebCounp() {
    var preferentialtypeid = $(".selected").attr("preferentialtype");
    $(".point").css("display", "none");
    $("#OpenInvoice").css("color", "#f75b08");
    $("#OpenInvoice").css("border", "1px solid #FF0000");
    $("#btBook").css("background", "#F75B08");
    //选中变未选中
    $("b[preferentialtype='2']").removeClass("notselected").addClass("selected");
    $("b[preferentialtype='1']").removeClass("selected").addClass("notselected");
    var rmParams = new Common.Query.M();
    var mebID = $("#hidMebID").val();
    if (mebID == "" || mebID == undefined || mebID == "0") {
        $("#cf").html("");
        openlay();
        return;
    }
    // 查询优惠券
    var rmParams = new Common.Query.M();
    rmParams.setParameters("mebid", mebID);
    rmParams.setParameters("chainid", $("#hidChainID").val());
    rmParams.setParameters("pagesize", 999);
    rmParams.setParameters("pageno", 1);
    Atour.Ajax.Get({
        Url: "",
        DataParam: rmParams.getString(false),
        FuncName: "CounpsCallBack",
        FuncParams: "data"
    });
}

// 查询优惠券回调函数
function CounpsCallBack(data) {
    var _data = '<input type="hidden" class="data"   dataid="{0}" dataname="{1}" datacode="{2}" value="{3}" datatype="{4}"  />'
    var _li = '<li class="{3}" ><div class="title">{0}元</div><div class="c_date"><b>有效期</b><b>{1}</b>{2}</div></li>';
    var _li_m = '<li class="{2}" ><div class="title">免房券</div><div class="c_date"><b>有效期</b><b>{0}</b>{1}</div></li>';
    $("#cf").html("");
    if (data.State == 1) {
        if (data.Data.DataSet.length > 0) {
            data.Data.DataSet = getDiscoupSort(data.Data.DataSet);
            $.each(data.Data.DataSet, function (key, val) {
                if (val.DisType != 7) {
                    var a_li = "";
                    var b = _data.formatStr(val.DiscountID, val.DisTypeName, val.Code, val.Value, val.DisCountCouponsType);
                    if (val.DisCountCouponsType == 1)
                        a_li = _li_m.formatStr(val.EndDate.substring(0, 10), b, check_counp_can_use(val) ? '' : 'no_used');
                    else {
                        a_li = _li.formatStr(val.Value, val.EndDate.substring(0, 10), b, check_counp_can_use(val) ? '' : 'no_used');
                    }
                    if (val.DisCountCouponsType != 1 && Math.abs(val.Value) == 0) {
                        a_li == "";
                    }
                    $("#cf").append(a_li);
                }
            });

        }
        var dcode = "";
        bindDisCount();

        //if (!isBeMeb && scode != "") { $("#hdDicCode").val(scode); }
        openlay();
    } else {
        openlay();
    }
}

function bindDisCount() {
    $("#cf").children("li").each(function () {
        //设置被选
        var codelist = $("#hidCode").val();
        dcode = $(this).find("input").attr("datacode");
        if (dcode != '' && codelist.indexOf(dcode) >= 0) {
            $(this).addClass("active")
        }
        $(this).unbind("click")
        //设置绑定
        $(this).bind("click", function () {
            if ($(this).hasClass("no_used")) {
                return false;
            }
            $(".validform_checktip").removeClass("validform_right");
            $(".validform_checktip").removeClass("validform_wrong");
            $("#hdDicCode").val(" ");
            $(".validform_checktip").html(" ");
            if ($(this).attr("class") == "active") {
                $(this).attr("class", " ");
                var datacode = [];
                var disvalue = 0;
                $('#cf .active').each(function () {
                    var obj = $(this).find("input");
                    datacode.push(obj.attr("datacode"));
                    if (obj.attr('datatype') == 1) {
                        disvalue += parseInt(getRoomRate($('#CheckInDate').val()));
                    } else {
                        disvalue += parseInt(obj.val());
                    }
                })
                $("#hidCode").val(datacode.join(','));
                $("#hidDisType").val(0);
                $("#hidDisValue").val(disvalue);
                $("#hidDisCount").val($("#cf").children(".active").length);
                return;
            }
            if ($("#cf").children(".active").length >= parseInt($('#tbTotalDays').html()) * parseInt($('#selRooms').val())) {
                return;
            }

            //$("#cf").children("li").each(function () {
            //    $(this).removeClass("active");
            //});
            $(this).addClass("active");
            var datacode = [];
            var disvalue = 0;
            $('#cf .active').each(function () {
                var obj = $(this).find("input");
                datacode.push(obj.attr("datacode"));
                if (obj.attr('datatype') == 1) {
                    disvalue += parseInt(getRoomRate($('#CheckInDate').val()));
                } else {
                    disvalue += parseInt(obj.val());
                }
            })
            $("#hidCode").val(datacode.join(','));
            //$("#hidDisType").val(obj.attr("datatype"));
            $("#hidDisValue").val(disvalue);
            $("#hidDisCount").val($("#cf").children(".active").length);
            return false;
        });
    });
}
//当点击时间发生
function whenClickDis(index) {
    //重置房价
    if ($("#hidCode").val() != "") {
        var nDisType = $("#hidDisType").val();
        var nDisValue = $("#hidDisValue").val();
        var nDisCode = $("#hidDisCount").val();
        if (nDisType == 1) {
            $(".coupon").find("span").html("您使用了一张免房券");
        } else {
            $(".coupon").find("span").html("您使用了" + nDisCode + "张优惠券共优惠" + nDisValue + "元");
        }
    }
    else {
        $(".coupon").find("span").html("");
    }
    var start = $("#CheckInDate").val();
	var dt_start = new Date().StringToDate(start.substring(0, 8) + "01");
	var e=dt_start.Format("yyyy-MM-dd");
	var printDate = new Date(e.replace(/-/g, "/"))
    printDate = new Date(printDate.getFullYear(), printDate.getMonth(), 1);
    var id = printDate.Format("yyyyMM");
    $("#tbody_0" + id).remove();
    //$("tbody[id*='tbody_0']").remove();
	InitCander(dt_start);
	$(".tmonth").css({ "color": "#000" });
    $("#"+id).css({ "color": "red" });
    ResteMebRoomRate();
    layer.close(index)

}
//获取抵用券
function checkDis(obj) {
    var d_code = $.trim($(obj).val());
    if (d_code == "") {
        $(".validform_checktip").removeClass("validform_wrong");
        return;
    }
    //$("#cf").children("li").each(function () {
    //    $(this).removeClass("active");
    //});
    var params = new Common.Query.M();
    params.setParameters("code", d_code);
    params.setParameters("chainid", $("#hidChainID").val());
    Atour.Ajax.Get({
        Url: "",
        DataParam: params.getString(false),
        FuncName: "init_disCar"
    });
}
///实例化券
function init_disCar(result) {
    $('.xubox_yes').css("pointer-events", "");
    $("#hidCode").val("");
    $("#hidDisType").val(0);
    $("#hidDisValue").val(0);
    if (result != undefined) {
        if (result.State == 1 && result.Data != undefined) {
            var _data = '<input type="hidden" class="data"   dataid="{0}" dataname="{1}" datacode="{2}" value="{3}" datatype="{4}"  />'
            var _li = '<li class="{3}" ><div class="title">{0}元</div><div class="c_date"><b>有效期</b><b>{1}</b>{2}</div></li>';
            var _li_m = '<li class="{2}" ><div class="title">免房券</div><div class="c_date"><b>有效期</b><b>{0}</b>{1}</div></li>';

            var a_li = "";
            var val = result.Data;
            if ($('input[datacode=' + val.Code + ']').length == 0) {
                var b = _data.formatStr(val.DiscountID, val.DisTypeName, val.Code, val.Value, val.DisCountCouponsType);
                if (val.DisCountCouponsType == 1)
                    a_li = _li_m.formatStr(val.EndDate.substring(0, 10), b, check_counp_can_use(val) ? '' : 'no_used');
                else {
                    a_li = _li.formatStr(val.Value, val.EndDate.substring(0, 10), b, check_counp_can_use(val) ? '' : 'no_used');
                }
                if (val.DisCountCouponsType != 1 && Math.abs(val.Value) == 0) {
                    a_li == "";
                }
                $("#cf").append(a_li).scrollTop(999);
                bindDisCount();
            }
            $(".validform_checktip").removeClass("validform_wrong");
            $(".validform_checktip").addClass("validform_right");
            $(".validform_checktip").html(result.Data.DisTypeName + "已添加,请选择使用。");
        } else {
            var errmsg = "优惠券不存在";
            if (result.ErrCode == "201")
                errmsg = result.ErrMsg;

            $(".validform_checktip").removeClass("validform_right");
            $(".validform_checktip").addClass("validform_wrong");
            $(".validform_checktip").html(errmsg);
        }
    } else {

        $(".validform_checktip").removeClass("validform_right");
        $(".validform_checktip").addClass("validform_wrong");
        $(".validform_checktip").html("优惠券不存在");
    }
}

function openlay() {
    $.layer({
        type: 1,
        shade: [0],
        title: ['使用优惠券', 'background:#fff;'],
        area: ['auto', 'auto'],
        border: [0],
        offset: ['50px', ''],
        shade: [0.3, '#000'],
        fadeIn: 300,
        btns: 2,
        btn: ['确定', '取消'],
        yes: function (index) {
            whenClickDis(index);
            if ($("#hidCode").val() == "") {
                $("b[preferentialtype='2']").removeClass("selected").addClass("notselected");
            }
        },
        close: function (index) {
            reSet();
        },
        no: function (index) {
            reSet();
        },
        page: { dom: '.couponlst' }
    });
    $('#coup_daynum').html($('#tbTotalDays').html());
    $('#coup_roomnum').html($('#selRooms').val());
    $('#coup_num').html(parseInt($('#tbTotalDays').html()) * parseInt($('#selRooms').val()));
}

function reSet(index) {
    $("#hidCode").val("");
    $("#hidDisType").val(0);
    $("#hidDisValue").val(0)
    $("b[preferentialtype='2']").removeClass("selected").addClass("notselected");
    whenClickDis(index);
}

function check_counp_can_use(counp) {
    var sDate = $('#CheckInDate').val().toDate();
    var eDate = $('#CheckOutDate').val().toDate();
    if (counp.EndDate < sDate.Format("yyyy-MM-dd")) return false;
    while (sDate < eDate) {
        if (counp.IsLock == 1) return false;
        if (counp.Weeks && counp.Weeks.indexOf(sDate.getDay()) == -1) return false;
        if (counp.HoliDay && counp.HoliDay.indexOf(sDate.Format("yyyy-MM-dd")) != -1) return false;
        sDate = sDate.addDay(1);
    }
    return true;
}

var dis_desc = function (a, b) {
    if (a.Value == b.Value) {
        return a.EndDate < b.EndDate ? -1 : 1;
    } else {
        return a.Value > b.Value ? -1 : 1;
    }
}

var getDiscoupSort = function (Discoups) {
    var Discoups = Discoups.sort(dis_desc);
    var noRate = [];
    var hasRate = [];
    $.each(Discoups, function (a, b) {
        if (b.DisCountCouponsType == 1) {
            noRate.push(b);
        } else {
            hasRate.push(b);
        }
    })
    Discoups = noRate.concat(hasRate);
    return Discoups;
}


function getRoomRate(endofdate) {
    var mebtype = $('#hidMebType').val();
    var obj = $('.tblcalendar td[endofday=' + endofdate + ']');
    if (mebtype == 0) return obj.attr('notmeb');
    if (mebtype == 1) return obj.attr('yk');
    if (mebtype == 2) return obj.attr('jk');
    if (mebtype == 3) return obj.attr('bj');
}

/*发票开始*/

//发票信息
var Invoice_INFO = {
    rise: '',
    taxpayer: '',
    bankAddress: '',
    bankCard: '',
    busiAddress: '',
    invoicePhone: '',
    invoice: ''
};

// 查询发票
function QueryInvoice() {
    var preferentialtypeid = $(".selected").attr("preferentialtype");
    //选中变未选中
    if (preferentialtypeid == 1) {
        Atour.Ui.Alert("使用积分不能开发票！");
        return false;
    }
    //会员ID
    var mebID = $("#hidMebID").val();
    var rmParams = new Common.Query.M();
    if (mebID == "" || mebID == undefined || mebID == "0") {
        openlayInvoice();
        return;
    }
    else {
        rmParams.setParameters("mebid", mebID);
        Atour.Ajax.Get({
            Url: "",
            DataParam: rmParams.getString(false),
            FuncName: "InvoiceCallBack",
            FuncParams: "data"
        });
    }
}
// 查询发票回调函数
function InvoiceCallBack(data) {
    if (data.State == 1) {
        if (data.Data.length > 0) {
            debugger
            $.each(data.Data, function (key, val) {
                if (val.PropertyTypeID == 12) {
                    $("#riseOrd").val(val.Value)
                    $("#risePre").val(val.Value)
                    Invoice_INFO.rise = val.Value
                }
                if (val.PropertyTypeID == 13) {
                    $("#taxpayer").val(val.Value)
                    Invoice_INFO.taxpayer = val.Value
                }
                if (val.PropertyTypeID == 14) {
                    $("#bankAddress").val(val.Value)
                    Invoice_INFO.bankAddress = val.Value
                }
                if (val.PropertyTypeID == 15) {
                    $("#bankCard").val(val.Value)
                    Invoice_INFO.bankCard = val.Value
                }
                if (val.PropertyTypeID == 16) {
                    $("#busiAddress").val(val.Value)
                    Invoice_INFO.busiAddress = val.Value
                }
                if (val.PropertyTypeID == 17) {
                    $("#invoicePhone").val(val.Value)
                    Invoice_INFO.invoicePhone = val.Value
                }
            });
        }
        openlayInvoice();
    } else {
        openlayInvoice();
    }
}
//弹窗
function openlayInvoice() {
    $.layer({
        type: 1,
        shade: [0],
        title: ['开发票', 'background:#fff;'],
        area: ['auto', 'auto'],
        border: [0],
        offset: ['50px', ''],
        shade: [0.3, '#000'],
        fadeIn: 300,
        btns: 2,
        btn: ['确定', '取消'],
        yes: function (index) {
            debugger
            setInvoice_INFO();
            if (checkData()) {
                //会员ID
                var mebID = $("#hidMebID").val();
                if (mebID != "" && mebID != undefined && mebID != "0") {
                    ChangInvoiceProperty(index);
                }
                if (whichTab() == 1) {
                    $("#OpenInvoice").text("<普通发票>")
                }
                else if (whichTab() == 2) {
                    $("#OpenInvoice").text("<专用发票>")
                }
                layer.close(index)
            }
        },
        close: function (index) {
        },
        no: function (index) {
        },
        page: { dom: '#Invoice' }
    });
}
//检查数据
function checkData() {
    var data = Invoice_INFO;
    if (this.whichTab() == 1) {
        if (!check(data.rise)) {
            Atour.Ui.Alert("请填写发票抬头");
            $("#riseOrd").focus();
            return false;
        }
    }
    else if (this.whichTab() == 2) {
        if (!check(data.rise)) {
            Atour.Ui.Alert("请填写发票抬头");
            $("#risePre").focus();
            return false;
        }
        if (!check(data.taxpayer)) {
            Atour.Ui.Alert("请填写纳税人识别号");
            $("#taxpayer").focus();
            return false;
        }
        if (!check(data.bankAddress)) {
            Atour.Ui.Alert("请填写开户行");
            $("#bankAddress").focus();
            return false;
        }
        if (!check(data.bankCard)) {
            Atour.Ui.Alert("请填写开户行账号");
            $("#bankCard").focus();
            return false;
        }
        if (!check(data.busiAddress)) {
            Atour.Ui.Alert("请填写经营地址");
            $("#busiAddress").focus();
            return false;
        }
        if (!check(data.invoicePhone)) {
            Atour.Ui.Alert("请填写联系电话");
            $("#invoicePhone").focus();
            return false;
        }
    }
    return true;
}
//检查
function check(value) {
    if (value == null || value == undefined || value == '') {
        return false;
    }
    return true;
}
//选中tab
function whichTab() {
    if ($("#tab1:checked").val() != null && $("#tab1:checked").val() != undefined) {
        return 1;
    }
    else if ($("#tab2:checked").val() != null && $("#tab2:checked").val() != undefined) {
        return 2;
    }
};
//设置发票信息
function setInvoice_INFO() {
    if (this.whichTab() == 1) {
        Invoice_INFO.rise = $("#riseOrd").val();
        Invoice_INFO.invoice = "普通发票>发票抬头:" + Invoice_INFO.rise;
    }
    else if (this.whichTab() == 2) {
        Invoice_INFO.rise = $("#risePre").val();
        Invoice_INFO.taxpayer = $("#taxpayer").val();
        Invoice_INFO.bankAddress = $("#bankAddress").val();
        Invoice_INFO.bankCard = $("#bankCard").val();
        Invoice_INFO.busiAddress = $("#busiAddress").val();
        Invoice_INFO.invoicePhone = $("#invoicePhone").val();
        Invoice_INFO.invoice = "专用发票>发票抬头:" + Invoice_INFO.rise + ";  纳税人识别号:" + Invoice_INFO.taxpayer + ";  开户行:" + Invoice_INFO.bankAddress + ";  开户行账号:" + Invoice_INFO.bankCard + ";  经营地址:" + Invoice_INFO.busiAddress + ";  发票联系电话:" + Invoice_INFO.invoicePhone;
    }
}
// 异步操作发票会员属性
function ChangInvoiceProperty(index) {
    //会员ID
    var mebID = $("#hidMebID").val();
    var rmParams = new Common.Query.M();
    rmParams.setParameters("mebid", $("#hidMebID").val());
    rmParams.setParameters("MebInvoice", JSON.stringify(Invoice_INFO));
    Atour.Ajax.Post({
        Url: "",
        DataParam: rmParams.getString(false),
        FuncName: "ChangInvoicePropertyCallBack",
        FuncParams: "data"
    });

}
//发票会员属性回调函数
function ChangInvoicePropertyCallBack(data) {
    if (data.State == 1) {
        if (!data.Data) {
            Atour.Ui.Alert("更改发票失败");
        }
    }
    else {
        Atour.Ui.Alert(data.ErrMsg);
    }

}
/*发票结束*/

// 查询当前登陆会员积分
function QueryMebPoint() {
    var preferentialtypeid = $(".selected").attr("preferentialtype");
    //选中变未选中
    if (preferentialtypeid == 1) {
        $(".point").css("display", "none");
        $("b[preferentialtype='1']").removeClass("selected").addClass("notselected");
        $("#OpenInvoice").css("color", "#f75b08");
        $("#OpenInvoice").css("border", "1px solid #FF0000");
        $("#btBook").css("background", "#F75B08");
    } else {
        if ($("#selRooms").val() > 1) {
            Atour.Ui.Alert("使用积分预订，房间数只能为1！");
            $("#selRooms").focus();
            return false;
        }
        $(".point").css("display", "block");
        $("b[preferentialtype='1']").removeClass("notselected").addClass("selected");
        $("b[preferentialtype='2']").removeClass("selected").addClass("notselected");
        $("#OpenInvoice").css("color", "#cccccc");
        $("#OpenInvoice").css("border", "1px solid #cccccc");
        if (eval(eval($("#keyon").text())) < eval(eval($("#suoxu").text()))) {
            $("#btBook").css("background", "#CCCCCC");
        } else {
            $("#btBook").css("background", "#F75B08");
        }
        reSet();
    }
}