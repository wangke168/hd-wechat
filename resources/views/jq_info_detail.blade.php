@extends('data_wap')
@section('title', '横店圆明新园')
@section('header_tit',$row->zone_name)

@section('content')
    @@parent
    <div style="margin-top:5px; position:relative;">
        <a href="http://m.hengdianworld.com/info_jq_detail.aspx?JQID=JQ1#" id="jqimg"><img src="{{$row->title_pic}}"
                                                                                           width="100%"></a>
        <div class="more" id="s1">{{$row->zone_name}}</div>
        <div class="moreimg"></div>
    </div>

    <div class="nav">
        <a href="{{$row->navigation}}">
            <div class="tit" id="dh">  <!--导航地址-->
                <img src="{{asset('test/address.png')}}" width="16rem" style="vertical-align:middle;"> <span
                        style="color:#6f6f6f;" id="s2">景区导航</span>
                <span class="rb"> <img src="{{asset('test/arrow-right-l.png')}}" width="10" border="0"
                                       height="14"> </span>
            </div>
        </a>
    </div>

    <div class="nav">
        <div class="tit" id="dh2">  <!--开园时间-->
            <img src="{{asset('test/ky.png')}}" width="16rem" style="vertical-align:middle;"> <span
                    style="color:#6f6f6f;"
                    id="s3">
      开园时间：{{$row->open_time}}
    </span>
        </div>
    </div>

    <div class="nav">
        <div class="tit"><img src="{{asset('test/adult_ticket.png')}}" width="18rem" style="vertical-align:middle;"> 挂牌价/网络价<span
                    class="cnt" style="color:red;" id="s4">￥{{$row->price}}/{{$row->booking_price}}元</span>

 <span style="float:right; display:block; background-color:#eac14d; padding:2px 10px; border-radius:5px"><a
             href="http://ydpt.hdyuanmingxinyuan.com/mobile/epay.aspx"><font
                 style="color:#fff; font-size:12px;"> 预 订 </font></a></span>
 </div>
    </div>

    <div class="nav">
        <div class="tit"><img src="{{asset('test/introduction.png')}}" width="16rem" style="vertical-align:middle;"> 简介
        </div>
        <div class="cnt" id="s5">{{$row->info}}</div>
    </div>

    @php
        $items=DB::table('zone_show_info')
                    ->where('zone_id',$row->id)
                    ->get();
    @endphp
    @if($items)

        <div class="nav">
            <div class="tit"><img src="{{asset('test/yyx.png')}}"
                                  width="16rem"
                                  style="vertical-align:middle;"> 演艺节目<span
                        class="rb"> <img src="{{asset('test/arrow-right-l.png')}}" width="10" border="0"
                                         height="14"> </span>
            </div>
            <div class="cnt" id="s6">

                @foreach($items as $item)
                    [{{$item->show_name}}]
                @endforeach

                <br>
                <a href="https://wechat.hdyuanmingxinyuan.com/article/detail?type=long"><font
                            color="red">[最新节目时间表]</font></a><br><font color="red">*如遇特殊情况，以当日景区预告为准。</font>
            </div>

        </div>
    @endif
@stop
