<?php

namespace Inside4\CommonCore;

Class Globals {

    public function init() {

        // Globals Objects:
        // $GLOBALS['inside4']['Globals'] = new \Inside4\CommonCore\Globals
        // $GLOBALS['inside4']['Routing'] = new \Inside4\CommonCore\Routing

        //i--- Set time for count speed (Optional) ; inside_4_core_structure ; torrison ; 01.05.2020 ; 1 ---/
        $GLOBALS['inside4']['Timer']['time_start'] = microtime();

        //i--- Set Default Language [RAW] ; inside_4_core_structure ; torrison ; 01.05.2020 ; 2 ---/
        $GLOBALS['inside4']['translate']['default_lang'] = $GLOBALS['inside4_main_config']['Translate']['default_lang']; // <<< Default System Language

        //i--- Set Base URL ; inside_4_core_structure ; torrison ; 01.05.2020 ; 3 ---/
        $GLOBALS['inside4']['main']['base_url'] = sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME']
        );

        //i--- URL Global Parts (Define in \Inside4\CommonCore\Routing) ; inside_4_core_structure ; torrison ; 01.05.2020 ; 4 ---/
        $GLOBALS['inside4']['translate']['uri_prefix_value'] = '';
        $GLOBALS['inside4']['translate']['uri_prefix'] = '';
        $GLOBALS['inside4']['main']['clear_uri'] = '';
        $GLOBALS['inside4']['main']['get_string'] = '';

        //i--- Fast Access to Database (Define in \Inside4\CommonCore\Database) ; inside_4_core_structure ; torrison ; 01.05.2020 ; 5 ---/
        $GLOBALS['inside4']['db'] = '';

        //i--- Fast Access to Session Data (Define in \Inside4\CommonCore\Sessions) ; inside_4_core_structure ; torrison ; 01.05.2020 ; 6 ---/
        $GLOBALS['inside4']['main']['session_data'] = '';

    }

}
