<?php
include_once(dirname(__FILE__) . "/../../app/config.php");

class staff_controller {

    public function index_action() {
        $staffs = staff::load_all_staffs();

        $tpl = new tpl("admin/header", "admin/footer");
        $tpl->set('staffs', $staffs);
        $tpl->display("admin/staff/staff");
    }
    

    public function new_action() {
        $service_items = service_item::get_all_items();
        $staff = staff::create_stub_staff();

        $tpl = new tpl("admin/header", "admin/footer");
        $tpl->set('items', $service_items);
        $tpl->set("staff", $staff);
        $tpl->display("admin/staff/info");
    }

    public function view_action() {
        $staff_id = get_request_assert("staff");
        $staff = staff::create($staff_id);
        if ($staff == null) {
            fatal();
        }

        $service_items = service_item::get_all_items();
        $tpl = new tpl("admin/header", "admin/footer");
        $tpl->set('items', $service_items);
        $tpl->set("staff", $staff);
        $tpl->display("admin/staff/info");
    }

    public function add_ajax() {
        $name = get_request_assert("name");
        $content = get_request_assert("content");
        $skills = get_request_assert("skills");
        $photo = get_request_assert("photo");

        $filename = null;
        $ret = uploadImageViaFileReader($photo, function($filename) {
            return $filename;
        });
        if (strncmp($ret, "fail|", 5) == 0) {
            return $ret;
        }
        $filename = $ret;

        $ret = db_staffs::inst()->add_staff($name, $content, $filename);
        return ($ret !== false) ? "success" : "fail|数据库操作失败，请稍后重试。";
    }

    public function update_ajax() {
        $staff_id = get_request_assert("staff_id");
        $name = get_request_assert("name");
        $content = get_request_assert("content");
        $skills = get_request_assert("skills");
        $photo = get_request_assert("photo");

        $filename = null;
        if (strncmp($photo, "http", 4) != 0) {
            $ret = uploadImageViaFileReader($photo, function($filename) {
                return $filename;
            });
            if (strncmp($ret, "fail|", 5) == 0) {
                return $ret;
            }
            $filename = $ret;
        }

        $ret = db_staffs::inst()->update_staff($staff_id, $name, $content, $filename);
        return ($ret !== false) ? "success" : "fail|数据库操作失败，请稍后重试。";
    }
}













