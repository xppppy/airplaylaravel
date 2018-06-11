<?php
/**
 * Created by PhpStorm.
 * User: Microsoft
 * Date: 2018/6/11
 * Time: 11:18
 */

namespace App\Http\Controllers;


class YouKu {

    public function test($sourceaddr,$timeout=10) {
//        $url = "https://v.youku.com/v_show/id_XNTQwMTgxMTE2.html?spm=a2hcm.20010061.m_234505.5~5!2~5~5~A";//动漫
//        $url = "https://v.youku.com/v_show/id_XMzU3MzUyNjYyMA==.html?spm=a2htv.20009910.m_86821.5~5!2~5~5!2~A";//电视剧
//        $url = "https://v.youku.com/v_show/id_XMzA3MzkxNjczNg==.html?spm=a2h1n.8251845.0.0";//电影
        $url = $sourceaddr;
        $curl = curl_init();    //创建一个新的CURL资源
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_TIMEOUT,$timeout);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,$timeout);
        curl_setopt($curl, CURLOPT_URL, $url);  //设置URL和相应的选项
//        curl_setopt($curl, CURLOPT_HEADER, 0);  //0表示不输出Header，1表示输出
        //如果成功只将结果返回，不自动输出任何内容。如果失败返回FALSE
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1); //跟随301跳转
        curl_setopt($curl,CURLOPT_AUTOREFERER,1); //自动设置referer
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //执行之后不直接打印出来

        curl_setopt($curl, CURLOPT_ENCODING, '');   //设置编码格式，为空表示支持所有格式的编码
        //header中“Accept-Encoding: ”部分的内容，支持的编码格式为："identity"，"deflate"，"gzip"。

        $data = curl_exec($curl);
        $bool = curl_errno($curl);
        curl_close($curl);  //关闭cURL资源，并释放系统资源

        $type = $this->GetType($data);//先获取影视属性，提供判断，电影就不收集集数

        return [
            'title'     => $this->GetTitle($data),
            '$type'     => $this->GetType($data),
            'numbUrl'    => $this->GetNumber($data,$type),
            'brief'   => $this->GetSummary($data),
            'hot'       => $this->GetHot($data,$type),
        ];
    }

    /**
     * 判断地址是否指向优酷
     * @param $data //获取页面数据
     * @return bool
     */
    public function Is_VideoYouKu($data){

        $link_url ='/<link rel="shortcut icon" href="(.*?)"/is';

        preg_match_all($link_url, $data, $link_url);//获取来源

        if(explode('/',$link_url[1][0])[2] == "static.youku.com"){
            return true;
        }
        return false;
    }

    /**
     * 获取影视属性
     * @param $data //获取页面数据
     * @return mixed
     */
    public function GetType($data){
        $script = '/<script([\w\W]*)<\/script>/iU';
        $catName = '/catName:(.*?),/';
        preg_match_all($script,$data,$scriptArray);
        preg_match_all($catName,$data,$type);
        if (!empty($type)){
            $type = explode('\'',$type[1][0])[1];
            return $type;
        }
        return '';
    }

    /**
     * 获取剧集
     * @param $data  //获取页面数据
     * @return array|int //不是电影就返回数组，否则返回1
     */
    public function GetNumber($data,$type){
        if ($type != '电影'){
            $a = '/<a class=\"sn\" href=\"(.*)\" data-from=\"(.*)\">(.*)<\/a>/siU';
            $drama_content = '/<div class=\"drama-content\">(.*)<\/div>/si';
            preg_match_all($drama_content, $data, $divArray);
            preg_match_all($a, $divArray[1][0], $aArray);
            $arr = [];
            $i = 1 ;
            if (!empty($aArray)){
                foreach ($aArray[1] as $value){
                    $value = "https:".$value;
                    $arr[$i] = ['url'=>$value];
                    $i++;
                }
                return $arr ;
            }
        }
        return 1;
    }

    /**
     * 获取影视名字
     * @param $data  //获取页面数据
     * @return mixed
     */
    public function GetTitle($data){
        $drama_top='/<div class=\"tvinfo\">(.*)<\/div>/is';
        $a = '/<a.*>(.*)<\/a.>/is';
        preg_match_all($drama_top, $data, $divArray);
        preg_match_all($a, $divArray[1][0], $aArr);
        $title = $this->get_tag_data($divArray[1][0],'a','title','');
        return $title[0];
    }

    /**
     * 获取简介
     * @param $data   //获取页面数据
     * @return string
     */
    function GetSummary($data){
        $summary= $this->get_tag_data($data,'div','class','summary');
        $sum = trim(explode('>',$summary[0])[1]);
        return $sum;
    }

    /**
     * 获取 hot 值
     * @param $data  //获取页面数据
     * @param $type     //获取 type 用于判断是否是电影
     * @return string
     */
    function GetHot($data,$type){
        $score = $this->get_tag_data($data,'span','class','score');
        if ($type == '电影'){
            $arr = explode('>',$score[1]);
            $hot1 = explode('<',$arr[1]);
            $hot2 = $arr[2];
            $hot = $hot1[0].$hot2;
        }else{
            $arr = explode('>',$score[0]);
            $hot1 = explode('<',$arr[1]);
            $hot2 = $arr[2];
            $hot = $hot1[0].$hot2;
        }
        return $hot;
    }

    /**
     * 获取标签内容
     * @param $html  //需要获取的数据
     * @param $tag   //标签名
     * @param $attr  //需要获取的属性
     * @param $value  //属性能的值，用于定位
     * @return mixed
     */
    function get_tag_data($html,$tag,$attr,$value){
        $regex = "/<$tag.*?$attr=\".*?$value.*?\".*?>(.*?)<\/$tag>/is";
        preg_match_all($regex,$html,$matches,PREG_PATTERN_ORDER);
        return $matches[1];
    }

}