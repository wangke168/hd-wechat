<!DOCTYPE html>
<html lang="zh-hans">
<head id="Head2">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta name="MobileOptimized" content="320"/>
    <meta name="copyright" content="Copyright &copy; 2013 hengdianworld.com Inc. All Rights Reserved."/>
    <meta name="description" content="掌上横店！掌上横店是国家5A级旅游景区横店影视城的移动门户- m.hengdianworld.com"/>
    <meta name="keywords" content="掌上横店,掌上横店影视城,横店影视城手机版网站"/>
    <title></title>
    <link href="{{asset('css/mbcss.css')}}" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        img {
            max-width: 100%;
        }
    </style>
    <script src="{{asset('js/jquery-1.10.2.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/divheight.js')}}"></script>



</head>
<body>


<div id="main">

    <div id="header">
        <!--       <span class="left-head"  onclick="javascript:history.go(-1);"></span>
               <span class="right-head" onclick="javascript:location.href='http://m.hengdianworld.com';"></span>
     -->

    </div>
    <div id="title">
        </div>
    <div id="titleinfo">
        横店影视城 </div>
    <div id="contents">



    </div>

    <div id="tempheight" style="clear:both;  "></div>
    <div id="bottom">
        <div style="color:#fff;"><img src="{{asset('images/tel.png')}}" width="15" height="15" border=0/>
            热线电话：<a href="tel:057986547211"> 0579-86547211</a>
        </div>
        <div>©2013-2014 横店影视城 版权所有</div>
    </div>

</div>
</body>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('onMenuShareTimeline',
            'onMenuShareAppMessage',
            'getLocation'), false) ?>);

    wx.ready(function () {

        wx.onMenuShareAppMessage({
            title: '秦王宫龙帝惊临智能排队系统', // 分享标题
            desc: '秦王宫龙帝惊临智能排队系统', // 分享描述
            link: '秦王宫龙帝惊临智能排队系统', // 分享链接
            imgUrl: '秦王宫龙帝惊临智能排队系统', // 分享图标
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
            title: '秦王宫龙帝惊临智能排队系统',
            link: '秦王宫龙帝惊临智能排队系统',
            imgUrl: '秦王宫龙帝惊临智能排队系统',
            success: function (res) {
//                alert('已分享');
                $.get('/count/addresp/');
            },
            fail: function (res) {
//                alert(JSON.stringify(res));
            }

        });
        wx.getLocation({
            success: function (res) {
                alert(JSON.stringify(res));
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