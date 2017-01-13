<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class servers_controller {

    public function index_action() {
        $tpl = new tpl("main/header", "main/footer");
        $servers = servers::get_all_servers();
        $tpl->set('servers', $servers);
        $tpl->display("servers/index");
    }
    
    public function detail_show_action() {
        $tpl = new tpl("main/header", "main/footer");
        $id = get_request('id');
        $server = servers::get_server_detail($id);
        $service_items = service_item::get_all_items();
        $token = picservice::get_token();
        $tpl->set('id', $id);
        $tpl->set('items', $service_items);
        $tpl->set('server', $server);
        $tpl->set('token', $token["token"]);
        $tpl->display("servers/detail");
    }

    public function modify_action() {
        $tpl = new tpl("main/header", "main/footer");
        $id = get_request('id');
        $server = servers::get_server_detail($id);
        $service_items = service_item::get_all_items();
        $token = picservice::get_token();
        $tpl->set('serverid', $id);
        $tpl->set('items', $service_items);
        $tpl->set('server', $server);
        $tpl->set('token', $token["token"]);
        $tpl->display("servers/modify");
    }
    
    public function new_action() {
        $tpl = new tpl("main/header", "main/footer");
        $service_items = service_item::get_all_items();
        $tpl->set('items', $service_items);
        $tpl->display("servers/new");
    }


    public function add_ajax() {
        $name = get_request('name');
        $content = get_request('content');
        $skills = get_request('skills');
        $filename_list = get_request('filename_list');
        $filename_list = implode($filename_list, ',');
        $skills = implode($skills, ',');
        $ret = servers::add($name, $content, $skills, $filename_list);
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
        $ret = servers::modify($id, $name, $content, $skills, $filename_list);
        return $ret ? 'success' : 'fail';
    }
    
    public function delete_ajax() {
        $id = get_request('id');
        $ret = servers::del($id);
        return $ret ? 'success' : 'fail';
    }


}












