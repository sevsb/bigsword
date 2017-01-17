<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class customers_controller {

    public function index_action() {
        $tpl = new tpl("main/header", "main/footer");
        $customers = customers::get_all_customers();
        $tpl->set('customers', $customers);
        $tpl->display("customers/index");
    }
    
    public function detail_show_action() {
        $tpl = new tpl("main/header", "main/footer");
        $id = get_request('id');
        $customer = customers::get_customer_detail($id);
        $service_items = service_item::get_all_items();
        $token = picservice::get_token();
        $tpl->set('id', $id);
        $tpl->set('items', $service_items);
        $tpl->set('customer', $customer);
        $tpl->set('token', $token["token"]);
        $tpl->display("customers/detail");
    }

    public function modify_action() {
        $tpl = new tpl("main/header", "main/footer");
        $id = get_request('id');
        $customer = customers::get_customer_detail($id);
        $service_items = service_item::get_all_items();
        $token = picservice::get_token();
        $tpl->set('id', $id);
        $tpl->set('items', $service_items);
        $tpl->set('customer', $customer);
        $tpl->set('token', $token["token"]);
        $tpl->display("customers/modify");
    }
    
    public function new_action() {
        $tpl = new tpl("main/header", "main/footer");
        $service_items = service_item::get_all_items();
        $tpl->set('items', $service_items);
        $tpl->display("customers/new");
    }


    public function add_ajax() {
        $name = get_request('name');
        $content = get_request('content');
        $skills = get_request('skills');
        $filename_list = get_request('filename_list');
        $filename_list = implode($filename_list, ',');
        $skills = implode($skills, ',');
        $ret = customers::add($name, $content, $skills, $filename_list);
        return $ret ? 'success' : 'fail';
    }
    
    public function modify_ajax() {
        $id = get_request('id');
        $name = get_request('name');
        $content = get_request('content');
        $skills = get_request('skills');
        $filename_list = get_request('filename_list');
        $filename_list = implode($filename_list, ',');
        $skills = implode($skills, ',');
        $ret = customers::modify($id, $name, $content, $skills, $filename_list);
        return $ret ? 'success' : 'fail';
    }
    
    public function delete_ajax() {
        $id = get_request('id');
        $ret = customers::del($id);
        return $ret ? 'success' : 'fail';
    }


}













