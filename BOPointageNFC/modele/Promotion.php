<?php

/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 11/04/2016
 * Time: 11:57
 */
include_once('metier/MapTable.php');

class Promotion extends MapTable
{

    private $idPromotion;
    private $nomPromotion;

    /**
     * Salle constructor.
     */
    public function __construct()
    {
        $this->setNomTable("promotion");
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
    public function getNomPromotion()
    {
        return $this->nomPromotion;
    }

    /**
     * @param mixed $nomPromotion
     */
    public function setNomPromotion($nomPromotion)
    {
        $this->nomPromotion = $nomPromotion;
    }


}