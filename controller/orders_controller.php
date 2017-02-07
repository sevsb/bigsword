<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class orders_controller {

    public function index_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $staffs = staff::load_all_staffs();
        $tpl->set('staffs', $staffs);
        $tpl->display("orders/index");
    }

    public function new_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $service_items = service::load_all();
        $staffs = staff::load_all_staffs();
        $duties = duty::get_all_duties();
        $token = picservice::get_token();
        $staff_services = db_staff_services::inst()->load_all();
        $tpl->set('id', $id);
        $tpl->set('items', $service_items);
        $tpl->set('staffs', $staffs);
        $tpl->set('items_count', count($service_items));
        $tpl->set('staffs_count', count($staffs));
        $tpl->set('duties', $duties);
        $tpl->set('token', $token["token"]);
        $tpl->set('staff_services', $staff_services);
        $tpl->display("orders/new");
    }
    
    public function get_duty_ajax() {
        $id = get_request('id');
        $ret = duty::get_one_duty($id);
        return $ret ? array("ret" => "success", "info" => $ret) : array("ret" => "fail", "info" => "cannot get duty");
    }
    


}













