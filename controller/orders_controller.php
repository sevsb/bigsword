<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class orders_controller {
    
    public function preaction($action) {
        login::assert();
    }
    public function index_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $service_items = service::load_all();
        $staffs = staff::load_all_staffs();
        $duties = duty::get_all_duties();
        $orders = order::load_all();
        $token = picservice::get_token();
        $staff_services = db_staff_services::inst()->load_all();
        $tpl->set('items', $service_items);
        $tpl->set('staffs', $staffs);
        $tpl->set('orders', $orders);
        $tpl->set('duties', $duties);
        $tpl->set('token', $token["token"]);
        $tpl->set('staff_services', $staff_services);
        $tpl->display("orders/index");
    }
    
    public function staff_orders_action() {
        $tpl = new tpl("booking/header", "booking/footer");
        $service_items = service::load_all();
        $staffs = staff::load_all_staffs();
        $duties = duty::get_all_duties();
        $orders = order::load_all();
        $token = picservice::get_token();
        $event_settings = db_settings::inst()->load_event_settings();
        $staff_services = db_staff_services::inst()->load_all();
        $work_hours = settings::instance()->get_work_hours();
        $tpl->set('start_clock', $work_hours['start']);
        $tpl->set('end_clock', $work_hours['end']);
        $tpl->set('event_settings', $event_settings);
        $tpl->set('items', $service_items);
        $tpl->set('staffs', $staffs);
        $tpl->set('orders', $orders);
        $tpl->set('duties', $duties);
        $tpl->set('token', $token["token"]);
        $tpl->set('staff_services', $staff_services);
        $tpl->display("orders/staff_orders");
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
        $customer_name = get_request('customer_name');
        $customer_tel = get_request('customer_tel');
        $userid = get_request('userid');
        $ret = order::add($staff_id, $service_id, $start_time, $customer_name, $customer_tel, $userid);
        return $ret ? array("ret" => "success", "info" => $ret) : array("ret" => "fail", "info" => "add_order_failed");
    }
    
    public function done_ajax() {
        $id = get_request('id');
        $ret = order::done($id);
        return $ret ? array("ret" => "success", "info" => $ret) : array("ret" => "fail", "info" => "done_order_failed");
    }
    
    public function cancel_ajax() {
        $id = get_request('id');
        $ret = order::cancel($id);
        return $ret ? array("ret" => "success", "info" => $ret) : array("ret" => "fail", "info" => "done_order_failed");
    }
    


}













