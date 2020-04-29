<?php

namespace Inside4\InsideAutoTables\Tables;

Class It_content
{
    var $table_config;
    var $table_columns;
    var $db_table_name = 'it_content';

    public function init()
    {

        $table_config['table_title'] = 'Content';

        $i = 0;
        $table_columns[$i]['name'] = 'content_id';
        $table_columns[$i]['text'] = 'ID';
        $table_columns[$i]['column_width'] = '100';
        $table_columns[$i]['in_crud'] = true;
        $i++;
        $table_columns[$i]['name'] = 'content_name';
        $table_columns[$i]['text'] = 'Content Title';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;
        $translate_columns[] = $table_columns[$i];

        $i++;
        $table_columns[$i]['name'] = 'content_alias';
        $table_columns[$i]['text'] = 'URL Alias';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['help'] = 'For SEO URL (optional)';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'content_create_date';
        $table_columns[$i]['text'] = 'Create Date';
        $table_columns[$i]['tab'] = 'adv';
        $table_columns[$i]['input_type'] = 'date';
        $table_columns[$i]['in_crud'] = true;
        $i++;
        $table_columns[$i]['name'] = 'content_type';
        $table_columns[$i]['text'] = 'Type';
        $table_columns[$i]['tab'] = 'adv';
        $variants = array();
            $variants[0]['id'] = '1';$variants[0]['name']="Blog";
            $variants[1]['id'] = '2';$variants[1]['name']="Landing Page";
        $table_columns[$i]['variants'] = $variants;
        $table_columns[$i]['input_type'] = 'select';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'content_desc';
        $table_columns[$i]['text'] = 'Description';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'html';
        $table_columns[$i]['help'] = 'Short text, for preview.';
        $table_columns[$i]['defend_filter'] = 2;
        $translate_columns[] = $table_columns[$i];

        $i++;
        $table_columns[$i]['name'] = 'content_html';
        $table_columns[$i]['text'] = 'HTML';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'html';
        $table_columns[$i]['defend_filter'] = "A";
        $translate_columns[] = $table_columns[$i];

        $i++;
        $table_columns[$i]['name'] = 'content_img';
        $table_columns[$i]['text'] = 'Image (Resize to 600x400)';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'image_mod';
        $table_columns[$i]['folder'] = 'content_img';
        $table_columns[$i]['in_crud'] = true;

        $table_columns[$i]['resize'] = true;
        $table_columns[$i]['crop_center'] = true;
        $table_columns[$i]['new_width'] = 600;
        $table_columns[$i]['new_height'] = 400;


        $i++;
        $table_columns[$i]['name'] = 'content_gallery';
        $table_columns[$i]['text'] = 'Gallery';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'm_images_sortable';
        $table_columns[$i]['folder'] = 'content_img';

        $i++;
        $table_columns[$i]['name'] = 'content_img_youtube';
        $table_columns[$i]['text'] = 'YouTube Image (Resize to 700x500)';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'image';
        $table_columns[$i]['folder'] = 'content_img';

        $table_columns[$i]['resize'] = true;
        $table_columns[$i]['crop_center'] = true;
        $table_columns[$i]['new_width'] = 700;
        $table_columns[$i]['new_height'] = 500;

        $i++;
        $table_columns[$i]['name'] = 'content_youtube_link';
        $table_columns[$i]['text'] = 'YouTube Link';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'link';

        $i++;
        $table_columns[$i]['name'] = 'content_priority';
        $table_columns[$i]['text'] = 'Priority';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;
        $table_columns[$i]['crud_edit'] = true;


        $i++;
        $table_columns[$i]['name'] = 'content_invisible';
        $table_columns[$i]['text'] = 'Invisible';
        $table_columns[$i]['tab'] = 'main';
        $table_columns[$i]['input_type'] = 'select-checkbox';
        $table_columns[$i]['in_crud'] = true;


        $i++;
        $table_columns[$i]['name'] = 'content_seo_title';
        $table_columns[$i]['text'] = 'SEO Title';
        $table_columns[$i]['tab'] = 'adv';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;
        $i++;
        $table_columns[$i]['name'] = 'content_seo_description';
        $table_columns[$i]['text'] = 'SEO Description';
        $table_columns[$i]['tab'] = 'adv';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;
        $i++;
        $table_columns[$i]['name'] = 'content_seo_keywords';
        $table_columns[$i]['text'] = 'SEO KeyWords';
        $table_columns[$i]['tab'] = 'adv';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;

        $i++;
        $table_columns[$i]['name'] = 'content_user_id';
        $table_columns[$i]['text'] = 'User Author ID';
        $table_columns[$i]['tab'] = 'adv';
        $table_columns[$i]['input_type'] = 'text';
        $table_columns[$i]['in_crud'] = true;



        $table_config['key'] = 'content_id';

        // System names: access = Access System, Chat = Chat communication
        $table_config['cell_tabs_arr'] = Array (
            'main' => 'Main',
            'adv' => 'Advanced',
            'translate' => 'Translate',
            'activities' => 'Активности',
        );

        $table_config['edit_controls_off'] = array(
            'activities'
        );

        $i=0;
        $adv_rel_inputs[$i]['name'] = 'rel_content_categories';
        $adv_rel_inputs[$i]['input_type'] = 'many2many';
        $adv_rel_inputs[$i]['text'] = 'Categories';
        $adv_rel_inputs[$i]['help'] = '';
        $adv_rel_inputs[$i]['table'] = 'it_categories';
        $adv_rel_inputs[$i]['rel_table'] = 'it_rel_content_categories';
        $adv_rel_inputs[$i]['this_key'] = 'content_id';
        $adv_rel_inputs[$i]['rel_key'] = 'content_id';
        $adv_rel_inputs[$i]['rel_join'] = 'category_id';
        $adv_rel_inputs[$i]['join_key'] = 'categories_id';
        $adv_rel_inputs[$i]['join_name'] = 'categories_name';
        $adv_rel_inputs[$i]['tab'] = 'adv';
        $i++;
        $adv_rel_inputs[$i]['name'] = 'rel_content_tags';
        $adv_rel_inputs[$i]['input_type'] = 'many2many';
        $adv_rel_inputs[$i]['text'] = 'Tags';
        $adv_rel_inputs[$i]['help'] = '';
        $adv_rel_inputs[$i]['table'] = 'it_tags';
        $adv_rel_inputs[$i]['rel_table'] = 'it_rel_content_tags';
        $adv_rel_inputs[$i]['this_key'] = 'content_id';
        $adv_rel_inputs[$i]['rel_key'] = 'content_id';
        $adv_rel_inputs[$i]['rel_join'] = 'tags_id';
        $adv_rel_inputs[$i]['join_key'] = 'tags_id';
        $adv_rel_inputs[$i]['join_name'] = 'tags_name';
        $adv_rel_inputs[$i]['tab'] = 'adv';

        $i++;
        $adv_rel_inputs[$i]['name'] = 'content_translate';
        $adv_rel_inputs[$i]['input_type'] = 'translate_form';
        $adv_rel_inputs[$i]['text'] = 'Translate';
        $adv_rel_inputs[$i]['help'] = '';
        $adv_rel_inputs[$i]['table'] = 'it_content_translate';
        $adv_rel_inputs[$i]['id_column'] = 'content_id';
        $adv_rel_inputs[$i]['lang_alias_column'] = 'content_lang_alias';
        $adv_rel_inputs[$i]['columns'] = $translate_columns;
        $adv_rel_inputs[$i]['tab'] = 'translate';

        /*
        $i++;
        $adv_rel_inputs[$i]['name'] = 'content_activities';
        $adv_rel_inputs[$i]['input_type'] = 'table_activities';
        $adv_rel_inputs[$i]['text'] = 'Message';
        $adv_rel_inputs[$i]['help'] = 'Сообщение';
        $adv_rel_inputs[$i]['tab'] = 'activities';
        */

        $this->table_config = $table_config;
        $this->table_columns = $table_columns;
        $this->adv_rel_inputs = $adv_rel_inputs;

    }
}

