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

        //echo '_____________________________________'.$id;
        $promo = new Promotion();
        $promo->setIdPromotion($id);
        $data=PromotionService::findPromotion($promo,null,' and IDPROMOTION = '.$id);
        //echo '_____________________________________'.$data[0][1];
        //echo '_______________________________________'.count($data);
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

            <!--details starts-->
            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">

                        <div class="box-header well">
                            <h2><i class="glyphicon glyphicon-plus-sign"></i> D&eacute;tails PROMOTION</h2>
                        </div>

                        <div class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label" style="padding-left: 15px">Identifiant : </label> <?php echo $data[0][0];?>
                            </div>
                            <div class="control-group">
                                <label class="control-label" style="padding-left: 15px">Promotion : </label> <?php echo $data[0][1];?>
                            </div>
                            <div class="form-actions">
                                <a class="btn" href="Promotion.php">Retour</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!--/.row details ends -->

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


