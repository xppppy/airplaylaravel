<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TuDouController extends Controller
{
    public function test()
    {
        $url = "http://new-play.tudou.com/v/906019112.html?spm=a2h28.8514923.category.5%212~5%212~5~5~5~5~A";
        $curl = curl_init();    //创建一个新的CURL资源
        curl_setopt($curl, CURLOPT_URL, $url);  //设置URL和相应的选项
        curl_setopt($curl, CURLOPT_HEADER, 0);  //0表示不输出Header，1表示输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //执行之后不直接打印出来
        curl_setopt($curl, CURLOPT_ENCODING, '');   //设置编码格式，为空表示支持所有格式的编码
        $data = curl_exec($curl);
        curl_close($curl);  //关闭cURL资源，并释放系统资源

        //---------------------------------------------------
        $a = "/<a\b[^>]+\bhref=\"([^\"]*)\"[^>]*>([\s\S]*?)<\/a>/is";//获取a标签相关内容
        $img = '/<img.*?src="(.*?)".*?>/is';//获取img标签相关内容
        $title = '/<title>(.*)<\/title>/is';//获取title标签相关内容
        /**
         * 获取分页
         */
        $arry1 = "" ;
        $pattern = "/<div.*?class=\"td-listbox__list__item--show\".*?>.*?<\/div>/ism";
        preg_match_all($pattern,$data,$content);
        for ($i =1 ; $i<count($content[0]);$i++) {
           $arry1 =$arry1.$content[0][$i];
        }
        dump($arry1);
        preg_match_all($a,$arry1,$con);
        dump($con);
//        preg_match_all($a,$content[0][0],$arr);
//        dump($content);
    }
}
