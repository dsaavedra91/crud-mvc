<?php
class ViewLoader {
    private static $homeUrl;

    public static function initialize() {
        self::$homeUrl = self::getHomeUrl();
    }

    private static function getHomeUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
        $url = str_replace('index.php', '', $url);
        return $url;
    }

    public static function loadView($viewName, $data = array()) {
        if ($data) {
            extract($data);
        }
        $homeUrl = self::getHomeUrl();
        include getcwd() . '/partials/header.php';
        include getcwd() . "/views/$viewName.php";
        include getcwd() . '/partials/footer.php';
    }
}

ViewLoader::initialize();
