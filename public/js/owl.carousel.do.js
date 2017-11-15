document.documentElement.style.fontSize = document.documentElement.clientWidth / 6.4 + 'px';  //便于计算，设置默认文本字体像素以100px为基准，设计稿是640px宽度设计
$(document).ready(function () {
    $("#owl-adv").owlCarousel({
        singleItem: true,
        autoPlay: 2000,
        // navigation : true,
        // slideSpeed : 300,
        // paginationSpeed : 400,
        // "singleItem:true" is a shortcut for:
        // items : 1, 
        // itemsDesktop : false,
        // itemsDesktopSmall : false,
        // itemsTablet: false,
        // itemsMobile : false
    });
    $('.item').click(function () { $('.item').trigger('owl.next'); });//解决点击后停止不滚动问题
});