<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class picservice_controller {

    public function update_code_ajax() {
        $code = get_request('code');
        $ret = picservice::update_code($code);
        return $ret;
    }
    

}













