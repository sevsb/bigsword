<?php
include_once(dirname(__FILE__) . "/config.php");

class booking {

    public static function init_service_items_list() {
        $service_items_list = array();
        $staff_services = db_staff_services::inst()->load_all();
        foreach ($staff_services as $value) {
            $services = explode(',', $value['service_id']);
            foreach ($services as $service) {
                if(empty($service_items_list[$service])) {
                    $service_items_list[$service] = $value['staff_id'];
                } else {
                    $service_items_list[$service] .= ',' . $value['staff_id'];
                }
            }
        }
        return $service_items_list;
    }

    public static function init_staffs_list() {
        $staffs_list = array();
        $staff_services = db_staff_services::inst()->load_all();
        foreach ($staff_services as $value) {
            $staffs_list[$value['staff_id']] = $value['service_id'];
        }
        return $staffs_list;
    }

};


