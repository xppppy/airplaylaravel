<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;

class TestController extends Controller {
    public function test($sourceaddr,$timeout=10) {
        //-----------------------------------------
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

        //返回0时表示程序执行成功
        if ($bool == 0) {
            $scriptArray = $this->Is_VideoQQ($data);
            $type = $this->GetType($scriptArray);
            if ($type != '电视剧' || $type != '动漫' || $type != '电影'){
                return [
                    'title'     => $this->GetTitle($scriptArray),
                    'type'      => '其他',
                    'numbUrl'   => $sourceaddr,
                    'thum'      => '',
                    'brief'     => '',
                    'hot'       => ''
                ];
            }
            //'title'=>
//            dump($this->GetTitle($scriptArray));
//
//            dump($this->GetType($scriptArray));
//
//            dump($this->Is_TvOrComic($scriptArray,$type,$sourceaddr));
//
//            dump($this->GetPic($scriptArray));
//
//            dump($this->GetBrief($scriptArray));
//
//            dump($this->GetHot($scriptArray));
//            exit;
            return  [
                'title'     => $this->GetTitle($scriptArray),
                'type'      => $this->GetType($scriptArray),
                'numbUrl'   => $this->Is_TvOrComic($scriptArray,$type,$sourceaddr),
                'thum'      => $this->GetPic($scriptArray),
                'brief'     => $this->GetBrief($scriptArray),
                'hot'       => $this->GetHot($scriptArray)
            ];

        } else {
            return 'error';
        }

    }

    /**
     * 判断是电视剧还是动漫
     * @param $scriptArray
     * @param $type
     * @return array|array|int
     */
    public function Is_TvOrComic($scriptArray,$type,$sourceaddr){
        if ($type == '电视剧'){
            return $this->GetTvNmuber($scriptArray);
        }elseif ($type == '动漫'){
            return $this->GetComicNmuber($scriptArray,$sourceaddr);
        }
        return 1;
    }
    /**
     * 获取电视剧集数
     * @param  $scriptArray //获取js中的数据
     * @return array|string
     */
    public function GetTvNmuber($scriptArray){
        //获取js中plot_id的数据
        $plot_id = '/"plot_id":"{(.*)}"/is';
        preg_match_all($plot_id, $scriptArray[0][4], $scriptArrays);
        //获取电视剧集数，数据格式为\"xxxx\":\"xxxxx_1_12\"
        $plotidArry = explode(',',$scriptArrays[1][0]);
        $arr =[];
        foreach ($plotidArry as $dataArray){
            //通过"_"打断，新数据为[0=>\"xxxx\":\"xxxxx,1=>1,2=>12\]
            $data = explode("_",$dataArray);
            //通过“\”打断，新数据为[0=>12,1=>"]，$index[0]=12,获得集数
            $index = explode('\\',$data[2]);
            //通过“\"”打断，新数据为[0=>,1=>xxxx,2=>":,3=>"xxxx],获取url中间部分用于还原url，原url“https:xxxx/$k[3]/$k[1]”
            $k = explode('\\"',$data[0]);
            //通过集数重新组装
            $arr[(int)$index[0]] = ['url'=>"v.qq.com/x/cover/".$k[3].'/'.$k[1].".html"];
        }
        //根据key重新排列数组
        if (ksort($arr)){
            return $arr;
        }else{
            return false ;
        }
    }

    /**
     * 获取动漫集数
     * @param  $scriptArray //获取js中的数据
     * @return array
     */
    public function GetComicNmuber($scriptArray,$sourceaddr){
        $arr = [];
        //获取js中plot_id的数据
        $video_id = '/"video_ids":\[(.*?)\]/is';
        preg_match_all($video_id, $scriptArray[0][4], $video_ids);
        $url = explode('.',explode('/',$sourceaddr)[5])[0];
        $video_idArray = explode(',',$video_ids[1][0]);

        for ($i = 0; $i < count($video_idArray) ; $i++){
            $v = explode("\"",$video_idArray[$i]);
            $arr[$i+1] = ['url'=>"v.qq.com/x/cover/".$url."/".$v[1].".html"];
        }
        return $arr;
    }

    /**
     * 获取影视 title
     * @param $scriptArray //获取js中的数据
     * @return bool
     */
    public function GetTitle($scriptArray){
//        $tag = '/"tag":\[(.*?)\]/is';
        $title ='/"title":\"(.*?)\"/is';
        preg_match_all($title,$scriptArray[0][4],$tags);
        if ($tags){
            return $tags[1][0];
        }
        return false;
    }

    /**
     * 获取影视 type
     * @param $scriptArray //获取js中的数据
     * @return bool
     */
    public function GetType($scriptArray){
        $type =  '/"type_name":"(.*?)"/is';
        preg_match_all($type,$scriptArray[0][4],$types);
        if ($types){
            return $types[1][0];
        }
        return false;
    }

    /**
     * 获取影视 Brief
     * @param $scriptArray //获取js中的数据
     * @return bool
     */
    public function GetBrief($scriptArray){
        $description ='/"description":"(.*?)"/is';
        preg_match_all($description,$scriptArray[0][4],$descriptionArrays);
        if ($descriptionArrays){
            return $descriptionArrays[1][0];
        }
        return false;
    }

    /**
     * 获取影视 img
     * @param $scriptArray //获取js中的数据
     * @return bool
     */
    public function GetPic($scriptArray){
        $horizontal_pic_url = '/"horizontal_pic_url":\"(.*?)\"/';
        preg_match_all($horizontal_pic_url,$scriptArray[0][4],$horizontal_pic_urls);
        if ($horizontal_pic_urls){
            return $horizontal_pic_urls[1][0];
        }
        return false;
    }

    /**
     * 获取影视 hot
     * @param $scriptArray //获取js中的数据
     * @return bool
     */
    public function GetHot($scriptArray){
        $douban_score = '/"douban_score":\"(.*?)\"/';
        preg_match_all($douban_score,$scriptArray[0][4],$douban_scores);
        if ($douban_scores){
            return $douban_scores[1][0];
        }
        return false;
    }

    /**
     *判断来源
     * @param $data //获取head中的数据
     * @return string
     */
    public function Is_VideoQQ($data){
        $head = '/<head.*?>(.*)<\/head>/ism';
        $script = '/<script([\w\W]*)<\/script>/iU';
        $link_url ='/<link rel="shortcut icon" href="(.*?)"/is';
        preg_match_all($head, $data, $headArray); //获取head内容
        preg_match_all($link_url, $headArray[0][0], $link_url);//获取来源

        if(explode('/',$link_url[1][0])[2] == "v.qq.com"){
            preg_match_all($script, $headArray[1][0], $scriptArray);//获取script中的内容
            return $scriptArray;
        }

        return false;
    }
}
