<?php

namespace Inside4\InsideAutoTables\Tables;

Class Inside_modules
{
    var $table_config;
    var $table_columns;
    var $db_table_name = 'inside_modules';

    public function init()
    {


        $i = 0;
        $table_columns[$i]['name'] = 'id';
        $table_columns[$i]['text'] = 'ID';
        $table_columns[$i]['column_width'] = '100';
        $table_columns[$i]['in_crud'] = true;


        $i++;
        $table_columns[$i]['name'] = 'main_type';
        $table_columns[$i]['text'] = 'Main Type';
        $table_columns[$i]['tab'] = 'main';
        $variants = array();
        $j = 0;
        $variants[$j]['id'] = strval($j);$variants[$j]['name']="Not Selected";$j++;
        $variants[$j]['id'] = strval($j);$variants[$j]['name']="Core";$j++;
        $variants[$j]['id'] = strval($j);$variants[$j]['name']="System";$j++;
        $variants[$j]['id'] = strval($j);$variants[$j]['name']="User Cases";$j++;
        $variants[$j]['id'] = strval($j);$variants[$j]['name']="Admin Cases";$j++;
        $variants[$j]['id'] = strval($j);$variants[$j]['name']="Manager Cases";$j++;
        $variants[$j]['id'] = strval($j);$variants[$j]['name']="Automatization";$j++;
        $variants[$j]['id'] = strval($j);$variants[$j]['name']="Usability";$j++;
        $variants[$j]['id'] = strval($j);$variants[$j]['name']="Advanced";$j++;
        $table_columns[$i]['variants'] = $variants;
        $table_columns[$i]['input_type'] = 'select';
        $table_columns[$i]['in_crud'] = true;
        $table_columns[$i]['crud_edit'] = true;

        $i++;
        $table_columns[$i]['name'] = 'public_id';
        $table_columns[$i]['text'] = 'Public ID';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'system_name';
        $table_columns[$i]['text'] = 'System Name [a-z0-9_-]';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'icon_class';
        $table_columns[$i]['text'] = 'Icon Class (CSS)';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'name';
        $table_columns[$i]['text'] = 'Name';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;


        $i++;
        $table_columns[$i]['name'] = 'description';
        $table_columns[$i]['text'] = 'Description';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'textarea';
        $table_columns[$i]['defend_filter'] = "A";
        /*
        $i++;
        $table_columns[$i]['name'] = 'img';
        $table_columns[$i]['text'] = 'Image (Resize to 600x400)';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'image';
        $table_columns[$i]['folder'] = 'inside_modules_img';
        $table_columns[$i]['in_crud'] = true;

        $table_columns[$i]['resize'] = true;
        $table_columns[$i]['crop_center'] = true;
        $table_columns[$i]['new_width'] = 600;
        $table_columns[$i]['new_height'] = 400;
         */

        $i++;
        $table_columns[$i]['name'] = 'owner';
        $table_columns[$i]['text'] = 'Owner';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;
        $table_columns[$i]['crud_edit'] = true;


        $i++;
        $table_columns[$i]['name'] = 'type';
        $table_columns[$i]['text'] = 'Type (Back-End, Front-End, ...)';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;
        $table_columns[$i]['crud_edit'] = true;

        $i++;
        $table_columns[$i]['name'] = 'issues';
        $table_columns[$i]['text'] = 'Issues';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;
        $table_columns[$i]['crud_edit'] = true;

        $i++;
        $table_columns[$i] = Array(
            'name' => 'off',
            'text' => 'Hide',
            'tab' => 'main',
            'input_type' => 'select-checkbox',
            'in_crud' => true,
            'filter' => true,
            'default_filter_value' => '',
        );

        $i++;
        $table_columns[$i] = Array(
            'name' => 'priority',
            'text' => 'priority',
            'tab' => 'main',
            'input_type' => 'text',
            'in_crud' => true,
            'crud_edit' => true,

        );


        $i++;
        $table_columns[$i]['name'] = 'files_json';
        $table_columns[$i]['text'] = 'Files JSON';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'mjson_multiple';
        $table_columns[$i]['config_array'] = Array(
            Array(
                'name' => 'name',
                'text' => 'Название',
                'type' => 'text',
            ),
            Array(
                'name' => 'filename',
                'text' => 'Имя файла',
                'type' => 'text',
            ),
            Array(
                'name' => 'path',
                'text' => 'Путь файла',
                'type' => 'text',
            ),
            Array(
                'name' => 'type',
                'text' => 'Тип',
                'type' => 'text',
            ),
        );
        $table_columns[$i]['defend_filter'] = "A";

        $i++;
        $table_columns[$i]['name'] = 'system_elements_json';
        $table_columns[$i]['text'] = 'System Elements JSON';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'mjson_multiple';
        $table_columns[$i]['config_array'] = Array(
            Array(
                'name' => 'name',
                'text' => 'Название',
                'type' => 'text',
            ),
            Array(
                'name' => 'link',
                'text' => 'Ссылка',
                'type' => 'text',
            ),
        );
        $table_columns[$i]['defend_filter'] = "A";

        /*

        $i++;
        $table_columns[$i]['name'] = 'data_json';
        $table_columns[$i]['text'] = 'Data JSON';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'textarea';
        $table_columns[$i]['in_crud'] = true;

        */

        // HTML for User Case

        // User case link

        $table_config['key'] = 'id';


        $table_config['cell_tabs_arr'] = Array (
            'main' => 'Main',
        );

        // Relations Inputs

        // System Elements

        // Files

        $this->table_config = $table_config;
        $this->table_columns = $table_columns;
    }
}