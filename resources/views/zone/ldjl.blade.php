<html>
<head>
    <meta charset="utf-8">
    <title>微信JS-SDK Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <script>
        /*        wx.ready(function () {

         wx.getLocation({
         success: function (res) {
         alert(JSON.stringify(res));
         },
         cancel: function (res) {
         alert('用户拒绝授权获取地理位置');
         }
         });
         });*/
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


<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareQZone',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onVoiceRecordEnd',
            'playVoice',
            'onVoicePlayEnd',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'), false) ?>);

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


        // 3 智能接口
        var voice = {
            localId: '',
            serverId: ''
        };
        // 3.1 识别音频并返回识别结果
        document.querySelector('#translateVoice').onclick = function () {
            if (voice.localId == '') {
                alert('请先使用 startRecord 接口录制一段声音');
                return;
            }
            wx.translateVoice({
                localId: voice.localId,
                complete: function (res) {
                    if (res.hasOwnProperty('translateResult')) {
                        alert('识别结果：' + res.translateResult);
                    } else {
                        alert('无法识别');
                    }
                }
            });
        };

        // 4 音频接口
        // 4.2 开始录音
        document.querySelector('#startRecord').onclick = function () {
            wx.startRecord({
                cancel: function () {
                    alert('用户拒绝授权录音');
                }
            });
        };

        // 4.3 停止录音
        document.querySelector('#stopRecord').onclick = function () {
            wx.stopRecord({
                success: function (res) {
                    voice.localId = res.localId;
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 4.4 监听录音自动停止
        wx.onVoiceRecordEnd({
            complete: function (res) {
                voice.localId = res.localId;
                alert('录音时间已超过一分钟');
            }
        });

        // 4.5 播放音频
        document.querySelector('#playVoice').onclick = function () {
            if (voice.localId == '') {
                alert('请先使用 startRecord 接口录制一段声音');
                return;
            }
            wx.playVoice({
                localId: voice.localId
            });
        };

        // 4.6 暂停播放音频
        document.querySelector('#pauseVoice').onclick = function () {
            wx.pauseVoice({
                localId: voice.localId
            });
        };

        // 4.7 停止播放音频
        document.querySelector('#stopVoice').onclick = function () {
            wx.stopVoice({
                localId: voice.localId
            });
        };

        // 4.8 监听录音播放停止
        wx.onVoicePlayEnd({
            complete: function (res) {
                alert('录音（' + res.localId + '）播放结束');
            }
        });

        // 4.8 上传语音
        document.querySelector('#uploadVoice').onclick = function () {
            if (voice.localId == '') {
                alert('请先使用 startRecord 接口录制一段声音');
                return;
            }
            wx.uploadVoice({
                localId: voice.localId,
                success: function (res) {
                    alert('上传语音成功，serverId 为' + res.serverId);
                    voice.serverId = res.serverId;
                }
            });
        };

        // 4.9 下载语音
        document.querySelector('#downloadVoice').onclick = function () {
            if (voice.serverId == '') {
                alert('请先使用 uploadVoice 上传声音');
                return;
            }
            wx.downloadVoice({
                serverId: voice.serverId,
                success: function (res) {
                    alert('下载语音成功，localId 为' + res.localId);
                    voice.localId = res.localId;
                }
            });
        };

        // 5 图片接口
        // 5.1 拍照、本地选图
        var images = {
            localId: [],
            serverId: []
        };
        document.querySelector('#chooseImage').onclick = function () {
            wx.chooseImage({
                success: function (res) {
                    images.localId = res.localIds;
                    alert('已选择 ' + res.localIds.length + ' 张图片');
                }
            });
        };

        // 5.2 图片预览
        document.querySelector('#previewImage').onclick = function () {
            wx.previewImage({
                current: 'http://img5.douban.com/view/photo/photo/public/p1353993776.jpg',
                urls: [
                    'http://img3.douban.com/view/photo/photo/public/p2152117150.jpg',
                    'http://img5.douban.com/view/photo/photo/public/p1353993776.jpg',
                    'http://img3.douban.com/view/photo/photo/public/p2152134700.jpg'
                ]
            });
        };

        // 5.3 上传图片
        document.querySelector('#uploadImage').onclick = function () {
            if (images.localId.length == 0) {
                alert('请先使用 chooseImage 接口选择图片');
                return;
            }
            var i = 0, length = images.localId.length;
            images.serverId = [];
            function upload() {
                wx.uploadImage({
                    localId: images.localId[i],
                    success: function (res) {
                        i++;
                        //alert('已上传：' + i + '/' + length);
                        images.serverId.push(res.serverId);
                        if (i < length) {
                            upload();
                        }
                    },
                    fail: function (res) {
                        alert(JSON.stringify(res));
                    }
                });
            }

            upload();
        };

        // 5.4 下载图片
        document.querySelector('#downloadImage').onclick = function () {
            if (images.serverId.length === 0) {
                alert('请先使用 uploadImage 上传图片');
                return;
            }
            var i = 0, length = images.serverId.length;
            images.localId = [];
            function download() {
                wx.downloadImage({
                    serverId: images.serverId[i],
                    success: function (res) {
                        i++;
                        alert('已下载：' + i + '/' + length);
                        images.localId.push(res.localId);
                        if (i < length) {
                            download();
                        }
                    }
                });
            }

            download();
        };

        // 6 设备信息接口
        // 6.1 获取当前网络状态
        document.querySelector('#getNetworkType').onclick = function () {
            wx.getNetworkType({
                success: function (res) {
                    alert(res.networkType);
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
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

        // 8 界面操作接口
        // 8.1 隐藏右上角菜单
        document.querySelector('#hideOptionMenu').onclick = function () {
            wx.hideOptionMenu();
        };

        // 8.2 显示右上角菜单
        document.querySelector('#showOptionMenu').onclick = function () {
            wx.showOptionMenu();
        };

        // 8.3 批量隐藏菜单项
        document.querySelector('#hideMenuItems').onclick = function () {
            wx.hideMenuItems({
                menuList: [
                    'menuItem:readMode', // 阅读模式
                    'menuItem:share:timeline', // 分享到朋友圈
                    'menuItem:copyUrl' // 复制链接
                ],
                success: function (res) {
                    alert('已隐藏“阅读模式”，“分享到朋友圈”，“复制链接”等按钮');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 8.4 批量显示菜单项
        document.querySelector('#showMenuItems').onclick = function () {
            wx.showMenuItems({
                menuList: [
                    'menuItem:readMode', // 阅读模式
                    'menuItem:share:timeline', // 分享到朋友圈
                    'menuItem:copyUrl' // 复制链接
                ],
                success: function (res) {
                    alert('已显示“阅读模式”，“分享到朋友圈”，“复制链接”等按钮');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 8.5 隐藏所有非基本菜单项
        document.querySelector('#hideAllNonBaseMenuItem').onclick = function () {
            wx.hideAllNonBaseMenuItem({
                success: function () {
                    alert('已隐藏所有非基本菜单项');
                }
            });
        };

        // 8.6 显示所有被隐藏的非基本菜单项
        document.querySelector('#showAllNonBaseMenuItem').onclick = function () {
            wx.showAllNonBaseMenuItem({
                success: function () {
                    alert('已显示所有非基本菜单项');
                }
            });
        };

        // 8.7 关闭当前窗口
        document.querySelector('#closeWindow').onclick = function () {
            wx.closeWindow();
        };

        // 9 微信原生接口
        // 9.1.1 扫描二维码并返回结果
        document.querySelector('#scanQRCode0').onclick = function () {
            wx.scanQRCode();
        };
        // 9.1.2 扫描二维码并返回结果
        document.querySelector('#scanQRCode1').onclick = function () {
            wx.scanQRCode({
                needResult: 1,
                desc: 'scanQRCode desc',
                success: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        };

        // 10 微信支付接口
        // 10.1 发起一个支付请求
        document.querySelector('#chooseWXPay').onclick = function () {
            // 注意：此 Demo 使用 2.7 版本支付接口实现，建议使用此接口时参考微信支付相关最新文档。
            wx.chooseWXPay({
                timestamp: 1414723227,
                nonceStr: 'noncestr',
                package: 'addition=action_id%3dgaby1234%26limit_pay%3d&bank_type=WX&body=innertest&fee_type=1&input_charset=GBK&notify_url=http%3A%2F%2F120.204.206.246%2Fcgi-bin%2Fmmsupport-bin%2Fnotifypay&out_trade_no=1414723227818375338&partner=1900000109&spbill_create_ip=127.0.0.1&total_fee=1&sign=432B647FE95C7BF73BCD177CEECBEF8D',
                signType: 'SHA1', // 注意：新版支付接口使用 MD5 加密
                paySign: 'bd5b1933cda6e9548862944836a9b52e8c9a2b69'
            });
        };

        // 11.3  跳转微信商品页
        document.querySelector('#openProductSpecificView').onclick = function () {
            wx.openProductSpecificView({
                productId: 'pDF3iY_m2M7EQ5EKKKWd95kAxfNw',
                extInfo: '123'
            });
        };

        // 12 微信卡券接口
        // 12.1 添加卡券
        document.querySelector('#addCard').onclick = function () {
            wx.addCard({
                cardList: [
                    {
                        cardId: 'p2e-YuLyjE-EbQpZd3-F2-ayqAfQ',
                        cardExt: '{"code": "", "openid": "", "timestamp": "1474357424", "signature":"46343759d52d62260a9dca0b6a4c504fe2fe8d62"}'
                    },
                    {
                        cardId: 'p2e-YuPji_LBT34qx0xSCE4LKj-E',
                        cardExt: '{"code": "", "openid": "", "timestamp": "1474353655", "signature":"fc056a3f1276cb8ab78c6776ccb64de9b983bf63"}'
                    }
                ],
                success: function (res) {
                    alert('已添加卡券：' + JSON.stringify(res.cardList));
                },
                cancel: function (res) {
                    alert(JSON.stringify(res))
                }
            });
        };

        var codes = [];
        // 12.2 选择卡券
        document.querySelector('#chooseCard').onclick = function () {
            wx.chooseCard({
                cardSign: '6caa49f4a5af3d64ac247e1f563e5b5eb94619ad',
                timestamp: 1437997723,
                nonceStr: 'k0hGdSXKZEj3Min5',
                success: function (res) {
                    res.cardList = JSON.parse(res.cardList);
                    encrypt_code = res.cardList[0]['encrypt_code'];
                    alert('已选择卡券：' + JSON.stringify(res.cardList));
                    decryptCode(encrypt_code, function (code) {
                        codes.push(code);
                    });
                },
                cancel: function (res) {
                    alert(JSON.stringify(res))
                }
            });
        };

        // 12.3 查看卡券
        document.querySelector('#openCard').onclick = function () {
            if (codes.length < 1) {
                alert('请先使用 chooseCard 接口选择卡券。');
                return false;
            }
            var cardList = [];
            for (var i = 0; i < codes.length; i++) {
                cardList.push({
                    cardId: 'pDF3iY9tv9zCGCj4jTXFOo1DxHdo',
                    code: codes[i]
                });
            }
            wx.openCard({
                cardList: cardList,
                cancel: function (res) {
                    alert(JSON.stringify(res))
                }
            });
        };

        var shareData = {
            title: '微信JS-SDK Demo',
            desc: '微信JS-SDK,帮助第三方为用户提供更优质的移动web服务',
            link: 'http://demo.open.weixin.qq.com/jssdk/',
            imgUrl: 'http://mmbiz.qpic.cn/mmbiz/icTdbqWNOwNRt8Qia4lv7k3M9J1SKqKCImxJCt7j9rHYicKDI45jRPBxdzdyREWnk0ia0N5TMnMfth7SdxtzMvVgXg/0'
        };
        wx.onMenuShareAppMessage(shareData);
        wx.onMenuShareTimeline(shareData);

        function decryptCode(code, callback) {
            $.getJSON('/jssdk/decrypt_code.php?code=' + encodeURI(code), function (res) {
                if (res.errcode == 0) {
                    codes.push(res.code);
                }
            });
        }
    });

    wx.error(function (res) {
        alert(res.errMsg);
    });

</script>