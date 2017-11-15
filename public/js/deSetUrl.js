function getCookie(name, key) {
    var reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    var arr = document.cookie.match(reg);
    if (arr != null) return unescape(arr[2]).substring(key);
    else return "";
}

function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.trim().substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]);
    else return ""; //返回参数值
}
var uidParam = getCookie('uidCookie') != "" ? getCookie('uidCookie', 4) : getUrlParam('uid');  //"uid=" 长度为"4"
var cpParam = getCookie('cpCookie') != "" ? getCookie('cpCookie', 4) : getUrlParam('coupon');  //"cid=" 长度为"4"
var wxParam = getCookie('wxCookie') != ""? getCookie('wxCookie',4):getUrlParam('wxnumber');  //"wid=" 长度为"4"
//var addUid = uidParam!=""?"uid=" + uidParam:"";
var addUid = "uid=" + uidParam;
var addCid = "coupon=" + cpParam;
var addWid = "wxnumber=" + wxParam;

$(document).ready(function () {
    $.each($("a"), function (i, n) {
        var $href = $(this).attr("href");
        var haveParam = $href.indexOf("?") >= 0 ? "1" : "0";//判断是否已经有参数
            if (haveParam == "1") {
                if (uidParam != "" && cpParam != "" && wxParam != "") { $(this).attr("href", $href + "&" + addUid + "&" + addCid + "&" + addWid); }
                if (uidParam != "" && cpParam != "" && wxParam == "") { $(this).attr("href", $href + "&" + addUid + "&" + addCid); }
                if (uidParam != "" && cpParam == "" && wxParam != "") { $(this).attr("href", $href + "&" + addUid + "&" + addWid); }
                if (uidParam != "" && cpParam == "" && wxParam == "") { $(this).attr("href", $href + "&" + addUid); }
                if (uidParam == "" && cpParam != "" && wxParam != "") { $(this).attr("href", $href + "&" + addCid + "&" + addWid); }
                if (uidParam == "" && cpParam != "" && wxParam == "") { $(this).attr("href", $href + "&" + addCid); }
                if (uidParam == "" && cpParam == "" && wxParam != "") { $(this).attr("href", $href + "&" + addWid); }
                if (uidParam == "" && cpParam == "" && wxParam == "") { $(this).attr("href", $href); }
            }
            if (haveParam == "0") {
                if (uidParam != "" && cpParam != "" && wxParam != "") { $(this).attr("href", $href + "?" + addUid + "&" + addCid + "&" + addWid); }
                if (uidParam != "" && cpParam != "" && wxParam == "") { $(this).attr("href", $href + "?" + addUid + "&" + addCid); }
                if (uidParam != "" && cpParam == "" && wxParam != "") { $(this).attr("href", $href + "?" + addUid + "&" + addWid); }
                if (uidParam != "" && cpParam == "" && wxParam == "") { $(this).attr("href", $href + "?" + addUid); }
                if (uidParam == "" && cpParam != "" && wxParam != "") { $(this).attr("href", $href + "?" + addCid + "&" + addWid); }
                if (uidParam == "" && cpParam != "" && wxParam == "") { $(this).attr("href", $href + "?" + addCid); }
                if (uidParam == "" && cpParam == "" && wxParam != "") { $(this).attr("href", $href + "?" + addWid); }
                if (uidParam == "" && cpParam == "" && wxParam == "") { $(this).attr("href", $href); }
            }
    });
});