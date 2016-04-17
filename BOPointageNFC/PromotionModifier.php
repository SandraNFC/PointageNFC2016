<?php
require_once('service/PromotionService.php');
session_start();

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: Promotion.php");
} else {
    echo '________________________'.$id;
    $promo = new Promotion();
    $promo->setIdPromotion($id);
    $data=PromotionService::findPromotion($promo,null,'and IDPROMOTION = '.$id);
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>D&eacute;tails Back Office Pointage NFC</title>
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

            <!--modifier starts-->
            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">

                        <div class="box-header well">
                            <h2><i class="glyphicon glyphicon-plus-sign"></i> Modifier PROMOTION num&eacute;ro : <?php echo $data[0][0]; ?></h2>
                        </div>

                        <div class="box-content row">

                            <div class="col-lg-12 col-md-12">
                                <form class="form-horizontal" action="#" method="post">
                                    <fieldset>
                                        <input type="text" class="form-control" name="nompromotion" value="<?php echo $data[0][1]; ?>">
                                        <br>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-info" name="modifier">Modifier</button>
                                            <a class="btn" href="Promotion.php">Annuler</a>
                                        </div>
                                    </fieldset>
                                </form>

                                <?php
                                $col=array();
                                $col[0]="NOMPROMOTION";
                                if(isset($_POST["modifier"]))
                                {
                                    if(!empty($_POST['nompromotion'])){

                                        $promo = new Promotion();
                                        $promo->setIdPromotion($id);
                                        $promo->setNomPromotion($_POST["nompromotion"]);
                                        PromotionService::updatePromotion($promo,$col);
                                        echo '<br> <p class="alert alert-success">Promotion  <b>" '.$promo->getNomPromotion().' " </b> modifi&eacute;e avec succ&egrave;s.</p>';
                                    }
                                    else{
                                        echo '<br> <p class="alert alert-danger">Tous les champs sont obligatoires.</p>';
                                    }
                                }
                                ?>
                            </div>
                        </div><!--/.box-content row-->
                    </div>
                </div>
            </div><!--/.row modifier ends -->

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