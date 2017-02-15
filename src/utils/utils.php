<?php
/**
 * Created by PhpStorm.
 * User: yu.fu
 * Date: 2016/12/2
 * Time: 17:58
 */
namespace fanlisdk\src\utils;

class utils {
    //push接口暂时没有签名
    public function getSign() {

    }

    public function xmldecode($xml) {
        return json_decode(json_encode(simplexml_load_string($xml)), true);
    }

    public function xmlgenerate(array $arr, $type = '', $version = '4.0') {
        //array(array([...],[...])

        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<orders version="' . $version . '"' . ($type ? $type : '') . '>';
        foreach ($arr as $order) {
            $xml .= '<order>';
            $keys = array_keys($order);
            foreach ($keys as $key) {
                if (is_array($order[$key])) {
                    $xml .= "<$key>";

                    $xml .= "</$key>";
                } else {
                    $xml .= "<$key>" . $order[$key] . "</$key>";
                }
            }

            $xml .= '</order>';
        }
        $xml .= '<orders>';
        return $xml;
    }

    public function curl(array $postdata, $url) {
        $ch = curl_init();
        if ($ch === false) {
            return false;
        }
        //目前推送接口只支持post方式
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type:application/x-www-form-urlencoded', 'Accept:application/xml']);

        $result = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array('http_code' => $http_code, 'data' => $result);
    }

}