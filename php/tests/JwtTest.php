<?php
    /**
     * Created by PhpStorm.
     * User: liqi
     * Date: 2017/3/24
     * Time: 下午4:26
     */
    
    use PHPUnit\Framework\TestCase;
    
    class JwtTest extends TestCase
    {
        
        private $header = [ 'typ' => 'JWT', 'alg' => 'HS256', 'kid' => '1' ];//head
        private $claim = [
            'iss' => 'liqi',
            'sub' => 'web',
            'aud' => 'chrome',
            'iat' => "2016-1-1",
            'exp' => '1231453215312'
        ];//claim
        
        private $secret = "^%$#*hggf";
    
    
        /**
         * @expectedException \JWT\Exception\ParameterException
         */
        public function testHeader(){
            $data = ['kid' => '1'];
            $header = new \JWT\Header($data);
        }
        
        public function testHeaderJsonable(){
            $header = new \JWT\Header($this->header);
            $json = $header->jsonSerialize();
            $parse = json_decode($json);
            $this->assertEquals(JSON_ERROR_NONE,json_last_error());
        }
        
        
        public function testEncode()
        {
            $header = new \JWT\Header($this->header);
            $claim = new \JWT\Claim($this->claim);
            $token = \JWT\Jwt::encode($header, $claim, $this->secret);
            $this->assertTrue((bool)$token);
            return $token;
        }
        
        /**
         * @depends testEncode
         */
        public function testDecode($token)
        {
            $decode = \JWT\Jwt::decode($token, $this->secret);
            $this->assertNotEmpty($decode);
            $this->assertEquals(2, count($decode));
            $this->assertEquals($this->header, $decode[ 0 ]);
            $this->assertEquals($this->claim, $decode[ 1 ]);
        }
        
        
        public function testDecodeEmpty(){
            $token = '';
            $decode = \JWT\Jwt::decode($token,$this->secret);
            $this->assertTrue(!$decode);
        }
        
    }
