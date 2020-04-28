<?php

namespace Inside4\CommonCore;

Class Input
{
    var $db;
    var $security;


    public function init()
    {


    }

    public function get_secure($val)
    {
        $res = $this->security->xss_cleaner($_GET[$val]);
        return $res;

    }

    public function post_secure($val)
    {
        $res = $this->security->xss_cleaner($_POST[$val]);
        return $res;
    }

    public function cookie_secure($val)
    {
        $res = $this->security->xss_cleaner($_COOKIE[$val]);
        return $res;
    }
    public function defend_filter($defendtype, $data)
    {

        if ($defendtype == "1") {   // For Guest
            $data = str_replace("&", "&amp;", $data);
            $data = str_replace("'", "&#8217;", $data);
            $data = str_replace("<", "&lt;", $data);
            $data = str_replace(">", "&gt;", $data);
            $data = str_replace("\"", "&quot;", $data);
            $data = str_replace(">", "&gt;", $data);
            //$data = mysql_escape_string($data);
            //$data = str_replace ("\\\"","&quot;",$data);
        }


        if ($defendtype == "2") {   // For Admin
            $data = str_replace("'", "&#8217;", $data);
            //$data = mysql_escape_string($data);
        }

        if ($defendtype == "3") {   // For Forms
            $data = str_replace("&", "", $data);
            $data = str_replace("<", "", $data);
            $data = str_replace(">", "", $data);
            $data = str_replace("\"", "", $data);
            $data = str_replace("'", "", $data);
        }

        if ($defendtype == "4") {   // For string, which works in filesystem functions
            $data = preg_replace("/[^a-z0-9_.]/i", "1", $data);
        }

        if ($defendtype == "5") {   // For integer
            $data = intval($data);
        }

        if ($defendtype == "6") {   // For Files
            $data = str_replace("<", "", $data);
            $data = str_replace(">", "", $data);
            $data = str_replace("\"", "", $data);
            $data = str_replace("\\", "", $data);
            $data = str_replace("/", "", $data);
            $data = str_replace("'", "", $data);

        }

        if ($defendtype == "7") {   // For Developers
            $data = str_replace("'", "''", $data);
        }

        if ($defendtype == "8") {   // For Guest Chat
            $data = str_replace("&", "&amp;", $data);
            $data = str_replace("'", "&#8217;", $data);
            $data = str_replace("<", "&lt;", $data);
            $data = str_replace(">", "&gt;", $data);
            $data = str_replace("\n", "<br />", $data);
            $data = mysql_escape_string($data);
        }

        if ($defendtype == "9") {   // For Integer
            $data = intval($data);
        }

        if ($defendtype == "A") {   // No Filter
            $data = $data;
        }


        return $data;
    }
}