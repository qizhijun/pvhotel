//"qweibo":"http://v.t.qq.com/share/share.php?title={title}&url={url}&pic={pic}",
//          "renren":"http://share.renren.com/share/buttonshare.do?title={title}&link={url}&pic={pic}",
//          "weibo":"http://v.t.sina.com.cn/share/share.php?title={title}&url={url}&pic={pic}",
//          "qzone":"http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={url}&title={title}&pic={pic}",
//          "facebook":"http://www.facebook.com/sharer/sharer.php?s=100&p[url]={url}}&p[title]={title}&p[summary]={title}&pic={pic}",
//          "twitter":"https://twitter.com/intent/tweet?text={title}&pic={pic}",
//          "kaixin":"http://www.kaixin001.com/rest/records.php?content={title}&url={url}&pic={pic}",
//          "douban": "http://www.douban.com/share/service?bm=&image={pic}&href={url}&updated=&name={title}"
/*title是标题，rLink链接，summary内容，site分享来源，pic分享图片路径*/
/*新浪微博*/
function shareTSina(title, rLink, site, pic) {
    window.open('http://service.weibo.com/share/share.php?title=' + title + '&url=' + encodeURIComponent(rLink) + '&appkey=' + encodeURIComponent(site) + '&pic=' + encodeURIComponent(pic), '_blank', 'scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes');
}
/*腾讯微博*/
function shareToWb(title, rLink, site, pic) {
    window.open('http://v.t.qq.com/share/share.php?url=' + encodeURIComponent(rLink) + '&title=' + title + '&appkey=' + encodeURI(site) + '&pic=' + encodeURI(pic), '_blank', 'scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes');
}
/*人人*/
function shareRR(title, rLink, summary, pic) {
    window.open('http://share.renren.com/share/buttonshare?title=' + title + '&link=' + encodeURIComponent(rLink) + '&context=' + encodeURIComponent(summary) + '&pic=' + encodeURI(pic), '_blank', 'scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes');
}
/*开心网*/
function shareKX(title, rLink, summary) {
    window.open('http://www.kaixin001.com/repaste/bshare.php?rtitle=' + title + 'rurl=' + encodeURIComponent(rLink) + '&rcontent=' + encodeURIComponent(summary), '_blank', 'scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes');
}
/*QQ空间*/
function shareQzone(title, rLink, summary, site, pic) {

    window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' + encodeURIComponent(rLink) + '&site=' + encodeURIComponent(site) + '&title=' + encodeURIComponent(title) + '&summary=' + encodeURIComponent(summary) + '&pics=' + encodeURIComponent(pic), '_blank', 'scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes')

    //window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?title=' + title + '&url=' + encodeURIComponent(rLink) + '&summary=' + summary + '&site=' + encodeURIComponent(site) + '&pic=' + encodeURIComponent(pic), '_blank', 'scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes')
}
/*百度*/
function shareBaiDu(title, rLink) {
    window.open('http://apps.hi.baidu.com/share?title=' + title + '&url=' + encodeURIComponent(rLink), '_blank', 'scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes');
}
/*豆瓣*/
function shareDouBan(title, rLink, pic) {
  
        window.open('http://www.douban.com/share/service?bm=&updated=&image=' + pic + '&name=' + title + '&href=' + encodeURIComponent(rLink), '_blank', 'scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes');
}

//objID需要追加的document元素的ID,wxid微信公众账户的对应的账户,wxname=微信商家名称,title=分享标题,summary=分享内容,rLink=跳转页面,site=站点名,pic=分享图片
function CreateShare(objID, wxid, wxname, title, summary, rLink, site, pic)//标题
{
    $body = $("#" + objID);
    var tempHtml = "<ul>";
    //tempHtml += "<li class='weixin' onclick=\"WeiXinShareBtn('" + wxid + "','" + wxname + "','" + title + "','" + encodeURIComponent(summary) + "','" + rLink + "','" + site + "','" + pic + "')\";>分享到朋友圈</li>";
    tempHtml += "<li class='qzone' onclick=\"shareQzone('" + title + "','" + rLink + "','" + summary + "','" + site + "','" + pic + "')\";>分享到qq空间</li>";
    tempHtml += "<li class='xinlang' onclick=\"shareTSina('" + title + "','" + rLink + "','" + site + "','" + pic + "')\";>分享到新浪微博</li>";
    tempHtml += "<li class='weibo' onclick=\"shareToWb('" + title + "','" + rLink + "','" + site + "','" + pic + "')\";>分享到腾讯微博</li>";
    tempHtml += "<li class='renren' onclick=\"shareRR('" + title + "','" + rLink + "','" + site + "','" + pic + "')\";>分享到人人</li>";
    tempHtml += "<li class='douban' onclick=\"shareDouBan('" + title + "','" + rLink + "','" + pic + "')\";>分享到豆瓣</li>";
    tempHtml += "</ul>";
    $body.append(tempHtml);
}
