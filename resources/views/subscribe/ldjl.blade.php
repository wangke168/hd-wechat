
<!DOCTYPE html>
<html lang="zh-hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>

    <title></title>
    <link href="{{asset('css/index.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-2.0.3.min.js')}}"></script>


</head>
<body>

</body>



<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('onMenuShareTimeline',
            'onMenuShareAppMessage',
            'getLocation'), true) ?>);

    wx.ready(function () {

        wx.onMenuShareAppMessage({
            title: '龙帝惊临智能预约系统', // 分享标题
            desc: '龙帝惊临智能预约系统', // 分享描述
            link: 'link', // 分享链接
            imgUrl: 'imgUrl', // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                $.get('/count/addrespf/');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        wx.onMenuShareTimeline({
            title: '龙帝惊临智能预约系统',
            link: '龙帝惊临智能预约系统',
            imgUrl: 'imgUrl',
            success: function (res) {
//                alert('已分享');
                $.get('/count/addresp/');
            },
            fail: function (res) {
//                alert(JSON.stringify(res));
            }

        });
        // 7.2 获取当前地理位置
        wx.getLocation({
            success: function (res) {
                alert(JSON.stringify(res));
               /* var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
                */
                $(".info").html("");
                var weidu = res.latitude; //维度
                var jingdu = res.longitude;//经度
                if (weidu > 29.136 && weidu < 29.140 && jingdu > 120.306 && jingdu < 120.315) {
                    $(".info").html("您所在位置:龙帝惊临取号处");
                }
                /*影视城位置以下可注释*/
                else if (weidu > 29.154 && weidu < 29.1549 && jingdu > 120.312 && jingdu < 120.320) {
                    $(".info").html("您所在位置:横店影视城有限公司");
                }
                /*影视城位置以上可注释*/
                else {
                    $(".info").html("您不在龙帝惊临取号范围");
                }

            },
            cancel: function (res) {
                alert('用户拒绝授权获取地理位置');
            }
        });

    });

    wx.error(function (res) {
        alert(res.errMsg);
    });


</script>
</html>