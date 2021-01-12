

function checkcity() {
    if ($("#city").val()) {
        $("#city").val('');
    }

}
function selCity(obj) {
    //alert('d');
    //	$("input[@type=radio]").each(function(i){
    //			if($(this).attr("checked")) $(this).attr("checked",false)
    //			//alert($(this).attr("checked")); 
    //		})
    GetCityList(obj);
}

//************通用函数************//
function $F(fctId) {
    return document.getElementById(fctId);
}

//取得某对象，若提供ID下的对象不存在则自动创建
function c$(fctId, fctClassName) {
    var varTempDivObj = $F(fctId);
    if (!varTempDivObj) {
        //GetPyzyIframe("ifm"+fctId);
        varTempDivObj = document.createElement("div");
        varTempDivObj.id = fctId;
        if (fctClassName && fctClassName != "") varTempDivObj.className = fctClassName;
        document.body.appendChild(varTempDivObj);
    }
    return varTempDivObj;
}

//取得某ID的iframe对象，若不存在该ID的对象则自动创建
//取得某ID的iframe对象，若不存在该ID的对象则自动创建
function GetPyzyIframe(fctIfmId, fctVisibility, fctTop, fctLeft, fctWidth, fctHeight) {
    var varTempIfmObj = $F(fctIfmId);
    if (!varTempIfmObj) {
        varTempIfmObj = document.createElement("iframe");
        varTempIfmObj.id = fctIfmId;
        varTempIfmObj.style.position = "absolute";
        varTempIfmObj.style.zIndex = "1";
        varTempIfmObj.style.visibility = "hidden";
        document.body.appendChild(varTempIfmObj);
    }
    if (fctTop) varTempIfmObj.style.top = fctTop + "px";
    if (fctLeft) varTempIfmObj.style.left = fctLeft + "px";
    if (fctWidth) varTempIfmObj.style.width = fctWidth + "px";
    if (fctHeight) varTempIfmObj.style.height = fctHeight + "px";
    if (fctVisibility) varTempIfmObj.style.visibility = (document.all ? fctVisibility : "hidden	");
    return varTempIfmObj;
}

//取得某对象的坐标位置、宽、高
function getPosition(obj) {
    var top = 0;
    var left = 0;
    var width = obj.offsetWidth;
    var height = obj.offsetHeight;
    while (obj.offsetParent) {
        if (window.ActiveXObject) {
            top += obj.offsetTop + 2;
            left += obj.offsetLeft + 1.5;
        } else {
            top += obj.offsetTop;
            left += obj.offsetLeft;
        }
        obj = obj.offsetParent;
    }
    return { "top": top, "left": left, "width": width, "height": height };
}

//取得编码存储框对象
function GetValueToInputObj(fctThisObj) {
    if (!fctThisObj) return null;
    var varThisObjAutoInput = (fctThisObj.getAttributeNode("value_to_input") ? fctThisObj.getAttributeNode("value_to_input").value : "");
    if (varThisObjAutoInput == "") return null;
    return $F(varThisObjAutoInput);
}

//自动触发下一个对象的Act事件
function AutoNextInputAct(fctThisObj, fctAct) {
    var varNextInput = fctThisObj.getAttributeNode("nextinput");
    if (varNextInput && varNextInput != "") {
        if (document.all) {
            eval("$F('" + varNextInput.value + "')." + fctAct + "()");
        } else {
            var evt = document.createEvent("MouseEvents");
            evt.initEvent(fctAct, true, true);
            $F(varNextInput.value).dispatchEvent(evt);
        }
        $F(varNextInput.value).focus();
    }
}

//给某对象的某事件增加处理函数AddFunToObj(document,"onclick","alert('1');")
function AddFunToObj(fctObj, fctAct, fctFunction) {
    if (fctObj.addEventListener) { //!IE
        fctObj.addEventListener(fctAct.replace("on", ""), function (e) {
            e.cancelBubble = !eval(fctFunction);
        }, false);
    } else if (fctObj.attachEvent) { //IE
        fctObj.attachEvent(fctAct, function () {
            return eval(fctFunction);
        });
    }
}

