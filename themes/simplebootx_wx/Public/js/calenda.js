function Calendar(selectedDoneCall) {

    //天数    
    var e = this;
    var _dayCount = 1;
    //是2天
    var _isTwoDays = false;
    //Scroll位置
    var _scrollTop = 1;
    //开始元素
    var _startEl;
    //结束元素
    var _endEl;
    var beginDate;
    var endDate;
    var calendarendDate;
    e.fullDate = null;
    var ind = 0;
    //彈窗提示
    var temps = true;
    this.fDrawCal = {
        setFullDate: function (fullDate) {
            e.fullDate = fullDate;
        },
        fullHouse: function () {
            //添加满房
            try {
                var i = 0, tempselect;
                for (i; i < e.fullDate.length; i++) {
                    var ele = $("#calendar_cell_" + e.fullDate[i]);
                    if (ele.css("line-height") != "18px")
                        ele.append("<span style='display:block;line-height:18px;color:red;'>满房</span>").css("line-height", "18px");
                }
            }
            catch (e) {
                return;
            }

        },
        fullHouseClick: function (date) {
            try {
                var i = 0;
                var tempfl = true;
                for (i; i < e.fullDate.length; i++) {
                  
                    if (date == e.fullDate[i]) {
                        $("#maxOptional").remove();
                        $("#wwei_dialog_p").remove();
                        $("#dateInclude").remove();
                        $("#fullHouseClick").remove();
                        $("body").append('<p id="fullHouseClick" style="width:40%;height:100px;text-align:center;position: fixed;bottom:10%;left:30%;z-index: 99999;background:rgba(0,0,0,0.6);color:#ffffff;border-radius: 5px;word-break:break-all;"><span style="display: block;margin-top: 30px;">满房不可以预定，请重新选择！</span></p>');

                        setTimeout(function () {
                            temps = true;
                            $("#fullHouseClick").remove();
                        }, 2000);
                        tempfl = false;
                        return false;
                    }
                }
                if (tempfl) {
                    //满房计算
              
                    var oldC = $('.calendar_select_first').attr("date-data");
                    var currentC = new Date(date.replace(/-/g, "/ "));
                    var tempFirstDay = new Date(oldC.replace(/-/g, "/ "));
                    var dayCountDays = currentC.getTime() - tempFirstDay.getTime();
                    var dayCount2 = parseInt(dayCountDays / (1000 * 60 * 60 * 24));
                   
                    if (dayCount2 > 0 && $(".calendar_select_second").length==0) {
                     
                      
                        if (!e.fDrawCal.dateInclude(date)) return false;
                        else return true;
                    }
                }
            } catch (e) {
                return;
            }
        },
        dateInclude: function (date) {
            try {
                var dateIncludez = [];
                var oldC = $('.calendar_select_first').attr("date-data");
                var currentC = new Date(date.replace(/-/g, "/ "));
                var tempFirstDay = new Date(oldC.replace(/-/g, "/ "));
                var dayCountDays = currentC.getTime() - tempFirstDay.getTime();
                var dayCount2 = parseInt(dayCountDays / (1000 * 60 * 60 * 24));
                var tempFirst = new Date(oldC);
                for (var i = 1; i <= dayCount2 - 1; i++) {
                    tempFirstDay.setDate(tempFirstDay.getDate() + 1)
                    dateIncludez.push(e.getDateString(tempFirstDay));
                }
                if (dateIncludez.length==0) return true;
                for (var i = 0; i < e.fullDate.length; i++) {
                    for (var j = 0; j < dateIncludez.length; j++) {
                        if (dateIncludez[j] == e.fullDate[i]) {
                            $("#wwei_dialog_p").remove();
                            $("#dateInclude").remove();
                            $("#maxOptional").remove();
                            $("#fullHouseClick").remove();
                            $("body").append('<p id="dateInclude" style="width:40%;height:100px;text-align:center;position: fixed;bottom:10%;left:30%;z-index: 99999;background:rgba(0,0,0,0.6);color:#ffffff;border-radius: 5px;word-break:break-all;"><span style="display: block;margin-top: 30px;">包含满房不可以预定，请重新选择！</span></p>');

                            setTimeout(function () {
                                temps = true;
                                $("#dateInclude").remove();
                            }, 2000);
                            return false;
                        }
                    }
                }
                return true;
            } catch (e) {
                return false;
            }

        },
        AddMonth: function (y, m, d) {
            var d_Date = new Date();
            var d_y = d_Date.getFullYear();
            var d_m = d_Date.getMonth() + 1;
            var d_d = d_Date.getDate();

            var temp_d = new Date(y, m - 1, 1);
            var first_d = temp_d.getDay(); //返回本月1号是周几
            temp_d = new Date(y, m, 0);
            var all_d = temp_d.getDate();//返回本月共有多少天,同时避免复杂的判断润年不润年
            var html, i_d;

            html = "<h2>" + y + "<span class='year'>年</span><span class='blue'>" + m + "<span class='year'>月</span></span></h2>"; //html=y+"年"+m+"月"+d_d+"日";
            // html = "";
            html += "<table border='0' cellpadding='0' cellspacing='0'><tr>"
            html += "<td class='td_xq sun'>周日</td>";
            html += "<td class='td_xq'>周一</td>";
            html += "<td class='td_xq'>周二</td>";
            html += "<td class='td_xq'>周三</td>";
            html += "<td class='td_xq'>周四</td>";
            html += "<td class='td_xq'>周五</td>";
            html += "<td class='td_xq sat' style='border-right: 1px #ffffff solid;'>周六</td></tr>";
            html += "<tr>";

            if (m < 10) {
                var m = "0" + m;
            }
            for (var i = 1; i <= 42; i++) {
                if (first_d < i && i <= (all_d + first_d)) {
                    i_d = i - first_d;//显示出几号                   
                    i_td = i_d - 1;
                    if (i_d < 10) {
                        var i_d0 = "0" + i_d;
                    } else {
                        var i_d0 = i_d;
                    }
                    setTime = new Date(y, m - 1, i_d);
                    weekday = new Array("日", "一", "二", "三", "四", "五", "六");
                    var strDate = e.getDateString(setTime);
                    html += "<td ";
                    if (y == d_y && m == d_m && d_d == i_d) {//日历中为当天
                        html += " id='calendar_cell_" + strDate + "' class='td_hao calendar_select_first calendar_day  bg color'  style='line-height: 18px;' date-data='" + strDate + "' week-data='周" + weekday[setTime.getDay()] + "'>" + i_d + "<br/>入住</td>";
                    } else if (y == d_y && m == d_m && d_d == i_td) {
                        html += " id='calendar_cell_" + strDate + "' class='td_hao calendar_select_second calendar_day bg color'  style='line-height: 18px;' date-data='" + strDate + "' week-data='周" + weekday[setTime.getDay()] + "'>" + i_d + "<br/>离店</td>";
                    } else if (y == d_y && m <= d_m && d_d > i_d) {
                        html += " class='td_hao gray'>" + i_d + "</td>";
                    } else {
                        if (!d || (d && i_d <= d)) {
                            html += " id='calendar_cell_" + strDate + "' class='td_hao calendar_day' date-data='" + strDate + "' week-data='周" + weekday[setTime.getDay()] + "'>" + i_d + "</td>";
                        }
                        else {
                            html += " class='td_hao gray'>" + i_d + "</td>";
                        }
                    }

                } else {
                    html += "<td class='gray'>&nbsp;</td>";
                }
                if (i % 7 == 0 && i < 42) {
                    html += "</tr><tr>";
                }
            }
            html += "</tr></table>";
            if ($(".dateWrap1").length > 0) {
                html = $(".dateWrap1").html() + html;
                $(".dateWrap1").remove();
            }
            var div = document.createElement('div');
            div.className = 'dateWrap1 juzhong';
            div.innerHTML = html;
            var trs = div.getElementsByTagName('tr'),
                trL = trs.length,
                tr = trs[trL - 1];
            if (tr.getElementsByTagName('td')[0].innerHTML === '&nbsp;') {
                tr.parentNode.removeChild(tr);
            }
            document.getElementById("date_list").appendChild(div);
        },
        addMaxOptional: function () {
            //日历最大天数限制
            if (temps) {
                temps = false;
                $("body").animate().append('<p id="maxOptional" style="width:40%;height:100px;line-height:100px;text-align:center;position: fixed;bottom:10%;left:30%;z-index: 99999;background:rgba(0,0,0,0.6);color:#ffffff;border-radius: 5px;">最多可选30天呦！</p>');

                setTimeout(function () {
                    temps = true;
                    $("#maxOptional").remove();
                }, 2000);
            }
        },
        setDayCount: function (count) {
            /// <summary>设置天数</summary>
            /// <param name="count" type="count">天数</param>

            e._dayCount = count;
        },

        showDays: function (date) {
            /// <summary>显示选中</summary>
            /// <param name="date" type="Date">日期</param>
            /// <param name="num" type="Number">天数</param> 
            tempend = $(".calendar_select_second").attr("date-data");
            var firstcell;
            var strDate;
            var ld = false, xx = false;
            if (date == null) {
                firstcell = $('.calendar_select_first');
                strDate = firstcell.attr('date-data');
                if (strDate != e.beginDate) {
                    firstcell = $('#calendar_cell_' + e.beginDate);
                    xx = true;
                }
                else {
                    if (firstcell.length == 0) {
                        firstcell = $('.today1');
                        if (firstcell.length != 0) {
                            firstcell.removeClass('today1');
                            firstcell.addClass('calendar_select_first');
                        }
                    }
                    else
                        xx = true;
                }
            } else {
                strDate = e.getDateString(date);
                firstcell = $('#calendar_cell_' + strDate);
            }

            if (firstcell.length == 0)
                return;
            var dayCount = e._dayCount;

            if (date != null || strDate != $("#HDSDate").val() || xx) {
                var strDate = firstcell.attr('date-data');
                var firstday = e.getDateFromString(strDate);
                //满房不允许点击

                if (!xx) {
                    var currentC = date;
                    var oldC = $('.calendar_select_first').attr("date-data");
                    currentC = new Date(currentC.replace(/-/g, "/ "));
                    oldC = new Date(oldC.replace(/-/g, "/ "));
                    var dayCountDays = currentC.getTime() - oldC.getTime();
                    var dayCount2 = parseInt(dayCountDays / (1000 * 60 * 60 * 24));
                    if (dayCount2 < 0) {
                        $('#wwei_dialog_p2').remove();
                        $('#wwei_dialog_p').remove();
                        $("#maxOptional").remove();

                        $('<p  id="wwei_dialog_p2" style="width:40%;height:100px;line-height:100px;text-align:center;position: fixed;bottom:10%;left:30%;z-index: 99999;background:rgba(0,0,0,0.6);color:#ffffff;border-radius: 5px;">请选择离店时间!</p>').appendTo('body')

                        setTimeout(function () { $("#wwei_dialog_p2").fadeOut(800, function () { $("#wwei_dialog_p2").remove(); }) }, 1500);

                        dayCount2 = 0;
                        dayCount = 0;
                        var htm = $('.calendar_select_first').html();
                        $('.calendar_select_first').removeClass('calendar_select_first bg color').css("line-height", "40px").html(parseInt(htm));
                        htm = $('.calendar_select_second').html();
                        $('.calendar_select_second').removeClass('calendar_select_second bg color').css("line-height", "40px").html(parseInt(htm));
                        $('.calendar_select').removeClass();
                        $('td.bg').removeClass('bg color');

                    } else if (dayCount > 0) {
                        $('#wwei_dialog_p').remove('p');
                        $("#maxOptional").remove();
                        dayCount = 0;
                        var htm = $('.calendar_select_first').html();
                        $('.calendar_select_first').removeClass('calendar_select_first bg color').css("line-height", "40px").html(parseInt(htm));
                        htm = $('.calendar_select_second').html();
                        $('.calendar_select_second').removeClass('calendar_select_second bg color').css("line-height", "40px").html(parseInt(htm));
                        $('.calendar_select').removeClass('calendar_select');
                        $('td.bg').removeClass('bg color');
                        $('<p  id="wwei_dialog_p" style="width:40%;height:100px;line-height:100px;text-align:center;position: fixed;bottom:10%;left:30%;z-index: 99999;background:rgba(0,0,0,0.6);color:#ffffff;border-radius: 5px;">请选择离店时间!</p>').appendTo('body');
                        setTimeout(function () { $("#wwei_dialog_p").fadeOut(800, function () { $("#wwei_dialog_p").remove(); }) }, 1500);
                    } else {

                        //不允许包含满房
                        if (e.fullDate) {
                            if (e.fDrawCal.dateInclude(date) == false) {
                                return;
                            }
                        }

                        $('#wwei_dialog_p2').remove('p');
                        $('#wwei_dialog_p').remove('p');
                        $("#maxOptional").remove();
                        var date2 = $('.calendar_select_first').attr('date-data');
                        firstday = e.getDateFromString(date2);
                        ld = true;
                        var minsec = Date.parse(strDate.replace("-", "/").replace("-", "/")) - Date.parse(date2.replace("-", "/").replace("-", "/"));
                        dayCount = minsec / 1000 / 60 / 60 / 24; //factor: second / minute / hour / day
                        if (dayCount > 30) {
                            //日历最大天数限制
                            e.fDrawCal.addMaxOptional();
                            return;
                        }
                    }

                    e.fDrawCal.setDayCount(dayCount);
                }
                else {
                    var htm = $('.calendar_select_first').html();
                    $('.calendar_select_first').removeClass('calendar_select_first bg color').css("line-height", "40px").html(parseInt(htm));
                    htm = $('.calendar_select_second').html();
                    $('.calendar_select_second').removeClass('calendar_select_second bg color').css("line-height", "40px").html(parseInt(htm));

                    if (e.fullDate) {
                        for (i = 0; i < e.fullDate.length; i++) {
                            if (e.fullDate[i] == tempend) {
                                tempend = i;
                                break;
                            }
                        }
                        //if (tempend >= 0)
                        //    $('#calendar_cell_' + e.fullDate[tempend]).append("<span style='display:block;line-height:18px;color:red;'>满房</span>").css("line-height", "18px");
                    }
                    $('.calendar_select').removeClass('calendar_select');
                    $('td.bg').removeClass('bg color');
                }

                for (var i = 0; i <= dayCount; i++) {
                    var theday = e.DateAdd(firstday, i);
                    strDate = e.getDateString(theday);

                    if (i == 0 && !ld) {
                        var htm = $('#calendar_cell_' + strDate).html();
                        $('#calendar_cell_' + strDate).addClass('calendar_select_first bg color').css("line-height", "18px").html(htm + "<br/>入住");
                    }
                    else if (i != 0 && i == dayCount) {
                        var eleedate = $('#calendar_cell_' + strDate);
                        htm = eleedate.html();
                        if (eleedate.css("line-height") == "18px")
                            eleedate.addClass('calendar_select_second bg color').css("line-height", "18px").html(theday.getDate() + "<br/>离店");
                        else
                            eleedate.addClass('calendar_select_second bg color').css("line-height", "18px").html(htm + "<br/>离店");
                    }
                    else {
                        $('#calendar_cell_' + strDate).addClass('calendar_select bg');
                    }
                }
                if (e.fullDate) {
                    e.fDrawCal.fullHouse();
                }
                xx = false;
                $("#numDayNew").html(dayCount);
            }

        },
        onSelect: function (ev) {
            /// <summary>当选中</summary>
            /// <param name="ev" type="Object">事件</param>   

            var el = ev.currentTarget;
            var date = $(el).attr('date-data');

            if (date != undefined) {
                var d_Date = new Date();
                var minsec;
                if (date) {
                    minsec = Date.parse(date.replace("-", "/").replace("-", "/")) - Date.parse(d_Date);
                }
                var _Count = minsec / 1000 / 60 / 60 / 24; //factor: second / minute / hour / day

                //alert(_Count);
                if (e.fullDate) {
                    if (e.fDrawCal.fullHouseClick(date) == false) {
                        return;
                    }
                }

                if (_Count < -1)
                    return;
                else {
                    e.fDrawCal.showDays(date);
                }
            } else
                return;
        },
        onOK: function () {
            /// <summary>确定</summary>     
            var firstday = $('.calendar_select_first');
            var lastday = $('.calendar_select_second');

            if (firstday.length == 0) {
                return;
            }
            /****************************/
            //if (lastday.length == 0) {
            //    return;
            //}
            if (e.maxDay > 0) {
                if (e.fDrawCal.getDays() > e.maxDay) {
                    alert("最长可入住" + e.maxDay + "天,请重新选择");
                    return;
                }
            }


            var date = firstday.attr('date-data');
            var day1 = {
                dateStr: e.getDateStringChin(date),
                week: e.getWeekDayString(date),
                date: e.getDateString(date)
            };
            e.beginDate = day1.date;
            if (_isTwoDays) {
                var date2 = lastday.attr('date-data');
                if (!date2) {
                    $('<p  id="wwei_dialog_p2" style="width:40%;height:100px;line-height:100px;text-align:center;position: fixed;bottom:10%;left:30%;z-index: 99999;background:rgba(0,0,0,0.6);color:#ffffff;border-radius: 5px;">请选择离店时间!</p>').appendTo('body')

                    setTimeout(function () { $("#wwei_dialog_p2").fadeOut(800, function () { $("#wwei_dialog_p2").remove(); }) }, 1500);
                    return;
                }
                var day2 = {
                    dateStr: e.getDateStringChin(date2),
                    week: e.getWeekDayString(date2),
                    date: e.getDateString(date2)
                };
                e.endDate = day2.date;
                selectedDoneCall(day1, day2);
            }
            else {
                selectedDoneCall(day1);
            }
            e.fDrawCal.closeDialog(0);
        },
        showDialog: function () {
            /// <summary>显示对话框</summary>
            var startdate = e.getDateFromString(e.beginDate);
            var enddate = e.getDateFromString(e.endDate);
            var count = 0;
            for (var i = startdate; i < enddate; i = e.DateAdd(i, 1)) {
                count++;
            }

            e.fDrawCal.setDayCount(count);
            e.fDrawCal.showDays();
            $('#yd_date').show();

            $("#date_list").css("height", $(window).height() - 72);
            if (e.fullDate) {
                e.fDrawCal.fullHouse();
            }
        },
        closeDialog: function (val) {
            /// <summary>关闭对话框</summary>
            var firstcell = $('.calendar_select_first');
            var strDate = firstcell.attr('date-data');
            var secondcell = $('.calendar_select_second');
            var endDate = secondcell.attr('date-data');
            $('#wwei_dialog_p').remove('p');


            var htm = $('.calendar_select_first').html();
            $('.calendar_select_first').removeClass('calendar_select_first bg color').css("line-height", "40px").html(parseInt(htm));
            htm = $('.calendar_select_second').html();
            $('.calendar_select_second').removeClass('calendar_select_second bg color').css("line-height", "40px").html(parseInt(htm));
            $('.calendar_select').removeClass('calendar_select');
            $('td.bg').removeClass('bg color');
            if (val != 0) {

                var minsec = Date.parse($("#HDEDate").val()) - Date.parse($("#HDSDate").val());

                e.fDrawCal.setDayCount(minsec / 1000 / 60 / 60 / 24);
                if (val == -1) {
                    e.beginDate = $("#HDSDate").val();
                    e.endDate = $("#HDEDate").val();
                }

            }
            $("#wwei_dialog_p,#wwei_dialog_p2").fadeOut(200, function () { $("#wwei_dialog_p,#wwei_dialog_p2").remove(); });

            //e.fDrawCal.showDays();
            $('#yd_date').hide();
        },
        getDays: function () {
            return e._dayCount;
        }
    }
    var _isInit = false;
    this.init = function () {

        /// <summary>初始化</summary>
        if (document.getElementById("date_list") == null)
            return;
        if (!_isInit) {
            var d_Date = new Date();            //系统时间对象  
            var d_y = d_Date.getFullYear();     //完整的年份,千万不要使用getYear,firfox不支持  
            var d_m = d_Date.getMonth() + 1;      //注意获取的月份比实现的小1  
            var d_d = d_Date.getDate();
            if (arguments.length > 2) {
                e.calendarendDate = new Date(e.getDateString(arguments[2]));
                var e_y = e.calendarendDate.getFullYear();
                var e_m = e.calendarendDate.getMonth() + 1;
                var e_d = e.calendarendDate.getDate();

                //n个月 i < n
                for (var i = 0; i <= 12; i++) {
                    if (d_m + i > 12) {
                        if ((d_y + 1 < e_y) || (d_m + i - 12 < e_m)) {
                            e.fDrawCal.AddMonth(d_y + 1, d_m + i - 12);
                        }
                        else if (d_m + i - 12 == e_m) {
                            e.fDrawCal.AddMonth(d_y + 1, d_m + i - 12, e_d);
                        }
                    } else {
                        if ((d_y < e_y) || (d_m + i < e_m)) {
                            e.fDrawCal.AddMonth(d_y, d_m + i);
                        } else if (d_m + i == e_m) {
                            e.fDrawCal.AddMonth(d_y, d_m + i, e_d);
                            break;
                        }
                    }
                }
            }
            else {

                //n个月 i < n
                for (var i = 0; i <= 12; i++) {

                    if (d_m + i > 12) {

                        e.fDrawCal.AddMonth(d_y + 1, d_m + i - 12);

                    } else {

                        e.fDrawCal.AddMonth(d_y, d_m + i);

                    }
                }
            }


            $('.calender_ok_btn').click(this.fDrawCal.onOK);
            $('.td_hao').click(this.fDrawCal.onSelect);

            $('.calender_return_btn').click(this.fDrawCal.closeDialog);
            $('#jian').on("tap", function () {
                if (ind > 0)
                    ind--;
                else
                    return;
                var y = parseInt($("#year").html());
                var m = parseInt($("#month").html());
                if (m == 1) {
                    y = y - 1;
                    m = 12;
                }
                else {
                    m = m - 1;
                }
                $("#year").html(y);
                $("#month").html(m);
                $("#date_list ").children().children().eq(ind).show().siblings().hide();
            });

            $('#jia').on("tap", function () {
                if (ind == 6) return;
                else
                    ind++;

                var y = parseInt($("#year").html());
                var m = parseInt($("#month").html());
                if (m == 12) {
                    y = y + 1;
                    m = 1;
                }
                else {
                    m = m + 1;
                }
                $("#year").html(y);
                $("#month").html(m);
                $("#date_list ").children().children().eq(ind).show().siblings().hide();

            });
            //if (fullDate) {
            //    e.fDrawCal.fullHouse(fullDate);
            //}
        }


        $("#date_list ").children().children().show();
        if (arguments.length > 0) {
            $("#year").html(e.getDateFromString(arguments[0]).getFullYear());
            $("#month").html(e.getDateFromString(arguments[0]).getMonth() + 1);
            e.beginDate = e.getDateString(arguments[0]);
            if (arguments.length > 1) {
                e.endDate = e.getDateString(arguments[1]);
                e.endDate = e.getDateString(arguments[1]);
                var minsec = Date.parse(e.endDate) - Date.parse(e.beginDate);

                e.fDrawCal.setDayCount(minsec / 1000 / 60 / 60 / 24);
                _isTwoDays = true;
            }
        }

        _isInit = true;
    }

    this.getDateString = function (date) {
        /// <summary>得到日期字符串</summary>
        /// <param name="date" type="Date">日期</param>
        /// <returns type="String" />

        if (typeof (date) == 'string')
            return date;

        var month = (date.getMonth() + 1);
        if (month < 10)
            month = "0" + month;
        var day = date.getDate();
        if (day < 10)
            day = "0" + day;

        return date.getFullYear() + '-' + month + '-' + day;
    }
    this.getDateStringChin = function (date) {
        /// <summary>得到日期字符串</summary>
        /// <param name="date" type="Date">日期</param>
        /// <returns type="String" />
        if (typeof (date) == 'string')
            date = e.getDateFromString(date);

        return (date.getMonth() + 1) + '月' + date.getDate() + '日';
    }
    this.getDateFromString = function (str) {
        /// <summary>从字符串得到日期</summary>
        /// <param name="str" type="String">字符串</param>
        /// <returns type="Date" />
        if (str == null || str == '')
            return new Date();
        str = str.replace(/-/ig, '/');

        try {
            return new Date(str);
        } catch (e) {
            return new Date();
        }
    }
    this.getWeekDayString = function (date) {
        /// <summary>得到周字符串</summary>
        /// <param name="date" type="Date">日期</param>
        /// <returns type="String" />

        if (typeof (date) == 'string')
            date = e.getDateFromString(date);

        var weekdays = new Array("日", "一", "二", "三", "四", "五", "六");

        return '周' + weekdays[date.getDay()];
    }
    this.DateAdd = function (sdate, days) {
        /// <summary>添加天数</summary>
        /// <param name="sdate" type="String">日期</param>
        /// <param name="days" type="Number">天数</param>
        /// <returns type="Date" />

        if (typeof (sdate) == 'string')
            sdate = e.getDateFromString(sdate);
        sdate = sdate.valueOf();
        sdate = sdate + days * 24 * 60 * 60 * 1000;
        sdate = new Date(sdate);
        return sdate;
    }

}

