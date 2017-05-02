<?php

include_once(dirname(__FILE__) . "/../config.php");
include_once(FRAMEWORK_PATH . "logging.php");
include_once(FRAMEWORK_PATH . "cache.php");
include_once(FRAMEWORK_PATH . "database.php");

class db_service extends database {
    private static $instance = null;
    public static function inst() {
        if (self::$instance == null)
            self::$instance = new db_service();
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

    public function add_service($title, $content, $photo, $service_time, $interval_time, $price) {
        return $this->insert(TABLE_SERVICES, array("title" => $title, "price" => $price, "service_time" => $service_time, "interval_time" => $interval_time, "content" => $content, "pic" => $photo));
    }

    public function update_service($id, $title, $content, $photo, $service_time, $interval_time, $price) {
        $id = (int)$id;
        if ($photo == null) {
            return $this->update(TABLE_SERVICES, array("title" => $title, "price" => $price, "service_time" => $service_time, "interval_time" => $interval_time, "content" => $content), "id = $id");
        } else {
            return $this->update(TABLE_SERVICES, array("title" => $title, "price" => $price, "service_time" => $service_time, "interval_time" => $interval_time, "content" => $content, "pic" => $photo), "id = $id");
        }
    }

    // public function modify($id, $title, $content, $time, $interval, $price, $filename_list) {
    //     return $this->update(TABLE_SERVICES, array("title" => $title, "content" => $content, "service_time" => $time, "interval_time" => $interval, "price" => $price, "pic" => $filename_list), "id = '$id'");
    // }
    // 
    public function del_service($id) {
        return $this->delete(TABLE_SERVICES, "id = '$id'");
    }

    public function get_all_services() {
        return $this->get_all_table(TABLE_SERVICES);
    }
    
    public function get_service($id) {
        return $this->get_one_table(TABLE_SERVICES, "id = $id");
    }


};


