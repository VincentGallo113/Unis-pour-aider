<?php
namespace ASBL;
require_once __DIR__ . '/db_link.inc.php';

use DB\DBLink;
use PDO;

class User {
    public $user_id, $username, $password, $personnel_id;
}

class userRepository
{
    public static function getAllUsers(&$message) {
        $result = [];
        $bdd = null;
        $m = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $m);
            $result = $bdd->query("SELECT * FROM Utilisateurs",
                PDO::FETCH_CLASS,
                "ASBL\User");
        } catch (\Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLINK::disconnect($bdd);
        return $result;
    }

    public static function userAndpasswordMatch($username, $password) {
        $message = "";
        $users = self::getAllUsers($message);

        if ($users) {
            foreach ($users as $user) {
                if ($user->username === $username) {
                    if (password_verify($password, $user->password)) {
                        return array(
                            'id' => $user->user_id,
                            'email' => $user->username,
                            'correspond' => true
                        );
                    } else {
                        return array('correspond' => false);
                    }
                }
            }
        }
        return array('correspond' => false);

    }

}