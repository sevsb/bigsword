<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class picservice_controller {

    public function update_code_ajax() {
        $code = get_request('code');
        $ret = picservice::update_code($code);
        return $ret;
    }
    
    public function get_code_ajax() {
        $ret = picservice::get_code();
        return $ret;
    }
    
    public function get_token_ajax() {
        $ret = picservice::get_token();
        return $ret;
    }
    
    public function save_token_ajax() {
        $token = get_request('token');
        $expired = get_request('expired');
        $ret = picservice::save_token($token, $expired);
        return $ret;
    }
    

}












