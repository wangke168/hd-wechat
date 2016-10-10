<?php

//require_once("../classes/jssdk.class.php");
//require_once("../inc/function.php");
//$fn=$_GET["wxnumber"];
$fn = $openid;
if ($fn == "") {
    $show_flag = "false";
} else {
    $show_flag = "true";
}
$project_id = "1";
//$jssdk=new JSSDK("wx3e632d57ac5dcc68", "5eadb547deeb37ab3fb3f82078bb2663");
//$signPackage = $jssdk->GetSignPackage();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>

    <title>{{$openid}}</title>
    <link href="{{asset('css/index.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-2.0.3.min.js')}}"></script>

    <script>
        {{--var qhterm ={{$show_flag}};//是否满足取号条件 false不满足,true满足--}}
        var qhterm=true;
        //页面加载后即开始第一次定位
        $(function () {
            if (qhterm) {   //满足取号条件,开始定位
                gpsdw();
            }
            else {    //不满足取号条件
                $(".overdiv").show(1)
                        .find(".closebtn").hide(1)
                        .nextAll("span").html("请扫描龙帝惊临二维码后重新取号").css({"margin-top": "30px"});
            }
        })

        //定位
        function gpsdw() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showposition, showerror, {
                    // 指示浏览器获取高精度的位置，默认为false
                    enableHighAccuracy: true,
                    // 指定获取地理位置的超时时间，默认不限时，单位为毫秒
                    timeout: 5000,
                    // 最长有效期，在重复获取地理位置时，此参数指定多久再次获取位置。
                    maximumAge: 3000
                });
            } else {
                alert("非常抱歉,您的浏览器不支持定位功能");
            }
        }

        //输出位置坐标
        function showposition(position) {
            $(".info").html("");
            var weidu = position.coords.latitude;//维度
            var jingdu = position.coords.longitude;//经度
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
        }
        //位置读取错误时
        function showerror(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("您拒绝了定位申请,请重试");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("无法获取到地理位置");
                    break;
                case error.TIMEOUT:
                    alert("请求超时,请重试");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("出现未知原因");
                    break;
            }
            $(".info").html("出现错误,请按提示解决");
        }


        /*取号*/
        function getqh() {
            if ($(".info").text().indexOf("您所在位置:龙帝惊临取号处") == 0) {
                $(".overdiv").show(1)
                        .find(".closebtn").show(1)
                        .nextAll("span").html("您好，只有在龙帝惊临取号范围才能预约,如果您确认在景区请点击点位按钮重新获取您的位置。");
            } else {
                $.get('test.php?p_id=<?php echo $project_id?>&fn=<?php echo $fn?>', function (data) {
                    var content = data;
                    $(".overdiv").show(1)
                            .find(".closebtn").hide(1)
                            .nextAll("span").html(content).css({"margin-top": "30px"});
                });
            }
        }
        /*关闭按钮*/
        function closeoverdiv() {
            $(".overdiv").hide(1);
        }
    </script>

</head>
<body>
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
</body>
</html>
<script language="JavaScript">
    function get_wait() {
        $.get("/zone/subscribe/ldjl/get_subscribe/<?php echo $fn?>", function (data) {
        });
    }
</script>


<?php
$pyq_title = "秦王宫龙帝惊临智能排队系统";
$imgUrl = "http://weix2.hengdianworld.com/control/editor/attached/image/20160324/20160324130222_32090.jpg";
$url = "http://weix2.hengdianworld.com/server/wechat/zone/index.php?p_id=1";
?>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',

            'openLocation',
            'getLocation'
    ), false) ?>);

    wx.ready(function () {
        // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
        document.querySelector('#checkJsApi').onclick = function () {
            wx.checkJsApi({
                jsApiList: [
                    'getNetworkType',
                    'previewImage'
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

        // 2. 分享接口
        // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
        document.querySelector('#onMenuShareAppMessage').onclick = function () {
            wx.onMenuShareAppMessage({
                title: '互联网之子',
                desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
                link: 'http://movie.douban.com/subject/25785114/',
                imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
                trigger: function (res) {
                    // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                    alert('用户点击发送给朋友');
                },
                success: function (res) {
                    alert('已分享');
                },
                cancel: function (res) {
                    alert('已取消');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            alert('已注册获取“发送给朋友”状态事件');
        };

        // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
        document.querySelector('#onMenuShareTimeline').onclick = function () {
            wx.onMenuShareTimeline({
                title: '互联网之子',
                link: 'http://movie.douban.com/subject/25785114/',
                imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
                trigger: function (res) {
                    // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
                    alert('用户点击分享到朋友圈');
                },
                success: function (res) {
                    alert('已分享');
                },
                cancel: function (res) {
                    alert('已取消');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            alert('已注册获取“分享到朋友圈”状态事件');
        };


        // 7 地理位置接口
        // 7.1 查看地理位置
        document.querySelector('#openLocation').onclick = function () {
            wx.openLocation({
                latitude: 23.099994,
                longitude: 113.324520,
                name: 'TIT 创意园',
                address: '广州市海珠区新港中路 397 号',
                scale: 14,
                infoUrl: 'http://weixin.qq.com'
            });
        };

        // 7.2 获取当前地理位置
//        document.querySelector('#getLocation').onclick = function () {
        wx.getLocation({
            success: function (res) {
                var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
                if (latitude > 29.136 && latitude < 29.140 && longitude > 120.306 && longitude < 120.315) {
//                        $(".info").html("您所在位置:龙帝惊临取号处");
                    alert("您所在位置:龙帝惊临取号处");
                }
                else if (latitude > 29.154 && latitude < 29.1549 && longitude > 120.312 && longitude < 120.320) {
//                        $(".info").html("您所在位置:横店影视城有限公司");
                    alert("您所在位置:横店影视城有限公司");
                }
                /*影视城位置以上可注释*/
                else {
//                        $(".info").html("您不在龙帝惊临取号范围");
                    alert("您不在龙帝惊临取号范围");
                }
//                    alert(latitude);
//                    alert(JSON.stringify(res));
            },
            cancel: function (res) {
                alert('用户拒绝授权获取地理位置');
            }
        });
//        };


        // 8.7 关闭当前窗口
        document.querySelector('#closeWindow').onclick = function () {
            wx.closeWindow();
        };


     
    });

    wx.error(function (res) {
        alert(res.errMsg);
    });

</script>