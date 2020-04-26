<?php

namespace Inside4\InsideTools;

Class InsideProjectFiles {

    var $i=0;
    var $db;

    public function view() {

        $path = str_replace('Inside4/InsideTools/InsideProjectFiles.php','', __FILE__);
        echo $path;

        echo "<ul>".$this->read_dir_content($path)."</ul>";
    }

    private function read_dir_content($parent_dir, $depth = 0){
        $str_result = "";

        $str_result .= "<li>". dirname($parent_dir) ."</li>";
        $str_result .= "<ul>";
        if ($handle = opendir($parent_dir))
        {
            while (false !== ($file = readdir($handle)))
            {
                if(in_array($file, array('.', '..'))) continue;
                if( is_dir($parent_dir . "/" . $file) ){
                    $str_result .= "<li>" . $this->read_dir_content($parent_dir . "/" . $file, $depth++) . "</li>";

                }
                $str_result .= "<li> [".$this->i."] {$file}</li>";
                $this->i++;
            }
            closedir($handle);
        }
        $str_result .= "</ul>";


        return $str_result;
    }

}