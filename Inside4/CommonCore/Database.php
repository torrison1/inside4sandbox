<?php

namespace Inside4\CommonCore;

//i--- Database Class based on PDO Object ; inside_core ; torrison ; 01.05.2020 ; 1 ---/
use \PDO;

Class Database
{

    var $db_host;
    var $db_user;
    var $db_database;
    var $db_password;

    var $conn;

    function init() {

        $this->db_host = $GLOBALS['inside4_main_config']['Database']['db_host'];
        $this->db_database = $GLOBALS['inside4_main_config']['Database']['db_database'];
        $this->db_user = $GLOBALS['inside4_main_config']['Database']['db_user'];
        $this->db_password = $GLOBALS['inside4_main_config']['Database']['db_password'];

        $res = Array();

        try {
            $conn = new PDO("mysql:host=$this->db_host;dbname=".$this->db_database.";charset=UTF8;", $this->db_user, $this->db_password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query("SET NAMES utf8;");

            $res['message'] = "Connected successfully";
            $res['status'] = "success";
        }
        catch(PDOException $e)
        {
            $res['message'] = $e->getMessage();
            $res['status'] = "error";

            $conn = false;

            // For Debug
            print_r($e->getMessage());

        }

        $res['conn'] = $conn;
        $GLOBALS['inside4']['db'] = $conn;
        $this->conn = $conn;

        return $res;

    }

    //i--- $this->db->sql_get_data($sql) for SELECT Requests ; inside_core ; torrison ; 01.05.2020 ; 2 ---/
    function sql_get_data($query) {

        $sql = $this->conn->prepare($query);
        $sql->execute();
        $data = $sql->fetchAll();
        return($data);
    }

    //i--- $this->db->run_sql($sql) for Any Requests ; inside_core ; torrison ; 01.05.2020 ; 3 ---/
    function run_sql($query) {

        $sql = $this->conn->prepare($query);
        $res = $sql->execute();
        return $res;
    }

    //i--- $this->db->insert($table, $arr) for Insert Requests ; inside_core ; torrison ; 01.05.2020 ; 4 ---/
    function insert($table, $arr=array())
    {
        if (!is_array($arr) || !count($arr)) return false;

        $bind = ':'.implode(',:', array_keys($arr));
        $sql  = 'insert into '.$table.'('.implode(',', array_keys($arr)).') '.
            'values ('.$bind.')';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array_combine(explode(',',$bind), array_values($arr)));

        if ($stmt->rowCount() > 0)
        {
            return true;
        }

        return false;
    }

    //i--- $this->db->insert($table, $arr, $where) for Update Requests ; inside_core ; torrison ; 01.05.2020 ; 5 ---/
    function update($table, $arr=array(), $where)
    {
        $updates = array_filter($arr, function ($value) {
            return null !== $value;
        });
        $query = 'UPDATE '.$table.' SET';
        $values = array();

        foreach ($updates as $name => $value) {
            $query .= ' '.$name.' = :'.$name.','; // the :$name part is the placeholder, e.g. :zip
            $values[':'.$name] = $value; // save the placeholder
        }

        $query = substr($query, 0, -1); // remove last , and add a ;

        $query = $query." ".$where.";";

        // print_r($query); print_r($values);
        $sth = $this->conn->prepare($query);

        $sth->execute($values); // bind placeholder array to the query and execute everything

        return true;
    }

    //i--- $this->db->quote($data) for Defend string from SQL injection attack and quote string ; inside_core ; torrison ; 01.05.2020 ; 6 ---/
    function quote($data) {
        return $this->conn->quote($data);
    }

    //i--- $this->db->last_id() get ID after the last insert ; inside_core ; torrison ; 01.05.2020 ; 7 ---/
    function last_id() {
        return $this->conn->lastInsertId();
    }

}