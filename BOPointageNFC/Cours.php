<?php
require_once('service/CoursService.php');
require_once('service/PromotionService.php');
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Cours Back Office Pointage NFC</title>
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
                            <h2><i class="glyphicon glyphicon-plus-sign"></i> Nouveau cours</h2>
                        </div>

                        <div class="box-content row">

                            <div class="col-lg-12 col-md-12">
                                <form class="form-horizontal" action="#" method="post">
                                    <fieldset>
                                        <input type="text" class="form-control" placeholder="Cours" name="cours">
                                        <br>
                                        <div class="control-group">
                                            <div class="controls">
                                                <select id="selectError" data-rel="chosen" name="promotion">
                                                    <option>Veuillez choisir la promotion pour ce cours ...</option>
                                                    <?php
                                                    $promo = new Promotion();
                                                    $liste_promo=PromotionService::findPromotion($promo,null,'order by IDPROMOTION');
                                                    foreach($liste_promo as $row) {

                                                        echo "<option value=$row[IDPROMOTION]>$row[NOMPROMOTION]</option>";
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
                                    if(!empty($_POST['cours']) && !empty($_POST['promotion'])){
                                        $cours = new Cours();
                                        $cours->setIdCours(0);
                                        $cours->setLibelle($_POST["cours"]);
                                        $cours->setIdpromotion($_POST["promotion"]);
                                        CoursService::insertCours($cours);
                                        echo '<br><p class="alert alert-success">Cours <b>" '.$_POST["cours"].' " </b> ins&eacute;r&eacute; avec succ&egrave;s.</p>';
                                    }
                                    else{
                                        echo '<br><p class="alert alert-danger">Tous les champs sont obligatoires.</p>';
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
                            <h2><i class="glyphicon glyphicon-list"></i> Liste des cours</h2>
                        </div>

                        <div class="box-content">
                            <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                <thead>
                                <tr>
                                    <th>Identifiant</th>
                                    <th>Cours</th>
                                    <th>Promotion</th>
                                </tr>
                                </thead>
                                <?php
                                $cours = new Viewcourspromo();
                                $liste_cours=CoursService::findCoursPromotion($cours,null,'order by IDCOURS desc');
                                foreach($liste_cours as $row) {
                                    ?>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $row["IDCOURS"]; ?></td>
                                        <td><?php echo $row["COURS"]; ?></td>
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
