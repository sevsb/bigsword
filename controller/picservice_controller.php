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
        return $ret;
    }
    
    public function auth_token_go_action () {
        header("Access-Control-Allow-Origin: " . PICSERVICE_IP );
        $act = get_request("act");
        $tourl = get_request("tourl");
        logging::e("tourl", $tourl);
        if ($act == 'auth') {
            $token = picservice::get_token();
            $token = $token['token'];
            $tourl = urlencode($tourl);
            $url = PICSERVICE_URL . "?picservice/auth_token". "&token=$token&tourl=$tourl";
            logging::e("LINK TO", $url);
            header("Location: " .$url);
            return;
        }
        
        if ($act == 'authret') {
            $ret = get_request("ret");
            if ($ret == 'success') {
                logging::e("tourl", $tourl);
                header("Location: " .$tourl);
            } else if($ret == 'fail'){
                logging::e("Auth token fail", "now refresh token from code & host");
                $code = picservice::get_code();
                $code = $code["value"];
                $host = $_SERVER['REQUEST_SCHEME'] . "://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $host = explode('?',$host);
                $host = $host[0];
                logging::e("fileget",PICSERVICE_URL . "/ajax.php?action=picservice.request_token&code=$code&host=$host");
                $ret = file_get_contents(PICSERVICE_URL . "/ajax.php?action=picservice.request_token&code=$code&host=$host");
                $ret = json_decode($ret);
                logging::e("fileget ret :", $ret);
                if ($ret->ret == 'failed') {
                    echo "picservice_token 校验失败！";
                    return;
                }
                $token = $ret->token;
                $expired = $ret->expired;
                $sa_ret = picservice::save_token($token, $expired);
                if ($sa_ret){
                    $tourl = urlencode($tourl);
                    $url = "?picservice/auth_token_go&act=auth&tourl=$tourl";
                    logging::e("LINK TO", $url);
                    header("Location: " . $url);
                    return;
                }
                echo "token 存储失败";
                return;
            }
        }
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













