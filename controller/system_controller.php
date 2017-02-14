<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class system_controller {

    public function duty_event_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $event_settings = settings::event_settings();
        $tpl->set('event_settings', $event_settings);
        $tpl->display("system/duty_event_setting");
    }
    
    public function new_event_setting_ajax() {
        $title = get_request('title');
        $color = get_request('color');
        $type = get_request('type');
        
        $ret = settings::instance()->add_event_setting($title, $color, $type);
        return $ret ? 'success' : 'fail';
    }
    
    public function update_event_settings_ajax() {
        $settings = get_request('settings');
        
        foreach ($settings as $setting) {
            $id = $setting["id"];
            $title = $setting["title"];
            $color = $setting["color"];
            $type = $setting["type"];
            $ret = settings::instance()->update_event_setting($id, $title, $color, $type);
            if (!$ret) {
                return 'fail';
            }
        }
        return 'success';
    }

 


}













