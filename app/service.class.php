<?php
include_once(dirname(__FILE__) . "/config.php");

class service {

    public $summary = array();

    public function __construct($data) {
        $this->summary = $data;
    }

    private function summary($key, $def = "") {
        if (isset($this->summary[$key])) {
            return $this->summary[$key];
        }
        return $def;
    }

    public function photo_url() {
        $url = rtrim(UPLOAD_URL, "/") . "/" . $this->summary["pic"];
        return $url;
    }

    public function photo_thumbnail_url() {
        $url = mkUploadThumbnail($this->summary["pic"], 0, 500);
        return $url;
    }

    public function title() {
        return $this->summary("title");
    }

    public function content() {
        return $this->summary("content");
    }

    public function price() {
        return $this->summary("price");
    }

    public function waste_time() {
        return $this->summary("service_time") + $this->summary("interval_time") * 2;
    }

    public function id() {
        return (int)$this->summary("id", 0);
    }

    public function is_valid() {
        return !empty($this->summary);
    }

    public static function load_all() {
        $services = array();
        $ret = db_service::inst()->get_all_services();
        foreach ($ret as $id => $service) {
            $services[$id] = new service($service);
        }
        return $services;
    }

    public static function create($id) {
        $ret = db_service::inst()->get_service($id);
        if (empty($ret)) {
            return null;
        }
        return new service($ret);
    }

    public static function create_stub() {
        return new service();
    }

    // ----------------------------------------------------------------------------------------------------
    public static function add($title, $content, $time, $interval, $price, $filename_list) {
        $ret = db_service::inst()->add($title, $content, $time, $interval, $price, $filename_list);
        return $ret;
    }

    public static function modify($id, $title, $content, $time, $interval, $price, $filename_list) {
        $ret = db_service::inst()->modify($id, $title, $content, $time, $interval, $price, $filename_list);
        return $ret;
    }

    public static function del($id) {
        $ret = db_service::inst()->del($id);
        return $ret;
    }

    public static function get_all_services() {
        $ret = db_service::inst()->get_all_services();
        return $ret;
    }

    public static function get_service_detail($id) {
        $ret = db_service::inst()->get_service_detail($id);
        return $ret;
    }


}












