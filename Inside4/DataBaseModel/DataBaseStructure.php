<?php
namespace Inside4\DataBaseModel;

Class DataBaseStructure
{
    public function init() {

        $database_tables = Array();

        // TO DO
        $table = Array(
            'module' => 'Auth_System',
            'name' => 'auth_users',
            'sql_params' => 'ENGINE=MyISAM DEFAULT CHARSET=utf8',
            'columns' => Array(

                // Primary ID
                Array(
                'name' => 'id',
                'sql_params' => 'int(16) NOT NULL',
                'advanced_commands' => Array(
                    Array('alter_command' => 'ADD PRIMARY KEY (`id`)'),
                    Array('alter_command' => 'MODIFY `id` int(16) NOT NULL AUTO_INCREMENT'),
                    ),
                ),
                // Email
                Array(
                    'name' => 'email',
                    'sql_params' => 'varchar(128) NOT NULL',
                    'advanced_commands' => Array(
                        Array('alter_command' => 'ADD KEY `email` (`email`)'),
                    ),
                ),

            ),
        );

        $database_tables[] = $table;

        return $database_tables;

    }
}