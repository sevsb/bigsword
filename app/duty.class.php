<?php
include_once(dirname(__FILE__) . "/config.php");

class duty {
    
    private $summary = array();
    
    public function __construct($data) {
        $this->summary = $data;
    }
    
    private function summary($key, $def = "") {
        if (isset($this->summary[$key])) {
            return $this->summary[$key];
        }
        return $def;
    }


    public function staff_id() {
        return $this->summary("serverid");
    }

    public function type() {
        return $this->summary("type");
    }
    
    public function rule() {
        return $this->summary("rule");
    }
    
    public function vacations() {
        return $this->summary("vacation");
    }


    public static function load_all() {
        $s = array();
        $r = db_duty::inst()->get_all_duties();
        foreach ($r as $id => $duty) {
            $s[$id] = new duty($duty);
        }
        return $s;
    }

    public static function create($id) {
        $r = db_duty::inst()->get_one_duty($id);
        if (empty($r)) {
            return null;
        }
        return new duty($r);
    }
    
    
   /////////////////////////////////////////////////////// 
    
    
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
        $duties = array();
        $r = db_duty::inst()->get_all_duties();
        foreach ($r as $dutyid => $duty) {
            $duties[$dutyid] = new duty($duty);
        }
        return $duties;
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