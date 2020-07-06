<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Info_API extends BaseController
{
    //i--- Per Page in Controller Code  ; inside_content_pages ; torrison ; 01.10.2018 ; 2 ---/
    protected $per_page = 3;

    public function feed()
    {

        // ==========================  Test form  ==========================
        if (isset($_GET['test_form'])) {

            $params = [
                'data' => [
                    'page' => array('type'=>'text', 'value'=> '')
                ],
            ];
            $api_test_form = new \Inside4\APITools\APITestForms;
            $api_test_form->demo_form_api_test(__FUNCTION__, __CLASS__,  'get', $params);
        }
        // https://inside4sandbox.ikiev.biz/Info_API/feed?test_form=1

        if (!isset($_GET['page'])) $_GET['page'] = 1;

        $page = intval($_GET['page']);
        $info_system = new \Inside4\Content\Info_system;
        $info_system->db =& $this->db;

        //i--- Special arrays for work with content categories and tags ; inside_content_pages ; torrison ; 01.10.2018 ; 7 ---/
        // $this->data['tags_arr'] = $info_system->get_tags_list();
        // $this->data['content_tags_arr'] = $info_system->get_content_tags_arr();
        // $this->data['content_categories_arr'] = $info_system->get_content_categories_arr();
        // $this->data['pagination'] = $this->create_pagination($info_system->pages_count());


        $result['pages_list'] = $info_system->pages_list($page, $this->per_page);
        $result['status'] = "success";
        $this->response->echo_json($result);


    }
}