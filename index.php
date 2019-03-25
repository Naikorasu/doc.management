<?php
/**
 * Created by PhpStorm.
 * User: naikorasu
 * Date: 25/03/19
 * Time: 13.27
 */

header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, X-Requested-With, Origin, Authorization');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Credentials: true');


$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
