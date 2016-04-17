<?php

/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 11/04/2016
 * Time: 15:27
 */
include_once('metier/MapTable.php');


class Viewcourspromo extends MapTable
{

    private $idCours;
    private  $cours;
    private $idPromotion;
    private  $promotion;

    public function __construct() {
        $this->setNomTable("viewcourspromo");
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


}