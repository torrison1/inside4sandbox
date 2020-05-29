<?php

$GLOBALS['inside4_main_config'] = Array(

    //i--- Database connection config ; inside_core ; torrison ; 01.05.2020 ; 1 ---/
    'Database' => Array (
        'db_host' => '',
        'db_database' => '',
        'db_user' => '',
        'db_password' => '',
    ),
    //i--- Random constants and keys for security reasons ; inside_security ; torrison ; 01.08.2018 ; 1 ---/
    'Security' => Array (
        'encryption_salt1' => '',
        'encryption_salt2' => '',
        'encryption_salt_length' => 8,
        'encryption_aes_key' => '',
        'encryption_iv_static' => '',
        'csrf_token_key' => '',
        'csrf_token_salt' => '',
    ),
    'Mailer' => Array (
        'from_email' => '',
        'from_name' => 'Inside Mailer',
        'mail_password' => '',
    ),
    //i--- Website Config Data ; inside_template ; torrison ; 01.05.2020 ; C1 ---/
    'Website' => Array (
        'sitename' => 'Inside 4 Sandbox',
        'base_url' => 'https://inside4sandbox.ikiev.biz',
        'fb_app_id' => '',
        'fb_app_secret' => '',
        'fb_app_login_redirect' => 'https://inside4sandbox.ikiev.biz/auth/facebook_redirect/',
        'fb_img_url' => '/Public/AppFront/img/sale1.jpg',
        'g_client_id' => '',
        'g_client_secret' => '',
        'g_redirect_uri' => 'https://inside4sandbox.ikiev.biz/auth/google_redirect/',
        'admin_email' => 'torrison1@gmail.com',
        'google_maps_key' => '',
        'google_maps_key2' => '',
    ),
    'Translate' => Array(
        'default_lang' => 'en',
    ),
    'Admin' => Array (
        'admin_panel_name' => 'Admin Panel',
    )
);