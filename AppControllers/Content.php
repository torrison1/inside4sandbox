<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Content extends BaseController {

    public function contacts(){

        // Page
        $this->view->render($this->data,'Content/contacts', 'app_default_template');
    }

}