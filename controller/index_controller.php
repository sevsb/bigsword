<?php
include_once(dirname(__FILE__) . "/../app/config.php");
include_once(dirname(__FILE__) . "/../app/login.class.php");

class index_controller {

    public function index_action() {
        $tpl = new tpl("index/header", "index/footer");
        $salt = login::mksalt();

        $tpl->set("salt", $salt);
        $tpl->display("index/login");
    }

}













