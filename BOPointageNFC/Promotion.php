<?php
require_once('service/PromotionService.php');
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Promotions Back Office Pointage NFC</title>
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
                            <h2><i class="glyphicon glyphicon-plus-sign"></i> Nouvelle promotion</h2>
                        </div>

                        <div class="box-content row">

                            <div class="col-lg-12 col-md-12">
                                <form class="form-horizontal" action="#" method="post">
                                    <fieldset>
                                        <input type="text" class="form-control" placeholder="Nom de la promotion" name="nompromotion">
                                        <br>
                                        <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
                                    </fieldset>
                                </form>

                                <?php
                                if(isset($_POST["ajouter"]))
                                {
                                    if(!empty($_POST['nompromotion'])){
                                        $promo = new Promotion();
                                        $promo->setIdPromotion(0);
                                        $promo->setNomPromotion($_POST["nompromotion"]);
                                        //echo '-------------------------------- Nom Promotion'.$promo->getNomPromotion();
                                        PromotionService::insertPromotion($promo);
                                        echo '<br> <p class="alert alert-success">Promotion <b>" '.$_POST["nompromotion"].' " </b> ins&eacute;r&eacute;e avec succ&egrave;s.</p>';
                                    }
                                    else {
                                        echo '<br> <p class="alert alert-danger">Ce champ est obligatoire.</p>';
                                    }
                                }
                                ?>
                            </div>
                        </div><!--/.box-content row-->
                    </div><!--/.box-inner-->
                </div><!--/.box col-md-12-->

            </div><!--/.row insert ends -->

            <!--liste starts-->
            <div class="row">
                <div class="box col-md-12">
                    <div class="box-inner">

                        <div class="box-header well" data-original-title="">
                            <h2><i class="glyphicon glyphicon-star-empty"></i> Liste des promotions</h2>
                        </div>

                        <div class="box-content">
                            <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                <thead>
                                <tr>
                                    <th>Identifiant</th>
                                    <th>Promotion</th>
                                </tr>
                                </thead>
                                <?php
                                    $promo = new Promotion();
                                    $liste_promo=PromotionService::findPromotion($promo,null,'order by IDPROMOTION desc');
                                    foreach($liste_promo as $row) {
                                        ?>
                                        <tbody>
                                        <tr>
                                            <td><?php echo $row["IDPROMOTION"]; ?></td>
                                            <td><?php echo $row["NOMPROMOTION"]; ?></td>
                                            <td class="center">
                                                <a class="btn btn-success btn-sm" href="PromotionDetail.php?id=<?php echo $row["IDPROMOTION"]; ?>">
                                                    <i class="glyphicon glyphicon-zoom-in icon-white"></i>
                                                    D&eacute;tails
                                                </a>
                                                <a class="btn btn-info btn-sm" href="PromotionModifier.php?id=<?php echo $row["IDPROMOTION"]; ?>">
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

<script type="text/javascript">
    <!--
    function open_infos(id)
    {
        alert(id);
        width = 800;
        height = 600;
        if(window.innerWidth)
        {
            var left = (window.innerWidth-width)/2;
            var top = (window.innerHeight-height)/2;
        }
        else
        {
            var left = (document.body.clientWidth-width)/2;
            var top = (document.body.clientHeight-height)/2;
        }
        window.open('PopupDetails.php?idpromotion='+id,'nom_de_ma_popup','menubar=no, scrollbars=no, top='+top+', left='+left+', width='+width+', height='+height+'');
    }
    -->
</script>
