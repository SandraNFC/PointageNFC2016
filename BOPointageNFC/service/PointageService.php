<?php

/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 04/04/2016
 * Time: 14:24
 */

include_once('modele/Pointage.php');
include_once('modele/Viewpointage.php');

class PointageService
{
    // insert
    public static function insertPointage(Pointage $p)
    {
        try{
            $p->insertToTable();

            $response["success"] = 1;
            $response["message"] = "Pointage successfully created.";

            echo json_encode($response);

        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // find
    public static function findPointage(Viewpointage $pv, $col, $apresWhere)
    {
        try{
            $listPointageView = $pv->searchToTable($col, $apresWhere);
            return $listPointageView;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // update
    public static function updatePointage(Pointage $p, $col)
    {
        try{
            $p->updateToTable($col);
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // delete
    public static function deletePointage(Pointage $p)
    {
        try{
            $p->deleteToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }
}