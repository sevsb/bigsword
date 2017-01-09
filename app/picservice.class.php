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
    
    
    
    
    
    
    
    
    
    
}












?>