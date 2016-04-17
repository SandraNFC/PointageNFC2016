<?php

include_once './metier/ConnectDB.php';
include_once './metier/UtilitaireMapping.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MapTable
 *
 * @author tiana
 */
abstract class MapTable {

    //put your code here
    var $nomTable;
    var $champ;

    abstract function getIdValue();

    abstract function getIdName();

    function getNomTable() {
        return $this->nomTable;
    }

    function setNomTable($nom) {
        if ($nom === null) {
            throw new Exception("nom de table null");
        } else if (strlen($nom) === 0) {
            throw new Exception("nom de table ===0");
        } else if (strcmp($nom, " ") === 0) {
            throw new Exception("nom de table \" \" ");
        } else
            $this->nomTable = $nom;
    }

    function getChamp() {
        return $this->champ;
    }

    function setChamp($tab) {
        $this->champ = $tab;
    }

    //  insert ------------------------------------------

    function insertToTable() {
        try {
            $connDB = new ConnectDB();
            $conn = $connDB->getConnect();

            $this->insertToTableConnection($conn);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function insertToTableConnection($connection) {
        try {
            $sql = UtilitaireMapping::makeSqlInsert($this);
            //echo "</br> sql insert ========== ".$sql;

            $stat = $connection->prepare($sql);
            $temp = array();

            $field = UtilitaireMapping::getDeclaredFields($this);
            for ($i = 0; $i < count($field); $i++) {
                if (UtilitaireMapping::getFieldValue($this, $field[$i]->name) === null)
                    continue;

                $attr = UtilitaireMapping::getFieldValue($this, $field[$i]->getName());
                if ($attr === null)
                    continue;
                if ($attr !== null)
                    $temp[$i] = $attr;


                //$stat->bindParam($i+1, $temp[$i]);
                //echo ' TEMP ' . $temp[$i];
            }

            //echo $temp;
            //$stat->execute();
            $stat->execute($temp);
        } catch (Exception $ex) {
            print_r(">>> INSERT EXCEPTION >>> " . $ex->getMessage());
            die();
        }
        /* finally{
          if($stat != null)
          {
          $stat->closeCursor();
          }
          } */
    }

    //  update ------------------------------------------


    function updateToTableConnection($listeNull, $connection) {
        try {

            $sql = UtilitaireMapping::makeSqlUpdate($this, $listeNull);
            // echo "</br> >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>" . $sql;

            $stat = $connection->prepare($sql);

            $nomId = $this->getIdName();

            $field = UtilitaireMapping::getDeclaredFields($this);

            $temp = array();

            $id = null;

            for ($i = 0; $i < count($field); $i++) {

                /* if($listeNull !== null && in_array($field[$i]->name,$listeNull))
                  {
                  //echo 'ato $listeNull !== null</br>';
                  //$temp[$i] = null;
                  //continue;
                  $val = UtilitaireMapping::getFieldValue($this, $field[$i]->getName());

                  if($val === null)
                  {
                  echo 'val === null <br/>';
                  continue;
                  }

                  if(strcmp($nomId, $field[$i]->getName()) === 0 )
                  {
                  $id = $val;
                  continue;
                  }

                  //echo 'VAL **** '.$val;

                  $temp[$i] = $val;
                  echo ' TEMP '.$temp[$i];

                  } */

                //echo ' TAILLE FIELD ' . count($field);

                $val = UtilitaireMapping::getFieldValue($this, $field[$i]->getName());
                //echo ' VAL: ' . $val . ' <br/>';

                if ($val === null) {
                    continue;
                }
                if (strcmp($nomId, $field[$i]->getName()) === 0) {
                    $id = $val;
                    continue;
                }

                $temp[$i] = $val;

                //echo $listeNull
            }

            $temp[$i] = $id;
            // echo ' >>>>>>>>>>>>>>>> TEMP TAILLE ' . count($temp);
            // echo ' >>>>>>>>>>>>>>>>>>>>>>>>>>>>>> TEMP ID '.$i;

            $stat->execute($temp);
        } catch (Exception $ex) {
            print_r('Error ' + $ex->getMessage());
            //throw $ex;
        }
    }

    public function updateToTable($listeNull) {
        $conn = null;
        try {
            $connDB = new ConnectDB();
            $conn = $connDB->getConnect();

            $this->updateToTableConnection($listeNull, $conn);
            $conn->commit();
        } catch (Exception $ex) {
            $conn->rollBack();
            throw $ex;
        }
    }

    //  delete ------------------------------------------

    function deleteToTableConnection($connection) {
        try {

            $sql = UtilitaireMapping::makeSqlDelete($this);
           // echo "</br> sql delete ========== " . $sql;

            $id = $this->getIdValue();

            //$field = UtilitaireMapping::getFieldValue($obj, $id);

            $requete = $connection->prepare($sql);

            $temp[0] = $id;

            // echo 'IDDDDD       '.$id;
            //$result = pg_execute($connection,'my_query',$temp);
           // echo "ID " . $id;
            $requete->execute($temp);
            $requete->closeCursor();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function deleteToTable() {
        try {
            $connDB = new ConnectDB();
            $conn = $connDB->getConnect();

            $this->deleteToTableConnection($conn);
            //pg_close($conn);
            $conn->commit();
        } catch (Exception $ex) {
            //$conn->rollBack();
            throw $ex;
        }
    }

    public function searchToTableConnection($connection, $listCol, $apresWhere) {
        $data = null;
        $stat = null;
        try {
            $sql = UtilitaireMapping::makeSqlRecherche($this, $listCol, $apresWhere);
            //echo '___________________________________________'.$sql;
            $stat = $connection->prepare($sql);
            $field = UtilitaireMapping::getDeclaredFields($this);
            $temp = array();
            if ($listCol != null) {
                for ($j = 0; $j < count($listCol); $j++) {
                    for ($i = 0; $i < count($field); $i++) {
                        if ($listCol[$j] === $field[$i]->name) {
                            $temp[$j] = UtilitaireMapping::getFieldValue($this, $field[$i]->name);
                            //echo 'VAL '.$temp[$j].' <br/>';
                        }
                    }
                }
            }
            $stat->execute($temp);
            //echo "AFTER EXECUTE <br/>";
            $objArray = array();
            //$objTemp = null;
            $data = $stat->fetchAll();
            //echo 'taille data '.count($data);
            $j = 0;
            foreach ($data as $o) {
                // echo 'DATA  <br>';

                for ($i = 0; $i < count($field); $i++) {
                    // echo $o;
                    UtilitaireMapping::setFieldValue($this, $field[$i]->name, $o);
                    //echo 'count '.count($field);
                }
                $objArray[$j] = $o;
                $j++;
            }
            return $objArray;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function searchToTable($listCol, $apresWhere) {
        $con = null;
        $obj = array();
        try {
            $con = new ConnectDB();
            $connection = $con->getConnect();
            $obj = $this->searchToTableConnection($connection, $listCol, $apresWhere);
            return $obj;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}

?>
