<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class booking_controller {

    public function index_action() {
        $tpl = new tpl("booking/header", "booking/footer");
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
        $tpl->display("booking/index");
    }

    public function add_ajax() {
        $staff_id = get_request('staff_id');
        $service_id = get_request('service_id');
        $start_time = get_request('start_time');
        $customer_name = get_request('customer_name');
        $customer_tel = get_request('customer_tel');
        $ret = order::add($staff_id, $service_id, $start_time, $customer_name, $customer_tel);
        return $ret ? array("ret" => "success", "info" => $ret) : array("ret" => "fail", "info" => "add_order_failed");
    }

}