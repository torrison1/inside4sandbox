<?php

namespace Inside4\CommonCore;

Class RenderView {

    //i--- Easy render php view by php tags and include function ; inside_core ; torrison ; 01.05.2020 ; 1 ---/
    public function render($data, $page_center, $template_folder = 'app_default_template') {

        // Convert array data to local variables
        foreach($data as $key => $value) ${$key} = $value;
        include "AppViews/".$template_folder."/main_template.php";
    }

    //i--- Render View file to the variable ; inside_core ; torrison ; 01.05.2020 ; 2 ---/
    public function render_to_var($data, $file_path, $template_folder = 'app_default_template') {

        // Convert array data to local variables
        foreach($data as $key => $value) ${$key} = $value;
        ob_start();
        include "AppViews/".$template_folder."/".$file_path;
        return ob_get_clean();
    }
}