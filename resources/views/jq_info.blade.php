@extends('data_wap')
@section('title', '横店圆明新园')
@section('header_tit', '景点介绍')


@section('content')
    <div style="font-size:14px; line-height:24px; padding:8px 8px 0;text-indent: 2em; text-align:justify; ">
        横店圆明新园，建有千姿百态的皇家宫殿，有数百种四季盛开的奇花异草，有超大型声、光、电结合精彩绝伦的水秀节目，有全国最大的“天池瀑布”，有美、俄、奥、法等八国建筑原景和原汁原味的异域风情表演，有占地上万平方的御苑珍藏馆，有全球最大集现代高科技多媒体手段与传统展示技术结合而创建的集科普教育、娱乐互动、趣味于一体的动物标本生态景观展厅，有12生肖高仿真互动机器人表演，有机器人咖啡厅，有魔法望远镜让您看到肉眼无法观看到的奇妙动物世界，有大型航母、潜水器等军事题材模型，有中国龙、西游记、红楼梦、红灯记、沙家浜等历史性题材冰雕，还有大型滑冰场和12生肖滑道，还有国内最大360度穹顶球幕、4D动感座椅、3D全息秀、结合魔术表演、观众参与互动的高科技球幕剧院。
    </div>
    <div style="margin:5px; padding:5px; border-radius:5px; border:0px ;">

        @foreach($rows as $row)
            <a href="info_jq_detail?id={{$row->id}}"><img src="{{$row->big_pic}}" width="100%" class="m"></a>
        @endforeach
    </div>
@stop
