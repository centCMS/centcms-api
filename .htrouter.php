<?php
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
if ($uri !== '/' && is_file($_SERVER['DOCUMENT_ROOT'] . $uri)) {
    return false;
}
if(in_array(pathinfo($uri, PATHINFO_EXTENSION), [
    "ico", "jpeg", "jpg", "png", "gif", "svg", "css", "js", 
    "woff", "woff2", "eot", "ttf", "json", ".map",
])) {
    return false;
}
require $_SERVER['DOCUMENT_ROOT'] . '/index.php';