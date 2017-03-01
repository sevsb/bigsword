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
        return $this->summary("staff_id");
    }
    
    public function customer_name() {
        return $this->summary("customer_name");
    }
    
    public function customer_tel() {
        return $this->summary("customer_tel");
    }
    
    public function id() {
        return $this->summary("id");
    }

    public function service_id() {
        return $this->summary("service_id");
    }

    public function status() {
        return $this->summary("status") == 2 ? '已完成' : "未完成" ;
    }

    public function start_time() {
        return $this->summary("start_time");
    }
    
    public function start_time_true() {
        $time = $this->summary("start_time");
        return date('Y-m-d H:i:s', $time);
    }

    public function content() {
        return $this->summary("content");
    }


    public static function load_all() {
        $orders = array();
        $ret = db_order::inst()->get_all_orders();
        foreach ($ret as $id => $order) {
            $orders[$id] = new order($order);
        }
        return $orders;
    }

    public static function create($id) {
        $ret = db_order::inst()->get_one_order($id);
        if (empty($ret)) {
            return null;
        }
        return new order($ret);
    }


   ///////////////////////////////////////////////////////


    public static function get_one_order($id) {
        $ret = db_order::inst()->get_one_order($id);
        return $ret;
    }

    public static function add($staff_id, $service_id, $start_time, $customer_name, $customer_tel, $userid) {
        return db_order::inst()->add($staff_id, $service_id, $start_time, $customer_name, $customer_tel, $userid);
    }
    
    public static function done($id) {
        logging::d("doneid:",$id);
        return db_order::inst()->done($id);
    }
    
    public static function cancel($id) {
        logging::d("doneid:",$id);
        return db_order::inst()->cancel($id);
    }


}



?>