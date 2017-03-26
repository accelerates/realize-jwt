<?php
    
    /**
     * Created by PhpStorm.
     * User: liqi
     * Date: 2017/3/24
     * Time: 下午3:18
     */
    
    namespace JWT;
    

    
    use JWT\Exception\ParameterException;

    class Header implements \JsonSerializable
    {
        private $header;
    
        /**
         * User: liqi
         * Date: 2016.8.16
         * Header constructor.
         * @param $header
         */
        public function __construct(array $header)
        {
            if(isset($header['typ'])&&isset($header['alg'])){
                $this->header = $header;
            }else{
                throw new ParameterException("the 'typ' or 'alg' is require in header");
            }
        }
    
        function jsonSerialize()
        {
            return json_encode($this->header);
        }
    
    
    }