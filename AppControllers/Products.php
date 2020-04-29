<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Products extends BaseController
{

    var $entity_table = 'it_content';
    var $entity_table_id_column = 'content_id';

    public function all () {

        // ==========================  Test form  ==========================
        if (isset($_GET['test_form'])) {
            $params = [
                'data' => [
                    'category_id' => array('type'=>'text', 'value'=>''),
                    'tag_id' => array('type'=>'text', 'value'=>''),
                    'search_text' => array('type'=>'text', 'value'=>''),
                    'page' => array('type'=>'text', 'value'=>'1'),
                    'per_page' => array('type'=>'text', 'value'=>'3'),
                    'lang' => array('type'=>'text', 'value'=>'en'),
                    'json' => array('type'=>'text', 'value'=>'1'),
                ],
            ];
            $api_test_form = new \Inside4\APITools\APITestForms;
            $api_test_form->demo_form_api_test(__FUNCTION__, __CLASS__,  'post', $params);
        }
        // https://inside4sandbox.ikiev.biz/products/all?test_form=1

        $this->data['all_arr'] = $this->db->sql_get_data("SELECT {$this->entity_table}.*
															FROM {$this->entity_table} 
															ORDER BY {$this->entity_table_id_column} DESC
															");

        if (isset($_POST['json']) AND $_POST['json'] == 1) {

            $result['status'] = "success";
            $result['message'] = '';
            $result['data'] = $this->data['all_arr'];

            $this->response->echo_json($result);

        } else {
            // Other View
        }
    }

    public function id ($id = 0) {

        // ==========================  Test form  ==========================
        if (isset($_GET['test_form'])) {
            $params = [
                'data' => [
                    'id' => array('type'=>'text', 'value'=>'8'),
                    'lang' => array('type'=>'text', 'value'=>'en'),
                    'json' => array('type'=>'text', 'value'=>'1'),
                ],
            ];
            $api_test_form = new \Inside4\APITools\APITestForms;
            $api_test_form->demo_form_api_test(__FUNCTION__, __CLASS__,  'post', $params);
        }
        // https://inside4sandbox.ikiev.biz/products/id?test_form=1


        if (isset($_GET['id'])) $id = $_GET['id'];
        if (isset($_POST['id'])) $id = $_POST['id'];

        $res = $this->db->sql_get_data("SELECT {$this->entity_table}.*
															FROM {$this->entity_table} 
															WHERE {$this->entity_table_id_column} = ".intval($id)."
															");
        if (isset($res[0])) {
            $this->data['row'] = $res[0];
        } else {
            $this->data['row'] = false;
        }

        if (isset($_POST['json']) AND $_POST['json'] == 1) {

            $result['status'] = "success";
            $result['message'] = '';
            $result['data'] = $this->data['row'];

            $this->response->echo_json($result);

        } else {

            // Other View

        }
    }
}