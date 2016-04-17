<?php

include_once('modele/Etudiant.php');
include_once('modele/Viewetupromo.php');

class EtudiantService
{
    //private $cours;

    // insert
    public static function insertEtudiant(Etudiant $etudiant)
    {
        try{
            $etudiant->insertToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // find
    public static function findEtudiant(Etudiant $etudiant, $col, $apresWhere)
    {
        try{
            $retEtudiant = $etudiant->searchToTable($col,$apresWhere);
            return $retEtudiant;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    public static function findEtudiantPromotion(Viewetupromo $etudiant, $col, $apresWhere)
    {
        try{
            $retEtudiant = $etudiant->searchToTable($col,$apresWhere);
            return $retEtudiant;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // update
    public static function updateEtudiant(Etudiant $etudiant,$col)
    {
        try{
            $etudiant->updateToTable($col);
        }
        catch(Exception $ex)
        {
            $ex->getMessage();
        }
    }

    // delete
    public static function deleteEtudiant(Etudiant $etudiant)
    {
        try{
            $etudiant->deleteToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

}