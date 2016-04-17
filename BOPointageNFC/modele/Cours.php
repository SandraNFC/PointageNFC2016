<?php

require_once('./metier/MapTable.php');

class Cours extends MapTable
{
    private $idCours;
    private $libelle;
    private $idPromotion;

    /**
     * Cours constructor.
     */
    public function __construct()
    {
        $this->setNomTable("cours");
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
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelleCours
     */
    public function setLibelle($libelleCours)
    {
        $this->libelle = $libelleCours;
    }

    /**
     * @return mixed
     */
    public function getIdpromotion()
    {
        return $this->idPromotion;
    }

    /**
     * @param mixed $idpromotion
     */
    public function setIdpromotion($idpromotion)
    {
        $this->idPromotion = $idpromotion;
    }

}
