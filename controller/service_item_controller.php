<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class service_item_controller {

    public function index_action() {
        $tpl = new tpl("main/header", "main/footer");
        $service_items = service::get_all_services();
        $tpl->set('items', $service_items);
        $tpl->display("service_item/index");
    }
    
    public function detail_show_action() {
        $tpl = new tpl("main/header", "main/footer");
        $id = get_request('id');
        $item = service::get_service_detail($id);
        $token = picservice::get_token();
        $tpl->set('id', $id);
        $tpl->set('item', $item);
        $tpl->set('token', $token["token"]);
        $tpl->display("service_item/detail");
    }

    public function modify_action() {
        $tpl = new tpl("main/header", "main/footer");
        $id = get_request('id');
        $item = service::get_service_detail($id);
        $token = picservice::get_token();
        $tpl->set('id', $id);
        $tpl->set('item', $item);
        $tpl->set('token', $token["token"]);
        $tpl->display("service_item/modify");
    }
    
    public function new_action() {
        $tpl = new tpl("main/header", "main/footer");
        $tpl->display("service_item/new");
    }

    public function add_ajax() {
        $title = get_request('title');
        $content = get_request('content');
        $time = get_request('time');
        $interval = get_request('interval');
        $price = get_request('price');
        $filename_list = get_request('filename_list');
        $filename_list = implode($filename_list, ',');
        $ret = service::add($title, $content, $time, $interval, $price, $filename_list);
        return $ret ? 'success' : 'fail';
    }

    public function modify_ajax() {
        $id = get_request('id');
        $title = get_request('title');
        $content = get_request('content');
        $time = get_request('time');
        $interval = get_request('interval');
        $price = get_request('price');
        $filename_list = get_request('filename_list');
        $filename_list = implode($filename_list, ',');
        $ret = service::modify($id, $title, $content, $time, $interval, $price, $filename_list);
        return $ret ? 'success' : 'fail';
    }
    
    public function delete_ajax() {
        $id = get_request('id');
        $ret = service::del($id);
        return $ret ? 'success' : 'fail';
    }

}













