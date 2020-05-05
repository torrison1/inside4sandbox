<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Info extends BaseController
{
    //i--- Per Page in Controller Code  ; inside_content_pages ; torrison ; 01.10.2018 ; 2 ---/
    protected $per_page = 5;

    public function feed($page = false) {

        //i--- Redirect for page = 1 ; inside_content_pages ; torrison ; 01.10.2018 ; 4 ---/
        if ($page == 1) redirect ('/info/feed/', 301);
        if (!$page) $page = 1;

        $info_system = new \Inside4\Content\Info_system;
        $info_system->db =& $this->db;

        //i--- Catalog Tree ; inside_content_pages ; torrison ; 01.10.2018 ; 6 ---/
        // $this->data['catalog_tree'] = $this->inside_lib->make_tree_view($this->info_system->get_tree_categories_arr(), false, $this->data['lang_link_prefix']);
        $this->data['catalog_tree'] = '';

        //i--- Special arrays for work with content categories and tags ; inside_content_pages ; torrison ; 01.10.2018 ; 7 ---/
        $this->data['tags_arr'] = $info_system->get_tags_list();
        $this->data['content_tags_arr'] = $info_system->get_content_tags_arr();
        $this->data['content_categories_arr'] = $info_system->get_content_categories_arr();


        $this->data['pagination'] = $this->create_pagination($info_system->pages_count());

        $this->data['pages_list_arr'] = $info_system->pages_list($page, $this->per_page);

        //i--- Prepare View and SEO data ; inside_content_pages ; torrison ; 01.10.2018 ; 8 ---/
        // TO DO

        if (isset($_GET['html_blocks'])) {
            echo $this->view->render_to_var($this->data, 'Parts/blog_feed_demo.php', $template_folder = 'app_default_template');
        } else {
            $this->view->render($this->data,'Content/pages_list', 'app_default_template');
        }


    }

    //i--- Code Igniter Pagination Class used ; inside_content_pages ; torrison ; 01.10.2018 ; 5 ---/
    private function create_pagination($count) {

        return $count;

    }

    //i--- Show by Alias / Full Page View ; inside_content_pages ; torrison ; 01.10.2018 ; 11 ---/
    public function page($alias = '') {

        if ($alias !== '') $_GET['alias'] = $alias;

        $info_system = new \Inside4\Content\Info_system;
        $info_system->db =& $this->db;

        if (isset($_GET['alias'])) {
            $alias = $_GET['alias'];
            $page_row = $info_system->get_page_row_by_alias($alias);
        }
        else if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $page_row = $info_system->get_page_row($id);
        } else {
            echo "No ID or Alias";
            exit();
        }

        $this->data['content_tags_arr'] = $info_system->get_content_tags_arr();
        $this->data['content_categories_arr'] = $info_system->get_content_categories_arr();
        $this->data['page_row'] = $page_row;
        $this->data['username'] = $page_row['content_user_id'] ? $this->auth->user['username'] : '';

        $this->data['comments_arr'] = $this->db->sql_get_data("SELECT it_comments.*, auth_users.img as avatar, auth_users.email, auth_users.username FROM 
															it_comments 
															LEFT JOIN auth_users ON auth_users.id = it_comments.comments_user_id
															WHERE comments_invisible != 1 AND comments_source = 1 AND comments_source_id = ".intval($page_row['content_id'])."
															ORDER BY comments_datetime DESC
															");

        $this->data['seo_title'] = $this->data['page_row']['content_name'];
        $this->data['seo_description'] = $this->data['page_row']['content_name'];
        $this->data['seo_keywords'] = $this->data['page_row']['content_name'];

        if ($this->data['page_row']['content_seo_title'] != '') $this->data['seo_title'] = $this->data['page_row']['content_seo_title'];
        if ($this->data['page_row']['content_seo_description'] != '') $this->data['seo_description'] = $this->data['page_row']['content_seo_description'];
        if ($this->data['page_row']['content_seo_keywords'] != '') $this->data['seo_keywords'] = $this->data['page_row']['content_seo_keywords'];

        $this->view->render($this->data,'Content/page', 'app_default_template');
    }


    //i--- Add Comment Method ; inside_content_pages ; torrison ; 01.10.2018 ; 13 ; red ---/
    public function ajax_add_comment() {
        $insert_arr['comments_source'] = '1';
        $insert_arr['comments_source_id'] = $this->input->post_secure('page_id');
        $insert_arr['comments_text'] = $this->input->post_secure('comment');
        $insert_arr['comments_invisible'] = '1';
        $insert_arr['comments_user_id'] = $this->auth->user['id'];
        $insert_arr['comments_link'] = $this->input->post_secure('page_url');
        $insert_arr['comments_datetime'] = time() + (3600 * 3);
        $this->db->insert('it_comments', $insert_arr);
        echo '{"status":"success", "message": "<strong>Комментарий сохранен, он будет опубликован после модерации!</strong>"}';
        die();

        // New mailing functionality
        $this->load->library('mailer');

        $title = 'Новый комментарий: Страница - '.$insert_arr['comments_link'].', на Vizitka.iKiev.biz';
        $message = "<b>Text:</b> ".$insert_arr['comments_text']."<br /><br />
					<b>Time:</b> ".date("Y-m-d H:i:s").
            '<br /><br /><b>Ссылка: </b><a href="'.$insert_arr['comments_link'].'">'.$insert_arr['comments_link'].'</a>';

        $this->mailer->send_email($admin_email, $message, $title);
    }


// -------------------------------------------------------------------------------
    public function ajaxPostShowListSearch()
    {
        $query = $this->input->get('q');
        $res = $this->pages->ajaxPostShowListSearch($query);
        echo json_encode($res);
    }
}
