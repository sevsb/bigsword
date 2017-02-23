<?php

include_once(dirname(__FILE__) . "/../config.php");
include_once(FRAMEWORK_PATH . "logging.php");
include_once(FRAMEWORK_PATH . "cache.php");
include_once(FRAMEWORK_PATH . "database.php");

class db_staff_services extends database {
    private static $instance = null;
    public static function inst() {
        if (self::$instance == null)
            self::$instance = new db_staff_services();
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
    
    public function load_all() {
        return $this->get_all_table(TABLE_STAFF_SERVICES);
    }
    
    public function get_staff_services($staff_id) {
        $staff_id = (int)$staff_id;
        return $this->get_one_table(TABLE_STAFF_SERVICES, "staff_id = $staff_id");
    }

    public function add_staff_service($id, $skill) {
        return $this->insert(TABLE_STAFF_SERVICES, array("staff_id" => $id, "service_id" => $skill));
    }

    public function update_staff_service($id, $skill) {
        $id = (int)$id;
        return $this->update(TABLE_STAFF_SERVICES, array("service_id" => $skill), "staff_id = $id");
    }
    
    public function del_staff_services($id) {
        return $this->delete(TABLE_STAFF_SERVICES, "staff_id = '$id'");
    }
    
};


