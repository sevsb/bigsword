<?php

include_once(dirname(__FILE__) . "/../config.php");
include_once(FRAMEWORK_PATH . "logging.php");
include_once(FRAMEWORK_PATH . "cache.php");
include_once(FRAMEWORK_PATH . "database.php");

class db_service_item extends database {
    private static $instance = null;
    public static function inst() {
        if (self::$instance == null)
            self::$instance = new db_service_item();
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

    public function add($title, $content, $time, $interval, $price, $filename_list) {
        return $this->insert(TABLE_SERVICE_ITEMS, array("title" => $title, "content" => $content, "service_time" => $time, "interval_time" => $interval, "price" => $price, "pic" => $filename_list ));
    }
    
    public function get_all_items() {
        return $this->get_all_table(TABLE_SERVICE_ITEMS);
    }


};


