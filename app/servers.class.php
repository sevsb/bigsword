<?php
include_once(dirname(__FILE__) . "/config.php");

class servers {
    
    public function __construct($data) {
        $this->summary = $data;
    }

    public static function add($name, $content, $skills, $filename_list) {
        $ret = db_servers::inst()->add($name, $content, $skills, $filename_list);
        $newid = db_servers::inst()->last_insert_id();
        $ret = db_duty::inst()->add($newid);
        return $ret;
    }
    
    public static function modify($id, $name, $content, $skills, $filename_list) {
        $ret = db_servers::inst()->modify($id, $name, $content, $skills, $filename_list);
        return $ret;
    }
    
    public static function del($id) {
        $ret = db_servers::inst()->del($id);
        return $ret;
    }
    
    public static function get_all_servers() {
        return db_servers::inst()->get_all_servers();
    }
    
    public static function get_server_detail($id) {
        return db_servers::inst()->get_server_detail($id);
    }
    
    public static function is_workdate($date, $serverid) {
        $duty = duty::get_one_duty($serverid);
        $type = $duty["type"];
        $vacations = $duty["vacation"];
        $rule = $duty["rule"];
        $vacations = json_decode($vacations);
        $vacations = get_object_vars($vacations);
        $jsday = mk_jsday($date);
        if (array_key_exists($jsday, $vacations)) {
            if ($vacations[$jsday]->type > 0) {
                return array("ret" => false, "reason" => "$date 单日是休息日子");
            }else if ($vacations[$jsday]->type < 0) {
                return array("ret" => true, "detail" => "$date 是工作日");
            }
        }
        if ($type == 1) {   
            $rule = explode(',', $rule);
            $wkd = date('w',strtotime($date));
            foreach ($rule as $restday) {
                if ($wkd == $restday) {
                    return array("ret" => false, "reason" => "$date 是 $wkd 这天是休息日来自RULE");
                }
            }
        }
        if ($type == 2) {
            $rule = explode(',', $rule);
            $work_regular = $rule[0];
            $rest_regular = $rule[1];
            $regular = $work_regular + $rest_regular;
            $start_date = $rule[2];
            $diff = diffBetweenTwoDays($start_date, $date);
            $extra_day = $diff % (int)$regular;
            if ($extra_day >= $work_regular) {
                return array("ret" => false, "reason" => "$date 这天是休息日来自RULE-2");
            }
        }
        return array("ret" => true, "detail" => "$date 是工作日");
    }
}




function diffBetweenTwoDays ($day1, $day2){
  $second1 = strtotime($day1);
  $second2 = strtotime($day2);
    
  if ($second1 < $second2) {
    $tmp = $second2;
    $second2 = $second1;
    $second1 = $tmp;
  }
  return ($second1 - $second2) / 86400;
}

function make_truedate($date){
    $date = explode("-", $date);
    $year = $date[0];
    $month = $date[1] + 1;
    $day = $date[2];
    $true_day = $year . "-" . $month . "-" . $day;  //需要手动+1月份
    return $true_day;
}






?>