<?php

namespace Inside4\InsideAutoTables\Tables;

Class Auth_users
{
    var $table_config;
    var $table_columns;
    var $db_table_name = 'auth_users';
    var $interface_name = 'Users Management';

    public function init()
    {

        $i = 0;
        $table_columns[$i]['name'] = 'id';
        $table_columns[$i]['text'] = 'ID';
        $table_columns[$i]['column_width'] = '100';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'username';
        $table_columns[$i]['text'] = 'User Name';
        $table_columns[$i]['column_width'] = '120';
        $table_columns[$i]['tab'] = 'personal';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'email';
        $table_columns[$i]['text'] = 'E-mail';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'is_verified_email';
        $table_columns[$i]['text'] = 'is_verified_email';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        /*

        $i++;
        $table_columns[$i]['name'] = 'salt';
        $table_columns[$i]['text'] = 'Salt';
        $table_columns[$i]['tab'] = 'system';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['help'] = 'String for encoding data';

        $i++;
        $table_columns[$i]['name'] = 'activation_code';
        $table_columns[$i]['text'] = 'Activation code';
        $table_columns[$i]['tab'] = 'system';
        $table_columns[$i]['input_type'] = 'text';
        $i++;
        $table_columns[$i]['name'] = 'remember_code';
        $table_columns[$i]['text'] = 'Password remember code';
        $table_columns[$i]['tab'] = 'system';
        $table_columns[$i]['input_type'] = 'text';

        $i++;
        $table_columns[$i]['name'] = 'created_on';
        $table_columns[$i]['text'] = 'Created Time';
        $table_columns[$i]['tab'] = 'system';
        $table_columns[$i]['input_type'] = 'unix_time';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'last_login';
        $table_columns[$i]['text'] = 'Last Login Time';
        $table_columns[$i]['tab'] = 'system';
        $table_columns[$i]['input_type'] = 'unix_time';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'active';
        $table_columns[$i]['text'] = 'Activity';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'select-checkbox';
        $table_columns[$i]['help'] = 'On-Off User';
        $table_columns[$i]['in_crud'] = true;
        $table_columns[$i]['filter'] = true;
        $table_columns[$i]['default_filter_value'] = "1";
        */

        $i++;
        $table_columns[$i]['name'] = 'phone';
        $table_columns[$i]['text'] = 'Phone Number';
        $table_columns[$i]['tab'] = 'personal';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'is_verified_phone';
        $table_columns[$i]['text'] = 'is_verified_phone';
        $table_columns[$i]['tab'] = 'personal';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'img';
        $table_columns[$i]['text'] = 'Image';
        $table_columns[$i]['tab'] = 'adv';
        $table_columns[$i]['folder'] = 'users_img';
        $table_columns[$i]['input_type'] = 'image';
        $table_columns[$i]['in_crud'] = true;


        $table_config['key'] = 'id';

// System names: access = Access System, Chat = Chat communication
        $table_config['cell_tabs_arr'] = Array (
            'main' => 'Main',
            'personal' => 'Personal',
            'adv' => 'Advanced',
            'system' => 'System',
            'groups' => 'Groups'
        );

        $i++;
        $adv_rel_inputs[$i]['name'] = 'rel_users_groups';
        $adv_rel_inputs[$i]['input_type'] = 'many2many';
        $adv_rel_inputs[$i]['text'] = 'User Groups';
        $adv_rel_inputs[$i]['help'] = 'Выберете группы, в которые входит данный пользователь';
        $adv_rel_inputs[$i]['table'] = 'auth_groups';
        $adv_rel_inputs[$i]['rel_table'] = 'auth_users_groups';
        $adv_rel_inputs[$i]['rel_key'] = 'user_id';
        $adv_rel_inputs[$i]['rel_join'] = 'group_id';
        $adv_rel_inputs[$i]['join_key'] = 'id';
        $adv_rel_inputs[$i]['join_name'] = 'description';
        $adv_rel_inputs[$i]['tab'] = 'groups';

        $this->table_config = $table_config;
        $this->table_columns = $table_columns;
        $this->adv_rel_inputs = $adv_rel_inputs;
    }
}