<?php

/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 11/04/2016
 * Time: 15:33
 */

include_once('metier/MapTable.php');

class Viewpointage extends MapTable
{
    private $idPointage;
    private $idEtudiant;
    private $nom;
    private $prenom;
    private $pseudo;
    private $idPromotion;
    private $promotion;
    private $idSC;
    private $idCours;
    private $cours;
    private $idSalle;
    private $numSalle;
    private $heureEntree;
    private $heureSortie;
    private $heureEntreeEtudiant;


    public function __construct() {
        $this->setNomTable("Viewpointage");
    }

    function getIdValue()
    {
        // TODO: Implement getIdValue() method.
    }

    function getIdName()
    {
        // TODO: Implement getIdName() method.
    }

    /**
     * @return mixed
     */
    public function getIdPointage()
    {
        return $this->idPointage;
    }

    /**
     * @param mixed $idPointage
     */
    public function setIdPointage($idPointage)
    {
        $this->idPointage = $idPointage;
    }

    /**
     * @return mixed
     */
    public function getIdEtudiant()
    {
        return $this->idEtudiant;
    }

    /**
     * @param mixed $idEtudiant
     */
    public function setIdEtudiant($idEtudiant)
    {
        $this->idEtudiant = $idEtudiant;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getIdPromotion()
    {
        return $this->idPromotion;
    }

    /**
     * @param mixed $idPromotion
     */
    public function setIdPromotion($idPromotion)
    {
        $this->idPromotion = $idPromotion;
    }

    /**
     * @return mixed
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param mixed $promotion
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * @return mixed
     */
    public function getIdSC()
    {
        return $this->idSC;
    }

    /**
     * @param mixed $idSC
     */
    public function setIdSC($idSC)
    {
        $this->idSC = $idSC;
    }

    /**
     * @return mixed
     */
    public function getIdCours()
    {
        return $this->idCours;
    }

    /**
     * @param mixed $idCours
     */
    public function setIdCours($idCours)
    {
        $this->idCours = $idCours;
    }

    /**
     * @return mixed
     */
    public function getCours()
    {
        return $this->cours;
    }

    /**
     * @param mixed $cours
     */
    public function setCours($cours)
    {
        $this->cours = $cours;
    }

    /**
     * @return mixed
     */
    public function getIdSalle()
    {
        return $this->idSalle;
    }

    /**
     * @param mixed $idSalle
     */
    public function setIdSalle($idSalle)
    {
        $this->idSalle = $idSalle;
    }

    /**
     * @return mixed
     */
    public function getNumSalle()
    {
        return $this->numSalle;
    }

    /**
     * @param mixed $numSalle
     */
    public function setNumSalle($numSalle)
    {
        $this->numSalle = $numSalle;
    }

    /**
     * @return mixed
     */
    public function getHeureEntree()
    {
        return $this->heureEntree;
    }

    /**
     * @param mixed $heureEntree
     */
    public function setHeureEntree($heureEntree)
    {
        $this->heureEntree = $heureEntree;
    }

    /**
     * @return mixed
     */
    public function getHeureSortie()
    {
        return $this->heureSortie;
    }

    /**
     * @param mixed $heureSortie
     */
    public function setHeureSortie($heureSortie)
    {
        $this->heureSortie = $heureSortie;
    }

    /**
     * @return mixed
     */
    public function getHeureEntreeEtudiant()
    {
        return $this->heureEntreeEtudiant;
    }

    /**
     * @param mixed $heureEntreeEtu
     */
    public function setHeureEntreeEtudiant($heureEntreeEtu)
    {
        $this->heureEntreeEtudiant = $heureEntreeEtu;
    }

}