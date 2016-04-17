<?php
require_once('service/SalleService.php');
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Salles Back Office Pointage NFC</title>
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

            <!--insert starts-->
            <div class="row">

                <div class="box col-md-12">
                    <div class="box-inner">

                        <div class="box-header well">
                            <h2><i class="glyphicon glyphicon-plus-sign"></i> Nouvelle salle</h2>
                        </div>

                        <div class="box-content row">

                            <div class="col-lg-12 col-md-12">
                                <form class="form-horizontal" action="#" method="post">
                                    <fieldset>
                                        <input type="text" class="form-control" placeholder="Num&eacute;ro de la salle" name="numsalle">
                                        <br>

                                        <input type="text" class="form-control" placeholder="Identifiant du tag NFC" name="uidtag">
                                        <br>

                                        <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
                                    </fieldset>
                                </form>

                                <?php
                                if(isset($_POST["ajouter"]))
                                {
                                    if((!empty($_POST['numsalle'])) && (!empty($_POST['uidtag']))){

                                        $salle = new Salle();
                                        $salle->setIdSalle(0);
                                        $salle->setNumSalle($_POST["numsalle"]);
                                        $salle->setUidtag($_POST["uidtag"]);
                                        SalleService::insertSalle($salle);
                                        echo '<br> <p class="alert alert-success">Salle num&eacute;ro <b>" '.$_POST["numsalle"].' " </b> ins&eacute;r&eacute;e avec succ&egrave;s.</p>';
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
                            <h2><i class="glyphicon glyphicon-map-marker"></i> Liste des salles</h2>
                        </div>

                        <div class="box-content">
                            <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                <thead>
                                <tr>
                                    <th>Identifiant</th>
                                    <th>Num&eacute;ro de la salle</th>
                                    <th>Tag NFC </th>
                                </tr>
                                </thead>
                                <?php
                                $salle = new Salle();
                                $liste_salle=SalleService::findSalle($salle,null,'order by IDSALLE desc');
                                foreach($liste_salle as $row) {
                                    ?>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $row["IDSALLE"]; ?></td>
                                        <td><?php echo $row["NUMSALLE"]; ?></td>
                                        <td><?php echo $row["UIDTAG"]; ?></td>
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
