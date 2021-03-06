<?php
include_once(dirname(__FILE__) . "/config.php");

class settings {
    private static $instance = null;
    public static function instance() {
        if (self::$instance == null)
            self::$instance = new settings();
        return self::$instance;
    }

    private $configs = array();
    private $event_settings = array();
    
    private function __construct() {
        $configs = db_settings::inst()->load_all();
        foreach ($configs as $config) {
            $key = $config["name"];
            $this->configs[$key] = $config;
        }
    }

    public function load($key, $def = null) {
        return isset($this->configs[$key]) ? $this->configs[$key]["value"] : $def;
    }

    public function save($key, $val) {
        $id = db_settings::inst()->save($key, $val);
        if ($id !== false) {
            $this->configs[$key] = array("id" => $id, "name" => $key, "value" => $val);
        }
        return $id;
    }

    public function get_all() {
        return $this->configs;
    }
    
//----------------------EVENT-SETTINGS----------------------------------------------    
    
    public function get_work_hours() {
        $configs = $this->configs;
        $work_hours = $this->load("work_hours") == '' ? '9,19' : $this->load("work_hours");
        logging::d("work_hours", $work_hours);
        $work_hours = explode("," ,$work_hours);
        return array('start' => $work_hours[0], 'end' => $work_hours[1]);
    }
    
    
    public static function event_settings() {
        return db_settings::inst()->load_event_settings();
        
    }
    
    public function add_event_setting($title, $color, $type) {
        return db_settings::inst()->add_event_setting($title, $color, $type);
    }
    
    public function update_event_setting($id, $title, $color, $type) {
        return db_settings::inst()->update_event_setting($id, $title, $color, $type);
    }
    
    public function event_vacations() {
        $event_settings = db_settings::inst()->load_event_settings();
        $event_vacations = array();
        foreach ($event_settings as $setting) {
            if($setting['code'] > 0) {
                $event_vacations[$setting['id']] = $setting;
            }
        }
        return $event_vacations;
    }
    
    public function event_ovetimes() {
        $event_settings = db_settings::inst()->load_event_settings();
        $event_ovetimes = array();
        foreach ($event_settings as $setting) {
            if($setting['code'] < 0) {
                $event_ovetimes[$setting['id']] = $setting;
            }
        }
        return $event_ovetimes;
    }
    
    
};


