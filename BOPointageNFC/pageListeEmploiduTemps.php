<?php
/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 11/04/2016
 * Time: 17:16
 */

require_once('service/SalleCoursService.php');

$emploiDuTemps = new Viewsallecours();

$listEDT = SalleCoursService::findViewSalleCours($emploiDuTemps,null,"");
echo  json_encode($listEDT);