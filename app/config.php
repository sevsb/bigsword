<?php

if (file_exists(dirname(__FILE__) . "/../../PATH.php")) {
    include_once(dirname(__FILE__) . "/../../PATH.php");
}

include_once(dirname(__FILE__) . "/../../framework/config.php");
include_once(dirname(__FILE__) . "/database/db_user.class.php");
include_once(dirname(__FILE__) . "/database/db_settings.class.php");
include_once(dirname(__FILE__) . "/database/db_picservice.class.php");
include_once(dirname(__FILE__) . "/database/db_service_item.class.php");
include_once(dirname(__FILE__) . "/database/db_servers.class.php");
include_once(dirname(__FILE__) . "/database/db_duty.class.php");
include_once(dirname(__FILE__) . "/user.class.php");
include_once(dirname(__FILE__) . "/upload.php");
include_once(dirname(__FILE__) . "/thumbnail.php");
include_once(dirname(__FILE__) . "/mailer.class.php");
include_once(dirname(__FILE__) . "/settings.class.php");
include_once(dirname(__FILE__) . "/picservice.class.php");
include_once(dirname(__FILE__) . "/service_item.class.php");
include_once(dirname(__FILE__) . "/servers.class.php");
include_once(dirname(__FILE__) . "/duty.class.php");
include_once(FRAMEWORK_PATH . "/helper.php");
include_once(FRAMEWORK_PATH . "/logging.php");
include_once(FRAMEWORK_PATH . "/tpl.php");


defined('UPLOAD_DIR') or define('UPLOAD_DIR', ROOT_PATH . '/upload/images');
defined('UPLOAD_URL') or define('UPLOAD_URL', rtrim(INSTANCE_URL, "/") . '/upload/images');
defined('THUMBNAIL_DIR') or define('THUMBNAIL_DIR', ROOT_PATH . '/upload/thumbnails');
defined('THUMBNAIL_URL') or define('THUMBNAIL_URL', rtrim(INSTANCE_URL, "/") . '/upload/thumbnails');
defined('UPLOAD_LIMIT') or define('UPLOAD_LIMIT', 10 * 1024 * 1024);
defined('PICSERVICE_IP') or define('PICSERVICE_IP', "http://180.76.160.113");
defined('PICSERVICE_URL') or define('PICSERVICE_URL', "http://180.76.160.113/picservice/");
//defined('PICSERVICE_IP') or define('PICSERVICE_IP', "http://127.0.0.1");
//defined('PICSERVICE_URL') or define('PICSERVICE_URL', "http://127.0.0.1/picservice/");


// security
defined('ALLOW_ROOT') or define('ALLOW_ROOT', true);

// database
defined('MYSQL_SERVER') or define('MYSQL_SERVER', '180.76.188.68');
defined('MYSQL_USERNAME') or define('MYSQL_USERNAME', 'bigsword');
defined('MYSQL_PASSWORD') or define('MYSQL_PASSWORD', 'bigsword');
defined('MYSQL_DATABASE') or define('MYSQL_DATABASE', 'bigsword');
defined('MYSQL_PREFIX') or define('MYSQL_PREFIX', 'bigsword_');


// db_settings
defined('TABLE_SETTINGS') or define('TABLE_SETTINGS', MYSQL_PREFIX . "settings");

// db_user
defined('TABLE_USERS') or define('TABLE_USERS', MYSQL_PREFIX . "users");
defined('TABLE_USERSETTINGS') or define('TABLE_USERSETTINGS', MYSQL_PREFIX . "user_settings");
defined('TABLE_USER_GROUPS') or define('TABLE_USER_GROUPS', MYSQL_PREFIX . "user_groups");

// mailer
defined('MAIL_SUBJECT_PREFIX') or define('MAIL_SUBJECT_PREFIX', '');

// service_items
defined('TABLE_SERVICE_ITEMS') or define('TABLE_SERVICE_ITEMS', MYSQL_PREFIX . "service_items");
// servers
defined('TABLE_SERVERS') or define('TABLE_SERVERS', MYSQL_PREFIX . "servers");
// duty
defined('TABLE_DUTY') or define('TABLE_DUTY', MYSQL_PREFIX . "duty");
// customers
defined('TABLE_CUSTOMERS') or define('TABLE_CUSTOMERS', MYSQL_PREFIX . "customers");
