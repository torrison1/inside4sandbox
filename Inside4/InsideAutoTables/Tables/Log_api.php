<?php

namespace Inside4\InsideAutoTables\Tables;

Class Log_api
{
    var $table_config;
    var $table_columns;
    var $db_table_name = 'log_api';

    public function init()
    {

        $i = 0;
        $table_columns[$i]['name'] = 'id';
        $table_columns[$i]['text'] = 'ID';
        $table_columns[$i]['column_width'] = '100';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'time';
        $table_columns[$i]['text'] = 'Time';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'unix_time';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'data';
        $table_columns[$i]['text'] = 'Data';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'textarea';
        $table_columns[$i]['defend_filter'] = 7;

        $table_config['key'] = 'id';

        $table_config['cell_tabs_arr'] = Array (
            'main' => 'Main'
        );

        $this->table_config = $table_config;
        $this->table_columns = $table_columns;
    }
}
