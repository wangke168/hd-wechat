$(document).ready(function () {
    for (var i = 0; i < $(".content li").length; i++) {
        $(".content li").eq(i).css({ "top": (i * 0.3) + "rem" });
    }
})
setInterval("ctxtslide()", 3000);
function ctxtslide() {
    var i = $(".content li:first");
    var temp = $(".content li:first").clone();
    temp.css({ "top": ($(".content li").length * 0.3) + "rem" });
    $(".content ul").append(temp);
    $(".content li").animate({ "top": "-=0.3rem" }, 500, function () {
        i.remove();
    });
}