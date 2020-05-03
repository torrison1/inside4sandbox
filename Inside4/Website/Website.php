<?php

namespace Inside4\Website;

Class Website {

    var $config;

    //i--- Define and init global Website Variables ; inside_template ; torrison ; 01.05.2020 ; 1 ---/
    public function init(){

        $this->config['main']['sitename'] = $GLOBALS['inside4_main_config']['Website']['sitename'];
        $this->config['main']['base_url'] = $GLOBALS['inside4_main_config']['Website']['base_url'];

        $this->config['facebook']['app_id'] = $GLOBALS['inside4_main_config']['Website']['fb_app_id'];
        $this->config['facebook']['app_secret'] = $GLOBALS['inside4_main_config']['Website']['fb_app_secret'];
        $this->config['facebook']['app_login_redirect'] = $GLOBALS['inside4_main_config']['Website']['fb_app_login_redirect'];

        $this->config['facebook']['fb_img_url'] = $GLOBALS['inside4_main_config']['Website']['fb_img_url'];

        $this->config['google']['client_id'] = $GLOBALS['inside4_main_config']['Website']['g_client_id'];
        $this->config['google']['client_secret'] = $GLOBALS['inside4_main_config']['Website']['g_client_secret'];
        $this->config['google']['redirect_uri'] = $GLOBALS['inside4_main_config']['Website']['g_redirect_uri'];
        $this->config['google']['grant_type'] = 'authorization_code';

        $this->config['mailer']['footer'] = "<a href='".$this->config['main']['base_url']."/'>".$this->config['main']['sitename']."</a>";
        $this->config['mailer']['admin_email'] = $GLOBALS['inside4_main_config']['Website']['admin_email'];


    }

    //i--- Google Analytics Code ; inside_template ; torrison ; 01.05.2020 ; 2 ---/
    public function ga_code(){
        ob_start();
        ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-157290025-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-157290025-1');
</script>
<?php
        return ob_get_clean();
    }

    //i--- Redirect Methods ; inside_template ; torrison ; 01.05.2020 ; 3 ---/
    public function redirect_301($redirect_301_url){

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$redirect_301_url);
        exit();
    }

    public function redirect_refresh($url){

        header("refresh: 1; url=$url");
        echo "Redirecting, please wait...";
        exit();
    }

    public function redirect_refresh_message($url, $message){

        echo $message."<br>";
        header("refresh: 1; url=$url");
        echo "Redirecting, please wait...";
        exit();
    }

}
