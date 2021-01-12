//地图控制
function MapClass(){
	//页面加载地图
	this.getLocation=function(Ycallback,Ncallback,divId){
		var me=this;
		
		var id=divId?divId:"";
		var map = new AMap.Map(id, {
			zoom:11,
			resizeEnable: true
		});
		this.map=map;
		
		map.plugin('AMap.Geolocation', function (){
			var geolocation = new AMap.Geolocation({
				timeout: 10000,           //超过10秒后停止定位，默认：无穷大
				showButton: false,        //显示定位按钮，默认：true
				showMarker: true,        //定位成功后在定位到的位置显示点标记，默认：true
				showCircle: true,        //定位成功后用圆圈表示定位精度范围，默认：true
				panToLocation: true       //定位成功后将定位到的位置作为地图中心点，默认：true
			});
	        map.addControl(geolocation);
	        
	        //获取完定位后触发查询地址的方法
			AMap.event.addListener(geolocation, 'complete',function(data){
				me.location_SUC(data,Ycallback,Ncallback);
			});
			AMap.event.addListener(geolocation, 'error',me.location_FAI);
			
			geolocation.getCurrentPosition();
		});
	}
	this.markers=[];
	//定位成功后的回调
	this.location_SUC=function(data,Ycallback,Ncallback){
		var me=this;
		var lnglatXY = new AMap.LngLat(data.position.getLng(),data.position.getLat());
		//加载地理编码插件
	    AMap.service(["AMap.Geocoder"], function() {        
	        var MGeocoder = new AMap.Geocoder({ 
	            radius: 1000,
	            extensions: "all"
	        });
	        //逆地理编码
	        MGeocoder.getAddress(lnglatXY,function(status,result){
	        	me.address_Callback(status,result,lnglatXY,Ycallback,Ncallback);
	        });
	    });
	}
	
	//逆地里回调函数
	this.address_Callback=function(status,result,lnglatXY,Ycallback,Ncallback){
		if(status === 'complete' && result.info === 'OK'){
    		var component=result.regeocode.addressComponent;
			var city = component.city==""?component.province:component.city;
			var address = result.regeocode.formattedAddress;
    		if(Ycallback!=undefined){
				Ycallback(city,address,lnglatXY);
			}
    	}else{
			if(Ncallback!=undefined){
				Ncallback();
			}
    	}
	}
	
	//定位失败后的回调
	this.location_FAI=function(Ncallback){
		if(Ncallback!=undefined){
			Ncallback();
		}
	}
	
	//信息展示窗体
	
	//实例化点标记
	this.addMarker=function(id,storeName,level,dis,lng,lat){
		var marker = new AMap.Marker({				  
			icon:'http://webapi.amap.com/images/3.png',
			animation:"AMAP_ANIMATION_DROP",
			offset: new AMap.Pixel(-12,-36),
			clickable:true,
			position:new AMap.LngLat(lng,lat)
		});
		marker.setMap(this.map);  //在地图上添加点
		var _this=this;
		 AMap.event.addListener(marker,"click",function(){
		 	_this.createInfoWindow(id,storeName,level,dis,lng,lat);

		 });
		this.markers.push(marker);
	}
	this.clearMarker=function(){
		for(var i=0;i<this.markers.length;i++){
			this.markers[i].setMap(null);
		}
	}
	this.createInfoWindow=function(tid,storeName,level,dis,lng,lat){

		level=parseFloat(level);
		var info = []; 
			info.push("<div class='infoWindow' >");
			info.push("<h5>"+storeName+"</h5>");
			info.push("<a class='closeInfoWindow' href='javascript:mainObj.mymap.infoWindow.close();'>×</a>");
			info.push("<div class='evaluation'>");
			for(var i=0;i<5;i++){
				if(i<level)
					info.push("<i class='active'></i>");
				else
					info.push("<i></i>");
			}
			var storeInfo="payment/wx/ddwash.php?tid="+tid
			info.push("<a href='javascript:location.href=\""+storeInfo+"\";' >详情<b class='mui-icon mui-icon-forward'></b></a>")
			info.push("</div>");
			info.push("<div>距离当前位置"+dis+"KM</div>");
			//var lnglat=lng+","+lat;
			var navUrl="ddwash.php?do=nav&lnglat="+lng+","+lat;
			info.push("<a class='navigation' href='javascript:location.href=\""+navUrl+"\";'><em></em>导航</a>");
			info.push("<span class='infoWindow_bottom'></span>")
			info.push("</div>");
			this.infoWindow = new AMap.InfoWindow({  
				isCustom:true,
				offset:{x:0,y:-50},
				content:info.join("")  //使用默认信息窗体框样式，显示信息内容
			}); 
			this.infoWindow.open(this.map, new AMap.LngLat(lng,lat));
		
	};
	//驾车导航
	this.driving_route=function(start_xy,end_xy) {
		var MDrive;
			this.start_xy=start_xy;
			this.end_xy=end_xy;
		var _this=this;
		AMap.service(["AMap.Driving"], function() {
			var DrivingOption = {
				//驾车策略，包括 LEAST_TIME，LEAST_FEE, LEAST_DISTANCE,REAL_TRAFFIC
				policy: AMap.DrivingPolicy.LEAST_TIME 
			};        
	        MDrive = new AMap.Driving(DrivingOption); //构造驾车导航类 
	        //根据起终点坐标规划驾车路线
	        MDrive.search(start_xy, end_xy, function(status, result){
	        	if(status === 'complete' && result.info === 'OK'){
	        		_this.driving_routeCallBack(result);
	        	}else{
	        		//alert(result);
	        	}
	        }); 
	    });
	};
	//导航结果展示
	this.driving_routeCallBack=function (data){
		var routeS = data.routes;
		if (routeS.length <= 0) {
			//document.getElementById("result").innerHTML = "未查找到任何结果!<br />建议：<br />1.请确保所有字词拼写正确。<br />2.尝试不同的关键字。<br />3.尝试更宽泛的关键字。";
		} 
		else{ 
			route_text="";
		 	for(var v =0; v< routeS.length;v++){
				//驾车步骤数
				this.steps = routeS[v].steps;
			}
			this.drivingDrawLine();
		} 	
	};
	//绘制驾车导航路线
	this.drivingDrawLine=function (s) {
		//起点、终点图标
		var sicon = new AMap.Icon({
			image: "http://cache.amap.com/lbs/static/jsdemo002.png",
			size:new AMap.Size(44,44),
			imageOffset: new AMap.Pixel(-334, -180)
		});
		var startmarker = new AMap.Marker({
			icon : sicon, //复杂图标
			visible : true, 
			position : this.start_xy,
			map:this.map,
			offset : {
				x : -16,
				y : -40
			}
		});
		var eicon = new AMap.Icon({
			image: "http://cache.amap.com/lbs/static/jsdemo002.png",
			size:new AMap.Size(44,44),
			imageOffset: new AMap.Pixel(-334, -134)
		});
		var endmarker = new AMap.Marker({
			icon : eicon, //复杂图标
			visible : true, 
			position : this.end_xy,
			map:this.map,
			offset : {
				x : -16,
				y : -40
			}
		});
		//起点到路线的起点 路线的终点到终点 绘制无道路部分
		var extra_path1 = new Array();
			extra_path1.push(this.start_xy);
			extra_path1.push(this.steps[0].path[0]);
		var extra_line1 = new AMap.Polyline({
			map: this.map,
			path: extra_path1,
			strokeColor: "#9400D3",
			strokeOpacity: 0.7,
			strokeWeight: 4,
			strokeStyle: "dashed",
			strokeDasharray: [10, 5]
		});
	
		var extra_path2 = new Array();
		var path_xy = this.steps[(this.steps.length-1)].path;
			extra_path2.push(this.end_xy);
			extra_path2.push(path_xy[(path_xy.length-1)]);
		var extra_line2 = new AMap.Polyline({
			map: this.map,
			path: extra_path2,
			strokeColor: "#9400D3",
			strokeOpacity: 0.7,
			strokeWeight: 4,
			strokeStyle: "dashed",
			strokeDasharray: [10, 5]
		});
		
		var drawpath = new Array(); 
		for(var s=0; s<this.steps.length; s++) {
			var plength = this.steps[s].path.length;
			for (var p=0; p<plength; p++) {
				drawpath.push(this.steps[s].path[p]);
			}
		}
		var polyline = new AMap.Polyline({
			map: this.map,
			path: drawpath,
			strokeColor: "#9400D3",
			strokeOpacity: 0.7,
			strokeWeight: 4,
			strokeDasharray: [10, 5]
		});
		this.map.setFitView();
	}
	//绘制驾车导航路段
	this.driveDrawFoldline=function(num) {
		var drawpath1 = new Array();
		drawpath1 = this.steps[num].path;
		if(polyline != null) {
			polyline.setMap(null);
		}
		polyline = new AMap.Polyline({
				map: map,
				path: drawpath1,
				strokeColor: "#FF3030",
				strokeOpacity: 0.9,
				strokeWeight: 4,
				strokeDasharray: [10, 5]
			});
	
		this.map.setFitView(polyline);
	}
}

var mymap=new MapClass();
if("function"==typeof define&&define.amd){
	define([],function(){
		return mymap;
	});
}else{
	window.mymap=mymap;
}
