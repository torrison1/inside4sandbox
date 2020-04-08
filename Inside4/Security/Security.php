<?php

namespace Inside4\Security;

Class Security
{
    var $encryption_salt1 = ''; // 8 symbols
    var $encryption_salt2 = ''; // 8 symbols
    var $encryption_salt_length = 8;
    var $encryption_aes_key = ''; // 8 symbols
    var $encryption_iv_static = ''; // 8 symbols

    // Dependencies
    var $db;

    function init() {
        $this->encryption_salt1 = $GLOBALS['inside4_main_config']['Security']['encryption_salt1'];
        $this->encryption_salt2 = $GLOBALS['inside4_main_config']['Security']['encryption_salt2'];
        $this->encryption_salt_length = $GLOBALS['inside4_main_config']['Security']['encryption_salt_length'];
        $this->encryption_aes_key = $GLOBALS['inside4_main_config']['Security']['encryption_aes_key'];
        $this->encryption_iv_static = $GLOBALS['inside4_main_config']['Security']['encryption_iv_static'];
    }

    function test() {

        $test = "Test3z134aaaZZZi";
        echo $test."<br><br>";

        $encrypted = $this->encrypt_secure($test);
        echo $encrypted."<br><br>";

        echo $this->decrypt_secure($encrypted)."<br><br>";

    }

    function xss_cleaner($input_str) {
        $return_str = str_replace( array('<','>',"'",'"',')','('), array('&lt;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $input_str );
        $return_str = str_ireplace( '%3Cscript', '', $return_str );
        return $return_str;
    }

    function encrypt_secure($string) {

        $string = $this->encryption_salt1.$string.$this->encryption_salt2;
        $encrypted = $this->aes256_encode($string, $this->encryption_aes_key);
        return $encrypted;
    }

    function encrypt_secure_static($string) {

        $string = $this->encryption_salt1.$string.$this->encryption_salt2;
        $encrypted = $this->aes256_encode_static($string, $this->encryption_aes_key);
        return $encrypted;
    }

    function decrypt_secure($string) {


        $string = $this->aes256_decode($string, $this->encryption_aes_key);
        $string = substr($string, $this->encryption_salt_length);
        $string = substr($string, 0, (-1)*$this->encryption_salt_length);

        return $string;
    }

    function generateRandomString($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function generateRandomString_unique($table, $column, $length = 16) {

        $random = false;
        $random_ready = false;
        $i=0;
        while (!$random_ready) {

            $random = md5(time()).$this->generateRandomString($length);
            $query = "SELECT 
                    id FROM ".$table." 
                    WHERE ".$column." = ".$this->db->quote($random)." LIMIT 1
        ";
            $data = $this->db->sql_get_data($query);
            // Random Check
            if (!isset($data[0]['id'])) $random_ready = true;

            $i++;
            if ($i > 100) {
                $random = false;
                $random_ready = true;
            }

        }

        return $random;
    }

    function aes256_encode($data, $key) {

        $iv = $this->generateRandomString(16);
        $res = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $res = $iv . base64_encode($res);
        return $res;
    }

    function aes256_encode_static($data, $key) {

        $iv = $this->encryption_iv_static;
        $res = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $res = $iv . base64_encode($res);
        return $res;
    }

    function aes256_decode($data, $key) {

        $iv = substr($data, 0, 16);
        $decrypt = substr($data, 16);
        $decrypt = base64_decode($decrypt);
        $decrypted = openssl_decrypt(
            $decrypt, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv
        );
        return $decrypted;
    }


    function aes_256_encode_2($data, $key) {

        $iv = substr(sha1(mt_rand()), 0, 16); // 16 rand symbols
        $encrypted = openssl_encrypt(
            json_encode($data), 'aes-256-cbc', $key, null, $iv
        );
        $encrypted = $encrypted.$iv;

        return base64_encode($encrypted);
    }

    function aes_256_decode_2($data, $key) {

        $decrypt = base64_decode($data);

        $iv = substr($decrypt, -16);
        $decrypt = substr($decrypt, 0, -16);
        $decrypted = openssl_decrypt(
            $decrypt, 'aes-256-cbc', $key, null, $iv
        );

        return $decrypted;
    }

    function String2Hex($string){
        $hex='';
        for ($i=0; $i < strlen($string); $i++){
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }

    function Hex2String($hex){
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2){
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }

    function ascii2hex($ascii) {
        $hex = '';
        for ($i = 0; $i < strlen($ascii); $i++) {
            $byte = strtoupper(dechex(ord($ascii{$i})));
            $byte = str_repeat('0', 2 - strlen($byte)).$byte;
            $hex.=$byte." ";
        }
        return $hex;
    }

    function hex2str($hex) {
        $str = '';
        for($i=0;$i<strlen($hex);$i+=2) $str .= chr(hexdec(substr($hex,$i,2)));
        return $str;
    }

    function hexToAscii($inputHex) {
        $inputHex = str_replace(' ', '', $inputHex);
        $inputHex = str_replace('\x', '', $inputHex);
        $ascii = pack('H*', $inputHex);
        return $ascii;
    }

}