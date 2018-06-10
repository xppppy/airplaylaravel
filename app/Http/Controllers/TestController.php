<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;

class TestController extends Controller {
    public function test($sourceaddr) {
        //-----------------------------------------
        $url = $sourceaddr;
        $curl = curl_init();    //创建一个新的CURL资源
        curl_setopt($curl, CURLOPT_URL, $url);  //设置URL和相应的选项
        curl_setopt($curl, CURLOPT_HEADER, 0);  //0表示不输出Header，1表示输出
        //如果成功只将结果返回，不自动输出任何内容。如果失败返回FALSE
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //执行之后不直接打印出来

        curl_setopt($curl, CURLOPT_ENCODING, '');   //设置编码格式，为空表示支持所有格式的编码
        //header中“Accept-Encoding: ”部分的内容，支持的编码格式为："identity"，"deflate"，"gzip"。

        $data = curl_exec($curl);
        $bool = curl_errno($curl);
        curl_close($curl);  //关闭cURL资源，并释放系统资源


        $a = "/<a\b[^>]+\bhref=\"([^\"]*)\"[^>]*>([\s\S]*?)<\/a>/is";//获取a标签相关内容
        $img = '/<img.*?src="(.*?)".*?>/is';//获取img标签相关内容
        $title = '/<title>(.*)<\/title>/is';//获取title标签相关内容

        //返回0时表示程序执行成功
        if ($bool == 0) {
            /**
             * 获取title
             */
            preg_match_all($title, $data, $content);
            $titileArray = explode("_", $content[1][0]);
            /**
             * 获取频道
             */
            preg_match_all('/<body.*?_wind="(.*?)">/is', $data, $pindaoArray);
            $pindao = explode("=", $pindaoArray[1][0]);
            /**
             * 获取简介和图片
             */
            preg_match_all("/<p class=\"summary\">(.*)<\/p>/is", $data, $jianjie);
            preg_match_all("/<meta itemprop=\"image\" content=\"(.*)\">/", $data, $thum);
            if ($pindao[2] == '电视剧' || $pindao[2] == '动漫') {
                /**
                 * 获取分页
                 */
                $pattern = "/<div class=\"mod_episode\".*?>.*?<\/div>/ism";
                preg_match_all($pattern, $data, $fenye);
                preg_match_all($a, $fenye[0][0], $sum);
                dump($sum);
            } else {
                $sum = 1;
            }
            /**
             * 获取hot
             */
            $units = "/<span class=\"units\">(.*?)<\/span>/";
            $decimal = "/<span class=\"decimal\">(.*?)<\/span>/";
            preg_match_all($units, $data, $hot1);
            preg_match_all($decimal, $data, $hot2);
            dump($hot1);
            dump($hot2);

            return [
                'title' => $titileArray[0],
                'type' => $pindao[2],
                'jianjie' => $jianjie[1][0],
                'thum' => $jianjie[1][0],
                'hot' => $hot1 . $hot2
            ];
        } else {
            return 'error';
        }

    }
}
