<?php

class ConnectDB {

    public function getConnect() {

        $user = 'root';
        $pass = '';
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        try {
            $dbconn = new PDO('mysql:host=localhost;dbname=nfcpointage', $user, $pass, $options); //
            if ($dbconn == null)
                echo 'NOT OK';
            // else echo ' OK ';
            return $dbconn;
            //echo 'connexion '+$dbconn;
        } catch (PDOException $pdoe) {
            echo 'PDO EXCEPTION ' . $pdoe->getMessage();
        } catch (Exception $ex) {
            echo " erreur lors de la connexion " . $ex->getMessage();
        }
    }

}

?>
