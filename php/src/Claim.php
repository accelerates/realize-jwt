<?php
    /**
     * Created by PhpStorm.
     * User: liqi
     * Date: 2017/3/24
     * Time: 下午3:21
     */
    
    namespace JWT;
    
    
    class Claim implements \JsonSerializable
    {
        private $claim;
    
        /**
         * User: liqi
         * Date: 2016.8.16
         * Claim constructor.
         * @param $claim
         */
        public function __construct($claim)
        {
            $this->claim = $claim;
        }
    
        function jsonSerialize()
        {
            return json_encode($this->claim);
        }
    
    
    }