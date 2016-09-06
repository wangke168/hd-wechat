<?php
include 'js/jssdk.php';
/*替换为你自己的数据库名（可从管理中心查看到）*/
$dbname = 'weixin';
 
/*从环境变量里取出数据库连接需要的参数*/
$host = "218.244.149.169";
$port = "3306";
$user = "weixin";
$pwd = "Wk*471000";
 
 
/*接着调用mysql_connect()连接服务器*/
$link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
if(!$link) {
    die("Connect Server Failed: " . mysql_error());
}
/*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
if(!mysql_select_db($dbname,$link)) {
    die("Select Database Failed: " . mysql_error($link));
}
//  mysql_select_db("weixin", $link); 
   //字符编码转换_读数据库 
    mysql_query("set character set 'utf8'"); 
   //字符编码转换_写数据库 
    mysql_query("set names 'utf8'");
 
/*至此连接已完全建立，就可对当前数据库进行相应的操作了*/
/*！！！注意，无法再通过本次连接调用mysql_select_db来切换到其它数据库了！！！*/
/* 需要再连接其它数据库，请再使用mysql_connect+mysql_select_db启动另一个连接*/
 
/**
 * 接下来就可以使用其它标准php mysql函数操作进行数据库操作
 */
 
/*显式关闭连接，非必须*/

//mysql_close($link);



?>