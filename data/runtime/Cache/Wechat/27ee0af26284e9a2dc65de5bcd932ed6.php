<?php if (!defined('THINK_PATH')) exit(); $category_type = array("1"=>"单人床","2"=>"双床","3"=>"大床"); ?>
<?php if(is_array($RoomArr)): foreach($RoomArr as $key=>$vo): ?><input type="hidden" name="id" id="id" value="<?php echo ($vo['id']); ?>" />
	<?php $p = json_decode($vo['pics'],true); ?>
	<div class="roomsingle border_color_gray1  ng-scope" data-index="0">
		<div class="roommain  w98">
			<div class="img">
				<img id="img<?php echo ($vo["id"]); ?>" roomid="<?php echo ($vo["id"]); ?>" onclick="imgAjax(<?php echo ($vo["id"]); ?>)" src="http://image.yijiudian.cn<?php echo sp_get_asset_upload_path($p['photo'][0]['url']);?>">
			</div>
			<div class="info info1">
				<div class="desc color_black2">
					<h3 class="color_black1 name f18 ng-binding"><?php echo ($vo["room_name"]); ?></h3>
					<p class="f16 ng-binding ng-scope">

						<em ng-if="room.room_area>0" class="ng-binding ng-scope"><?php echo ($vo["room_area"]); ?>㎡/</em> 可住<?php echo ($vo["imax_guestnum"]); ?>人 <?php echo ($category_type[$vo[category_type]]); ?>
					</p>

					<p class="f14 ng-binding" style="line-height: 20px;"><?php echo ($vo["descp"]); ?></p>
				</div>
				
				<?php $roomprice = $room_price[$vo['id']] ? $room_price[$vo['id']] : $vo['clevel_price0']; $Zprice = $RoomRpArr1[$vo[id]][0]['Zprice'] ? $RoomRpArr1[$vo[id]][0]['Zprice'] : $roomprice; ?>
				<div class="priceblock rplist">
					<span class="singl"><span class="sellprice color_red1 f20 ng-binding" id="price<?php echo ($vo['id']); ?>">￥<?php echo ($Zprice); ?></span><em>起</em></span>
					<span class="jiantou border_color_gray1 close "></span>
				</div>

			</div>
			<div class="clear"></div>
		</div>
		<div class="rateplanlist border_color_gray1" id="prices">
			<?php if(is_array($RoomRpArr1[$vo[id]])): foreach($RoomRpArr1[$vo[id]] as $key=>$v): ?><div class="rateplan border_color_gray1 w98 ng-scope">
					<div class="info">
						<span class="name ng-binding" onclick="tcAjax(<?php echo ($vo["id"]); ?>,<?php echo ($v["id"]); ?>)"><?php echo ($v['rateplanname']); ?></span>
						<span <?php if($v['paymenttype'] == -1): ?>style="display:none;"<?php endif; ?> class="tip f12  ng-binding ng-hide color_blue1 border_color_blue1">提前12小时可取消</span>
						<p class="priceblock">
							<span class="sellprice color_red1 f20 ng-binding" id="prices<?php echo ($v['id']); ?>" data-num="<?php echo ($room_N[$vo['id']][$newdate[0]]); ?>" data-rnum="<?php echo ($NumArr[$vo['id']][$newdate[0]]); ?>"><span id="price<?php echo ($v['id']); ?>">￥<?php echo ($v['Zprice']); ?></span></span>
							<span class="book" data-dateplan="73808" data-num="2">
					<!--<?php if($room_N[$vo['id']][$newdate[0]] < $NumArr[$vo['id']][$newdate[0]]): if($phone): ?><a href="http://diangu.yijiudian.cn/Wechat/Room/room_book?id=<?php echo ($v['id']); ?>&begintime=<?php echo ($sdate); ?>&endtime=<?php echo ($edate); ?>&Zprice=<?php echo ($v['Zprice']); ?>&paymenttype=<?php echo ($v['paymenttype']); ?>"><span class="bg_color_red1 color_white1 ding" >订</span></a>
	        			<?php else: ?>
	        				<a href="<?php echo U('User/reg');?>"><span class="bg_color_red1 color_white1 ding" >订</span></a><?php endif; ?>
					<?php else: ?>

						<span class="bg_color_gray1 color_white1 ding ng-hide">满</span><?php endif; ?>
							<?php if($v['paymenttype'] == -1): ?><span class="border_color_red1 payment ng-binding">到付</span>
								<?php else: ?>
								<span class="border_color_gray1 payment ng-binding ng-hide">预付</span><?php endif; ?>-->
             		<?php if($v['paymenttype'] == -1): if($room_N[$vo['id']][$newdate[0]] < $NumArr[$vo['id']][$newdate[0]]): if($phone): ?><a href="http://diangu.yijiudian.cn/Wechat/Room/room_book?id=<?php echo ($v['id']); ?>&begintime=<?php echo ($sdate); ?>&endtime=<?php echo ($edate); ?>&Zprice=<?php echo ($v['Zprice']); ?>&paymenttype=<?php echo ($v['paymenttype']); ?>"><span class="bg_color_red1 color_white1 ding" >订</span></a>
								<a href="http://diangu.yijiudian.cn/Wechat/Room/room_book?id=<?php echo ($v['id']); ?>&begintime=<?php echo ($sdate); ?>&endtime=<?php echo ($edate); ?>&Zprice=<?php echo ($v['Zprice']); ?>&paymenttype=<?php echo ($v['paymenttype']); ?>" style="color:#757575;"><span class="border_color_red1 payment ng-binding">到付</span></a>
								<!--<a href="index.php?g=Wechat&m=Room&a=room_book&id=<?php echo ($v['id']); ?>&begintime=<?php echo ($sdate); ?>&endtime=<?php echo ($edate); ?>&Zprice=<?php echo ($v['Zprice']); ?>&paymenttype=<?php echo ($v['paymenttype']); ?>"><span class="bg_color_red1 color_white1 ding" >订</span></a>-->
								<!--<a href="index.php?g=Wechat&m=Room&a=room_book&id=<?php echo ($v['id']); ?>&begintime=<?php echo ($sdate); ?>&endtime=<?php echo ($edate); ?>&Zprice=<?php echo ($v['Zprice']); ?>&paymenttype=<?php echo ($v['paymenttype']); ?>" style="color:#757575;"><span class="border_color_red1 payment ng-binding">到付</span></a>-->
					
							<?php else: ?>
								<a href="<?php echo U('User/reg');?>"><span class="bg_color_red1 color_white1 ding" >订</span></a>
								<a href="<?php echo U('User/reg');?>"><span class="border_color_red1 payment ng-binding">到付</span></a><?php endif; ?>
						<?php else: ?>
							<span class="bg_color_gray1 color_white1 ding ng-hide">满</span>	
							<span class="border_color_red1 payment ng-binding">到付</span><?php endif; ?>
					<?php else: ?>
						<?php if($room_N[$vo['id']][$newdate[0]] < $NumArr[$vo['id']][$newdate[0]]): if($phone): ?><a href="http://diangu.yijiudian.cn/Wechat/Room/room_book?id=<?php echo ($v['id']); ?>&begintime=<?php echo ($sdate); ?>&endtime=<?php echo ($edate); ?>&Zprice=<?php echo ($v['Zprice']); ?>&paymenttype=<?php echo ($v['paymenttype']); ?>"><span class="bg_color_red1 color_white1 ding" >订</span></a>
								<a href="http://diangu.yijiudian.cn/Wechat/Room/room_book?id=<?php echo ($v['id']); ?>&begintime=<?php echo ($sdate); ?>&endtime=<?php echo ($edate); ?>&Zprice=<?php echo ($v['Zprice']); ?>&paymenttype=<?php echo ($v['paymenttype']); ?>" style="color:#757575;"><span class="border_color_gray1 payment ng-binding ng-hide">预付</span></a>
							<?php else: ?>
								<a href="<?php echo U('User/reg');?>"><span class="bg_color_red1 color_white1 ding" >订</span></a>
								<a href="<?php echo U('User/reg');?>"><span class="border_color_red1 payment ng-binding">预付</span></a><?php endif; ?>
						<?php else: ?>
							<span class="bg_color_gray1 color_white1 ding ng-hide">满</span>	
							<span class="border_color_red1 payment ng-binding">预付</span><?php endif; endif; ?>
            
								</span>
						</p>
					</div>
				</div><?php endforeach; endif; ?>
			<div class="more color_blue1 border_color_gray1 ng-hide">点击查看更多</div>
		</div>
	</div><?php endforeach; endif; ?>