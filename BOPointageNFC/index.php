<?php
    require_once('service/UtilisateurService.php');
    require_once('metier/UtilitaireMapping.php');
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta http-equiv="content-type" charset="utf-8">
    <title>Authentification Back Office Pointage NFC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">
    <link href="css/charisma-app.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.ico">

</head>

<body>
    <div class="ch-container">

        <div class="row">
            <div class="col-md-12 center login-header">
                <h2>Back Office Pointage NFC</h2>
            </div>
        </div><!--/row-->

        <div class="row">
            <div class="well col-md-5 center login-box">
                <div class="alert alert-info">
                    Authentification
                </div>
                <form class="form-horizontal" action="Index.php" method="post">
                    <fieldset>
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                            <input type="text" class="form-control" placeholder="Login " name="login">
                        </div>
                        <div class="clearfix"></div><br>

                        <div class="input-group input-group-lg">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                            <input type="password" class="form-control" placeholder="Mot de passe" name="motDePasse">
                        </div>
                        <div class="clearfix"></div>

                        <!--<div class="input-prepend">
                            <label class="remember" for="remember"><input type="checkbox" id="remember">Se souvenir de moi</label>
                        </div>
                        <div class="clearfix"></div>-->

                        <p class="center col-md-5">
                            <button type="submit" class="btn btn-primary" name="seconnecter">Connexion</button>
                        </p>
                    </fieldset>
                </form>
                <p></p>

                <?php
                if(isset($_POST["seconnecter"]))
                {
                    if((!empty($_POST['login'])) && (!empty($_POST['motDePasse']))){
                        $user = new Utilisateur();
                        $user->setLoginUtilisateur($_POST["login"]);
                        $user->setMotDePasseUtilisateur($_POST["motDePasse"]);
                        $usersession = UtilisateurService::loginUtilisateur($user);

                        if(count($usersession)>0)
                        {
                            $_SESSION['idutilisateur'] = $usersession[0][0];
                            $_SESSION['nom'] = $usersession[0][1];
                            // echo '----------------------- session nom '.$_SESSION['nom'];
                            header('Location:Accueil.php');
                        }
                        else{
                            echo '<p class="message_error">Utilisateur inexistant, veuillez v&eacute;rifier votre saisie</p>';
                        }
                    }
                    else if(empty($_POST['login'])){
                        echo '<p class="message_error">Veuillez saisir  votre login</p>';
                    }

                    else if(empty($_POST['motDePasse'])){
                        echo '<p class="message_error">Veuillez saisir  votre mot de passe</p>';
                    }
                    else{
                        echo '<p class="message_error">Champs obligatoires</p>';
                    }
                }
                ?>
            </div><!--/.well col-md-5 center login-box-->
        </div><!--/row-->

    </div><!--/.ch-container-->

<!-- external javascript -->

</body>
</html>
