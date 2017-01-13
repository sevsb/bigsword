<?php

include_once(dirname(__FILE__) . "/../config.php");
include_once(FRAMEWORK_PATH . "logging.php");
include_once(FRAMEWORK_PATH . "cache.php");
include_once(FRAMEWORK_PATH . "database.php");

class db_servers extends database {
    private static $instance = null;
    public static function inst() {
        if (self::$instance == null)
            self::$instance = new db_servers();
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

    public function add($name, $content, $skills, $filename_list) {
        return $this->insert(TABLE_SERVERS, array("name" => $name, "content" => $content, "skill" => $skills, "pic" => $filename_list));
    }
    
    public function get_all_servers() {
        return $this->get_cached('all_servers', TABLE_SERVERS);
    }
    
    public function get_server_detail($id) {
        return $this->get_one_table(TABLE_SERVERS, "id = '$id'");
    }

};


