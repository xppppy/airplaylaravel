<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(){
        $url="http://new-play.tudou.com/v/906019112.html?spm=a2h28.8514923.category.5%212~5%212~5~5~5~5~A";
//        $UserAgent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $curl = curl_init();    //创建一个新的CURL资源
        curl_setopt($curl, CURLOPT_URL, $url);  //设置URL和相应的选项
        curl_setopt($curl, CURLOPT_HEADER, 0);  //0表示不输出Header，1表示输出
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);  //设定是否显示头信息,1显示，0不显示。
//如果成功只将结果返回，不自动输出任何内容。如果失败返回FALSE
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //执行之后不直接打印出来
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_ENCODING, '');   //设置编码格式，为空表示支持所有格式的编码
//header中“Accept-Encoding: ”部分的内容，支持的编码格式为："identity"，"deflate"，"gzip"。

//        curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
//        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
//设置这个选项为一个非零值(象 “Location: “)的头，服务器会把它当做HTTP头的一部分发送(注意这是递归的，PHP将发送形如 “Location: “的头)。

        $data = curl_exec($curl);
//echo curl_errno($curl); //返回0时表示程序执行成功
        curl_close($curl);  //关闭cURL资源，并释放系统资源

        $a = "/<a\b[^>]+\bhref=\"([^\"]*)\"[^>]*>([\s\S]*?)<\/a>/is";//获取a标签相关内容
        $img = '/<img.*?src="(.*?)".*?>/is';//获取img标签相关内容
        $title = '/<title>(.*)<\/title>/is';//获取title标签相关内容
        /**
         * 获取title
         */
        preg_match_all($title,$data,$content);
        $arr1 = explode("_",$content[1][0]);
        $arr2 = explode(" ",$arr1[0]);
        dump(["title详细信息:",$arr1]);
        dump(["视频名称:",$arr2]);
        /**
         * 获取简介和图片
         */
        preg_match_all('/<p class=\"summary\">(.*)<\/p>/ism',$data,$content1);
        preg_match_all("/<meta itemprop=\"image\" content=\"(.*)\">/",$data,$content2);
        dump(["获取简介:",$content1]);
        dump(["视频展示图片:",$content2]);
        /**
         * 获取分页
         */
        $pattern = "/<div.*?class=\"td-listbox__list__item--show\".*?>.*?<\/div>/ism";
        preg_match_all($pattern,$data,$content);
        if (!empty($content[0])) {
            preg_match_all($a,$content[0][0],$arr);
            dump(["级数:",$arr]) ;
        }else{
            dump(["级数:","无级数"]) ;
        }
        /**
         * 获取往期和图片
         */
/*        $pattern1 = "/<ul class=\"figure_list\".*?>.*<\/ul>/is";*/
//        preg_match_all($pattern1,$data,$content);
//        preg_match_all($a,$content[0][0],$arr1);
//        if (!empty($arr1[0])){
//            preg_match_all($img,$content[0][0],$arr2);
/*            preg_match_all("/<span class=\"num\".*?>(.*?)<\/span>/",$content[0][0],$arr3);*/
//            dump(["往期内容:",$arr1]);
//            dump(["往期内容展示图片:",$arr2]);
//            dump(["往期名字:",$arr3]);
//        }
//        dump(["往期内容:","无内容"]);




//        print_r($arr);
    }
}
