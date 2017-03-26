<?php
    /**
     * Created by PhpStorm.
     * User: liqi
     * Date: 2017/3/24
     * Time: 下午3:24
     */
    
    namespace JWT;
    
    
    class Jwt
    {
        private static function getAlgorithm()
        {
            return new Algorithm();
        }
        
        //传入数据获取token
        public static function encode(\JsonSerializable $head, \JsonSerializable $claim, $secret)
        {
            $algorithm = static::getAlgorithm();
            return $algorithm->encode($head->jsonSerialize(), $claim->jsonSerialize(), $secret);
        }
        
        // 传入token验证签名并获取数据
        public static function decode($token, $secret)
        {
            $algorithm = static::getAlgorithm();
            if ($decode = $algorithm->decode($token, $secret)) {
                return $decode;
            } else {
                return false;
            }
        }
        
    }