<html>
<head>
    <meta charset="utf-8">
    <title>微信JS-SDK Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body ontouchstart="">
<div class="wxapi_container">
    <div class="wxapi_index_container">
        <ul class="label_box lbox_close wxapi_index_list">
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-basic">基础接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-share">分享接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-image">图像接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-voice">音频接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-smart">智能接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-device">设备信息接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-location">地理位置接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-webview">界面操作接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-scan">微信扫一扫接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-shopping">微信小店接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-card">微信卡券接口</a></li>
            <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-pay">微信支付接口</a></li>
        </ul>
    </div>
    <div class="lbox_close wxapi_form">
        <h3 id="menu-basic">基础接口</h3>
        <span class="desc">判断当前客户端是否支持指定JS接口</span>
        <button class="btn btn_primary" id="checkJsApi">checkJsApi</button>

        <h3 id="menu-share">分享接口</h3>
        <span class="desc">获取“分享到朋友圈”按钮点击状态及自定义分享内容接口</span>
        <button class="btn btn_primary" id="onMenuShareTimeline">onMenuShareTimeline</button>
        <span class="desc">获取“分享给朋友”按钮点击状态及自定义分享内容接口</span>
        <button class="btn btn_primary" id="onMenuShareAppMessage">onMenuShareAppMessage</button>
        <span class="desc">获取“分享到QQ”按钮点击状态及自定义分享内容接口</span>
        <button class="btn btn_primary" id="onMenuShareQQ">onMenuShareQQ</button>
        <span class="desc">获取“分享到腾讯微博”按钮点击状态及自定义分享内容接口</span>
        <button class="btn btn_primary" id="onMenuShareWeibo">onMenuShareWeibo</button>
        <span class="desc">获取“分享到QZone”按钮点击状态及自定义分享内容接口</span>
        <button class="btn btn_primary" id="onMenuShareQZone">onMenuShareQZone</button>

        <h3 id="menu-image">图像接口</h3>
        <span class="desc">拍照或从手机相册中选图接口</span>
        <button class="btn btn_primary" id="chooseImage">chooseImage</button>
        <span class="desc">预览图片接口</span>
        <button class="btn btn_primary" id="previewImage">previewImage</button>
        <span class="desc">上传图片接口</span>
        <button class="btn btn_primary" id="uploadImage">uploadImage</button>
        <span class="desc">下载图片接口</span>
        <button class="btn btn_primary" id="downloadImage">downloadImage</button>

        <h3 id="menu-voice">音频接口</h3>
        <span class="desc">开始录音接口</span>
        <button class="btn btn_primary" id="startRecord">startRecord</button>
        <span class="desc">停止录音接口</span>
        <button class="btn btn_primary" id="stopRecord">stopRecord</button>
        <span class="desc">播放语音接口</span>
        <button class="btn btn_primary" id="playVoice">playVoice</button>
        <span class="desc">暂停播放接口</span>
        <button class="btn btn_primary" id="pauseVoice">pauseVoice</button>
        <span class="desc">停止播放接口</span>
        <button class="btn btn_primary" id="stopVoice">stopVoice</button>
        <span class="desc">上传语音接口</span>
        <button class="btn btn_primary" id="uploadVoice">uploadVoice</button>
        <span class="desc">下载语音接口</span>
        <button class="btn btn_primary" id="downloadVoice">downloadVoice</button>

        <h3 id="menu-smart">智能接口</h3>
        <span class="desc">识别音频并返回识别结果接口</span>
        <button class="btn btn_primary" id="translateVoice">translateVoice</button>

        <h3 id="menu-device">设备信息接口</h3>
        <span class="desc">获取网络状态接口</span>
        <button class="btn btn_primary" id="getNetworkType">getNetworkType</button>

        <h3 id="menu-location">地理位置接口</h3>
        <span class="desc">使用微信内置地图查看位置接口</span>
        <button class="btn btn_primary" id="openLocation">openLocation</button>
        <span class="desc">获取地理位置接口</span>
        <button class="btn btn_primary" id="getLocation">getLocation</button>

        <h3 id="menu-webview">界面操作接口</h3>
        <span class="desc">隐藏右上角菜单接口</span>
        <button class="btn btn_primary" id="hideOptionMenu">hideOptionMenu</button>
        <span class="desc">显示右上角菜单接口</span>
        <button class="btn btn_primary" id="showOptionMenu">showOptionMenu</button>
        <span class="desc">关闭当前网页窗口接口</span>
        <button class="btn btn_primary" id="closeWindow">closeWindow</button>
        <span class="desc">批量隐藏功能按钮接口</span>
        <button class="btn btn_primary" id="hideMenuItems">hideMenuItems</button>
        <span class="desc">批量显示功能按钮接口</span>
        <button class="btn btn_primary" id="showMenuItems">showMenuItems</button>
        <span class="desc">隐藏所有非基础按钮接口</span>
        <button class="btn btn_primary" id="hideAllNonBaseMenuItem">hideAllNonBaseMenuItem</button>
        <span class="desc">显示所有功能按钮接口</span>
        <button class="btn btn_primary" id="showAllNonBaseMenuItem">showAllNonBaseMenuItem</button>

        <h3 id="menu-scan">微信扫一扫</h3>
        <span class="desc">调起微信扫一扫接口</span>
        <button class="btn btn_primary" id="scanQRCode0">scanQRCode(微信处理结果)</button>
        <button class="btn btn_primary" id="scanQRCode1">scanQRCode(直接返回结果)</button>

        <h3 id="menu-shopping">微信小店接口</h3>
        <span class="desc">跳转微信商品页接口</span>
        <button class="btn btn_primary" id="openProductSpecificView">openProductSpecificView</button>

        <h3 id="menu-card">微信卡券接口</h3>
        <span class="desc">批量添加卡券接口</span>
        <button class="btn btn_primary" id="addCard">addCard</button>
        <span class="desc">调起适用于门店的卡券列表并获取用户选择列表</span>
        <button class="btn btn_primary" id="chooseCard">chooseCard</button>
        <span class="desc">查看微信卡包中的卡券接口</span>
        <button class="btn btn_primary" id="openCard">openCard</button>

        <h3 id="menu-pay">微信支付接口</h3>
        <span class="desc">发起一个微信支付请求</span>
        <button class="btn btn_primary" id="chooseWXPay">chooseWXPay</button>
    </div>
</div>
</body>

    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo $js->config(array('onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareQZone'), false) ?>);

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
                title: '微信JS-SDK Demo11',
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

    </script>

    </html>