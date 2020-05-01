<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Auth extends BaseController {

    //i--- Login Page: /auth/login page ; inside_auth ; torrison ; 01.05.2020 ; 1 ---/
    public function login(){

        $this->view->render($this->data,'Auth/login', 'app_default_template');
    }

    //i--- User Profile Page: /auth/profile page ; inside_auth ; torrison ; 01.05.2020 ; 2 ---/
    public function profile(){

        if (!$this->auth->user) {
            $redirect_link = $GLOBALS['inside4']['translate']['uri_prefix'].'/';
            $this->website->redirect_refresh($redirect_link);
        }

        // Profile
        $this->view->render($this->data,'Auth/auth_profile', 'app_default_template');
    }

    //i--- Logout links: /auth/logout, /auth/off links ; inside_auth ; torrison ; 01.05.2020 ; 3 ---/
    public function logout(){
        // Logout + Redirect to Main Page
        $this->auth->logout();
        $redirect_link = $GLOBALS['inside4']['translate']['uri_prefix'].'/';
        $this->website->redirect_refresh($redirect_link);
    }
    public function off(){
        $this->logout();
    }

    //i--- Facebook redirect  link: /auth/facebook_redirect ; facebook_auth ; torrison ; 01.05.2020 ; 1 ---/
    public function facebook_redirect(){

        $fb_user_data = $this->auth->fb_login->redirect_result();
        $email = $fb_user_data->getField('email');
        $data['fb_id'] = $fb_user_data->getField('id');
        $data['username'] = $fb_user_data->getField('name');
        // Download Avatar
        // ... TO DO
        // $data['img'] = $fb_user_data->getField('picture');
        $data['img'] = '';

        $res = $this->auth->social_login($email, $data, 'fb');
        echo $res['message']."<br>";
        if ($res['login_type'] == 'register') $redirect_link = '/auth/profile?reg=1';
        else $redirect_link = $GLOBALS['inside4']['translate']['uri_prefix'].'/auth/profile';
        $this->website->redirect_refresh($redirect_link);

    }

    //i--- Google redirect  link: /auth/google_redirect ; google_auth ; torrison ; 01.05.2020 ; 1 ---/

    public function google_redirect(){
        $user_data = $this->auth->google_login->redirect_result();
        $email = $user_data['email'];

        $data['google_id'] = $user_data['id'];
        $data['username'] = $user_data['name'];

        $data['default_lang'] = $user_data['locale'];

        // Download Avatar
        // ... TO DO
        // $data['img'] = $fb_user_data->getField('picture');
        $data['img'] = '';

        // print_r($user_data);
        // print_r($email);
        // print_r($data);

        $res = $this->auth->social_login($email, $data, 'google');

        echo $res['message']."<br>";
        if ($res['login_type'] == 'register') $redirect_link = '/auth/profile?reg=1';
        else $redirect_link = $GLOBALS['inside4']['translate']['uri_prefix'].'/auth/profile';
        $this->website->redirect_refresh($redirect_link);

    }

    //i--- Generate New Password link: /auth/generate_new_password ; inside_auth ; torrison ; 01.05.2020 ; 4 ---/
    public function generate_new_password(){

        $code = $_GET['code'];

        if ($this->auth->check_password_recovery_code($code)){
            // New Password was sent
            $this->view->render($this->data,'Static/new_password', 'app_default_template');
        } else {

            $this->data['header'] = 'Recovery Code Wrong !';
            $this->data['content'] = 'Try again or contact a support!';
            $this->view->render($this->data,'Static/message', 'app_default_template');
        }
    }

    //i--- Email Verification link: /auth/email_verification_code (send code or process code when isset $_GET['code']) ; inside_auth ; torrison ; 01.05.2020 ; 5 ---/
    public function email_verification_code() {

        if(isset($_GET['code'])) {

            if ($this->auth->email_verification_code($_GET['code'])) {

                // Success
                $this->data['header'] = 'Success!';
                $this->data['content'] = 'Your Email is verified!';

            }
            else {
                // Error
                $this->data['header'] = 'Code Wrong !';
                $this->data['content'] = 'Try again or contact a support!';
            }

        } else {
            $this->data['header'] = 'No Code !';
            $this->data['content'] = 'Try again or contact a support!';
        }
        $this->data['redirect'] = $GLOBALS['inside4']['translate']['uri_prefix']."/";
        $this->view->render($this->data,'Static/message_redirect', 'app_default_template');

    }

}