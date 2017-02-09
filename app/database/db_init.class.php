<?php


include_once(dirname(__FILE__) . "/../config.php");
include_once(FRAMEWORK_PATH . "logging.php");
include_once(FRAMEWORK_PATH . "cache.php");
include_once(FRAMEWORK_PATH . "database.php");


// --------------------------------------------------------- init --------------------------------------------------------------
class db_init extends database {
    private static $mInstance = null;
    public static function instance() {
        if (self::$mInstance == null)
            self::$mInstance = new db_init();
        return self::$mInstance;
    }

    private function __construct() {
        try {
            $this->init(MYSQL_DATABASE);
        } catch (PDOException $e) {
            $this->init();
        }
    }

    private function create_table($name, $data) {
        $s = array();
        foreach ($data as $k => $v) {
            $s []= "$k $v";
        }
        $s = implode(", ", $s);
        $s = "id INT AUTO_INCREMENT PRIMARY KEY, $s";

        $query = "CREATE TABLE IF NOT EXISTS $name ($s) DEFAULT CHARSET utf8";
        // logging::d("Database", $query);
        $res = $this->exec($query);
        $res = str_replace("\n", " ", print_r($res, true));
        logging::d("Database", $res);
    }

    public function create_tables() {
        $query = "CREATE DATABASE IF NOT EXISTS " . MYSQL_DATABASE . " DEFAULT CHARSET utf8 COLLATE utf8_general_ci";
        $this->exec($query);
        $this->exec("use " . MYSQL_DATABASE);

        // setting
        $this->create_table(TABLE_SETTINGS,  array("name" => "TEXT", "value" => "TEXT"));
        
        // user
        $this->create_table(TABLE_USERS,  array("nick" => "TEXT", "email" => "TEXT", "password" => "TEXT", "face" => "TEXT", "register_time" => "TEXT", "groupid" => "INT", "token" => "TEXT", "tokentime" => "TEXT"));
        $this->create_table(TABLE_USERSETTINGS,  array("userid" => "INT", "name" => "TEXT", "value" => "TEXT"));
        $this->create_table(TABLE_USER_GROUPS,  array("name" => "TEXT", "access" => "TEXT"));

        // serve
        //$this->create_table(TABLE_SERVICE_ITEMS, array('title' => "TEXT",'content' => "TEXT",'price' => "TEXT",'service_time' => "TEXT",'interval' => "TEXT",'pic' => "TEXT"));
        $this->create_table(TABLE_SERVICE_ITEMS,  array("title" => "TEXT", "content" => "TEXT", "price" => "TEXT", "service_time" => "TEXT", "interval_time" => "TEXT",  "pic" => "TEXT" ));
        $this->create_table(TABLE_SERVERS,  array("name" => "TEXT", "level" => "TEXT", "content" => "TEXT", "skill" => "TEXT", "status" => "TEXT",  "pic" => "TEXT" ));
        
        // duty
        $this->create_table(TABLE_DUTY,  array("serverid" => "TEXT", "type" => "TEXT", "rule" => "TEXT", "vacation_count" => "TEXT", "vacation" => "TEXT",  "overtime" => "TEXT"));

        
        // orders
        $this->create_table(TABLE_ORDERS,  array("staff_id" => "TEXT", "service_id" => "TEXT", "start_time" => "TEXT", "status" => "TEXT",  "content" => "TEXT"));
        
        // customers
        $this->create_table(TABLE_CUSTOMERS,  array("name" => "TEXT", "tel" => "TEXT"));

    }

};