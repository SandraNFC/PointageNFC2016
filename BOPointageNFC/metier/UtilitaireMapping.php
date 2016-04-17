<?php

include_once 'MapTable.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class UtilitaireMapping {

    //put your code here
    // getDeclaredFields  ######################################################################


    public static function getDeclaredFields($nomClasse) {

        try {


            $retour = null;
            $class = new ReflectionClass($nomClasse);
            $list = $class->getProperties();

            $i = 0;
            for ($t = 0; $t < count($list); $t++) {

                if ($list[$t]->class == $class->name) {
                    $retour[$i] = $list[$t];
                    $i++;
                }
            }
            return $retour;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // isDate  ######################################################################


    public static function isDate($var) {
        if ($var == null || strlen($var) == 0)
            return false;

        $temp = null;
        try {
            $temp = new DateTime($var);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    // getFieldValue  ######################################################################


    public static function getFieldValue(Maptable $obj, $field) {
        try {

            // 1°/ nom methode
            $nomMeth = "get";
            $field[0] = strtoupper($field[0]);
            $nomMeth = $nomMeth . $field;
            //echo 'nom methode '.$nomMeth;
            //echo '<br>';
            // 2° get the method
            $nomClasse = get_class($obj);
            $classe = new ReflectionClass($nomClasse);
            $meth = $classe->getMethod($nomMeth);

            // echo 'METHODE    '.$meth->getName();
            // echo '<br>';
            //echo 'METHODE       '.$meth;

            $val = $meth->invoke($obj);
            // 3° invoker meth
            //$reflectionMethod = new ReflectionMethod($classe->getName(),$meth->getName());            
            //$val = $reflectionMethod->invoke($obj);
            // echo 'VAL   '.$val;

            return $val;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // setFieldValue  ######################################################################


    public static function setFieldValue(Maptable $obj, $field, $arg) {
        try {

            // 1°/ nom methode
            $nomMeth = "set";
            $field[0] = strtoupper($field[0]);
            $nomMeth = $nomMeth . $field;


            // 2° get the method
            $nomClasse = get_class($obj);
            $classe = new ReflectionClass($nomClasse);
            $meth = $classe->getMethod($nomMeth);


            // 3° invoker meth
            //echo "invocation de ".$meth->getName()." dans ".$classe->getName()."  ";


            $reflectionMethod = new ReflectionMethod($classe->getName(), $meth->getName());
            $reflectionMethod->invoke($obj, $arg);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // MAKE SQL INSERT ######################################################################

    public static function makeSQLInsert(MapTable $obj) {

        $sql = "";
        $sqlAvant = "";
        $sqlApres = "";
        $check = 0;
        try {
            // 0° nom table
            $classe = get_class($obj);
            $sqlAvant = "  insert into " . $obj->getNomTable();

            // 1° avoir les champs
            $champ = UtilitaireMapping::getDeclaredFields($classe);
            $nb = count($champ);
            // echo 'nombre ='.$nb;
            // 2° sql avant
            //$i;

            for ($i = 0; $i < $nb; $i++) {

                // "string et date null ou chiffre non setté" sera considéré comme null par le metier    
                if (UtilitaireMapping::getFieldValue($obj, $champ[$i]->name) === null)
                    continue;

                // car supposé etre chiffre , date ou null => string

                if ($i == 0) {
                    $sqlAvant = $sqlAvant . " ( " . $champ[$i]->name;
                    $check = 1;
                } else
                    $sqlAvant = $sqlAvant . " , " . $champ[$i]->name;
            }
            $sqlAvant = $sqlAvant . " ) values ";


            // 3° sql apres

            if ($check === 0)
                throw new Exception(" erreur dans make insert Sql objet invalide ");

            $k = 1;
            $l = 0;

            for ($l = 0; $l < $nb; $l++) {

                if (UtilitaireMapping::getFieldValue($obj, $champ[$l]->name) === null)
                    continue;

                //if($i!=0)
                // $temp = "$".$k;
                if ($l == 0)
                    $sqlApres = $sqlApres . " ( ?";
                else
                    $sqlApres = $sqlApres . " , ?";

                $k++;
            }


            $sqlApres = $sqlApres . " )";



            $sql = $sqlAvant . $sqlApres;

            // echo ' </br> REQUETE         '.$sql;



            return $sql;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // MAKE SQL UPDATE ######################################################################


    public static function makeSqlUpdate(MapTable $obj, $listeNull) {
        $sql = "";

        try {
            $classe = get_class($obj);
            $sql = " update " . $obj->getNomTable() . " set ";

            $champ = UtilitaireMapping::getDeclaredFields($classe);
            $nb = count($champ);



            //  set " x1 = <val1> , x2 = <val2> , x3 = <val3> "     
            $nomId = $obj->getIdName();
            $place = 0;


            $k = 1;
            for ($i = 0; $i < $nb; $i++) {


                // continue si champ Id
                if (strcmp($nomId, $champ[$i]->name) === 0)
                    continue;


                if ($listeNull !== null && in_array($champ[$i]->name, $listeNull)) {
                    if ($place > 0)
                        $sql = $sql . " , ";

                    $sql = $sql . " " . $champ[$i]->name . " = ?";
                    $k++;
                    $place++;
                    continue;
                }

                // get valeur champ
                $val = UtilitaireMapping::getFieldValue($obj, $champ[$i]->name);

                // passe si null
                if ($val === null)
                    continue;

                if ($place > 0)
                    $sql = $sql . " , ";

                $sql = $sql . " " . $champ[$i]->name . " = ?";
                $k++;

                $place++;
            }


            // where <nomId> = <valeurId>

            $sql = $sql . "  where " . $nomId . " = ?";


            return $sql;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // makeSqlDelete ######################################################################


    public static function makeSqlDelete(MapTable $obj) {
        $sql = "";

        try {

            $sql +=" delete from " . $obj->getNomTable() . " where " . $obj->getIdName() . " = ? ";
            return $sql;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // MAKE SQL RECHERCHE ######################################################################

    public static function makeSqlRecherche(MapTable $obj, $listeCol, $apreswhere) {
        $sql = "";
        $where = "  where 1<2 ";

        try {
            $classe = get_class($obj);
            $sql = " select * from  " . $obj->getNomTable();

            $champ = UtilitaireMapping::getDeclaredFields($classe);
            $nb = count($champ);
            // echo 'Nb '.$nb;
            $place = 0;
            $j = 0;
            // echo 'NOMBRE COLONNE '.count($listeCol);
            for ($i = 0; $i < $nb; $i++) {
                // echo ' CHAMP '.$champ[$i]->name;
                if ($listeCol !== null) {
                    //echo ' ato '.'<br>';
                    if ($j >= count($listeCol))
                        break;
                    if ($champ[$i]->name === $listeCol[$j]) {
                        //echo 'J '.$j;
                        //echo $i.' place '.$place.' ';
                        $where .= " and " . $champ[$i]->name . " = ? ";
                        $place++;
                        //if(count($listeCol)) $j++;
                        $j++;
                    }
                }
            }
            //$where += " )";
            // echo $sql.$where." ".$apreswhere;
            return $sql . $where . " " . $apreswhere;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function getTotalfield($tab, $champ) {
        $result = 0;
        $temp;
        for ($i = 0; $i < count($tab); $i++) {
            $temp = UtilitaireMapping::getFieldValue(($tab[$i]), $champ);
            if (!is_numeric($temp)) {
                throw new Exception(" champ non numerique");
            } else {
                $result = $result + $temp;
            }
        }
        return $result;
    }

}

?>
