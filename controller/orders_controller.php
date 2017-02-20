<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class orders_controller {

    public function index_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $service_items = service::load_all();
        $staffs = staff::load_all_staffs();
        $duties = duty::get_all_duties();
        $orders = order::load_all();
        $token = picservice::get_token();
        $staff_services = db_staff_services::inst()->load_all();
        $tpl->set('id', $id);
        $tpl->set('items', $service_items);
        $tpl->set('staffs', $staffs);
        $tpl->set('orders', $orders);
        $tpl->set('duties', $duties);
        $tpl->set('token', $token["token"]);
        $tpl->set('staff_services', $staff_services);
        $tpl->display("orders/index");
    }

    public function new_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $service_items = service::load_all();
        $staffs = staff::load_all_staffs();
        $duties = duty::get_all_duties();
        $token = picservice::get_token();
        $staff_services = db_staff_services::inst()->load_all();
        $orders = order::load_all();
        $tpl->set('id', $id);
        $tpl->set('items', $service_items);
        $tpl->set('staffs', $staffs);
        $tpl->set('items_count', count($service_items));
        $tpl->set('staffs_count', count($staffs));
        $tpl->set('duties', $duties);
        $tpl->set('token', $token["token"]);
        $tpl->set('staff_services', $staff_services);
        $tpl->set('service_items', $service_items);
        $tpl->set('orders', $orders);
        $tpl->display("orders/new");
    }
    
    public function add_ajax() {
        $staff_id = get_request('staff_id');
        $service_id = get_request('service_id');
        $start_time = get_request('start_time');
        $ret = order::add($staff_id, $service_id, $start_time);
        return $ret ? array("ret" => "success", "info" => $ret) : array("ret" => "fail", "info" => "add_order_failed");
    }
    


}













