<?php

include_once(dirname(__FILE__) . "/../config.php");
include_once(FRAMEWORK_PATH . "logging.php");
include_once(FRAMEWORK_PATH . "cache.php");
include_once(FRAMEWORK_PATH . "database.php");

class db_staffs extends database {
    private static $instance = null;
    public static function inst() {
        if (self::$instance == null)
            self::$instance = new db_staffs();
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

    public function get_all_staffs() {
        return $this->get_all_table(TABLE_STAFFS);
    }
    
    public function get_staff($staff_id) {
        $staff_id = (int)$staff_id;
        return $this->get_one_table(TABLE_STAFFS, "id = $staff_id");
    }

    public function add_staff($name, $content, $photo) {
        return $this->insert(TABLE_STAFFS, array("name" => $name, "content" => $content, "photo" => $photo));
    }
    
    public function del_staff($id) {
        return $this->delete(TABLE_STAFFS, "id = '$id'");
    }

    public function update_staff($staff_id, $name, $content, $photo) {
        $staff_id = (int)$staff_id;
        if ($photo == null) {
            return $this->update(TABLE_STAFFS, array("name" => $name, "content" => $content), "id = $staff_id");
        } else {
            return $this->update(TABLE_STAFFS, array("name" => $name, "content" => $content, "photo" => $photo), "id = $staff_id");
        }
    }
};


