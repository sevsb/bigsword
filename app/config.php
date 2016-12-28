<?php

if (file_exists(dirname(__FILE__) . "/../../PATH.php")) {
    include_once(dirname(__FILE__) . "/../../PATH.php");
}

include_once(dirname(__FILE__) . "/../../framework/config.php");
include_once(dirname(__FILE__) . "/database/db_user.class.php");
include_once(dirname(__FILE__) . "/database/db_settings.class.php");
include_once(dirname(__FILE__) . "/user.class.php");
include_once(dirname(__FILE__) . "/upload.php");
include_once(dirname(__FILE__) . "/thumbnail.php");
include_once(dirname(__FILE__) . "/mailer.class.php");
include_once(dirname(__FILE__) . "/settings.class.php");
include_once(FRAMEWORK_PATH . "/helper.php");
include_once(FRAMEWORK_PATH . "/logging.php");
include_once(FRAMEWORK_PATH . "/tpl.php");


defined('UPLOAD_DIR') or define('UPLOAD_DIR', ROOT_PATH . '/upload/images');
defined('UPLOAD_URL') or define('UPLOAD_URL', rtrim(INSTANCE_URL, "/") . '/upload/images');
defined('THUMBNAIL_DIR') or define('THUMBNAIL_DIR', ROOT_PATH . '/upload/thumbnails');
defined('THUMBNAIL_URL') or define('THUMBNAIL_URL', rtrim(INSTANCE_URL, "/") . '/upload/thumbnails');
defined('UPLOAD_LIMIT') or define('UPLOAD_LIMIT', 10 * 1024 * 1024);


// security
defined('ALLOW_ROOT') or define('ALLOW_ROOT', true);

// database
defined('MYSQL_SERVER') or define('MYSQL_SERVER', 'localhost');
defined('MYSQL_USERNAME') or define('MYSQL_USERNAME', 'comacc');
defined('MYSQL_PASSWORD') or define('MYSQL_PASSWORD', 'comacc');
defined('MYSQL_DATABASE') or define('MYSQL_DATABASE', 'comacc');
defined('MYSQL_PREFIX') or define('MYSQL_PREFIX', 'common_');


// db_book
defined('TABLE_USERS') or define('TABLE_USERS', MYSQL_PREFIX . "users");
defined('TABLE_SETTINGS') or define('TABLE_SETTINGS', MYSQL_PREFIX . "settings");
defined('TABLE_USERSETTINGS') or define('TABLE_USERSETTINGS', MYSQL_PREFIX . "user_settings");

// mailer
defined('MAIL_SUBJECT_PREFIX') or define('MAIL_SUBJECT_PREFIX', '');












