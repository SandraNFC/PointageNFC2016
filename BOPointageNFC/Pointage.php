<?php
session_start();
require_once('service/PointageService.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Emploi du temps Back Office Pointage NFC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- heads -->
    <?php include("L_Heads.html");?>

</head>

<body>
<!-- topbar starts -->
<?php include("L_TopBars.html");?>
<!-- topbar ends -->

<div class="ch-container">
    <div class="row">

        <!-- left menu starts -->
        <?php include("L_Menus.html");?>
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">

            <?php include_once("L_BreadCrumb.html");?>

            <!--liste starts-->
            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">

                        <div class="box-header well" data-original-title="">
                            <h2><i class="glyphicon glyphicon-time"></i> Pointage</h2>
                        </div>

                        <div class="box-content">
                            <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                <thead>
                                <tr>
                                    <th>Identifiant</th>
                                    <th>Promotion</th>
                                    <th>&Eacute;tudiant</th>
                                    <th>Cours</th>
                                    <th>Salle</th>
                                    <th>Horaire d'entr&eacute;e</th>
                                    <th>Horaire de sortie</th>
                                    <th>Pointage</th>
                                </tr>
                                </thead>
                                <?php
                                $v_pointage = new Viewpointage();
                                $liste_pointage=PointageService::findPointage($v_pointage,null,'order by IDPOINTAGE desc');
                                foreach($liste_pointage as $row) {
                                    ?>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $row["IDPOINTAGE"]; ?></td>
                                        <td><?php echo $row["PROMOTION"]; ?></td>
                                        <td><?php echo $row["NOM"]?> <?php echo $row["PRENOM"]; ?></td>
                                        <td><?php echo $row["COURS"]; ?></td>
                                        <td><?php echo $row["NUMSALLE"]; ?></td>
                                        <td><?php echo $row["HEUREENTREE"]; ?></td>
                                        <td><?php echo $row["HEURESORTIE"]; ?></td>
                                        <td><?php echo $row["HEUREENTREEETUDIANT"]; ?></td>
                                        <td class="center">
                                            <a class="btn btn-success btn-sm" href="#">
                                                <i class="glyphicon glyphicon-zoom-in icon-white"></i>
                                                D&eacute;tails
                                            </a>
                                            <a class="btn btn-info btn-sm" href="#">
                                                <i class="glyphicon glyphicon-edit icon-white"></i>
                                                Modifier
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#">
                                                <i class="glyphicon glyphicon-trash icon-white"></i>
                                                Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!--/.row liste ends-->

        </div><!--/#content-->
    </div><!--/.row-->
</div><!--/.ch-container-->

<hr>

<!-- footer-->
<?php include("L_Footer.html");?>

</div><!--/.fluid-container-->

<!-- external javascript -->
<!-- -->
<?php include("L_ExternalJavascript.html");?>

</body>
</html>
