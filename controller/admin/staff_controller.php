<?php
include_once(dirname(__FILE__) . "/../../app/config.php");

class staff_controller {
    public function preaction($action) {
        login::assert();
    }
    public function index_action() {
        $staffs = staff::load_all_staffs();

        $tpl = new tpl("admin/header", "admin/footer");
        $tpl->set('staffs', $staffs);
        $tpl->display("admin/staff/staff");
    }
    

    public function new_action() {
        $service_items = service::get_all_services();
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
        $staff_services = db_staff_services::inst()->get_staff_services($staff_id);
        $service_items = service::get_all_services();
        $tpl = new tpl("admin/header", "admin/footer");
        $tpl->set('items', $service_items);
        $tpl->set("staff", $staff);
        $tpl->set("staff_id", $staff_id);
        $tpl->set("staff_services", $staff_services["service_id"]);
        $tpl->display("admin/staff/info");
    }

    public function add_ajax() {
        $name = get_request_assert("name");
        $content = get_request_assert("content");
        $skills = get_request_assert("skills");
        $photo = get_request_assert("photo");
        $skills = implode(',', $skills);
        $filename = null;
        $ret = uploadImageViaFileReader($photo, function($filename) {
            return $filename;
        });
        if (strncmp($ret, "fail|", 5) == 0) {
            return $ret;
        }
        $filename = $ret;

        $ret1 = db_staffs::inst()->add_staff($name, $content, $filename);
        $newid = db_staffs::inst()->last_insert_id();
        $ret2 = db_duty::inst()->add($newid);
        $ret3 = db_staff_services::inst()->add_staff_service($newid, $skills);
        return (($ret1 && $ret2 && $ret3) !== false) ? "success" : "fail|数据库操作失败，请稍后重试。";
    }

    public function update_ajax() {
        $staff_id = get_request_assert("staff_id");
        $name = get_request_assert("name");
        $content = get_request_assert("content");
        $skills = get_request_assert("skills");
        $photo = get_request_assert("photo");
        $skills = implode(',', $skills);
        $filename = null;
        
        if (substr($photo, 0, 5) == "data:") {
            $ret = uploadImageViaFileReader($photo, function($filename) {
                return $filename;
            });
            logging::e("uploadImage-ret", $ret);
            if (strncmp($ret, "fail|", 5) == 0) {
                return $ret;
            }
            $filename = $ret;
        }else {
            $filename = explode('/', $photo);
            $filename = end($filename);
        }

        $ret = db_staffs::inst()->update_staff($staff_id, $name, $content, $filename);
        $ret1 = db_staff_services::inst()-> update_staff_service($staff_id, $skills);
        return (($ret && $ret1) !== false) ? "success" : "fail|数据库操作失败，请稍后重试。";
    }
    
    public function del_ajax() {
        $id = get_request_assert("id");
        $ret1 = db_staffs::inst()->del_staff($id);
        $ret2 = db_staff_services::inst()->del_staff_services($id);
        $ret3 = db_duty::inst()->del($id);
        return (($ret1 && $ret2 && $ret3) !== false) ? "success" : "fail|数据库操作失败，请稍后重试。";
    }
}













