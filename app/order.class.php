<?php
include_once(dirname(__FILE__) . "/config.php");

class order {
    
    public $summary = array();
    
    public function __construct($data) {
        $this->summary = $data;
    }
    
    private function summary($key, $def = "") {
        if (isset($this->summary[$key])) {
            return $this->summary[$key];
        }
        return $def;
    }


    public function staff_id() {
        return $this->summary("serverid");
    }

    public function service_id() {
        return $this->summary("service_id");
    }
    
    public function status() {
        return $this->summary("status");
    }
    
    public function start_time() {
        return $this->summary("start_time");
    }
    
    public function content() {
        return $this->summary("content");
    }


    public static function load_all() {
        $orders = array();
        $r = db_order::inst()->get_all_orders();
        foreach ($r as $orderid => $order) {
            $orders[$orderid] = new order($order);
        }
        return $orders;
    }

    public static function create($id) {
        $r = db_order::inst()->get_one_order($id);
        if (empty($r)) {
            return null;
        }
        return new order($r);
    }
    
    
   /////////////////////////////////////////////////////// 
    

    public static function get_one_order($id) {
        $ret = db_order::inst()->get_one_order($id);
        return $ret;
    }
    
    public static function add($staff_id, $service_id, $start_time) {
        return db_order::inst()->add($staff_id, $service_id, $start_time);
    }
    
    
}
    


?>