var varPageId = 0;

//生成并显示出城市下拉菜单
function GetCityList(fctThisObj) {
    var varMenuObj = c$("divAddressMenu");
    var varThisObj = fctThisObj;
    if (varThisObj.id == "menuPageS" || varThisObj.id == "menuPageE") {
        varThisObj = varMenuObj.obj;
    } else {
        varPageId = 0;
    }
    //清除已选城市Value
    var varThisObjAutoInput = GetValueToInputObj(varThisObj); //取得城市编码值存储对象
    if (varThisObjAutoInput) varThisObjAutoInput.value = "";
    //取得城市数据并拆解为数组
    var varObjValue = varThisObj.value;
    var varThisObjAdd = (varThisObj.getAttributeNode("mod_address_suggest") ? varThisObj.getAttributeNode("mod_address_suggest").value : "");
    var varData = (varObjValue == "" ? (varThisObjAdd == "" ? varAddress : varThisObjAdd) : varAddress);
    var varHtmlStr = "", varCityDataSplit = varData.split("@"), varCityDataSplitI, varCityDataSplitIu, varNextPageStr = "";
    //存储当前操作对象
    varMenuObj.obj = varThisObj;
    var varPageRCount = (varThisObj.getAttributeNode("pagecount") ? parseInt(varThisObj.getAttributeNode("pagecount").value, 10) : 8);
    var varThisPageI = 0
    for (var i = 1; i < varCityDataSplit.length - 1; i++) {
        varCityDataSplitI = varCityDataSplit[i];
        if (varCityDataSplitI.toUpperCase().indexOf(varObjValue.toUpperCase()) >= 0 || varObjValue == "" || i == varObjValue) { // || varCityDataSplitI.toLowerCase().indexOf(varObjValue.toLowerCase())>=0
            varThisPageI += 1;
            if (varThisPageI > varPageId * varPageRCount && varThisPageI <= (varPageId + 1) * varPageRCount) {
                varCityDataSplitISplit = varCityDataSplitI.split("|");
                varHtmlStr += "<a href='javascript:;' onclick='WriteCity(" + varThisPageI + ")' id='menuA" + varThisPageI + "' title='" + varCityDataSplitI.replace("'", "") + "'><span>" + varCityDataSplitISplit[1] + "&nbsp;&nbsp;</span>" + varCityDataSplitISplit[0] + "</a>";//("+varCityDataSplitISplit[2]+")
            }
        }
    }
    if (varThisPageI > varPageRCount) {
        varNextPageStr = "&nbsp;<b id=menuPageS style=" + (varPageId > 0 ? "cursor:pointer;" : "color:#666666;") + ">&lt;&lt;&lt;&nbsp;上一页</b>　"
        varNextPageStr += "<b id=menuPageE style=" + (varThisPageI > (varPageId + 1) * varPageRCount ? "cursor:pointer;" : "color:#666666;") + ">下一页&nbsp;&gt;&gt;&gt;</b>";
    }
    var varThisObjPosition = getPosition(varThisObj); //取得事件发生处控件坐标
    with (varMenuObj) {
        style.top = varThisObjPosition.top + varThisObjPosition.height + "px";
        style.left = varThisObjPosition.left + "px";
        style.visibility = "visible";
        innerHTML = "<div><h4>可输城市拼音/汉字。</h4>" + (varHtmlStr == "" ? "<nobr>没有找到您查的信息‘" + varObjValue + "’。</nobr>" : varHtmlStr + varNextPageStr) + "</div>";
    }
    //GetPyzyIframe("ifm"+varMenuObj.id,"visible",(varThisObjPosition.top+varThisObjPosition.height),varThisObjPosition.left,varMenuObj.offsetWidth,varMenuObj.offsetHeight); //取Iframe
    return false;
}
//选择某城市
function WriteCity(fctI) {
    var varMenuObj = c$("divAddressMenu");
    var varThisObj = varMenuObj.obj;
    var varMenuValue = $F("menuA" + fctI).title;
    //alert(varMenuValue+fctI);
    //	alert(varMenuValue);
    varMenuValue = varMenuValue.split("|");
    varThisObj.value = varMenuValue[0];
    var hidObj = $F('hcity')
    var varThisObjAutoInput = GetValueToInputObj(hidObj); //取得城市编码值存储对象
    if (!varThisObjAutoInput) varThisObjAutoInput = hidObj;
    varThisObjAutoInput.value = varMenuValue[2];

    if (typeof (fctI) == "number") AutoNextInputAct(varThisObj, "click");

    //_Hidden("1");
}
//隐藏城市列表
function _Hidden(e) {
    e = e ? e : event;
    var varMenuObj = c$("divAddressMenu");
    var varThisObj = varMenuObj.obj;
    if (varMenuObj.style.visibility != "hidden") {
        if (e) {
            var EventOBJ = (e.srcElement ? e.srcElement : e.target);
            if (EventOBJ.id == "menuPageS" && EventOBJ.style.color == "") { //如果点的是“上一页”则向上翻页
                varPageId = varPageId - 1;
                GetCityList(EventOBJ);
            }
            if (EventOBJ.id == "menuPageE" && EventOBJ.style.color == "") { //如果点的是“下一页”则向下翻页
                varPageId = varPageId + 1;
                GetCityList(EventOBJ);
            }
            if (varThisObj == EventOBJ || EventOBJ.id.indexOf("menuPage") == 0 || EventOBJ.id.indexOf("divAddressMenu") == 0) return false;
        }

        var varThisObjAutoInput = GetValueToInputObj(varThisObj); //取得城市编码值存储对象
        if ($F("menuA1")) { //如果下拉菜单中存在第一个城市
            if (!varThisObjAutoInput) varThisObjAutoInput = varThisObj;
            if (varThisObjAutoInput.value == "" || varThisObjAutoInput == varThisObj) { //编码框中无值
                //WriteCity("1");
            }
        } else if (EventOBJ.id.indexOf("menuA") < 0) { //如果下拉菜单中不存在满足条件的城市
            if (varThisObj) varThisObj.value = "";
        }
        varMenuObj.style.visibility = "hidden";
        //GetPyzyIframe("ifm"+varMenuObj.id,"hidden");
    }
}
//document.write('\
//	<style type="text/css">\
//		.DateListBox{float:left;border:solid #FC7A7D 1px;width:147px !important;width:142px;height:168px !important;height:186px;font-size:12px;text-align:center;}\
//		.DateListBox h1{width:100%;background-color:#FFF4F4;color:#B42929;font-size:12px;height:20px;font-weight:bold;line-height:20px;vertical-align:middle;margin:0px;}\
//		.DateListBox div{float:left;border:solid #EB696C 1px;background-color:#EB696C;color:#FFFFFF;width:19px !important;width:17px;height:20px;font-size:12px;font-weight:bold;line-height:20px;vertical-align:middle;}\
//		.DateListBox a{float:left;color:#990000;border:solid #ffffff 1px;background-color:#ffffff;width:19px !important;width:17px;height:19px !important;height:22px;font-size:12px;line-height:20px;vertical-align:middle;}\
//		.DateListBox a:hover{border:solid #F2C2BD 1px;background-color:#FBEDEC;}\
//		.DateListBox .aSelect{cursor:pointer;border:solid #DEB4B4 1px;background-color:#FAE0CF;color:#FF0000;}\
//		.PyzyDateBox{position:absolute;z-index:10000;visibility:hidden;background-color:#FFFFFF;border:solid #EBcccC 1px;height:170px;width:298px !important;width:290px;}\
//	</style>\
//');

AddFunToObj(window, "onload", "AddFunToObj(document,'onclick','_Hidden(" + (document.all ? "" : "e") + ");');");