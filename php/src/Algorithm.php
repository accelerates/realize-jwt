<?php
    /**
     * Created by PhpStorm.
     * User: liqi
     * Date: 2017/3/24
     * Time: 下午3:24
     */
    
    namespace JWT;
    
    
    class Algorithm
    {
        
        private $iv;
        
        private $public_secret;
        
        /**
         * User: liqi
         * Date: 2016.8.16
         * Algorithm constructor.
         * @param string $iv
         * @param string $public_secret
         */
        public function __construct($iv = null, $public_secret = null)
        {
            $this->iv = $this->_default($iv, '1234567890123456');
            $this->public_secret = $this->_default($public_secret, 'jwt');
        }
        
        public function encode($head, $claim, $secret)
        {
            $join = implode('.',
                [
                    $this->urlSafeBase64Encode($head),
                    $this->urlSafeBase64Encode($claim)
                ]);
            $sign = $this->sign($join, $secret);
            
            return $this->encrypt($join . '.' . $sign);
        }
        
        public function decode($token, $secret)
        {
            if ($data = $this->validSign($token, $secret)) {
                list($head, $claim) = $data;
                
                return [ json_decode($this->urlSafeBase64Decode($head), true), json_decode($this->urlSafeBase64Decode($claim), true) ];
            } else {
                return false;
            }
        }
        
        /**
         * 签名
         */
        public function sign($data, $secret)
        {
            return hash_hmac('sha256', $data, $secret);
        }
        
        //公钥加密
        public function encrypt($token)
        {
            return openssl_encrypt($token, 'AES-256-CBC', $this->getPublicSecret(), false, $this->getIv());
        }
        
        
        //公钥解密
        public function decrypt($token)
        {
            return openssl_decrypt($token, 'AES-256-CBC', $this->getPublicSecret(), false, $this->getIv());
        }
        
        //验证签名
        public function validSign($token, $secret)
        {
            $decode = $this->decrypt($token);
            if(!$decode) return false;
            list($head, $claim, $sign) = explode('.', $decode);
            if ($this->sign($head . '.' . $claim, $secret) == $sign) {
                return [ $head, $claim, $sign ];
            } else {
                return false;
            }
        }
        
        
        public function urlSafeBase64Encode($data)
        {
            return base64_encode($data);
        }
        
        public function urlSafeBase64Decode($data)
        {
            return base64_decode($data);
        }
        
        
        private function _default($param, $default)
        {
            switch ( (bool)$param ) {
                case false:
                    return $default;
                default:
                    return $param;
            }
        }
        

        public function getIv()
        {
            return $this->iv;
        }
        

        public function getPublicSecret()
        {
            return $this->public_secret;
        }
    }