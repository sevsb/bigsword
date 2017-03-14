<?php
include_once(dirname(__FILE__) . "/../app/config.php");

class system_controller {
    
    public function preaction($action) {
        login::assert();
    }

    public function duty_event_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $event_settings = settings::event_settings();
        $tpl->set('event_settings', $event_settings);
        $tpl->display("system/duty_event_setting");
    }
    
    public function personal_config_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $userid = get_session('user.id');
        $user = user::create($userid);
        $tpl->set('userid', $userid);
        $tpl->set('user', $user);
        $tpl->display("system/personal_config");
    }
    
    public function work_hours_setting_action() {
        $tpl = new tpl("admin/header", "admin/footer");
        $work_hours = settings::instance()->get_work_hours();
        $tpl->set('start_hour', $work_hours['start']);
        $tpl->set('end_hour', $work_hours['end']);
        $tpl->display("system/work_hours_setting");
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
    
    public function update_config_ajax() {
        $id = get_request('id');
        $nick = get_request('nick');
        $face = get_request('face');
        $filename = null;
        if (substr($face, 0, 5) == "data:") {
            $ret = uploadImageViaFileReader($face, function($filename) {
                return $filename;
            });
            logging::e("uploadImage-ret", $ret);
            if (strncmp($ret, "fail|", 5) == 0) {
                return $ret;
            }
            $filename = $ret;
        }else {
            $filename = explode('/', $face);
            $filename = end($filename);
        }
        //logging::e('UPDATE_CONFIG', "$id");
        //logging::e('UPDATE_CONFIG', "$filename");
        //logging::e('UPDATE_CONFIG', "$nick");
        $ret = db_user::inst()->update_detail($id, $nick, $filename);
        $_SESSION["user.name"] = $nick;
        return ($ret !== false) ? "success" : "fail|数据库操作失败，请稍后重试。";
    }
    
    public function set_work_hours_ajax() {
        $start = get_request('start');
        $end = get_request('end');
        $work_hours = $start . "," . $end;
        $ret = settings::instance()->save('work_hours', $work_hours);
        return ($ret !== false) ? "success" : "fail|数据库操作失败，请稍后重试。";
    }

}













