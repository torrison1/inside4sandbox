<?php

namespace Inside4\CommonCore;
use Inside4\CommonCore\Commons as Commons;
use Inside4\AuthSystem\AuthSystem as AuthSystem;
use Inside4\TextsTranslate\TextsTranslate as TextsTranslate;
use Inside4\Website\Website as Website;
use Inside4\SEO\SEO as SEO;
use Inside4\CommonCore\RenderView as RenderView;
use Inside4\Security\Security as Security;
use Inside4\CommonCore\Database as Database;
use Inside4\CommonCore\Sessions as Sessions;
use Inside4\CommonCore\Response as Response;
use Inside4\Mailing\Mailer as Mailer;


Class BaseController {

    var $t; // Short variable for Texts Translate
    var $auth;
    var $website;
    var $seo;
    var $data;
    var $view;
    var $security;
    var $db;
    var $sessions;
    var $mailer;
    var $response;
    var $commons;


    public function __construct(){

        $this->commons = new Commons();

        $this->website = new Website();
        $this->website->init();

        $this->mailer =  new Mailer();
        $this->mailer->init();

        $this->db = new Database();
        $this->db->init();

        $this->security = new Security();
        $this->security->init();
        $this->security->db =& $this->db;


        $this->sessions = new Sessions();
        $this->sessions->db =& $this->db;
        $this->sessions->security =& $this->security;
        $this->sessions->init();

        $this->view = new RenderView();

        $this->t = new TextsTranslate();
        $this->t->db =& $this->db;
        $this->t->init();

        $this->auth = new AuthSystem();
        $this->auth->db =& $this->db;
        $this->auth->security =& $this->security;
        $this->auth->sessions =& $this->sessions;
        $this->auth->view =& $this->view;
        $this->auth->mailer =& $this->mailer;
        $this->auth->website =& $this->website;
        $this->auth->init();

        $this->response = new Response();
        $this->response->sessions =& $this->sessions;



        // Common View Variables
        $this->data['lang_link_prefix'] =& $GLOBALS['inside4']['translate']['uri_prefix'];
        $this->data['inside4_website'] =& $this->website;
        $this->data['inside4_auth'] =& $this->auth;
        $this->data['inside4_security'] =& $this->security;
        $this->data['t'] =& $this->t;
        $this->data['user'] =& $this->auth->user;

        $this->seo = new SEO();
        $this->data = $this->data + $this->seo->add_page_seo_data();


    }

}