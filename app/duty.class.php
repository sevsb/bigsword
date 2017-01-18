<?php
include_once(dirname(__FILE__) . "/config.php");

class duty {
    
    public function __construct($data) {
        $this->summary = $data;
    }
    
    public static function setrule($id, $type, $rule) {
        $ret = db_duty::inst()->setrule($id, $type, $rule);
        return $ret;
    }
    
    public static function get_one_duty($id) {
        $ret = db_duty::inst()->get_one_duty($id);
        return $ret;
    }

    
    
    
    
    
    
    
    
}












?>