<?php

namespace Ethansmart\Httpbuilder\Http;

use Log;

/**
 * Class HttpClient
 * @package Ethansmart\HttpBuilder\Http
 * Support Http Method : GET, POST, PUT , DELETE
 */

class HttpClient
{
    private $ch ;
    private $uri ;
    private $method ;
    private $params ;
    private $header ;
    private $timeout;

    public function __construct()
    {
        $this->timeout = 120 ;
    }

    public function Get($data)
    {
        $data['method'] = "GET";
        return $this->HttpRequest($data);
    }

    public function Post($data)
    {
        $data['method'] = "POST";
        return $this->HttpRequest($data);
    }

    public function Put($data)
    {
        $data['method'] = "PUT";
        return $this->HttpRequest($data);
    }

    public function Delete($data)
    {
        $data['method'] = "DELETE";
        return $this->HttpRequest($data);
    }

    /**
     * @param $data
     * @return array
     */
    public function HttpRequest($data)
    {
        $this->ch = curl_init();
        $uri = $data['uri'];
        try {
            $this->dataValication($data);
        } catch (\Exception $e) {
            return ['code'=>-1, 'msg'=>$e->getMessage()];
        }

        $headers = $this->header;
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($this->ch, CURLOPT_HEADER, 1);
        curl_setopt($this->ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->method); //设置请求方式
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->params);
        curl_setopt($this->ch, CURLOPT_URL, $this->uri);

        if (1 == strpos('$'.$this->uri, "https://")) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $result = curl_exec($this->ch);

        Log::info("Request Headers: ". json_encode(curl_getinfo($this->ch, CURLINFO_HEADER_OUT)));

        if(!curl_errno($this->ch)){
            $info = curl_getinfo($this->ch);
            Log::info('耗时 ' . $info['total_time'] . ' Seconds 发送请求到 ' . $info['url']);
        }else{
            Log::info('Curl error: ' . curl_error($this->ch)) ;
            return ['code'=>-1, 'msg'=>"请求 $uri 出错: Curl error: ". curl_error($this->ch)];
        }

        curl_close($this->ch);
        Log::info("Request Result :".$result);

        if (!is_array($result) || !is_object($result)) {
            return ['code'=>0, 'msg'=>'OK', 'data'=> $result];
        }
        return ['code'=>0, 'msg'=>'OK', 'data'=>json_decode($result)];
    }

    public function setHeaders($header)
    {
        $this->header[] = $header;
        return $this;
    }

    public function setTimeout($timeout)
    {
        if (!empty($timeout) || $timeout != 30) {
            $this->timeout = $timeout ;
        }

        return $this;
    }

    public function dataValication($data)
    {
        if(!isset($data['uri']) || empty($data['uri'])){
            throw new \Exception("HttpClient Error: Uri不能为空", 4422);
        }else{
            $this->uri = $data['uri'];
        }

        if(!isset($data['params']) || empty($data['params'])){
            $this->params = [];
        }else{
            $this->params = $data['params'];
        }

        if(!isset($data['method']) || empty($data['method'])){
            $this->method = "POST";
        }else{
            $this->method = $data['method'];
        }
    }
}