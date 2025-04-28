<?php
  
	require_once("vue/equipement/equipement.php");
    

    if(isset($_POST["ajouter_id"])){
      if ( ! isset($_SESSION["email"]))
        {
          echo 'Connectez-vous avant de commencer une réservation !';}
        else{
          $unControleur->ajouterEquipementRes($_POST['ajouter_id']);
        }
      }
    
    

?>