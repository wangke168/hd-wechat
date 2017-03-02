<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>{!! $row_zone->zone_name !!}2017年演艺秀时间表_横店影视城</title>
    <meta name="keywords" content="商业报道,科技新闻,生活方式,智能,火箭,航天,马斯克,SpaceX">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
    <script type="text/javascript">function resetImgHeight(A, e) {
            var t, i, a, o = 0;
            for (t = 0, i = A.length; t < i; t++)A[t].src = e, a = A[t].clientWidth, A[t].attributes["data-ratio"] && (o = A[t].attributes["data-ratio"].value || 0, o = parseFloat(o)), o && (A[t].style.height = a * o + "px")
        }
        !function () {
            function A(A, e) {
                var t, i, a = new Image, o = !1;
                a.onload = function () {
                    o = !!(a.height > 0 && a.width > 0), i = o ? " " + e : " no-" + e, t = document.querySelector("html").className, t += i, document.querySelector("html").className = t.trim()
                }, a.onerror = function () {
                    i = " no-" + e, t = document.querySelector("html").className, t += i, document.querySelector("html").className = t.trim()
                }, a.src = A
            }

            var e = "data:image/webp;base64,UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoBAAEAAwA0JaQAA3AA/vuUAAA=", t = "data:image/webp;base64,UklGRlIAAABXRUJQVlA4WAoAAAASAAAAAAAAAAAAQU5JTQYAAAD/////AABBTk1GJgAAAAAAAAAAAAAAAAAAAGQAAABWUDhMDQAAAC8AAAAQBxAREYiI/gcA";
            A(e, "webp"), A(t, "webpanimation")
        }(), window.DeviceInfo = function () {
            var A = navigator.userAgent;
            return {
                isMobile: /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(A),
                isIOS: /iPad|iPhone|iPod/i.test(A),
                isAndroid: /android/i.test(A),
                isQdaily: /QDaily/i.test(A)
            }
        }()</script>
    <script type="text/javascript">!function (e) {
            function n() {
                document.documentElement.style.fontSize = document.documentElement.clientWidth / 16 + "px", window.jQuery && window.jQuery(window).trigger("refreshBasesize")
            }

            var t = null;
            window.addEventListener("resize", function () {
                clearTimeout(t), t = setTimeout(n, 300)
            }, !1), n()
        }(window)</script>
    <script type="text/javascript">!function () {
            function e(e) {
                var i;
                return e && (i = e.match(/\.(gif|png|jpg|jpeg|webp)/gi), i && i[0]) ? i[0].slice(1).toLowerCase() : ""
            }

            function i(i) {
                var a, t, o, r = Math.round(window.devicePixelRatio || 1), c = [1, 1, 1.5, 2, 2, 2], l = document.querySelector("html"), d = /(^|\s)webp(\s|$)/i.test(l.className), n = /(^|\s)webpanimation(\s|$)/i.test(l.className), m = l.clientWidth, p = /img\.qdaily\.com\//.test(i), g = e(i);
                return i && p && g && "webp" != g ? (t = "gif" != g && d, a = "gif" == g && n, i = i.replace(/\/(thumbnail|crop)\/.*?(\d+)x(\d+)[^\/]*\//gi, function (e, i, a, t) {
                    return r > 1 && (a = Math.round(a * c[r]), t = Math.round(t * c[r]), e = e.replace(/\d+x\d+/, a + "x" + t)), e
                }), (t || a) && (i = i.replace(/\/format\/([^\/]*)/gi, function (e, i) {
                    return "/format/webp"
                }), o = t ? /(-w\d+)/gi : /(-w\d+Gif)/gi, i = i.replace(o, function (e) {
                    var i = m * r;
                    return DeviceInfo.isMobile ? i >= 1080 ? "-WebpMobileW750" : i >= 540 ? "-WebpMobileW550" : "-WebpMobileW350" : "-WebpWebW640"
                })), i) : i
            }

            resetImgQuantity = function (e) {
                var a, t, o, r, c, l, d = [".com-grid-article .pic img.lazyload", ".com-grid-banner-article .pic img.lazyload", ".com-grid-key-article .pic img.lazyload", ".com-grid-paper .pic img.lazyload", ".com-grid-key-paper .pic img.lazyload", ".com-grid-column .pic img.lazyload", ".com-paper-detail .options .pic img.lazyload", ".com-article-detail .detail img.lazyload", ".com-card-article .detail img.lazyload", ".com-card-popup .detail img.lazyload", ".com-card-face .content img.lazyload"].join(", ");
                for (e && $ ? (a = $('<div class="wrapper-container"></div>').append(e), t = a.find(d)) : t = document.querySelectorAll(d), o = 0, r = t.length; o < r; o++)c = t[o], l = c.attributes["data-src"].value, l = i(l), c.attributes["data-src"].value = l
            }, window.resetImgQuantity = resetImgQuantity
        }()</script>

    <link href="{{asset('lib/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('lib/show.css')}}" rel="stylesheet" type="text/css"/>
    <meta name="csrf-param" content="authenticity_token"/>
    <meta name="csrf-token"
          content="q+lpL1DPr70x/aquafoz8juXwpvlcM9qAgJ82ntU94/IWIoMJAjK+Gz/+mZUgO8RX8v0X+O3y+/Erfq3WV5ybg=="/>
