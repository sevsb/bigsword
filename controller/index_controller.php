<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class index_controller {

    public function index_action() {
        $tpl = new tpl("index/header", "index/footer");
        $tpl->display("index/index");
    }

}













