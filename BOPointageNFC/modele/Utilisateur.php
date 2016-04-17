<?php

/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 02/04/2016
 * Time: 23:23
 *
 */


include_once('metier/MapTable.php');


class Utilisateur extends MapTable
{
    private $idUtilisateur;
    private $nomUtilisateur;
    private $loginUtilisateur;
    private $motDePasseUtilisateur;

    public function __construct() {
        $this->setNomTable("utilisateur");
    }

    public function getIdValue() {
        return $this->id;
    }

    public function getIdName() {
        return "id";
    }

    /**
     * @return mixed
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * @param mixed $idUtilisateur
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;
    }

    /**
     * @return mixed
     */
    public function getNomUtilisateur()
    {
        return $this->nomUtilisateur;
    }

    /**
     * @param mixed $nomUtilisateur
     */
    public function setNomUtilisateur($nomUtilisateur)
    {
        $this->nomUtilisateur = $nomUtilisateur;
    }

    /**
     * @return mixed
     */
    public function getLoginUtilisateur()
    {
        return $this->loginUtilisateur;
    }

    /**
     * @param mixed $loginUtilisateur
     */
    public function setLoginUtilisateur($loginUtilisateur)
    {
        $this->loginUtilisateur = $loginUtilisateur;
    }

    /**
     * @return mixed
     */
    public function getMotDePasseUtilisateur()
    {
        return $this->motDePasseUtilisateur;
    }

    /**
     * @param mixed $motDePasseUtilisateur
     */
    public function setMotDePasseUtilisateur($motDePasseUtilisateur)
    {
        $this->motDePasseUtilisateur = $motDePasseUtilisateur;
    }



}
