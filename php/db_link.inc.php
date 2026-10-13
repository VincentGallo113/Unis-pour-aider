<?php
namespace DB;
require_once __DIR__ . '/config.inc.php';
use PDO;

class DBLink {
    public static function connect2db($base, &$message) {
        if (!in_array('sqlite', PDO::getAvailableDrivers(), true)) {
            throw new \RuntimeException('Activez les extensions pdo_sqlite et sqlite3 de PHP (voir README.md).');
        }
        $directory = dirname($base);
        if (!is_dir($directory) && !mkdir($directory, 0700, true) && !is_dir($directory)) {
            throw new \RuntimeException('Impossible de créer le dossier de la base locale.');
        }
        $link = new PDO('sqlite:' . $base, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CASE => PDO::CASE_LOWER,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $link->exec('PRAGMA busy_timeout = 5000');
        $link->exec('PRAGMA foreign_keys = ON');
        // Transaction : un premier lancement interrompu sera repris proprement.
        $link->exec('BEGIN IMMEDIATE');
        try {
            if (!$link->query("SELECT name FROM sqlite_master WHERE type = 'table' AND name = 'Personnel'")->fetchColumn()) {
                $link->exec(file_get_contents(dirname(__DIR__) . '/bd.sql'));
                $hash = password_hash('Portfolio2026!', PASSWORD_DEFAULT);
                $stmt = $link->prepare('UPDATE Personnel SET mdp = ? WHERE pid = 81');
                $stmt->execute([$hash]);
                $stmt = $link->prepare('UPDATE Personnel SET mdp = ? WHERE pid != 81');
                $stmt->execute([password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT)]);
            }
            $link->exec('COMMIT');
        } catch (\Throwable $e) {
            $link->exec('ROLLBACK');
            throw $e;
        }
        return $link;
    }
    public static function disconnect(&$link) { $link = null; }
}
