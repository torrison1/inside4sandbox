<?php

namespace Inside4\SEO;

Class SEO
{

    //i--- SEO texts for URLs ; inside_seo ; torrison ; 01.05.2020 ; 1 ---/
    var $seo_data = Array(
        Array(
            'page_url' => '/',
            'seo_title' => 'Inside 4 Sandbox',
            'seo_description' => 'Pure PHP 7.2 Framework with MVC Structure',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/ua/',
            'seo_title' => 'Inside 4 Сандбокс',
            'seo_description' => 'Чистий PHP 7.2 фреймворк з MVC структурою',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/ru/',
            'seo_title' => 'Inside 4 Песочница',
            'seo_description' => 'Чистый PHP 7.2 фреймворк с MVC структурой',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/auth/login',
            'seo_title' => 'Auth',
            'seo_description' => 'Auth System Login Page',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/ua/auth/login',
            'seo_title' => 'Аутентіфікація',
            'seo_description' => 'Сторінка входу',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/ru/auth/login',
            'seo_title' => 'Аутентификация',
            'seo_description' => 'Страница входа',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/auth/profile',
            'seo_title' => 'Profile',
            'seo_description' => 'Auth System Profile Page',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/ua/auth/profile',
            'seo_title' => 'Профіль',
            'seo_description' => 'Сторінка користувача',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/ru/auth/profile',
            'seo_title' => 'Профиль',
            'seo_description' => 'Страница пользователя',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/content/contacts',
            'seo_title' => 'Сontacts',
            'seo_description' => 'Auth System Сontacts',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/ua/content/contacts',
            'seo_title' => 'Зв\'язок ',
            'seo_description' => 'Сторінка користувача',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/ru/content/contacts',
            'seo_title' => 'Контакты',
            'seo_description' => 'Страница контактов',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/main/privacy',
            'seo_title' => 'Privacy Usage Agreement',
            'seo_description' => 'Privacy Usage Agreement',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/ua/main/privacy',
            'seo_title' => 'Privacy Usage Agreement',
            'seo_description' => 'Privacy Usage Agreement',
            'seo_keywords' => '',
        ),
        Array(
            'page_url' => '/ru/main/privacy',
            'seo_title' => 'Privacy Usage Agreement',
            'seo_description' => 'Privacy Usage Agreement',
            'seo_keywords' => '',
        ),
    );

    //i--- Add SEO data method ; inside_seo ; torrison ; 01.05.2020 ; 2 ---/
    public function add_page_seo_data() {

        $res = Array();
        $current_url = $GLOBALS['inside4']['translate']['uri_prefix'].$GLOBALS['inside4']['main']['clear_uri'];

        foreach ($this->seo_data as $row) {
            if ($row['page_url'] == $current_url) $res = $row;
        }

        if (!isset($res['seo_title'])) $res['seo_title'] = $current_url;
        if (!isset($res['seo_description'])) $res['seo_description'] = $current_url;
        if (!isset($res['seo_keywords'])) $res['seo_keywords'] = $current_url;

        return $res;

    }
}
