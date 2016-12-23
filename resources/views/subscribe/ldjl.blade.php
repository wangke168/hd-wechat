<?php

$fn = $openid;
if ($fn == "") {
    $show_flag = "false";
} else {
    $show_flag = "true";
}
$project_id = "1";

?>

<!DOCTYPE html>
<html lang="zh-hans">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>

    <title>龙帝惊临智能预约系统</title>
    <link href="{{asset('css/index.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-2.0.3.min.js')}}"></script>

    <script>
        var qhterm ={{$show_flag}};//是否满足取号条件 false不满足,true满足

        //页面加载后即开始第一次定位
        $(function () {
            if (!qhterm)  {    //不满足取号条件
                $(".overdiv").show(1)
                        .find(".closebtn").hide(1)
                        .nextAll("span").html("请扫描龙帝惊临二维码后重新取号").css({"margin-top": "30px"});
            }
        });


        /*取号*/
        function getqh() {
//            alert ($(".info").text().indexOf("您所在位置:龙帝惊临取号处") );
            if ($(".info").text().indexOf("您所在位置:龙帝惊临取号处") < 0) {
                $(".overdiv").show(1)
                        .find(".closebtn").hide(1)
                        .nextAll("span").html("您好，只有在龙帝惊临取号范围才能预约。").css({"margin-top": "30px"});
            } else {
                $.get('/zone/subscribe/get?project_id=<?php echo $project_id?>&fn=<?php echo $fn?>', function (data) {
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



<?php
$pyq_title = "秦王宫龙帝惊临智能排队系统";
$imgUrl = "http://weix2.hengdianworld.com/control/editor/attached/image/20160324/20160324130222_32090.jpg";
$url = "http://wechat.hengdianworld.com/zone/subscribe/ldjl?project_id=1";
?>


<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('onMenuShareTimeline',
            'onMenuShareAppMessage',
            'getLocation'), false) ?>);

    wx.ready(function () {

        wx.onMenuShareAppMessage({
            title: '<?php echo $pyq_title ?>', // 分享标题
            desc: '<?php echo $pyq_title ?>', // 分享描述
            link: '<?php echo $url ?>', // 分享链接
            imgUrl: '<?php echo $imgUrl ?>', // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
            //    $.get('/count/addrespf/');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        wx.onMenuShareTimeline({
            title: '<?php echo $pyq_title ?>',
            link: '<?php echo $url ?>',
            imgUrl: '<?php echo $imgUrl ?>',
            success: function (res) {
//                alert('已分享');
        //        $.get('/count/addresp/');
            },
            fail: function (res) {
//                alert(JSON.stringify(res));
            }

        });
        // 7.2 获取当前地理位置
        wx.getLocation({
            success: function (res) {
//                alert(JSON.stringify(res));
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
