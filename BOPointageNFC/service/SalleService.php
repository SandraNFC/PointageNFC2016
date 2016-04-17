<?php

/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 04/04/2016
 * Time: 23:29
 */

include_once('modele/Salle.php');
class SalleService
{
    public static function insertSalle(Salle $salle)
    {
        try{
            $salle->insertToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    public static function findSalle(Salle $salle, $col, $apresWhere)
    {
        try{
            $listeSalle = $salle->searchToTable($col, $apresWhere);
            return $listeSalle;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    public static function updateSalle(Salle $salle, $col)
    {
        try{
            $salle->updateToTable($col);
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    public static function deleteSalle(Salle $salle)
    {
        try{
            $salle->deleteToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }
}