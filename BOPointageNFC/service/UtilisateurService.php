<?php

/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 04/04/2016
 * Time: 13:32
 */
include_once('modele/Utilisateur.php');

class UtilisateurService
{
    // insert
    public static function insertUtilisateur(Utilisateur $user)
    {
        try{
            $user->insertToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // find
    public static function findUtilisateur(Utilisateur $user, $col, $apresWhere)
    {
        try{
            $listUser = $user->searchToTable($col, $apresWhere);
            return $listUser;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // --------------------- login utilisateur "admin" back office ---------------------
    public static function loginUtilisateur(Utilisateur $user)
    {
        try{
            $col = array();
            $col[0] = 'loginUtilisateur';
            $col[1] = 'motDePasseUtilisateur';
            //echo '<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< LOGIN : '.$user->getLoginUtilisateur();
            //echo '<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< MOT DE PASSE : '.$user->getMotDePasseUtilisateur();

            // echo UtilitaireMapping::makeSqlRecherche($user,$col,'');
            $retUser = $user->searchToTable($col,'');
            count($retUser);

            return $retUser;
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // update
    public static function updateUtilisateur(Utilisateur $user,$col)
    {
        try{
            $user->updateToTable($col);
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }

    // delete
    public static function deleteUtilisateur(Utilisateur $user)
    {
        try{
            $user->deleteToTable();
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }
}
