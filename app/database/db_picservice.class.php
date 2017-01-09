<?php

include_once(dirname(__FILE__) . "/../config.php");
include_once(FRAMEWORK_PATH . "logging.php");
include_once(FRAMEWORK_PATH . "cache.php");
include_once(FRAMEWORK_PATH . "database.php");

class db_picservice extends database {
    private static $instance = null;
    public static function inst() {
        if (self::$instance == null)
            self::$instance = new db_picservice();
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

    public function update_code($code) {
        return $this->update(TABLE_SETTINGS, array('value' => $code), "name = 'authorized_code'");
    }
    
    public function save_token($token, $expired) {
        $ret1 = $this->update(TABLE_SETTINGS, array('value' => $token), "name = 'picservice_token'");
        $ret2 = $this->update(TABLE_SETTINGS, array('value' => $expired), "name = 'picservice_token_expired'");
        return $ret1 && $ret2;
    }
    
    public function get_code() {
        return $this->get_one_table(TABLE_SETTINGS, "name = 'authorized_code'");
    }
    
    public function get_token() {
        $token = $this->get_one_table(TABLE_SETTINGS, "name = 'picservice_token'");
        $expired = $this->get_one_table(TABLE_SETTINGS, "name = 'picservice_token_expired'");
        
        return array('token' => $token['value'], 'expired' => $expired['value']);
    }

};


