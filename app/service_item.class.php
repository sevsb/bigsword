<?php
include_once(dirname(__FILE__) . "/config.php");

class service_item {
    
    public function __construct($data) {
        $this->summary = $data;
    }
    
    public static function add($title, $content, $time, $interval, $price, $filename_list) {
        $ret = db_service_item::inst()->add($title, $content, $time, $interval, $price, $filename_list);
        return $ret;
    }

    public static function modify($id, $title, $content, $time, $interval, $price, $filename_list) {
        $ret = db_service_item::inst()->modify($id, $title, $content, $time, $interval, $price, $filename_list);
        return $ret;
    }

    public static function del($id) {
        $ret = db_service_item::inst()->del($id);
        return $ret;
    }
    
    public static function get_all_items() {
        $ret = db_service_item::inst()->get_all_items();
        return $ret;
    }
    
    public static function get_item_detail($id) {
        $ret = db_service_item::inst()->get_item_detail($id);
        return $ret;
    }

    
    
    
    
    
    
    
    
    
    
}












?>