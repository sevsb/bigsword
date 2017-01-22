<?php
include_once(dirname(__FILE__) . "/config.php");

class servers {
    
    public function __construct($data) {
        $this->summary = $data;
    }

    public static function add($name, $content, $skills, $filename_list) {
        $ret = db_servers::inst()->add($name, $content, $skills, $filename_list);
        $newid = db_servers::inst()->last_insert_id();
        $ret = db_duty::inst()->add($newid);
        return $ret;
    }
    
    public static function modify($id, $name, $content, $skills, $filename_list) {
        $ret = db_servers::inst()->modify($id, $name, $content, $skills, $filename_list);
        return $ret;
    }
    
    public static function del($id) {
        $ret = db_servers::inst()->del($id);
        return $ret;
    }
    
    public static function get_all_servers() {
        return db_servers::inst()->get_all_servers();
    }
    
    public static function get_server_detail($id) {
        return db_servers::inst()->get_server_detail($id);
    }
    
    public static function is_workdate($date, $serverid) {
        $duty = duty::get_one_duty($serverid);
        $type = $duty["type"];
        $vacations = $duty["vacation"];

        $vacations = json_decode($vacations);
        $vacations = get_object_vars($vacations);
        
        
        if (array_key_exists($date, $vacations)) {
            if ($vacations[$date]->type > 0) {
                return array("ret" => false, "reason" => "$date 单日是休息日子");
            }else if ($vacations[$date]->type < 0) {
                return array("ret" => true, "detail" => "$date 是工作日");
            }
        }
        
        if ($type == 1) {
            
        }
        if ($type == 2) {
            
        }
       
        return array("ret" => true, "detail" => "$date 是工作日");
        return $date;
    }
}











?>