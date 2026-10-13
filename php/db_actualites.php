<?php
namespace ASBL;
require_once __DIR__ . '/db_link.inc.php';

use DB\DBLink;
use PDO;

class Actualite {
    public $aid, $date_actualite, $intitule, $image,$amorce,$actualite, $visible;
}

class ActualiteRepository {
    public static function getAllActualite(&$message, $tri){
        $result = [];
        $bdd = null;
        $m = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $m);
            $result = $bdd->query("SELECT * FROM Actualites ORDER BY aid ".($tri === "ASC" ? "ASC" : "DESC"),
                PDO::FETCH_CLASS,
                "ASBL\Actualite");
        }
        catch (\Exception $e) {
            $message.= $e->getMessage().'<br>';
        }
        DBLINK::disconnect($bdd);
        return $result;
    }
    public static function getMostRecentActualies(&$message){
        $result = [];
        $bdd = null;
        $m = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $m);
            $result = $bdd->query("SELECT * FROM Actualites ORDER BY aid DESC LIMIT 2",
                PDO::FETCH_CLASS,
                "ASBL\Actualite");
        }
        catch (\Exception $e) {
            $message.= $e->getMessage().'<br>';
        }
        DBLINK::disconnect($bdd);
        return $result;
    }
    public static function getRowCount(&$message) {
        $rowCount = 0;
        $bdd = null;
        $m = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $m);
            $result = $bdd->query("SELECT COUNT(*) AS total FROM Actualites");
            $rowCount = $result->fetchColumn(); // Récupérer la première colonne du résultat
        } catch (\Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLINK::disconnect($bdd);
        return $rowCount;
    }

    public static function newActualite(&$message, $id, $date, $intitule, $actualite) {
        $bdd = null;
        $m = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $m);
            $stmt = $bdd->prepare("INSERT INTO Actualites (date_actualite, intitule, image, amorce, actualite, visible) VALUES (?, ?, ?, ?, ?, 1)");
            $stmt->execute([$date, $intitule, "images/iconeArticle/iconeArticle.png", $intitule, $actualite]);
        } catch (\Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLINK::disconnect($bdd);
    }
    public static function searchInActualites(&$message, $search) {
        $result = [];
        $bdd = null;
        $m = "";
        try {
            $bdd = DBLINK::connect2db(MYDB, $m);

            // Utilisez une clause WHERE avec la fonction LIKE pour rechercher dans l'intitulé ou l'actualité
            $query = "SELECT * FROM Actualites WHERE intitule LIKE :search OR actualite LIKE :search ORDER BY aid DESC";
            $stmt = $bdd->prepare($query);
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_CLASS, "ASBL\Actualite");
        }
        catch (\Exception $e) {
            $message .= $e->getMessage() . '<br>';
        }
        DBLINK::disconnect($bdd);
        return $result;
    }
}