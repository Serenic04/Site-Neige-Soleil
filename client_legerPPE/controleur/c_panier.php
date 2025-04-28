<?php


    if (!isset($_SESSION['id'])){header("Location: index.php?page=connexion"); }

    else{
	    require_once("vue/panier/panier.php");


        if(isset($_POST['supprimerHab'])){

            $unControleur->supprimerPanierHab($_POST['supprimerHab']);

            echo '<script>window.location.href = "index.php?page=panier";</script>';


        }

        if(isset($_POST['supprimerEqp'])){

            $unControleur->supprimerPanierEQP($_POST['supprimerEqp']);

            echo '<script>window.location.href = "index.php?page=panier";</script>';


        }

        if(isset($_POST['ajouterEqp'])){

            $unControleur->ajouterPanierEQP($_POST['ajouterEqp']);

            echo '<script>window.location.href = "index.php?page=panier";</script>';

        }

        if(isset($_POST['retirerEqp'])){

            $unControleur->retirerPanierEQP($_POST['retirerEqp']);

            echo '<script>window.location.href = "index.php?page=panier";</script>';

        }

    }
?>