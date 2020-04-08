<?php

namespace Inside4\AuthSystem;

Class FacebookLogin {

    var $app_id;
    var $app_secret;
    var $app_login_redirect;

    var $access_token;

    public function set_config($config) {


        $this->app_id = $config['app_id'];
        $this->app_secret = $config['app_secret'];
        $this->app_login_redirect = $config['app_login_redirect'];

    }

    public function init() {

        session_start();

    }
    public function fb_login_link() {

        $fb = new \Facebook\Facebook([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret,
            'default_graph_version' => 'v3.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl($this->app_login_redirect, $permissions);

        return htmlspecialchars($loginUrl);

    }
    public function redirect_result() {

        $user = false;

        $fb = new \Facebook\Facebook([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret,
            'default_graph_version' => 'v3.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken($this->app_login_redirect);
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
        } else {
            $this->access_token = $accessToken->getValue();

            // $_SESSION['fb_access_token'] = (string) $accessToken;

            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get('/me?fields=id,name,email,picture.type(large)', $accessToken->getValue());
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
            }

            $user = $response->getGraphUser();
        }

        return $user;

    }


}