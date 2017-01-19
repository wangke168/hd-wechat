<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\MemcachedCache;
use App\WeChat\Tour;
use App\WeChat\Usage;
use EasyWeChat\Message\Text;
use DB;
use App\Models\WechatArticle;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;

class TestController extends Controller
{
    protected $cache;
    public function __construct(Cache $cache = null)
    {
        $this->cache = $cache;
    }
    public function test()
    {

        $app=app('wechat');
        $zone=new Tour();
        $row=DB::table('tour_project_info')
            ->orderBy('id','desc')
            ->get();
        foreach ($row as $result) {
            $aaa = explode(',', $result->show_time);
            $prevtime = date('Y-m-d');
            foreach ($aaa as $bbb) {
                $temptime = (strtotime($bbb) - strtotime("now")) / 60;
                if ($temptime < 30 && $temptime > 0) {

                    $row1 = DB::table('wx_user_info')
                        ->where('eventkey', $result->eventkey)
                        ->where('scandate', date('Y-m-d'))
                        ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
                        ->get();

                    foreach ($row1 as $send_openid) {
                        $content = new Text();
                        $content->content = "您好，" . $zone->get_zone_name($result->zone_id,'1') . "景区" . $result->show_name . "的演出时间是" . $bbb . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $result->location_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                        $app->staff->message($content)->by('1001@u_hengdian')->to('o2e-YuBgnbLLgJGMQykhSg_V3VRI')->send();
//                        return $content;
                    }


                    /*检查景区eventkey下有没有其他二维码，例：龙帝惊临项目在秦王宫里，因此龙帝惊临和秦王宫的二维码是从属关系，扫龙帝惊临的二维码也能收到秦王宫的节目提醒*/
//                    $qrscene_id=$this->get_eventkey_info($result['eventkey']);
                    $Usage = new Usage();
                    $qrscene_id = $Usage->get_eventkey_son_info($result->eventkey);
                    if ($qrscene_id) {
                        foreach ($qrscene_id as $key => $eventkey) {

                            $row2 = DB::table('wx_user_info')
                                ->where('eventkey', $eventkey)
                                ->where('scandate', date('Y-m-d'))
                                ->whereRaw('UNIX_TIMESTAMP(endtime)>=' . strtotime($prevtime))
                                ->get();

                            foreach ($row2 as $send_openid) {
                                $content = new Text();
                                $content->content = "您好，" . $zone->get_zone_name($result->zone_id,'1') . "景区" . $result->show_name . "的演出时间是" . $bbb . "。还没到剧场的话要抓紧了哦。\n如果您不知道剧场位置，<a href='" . $result->location_url . "'>点我</a>\n微信演出时间有时无法及时更新，以景区公示为准。";
                                $app->staff->message($content)->by('1001@u_hengdian')->to('o2e-YuBgnbLLgJGMQykhSg_V3VRI')->send();
//                                return $content;
                            }
                        }
                    }

                }
                $prevtime = $bbb;
            }
        }
    }

    public function qrcreate()
    {
      /*  $rows=DB::table('wx_qrscene_info')
        ->where('id','>', '872')
        ->pluck('qrscene_id');
        foreach ($$rows as $row) {
            # code...
        }
        return $row;
*/
        $str=""1365",
    "1366",
    "1367",
    "1368",
    "1369",
    "1370",
    "1371",
    "1372",
    "1373",
    "1374",
    "1375",
    "1376",
    "1377",
    "1378",
    "1379",
    "1380",
    "1381",
    "1382",
    "1383",
    "1384",
    "1385",
    "1386",
    "1387",
    "1388",
    "1389",
    "1390",
    "1391",
    "1392",
    "1393",
    "1394",
    "1395",
    "1396",
    "1397",
    "1398",
    "1399",
    "1400",
    "1401",
    "1402",
    "1403",
    "1404",
    "1405",
    "1406",
    "1407",
    "1408",
    "1409",
    "1410",
    "1411",
    "1412",
    "1413",
    "1414",
    "1415",
    "1416",
    "1417",
    "1418",
    "1419",
    "1420",
    "1421",
    "1422",
    "1423",
    "1424",
    "1425",
    "1426",
    "1427",
    "1428",
    "1429",
    "1430",
    "1431",
    "1432",
    "1434",
    "1435",
    "1436",
    "1437",
    "1438",
    "1439",
    "1440",
    "1441",
    "1442",
    "1443",
    "1444",
    "1445",
    "1446",
    "1447",
    "1448",
    "1449",
    "1450",
    "1451",
    "1457",
    "1458",
    "1462",
    "1463",
    "1464",
    "1465",
    "1466",
    "1469",
    "1470",
    "1471",
    "1472",
    "1473",
    "1474",
    "1475",
    "1476",
    "1477",
    "1478",
    "1479",
    "1480",
    "1481",
    "1482",
    "1483",
    "1486",
    "1487",
    "1489",
    "1490",
    "1491",
    "1496",
    "1497",
    "1500",
    "1501",
    "1503",
    "1504",
    "1505",
    "1508",
    "1510",
    "1512",
    "1513",
    "1514",
    "1515",
    "1516",
    "1517",
    "1433",
    "1452",
    "1453",
    "1454",
    "1455",
    "1456"";
    return str_replace('"','',$str);


    /*    for ($k='1370'; $k <'1396'; $k++) { 
            $i=$k-1365;
            $qrscene_name='永康酒店'.$i;
             $row=DB::table('wx_qrscene_info')
        ->insert(['classid'=>'1','qrscene_id'=>$k,'qrscene_name'=>$qrscene_name]);
        // return $row;
        }
        for ($k='1396'; $k <'1416'; $k++) { 
            $i=$k-1395;
            $qrscene_name='金华酒店'.$i;
             $row=DB::table('wx_qrscene_info')
        ->insert(['classid'=>'1','qrscene_id'=>$k,'qrscene_name'=>$qrscene_name]);
        // return $row;
        }
        for ($k='1416'; $k <'1431'; $k++) { 
            $i=$k-1415;
            $qrscene_name='浦江酒店'.$i;
             $row=DB::table('wx_qrscene_info')
        ->insert(['classid'=>'1','qrscene_id'=>$k,'qrscene_name'=>$qrscene_name]);
        // return $row;
        }
        return $k;
        */
       
    }

     public function detail_test(Request $request)
     {



     }

    public function cache()
    {
        $this->getCache()->save('testcach', 'wechat', 6500 - 1500);

    }
    private function getCache()
    {
        return $this->cache ?: $this->cache=new MemcachedCache();
        // return $this->cache ?: $this->cache = new FilesystemCache(sys_get_temp_dir());
    }
}