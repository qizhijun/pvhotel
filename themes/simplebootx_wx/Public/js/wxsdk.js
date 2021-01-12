require.config({
    paths: {
    	jssdk:'http://res.wx.qq.com/open/js/jweixin-1.0.0'
    }
});
define(['jssdk'],function(wx){
	var wxsdk=function(){
		this.init=function(debug,sign){
			wx.config({
				debug: debug,
				appId: sign.appId,
				timestamp: sign.timestamp,
				nonceStr: sign.nonceStr,
				signature: sign.signature,
				jsApiList: [
				  // 所有要调用的 API 都要加到这个列表中
				    'checkJsApi',
				    'onMenuShareTimeline',
				    'onMenuShareAppMessage',
				    'onMenuShareQQ',
				    'onMenuShareWeibo',
				    'openLocation',
				    'chooseImage',
				    'uploadImage',
				]
			});
		}
		/**
		 * 分享内容
		 */
		this.share=function(share,Ycall){
			wx.ready(function(){
				//显示分享按钮
				wx.showOptionMenu();
				//分享给朋友
				wx.onMenuShareAppMessage({
				    title: share.title,
				    desc: share.desc,
				    link: share.link,
				    imgUrl: share.imgUrl,
				    success:function(){
				    	if(Ycall!=undefined&&typeof Ycall=="function"){
				    		Ycall();
				    	}
				    }
				});
		
				//分享到朋友圈
				wx.onMenuShareTimeline({
				    title: share.title,
				    link: share.link,
				    imgUrl: share.imgUrl,
				    success:function(){
				    	if(Ycall!=undefined&&typeof Ycall=="function"){
				    		Ycall();
				    	}
				    }
				});
		
			});
		}
		
		/**
		 * 地图显示
		 */
		this.showmap=function(lat,lng,name,address,scale,infoUrl){
			wx.openLocation({
			    latitude: parseFloat(lat), // 纬度，浮点数，范围为90 ~ -90
			    longitude: parseFloat(lng), // 经度，浮点数，范围为180 ~ -180。
			    name: name, // 位置名
			    address: address, // 地址详情说明
			    scale: scale, // 地图缩放级别,整形值,范围从1~28。默认为最大
			    infoUrl: infoUrl // 在查看位置界面底部显示的超链接,可点击跳转
			});
		}
		/**
		 * 上传临时图片 
		 */
		this.chooseImage = function(_count, _choosefun){
			
			wx.chooseImage({
				count: _count, // 默认9
			    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
			    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			    success: function (res) {
			        var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片

			        if(_choosefun!=undefined&&typeof _choosefun=="function"){
			    		_choosefun(localIds.toString());
			    	}
			    }
		    });
	    }
		this.uploadImage = function(_localId, _uploadfun){
			setTimeout(function(){
				wx.uploadImage({
				    localId: _localId, // 需要上传的图片的本地ID，由chooseImage接口获得
				    isShowProgressTips: 1, // 默认为1，显示进度提示
				    success: function (res) {
				        var serverId = res.serverId; // 返回图片的服务器端ID
				        if(_uploadfun!=undefined&&typeof _uploadfun=="function"){
				    		_uploadfun(serverId);
				    	}
				    }
				});
			}, 100)
		}
	}
	window.wxsdk=new wxsdk();
});
