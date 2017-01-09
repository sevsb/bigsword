<?php
include_once(dirname(__FILE__) . "/config.php");

class picservice {
    
    public function __construct($data) {
        $this->summary = $data;
    }
    
    public static function update_code($code) {
        $ret = db_picservice::inst()->update_code($code);
        return $ret ? 'success' : 'fail';
    }
      
    public static function get_code() {
        $ret = db_picservice::inst()->get_code();
        return $ret;
    }
    
    public static function get_token() {
        $ret = db_picservice::inst()->get_token();
        return $ret;
    }
    
    public static function save_token($token, $expired) {
        $ret = db_picservice::inst()->save_token($token, $expired);
        return $ret;
    }
    
    
    
    
    
    
    
    
    
    
}












?>