<?php
namespace Inside4\Filesworks;

class Files {

    public function file_upload($filetmp, $filename, $path)
    {
        if ($filetmp != "") {

            $new_file_name = $this->is_exists_file($filename, $path);

            echo $GLOBALS['inside4']['DIR'] . $path . $new_file_name;

            $file_type = substr($new_file_name, -4);

            if (! (
                $file_type == '.png' OR
                $file_type == '.jpg' OR
                $file_type == '.svg' OR
                $file_type == '.gif' OR
                $file_type == '.PNG' OR
                $file_type == '.JPG' OR
                $file_type == '.pdf'
            )) exit ('Bad file type!');

            move_uploaded_file($filetmp, $GLOBALS['inside4']['DIR'] . $path . $new_file_name);

            if ($this->is_exists_file($new_file_name, $path)) return $new_file_name;
            else {
                rename($_SERVER["DOCUMENT_ROOT"] . $path . $new_file_name, $GLOBALS['inside4']['DIR'] . $path . "error_file");
                return "error_file";
            }
        }
    }

    public function file_delete($path_file)
    {
        unlink($GLOBALS['inside4']['DIR'] . $path_file);
    }

    //Check file if exists and give new name if it is copy.
    public function is_exists_file($filename, $path)
    {
        $i = 0;
        $new_file_name = $filename;
        $unique_name_find = false;
        while ($unique_name_find != true) {
            if (file_exists($GLOBALS['inside4']['DIR'] . $path . $new_file_name)) {
                $new_file_name = "copy" . $i . "_" . $filename;
            } else {
                $unique_name_find = true;
            }
            $i++;
        }
        return $new_file_name;
    }

}
