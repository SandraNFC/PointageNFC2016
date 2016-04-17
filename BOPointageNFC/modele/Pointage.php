<?php

/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 03/04/2016
 * Time: 13:56
 */

require_once("./metier/MapTable.php");

class Pointage extends MapTable
{

    private $idPointage;
    private $idEtudiant;
    private $idSC;
    private $heureEntreeEtudiant;

    /**
     * Pointage constructor.
     */
    public function __construct()
    {
        $this->setNomTable("pointage");
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
