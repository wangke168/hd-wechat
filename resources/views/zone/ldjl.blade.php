<?php

//require_once("../classes/jssdk.class.php");
//require_once("../inc/function.php");
//$fn=$_GET["wxnumber"];
$fn=$openid;
if ($fn=="")
{
    $show_flag="false";
}
else{
    $show_flag="true";
}
$project_id="1";
//$jssdk=new JSSDK("wx3e632d57ac5dcc68", "5eadb547deeb37ab3fb3f82078bb2663");
//$signPackage = $jssdk->GetSignPackage();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />

    <title>{{$openid}}</title>
    <link href="{{asset('css/index.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-2.0.3.min.js')}}"></script>

    <script>
        var qhterm ={{$show_flag}};//是否满足取号条件 false不满足,true满足

        //页面加载后即开始第一次定位
        $(function () {
            if (qhterm) {   //满足取号条件,开始定位
                gpsdw();
            }
            else {    //不满足取号条件
                $(".overdiv").show(1)
                        .find(".closebtn").hide(1)
                        .nextAll("span").html("请扫描龙帝惊临二维码后重新取号").css({ "margin-top": "30px" });
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
            if ($(".info").text().indexOf("您所在位置:龙帝惊临取号处")==0) {
                $(".overdiv").show(1)
                        .find(".closebtn").show(1)
                        .nextAll("span").html("您好，只有在龙帝惊临取号范围才能预约,如果您确认在景区请点击点位按钮重新获取您的位置。");
            } else {
                $.get('test.php?p_id=<?php echo $project_id?>&fn=<?php echo $fn?>', function (data) {
                    var content=data;
                    $(".overdiv").show(1)
                            .find(".closebtn").hide(1)
                            .nextAll("span").html(content).css({ "margin-top": "30px" });
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
<script language="JavaScript" >
    function get_wait() {
        $.get("/zone/subscribe/ldjl/get_subscribe/<?php echo $fn?>", function (data) {
        });
    }
</script>


<?php
$pyq_title="秦王宫龙帝惊临智能排队系统";
$imgUrl="http://weix2.hengdianworld.com/control/editor/attached/image/20160324/20160324130222_32090.jpg";
$url="http://weix2.hengdianworld.com/server/wechat/zone/index.php?p_id=1";
?>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>

