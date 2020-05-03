<?php

namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Main extends BaseController {

    //i--- Main Pages Methods ; inside_main_pages ; torrison ; 01.05.2020 ; 1 ---/
    public function index(){

        $this->view->render($this->data,'index', 'app_default_template');

    }

    public function privacy(){
        $this->view->render($this->data,'Static/privacy', 'app_default_template');
    }
}
