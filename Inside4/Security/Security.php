<?php

namespace Inside4\Security;

Class Security
{
    var $encryption_salt1 = ''; // 8 symbols
    var $encryption_salt2 = ''; // 8 symbols
    var $encryption_salt_length = 8;
    var $encryption_aes_key = ''; // 8 symbols
    var $encryption_iv_static = ''; // 8 symbols
    var $csrf_token_key = ''; // 32 symbols
    var $csrf_token_salt = ''; // 32 symbols

    // Dependencies
    var $db;

    function init() {
        $this->encryption_salt1 = $GLOBALS['inside4_main_config']['Security']['encryption_salt1'];
        $this->encryption_salt2 = $GLOBALS['inside4_main_config']['Security']['encryption_salt2'];
        $this->encryption_salt_length = $GLOBALS['inside4_main_config']['Security']['encryption_salt_length'];
        $this->encryption_aes_key = $GLOBALS['inside4_main_config']['Security']['encryption_aes_key'];
        $this->encryption_iv_static = $GLOBALS['inside4_main_config']['Security']['encryption_iv_static'];
        $this->csrf_token_key = $GLOBALS['inside4_main_config']['Security']['csrf_token_key'];
        $this->csrf_token_salt = $GLOBALS['inside4_main_config']['Security']['csrf_token_salt'];
    }

    //i--- Encrypt/Decrypt test method ; inside_security ; torrison ; 01.08.2018 ; 2 ---/
    function test() {

        $test = "Test3z134aaaZZZi";
        echo $test."<br><br>";

        $encrypted = $this->encrypt_secure($test);
        echo $encrypted."<br><br>";

        echo $this->decrypt_secure($encrypted)."<br><br>";

    }

    //i--- XSS Cleaner ; inside_security ; torrison ; 01.08.2018 ; 3 ---/
    function xss_cleaner($input) {
        if (is_array($input)) {
            $return = Array();
            foreach ($input as $value) {

                $value = str_replace( array('<','>',"'",'"',')','('), array('&lt;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $value );
                $value = str_ireplace( '%3Cscript', '', $value );

                $return[] = $value;
            }
        } else {
            $return = str_replace( array('<','>',"'",'"',')','('), array('&lt;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $input );
            $return = str_ireplace( '%3Cscript', '', $return );
        }

        return $return;
    }

    //i--- AES256 Encrypt/Decrypt methods ; inside_security ; torrison ; 01.08.2018 ; 4 ---/
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

    //i--- Random Strings Generators ; inside_security ; torrison ; 01.08.2018 ; 5 ---/
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

    // ---------------------------------- CSRF ---------------------------------
    function csfr_token($user_id) {
        return $user_id.$this->csrf_token_salt.$user_id;
    }

    function make_csfr_token($user_id) {
        return $this->aes256_encode($this->csfr_token($user_id), $this->csrf_token_key);
    }

    function check_csfr_token($user_id) {
        if ($this->aes256_decode($_POST['csrf_token'], $this->csrf_token_key) != $this->csfr_token($user_id)) {
            // echo $this->aes_256_decode_2($_POST['csrf_token'])." !== ".$this->csfr_token($user_id);
            exit();
        }
    }

}