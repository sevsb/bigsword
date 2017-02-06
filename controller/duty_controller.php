<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class duty_controller {

    public function index_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $servers = servers::get_all_servers();
        $tpl->set('servers', $servers);
        $tpl->display("duty/index");
    }

    public function modify_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $id = get_request('id');
        $server = servers::get_server_detail($id);
        $service_items = service::get_all_services();
        $duty = duty::get_one_duty($id);
        $token = picservice::get_token();
        $tpl->set('id', $id);
        $tpl->set('items', $service_items);
        $tpl->set('server', $server);
        $tpl->set('duty', $duty);
        $tpl->set('token', $token["token"]);
        $tpl->display("duty/modify");
    }
    
    public function calendar_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $service_items = service::get_all_services();
        $tpl->set('items', $service_items);
        $tpl->display("duty/calendar");
    }

    public function setrule_ajax() {
        $id = get_request('serverid');
        $type = get_request('type');
        $rule = get_request('rule');
        $rule = implode(',', $rule);
        //logging::e("SETRULE", "id : $id");
        //logging::e("SETRULE", "type : $type");
        //logging::e("SETRULE", "rule : $rule");
        $ret = duty::setrule($id, $type, $rule);
        return $ret ? 'success' : 'fail';
    }
    
    public function make_event_ajax() {
        $id = get_request('serverid');
        $date = get_request('date');
        $type = get_request('type');
        $content = get_request('content');

        $event = array(
            "type" => $type,
            "content" => $content
        );

        logging::e("MAKEEVENT", "id : $id");
        logging::e("MAKEEVENT", "date : $date");
        logging::e("MAKEEVENT", "type : $type");
        logging::e("MAKEEVENT", "content : $content");
        logging::e("MAKEEVENT", "event : $event");
        
        $vacations = duty::get_one_vacation($id);
        logging::e("MAKEEVENT", "now vacations : $vacations");
        
        $vacations = json_decode($vacations);
        $vacations->$date = $event;
        $vacations = json_encode($vacations);

        logging::e("MAKEEVENT", "update vacations : $vacations");
        $ret = duty::save_event($id, $vacations);
        return $ret ? 'success' : 'fail';
    }
    
    public function cancel_event_ajax() {
        $id = get_request('serverid');
        $date = get_request('date');
        logging::e("CANCELEVENT", "date : $date");
        
        $vacations = duty::get_one_vacation($id);
        logging::e("MAKEEVENT", "now vacations : $vacations");
        
        $vacations = json_decode($vacations);
        unset($vacations->$date);
        $vacations = json_encode($vacations);

        logging::e("MAKEEVENT", "update vacations : $vacations");
        $ret = duty::save_event($id, $vacations);
        return $ret ? 'success' : 'fail';
    }
    
    public function get_duty_ajax() {
        $id = get_request('id');
        $ret = duty::get_one_duty($id);
        return $ret ? array("ret" => "success", "info" => $ret) : array("ret" => "fail", "info" => "cannot get duty");
    }
    


}












