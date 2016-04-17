<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 14/04/2016
 * Time: 08:40
 */

include_once('modele/Viewsallecours.php');
include_once('modele/Salle_cours.php');
class SalleCoursService
{

// salle cours
    public static function insertSalleCours(Salle_cours $sc)
    {
        try {
            $sc->insertToTable();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function findSalleCours(SalleCoursView $scv, $col, $apresWhere)
    {
        try {
            $listSCView = $scv->searchToTable($col, $apresWhere);
            return $listSCView;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }

    public static function updateSalleCours(Salle_cours $sc, $col)
    {
        try {
            $sc->updateToTable($col);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function deleteSalleCours(Salle_cours $sc)
    {
        try {
            $sc->deleteToTable();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function findViewSalleCours(ViewSalleCours $scv, $col, $apresWhere)
    {
        try {
            $listSCView = $scv->searchToTable($col, $apresWhere);
            return $listSCView;
        } catch (Exception $ex) {
            $ex->getMessage();
        }
    }
}