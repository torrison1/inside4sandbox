<?php

namespace Inside4\CommonCore;

Class Globals {

    public function init() {

        // Globals Objects:
        // $GLOBALS['inside4']['Globals'] = new \Inside4\CommonCore\Globals
        // $GLOBALS['inside4']['Routing'] = new \Inside4\CommonCore\Routing

        $GLOBALS['inside4']['Timer']['time_start'] = microtime();

        $GLOBALS['inside4']['translate']['default_lang'] = 'en'; // <<< Default System Language
        $GLOBALS['inside4']['main']['base_url'] = sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME']
        );

        // Define in \Inside4\CommonCore\Routing
        $GLOBALS['inside4']['translate']['uri_prefix_value'] = '';
        $GLOBALS['inside4']['translate']['uri_prefix'] = '';
        $GLOBALS['inside4']['main']['clear_uri'] = '';
        $GLOBALS['inside4']['main']['get_string'] = '';

        // Define in \Inside4\CommonCore\Database
        $GLOBALS['inside4']['db'] = '';

        // Define in \Inside4\CommonCore\Sessions
        $GLOBALS['inside4']['main']['session_data'] = '';

    }

}
