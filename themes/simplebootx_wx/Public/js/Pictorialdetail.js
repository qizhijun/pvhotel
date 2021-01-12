function HotelintroPictorialdetailController($scope, $http, $timeout, $routeParams, $rootScope, $ocLazyLoad) {
    //require(['/webapp/script/js/hhSwipe.js', '/webapp/script/js/share.js'], function () {
    $ocLazyLoad.load(['themes/simplebootx_wx/Public/js/hhSwipe.js', 'themes/simplebootx_wx/Public/js/share.js']).then(function () {

        $("#div_top_bar").find(".title").html("酒店画报");
        var MagazineID = $routeParams.magazineid;
        // alert(MagazineID);
        //画报列表
        var Pictorialdateil = "/api/v1/HotelIntro/PictorialDetail?MagazineID=" + MagazineID;

        $http.get(Pictorialdateil)
        .success(function (data) {
            if (data.has_val) {
                $scope.detailList = data.result;
                CreateShare("share", "", "", $scope.detailList[0].detailname, $scope.detailList[0].desc, location.href, $scope.hotel_basic_info.hname);

            }
        });

        ////执行完是运行
        $scope.$on('ngRepeatFinished', function (ngRepeatFinishedEvent) {
            //图片滑动
            slider = Swipe($('#imgsTil_all'), {
                auto: 0,
                continuous: true,
                callback: function () {

                    $("#limgs").height(
                        $("#limgs").children().eq(slider.getPos()).height());
                }
            });
            $("#limgs").children().eq(0).find("img").on("load", function () {
                $("#limgs").height($("#limgs").children().eq(0).height());
            })
            //
        });
    })

}