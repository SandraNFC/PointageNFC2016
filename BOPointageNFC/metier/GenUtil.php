<?php

include_once './metier/MapTable.php';
include_once './metier/UtilitaireMapping.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GenUtil
 *
 * @author tiana
 */
class GenUtil {

    public static function rechercher($obj, $listeCol, $listeVal, $apreswhere) {
        $result;
        try {
            $connDB = new ConnectDB();
            $conn = $connDB->getConnect();

            $result = GenUtil::rechercherWithConnection($conn, $obj, $listeCol, $listeVal, $apreswhere);
            pg_close($conn);

            return $result;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function rechercherWithConnection($connection, $obj, $listeCol, $listeVal, $apreswhere) {
        try {


            $ret = null;
            $nomClasse = get_class($obj);
            $classe = new ReflectionClass($nomClasse);

            // 1°/ ================================== sql recherche 
            $sql = UtilitaireMapping::makeSqlRecherche($obj, $listeCol, $listeVal, $apreswhere);
            echo '</br> sql ============' . $sql;


            // 2°/ ============ prepare $sql

            pg_prepare($connection, 'my_query', $sql);

            // 3°/ ============ make $temp

            $temp = array();
            $c = 0;

            $champ = UtilitaireMapping::getDeclaredFields($nomClasse);
            $nb = count($champ);



            // 1°  dans listeCol numeric ou daty  == champ dans une intervalle "<" ou ">" ou  =  "> <" 
            if ($listeCol != null) {
                for ($i = 0; $i < count($listeCol); $i++) {

                    /// $where = $where." and ".$listeCol[$i]." = ";  
                    $t = 2 * $i;

                    // test date ou chiffre simple
                    if ($listeVal[$t] === null && $listeVal[$t + 1] === null) {
                        continue;
                    }


                    //  chiffre ou date ===============
                    if (($listeVal[$t] !== null && is_numeric($listeVal[$t]) ) || ($listeVal[$t + 1] !== null && is_numeric($listeVal[$t + 1]))) {

                        $min = $listeVal[$t];
                        $max = $listeVal[$t + 1];
                    } else {
                        $min = "'" . $listeVal[$t] . "'";
                        $max = "'" . $listeVal[$t + 1] . "'";
                    }


                    //  constitution de la requette chiffre ou date ===============

                    if ($listeVal[$t] !== null && $listeVal[$t + 1] === null) {
                        $temp[$c] = $min;
                        echo "</br>  temp " . $c . "  == " . $temp[$c];
                        $c++;
                    } else if ($listeVal[$t] === null && $listeVal[$t + 1] !== null) {
                        $temp[$c] = $max;
                        echo "</br>  temp " . $c . "  == " . $temp[$c];

                        $c++;
                    } else {
                        //$where = $where." and ".$listeCol[$i]." >= ".$min." and ".$listeCol[$i]." <= ".$max; 
                        $temp[$c] = $min;
                        echo "</br>  temp " . $c . "  == " . $temp[$c];
                        $c++;
                        $temp[$c] = $max;
                        echo "</br>  temp " . $c . "  == " . $temp[$c];
                        $c++;
                    }
                }
            }


            // 2° autre que listeCol
            // => exite (null ou nom une $val)   

            $i;
            for ($i = 0; $i < $nb; $i++) {

                // si champ intervalle (chiffre) continuer
                if ($listeCol != null && in_array($champ[$i]->name, $listeCol))
                    continue;

                //   === setter la valeur recu
                $val = UtilitaireMapping::getFieldValue($obj, $champ[$i]->name);


                if ($val === null)
                    continue;

                // test id numeric ou string
                if (is_numeric($val)) {
                    //$where = $where." and ".$champ[$i]->name." = ".$val."";
                    $temp[$c] = $val;
                    echo "</br>  temp " . $c . "  == " . $temp[$c];
                    $c++;
                } else {
                    //$where = $where." and ".$champ[$i]->name." like '".$val."'";
                    $temp[$c] = $val;
                    echo "</br>  temp " . $c . "  == " . $temp[$c];
                    $c++;
                    $temp[$c] = strtoupper($val);
                    echo "</br>  temp " . $c . "  == " . $temp[$c];
                    $c++;
                }
            }



            // 4°/ ============ execute $sql
            //  print_r($temp);
            // ================================== execute

            $result = pg_execute($connection, 'my_query', $temp);


            if (!$result) {
                throw new Exception(" requette invalide  ");
            }


            $k = 0;
            // ========================  setter tous les champs recuperés

            $i = 0;
            while ($row = pg_fetch_assoc($result)) {   // tetezina ny result
                // echo " ato ====="; 
                $ret[$k] = $classe->newInstance(null);
                for ($i = 0; $i < $nb; $i++) {

                    $temp = $row[$champ[$i]->name];
                    // echo "champ ==".$champ[$i]->name." valeur ===  ".$temp."</br>";  



                    try {

                        UtilitaireMapping::setFieldValue($ret[$k], $champ[$i]->name, $temp);
                    } catch (Exception $ex) {
                        continue;
                    }
                }
                /*
                  echo ' APRES ######################';
                  echo ' id ========'.$ret[$k]->getIdBoutique();
                  echo '</br>';
                  echo ' nom ========'.$ret[$k]->getNom();
                  echo '</br>';
                  echo ' numero ========'.$ret[$k]->getNumero();
                  echo '</br>';
                 */

                $k = $k + 1;
            }



            return $ret;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}

?>
