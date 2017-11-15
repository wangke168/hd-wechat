<!DOCTYPE html>
<!-- saved from url=(0039)http://m.hengdianworld.com/info_jq.aspx -->
<html xmlns="http://www.w3.org/1999/xhtml" style="font-size: 58.5938px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title')</title>
    <meta name="description" content="横店圆明新园  景点介绍 景区介绍">
    <meta name="keywords" content="横店圆明新园  景点介绍 景区介绍">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <!--使用CHROME做渲染-->
    <meta name="renderer" content="webkit"><!--使用极速模式-->
    <link href="{{asset('css/navbar.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/shows.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/infojq.css')}}" rel="stylesheet" type="text/css"/>
    <script src="https://hm.baidu.com/hm.js?9cf3075d2f6b03afedf5cf5de9e612bd"></script>
    <script src="https://hm.baidu.com/hm.js?5a64c36e04cedc2deb51ec4451adc81b"></script>
    <script src="{{asset('js/jquery-1.10.2.js')}}"></script>
    <style type="text/css">
        :root #header + #content > #left > #rlblock_left,
        :root #content > #right > .dose > .dosesingle,
        :root #content > #center > .dose > .dosesingle {
            display: none !important;
        }</style>
    <script src="{{asset('js/deSetUrl.js')}}"></script>
    <!--引入js-->
    <script>
        document.documentElement.style.fontSize = s = document.documentElement.clientWidth / 6.4 + 'px';  //便于计算，设置默认文本字体像素以100px为基准，设计稿是640px宽度设计
        //alert(s);
    </script>

    <style type="text/css">
        #bottom {
            background-color: #eac14d;
            height: 40px;
            margin: 0 auto;
            padding: 10px 0;
            text-align: center;
            line-height: 20px;
            font-size: 12px;
            color: #FFF;
        }

    </style>
</head>
<body style="">

<link type="text/css" href="{{asset('css/headnav.css')}}" rel="stylesheet">

<div class="hdHeader-main">
    <div id="header" style="display: none;"></div><!--微信端使用-->
    <div id="header_web"><!--移动端使用-->
        {{--<span class="left-head" onclick="javascript:history.go(-1);"></span>--}}
        {{--<span class="right-head show-category"></span>--}}
        <span id="header_tit">@yield('header_tit')</span>
    </div>
</div>

{{--<div class="hdHeader-nav active" style="display: none;">
    <ul class="nav-list">
        <li><a href="http://e.hengdianworld.com/mobile/epay.aspx"><span class="t1">门票</span></a></li>
        <li><a href="http://e.hengdianworld.com/yd_tc.aspx"><span class="t2">优惠套餐</span></a></li>
        <li><a href="http://e.hengdianworld.com/yd_hotel.aspx"><span class="t3">酒店</span></a></li>
        <li><a href="http://z.hengdianworld.com/2017mfilms/"><span class="t4">微电影</span></a></li>
        <li><a href="http://m.hengdianworld.com/Foods.aspx"><span class="t5">美食</span></a></li>
        <li><a href="http://m.hengdianworld.com/Crew.aspx"><span class="t6">剧组动态</span></a></li>
        <div class="clear"></div>
    </ul>
</div>--}}
<div class="hdHeader-nav-mask" style="display: none;" id="mask"></div>
<div class="stip"></div>
<script>
    $(function () {
        $('.show-category').click(function () {
            $('.active').slideToggle("fast");
            $('.hdHeader-nav-mask').toggle();
        })
        $('#mask').click(function () {
            $('.hdHeader-nav-mask').toggle();
            $('.active').slideToggle("fast");
        })
    })
</script>

@yield('content')

<div id="bottom">
    <div style="color:#fff;"><img src="{{asset('images/tel.png')}}" width="15" height="15" border=0/>
        热线电话：<a href="tel:057989600055"> <span style="color: white">0579-89600055</span></a>
    </div>
    <div>©2013-2017 横店圆明新园 版权所有</div>
</div>
</body>
</html>