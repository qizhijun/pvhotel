$(document).ready(function () {
    YD.HotelDefault.Init();
    YD.HotelDefault.InitLayDate();
    YD.HotelDefault.InitSerchBar();
    YD.HotelDefault.QueryChain();

    $(".hotel_list").on("click", ".hotel_item tr", function () {
        var id = $(this).attr("id");
        if (id != null) {
            $("tr[class='" + id + "']").toggle("slow");
        }
        if ($(this).find("img").attr("src") != null && $(this).find("img").attr("src").indexOf("down") > 0) {
            $(this).find("img").attr("src", "/Skin/images/arrow_right.ico");
        } else {
            $(this).find("img").attr("src", "/Skin/images/arrow_down.ico");
        }
    })
    $(".hotel_list").on("click", "tfoot a", function () {
        $(this).parents("table").find("tbody tr[class='hide']").each(function () {
            var id = $(this).attr("id");
            $(this).find("img").attr("src", "/Skin/images/arrow_right.ico");
            $("tr[class='" + id + "']").hide("slow");
        });
    })
});

YD.NS("HotelDefault");
YD.HotelDefault = {
    Init: function () {
        $(".menu ul li").removeClass("active");
        $(".menu ul li").eq(1).addClass("active");
    },
    InitLayDate: function () {
        laydate.skin('molv');
        var start = {
            elem: '#CheckInDate',
            format: 'YYYY-MM-DD',
            isclear: false, //是否显示清空
            min: laydate.now(), //设定最小日期为当前日期
            max: laydate.now(+89), //最大日期 
            choose: function (dates) {
                var startDate = dates.toDate();
                var nextDate = startDate.addDay(1).Format("yyyy-MM-dd");
                var maxDate = startDate.addDay(90).Format("yyyy-MM-dd");
                end.min = nextDate;//设定最小日期为当前日期
                end.max = maxDate; //最大日期
                //if ($('#CheckOutDate').val() < nextDate) {
                //    $('#CheckOutDate').val(nextDate).click();
                //}
                //if ($('#CheckOutDate').val() > maxDate) {
                //    $('#CheckOutDate').val(maxDate).click();
                //}
                //RefreshData();
            }
        };
        laydate(start);
        var minDate = laydate.now(+1);
        var maxDate = laydate.now(+181);
        if ($('#CheckInDate').val()) {
            var checkInDate = $('#CheckInDate').val().toDate();
            minDate = checkInDate.addDay(1).Format("yyyy-MM-dd");
            //maxDate = checkInDate.addMonth(3).Format("yyyy-MM-dd");
        }
        var end = {
            elem: '#CheckOutDate',
            format: 'YYYY-MM-DD',
            isclear: false, //是否显示清空
            istoday: false,//是否显示今天
            min: minDate, //设定最小日期为当前日期
            max: maxDate, //最大日期 
            choose: function (dates) {
                var startDate = $('#CheckInDate').val().toDate();
                var nextDate = startDate.addDay(1).Format("yyyy-MM-dd");
                var maxDate = startDate.addDay(90).Format("yyyy-MM-dd");
                if ($('#CheckInDate').val() >= dates) {
                    $('#CheckOutDate').val(nextDate);
                }
                if (maxDate < dates) {
                    $('#CheckOutDate').val(maxDate);
                    Atour.Ui.Alert("入住时间大于一年，请分多个订单预定。");
                }
                // RefreshData();
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

    },
    InitSerchBar: function () {
        $("#CityName").bind("click", function () {
            GetCityList(this);
        }).bind("keyup", function () {
            GetCityList(this);
        }).bind("blur", function () {
            YD.HotelDefault.SerchCity();
        }).bind("focus", function () {
            this.value = "";
        });
        $("#btnQuery").bind("click", function (e) {
            YD.HotelDefault.QueryChain(e);
        });
    },
    SerchCity: function () {//城市文本框失去焦点事件
        var city = $("#CityName").val();
        YD.HotelDefault.GetCityIDbyName(city);
        if (city == null || city == "" || city == undefined) {
            $("#CityName").val("")
            $("#hcity").val("0");
        }
    },
    GetCityIDbyName: function (cityName) {//根据名称获取id
        $("#divAddressMenu div a").each(function () {
            if ($(this).text().toLowerCase().indexOf(cityName.toLowerCase()) >= 0) {
                $(this).click();
            }
        });
    },
    QueryChain: function (e) {

        //$('html,body').animate({ scrollTop: '0px' }, 1500);

        window.scrollTo(0, 0);

        var CityID = $("#hcity").val();
        var CheckInDate = $("#CheckInDate").val();
        var Tag = $("#Tag").val();
        if (CheckInDate == null || CheckInDate == "" || CheckInDate == undefined) {
            checkindate = new Date().Format("yyyy-MM-dd");
            $("#CheckInDate").val(checkindate);
        }
        var d = new Common.Utils.D();
        var CurrentDate = new Date().Format("yyyy-MM-dd");;
        var diffdate = d.dayDiff(CheckInDate, CurrentDate);
        if (diffdate < 0) {
            checkindate = new Date().Format("yyyy-MM-dd");
            $("#CheckInDate").val(checkindate);
        }
        if ((CityID == "" || CityID == undefined || CityID == null || CityID == 0) &&
            (Tag == "" || Tag == undefined || Tag == null)) {
            $("#hcity").val(0);
            $("#CityName").val("");
        }
        var brands = "";
        $("input[class='brand']:checked").each(function () {
            brands += $(this).val() + ",";
        })
        var params = new Common.Query.M();
        params.setParameters("pagesize", 10);
        params.setParameters("pageno", e == undefined ? 1 : e.data == undefined || null ? 1 : e.data);
        params.setParameters("cityid", CityID);
        params.setParameters("key", Tag);
        params.setParameters("brands", brands.substr(0, brands.length - 1));
        Atour.Ajax.Get({
            Url: "/yaduo/Utility/GetChainByBrands",
            DataParam: params.getString(false),
            Async: false,
            FuncName: "InitData"
        });
    }
}

function goMap(chainid) {
    if (chainid != null && chainid != undefined) {
        $.layer({
            type: 2,
            shadeClose: false,
            title: false,
            closeBtn: [0, true],
            shade: [0.8, '#000'],
            border: [0],
            offset: ['60px', ''],
            area: ['95%', '95%'],
            iframe: { src: '/Hotel/Map?chainid=' + chainid }
        });
    }
}

//组装数据
var lstChain = null;
function InitData(result) {
    $("#loadData").remove();
    //clear html.
    lstChain = new Array();
    $(".hotel_item").remove();
    $(".pages").empty();
    //init async data.
    var chaindata = result.Data.ChainCollection;
    if (result != null && result != undefined && result.State == 1 && chaindata != null && chaindata != undefined) {
        for (var i = 0; i < chaindata.length; i++) {
            AddHotelItem(chaindata[i]);
        }
        //bind page event
        $(".pages").querypage({
            TotalPage: result.Data.AllPage,
            PageNo: result.Data.CurrPage,
            CallBack: YD.HotelDefault.QueryChain
        });

        //异步加载房态及房型
        $.each(lstChain, function (i, j) {
            CreateRoomStatus(j);
            CreateRoomPhoto(j.ChainID);
            AddChainPhoto(j.ChainID);
        });
        $(".tblhotels").detach();
        $(".pages").show();
    }
    else {
        $(".hotel_item").detach();
        $(".pages").hide();
        $(".hotel_list table").remove()
        $(".hotel_list").append("<table border='0' cellspacing='0' cellpadding='0' class='tblhotels'><tfoot><tr><td colspan='5'><div id=\"noResult\" class=\"b_noResult404\" style=\"\"><p class=\"e_noResultImg\"><img alt=\"404\" src=\"../../skin/images/lose.jpg\"></p><div class=\"e_noResultContent\"><h4>很抱歉，没有找到与“<em>" + $("#CityName").val() + "</em>”+“<em>" + $("#Tag").val() + "</em>”相关的酒店</h4><ul class=\"e_noResultContent_list\"><li>看看输入的文字是否有误</li><li>去掉可能不需要的字词，如\"的\"、\"什么\"等</li><li>调整关键字，如\"西安、上海\"</li></ul></div></div></td></tr></tfoot></table>");
    }
}

//新增酒店数据
function AddHotelItem(objChain) {
    var sb = new Common.Utils.MsBuilder();
    sb.Append("<div class='hotel_item'>");
    //房型图片拼接
    sb.Append("<div class='left item_img'><img class='lazy-load' src='../../skin/images/default.jpg' id='img" + objChain.ChainID + "'/></div>");
    /*酒店详细情况*/
    sb.Append("<div class='left item_details'><div>");
    //酒店logo拼接
    sb.Append("<span class='item_icon left'><img src='../Skin/images/product/LOGO" + objChain.Brand + ".png'/></span>");
    //酒店名称拼接
    sb.Append("<span class='item_title'><a href='/Hotel/HotelDetails?chainid=" + objChain.ChainID + "'>" + objChain.ChainName + "</a></span></div>");
    //酒店地址拼接
    sb.Append("<div class='item_address'><span>地址：" + objChain.ChainAddress + "</span><a href='#' onclick='goMap(" + objChain.ChainID + ")' title='查看地图' style='color:#e8e8e8;'><img style='height:20px;margin:-5px 5px -4px 10px;' src='../../skin/images/map.png'/></a><br/><span>电话：" + objChain.Telephone + "</span></div>");
    //房型列表 和结束
    sb.Append("<div class='item_hotels' id='item_hotels" + objChain.ChainID + "'></div></div><input type='hidden' id='chainname" + objChain.ChainID + "' value='" + objChain.ChainName + "' /></div>");
    $(sb.toString()).insertBefore(".pages");

    lstChain.push(objChain);

}

function CreateRoomStatus(objchain) {  /***调用房态开始***/
    var rmParams = new Common.Query.M();
    var mebTypeID = $("#MebTypeID").val();
    var CheckInDate = $("#CheckInDate").val();
    if (mebTypeID == "" || mebTypeID == undefined || mebTypeID == null) {
        mebTypeID = 0;
    }
    //在选择的时间上加一天
    var d = new Common.Utils.D();
    var sdate = d.objToDate(CheckInDate).addDay(1).Format("yyyy-MM-dd");;
    rmParams.setParameters("chainid", objchain.ChainID);
    rmParams.setParameters("mebtype", mebTypeID);
    rmParams.setParameters("start", CheckInDate);
    rmParams.setParameters("end", sdate);
    Atour.Ajax.Get({
        Url: "/yaduo/Book/GetCurrStatusByMebType",
        DataParam: rmParams.getString(false),
        FuncName: "InitRoomType",
        Async: true,
        FuncParams: { objchain: objchain }
    });
    /***调用房态结束***/
}

function CreateRoomPhoto(nchainid) {
    /***调用图片开始***/
    var phParams = new Common.Query.M();
    phParams.setParameters("nChainID", nchainid);
    //取到的是官网酒店列表的图片 主题为15
    phParams.setParameters("nPhotoTopicID", 15);
    Atour.Ajax.Get({
        Url: "/yaduo/Inn/PotoList",
        Async: true,
        DataParam: phParams.getString(false),
        FuncName: "AddPhoto"
    });
    /***调用图片结束***/
}

//添加分店图片
function AddPhoto(data) {
    if (data.State == 1) {
        //取一张图片
        if (data.Data != null && data.Data.length > 0) {
            var result = data.Data[0];
            $("#img{0}".formatStr(result.ChainID)).attr("src", result.PhOrginalUrl);
        }
    }
}

//异步判断当前酒店是否有房型图片
function AddChainPhoto(chainid) {
    /***调用图片开始***/
    var phParams = new Common.Query.M();
    phParams.setParameters("nChainID", chainid);
    //取到的是官网酒店列表的图片 主题为5
    phParams.setParameters("nPhotoTopicID", 16);
    phParams.setParameters("nPageSize", 1);
    phParams.setParameters("nGoPage", 1);
    Atour.Ajax.Get({
        Url: "/yaduo/Inn/QueryPhoto",
        DataParam: phParams.getString(false),
        FuncName: "QueryChainPhotos"
    });
    /***调用图片结束***/
}

function QueryChainPhotos(result) {
    if (result.Data.DataSet != null && result.Data.DataSet.length > 0) {
        var _objChain = result.Data.DataSet[0];
        $("<span class='item_img_see' onclick='LookPhoto(" + _objChain.ChainID + ")'>查看图片</span>").insertAfter($("#img{0}".formatStr(_objChain.ChainID)));
    }
}

//初始化房型数据
function InitRoomType(data, objchain) {
    var isHasHeader = false;
    var isPro = false;
    var sb = new Common.Utils.MsBuilder();
    sb.Append("<table border='0' cellspacing='0' cellpadding='0' class='tblhotels'>");
    if (data.State == 1) {
        var objRoomStatus = data.Data.sort(function (a, b) { return a.RoomStatusCollect.length > 0 && b.RoomStatusCollect.length > 0 && (a.RoomStatusCollect[0].RoomRate > b.RoomStatusCollect[0].RoomRate) ? 1 : -1 });
        if (objRoomStatus != null && objRoomStatus != undefined && objRoomStatus.length > 0) {

            full_room_list = [];

            for (var i_index = 0; i_index < objRoomStatus.length; i_index++) {

                var room = objRoomStatus[i_index];

                if (!isHasHeader) {
                    sb.Append(getRoomStatusTableHeader(objchain));
                    isHasHeader = true;
                    sb.Append("<tbody>");
                }
                //公寓
                var rate_td = "";
                if (objchain.Brand == 2) {
                    rate_td = getRoomRateTd_Yu(room, i_index, room.RoomTypeID, room.IsPre == 1);
                } else {
                    rate_td = getRoomRateTd(room, i_index, room.RoomTypeID, room.IsPre == 1);
                }
                var pro = getPorRate(room.RoomStatusCollect);
                if (rate_td.indexOf("已满房") == -1) {
                    //if (room.IsPre == 1 && sb.sValues.length > 3)
                    //    sb.Insert(3, rate_td);
                    //else
                    sb.Append(rate_td);
                } else {
                    full_room_list.push(rate_td);
                }

            }
            full_room_list.forEach(function (rate_td) { sb.Append(rate_td); })
            var showCount = 3;
            if (objchain.Brand == 2)
                showCount = 6;
            showCount += 2;
            for (var j_index = 3; j_index < sb.sValues.length; j_index++) {
                if (j_index > showCount)
                    sb.sValues[j_index] = sb.sValues[j_index].formatStr("class='hide'");
                else
                    sb.sValues[j_index] = sb.sValues[j_index].formatStr("");
            }
            if (sb.sValues.length > showCount + 1) {
                sb.Append("</tbody><tfoot><tr><td colspan='6' style='text-align:right;'><a href='javascript:void(0);'>查看更多</a></td></tr></tfoot></table>");
            } else {
                sb.Append("</tbody></table>");
            }
        }
        else {
            sb.Append(getEmtyTr(objchain));
        }
    }
    else {
        sb.Append(getEmtyTr(objchain));
    }
    var item_hotels = "#item_hotels{0}".formatStr(objchain.ChainID);
    $(item_hotels).append(sb.toString());
    //benjamin
    //bind show more link
    $(item_hotels + " .tblhotels").linkmore();
    //setTimeout(function () { $(item_hotels + " .tblhotels").linkmore(); }, 2500);
}

//组装三行数据为空的行
function getEmtyTr(objchain) {
    var th = getRoomStatusTableHeader(objchain);
    //var tr1 = "<tbody><tr><td>雅致大床房</td><td>---</td><td>---</td><td>---</td> <td><input type='button' value='已满房' class='btn disabled' /></td></tr>";
    //var tr2 = "<tr><td>行政大床房</td><td>---</td><td>---</td><td>---</td> <td><input type='button' value='已满房' class='btn disabled' /></td></tr>";
    //var tr3 = "<tr><td>行政套房</td><td>---</td><td>---</td><td>---</td> <td><input type='button' value='已满房' class='btn disabled' /></td></tr></tbody>";

    var tr1 = "<tbody><tr><td>雅致大床房</td><td>---</td><td>---</td><td><input type='button' value='已满房' class='btn disabled' /></td></tr>";
    var tr2 = "<tr><td>行政大床房</td><td>---</td><td>---</td><td><input type='button' value='已满房' class='btn disabled' /></td></tr>";
    var tr3 = "<tr><td>行政套房</td><td>---</td><td>---</td><td><input type='button' value='已满房' class='btn disabled' /></td></tr></tbody>";
    return th + tr1 + tr2 + tr3;
}

//获取表头
function getRoomStatusTableHeader(objchain) {
    //公寓
    if (objchain.Brand == 2) {
        return "<thead><tr><th>房型</th><th>描述</th><th>房价</th><th>&nbsp;</th></tr></thead>"
    } else {
        var sH = $("#tableHeradName").val();
        if (sH == undefined || sH == "" || sH == null) {
            sH = "官网预订价";
        }
        //return "<thead><tr><th>房型</th><th>门市价</th><th>" + sH + "</th><th>积分兑换</th><th>&nbsp;</th></tr></thead>"
        return "<thead><tr><th>房型</th><th>门市价</th><th>" + sH + "</th><th>&nbsp;</th></tr></thead>"
    }
}

//获取房型每一行价格
function getRoomRateTd(obj, i, roomTypeID, ispro) {
    var RetailPrice = "---";
    var MebOrFirstPrice = "---";
    var PointPrice = "---";
    var RoomTypeName = "---";
    var ProRate = "";
    var tr = "";
    if (obj != null && obj != undefined) {
        RoomTypeName = obj.RoomTypeName;
        //获取剩余房间数量
        var SurpluCount = obj.CanBook;
        var btnStatu = getBtnStatu(SurpluCount, obj, roomTypeID);

        //得到门市价格
        RetailPrice = getRoomRate(obj.RoomStatusCollect, 1);
        // 积分兑换数量
        if (SurpluCount > 0 && RetailPrice != "---") {
            var checkindate = $("#CheckInDate").val();
            if (checkindate == null || checkindate == undefined) {
                checkindate = new Date().Format("yyyy-MM-dd");
            }
            if (RetailPrice < 400) {
                PointPrice = "<a href='/Hotel/market?chainid={0}&roomtypeid={1}&checkindate={2}&m=1';>12000积分</a>".formatStr(obj.ChainID, roomTypeID, checkindate)
            }
            else if (RetailPrice > 600) {
                PointPrice = "<a href='/Hotel/market?chainid={0}&roomtypeid={1}&checkindate={2}&m=3';>24000积分</a>".formatStr(obj.ChainID, roomTypeID, checkindate)
            }
            else {
                PointPrice = "<a href='/Hotel/market?chainid={0}&roomtypeid={1}&checkindate={2}&m=4';>18000积分</a>".formatStr(obj.ChainID, roomTypeID, checkindate)
            }
        }
        //会员首次预订或者其它
        // MebOrFirstPrice = getRoomRate(obj.RoomStatusCollect, -1);
        if (!ispro) {
            MebOrFirstPrice = getRoomRate(obj.RoomStatusCollect, -1);
            //tr = "<tr {0} ><td>" + RoomTypeName + "</td><td>" + RetailPrice + "</td><td>" + MebOrFirstPrice + "</td><td>" + PointPrice + "</td><td>" + btnStatu + "</td></tr>"
            tr = "<tr {0} ><td>" + RoomTypeName + "</td><td>" + RetailPrice + "</td><td>" + MebOrFirstPrice + "</td><td>" + btnStatu + "</td></tr>"
        }
        else {
            MebOrFirstPrice = getPorRate(obj.RoomStatusCollect);
            btnStatu = '<input type="button" value="预订" class="btn normal" onclick="bookMark(' + obj.ChainID + ',' + roomTypeID + ')">';
            if (MebOrFirstPrice == 0 || MebOrFirstPrice == -1 || SurpluCount < 1 || !CheckPro(obj.RoomStatusCollect)) {
                btnStatu = '<input type="button" value="已满房" class="btn disabled">';
                MebOrFirstPrice = '---';
            }

            tr = "<tr {0} ><td>" + RoomTypeName + "&nbsp;&nbsp;<img src=\"../Skin/images/re.gif\"></td><td>---</td><td>" + MebOrFirstPrice + "</td><td>---</td><td>" + btnStatu + "</td></tr>"

        }

        //if (OrdigRate > 0) {
        //    //ProRate = OrdigRate;
        //    ProRate = '<td style="text-align: right;"></td>'
        //    ispro = true;
        //} else {
        //    if (OrdigRate == 0)
        //        ProRate = '<td style="text-align: right;"><input type="button" value="已售完" class="btn orange disabled " ></td>'
        //    else
        //        ProRate = '<td style="text-align: right;">&nbsp;</td>'
        //}

    }
    return tr;
}

//获取房型每一行价格
function getRoomRateTd_Yu(obj, i, roomTypeID, ispro) {
    var tr = "";
    if (obj != null && obj != undefined) {
        //获取剩余房间数量
        var SurpluCount = obj.CanBook;
        //房态
        var btnStatu = getBtnStatu_Yu(SurpluCount, obj, roomTypeID);
        //最小价格
        var minPrice = "0";
        //循环房价
        var rrs = "";
        for (var j = 0; j < obj.RoomStatusCollect.length; j++) {
            if (minPrice == "0" || obj.RoomStatusCollect[j].RoomRate < minPrice)
                minPrice = obj.RoomStatusCollect[j].RoomRate;
            var mark = getRoomRateTypeMark(obj.RoomStatusCollect[j].RoomRateTypeID);
            if (i == 0 && btnStatu) {
                rrs += "<tr class='" + roomTypeID + "'><td style='padding-left:50px;'>" + obj.RoomStatusCollect[j].RoomRateTypeName + "</td><td>" + mark + "</td><td>￥" + obj.RoomStatusCollect[j].RoomRate + "/天</td><td><input type='button' value='预订' class='btn normal' onclick='bookRoomYu(" + obj.RoomStatusCollect[j].ChainID + "," + roomTypeID + "," + obj.RoomStatusCollect[j].RoomRateTypeID + ")'></td></tr>";
            } else {
                rrs += "<tr class='" + roomTypeID + "' style='display:none;'><td style='padding-left:50px;'>" + obj.RoomStatusCollect[j].RoomRateTypeName + "</td><td>" + mark + "</td><td>￥" + obj.RoomStatusCollect[j].RoomRate + "/天</td><td><input type='button' value='预订' class='btn normal' onclick='bookRoomYu(" + obj.RoomStatusCollect[j].ChainID + "," + roomTypeID + "," + obj.RoomStatusCollect[j].RoomRateTypeID + ")'></td></tr>";
            }
        }
        if (minPrice == "0")
            minPrice = "---"
        if (btnStatu) {
            if (i == 0) {
                tr = "<tr {0} id='" + roomTypeID + "'><td width='184px;'>" + obj.RoomTypeName + "</td><td width='157px;'>&nbsp;</td><td>￥" + minPrice + "起</td><td>共" + obj.RoomStatusCollect.length + "个价格<img style='width:12px;height:12px;position:relative;bottom:-1px;left:5px;' src='/Skin/images/arrow_down.ico' /></td></tr>";
            } else {
                tr = "<tr {0} id='" + roomTypeID + "'><td width='184px;'>" + obj.RoomTypeName + "</td><td width='157px;'>&nbsp;</td><td>￥" + minPrice + "起</td><td>共" + obj.RoomStatusCollect.length + "个价格<img style='width:12px;height:12px;position:relative;bottom:-1px;left:5px;' src='/Skin/images/arrow_right.ico' /></td></tr>";
            }
            tr += rrs;
        } else {
            tr = "<tr {0} id='" + roomTypeID + "'><td width='184px;'>" + obj.RoomTypeName + "</td><td width='157px;'>&nbsp;</td><td>￥" + minPrice + "起</td><td><input type='button' value='已满房' class='btn disabled' /></td></tr>";
        }

    }
    return tr;
}

//获取房价描述
function getRoomRateTypeMark(RoomRateTypeID) {
    if (RoomRateTypeID == "2000") {
        return "1-6 天";
    } else if (RoomRateTypeID == "2001") {
        return "7-29 天";
    } else if (RoomRateTypeID == "2003") {
        return "30-179 天";
    } else if (RoomRateTypeID == "2004") {
        return ">=180 天";
    }
}

//获取房型状态
function getBtnStatu_Yu(SurpluCount, obj, roomTypeID) {
    if (SurpluCount == undefined || SurpluCount == "" || SurpluCount == null || SurpluCount < 1
        || obj == undefined || obj == null || obj == "" || obj.RoomStatusCollect.length == 0
        || roomTypeID == undefined || roomTypeID == "" || roomTypeID == null) {
        return false;
    }
    return true;
}

//获取按钮状态
function getBtnStatu(SurpluCount, obj, roomTypeID) {
    if (SurpluCount == undefined || SurpluCount == "" || SurpluCount == null || SurpluCount < 1
        || obj == undefined || obj == null || obj == "" || obj.RoomStatusCollect.length == 0
        || roomTypeID == undefined || roomTypeID == "" || roomTypeID == null) {
        return "<input type='button' value='已满房' class='btn disabled' />";
    }
    return "<input type='button' value='预订' class='btn normal' onclick='bookRoom({0},{1})' />".formatStr(obj.ChainID, roomTypeID, obj.ChainName);
}

//跳转到预订界面
function bookRoom(chainid, roomtypeid) {
    var checkindate = $("#CheckInDate").val();
    var checkoutDate = $("#CheckOutDate").val();
    //var t = /^\+?[1-9][0-9]*$/;
    //if (datecount == "" || !t.test(datecount)) {
    //    datecount = 1;
    //}
    window.location = "/Hotel/HotelCalendar?chainid=" + chainid + "&roomtypeid=" + roomtypeid + "&checkindate=" + checkindate + "&checkoutDate=" + checkoutDate;;
}

//跳转到预订界面
function bookRoomYu(chainid, roomtypeid, rrtype) {
    var checkindate = $("#CheckInDate").val();
    var checkoutDate = $("#CheckOutDate").val();
    //var t = /^\+?[1-9][0-9]*$/;
    //if (datecount == "" || !t.test(datecount)) {
    //    datecount = 1;
    //}
    window.location = "/Hotel/HotelCalendarYu?chainid=" + chainid + "&roomtypeid=" + roomtypeid + "&checkindate=" + checkindate + "&checkoutDate=" + checkoutDate + "&rrtype=" + rrtype;
}

//跳转到预订界面
function bookMark(chainid, roomtypeid) {
    var checkindate = $("#CheckInDate").val();
    var checkoutDate = $("#CheckOutDate").val();
    //var t = /^\+?[1-9][0-9]*$/;
    //if (datecount == "" || !t.test(datecount)) {
    //    datecount = 1;
    //}
    window.location = "/Hotel/Pro?chainid=" + chainid + "&roomtypeid=" + roomtypeid + "&checkindate=" + checkindate + "&checkoutDate=" + checkoutDate;
}


function getPorRate(obj) {
    if (obj != null && obj != undefined && obj.length > 0) {
        for (var i = 0; i < obj.length; i++) {
            if (obj[i].RoomRateTypeID == 90) {
                return obj[i].RoomRate;// 特价房
            }
        }
    }
    return -1;
}

function CheckPro(obj) {
    if (obj != null && obj != undefined && obj.length > 0) {
        for (var i = 0; i < obj.length; i++) {
            if (obj[i].RoomRateTypeID == 90) {
                if (obj[i].RoomRate > 0)
                    return true;
            }
        }
    }
    return false;
}

//获取房型价格
function getRoomRate(obj, ratetype) {
    var d = "---";
    if (obj != null && obj != undefined && obj.length > 0) {
        for (var i = 0; i < obj.length; i++) {
            if (ratetype != -1) {
                if (obj[i].RoomRateTypeID == ratetype)
                    return obj[i].RoomRate;
            } else {
                if (obj[i].RoomRateTypeID != 1 && obj[i].RoomRateTypeID != 90)
                    return obj[i].RoomRate;
            }
        }
    }
    return d;
}

function LookPhoto(chainid) {
    if (chainid == undefined || chainid == null || chainid == "" || chainid < 1)
        return
    $.layer({
        type: 2,
        shadeClose: false,
        title: false,
        closeBtn: [0, true],
        shade: [0.8, '#000'],
        border: [0],
        offset: ['10px', ''],
        area: ['1000px', '595px'],
        iframe: { src: '/Hotel/HotelPhoto?chainid=' + chainid }
    });

}
