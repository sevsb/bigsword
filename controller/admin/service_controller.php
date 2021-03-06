<?php
include_once(dirname(__FILE__) . "/../../app/config.php");

class service_controller {
    public function preaction($action) {
        login::assert();
    }
    public function index_action() {
        $services = service::load_all();

        $tpl = new tpl("admin/header", "admin/footer");
        $tpl->set("services", $services);
        $tpl->display("admin/service/index");
    }

    public function new_action() {
        $service = service::create_stub();
        $tpl = new tpl("admin/header", "admin/footer");
        $tpl->set("service", $service);
        $tpl->display("admin/service/info");
    }

    public function view_action() {
        $service_id = get_request_assert("service");
        $service = service::create($service_id);
        if ($service == null) {
            fatal();
        }
        $tpl = new tpl("admin/header", "admin/footer");
        $tpl->set("service", $service);
        $tpl->set("service_id", $service_id);
        $tpl->display("admin/service/info");
    }

    public function add_ajax() {
        $title = get_request_assert("title");
        $content = get_request_assert("content");
        $photo = get_request_assert("photo");
        $service_time = get_request_assert("service_time");
        $interval_time = get_request_assert("interval_time");
        $price = get_request_assert("price");

        $filename = null;
        $ret = uploadImageViaFileReader($photo, function($filename) {
            return $filename;
        });
        if (strncmp($ret, "fail|", 5) == 0) {
            return $ret;
        }
        $filename = $ret;

        $ret = db_service::inst()->add_service($title, $content, $filename, $service_time, $interval_time, $price);
        return ($ret !== false) ? "success" : "fail|数据库操作失败，请稍后重试。";
    }
    
    public function del_ajax() {
        $id = get_request_assert("id");
        $ret = db_service::inst()->del_service($id);
        return ($ret !== false) ? "success" : "fail|数据库操作失败，请稍后重试。";
    }

    public function update_ajax() {
        $service_id = get_request_assert("service_id");
        $title = get_request_assert("title");
        $content = get_request_assert("content");
        $photo = get_request_assert("photo");
        $service_time = get_request_assert("service_time");
        $interval_time = get_request_assert("interval_time");
        $price = get_request_assert("price");

        $filename = null;
        if (strpos($photo, THUMBNAIL_URL)) {
        //if (strncmp($photo, "http", 4) != 0) {
            $ret = uploadImageViaFileReader($photo, function($filename) {
                return $filename;
            });
            if (strncmp($ret, "fail|", 5) == 0) {
                return $ret;
            }
            $filename = $ret;
        }

        $ret = db_service::inst()->update_service($service_id, $title, $content, $filename, $service_time, $interval_time, $price);
        return ($ret !== false) ? "success" : "fail|数据库操作失败，请稍后重试。";
    }

}













