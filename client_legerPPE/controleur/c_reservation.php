<?php
  
	require_once("vue/reservation/reservation.php");
    

    if(isset($_POST["ajouter_id"])){
      if ( ! isset($_SESSION["email"]))
        {
          echo 'Connectez-vous avant de commencer une réservation !';}
        else{
          $unControleur->ajouterHabitationRes($_POST['ajouter_id']);
        }
      }
    
    

?>