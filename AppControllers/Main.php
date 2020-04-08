<?php

namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Main extends BaseController {

    public function index(){

        $this->view->render($this->data,'index', 'app_default_template');

    }

    public function privacy(){
        $this->view->render($this->data,'Static/privacy', 'app_default_template');
    }
}
