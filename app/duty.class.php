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
    
    public static function save_event($id, $vacation) {
        $ret = db_duty::inst()->save_event($id, $vacation);
        return $ret;
    }
    
    public static function get_one_duty($id) {
        $ret = db_duty::inst()->get_one_duty($id);
        return $ret;
    }
    
    public static function get_all_duties() {
        $ret = db_duty::inst()->get_all_duties();
        return $ret;
    }
    
    public static function get_one_vacation($id) {
        $ret = db_duty::inst()->get_one_duty($id);
        return $ret["vacation"];
    }

    
    
    
    
    
    
    
    
}




function mk_jsday($date){
    $date = explode('-', $date);
    $year = $date[0];
    $month = $date[1] - 1;
    $day = $date[2];
    
    return $year . "-" . $month . "-" . $day;
}








?>