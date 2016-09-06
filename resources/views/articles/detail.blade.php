    <html xmlns="http://www.w3.org/1999/xhtml">
    <head id="Head2">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <meta name="MobileOptimized" content="320"/>
        <meta name="copyright" content="Copyright &copy; 2013 hengdianworld.com Inc. All Rights Reserved."/>
        <meta name="description" content="掌上横店！掌上横店是国家5A级旅游景区横店影视城的移动门户- m.hengdianworld.com"/>
        <meta name="keywords" content="掌上横店,掌上横店影视城,横店影视城手机版网站"/>
        <title>{{$article->title}}</title>
        <link href="{{asset('css/mbcss.css')}}" rel="stylesheet" type="text/css"/>
        <style type="text/css">
            img {
                max-width: 100%;
            }
        </style>
        <script src="{{asset('js/jquery-1.10.2.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/divheight.js')}}"></script>
        <script type="text/ecmascript"
                src="http://mat1.gtimg.com/www/asset/lib/jquery/jquery/jquery-1.11.1.min.js"></script>
        <script>
            $(function () {
                var awidth = parseInt($(document).width());//获取屏幕的宽度
                $("iframe").css({"width": "100%"})  //设置宽度
                    .height(awidth / 4 * 3);  //设置高度
            })
        </script>

    </head>
    <body>


    <div id="main">

        <div id="header">
            <!--       <span class="left-head"  onclick="javascript:history.go(-1);"></span>
                   <span class="right-head" onclick="javascript:location.href='http://m.hengdianworld.com';"></span>
         -->

        </div>
        <div id="title">
            {{$article->title}}</div>
        <div id="titleinfo">
            横店影视城        {{$article->adddate}}</div>
        <div id="contents">

        {!!$article->content!!}
         </div>

        <div id="tempheight" style="clear:both;  "></div>
        <div id="bottom">
            <div style="color:#fff;"><img src="{{asset('images/tel.png')}}" width="15" height="15" border=0/>
                热线电话：<a href="tel:4009999141"> 400-9999141</a>
            </div>
            <div>©2013-2014 横店影视城 版权所有</div>
        </div>

    </div>

    </body>
    </html>