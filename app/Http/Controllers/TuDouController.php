<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TuDouController extends Controller
{
    public function test()
    {
        $url = "http://new-play.tudou.com/v/XMzQ3ODQ1OTYzNg==5d0cefbfbdefbfbd391f";
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
        $pattern = "/<div.*?class=\"td-listbox__list__item--show\".*?>.*?<\/div>/ism";
/*        preg_match_all("/<script.*?src=['\"](.*?\.js).*?>/i",$data, $matches);*/

        $head = '/<head.*?>(.*)<\/head>/ism';
        $script = '/<script([\w\W]*)<\/script>/iU';
        $link_url ='/<link rel="shortcut icon" href="(.*?)"/is';
        preg_match_all($script, $data, $headArray); //获取head内容
//        preg_match_all($link_url, $headArray[0][0], $link_url);//获取来源
//        preg_match_all($script, $headArray[1][0], $scriptArray);//获取script中的内容
        dump($data);
//        preg_match_all($a,$content[0][0],$arr);
//        dump($content);
    }
}
