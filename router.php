<?php
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (preg_match('~(?:^|/)(?:data|php|inc|\.idea)(?:/|$)|\.(?:sql|sqlite|db|md|txt|zip)$~i', $path)) {
    http_response_code(403); exit('Accès interdit.');
}
return false;