</head>
<body class="mobile articles show">

<div class="page-content">
    <div class="com-article-detail short" data-categoryid="4">
        <div class="article-detail-hd">

            <?php
            $date = Carbon\Carbon::now()->toDateString();
            $zone = new \App\WeChat\Zone();
      //      $zone_name = $zone->get_zone_info($zone_id)->zone_name;
            ?>

            <div class="banner"><img
                        src="{!! $row_zone->show_top_pic !!}"
                        alt=""></div>
            <h1 class="title">{!! $row_zone->zone_name !!}2017年演艺秀时间表</h1>

            <div class="author-date clearfix">
                <div class="author clearfix"><span class="avatar x25 circle"><img
                                src="/media/images/logo.png"
                                alt=""> </span> <span class="name">横店影视城</span></div>
            </div>


        </div>
        <div class="article-detail-bd">
            <div class="excerpt"> 本时间表为常规时间表，若景区临时有更改，恕不另行通知，请以当日景区公告为准。</div>
            <div class="detail">

                <table>
                    <tbody>
                    <?php


                    //获取现在所处时间段
                    $rows_show = DB::table('zone_show_time')
                            ->whereDate('startdate', '<=', $date)
                            ->whereDate('enddate', '>=', $date)
                            ->where('zone_id', $row_zone->id)
                            ->orderBy('show_id', 'asc')
                            ->get();
                    if ($rows_show) {
                     //   echo '<tr class="zone"><td>' . $zone_name . '</td></tr>';

                        foreach ($rows_show as $row_show) {

                            $show_name = $zone->get_project_info($row_show->show_id)->show_name;
                            if ($row_show->se_name) {
                                $show_name = $row_show->se_name . '(' . $show_name . ')';
                            }
                            echo '<tr><td class="showname">' . $show_name . '</td></tr>';
                            echo '<tr><td class="showtime">' .str_replace(',',' | ', $row_show->show_time) . '</td></tr>';
                            if ($row_show->remark) {
                                echo '<tr><td class="showtime">' . $row_show->remark . '</td></tr>';
                            }
                            //获取下一个时间
                            /*     $row_next=DB::table('zone_show_time')
                                          ->whereDate('startdate','>',$row_show->enddate)
                                          ->orderBy('startdate','asc')
                                          ->first();
                                  if($row_next)
                                  {

                                     echo date('n月d日',strtotime($row_next->startdate));
                                      echo "<br>";

                                  }
         */
                        }

                    }
                    ?>
                    </tbody>
                </table>

                <p>题图/{!! $row_zone->show_top_pic_info !!}</p>
                <!--
                <p>伊隆·马斯克的航天公司 SpaceX 公布了一个<a
                            href="http://www.spacex.com/news/2017/02/27/spacex-send-privately-crewed-dragon-spacecraft-beyond-moon-next-year">全新计划</a>，要在
                    2018 年送两位付费乘客去月球轨道兜一兜风。<br></p>

                <p>SpeceX 在一份公告里面说，这两位要去月球轨道的乘客已经为这趟旅程支付了大笔预付费用，他们会首先进行身体检查和健康测试，之后从今年年底开始进行训练。同时 SpaceX
                    表示，还有其他的乘客对这个项目很感兴趣，之后会根据他们的身体测试结果公布更多信息。</p>

                <p>这趟前往月球轨道的飞行将由 SpaceX
                    正在研发的“重型猎鹰”火箭发射，乘客将乘坐新版“龙”（Dragon）飞船前往月球轨道，不降落在月球表面，只是进行环绕飞行并返回。按照计划，“龙”飞船的载人版本“载人龙”将在今年内发射前往国际空间站进行飞行和测试，而“重型猎鹰”飞船将在今年夏天进行首测测试飞行。</p>

                <div class="com-insert-images medium-insert-images" contenteditable="false">
                    <figure style="margin: 0px;" contenteditable="false"><img data-ratio="0.562500" data-format="jpeg"
                                                                              class="lazyload"
                                                                              data-src="http://img.qdaily.com/uploads/201703020753426K9oLel7vgPnJNpU.jpg-w600">
                        <figcaption contenteditable="true"><p>“重型猎鹰”火箭模拟图/SpaceX</p></figcaption>
                    </figure>
                </div>
                <p>去月球是一件难度很大的航天项目。1960 年代，美国的“阿波罗”计划将人类首次送出地球轨道。从 1969 年 7月20日“阿波罗”11 号首次登陆月球到 1972 年 12 月 14 日“阿波罗” 17
                    号离开月面为止，共有 18 人登上了月球。算上环绕月球并未登陆的“阿波罗” 8 号和 10 号，人类历史上一共有 24 人抵达过月球附近。但在 1972 年之后，就再也没有人类离开过近地轨道。</p>

                <p>实际上，自从发射“阿波罗”飞船的“土星 5 号”火箭退役之后，世界各国的火箭就再也没有达到过类似的运载能力。“土星 5 号”火箭可以把 119 吨有效载荷送到近地轨道，而现今在役的最强劲的运载火箭德尔塔
                    4 型、长征 5 号和阿丽亚娜 5 型的近地轨道运载能力最大也只在 30 吨上下。按照设计，用于这次月球“兜风”的“重型猎鹰”火箭将会成为最强大的运载火箭，近地轨道载荷能力将超过 54 吨。</p>

                <p>“猎鹰”系列火箭是 SpaceX 花自己的钱研发的，但“龙”飞船则不是。“龙”飞船是美国国家宇航局 NASA 向私人航天企业外包运载项目的成果，这个项目最低通过 12 次飞行运输 20
                    吨物资到国际空间站，项目总额 31 亿美元。目前，“龙”飞船发射 12 次，SpaceX 正在“龙”的基础上研制“载人龙”飞船，也就是这次月球旅行需要的飞船。</p>

                <div class="com-insert-images medium-insert-images" contenteditable="false">
                    <figure style="margin: 0px;" contenteditable="false"><img data-ratio="0.666500" data-format="jpeg"
                                                                              class="lazyload"
                                                                              data-src="http://img.qdaily.com/uploads/20170302075410JNvVcOIAFoKTQjkt.jpg-w600">
                        <figcaption contenteditable="true"><p>“载人龙”飞船/SpaceX</p></figcaption>
                    </figure>
                </div>
                <p>和无人项目不一样，载人飞行对于安全的要求是显而易见的。1960 年代，“阿波罗”计划中的“土星 5 号”火箭 13 次发射全部成功，“阿波罗 13 号”遭遇故障，但成员安全返回。1981 到 2011
                    年间，美国的航天飞机共完成 135
                    次飞行，起飞过程中发生过一次事故，导致“挑战者”号航天飞机损毁，成员丧生，返回阶段发生过一次事故，导致“哥伦比亚”号空中解体，成员全部丧生；前苏联和俄罗斯的“联盟”号系列飞船进行了 112
                    次飞行，发射全部成功，但“联盟“ 1 号和 11 号返回时遭遇故障，共导致 4 人死亡。</p>

                <p>目前，SpaceX 的“猎鹰”火箭共进行了 30 次发射，在 2015 年 6 月 28 日的无人飞行中遭遇一次事故，火箭在飞行过程中因为燃料罐故障爆炸，任务失败。另外在 2016 年 9 月 1
                    日发生过一次地面事故，火箭在发射前测试中意外爆炸，这次事故一般不认为是发射事故，与火箭的可靠性关联也不大。</p>

                <p>目前，SpaceX 没有公布首批前往月球的两位乘客为这段旅程支付了多少费用。按照现在的报价，“重型猎鹰”火箭不包括有效载荷的一次发射价格为 9
                    千万美元。因为地面级的三枚芯级火箭全部可以回收，这个价格里面包含的利润空间随着任务的进展会逐渐扩大。同时，“载人龙”飞船作为 SpaceX 和 NASA
                    的载人合同项目之一，研发成本将由项目本身承担，成本将进一步减低。</p>

                <p>SpaceX 在声明中感谢了 NASA 的商业化航天项目，称这是这个计划变成现实的基础。NASA 在 SpaceX 公布了这个项目之后也发布了<a
                            href="https://www.nasa.gov/press-release/nasa-statement-about-spacex-private-moon-venture-announcement">一篇声明</a>，称这种商业合作方式会改变航天业，这个月球旅行项目将是
                    SpaceX 达到的新高度。</p>

                <p>如果一切顺利，2018 年底“重型猎鹰”火箭和“载人龙”飞船将带着两名乘客从位于美国佛罗里达州卡纳维拉尔角的肯尼迪航天中心 39A 发射工位起飞。50 年前，“土星 5
                    号”带着“阿波罗”飞船就是在这个工位起飞，离开地球进入深空。 45
                    年之后，人类将会再一次离开地球轨道，不过这次决定一切的不再是冷战和举国体制，在可见的未来，商业的力量可能会进一步，把人类送到火星，或是更远的地方。</p>

                <p><br></p>

                <p>题图/阿波罗 15 号/NASA</p>

            </div>
        </div>
        <div class="article-detail-ft">
            <ul class="tags items clearfix">
                <li class="tag item" data-id="2493"><span data-id="2493">火箭</span></li>
                <li class="tag item" data-id="3466"><span data-id="3466">航天</span></li>
                <li class="tag item" data-id="15064"><span data-id="15064">马斯克</span></li>
                <li class="tag item" data-id="946"><span data-id="946">SpaceX</span></li>
            </ul>
            <div class="share-wrapper clearfix"><span class="text">分享至：</span>

                <div class="com-share" data-id="38319" data-title="《去月球轨道兜兜风，SpaceX 将开启商业月球旅游计划》，来自@好奇心日报"
                     data-pic="http://img.qdaily.com/article/article_show/20170302075311b5CjIy1lWdAOpMfm.jpg?imageMogr2/auto-orient/thumbnail/!640x380r/gravity/Center/crop/640x380/quality/85/format/jpg/ignore-error/1"
                     data-url="http://m.qdaily.com/mobile/articles/38319.html" data-weiboappkey="2462590045">
                    <div class="share-bd clearfix"><a data-ga-event="mobile:share:weibo"
                                                      href="http://service.weibo.com/share/share.php"
                                                      class="share iconfont icon-weibo"></a><a
                                data-ga-event="mobile:share:tengxunweibo" href="http://share.v.t.qq.com/index.php"
                                class="share iconfont icon-tengxunweibo"></a><a data-ga-event="mobile:share:kongjian"
                                                                                href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey"
                                                                                class="share iconfont icon-kongjian"></a><a
                                data-ga-event="mobile:share:douban" href="http://www.douban.com/share/service"
                                class="share iconfont icon-douban"></a><a data-ga-event="mobile:share:linkedin"
                                                                          href="http://www.linkedin.com/shareArticle"
                                                                          class="share iconfont icon-linkedin"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">var elsImg = document.querySelectorAll(".com-article-detail .detail img"), placeholderImg = "";
        try {
            resetImgHeight && resetImgHeight(elsImg, placeholderImg)
        } catch (e) {
        }</script>
    <div class="com-related-banners">
        <div class="related-banners-bd">
            <div class="gap"></div>
            <a href="/mobile/articles/31769.html" class="com-grid-key-article">
                <div class="grid-key-article-hd">
                    <div class="imgcover pic"><img class="lazyload"
                                                   data-src="http://img.qdaily.com/article/article_show/20160912073604btowuU3cq8QyCajA.jpg?imageMogr2/auto-orient/thumbnail/!320x195r/gravity/Center/crop/320x195/quality/85/format/jpg/ignore-error/1"
                                                   alt="SpaceX 火箭爆炸了，你知道它曾经还失败过多少次吗？"></div>
                </div>
                <div class="grid-key-article-bd"><p class="category"><span class="iconfont icon-zhineng"></span> <span>智能</span>
                    </p>

                    <h1 class="title">SpaceX 火箭爆炸了，你知道它曾经还失败过多少次吗？</h1>

                    <div class="ribbon"><span class="iconfont icon-message">14</span> <span class="iconfont icon-heart">13</span>
                    </div>
                </div>
            </a>

            <div class="gap"></div>
            <a href="/mobile/articles/33691.html" class="com-grid-key-article">
                <div class="grid-key-article-hd">
                    <div class="imgcover pic"><img class="lazyload"
                                                   data-src="http://img.qdaily.com/article/article_show/20161025071751z3uORN8EMerVhUqH.jpg?imageMogr2/auto-orient/thumbnail/!320x195r/gravity/Center/crop/320x195/quality/85/format/jpg/ignore-error/1"
                                                   alt="马斯克计划中的火星殖民地，机器人会修建城市"></div>
                </div>
                <div class="grid-key-article-bd"><p class="category"><span class="iconfont icon-zhineng"></span> <span>智能</span>
                    </p>

                    <h1 class="title">马斯克计划中的火星殖民地，机器人会修建城市</h1>

                    <div class="ribbon"><span class="iconfont icon-message">5</span> <span class="iconfont icon-heart">72</span>
                    </div>
                </div>
            </a></div>
    </div>
    <div class="com-related-comments-brief " data-id="38319">
        <div class="gap"></div>
        <div class="related-comments-brief-bd"><p class="count" style="visibility:hidden">10条评论</p>

            <div class="items comments" data-lastkey="0"></div>
            <div class="callup-button"><a data-ga-event="mobile:click:seeMore" data-id="38319"
                                          href="/mobile/downloads/callup/1.html" class="btn">打开好奇心，查看更多内容</a></div>
        </div>
    </div>
    -->
</div>
<script type="text/javascript">resetImgQuantity(), window.onload = function () {
        !function (e, a, n, t, o, c, i) {
            e.GoogleAnalyticsObject = o, e[o] = e[o] || function () {
                        (e[o].q = e[o].q || []).push(arguments)
                    }, e[o].l = 1 * new Date, c = a.createElement(n), i = a.getElementsByTagName(n)[0], c.async = 1, c.src = t, i.parentNode.insertBefore(c, i)
        }(window, document, "script", "//www.google-analytics.com/analytics.js", "ga"), ga("create", "UA-50426186-1", "qdaily.com"), ga("require", "displayfeatures"), ga("send", "pageview")
    }</script>
<script type="text/javascript" src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="{{asset('lib/js/a1.js')}}"></script>
<script src="{{asset('lib/js/a2.js')}}"></script>
</body>
</html>