<?php
/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 11/04/2016
 * Time: 22:46
 */
require_once('service/PointageService.php');

$pointage = new Viewpointage();

$listePresence = PointageService::findPointage($pointage,null,"");

echo json_encode($listePresence);