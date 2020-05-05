<?php

namespace Inside4\Content;

Class Info_system
{
    var $db;

    public function pages_list($page = '1', $per_page = 1, $user_owner_id = false, $filter_type = false, $filter_data = false)
    {

        if ($page == 'all') $limit = "LIMIT 999";
        else $limit = "LIMIT ".( (intval($page) - 1)*$per_page).",$per_page";

        $where = '';
        if(isset($_GET['nameAlias']) && $_GET['nameAlias'])
            $where =  " AND (content_name LIKE LOWER(" . $this->db->quote('%' . $_GET['nameAlias'] . '%') . ") OR content_alias LIKE LOWER(" . $this->db->quote('%' . $_GET['nameAlias'] . '%') . "))";

        if ($user_owner_id)
            $user_owner_filter_where = "AND content_user_id = ".intval($user_owner_id);
        else $user_owner_filter_where = "";

        $filter_join = '';
        $filter_where = '';
        if ($filter_type) {
            if ($filter_type == 'tag') {
                $filter_join = '
					LEFT JOIN it_rel_content_tags ON it_rel_content_tags.content_id = it_content.content_id
					LEFT JOIN it_tags ON it_tags.tags_id = it_rel_content_tags.tags_id
				';
                $filter_where = "AND it_tags.tags_name = ".$this->db->quote($filter_data)."";
            }
            elseif ($filter_type == 'cat') {
                $filter_join = '
					LEFT JOIN it_rel_content_categories ON it_rel_content_categories.content_id = it_content.content_id
					LEFT JOIN it_categories ON it_categories.categories_id = it_rel_content_categories.category_id
				';
                $filter_where = "
					AND it_categories.categories_alias = ".$this->db->quote($filter_data)."
				";
            }
        }

        if ($GLOBALS['Commons']['lang'] == 'en')
        {
            $res = $this->db->sql_get_data("SELECT *
										FROM it_content
										{$filter_join}
										WHERE content_invisible != 1 AND content_type = 1 {$user_owner_filter_where}
										{$filter_where}
										{$where}
										ORDER BY content_priority ASC, it_content.content_id DESC
										{$limit}
										");

            return $res;
        }
        else
        {
            $res = $this->db->sql_get_data("SELECT

										it_content_translate.content_name as content_name_translate,
										it_content_translate.content_desc as content_desc_translate,

										it_content.*

										FROM it_content

										LEFT JOIN it_content_translate ON it_content.content_id = it_content_translate.content_id

										AND it_content_translate.content_lang_alias = ".$this->db->quote($GLOBALS['Commons']['lang'])."
										{$filter_join}
										WHERE
										it_content.content_invisible != 1 AND content_type = 1 {$user_owner_filter_where}
										{$filter_where}
										{$where}
										ORDER BY it_content.content_priority ASC, it_content.content_id DESC
										{$limit}
										");
            // $this->output->enable_profiler(TRUE);
            $res_new = Array();



            foreach ($res as $row)
            {
                if ($row['content_name_translate'] != '') $row['content_name'] = $row['content_name_translate'];
                if ($row['content_desc_translate'] != '') $row['content_desc'] = $row['content_desc_translate'];

                // if ($row['categories_invisible_translate'] != '1')
                $res_new[] = $row;
            }
            return $res_new;
        }
    }

    public function pages_count()
    {
        $res = $this->db->sql_get_data("SELECT count(*) as pages_count
									FROM it_content 
									WHERE content_invisible != 1  AND content_type = 1
									");

        return $res[0]['pages_count'];
    }

    public function get_page_row($id)
    {
        if ($GLOBALS['Commons']['lang'] == 'en')
        {
            $res = $this->db->sql_get_data("SELECT *
							FROM it_content 
							WHERE content_id = ".intval($id)." 
							LIMIT 1");

            if (isset($res[0])) return $res[0];
            else return false;
        }
        else
        {
            $res = $this->db->sql_get_data("SELECT 
										
										it_content_translate.content_name as content_name_translate,
										it_content_translate.content_desc as content_desc_translate,
										
										it_content.* 
										
										FROM it_content
										
										LEFT JOIN it_content_translate ON it_content.content_id = it_content_translate.content_id 
										
										AND it_content_translate.content_lang_alias = ".$this->db->quote($GLOBALS['Commons']['lang'])."
										
										WHERE
										it_content.content_id = ".intval($id)." 

										LIMIT 1
										");

            if (isset($res[0]))
            {
                $row = $res[0];
                if ($row['content_name_translate'] != '') $row['content_name'] = $row['content_name_translate'];
                if ($row['content_desc_translate'] != '') $row['content_desc'] = $row['content_desc_translate'];

                return $row;
            }
            else return false;


        }
    }

    public function get_page_row_by_alias($alias)
    {
        if ($GLOBALS['Commons']['lang'] == 'en')
        {
            $res = $this->db->sql_get_data("SELECT *
							FROM it_content 
							WHERE content_alias = ".$this->db->quote($alias)." 
							LIMIT 1");

            if (isset($res[0])) return $res[0];
            else return false;
        }
        else
        {
            $res = $this->db->sql_get_data("SELECT 
										
										it_content_translate.content_name as content_name_translate,
										it_content_translate.content_desc as content_desc_translate,
										
										it_content.* 
										
										FROM it_content
										
										LEFT JOIN it_content_translate ON it_content.content_id = it_content_translate.content_id 
										
										AND it_content_translate.content_lang_alias = ".$this->db->quote($GLOBALS['Commons']['lang'])."
										
										WHERE
										it_content.content_alias = ".$this->db->quote($alias)." 

										LIMIT 1
										");

            if (isset($res[0]))
            {
                $row = $res[0];
                if ($row['content_name_translate'] != '') $row['content_name'] = $row['content_name_translate'];
                if ($row['content_desc_translate'] != '') $row['content_desc'] = $row['content_desc_translate'];

                return $row;
            }
            else return false;


        }
    }



    public function get_tags_list()
    {
        $res = $this->db->sql_get_data("SELECT * 
									FROM it_tags 									
									ORDER BY tags_name ASC
									LIMIT 100
									");

        return $res;
    }

    public function get_content_tags_arr()
    {
        $res = $this->db->sql_get_data("SELECT  it_rel_content_tags.*, it_tags.tags_name as name
									FROM it_rel_content_tags 	
									LEFT JOIN it_tags ON it_tags.tags_id = it_rel_content_tags.tags_id									
									");

        return $res;
    }

    public function get_content_categories_arr()
    {
        $res = $this->db->sql_get_data("SELECT  it_rel_content_categories.*, it_categories.categories_name as name, it_categories.categories_alias as alias
									FROM it_rel_content_categories 	
									LEFT JOIN it_categories ON it_categories.categories_id = it_rel_content_categories.category_id									
									");

        return $res;
    }

    public function get_tree_categories_arr()
    {
        return $this->get_all_categories_arr(false);
    }

    public function get_all_categories_arr($only_top = true, $pid = false)
    {
        if ($only_top) $only_top_filter = ' AND categories_pid = 0';
        else {
            if ($pid) $only_top_filter = ' AND categories_pid = '.intval($pid);
            else $only_top_filter = '';
        }

        if ($GLOBALS['Commons']['lang'] == 'en')
        {
            $res = $this->db->sql_get_data("SELECT * 
									FROM it_categories 
									WHERE categories_invisible != 1 {$only_top_filter}
									ORDER BY categories_priority ASC, categories_id DESC
									");

            return $res;
        }
        else
        {
            $res = $this->db->sql_get_data("SELECT 
										
										it_categories_translate.categories_name as categories_name_translate,
										it_categories_translate.categories_img as categories_img_translate,
										it_categories_translate.categories_desc as categories_desc_translate,
										
										it_categories.* 
										
										FROM it_categories
										
										LEFT JOIN it_categories_translate ON it_categories.categories_id = it_categories_translate.categories_id 
										
										AND it_categories_translate.categories_lang_alias = ".$this->db->quote($GLOBALS['Commons']['lang'])."
										
										WHERE
										it_categories.categories_invisible != 1 {$only_top_filter}

										ORDER BY it_categories.categories_priority ASC, it_categories.categories_id DESC
										");

            $res_new = Array();



            foreach ($res as $row)
            {
                if ($row['categories_name_translate'] != '') $row['categories_name'] = $row['categories_name_translate'];
                if ($row['categories_img_translate'] != '') $row['categories_img'] = $row['categories_img_translate'];
                if ($row['categories_desc_translate'] != '') $row['categories_desc'] = $row['categories_desc_translate'];

                // if ($row['categories_invisible_translate'] != '1')
                $res_new[] = $row;
            }
            return $res_new;
        }
    }

    /*---------------------------------------------------------------------
                                              Advanced
    -----------------------------------------------------------------------*/

    public function ajaxPostShowListSearch($query)
    {
        $sql = "
                      SELECT content_name, content_alias
                      FROM it_content
                      WHERE
                      content_name LIKE LOWER(" . $this->db->quote('%' . $query . '%') . ")
                      OR
                      content_alias LIKE LOWER(" . $this->db->quote('%' . $query . '%') . ")
                        ";

        return $this->db->sql_get_data($sql);
    }

    public function similar_pages_list($page_id)
    {

    }
}
