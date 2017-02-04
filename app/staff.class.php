<?php
include_once(dirname(__FILE__) . "/config.php");

class staff {
    private $summary = array();

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
        $r = db_staffs::inst()->get_all_staffs();
        foreach ($r as $staffid => $staff) {
            $staffs[$staffid] = new staff($staff);
        }
        return $staffs;
    }

    public static function create($id) {
        $r = db_staffs::inst()->get_staff($id);
        if (empty($r)) {
            return null;
        }
        return new staff($r);
    }

    public static function create_stub_staff() {
        return new staff();
    }

};

 
