<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
if (isset($_POST['disconnect'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/db_link.inc.php';
try {
    $startupMessage = '';
    $startupDatabase = \DB\DBLink::connect2db(MYDB, $startupMessage);
    \DB\DBLink::disconnect($startupDatabase);
} catch (\Exception $e) {
    http_response_code(500);
    exit('<h1>Configuration locale</h1><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p><p>Consultez README.md pour lancer le projet.</p>');
}
