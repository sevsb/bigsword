<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class main_controller {

    public function main_action() {
        $tpl = new tpl("main/header", "main/footer");
        $tpl->display("main/main");
    }
    
    public function serve_index_action() {
        $tpl = new tpl("main/header", "main/footer");
        $tpl->display("service_item/index");
    }
    
    public function new_serve_action() {
        $tpl = new tpl("main/header", "main/footer");
        $tpl->display("service_item/new");
    }

}













