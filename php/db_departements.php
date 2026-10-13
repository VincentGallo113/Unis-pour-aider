<?php
namespace ASBL;
require_once __DIR__ . '/db_link.inc.php';

use DB\DBLink;
use PDO;

class Departement {
    public $did, $departement, $nbmembres;
}

class DepartementRepository
{
    public static function getAllDepartement(&$message)
    {
        $result = [];
        $bdd = null;
        $message = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $message);
            $result = $bdd->query("SELECT d.*, COUNT(p.IdDepartement) AS nbmembres
                                        FROM Departements d
                                        LEFT JOIN Personnel p ON d.did = p.IdDepartement
                                        GROUP BY d.did",
                PDO::FETCH_CLASS,
                "ASBL\Departement");
        } catch (\Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLINK::disconnect($bdd);
        return $result;
    }

    public static function deleteDept($id, &$message) {
        $bdd = null;
        $message = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("DELETE FROM Departements WHERE did = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $message = "Le département a été supprimé avec succès.";
        } catch (\Exception $e) {
            $message = $e->getMessage() . '<br>';
        }
        DBLINK::disconnect($bdd);
        return $message;
    }
    public static function getDepartementById($id, &$message) {
        $departement = null;
        $bdd = null;
        $message = "";

        try {
            $bdd = DBLINK::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("SELECT * FROM Departements WHERE did = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $departement = $stmt->fetchObject("ASBL\Departement");
        } catch (\Exception $e) {
            $message = $e->getMessage() . '<br>';
        }

        DBLINK::disconnect($bdd);
        return $departement;
    }

    public static function updateDepartementName($id, $nouveauNomDept, &$message)
    {
        $bdd = null;
        $message = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $message);
            $stmt = $bdd->prepare("UPDATE Departements SET departement = :nouveauNomDept WHERE did = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nouveauNomDept', $nouveauNomDept, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (\Exception $e) {
            return false;
        } finally {
            DBLINK::disconnect($bdd);
        }
    }
}