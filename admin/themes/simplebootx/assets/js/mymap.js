(function($){
	var myMap=function(){
		//初始化地图
		this.init=function(divid,textid,lngid,latid,btnid){
			var me=this;
			this.deflng=$.trim($("#"+lngid).val());
			this.deflat=$.trim($("#"+latid).val());
			this.deflnglat=[this.deflng?this.deflng:116.397428,this.deflat?this.deflat:39.90923];
			this.map=new AMap.Map(divid, {
				//resizeEnable: true,
				center: this.deflnglat,//地图中心点
				zoom: 13 //地图显示的缩放级别
			}); 
			
			//设置默认坐标
			this.setMark(this.deflnglat,function(e){
				var lnglatXY=[e.lnglat.lng,e.lnglat.lat];
				$("#"+lngid).val(e.lnglat.lng);
				$("#"+latid).val(e.lnglat.lat);
				me.map.panTo(lnglatXY);
				me.regeocoder(lnglatXY,function(res){
					var address=res.regeocode.formattedAddress;
					$("#"+textid).val(address);
				});
			});
			
			//点击按钮
			$("#"+btnid).click(function(){
				me.addressEvent(textid,lngid,latid);
			});
			
			//文本框回车
			$("#"+textid).change(function(){
				//me.addressEvent(textid,lngid,latid);
			}).bind('keypress',function(event){
				if(event.keyCode == "13"){
					me.addressEvent(textid,lngid,latid);
					return false;
				}
			})
			
		}
		
		this.addressEvent=function(textid,lngid,latid){
			var me=this;
			var address=$.trim($("#"+textid).val());
			me.geocoder(address,function(res){
				var localobj=res.geocodes[0].location;
				$("#"+lngid).val(localobj.lng);
				$("#"+latid).val(localobj.lat);
				$("#"+textid).val(res.geocodes[0].formattedAddress);
				me.map.panTo([localobj.lng,localobj.lat]);
				me.marker.setPosition([localobj.lng,localobj.lat]);
			});
		}
		
		//地址找坐标
		this.geocoder=function(address,callback) {
			var me=this;
			var geocoder = new AMap.Geocoder({
				city: "", //城市，默认：“全国”
				radius: 1000 //范围，默认：500
			});
			//地理编码,返回地理编码结果
			geocoder.getLocation(address,function(status, result) {
				if (status === 'complete' && result.info === 'OK') {
					if(callback!=undefined){
						callback(result);
					}
				}
			});
		}
		
		//坐标找地址
		this.regeocoder=function(lnglatXY,callback){
			var me=this;
			var geocoder = new AMap.Geocoder({
				radius: 1000,
				extensions: "all"
			});        
			geocoder.getAddress(lnglatXY,function(status, result) {
				if (status === 'complete' && result.info === 'OK') {
					if(callback!=undefined){
						callback(result);
					}
				}
			});	
		}
		
		//设置坐标点标注
		this.setMark=function(lnglatXY,dragendcall){
			this.marker = new AMap.Marker({ //添加自定义点标记
				map: this.map,
				position: lnglatXY, //基点位置
				offset: new AMap.Pixel(-17, -42), //相对于基点的偏移位置
				draggable: true,  //是否可拖动
				//content: '<div class="marker-route marker-marker-bus-from"></div>'   //自定义点标记覆盖物内容
			});
			
			this.marker.on("dragend",function(e){
				if(dragendcall!=undefined){
					dragendcall(e);
				}
			});
		}
	}
	window.mymap=new myMap();
})(window.jQuery||window.Zepto);