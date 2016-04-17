<?php

/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 03/04/2016
 * Time: 00:13
 */

require_once('metier/MapTable.php');

class Salle extends MapTable
{

    private $idSalle;
    private $numSalle;
    private $uidTag;

    /**
     * Salle constructor.
     */
    public function __construct()
    {
        $this->setNomTable("salle");
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
    public function getUidTag()
    {
        return $this->uidTag;
    }

    /**
     * @param mixed $uidtag
     */
    public function setUidtag($uidtag)
    {
        $this->uidTag = $uidtag;
    }

}
