<?php

include_once(dirname(__FILE__) . "/../config.php");
include_once(FRAMEWORK_PATH . "logging.php");
include_once(FRAMEWORK_PATH . "cache.php");
include_once(FRAMEWORK_PATH . "database.php");

class db_duty extends database {
    private static $instance = null;
    public static function inst() {
        if (self::$instance == null)
            self::$instance = new db_duty();
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

    public function add($id) {
        return $this->insert(TABLE_DUTY, array("serverid" => $id));
    }
    
    public function setrule($id, $type, $rule) {
        return $this->update(TABLE_DUTY, array("type" => $type, "rule" => $rule), "serverid = '$id'");
    }
    

    public function get_one_duty($id) {
        return $this->get_one_table(TABLE_DUTY, "serverid = '$id'");
    }

};


