<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class test extends Controller{

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function test(){
//        $header = array();
//        $header[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9;q=0.8';
//        $header[] = 'Referer: https://v.qq.com/tv/';
//        $header[] = 'Host: v.qq.com';
//        $header[] = 'Users-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36';
        $curl_a = curl_init(); //初始化
        curl_setopt($curl_a, CURLOPT_URL, "http://new-play.tudou.com/v/906003134.html?spm=a2h28.8514923.category.5%213~5%212~5~5~A"); //设置访问的URL
        curl_setopt($curl_a, CURLOPT_RETURNTRANSFER, true); //执行之后不直接打印出来
//        curl_setopt($curl_a,CURLOPT_HTTPHEADER,$header);
        $output = curl_exec($curl_a);  //执行
        curl_close($curl_a);	//关闭CURL

        preg_match_all('/<title>(.*)<\/title>/',$output,$content);

        echo '<pre>';

        print_r($content);
        echo '--------------<pre>';
        $aa = "211 sasb";
//        $arr = explode("：",$content[1][0]);//爱奇艺
        $arr = explode("_",$content[1][0]);//土豆
        dump($arr);
        var_dump($content[1][0],'gb2312');

    }

}
