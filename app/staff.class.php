<?php
include_once(dirname(__FILE__) . "/config.php");

class staff {
    public $summary = array();

    public function __construct($summary = array()) {
        $this->summary = $summary;
    }

    public function photo_url() {
        $url = rtrim(UPLOAD_URL, "/") . "/" . $this->summary["photo"];
        return $url;
    }

    public function photo_thumbnail_url() {
        $url = mkUploadThumbnail($this->summary["photo"], 0, 500);
        return $url;
    }

    private function summary($key, $def = "") {
        if (isset($this->summary[$key])) {
            return $this->summary[$key];
        }
        return $def;
    }

    public function name() {
        return $this->summary("name");
    }

    public function content() {
        return $this->summary("content");
    }

    public function id() {
        return (int)$this->summary("id", 0);
    }

    public function is_valid() {
        return !empty($this->summary);
    }


    public static function load_all_staffs() {
        $staffs = array();
        $ret = db_staffs::inst()->get_all_staffs();
        foreach ($ret as $staffid => $staff) {
            $staffs[$staffid] = new staff($staff);
        }
        return $staffs;
    }

    public static function create($id) {
        $ret = db_staffs::inst()->get_staff($id);
        if (empty($ret)) {
            return null;
        }
        return new staff($ret);
    }

    public static function create_stub_staff() {
        return new staff();
    }

    public static function is_workdate($timestamp, $staff_id) {

        $date = date("Y-m-d ", $timestamp);

        $duty = duty::create($staff_id);
        $type = $duty->type();
        $vacations = $duty->vacations();
        $rule = $duty->rule();
        logging::e("vacations",$vacations);
        $vacations = json_decode($vacations);
        $vacations = get_object_vars($vacations);
        //logging::e("timestamp",$timestamp);
        //logging::e("vacations",$vacations);
        if (array_key_exists($timestamp, $vacations)) {
            logging::e("array_key_exists",$vacations);
            if ($vacations[$timestamp]->type > 0) {
                return array("ret" => false, "reason" => "$date 单日是休息日子");
            }else if ($vacations[$timestamp]->type < 0) {
                return array("ret" => true, "detail" => "$date 是工作日");
            }
        }
        if ($type == 1) {
            $rule = explode(',', $rule);
            $wkd = date('w',$timestamp);
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

};

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
