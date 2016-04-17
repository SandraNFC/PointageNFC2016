<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Accueil Back Office Pointage NFC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- heads -->
    <?php include_once("L_Heads.html");?>

</head>

<body>
<!-- topbar starts -->
<?php include_once("L_TopBars.html");?>
<!-- topbar ends -->

<div class="ch-container">
    <div class="row">

        <!-- left menu starts -->
        <?php include_once("L_Menus.html");?>
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

            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">

                        <div class="box-header well">
                            <h2><i class="glyphicon glyphicon-info-sign"></i> Introduction</h2>
                        </div>

                        <div class="box-content row">

                            <div class="col-lg-12 col-md-12">
                                <h1>Pointage NFC <br>
                                    <small>Back Office Pointage NFC</small>
                                </h1>
                                <p>
                                    Cette application web est destinée aux administrateurs de l'application mobile <i>"Pointage NFC"</i> pour gérer toutes les entités, utiles pour le bon déroulement de l'application.
                                </p>

                                <p><b>Création | Mise à jour | Lecture | Suppression</b></p>
                            </div>

                        </div><!--/.box-content row-->
                    </div><!--/.box-inner-->
                </div><!--/.box col-md-12-->
            </div><!--/.row-->

        </div><!--/#content-->
    </div><!--/.row-->
</div><!--/.ch-container-->

<hr>

<!-- footer-->
<?php include_once("L_Footer.html");?>

</div><!--/.fluid-container-->

<!-- external javascript -->
<?php include_once("L_ExternalJavascript.html");?>

</body>
</html>
