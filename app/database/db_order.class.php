<?php

include_once(dirname(__FILE__) . "/../config.php");
include_once(FRAMEWORK_PATH . "logging.php");
include_once(FRAMEWORK_PATH . "cache.php");
include_once(FRAMEWORK_PATH . "database.php");

class db_order extends database {
    private static $instance = null;
    public static function inst() {
        if (self::$instance == null)
            self::$instance = new db_order();
        return self::$instance;
    }

    private function __construct() {
        try {
            $this->init(MYSQL_DATABASE);
        } catch (PDOException $e) {
            logging::e("PDO.Exception", $e, false);
            die($e);
        }
    }

    public function add($staff_id, $service_id, $start_time, $customer_name, $customer_tel) {
        return $this->insert(TABLE_ORDERS, array("staff_id" => $staff_id, "service_id" => $service_id, "start_time" => $start_time, "customer_name" => $customer_name, "customer_tel" => $customer_tel, "status" => 1));
    }
    
    public function update($id, $staff_id, $service_id, $start_time, $status, $content) {
        return $this->update(TABLE_ORDERS, array("staff_id" => $staff_id, "service_id" => $service_id, "start_time" => $start_time, "status" => $status, "content" => $content), "id = '$id'");
    }

    public function get_one_order($id) {
        return $this->get_one_table(TABLE_ORDERS, "id = '$id'");
    }
    
    public function get_all_orders() {
        return $this->get_all_table(TABLE_ORDERS);
    }

}


