<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class service_item_controller {

    public function index_action() {
        $tpl = new tpl("main/header", "main/footer");
        $service_items = service_item::get_all_items();
        $tpl->set('items', $service_items);
        $tpl->display("service_item/index");
    }
    
    public function detail_action() {
        $tpl = new tpl("main/header", "main/footer");
        $id = get_request('id');
        $item = service_item::get_item_detail($id);
        $token = picservice::get_token();
        $tpl->set('item', $item);
        $tpl->set('token', $token["token"]);
        $tpl->display("service_item/detail");
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
        $ret = service_item::add($title, $content, $time, $interval, $price, $filename_list);
        return $ret ? 'success' : 'fail';
    }


}













