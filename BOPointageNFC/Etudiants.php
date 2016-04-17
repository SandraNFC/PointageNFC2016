<?php
require_once('service/EtudiantService.php');
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
                            <h2><i class="glyphicon glyphicon-plus-sign"></i> Nouvel &eacute;tudiant</h2>
                        </div>

                        <div class="box-content row">

                            <div class="col-lg-12 col-md-12">
                                <form class="form-horizontal" action="#" method="post">
                                    <fieldset>

                                        <input type="text" class="form-control" placeholder="Nom" name="nom">
                                        <br>

                                        <input type="text" class="form-control" placeholder="Pr&eacute;noms" name="prenoms">
                                        <br>

                                        <input type="text" class="form-control" placeholder="Pseudo" name="pseudo">
                                        <br>

                                        <input type="password" class="form-control" placeholder="Mot de passe" name="motdepasse">
                                        <br>


                                        <div class="control-group">
                                            <div class="controls">
                                                <select id="selectError" data-rel="chosen" name="promotion">
                                                    <option>Veuillez choisir la promotion de l'&eacute;tudiant</option>
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
                                    if(!empty($_POST['promotion']) && !empty($_POST['nom']) && !empty($_POST['prenoms']) && !empty($_POST['pseudo']) && !empty($_POST['motdepasse'])){
                                        $etu = new Etudiant();
                                        $etu->setIdEtudiant(0);
                                        $etu->setIdPromotion($_POST["promotion"]);
                                        $etu->setNom($_POST["nom"]);
                                        $etu->setPrenom($_POST["prenoms"]);
                                        $etu->setPseudo($_POST["pseudo"]);
                                        $etu->setMotDePasse($_POST["motdepasse"]);
                                        EtudiantService::insertEtudiant($etu);
                                        echo '<br> <p class="alert alert-success">&Eacute;tudiant <b>" '.$_POST["nom"].' '.$_POST["prenoms"].' " </b> ins&eacute;r&eacute; avec succ&egrave;s.</p>';
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
                            <h2><i class="glyphicon glyphicon-list-alt"></i> Liste des &eacute;tudiants</h2>
                        </div>

                        <div class="box-content">
                            <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                <thead>
                                <tr>
                                    <th>Identifiant</th>
                                    <th>Promotion</th>
                                    <th>Nom</th>
                                    <th>Pr&eacute;noms</th>
                                    <th>Pseudo</th>
                                </tr>
                                </thead>
                                <?php
                                $etu = new Viewetupromo();
                                $liste_etudiants=EtudiantService::findEtudiantPromotion($etu,null,'order by IDETUDIANT desc');
                                foreach($liste_etudiants as $row) {
                                    ?>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $row["IDETUDIANT"]; ?></td>
                                        <td><?php echo $row["PROMOTION"]; ?></td>
                                        <td><?php echo $row["NOM"]; ?></td>
                                        <td><?php echo $row["PRENOM"]; ?></td>
                                        <td><?php echo $row["PSEUDO"]; ?></td>
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
