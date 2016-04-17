<?php
/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 11/04/2016
 * Time: 16:26
 */

require_once('service/EtudiantService.php');

$etudiant = new Etudiant();

$listeEtudiant = EtudiantService::findEtudiant($etudiant, null, "");
echo json_encode($listeEtudiant);