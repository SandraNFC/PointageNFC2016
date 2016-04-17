<?php
/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 10/04/2016
 * Time: 16:00
 */
require_once('service/PointageService.php');


$response = array();
if(isset($_POST['IDSC']) && isset($_POST['IDETUDIANT']) && isset($_POST["HEUREENTREEETUDIANT"]))
{
    $idsc = $_POST['IDSC'];
    $ide = $_POST['IDETUDIANT'];
    $heureEntree = $_POST["HEUREENTREEETUDIANT"];

    $pointage = new Pointage();
    $pointage->setIdPointage(0);
    $pointage->setIdSC($idsc);
    $pointage->setIdEtudiant($ide);
    $pointage->setHeureEntreeEtudiant($heureEntree);

    PointageService::insertPointage($pointage);

    $response["success"]= 1;
    $response["message"] ="Pointage successfully added";

    echo json_encode($response);


}
else{
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    echo json_encode($response);
}