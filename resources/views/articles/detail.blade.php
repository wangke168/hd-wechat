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

        {!!str_replace("/control/editor/attached/image/","http://weix2.hengdianworld.com/control/editor/attached/image/",$article->content)!!}
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
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo $js->config(array('checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',


            'openLocation',
            'getLocation'), false) ?>);

        wx.ready(function () {

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

            // 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口
            document.querySelector('#onMenuShareQQ').onclick = function () {
                wx.onMenuShareQQ({
                    title: '互联网之子',
                    desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
                    link: 'http://movie.douban.com/subject/25785114/',
                    imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
                    trigger: function (res) {
                        alert('用户点击分享到QQ');
                    },
                    complete: function (res) {
                        alert(JSON.stringify(res));
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
                alert('已注册获取“分享到 QQ”状态事件');
            };

            // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
            document.querySelector('#onMenuShareWeibo').onclick = function () {
                wx.onMenuShareWeibo({
                    title: '互联网之子',
                    desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
                    link: 'http://movie.douban.com/subject/25785114/',
                    imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
                    trigger: function (res) {
                        alert('用户点击分享到微博');
                    },
                    complete: function (res) {
                        alert(JSON.stringify(res));
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
                alert('已注册获取“分享到微博”状态事件');
            };

            // 2.5 监听“分享到QZone”按钮点击、自定义分享内容及分享接口
            document.querySelector('#onMenuShareQZone').onclick = function () {
                wx.onMenuShareQZone({
                    title: '互联网之子',
                    desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
                    link: 'http://movie.douban.com/subject/25785114/',
                    imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
                    trigger: function (res) {
                        alert('用户点击分享到QZone');
                    },
                    complete: function (res) {
                        alert(JSON.stringify(res));
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
                alert('已注册获取“分享到QZone”状态事件');
            };



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



        /*关闭按钮*/
        function closeoverdiv() {
            $(".overdiv").hide(1);
        }
    </script>