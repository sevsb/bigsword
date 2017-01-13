<?php
include_once(dirname(__FILE__) . "/config.php");

class servers {
    
    public function __construct($data) {
        $this->summary = $data;
    }
    
    public static function add($name, $content, $skills, $filename_list) {
        $ret = db_servers::inst()->add($name, $content, $skills, $filename_list);
        return $ret;
    }
    
    public static function get_all_servers() {
        return db_servers::inst()->get_all_servers();
    }
    
    public static function get_server_detail($id) {
        return db_servers::inst()->get_server_detail($id);
    }
    
    
    
    
    
    
    
    
    
    
}












?>