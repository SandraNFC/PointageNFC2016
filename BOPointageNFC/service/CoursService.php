<?php

/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 03/04/2016
 * Time: 16:23
 */

include_once('modele/Cours.php');
include_once('modele/Viewcourspromo.php');

class CoursService
{
    //private $cours;

    // insert
    public static function insertCours(Cours $cours)
    {
        try{
            $cours->insertToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // find
    public static function findCours(Cours $cours, $col, $apresWhere)
    {
        try{
            $retCours = $cours->searchToTable($col,$apresWhere);
            return $retCours;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    public static function findCoursPromotion(Viewcourspromo $cours, $col, $apresWhere)
    {
        try{
            $retCours = $cours->searchToTable($col,$apresWhere);
            return $retCours;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // find by Id
    public static function findCoursById(Cours $cours)
    {
        try{
            $col = array();
            $col = 'idCours';
            $retCours = $cours->searchToTable($col);
            return $retCours;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // update
    public static function updateCours(Cours $cours,$col)
    {
        try{
            $cours->updateToTable($col);
        }
        catch(Exception $ex)
        {
            $ex->getMessage();
        }
    }

    // delete
    public static function deleteCours(Cours $cours)
    {
        try{
            $cours->deleteToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

}