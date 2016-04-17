<?php
require_once('service/SalleCoursService.php');
require_once('service/SalleService.php');
require_once('service/CoursService.php');
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Emploi du temps Back Office Pointage NFC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- heads -->

    <link href="css/datetime/bootstrap.min.css" rel="stylesheet">
    <link href="css/datetime/bootstrap-theme.min.css" rel="stylesheet">

    <!-- for datetimepicker -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
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

            <!--insert starts-->
            <div class="row">

                <div class="box col-md-12">
                    <div class="box-inner">

                        <div class="box-header well">
                            <h2><i class="glyphicon glyphicon-plus-sign"></i> Nouvel emploi du temps</h2>
                        </div>

                        <div class="box-content row">

                            <div class="col-lg-12 col-md-12">
                                <form class="form-horizontal" action="#" method="post">
                                    <fieldset>
                                        <!-- datepicker starts -->
                                        <input type="text" class="form-control datetime_entree" placeholder="Horaire d'entr&eacute;e" name="heureentree">
                                        <br>
                                        <script type="text/javascript">
                                            $(".datetime_entree").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
                                        </script>
                                        <!-- test datepicker ends -->

                                        <input type="text" class="form-control datetime_sortie" placeholder="Horaire de sortie" name="heuresortie">
                                        <script type="text/javascript">
                                            $(".datetime_sortie").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
                                        </script>
                                        <br>

                                        <div class="control-group">
                                            <div class="controls">
                                                <select id="selectError" data-rel="chosen" name="salle">
                                                    <option>Veuillez choisir la salle pour cet emploi du temps ...</option>
                                                    <?php
                                                    $salle = new Salle();
                                                    $liste_salle=SalleService::findSalle($salle,null,'order by IDSALLE');
                                                    foreach($liste_salle as $row) {

                                                        echo "<option value=$row[IDSALLE]>$row[NUMSALLE]</option>";
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="control-group">
                                            <div class="controls">
                                                <select id="selectError2" data-rel="chosen" name="cours">
                                                    <option>Veuillez choisir le cours pour cet emploi du temps ...</option>
                                                    <?php
                                                    $cours = new Cours();
                                                    $liste_cours=CoursService::findCours($cours,null,'order by IDCOURS');
                                                    foreach($liste_cours as $row) {

                                                        echo "<option value=$row[IDCOURS]>$row[LIBELLE]</option>";
                                                    }?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>

                                        <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
                                    </fieldset>
                                </form>

                                <?php
                                if(isset($_POST["ajouter"]))
                                {
                                    if(!empty($_POST['heureentree']) && !empty($_POST['heuresortie']) && !empty($_POST['salle']) && !empty($_POST['cours'])){
                                        $sc = new Salle_cours();
                                        $sc->setIdSC(0);
                                        $sc->setIdCours($_POST["cours"]);
                                        $sc->setIdSalle($_POST["salle"]);
                                        $sc->setHeureEntree($_POST["heureentree"]);
                                        $sc->setHeureSortie($_POST["heuresortie"]);
                                        SalleCoursService::insertSalleCours($sc);
                                        echo '<br> <p class="alert alert-success">Emploi du temps ins&eacute;r&eacute; avec succ&egrave;s.</p>';
                                    }
                                    else{
                                        echo '<br> <p class="alert alert-danger">Tous les champs sont obligatoires.</p>';
                                    }
                                }
                                ?>
                            </div>
                        </div><!--/.box-content row-->
                    </div><!--/.box-inner-->
                </div><!--/.box col-md-12-->

            </div><!--/.row insert ends-->

            <!--liste starts-->
            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">

                        <div class="box-header well" data-original-title="">
                            <h2><i class="glyphicon glyphicon-time"></i> Emploi du temps</h2>
                        </div>

                        <div class="box-content">
                            <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                <thead>
                                <tr>
                                    <th>Identifiant</th>
                                    <th>Cours</th>
                                    <th>Salle</th>
                                    <th>Horaire d'entr&eacute;e</th>
                                    <th>Horaire de sortie</th>
                                    <th>Promotion</th>
                                </tr>
                                </thead>
                                <?php
                                $sc = new Viewsallecours();
                                $liste_sc=SalleCoursService::findViewSalleCours($sc,null,'order by IDSC desc');
                                foreach($liste_sc as $row) {
                                    ?>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $row["IDSC"]; ?></td>
                                        <td><?php echo $row["COURS"]; ?></td>
                                        <td><?php echo $row["NUMSALLE"]; ?></td>
                                        <td><?php echo $row["HEUREENTREE"]; ?></td>
                                        <td><?php echo $row["HEURESORTIE"]; ?></td>
                                        <td><?php echo $row["PROMOTION"]; ?></td>
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
