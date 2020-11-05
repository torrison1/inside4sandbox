<?php

namespace Inside4\InsideAutoTables\Tables;

Class It_categories_translate
{
    var $table_config;
    var $table_columns;
    var $db_table_name = 'it_categories_translate';

    public function init()
    {

        $i = 0;
        $table_columns[$i]['name'] = 'categories_id';
        $table_columns[$i]['text'] = 'ID';
        $table_columns[$i]['column_width'] = '100';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;
        $i++;
        $table_columns[$i]['name'] = 'categories_name';
        $table_columns[$i]['text'] = 'Сategory Title';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'categories_lang_alias';
        $table_columns[$i]['text'] = 'Translate Language';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';

        $table_config['key'] = 'categories_id';

        // System names: access = Access System, Chat = Chat communication
        $table_config['cell_tabs_arr'] = Array (
            'main' => 'Main'
        );

        $this->table_config = $table_config;
        $this->table_columns = $table_columns;
    }
}
