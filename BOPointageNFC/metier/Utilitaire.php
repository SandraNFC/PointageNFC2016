<?php

include_once 'ConnectDB.php';
include_once 'GenUtil.php';

class Utilitaire {

    public static function getsequence($nomtable) {
        try {


            $connDB = new ConnectDB();
            $conn = $connDB->getConnect();
// 1� SQL ################################################
            $query = " select nextval('" . $nomtable . "') as nb ";

// 2� execute #############################################
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());


// Printing results in HTML

            $row = pg_fetch_assoc($result);

            pg_close($conn);

            return $row['nb'];
        } catch (Exception $e) {

            throw $e;
        }
    }

    public static function getIdBoutique($pseudo) {
        $u = new Utilisateur();
        $u->setPseudo($pseudo);

        $li = GenUtil::rechercher($u, NULL, NULL, '');

        return $li[0]->getIdboutique();
    }

}

?>