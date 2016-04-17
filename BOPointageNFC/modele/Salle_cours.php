<?php

/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 03/04/2016
 * Time: 14:06
 */

require_once("metier/MapTable.php");

class Salle_cours extends MapTable
{

    private $idSC;
    private $idCours;
    private $idSalle;
    private $heureEntree;
    private $heureSortie;

    /**
     * Salle_cours constructor.
     */
    public function __construct()
    {
        $this->setNomTable("salle_cours");
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


}
