<?php

namespace Inside4\CommonCore;

Class Sessions {

    //i--- Session System make tokens and control users sessions ; inside_core ; torrison ; 01.05.2020 ; 1 ---/
    var $session_data;
    var $sessions_table = 'inside_sessions';
    var $sessions_actions_table  = 'inside_sessions_actions';
    var $client_ip;
    var $token;

    // Dependencies
    var $db;
    var $security;


    public function init() {

        $this->client_ip = $this->get_ip();

        // Get Cookie inside_token
        // print_r($_COOKIE);

        //i--- inside4_session in a session token in the COOKIE variable ; inside_core ; torrison ; 01.05.2020 ; 2 ---/
        if (isset($_COOKIE['inside4_session'])) {

            $this->session_data = $this->get_session_data($_COOKIE['inside4_session']);

            if (!$this->session_data) {
                $this->session_data = $this->create_session();
                $this->track_activity('error_token_new_session');
            } else {
                $this->track_activity('user #'.$this->session_data['user_id']);
            }

        } else {
            $this->session_data = $this->create_session();
            $this->track_activity('new_session');
        }

        // print_r($GLOBALS['inside4']['main']['session_data']);
    }

    //i--- Session data store info about user browser and IP address ; inside_core ; torrison ; 01.05.2020 ; 3 ---/
    public function get_session_data($token){

        $session_data = Array();

        // Generate encrypted token
        $encrypted_random_token = $this->security->encrypt_secure_static($token);
        $encrypted_random_token = md5($encrypted_random_token);

        // Get Session Row
        $query = "SELECT 
                    id, start_time, last_activity, user_agent, ip_address, user_id
                    FROM ".$this->sessions_table." 
                    WHERE token_encrypted = ".$this->db->quote($encrypted_random_token)." LIMIT 1
        ";
        $data = $this->db->sql_get_data($query);
        // Token Check
        if (isset($data[0]['id'])) {
            $session_data = $data[0];

            // Update Session Row
            $tokens = $this->generate_tokens();
            $update_data['token_encrypted'] = $tokens['token_encrypted'];
            $update_data['last_activity'] = time();
            $this->db->update($this->sessions_table, $update_data, 'WHERE id = '.intval($data[0]['id']));


        }
        else $session_data = false;

        return $session_data;

    }

    //i--- On Authentication user_id adds to session user data  ; inside_core ; torrison ; 01.05.2020 ; 4 ---/
    public function add_user_to_session($user_id){
        $update_data['user_id'] = intval($user_id);
        $this->db->update($this->sessions_table, $update_data, 'WHERE id = '.$this->session_data['id']);
    }

    //i--- On LogOut user_id removes from session user data  ; torrison ; 01.05.2020 ; 5 ---/
    public function remove_user_from_session(){
        $update_data['user_id'] = 0;
        $this->db->update($this->sessions_table, $update_data, 'WHERE id = '.$this->session_data['id']);
    }

    //i--- When user come firstly system makes session data and give a token ; inside_core ; torrison ; 01.05.2020 ; 6 ---/
    public function create_session(){

        $tokens = $this->generate_tokens();

        // echo "Token : ".$new_random_token."<br><br>";
        // echo "Token Encrypted : ".$encrypted_random_token."<br><br>";

        // Make and Save Session Row
        $data['start_time'] = time();
        $data['token_encrypted'] = $tokens['token_encrypted'];
        $data['last_activity'] = time();
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['ip_address'] = $this->client_ip;
        $data['user_id'] = 0;

        $this->db->insert($this->sessions_table, $data);
        $data['id'] = $this->db->last_id();

        return $data;

    }

    //i--- Token generated randomly and checking to be unique ; inside_core ; torrison ; 01.05.2020 ; 7 ---/
    public function generate_tokens(){

        $token_ready = false;

        while (!$token_ready) {

            // Random Token
            $new_random_token = (time()).(floor(microtime(1)*10000)).$this->security->generateRandomString('16');
            $encrypted_random_token = $this->security->encrypt_secure_static($new_random_token);
            $encrypted_random_token = md5($encrypted_random_token);
            $query = "SELECT 
                    id FROM ".$this->sessions_table." 
                    WHERE token_encrypted = ".$this->db->quote($encrypted_random_token)." LIMIT 1
        ";
            $data = $this->db->sql_get_data($query);
            // Token Check
            if (!isset($data[0]['id'])) $token_ready = true;
        }

        $res['new_token'] = $new_random_token;
        $this->token = $new_random_token;
        setcookie('inside4_session', $new_random_token, strtotime("+1 year"), '/');

        $res['token_encrypted'] = $encrypted_random_token;

        return $res;
    }

    //i--- Also Session System has track_activity method for save users activities for analyse usability process ; inside_core ; torrison ; 01.05.2020 ; 8 ---/
    public function track_activity($action){

        $activity_row = Array();

        $activity_row['session_id'] = $this->session_data['id'];
        $activity_row['time'] = time();
        $activity_row['url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $activity_row['action'] = $action;
        $this->db->insert($this->sessions_actions_table, $activity_row);
    }

    //i--- Method get_ip helps to get client IP address ; inside_core ; torrison ; 01.05.2020 ; 9 ---/
    public function get_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}