<?php

namespace Inside4\InsideAutoTables\Tables;

Class Demo_table
{
    var $table_config;
    var $table_columns;
    var $db_table_name = 'demo_table';

    public function init()
    {

        $i = 0;
        $table_columns[$i]['name'] = 'id';
        $table_columns[$i]['text'] = 'ID';
        $table_columns[$i]['column_width'] = '100';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'name';
        $table_columns[$i]['text'] = 'Name';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'description';
        $table_columns[$i]['text'] = 'description';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'textarea';

        $i++;
        $table_columns[$i]['name'] = 'image';
        $table_columns[$i]['text'] = 'image';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'image';
        $table_columns[$i]['folder'] = 'content_img';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'off';
        $table_columns[$i]['text'] = 'OFF';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'select-checkbox';
        $table_columns[$i]['in_crud'] = true;

        $table_config['key'] = 'id';

        // System names: access = Access System, Chat = Chat communication
        $table_config['cell_tabs_arr'] = Array (
            'main' => 'Main'
        );

        $this->table_config = $table_config;
        $this->table_columns = $table_columns;
    }
}
