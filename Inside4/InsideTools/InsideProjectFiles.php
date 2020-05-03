<?php

namespace Inside4\InsideTools;

Class InsideProjectFiles {

    var $i=0;
    var $db;


    var $vendor_folders = Array(
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/inside/js/ckeditor',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/inside/js/kcfinder',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/js/lightslider',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/js/lightGallery',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/js/jquery-ui-1.12.1',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/js/lightslider-master',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/js/bootstrap-3.3.7',

        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/inside/jquery_chosen',
        '/home/ikiev/ikiev.biz/inside4sandbox/Inside4/vendor/facebook',
        '/home/ikiev/ikiev.biz/inside4sandbox/Inside4/Mailing/PHPMailer',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/inside/css/jquery-ui-smoothness',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/inside/dropdown',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/inside/js/jquery_ui',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/inside/js/scrollTo',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/inside/js/autosize',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/inside/bootstrap',

        '/home/ikiev/ikiev.biz/inside4sandbox/Public/JQuery',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/Bootstrap',

        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/js/jquery-3.1.1',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/js/bootstrap-select-1.12.2',

        '/home/ikiev/ikiev.biz/inside4sandbox/Public/InsideAdmin/inside_admin_template/js/jquery.scrollbar',
        '/home/ikiev/ikiev.biz/inside4sandbox/MobileApp/app_core/inside_front/menu_basis/files/legitRipple',
        '/home/ikiev/ikiev.biz/inside4sandbox/MobileApp/app_core/inside_front/menu_basis/files/touch_ripple',
        '/home/ikiev/ikiev.biz/inside4sandbox/MobileApp/app_core/inside_front/menu_basis/files/touch_sideswipe',
        '/home/ikiev/ikiev.biz/inside4sandbox/MobileApp/app_core/inside_front/vendor/canvas',
        '/home/ikiev/ikiev.biz/inside4sandbox/Inside4/vendor/composer',

    );

    var $content_folders = Array(
        '/home/ikiev/ikiev.biz/inside4sandbox/MobileApp/app_core/img',
        '/home/ikiev/ikiev.biz/inside4sandbox/MobileApp/cordova/res/icon',
        '/home/ikiev/ikiev.biz/inside4sandbox/MobileApp/cordova/res/screen',
        '/home/ikiev/ikiev.biz/inside4sandbox/Uploads',
        '/home/ikiev/ikiev.biz/inside4sandbox/Manuals',
        '/home/ikiev/ikiev.biz/inside4sandbox/Public/AppFront/app_default_template/img',
    );
    public function view($to_var = true) {

        if ($to_var) ob_start();

        $path = str_replace('/Inside4/InsideTools/InsideProjectFiles.php','', __FILE__);

        echo "<h3>Project Folder : <a href=\"https://github.com/torrison1/inside4sandbox\" target=\"_blank\">".$path."</a></h3>";

        echo "<ul>".$this->read_dir_content($path)."</ul>";

        echo "<br><br> ------------------------------------------ <br><br>";
        echo "<h3>Vendors Folders</h3>";

        $i = 1;
        foreach($this->vendor_folders as $folder) {
            $folder_github_url = str_replace('/home/ikiev/ikiev.biz/inside4sandbox/', 'https://github.com/torrison1/inside4sandbox/tree/master/', $folder);
            $folder_name = str_replace('/home/ikiev/ikiev.biz/inside4sandbox/', '', $folder);
            echo "<b> [{$i}] $folder_name</b><br>";
            echo '<a href="'.$folder_github_url.'" target="_blank">'.$folder_github_url.'</a> <br>';
            echo "<br><br>";
            $i++;
        }

        echo "------------------------------------------ <br><br>";
        echo "<h3>Content Folders</h3>";

        $i = 1;
        foreach($this->content_folders as $folder) {
            $folder_github_url = str_replace('/home/ikiev/ikiev.biz/inside4sandbox/', 'https://github.com/torrison1/inside4sandbox/tree/master/', $folder);
            $folder_name = str_replace('/home/ikiev/ikiev.biz/inside4sandbox/', '', $folder);
            echo "<b> [{$i}] $folder_name</b><br>";
            echo '<a href="'.$folder_github_url.'" target="_blank">'.$folder_github_url.'</a> <br>';
            echo "<br><br>";
            $i++;
        }

        echo "<br><br>";

        if ($to_var) return ob_get_clean();

    }

    private function read_dir_content($parent_dir, $depth = 0){
        $str_result = "";

        $dir_view = str_replace('/home/ikiev/ikiev.biz/inside4sandbox/','',$parent_dir );
        $str_result .= "<li style='font-weight: bold;'>". ($dir_view) ."</li>";
        $str_result .= "<ul>";

        // $str_result .= ">> ".$parent_dir." <<";
        if ($handle = opendir($parent_dir))
        {
            while (false !== ($file = readdir($handle)))
            {
                if(in_array($file, array('.', '..'))) continue;
                // $str_result .= ">> ".$parent_dir . "/" . $file." <<";
                if(in_array($parent_dir . "/" . $file, $this->vendor_folders)) {
                    $folder = $parent_dir . "/" . $file;
                    $folder_name = str_replace('/home/ikiev/ikiev.biz/inside4sandbox/', '', $folder);
                    $str_result .= "<li> [Vendor Folder] <b> {$file} </b></li>";
                    continue;
                }
                if(in_array($parent_dir . "/" . $file, $this->content_folders)) {
                    $folder = $parent_dir . "/" . $file;
                    $folder_name = str_replace('/home/ikiev/ikiev.biz/inside4sandbox/', '', $folder);
                    $str_result .= "<li> [Content Folder] <b> {$file} </b></li>";
                    continue;
                }
                if( is_dir($parent_dir . "/" . $file) ){
                    $str_result .= "" . $this->read_dir_content($parent_dir . "/" . $file, $depth++) . "";
                } else {
                    $str_result .= "<li> [".$this->i."] {$file}</li>";
                }
                $this->i++;
            }
            closedir($handle);
        }
        $str_result .= "</ul>";


        return $str_result;
    }


    // >> TO DEL | OLD Method $this->ListFolder('.');
    function ListFolder($path)
    {
        //using the opendir function
        $dir_handle = @opendir($path) or die("Unable to open $path");

        //Leave only the lastest folder name
        $dirname = end(explode("/", $path));

        //display the target folder.
        echo ("<li>$dirname\n");
        echo "<ul>\n";
        while (false !== ($file = readdir($dir_handle)))
        {
            if($file!="." && $file!="..")
            {
                if (is_dir($path."/".$file))
                {
                    //Display a list of sub folders.
                    ListFolder($path."/".$file);
                }
                else
                {
                    //Display a list of files.
                    echo "<li>$file</li>";
                }
            }
        }
        echo "</ul>\n";
        echo "</li>\n";

        //closing the directory
        closedir($dir_handle);
    }

}