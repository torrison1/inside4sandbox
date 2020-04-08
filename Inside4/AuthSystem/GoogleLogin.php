<?php

namespace Inside4\AuthSystem;

Class GoogleLogin {

    var $client_id;
    var $client_secret;
    var $redirect_uri;
    var $grant_type;

    var $access_token;

    public function set_config($config) {


        $this->client_id = $config['client_id'];
        $this->client_secret = $config['client_secret'];
        $this->redirect_uri = $config['redirect_uri'];
        $this->grant_type = $config['grant_type'];

    }

    public function social_login_link() {

        $loginUrl = "https://accounts.google.com/o/oauth2/auth?redirect_uri=".$this->redirect_uri.
            "&response_type=code&client_id=".$this->client_id.
            "&scope=https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile";

        return $loginUrl;

    }
    public function redirect_result() {

        $user = false;

        $result = false;
        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'grant_type' => $this->grant_type,
            'code' => $_GET['code']
        );

        $url = 'https://accounts.google.com/o/oauth2/token';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);
        $tokenInfo = json_decode($result, true);

        if (isset($tokenInfo['access_token'])) {
            $params['access_token'] = $tokenInfo['access_token'];

            $this->access_token = $tokenInfo['access_token'];

            $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);

            $user = $userInfo;
        }
        return $user;

    }


}