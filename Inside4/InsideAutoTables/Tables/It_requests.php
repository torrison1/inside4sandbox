<?php

namespace Inside4\InsideAutoTables\Tables;

Class It_requests
{
    var $table_config;
    var $table_columns;
    var $db_table_name = 'it_requests';

    public function init()
    {

        $table_config['table_title'] = 'Заявки';

        $i = 0;
        $table_columns[$i]['name'] = 'requests_id';
        $table_columns[$i]['text'] = 'ID';
        $table_columns[$i]['column_width'] = '100';
        $table_columns[$i]['in_crud'] = true;


        $i++;
        $table_columns[$i]['name'] = 'requests_name';
        $table_columns[$i]['text'] = 'Name';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'requests_virtual_type';
        $table_columns[$i]['text'] = 'Virtual Type';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['in_crud'] = true;
        $table_columns[$i]['input_type'] = 'select_from_table';
        $table_columns[$i]['select_table'] = 'it_requests';
        $table_columns[$i]['select_index'] = 'requests_id';
        $table_columns[$i]['select_field'] = 'requests_name';
        $table_columns[$i]['select_sql'] = 'SELECT requests_id, requests_name FROM it_requests WHERE virtual1 = 1 ORDER BY requests_name ASC';
        $table_columns[$i]['filter'] = true;
        $table_columns[$i]['in_crud'] = true;
        $table_columns[$i]['filters_column'] = 2;

        $i++;
        $table_columns[$i]['name'] = 'virtual1';
        $table_columns[$i]['text'] = 'Virtual';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'select-checkbox';
        $table_columns[$i]['in_crud'] = true;
        $table_columns[$i]['filter'] = true;
        $table_columns[$i]['default_filter_value'] = 0;

        $i++;
        $table_columns[$i]['name'] = 'requests_user_contacts';
        $table_columns[$i]['text'] = 'User Name and Contacts';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'requests_datetime';
        $table_columns[$i]['text'] = 'Time';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'unix_time';
        $table_columns[$i]['help'] = 'Stored in Unixtime format';
        $table_columns[$i]['in_crud'] = true;


        $i++;
        $table_columns[$i]['name'] = 'requests_message';
        $table_columns[$i]['text'] = 'Message';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'textarea';
        $table_columns[$i]['help'] = '';

        $i++;
        $table_columns[$i]['name'] = 'requests_priority';
        $table_columns[$i]['text'] = 'Priority';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;
        $table_columns[$i]['crud_edit'] = true;

        $i++;
        $table_columns[$i]['name'] = 'requests_type';
        $table_columns[$i]['text'] = 'Type';
        $table_columns[$i]['tab'] = 'main';
        $variants = array();
        $variants[0]['id'] = '1';$variants[0]['name']="Undefined Request";
        $variants[1]['id'] = '2';$variants[1]['name']="PM + Dev";
        $variants[2]['id'] = '3';$variants[2]['name']="Only Dev";
        $variants[3]['id'] = '4';$variants[3]['name']="Outstaffing";
        $table_columns[$i]['variants'] = $variants;
        $table_columns[$i]['input_type'] = 'select';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'requests_result';
        $table_columns[$i]['text'] = 'Result';
        $table_columns[$i]['tab'] = 'main';
        $variants = array();
        $variants[0]['id'] = '1';$variants[0]['name']="New";
        $variants[1]['id'] = '2';$variants[1]['name']="In Communication";
        $variants[2]['id'] = '3';$variants[2]['name']="Answered";
        $variants[3]['id'] = '4';$variants[3]['name']="Canceled";
        $variants[4]['id'] = '5';$variants[4]['name']="Make an Order";
        $table_columns[$i]['variants'] = $variants;
        $table_columns[$i]['input_type'] = 'select';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'requests_url';
        $table_columns[$i]['text'] = 'URL';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'link';
        $table_columns[$i]['in_crud'] = true;

        $table_config['key'] = 'requests_id';

        // System names: access = Access System, Chat = Chat communication
        $table_config['cell_tabs_arr'] = Array (
            'main' => 'Main',
            'activities' => 'Активности'
        );
        $table_config['edit_controls_off'] = Array('activities');

        $adv_rel_inputs = Array(
            Array(
                'name' => 'requests_activities',
                'input_type' => 'table_activities',
                'text' => 'Message',
                'help' => 'Сообщение',
                'tab' => 'activities',
            ),
        );

        $this->table_config = $table_config;
        $this->table_columns = $table_columns;
    }
}
