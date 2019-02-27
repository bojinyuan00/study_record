<?php

namespace Client\Controller;
use Think\Controller;

//前台需要调用的方法
class ClientController extends Controller{
    const TOKEN = 'API';
    //Ä£ÄâÇ°Ì¨ÇëÇó·þÎñÆ÷api½Ó¿Ú
    public function getDataFromServer(){
        //Ê±¼ä´Á
        $timeStamp = time();
        //Ëæ»úÊý
        $randomStr = $this -> createNonceStr();
        //Éú³ÉÇ©Ãû
        $signature = $this -> arithmetic($timeStamp,$randomStr);
        //urlµØÖ·
        $url = "http://www.apitest.com/Server/Server/respond/t/{$timeStamp}/r/{$randomStr}/s/{$signature}";
        $result = $this -> httpGet($url);
        dump($result);
    }

    //curlÄ£ÄâgetÇëÇó¡£
    private function httpGet($url){
        $curl = curl_init();

        //ÐèÒªÇëÇóµÄÊÇÄÄ¸öµØÖ·
        curl_setopt($curl,CURLOPT_URL,$url);
        //±íÊ¾°ÑÇëÇóµÄÊý¾ÝÒÑÎÄ¼þÁ÷µÄ·½Ê½Êä³öµ½±äÁ¿ÖÐ
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);

        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    //Ëæ»úÉú³É×Ö·û´®
    private function createNonceStr($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return "z".$str;
    }

    /**
     * @param $timeStamp Ê±¼ä´Á
     * @param $randomStr Ëæ»ú×Ö·û´®
     * @return string ·µ»ØÇ©Ãû
     */
    private function arithmetic($timeStamp,$randomStr){
        $arr['timeStamp'] = $timeStamp;
        $arr['randomStr'] = $randomStr;
        $arr['token'] = self::TOKEN;
        //°´ÕÕÊ××ÖÄ¸´óÐ¡Ð´Ë³ÐòÅÅÐò
        sort($arr,SORT_STRING);
        //Æ´½Ó³É×Ö·û´®
        $str = implode($arr);
        //½øÐÐ¼ÓÃÜ
        $signature = sha1($str);
        $signature = md5($signature);
        //×ª»»³É´óÐ´
        $signature = strtoupper($signature);
        return $signature;
    }



    


}

//后台控制器内需要的方法与判断
class ServerController extends Controller{
    const TOKEN = 'API';

    //响应前台的请求
    public function respond(){
        //验证身份
        $timeStamp = $_GET['t'];
        $randomStr = $_GET['r'];
        $signature = $_GET['s'];
        $str = $this -> arithmetic($timeStamp,$randomStr);
        if($str != $signature){
            echo "-1";
            exit;
        }
        //模拟数据
        $arr['name'] = 'api';
        $arr['age'] = 15;
        $arr['address'] = 'zz';
        $arr['ip'] = "192.168.0.1";
        echo json_encode($arr);
    }

    /**
     * @param $timeStamp 时间戳
     * @param $randomStr 随机字符串
     * @return string 返回签名
     */
    public function arithmetic($timeStamp,$randomStr){
        $arr['timeStamp'] = $timeStamp;
        $arr['randomStr'] = $randomStr;
        $arr['token'] = self::TOKEN;
        //按照首字母大小写顺序排序
        sort($arr,SORT_STRING);
        //拼接成字符串
        $str = implode($arr);
        //进行加密
        $signature = sha1($str);
        $signature = md5($signature);
        //转换成大写
        $signature = strtoupper($signature);
        return $signature;
    }
}
--------------------- 
作者：善良死神 
来源：CSDN 
原文：https://blog.csdn.net/li741350149/article/details/62887524 
版权声明：本文为博主原创文章，转载请附上博文链接！
