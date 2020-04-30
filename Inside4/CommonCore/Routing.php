<?php

namespace Inside4\CommonCore;

Class Routing {

    static function route(){

        //i--- Get Request URI ; inside_4_core_structure ; torrison ; 01.05.2020 ; 1 ---/
        $server_URI = $_SERVER['REQUEST_URI'];


        //i--- Check /xx/ Localization Prefix ; inside_4_core_structure ; torrison ; 01.05.2020 ; 2 ---/
        if (substr($server_URI, 3, 1) == '/') {
            $GLOBALS['inside4']['translate']['uri_prefix_value'] = substr($server_URI, 1, 2);
            $GLOBALS['inside4']['translate']['uri_prefix'] = '/'.$GLOBALS['inside4']['translate']['uri_prefix_value'];
            $server_URI = '/'.substr($server_URI, 4);

            if ($GLOBALS['inside4']['translate']['default_lang'] == $GLOBALS['inside4']['translate']['uri_prefix_value'])
            {
                $redirect_301_url = $GLOBALS['inside4']['main']['base_url'].$server_URI;
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$redirect_301_url);
                exit();
            }
        }

        //i--- Cut GET string ; inside_4_core_structure ; torrison ; 01.05.2020 ; 3 ---/
        $result = explode('?',  $server_URI);
        if (isset($result[1])) {
            $GLOBALS['inside4']['main']['get_string'] = $result[1];
            $server_URI = $result[0];
        }

        $GLOBALS['inside4']['main']['clear_uri'] = $server_URI;

        // Get URI parts explode by '/'
        $result = explode('/',  $server_URI);

        // echo $_SERVER['REQUEST_URI'];
        // print_r($result);

        //i--- Default Controller And Method ; torrison ; 01.05.2020 ; 4 ---/
        if (!isset($result[1]) OR $result[1] == '') $result[1] = 'main';
        if (!isset($result[2]) OR $result[2] == '') $result[2] = 'index';

        //i--- RUN Controller And Method ; torrison ; 01.05.2020 ; 6 ---/
        $route_class = "\\AppControllers\\".preg_replace('/[^a-zA-Z0-9]_/', '', ucfirst($result[1]));
        $route_method = preg_replace('/[^a-zA-Z0-9]_/', '', $result[2]);


        // echo "<br>".$route_class."->"; echo $route_method."<br>"; echo "OK"; exit();

        $run_controller = new $route_class();
        if (isset($result[3])) $run_controller->$route_method($result[3]);
        else $run_controller->$route_method();

    }

    // ---------- Helpers ---------------
    //i--- Small Helper for Debug (Optional) ; torrison ; 01.05.2020 ; 5 ---/
    public function echo_url(){
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://';
        return  $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }

}