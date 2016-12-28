<?php

include_once("app/config.php");
include_once("app/login.php");
include_once("app/database.php");

class kind_controller {
    public function upload_ajax() {
        if (!isset($_FILES["imgFile"])) {
            return;
        }

        $save_path = rtrim(UPLOAD_DIR, "/") . "/";
        $save_url = rtrim(UPLOAD_URL, "/") . "/";


        if (isset($_FILES['imgFile']['error']) && $_FILES["imgFile"]["error"] != 0) {
            switch($_FILES['imgFile']['error']){
            case '1':
                $error = '超过php.ini允许的大小。';
                break;
            case '2':
                $error = '超过表单允许的大小。';
                break;
            case '3':
                $error = '图片只有部分被上传。';
                break;
            case '4':
                $error = '请选择图片。';
                break;
            case '6':
                $error = '找不到临时目录。';
                break;
            case '7':
                $error = '写文件到硬盘出错。';
                break;
            case '8':
                $error = 'File upload stopped by extension。';
                break;
            case '999':
            default:
                $error = '未知错误。';
            }
            return array("error" => 1, "message" => $error);
        }

        $file_name = $_FILES['imgFile']['name'];
        $tmp_name = $_FILES['imgFile']['tmp_name'];
        $file_size = $_FILES['imgFile']['size'];

        if (empty($file_name)) {
            return array("error" => 1, "message" => "请选择文件。");
        }

        if (!is_dir($save_path)) {
            $ret = mkdir($save_path, 0777, true);
            if (!$ret) {
                return array("error" => 1, "message" => "上传目录不存在。");
            }
        }

        if (!is_writable($save_path)) {
            return array("error" => 1, "message" => "上传目录没有写权限。");
        }

        if (!is_uploaded_file($tmp_name)) {
            return array("error" => 1, "message" => "上传失败。");
        }

        if ($file_size > UPLOAD_LIMIT) {
            return array("error" => 1, "message" => "上传文件大小超过限制。");
        }

        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
        if (!in_array($file_ext, $ext_arr)) {
            return array("error" => 1, "message" => "上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr) . "格式。");
        }

        $new_file_name = md5(file_get_contents($tmp_name)) . "." . $file_ext;

        $file_path = $save_path . $new_file_name;
        if (move_uploaded_file($tmp_name, $file_path) === false) {
            return array("error" => 1, "message" => "上传文件失败。");
        }
        chmod($file_path, 0644);

        $file_url = $save_url . $new_file_name;
        return array("error" => 0, "url" => $file_url);
    }

    public function file_manager_ajax() {

        $root_path = rtrim(UPLOAD_DIR, "/") . "/";
        $root_url = rtrim(UPLOAD_URL, "/") . "/"; 

        $ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

        $result = array();
        $result['moveup_dir_path'] = '';
        $result['current_dir_path'] = '';
        $result['current_url'] = $root_url;
        $result['total_count'] = 0;
        $result['file_list'] = array();


        $dir = opendir($root_path);
        if ($dir === false) {
            return $result;
        }

        $i = 0;
        $file_list = array();
        while (($filename = readdir($dir)) !== false) {
            if ($filename{0} == '.')
                continue;

            $file = $root_path . $filename;

            if (is_dir($file)) {
                continue;
            }
            $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (!in_array($file_ext, $ext_arr)) {
                continue;
            }

            $file_list[$i]['is_dir'] = false;
            $file_list[$i]['has_file'] = false;
            $file_list[$i]['filesize'] = filesize($file);
            $file_list[$i]['dir_path'] = '';
            $file_list[$i]['is_photo'] = true;
            $file_list[$i]['filetype'] = $file_ext;
            $file_list[$i]['filename'] = $filename;
            $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file));
            $i++;
        }
        closedir($dir);

        $result['total_count'] = count($file_list);
        $result['file_list'] = $file_list;

        logging::d("Kind", $result);
        return $result;
    }
}







