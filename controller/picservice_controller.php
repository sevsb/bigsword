<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class picservice_controller {

    public function update_code_ajax() {
        header("Access-Control-Allow-Origin: " . PICSERVICE_IP );
        $code = get_request('code');
        $ret = picservice::update_code($code);
        return $ret;
    }
    
    public function get_code_ajax() {
        $ret = picservice::get_code();
        return array("ret" => "success", "info" =>$ret);
    }
    
    public function request_token_action() {
        $filename = get_request("filename");
        $ret = picservice::get_code();
        $code = $ret['value'];
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $host = $url[0];
        $host = urlencode($host);
        $ret = file_get_contents(PICSERVICE_URL . "ajax.php?action=picservice.request_token&host=$host&code=$code");
        $ret = json_decode($ret);
        if($ret->ret == 'fail'){
            logging::e("TOKEN", "token request failed: reason:" . $ret->reason);
            return;
        }else if ($ret->ret == 'success') {
            $expired = $ret->expired;
            $token = $ret->token;
            $ret = picservice::save_token($token, $expired);
            if (!$ret) {
                logging::e("TOKEN", "token save failed:" . $ret);
                return false;
            }else {
                $url = PICSERVICE_URL . "?picservice/show&filename=$filename&token=$token&redirecturl=$host";
                header("Location:" . $url);
            }
        }

        //return array("ret" => "success", "info" =>$ret);
    }
    
    public function get_pic_url_ajax() {
        return array("ret" => "success", "info" =>PICSERVICE_URL);
    }
   
    public function get_token_ajax() {
        $ret = picservice::get_token();
        return array("ret" => "success", "info" =>$ret);
    }
    
    public function save_token_ajax() {
       
        $token = get_request('token');
        $expired = get_request('expired');
        $ret = picservice::save_token($token, $expired);
        return $ret ? array("ret" => "success") : array("ret" => "fail", "reason" => "save_token_fail");
    }
    
}








