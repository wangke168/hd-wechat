<html>
<head>
    <meta charset="utf-8">
    <title>微信JS-SDK Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="{{asset('css/index.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-2.0.3.min.js')}}"></script>


</head>
<body ontouchstart="">
<div id="page">
    <a class="quhaobtn" href="javascript:getqh()">
        点击取号
    </a>
    <div class="dwlabel">
        <div class="info">
            定位中...
        </div>
        <a class="btn" href="javascript:gpsdw()">
            <i class="gpsico"></i>
            定位
        </a>
    </div>
</div>
<div class="overdiv" style="display:none;">
    <div class="tootip">
        <a class="closebtn" href="javascript:closeoverdiv()">
            +
        </a>
            <span>
                提示区文字
            </span>
    </div>
</div>
<div class="wxapi_container">

    <div class="lbox_close wxapi_form">




        <h3 id="menu-location">地理位置接口</h3>
        <span class="desc">获取地理位置接口</span>
        <button class="btn btn_primary" id="getLocation">getLocation</button>


    </div>
</div>
</body>


<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',


            'openLocation',
            'getLocation'), false) ?>);

    wx.ready(function () {

        wx.getLocation({
            success: function (res) {
                $(".info").html("");
                var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
                if (latitude > 29.136 && latitude < 29.140 && longitude > 120.306 && longitude < 120.315) {
                        $(".info").html("您所在位置:龙帝惊临取号处");
                    alert("您所在位置:龙帝惊临取号处");
                }
                else if (latitude > 29.154 && latitude < 29.1549 && longitude > 120.312 && longitude < 120.320) {
                        $(".info").html("您所在位置:横店影视城有限公司");
                    alert("您所在位置:横店影视城有限公司");
                }
                /*影视城位置以上可注释*/
                else {
                        $(".info").html("您不在龙帝惊临取号范围");
                    alert("您不在龙帝惊临取号范围");
                }
//                    alert(latitude);
//                    alert(JSON.stringify(res));
            },
            cancel: function (res) {
                alert('用户拒绝授权获取地理位置');
            }
        });

        // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
        document.querySelector('#checkJsApi').onclick = function () {
            wx.checkJsApi({
                jsApiList: [
                    /*'getNetworkType',
                    'previewImage'*/
//                    'getLocation'

                ],
                success: function (res) {
//                    alert(JSON.stringify(res));
                    /*                    if (res.checkResult.getLocation == false) {
                     alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
                     return;*/
                }
            });
        };





        // 7.2 获取当前地理位置
//        document.querySelector('#getLocation').onclick = function () {

//        };

        var shareData = {
            title: '微信JS-SDK Demo',
            desc: '微信JS-SDK,帮助第三方为用户提供更优质的移动web服务',
            link: 'http://demo.open.weixin.qq.com/jssdk/',
            imgUrl: 'http://mmbiz.qpic.cn/mmbiz/icTdbqWNOwNRt8Qia4lv7k3M9J1SKqKCImxJCt7j9rHYicKDI45jRPBxdzdyREWnk0ia0N5TMnMfth7SdxtzMvVgXg/0'
        };
        wx.onMenuShareAppMessage(shareData);
        wx.onMenuShareTimeline(shareData);


    });

    wx.error(function (res) {
        alert(res.errMsg);
    });

    var qhterm=true;
    $(function () {
        if (qhterm) {   //满足取号条件,开始定位
//            gpsdw();
        }
        else {    //不满足取号条件
            $(".overdiv").show(1)
                    .find(".closebtn").hide(1)
                    .nextAll("span").html("请扫描龙帝惊临二维码后重新取号").css({ "margin-top": "30px" });
        }
    })
    /*取号*/
    function getqh() {
        if ($(".info").text().indexOf("您所在位置:龙帝惊临取号处")==0) {
            $(".overdiv").show(1)
                    .find(".closebtn").show(1)
                    .nextAll("span").html("您好，只有在龙帝惊临取号范围才能预约,如果您确认在景区请点击点位按钮重新获取您的位置。");
        }
    }
</script>