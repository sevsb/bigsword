<?php
include_once(dirname(__FILE__) . "/config.php");

class book {
    private $summary = array();
    private $attr = array();

    public function __construct($data = array()) {
        $this->summary = $data;
    }

    public static function create($bookid = 0) {
        $book = db_book::inst()->get_book($bookid);
        return new book($book);
    }

    public static function load_all_books() {
        $books = array();
        $r = db_book::inst()->get_all_books();
        foreach ($r as $bookid => $book) {
            $books[$bookid] = new book($book);
        }
        return $books;
    }

    public function attr($name, $value = null) {
        if ($value === null) {
            $this->attr[$name] = $value;
        }
        return $this->attr[$name];
    }

    private function summary($key, $def = "") {
        if (isset($this->summary[$key])) {
            return $this->summary[$key];
        }
        return $def;
    }

    public function id() {
        return $this->summary("id", 0);
    }

    public function author() {
        return $this->summary("author");
    }

    public function owner() {
        return $this->summary("owner");
    }

    public function title() {
        return $this->summary("title");
    }

    public function pages() {
        return $this->summary("pages");
    }

    public function article() {
        return $this->summary("article");
    }

    public function face() {
        return $this->summary("face");
    }

    public function faceurl($full = false) {
        $url = rtrim(UPLOAD_URL, "/") . "/" . $this->summary("face");
        if ($full) {
            $url = mk_domain_url($url);
        }
        return $url;
    }

    public function face_thumbnail($full = false) {
        $url = mkUploadThumbnail($this->summary("face"), 0, 500);
        if ($full) {
            $url = mk_domain_url($url);
        }
        return $url;
    }

    public function face_content() {
        $path = rtrim(UPLOAD_DIR, "/") . "/" . $this->summary("face");
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $content = file_get_contents($path);
        $content = base64_encode($content);
        $content = "data:image/$extension;base64,$content";
        return $content;
    }

    public function status() {
        return $this->summary("status", db_book::STATUS_MAINTAIN);
    }

    public function status_text() {
        $status_table = array(
            db_book::STATUS_MAINTAIN => "维护中",
            db_book::STATUS_KEEP => "正常",
            db_book::STATUS_LENDED => "借出",
            db_book::STATUS_MISSING => "丢失",
            db_book::STATUS_RETURNED => "归还",
            db_book::STATUS_BORROWING => "预约",
        );
        return $status_table[$this->status()];
    }

    public function keeper() {
        if ($this->status() == db_book::STATUS_RETURNED) {
            return user::create_owner_user($this->owner());
            // return array("id" => 0, "nick" => $this->owner(), "email" => " 图书所有者 ", "face" => "images/favicon.ico", 
            //     "facethumbnail" => INSTANCE_URL . "/images/favicon.ico",
            //     "facethumbnailfull" => "http://{$SERVER["HTTP_HOST"]}/" . INSTANCE_URL . "/images/favicon.ico"
            // );
        }

        $id = db_borrow::inst()->keeper($this->id());
        return user::create($id);
        // $users = db_user::inst()->get_all_users();
        // if (isset($users[$id])) {
        //     $users[$id]["facethumbnail"] = mkUploadThumbnail($users[$id]["face"], 100, 100);
        //     $users[$id]["facethumbnailfull"] = "http://{$_SERVER["HTTP_HOST"]}/" . mkUploadThumbnail($users[$id]["face"], 100, 100);
        //     return $users[$id];
        // }
        // return array("id" => 0, "nick" => "图书馆", "email" => settings::instance()->load("admin_email", ""), "face" => "images/favicon.ico", 
        //     "facethumbnail" => INSTANCE_URL . "/images/favicon.ico",
        //     "facethumbnailfull" => "http://{$SERVER["HTTP_HOST"]}/" . INSTANCE_URL . "/images/favicon.ico"
        // );
    }

    public function orderers() {
        if ($this->status() != db_book::STATUS_BORROWING) {
            return array();
        }
        $orders = db_order::inst()->get_orders($this->id());
        $users = user::load_all_users();
        $librarian = user::create_library_user();

        $r = array();
        foreach ($orders as $key => $o) {
            $r [$key]= isset($users[$o["userid"]]) ? $users[$o["userid"]] : $librarian;
            // $face = $o["userface"];
            // $orders[$key]["userfacethumbnail"] = mkUploadThumbnail($face, 100, 100);
        }
        return $r;
    }

    public function history() {
        // $library_user = array("id" => 0, "nick" => "图书馆", "email" => settings::instance()->load("admin_email", ""), "face" => "images/favicon.ico", "facethumbnail" => INSTANCE_URL . "/images/favicon.ico");

        $histories = db_borrow::inst()->history($this->id());
        $users = user::load_all_users();

        // $users = db_user::inst()->get_all_users();
        // foreach ($users as $id => $user) {
        //     $users[$id]["facethumbnail"] = mkUploadThumbnail($user["face"], 100, 100);
        // }

        foreach ($histories as $id => $history) {
            $lenderid = $history["lender"];
            $loanerid = $history["loaner"];
            $time = $history["time"];
            $time = date("Y-m-d H:i:s", $time);
            $lender = $users[$lenderid]; // isset($users[$lenderid]) ? $users[$lenderid] : $library_user;
            $loaner = $users[$loanerid]; // isset($users[$loanerid]) ? $users[$loanerid] : $library_user;
            $histories[$id]["lender"] = $lender;
            $histories[$id]["loaner"] = $loaner;
            $histories[$id]["time"] = $time;
        }
        return $histories;
    }


    public function last_history() {
        $history = db_borrow::inst()->last_history($this->id());
        if (empty($history)) {
            return null;
        }

        if ($this->status() == db_book::STATUS_RETURNED) {
            return null;
        }

        $users = user::load_all_users();
        $lender = $history["lender"];
        $loaner = $history["loaner"];
        $time = $history["time"];
        $history["period"] = time() - $time;
        $history["format_period"] = format_period($time);
        $history["lender"] = $users[$lender];
        $history["loaner"] = $users[$loaner];
        $history["time"] = date("Y-m-d H:i:s", $time);
        $history["book"] = $this;
        return $history;
    }

    public function borrow_count() {
        return db_borrow::inst()->borrow_count($this->id());
    }

    public function is_watching() {
        $userid = get_session("user.id");
        $r = db_watch::inst()->get_watchers($this->id());
        foreach ($r as $w) {
            if ($w["userid"] == $userid)
                return true;
        }
        return false;
    }

    public function watchers() {
        $r = db_watch::inst()->get_watchers($this->id());
        $users = user::load_all_users();

        // $library_user = array("id" => 0, "nick" => "图书馆", "email" => settings::instance()->load("admin_email", ""), "face" => "images/favicon.ico", "facethumbnail" => INSTANCE_URL . "/images/favicon.ico");
        // $users = db_user::inst()->get_all_users();
        // foreach ($users as $id => $user) {
        //     $users[$id]["facethumbnail"] = mkUploadThumbnail($user["face"], 100, 100);
        //     $users[$id]["facethumbnailfull"] = "http://{$_SERVER["HTTP_HOST"]}/" . mkUploadThumbnail($user["face"], 100, 100);
        // }

        $watchers = array();
        foreach ($r as $w) {
            $watchers []= $users[$w["userid"]];
        }
        return $watchers;
    }
};


