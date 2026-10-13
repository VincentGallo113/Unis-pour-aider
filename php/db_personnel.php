<?php
namespace ASBL;
require_once __DIR__ . '/db_link.inc.php';

use DB\DBLink;
use PDO;

class Personnels {
    public $pid, $prenom, $nom, $courriel,$mdp,$telephone, $photo,$description,$iddepartement,$isadmin;
}

class PersonnelsRepository
{
    public static function getAllEquipes(&$message)
    {
        $result = [];
        $bdd = null;
        $m = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $m);
            $result = $bdd->query("SELECT * FROM Personnel ORDER BY pid ",
                PDO::FETCH_CLASS,
                "ASBL\Personnels");
        } catch (\Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLINK::disconnect($bdd);
        return $result;
    }

    public static function getAllPersonnelByDept($IdDepartement, &$message){
        $personnels = [];
        $bdd = null;
        $message = "";

        try {
            $bdd = DBLINK::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT p.* FROM Personnel p 
                               WHERE p.IdDepartement = :idDepartement");
            $stmt->bindParam(':idDepartement', $IdDepartement, PDO::PARAM_INT);
            $stmt->execute();
            $personnels = $stmt->fetchAll(PDO::FETCH_CLASS, "ASBL\Personnels");
        } catch (\Exception $e) {
            $message = $e->getMessage() . '<br>';
        }

        DBLINK::disconnect($bdd);
        return $personnels;
    }

    public static function getPersonnelById(&$message, $personnel_id) {
        $bdd = null;
        $personnel = [];
        $message = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Personnel WHERE pid = :personnel_id");
            $stmt->bindParam(':personnel_id', $personnel_id, PDO::PARAM_INT);
            $stmt->execute();
            $personnel = $stmt->fetchObject("ASBL\Personnels");
        } catch (\Exception $e) {
            $message = $e->getMessage() . '<br>';
        }
        DBLINK::disconnect($bdd);
        return $personnel;
    }

    public static function personnelAndpasswordMatch($username, $password) {
        $message = "";
        $bdd = null;
        try {
            $bdd = DBLINK::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Personnel WHERE courriel = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $personnel = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($personnel && password_verify($password, $personnel['mdp'])) {
                return array(
                    'id' => $personnel['pid'],
                    'email' => $personnel['courriel'],
                    'correspond' => true
                );
            } else {
                return array('correspond' => false);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage() . '<br>';
            return array('correspond' => false);
        } finally {
            DBLINK::disconnect($bdd);
        }
    }
}