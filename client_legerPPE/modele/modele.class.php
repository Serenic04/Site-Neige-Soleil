<?php
    class Modele {
        private $unPdo ; 
        //connexion via la classe PDO : PHP DATA Object

        public function __construct(){
            $serveur = "localhost";
            $bdd ="BDD_ppe";
            $user = "root";
            $mdp = "";

            try{
            $this->unPdo = new PDO("mysql:host=".$serveur.";dbname=".$bdd,$user,$mdp);
            }
            catch(PDOException $exp){
                echo "Erreur de connexion a la base de BDD";
            }
        }

        public function refrshPage(){
            echo "<script>alert('Message d\'alerte');</script>";
            echo "<script> location.refresh();</script>";
        }


        /**      INSCRIPTION/CONNEXION       **/
      
        public function inscription($tab){
            $requete = "insert into user values(null, :nom, :prenom, :adresse, :tel, :email, :mot_de_passe, :role);";
            if ($tab["confirm_password"] != $tab["mot_de_passe"]){echo "Confirmation du mot de passe invalidée, veuillez recommencer.";}
            else {
                $donnees = array(':nom' => $tab['nom'],
                                ':prenom' => $tab['prenom'],
                                ':email' => $tab['email'],
                                ':tel' => $tab['tel'],
                                ':adresse' => $tab['adresse'],
                                ':mot_de_passe' => $tab['mot_de_passe'],
                                ':role' => $tab['role']
                                );
                //on prepare la requete
                $exec = $this->unPdo->prepare ($requete);
                //exécuter la requete
                $exec->execute ($donnees);
                echo " <br> Insertion réussie.";
                header("Location: index.php?page=connexion");
            }
        }

        public function verifConnexion ($email, $mdp){
            $requete = "select * from user where email =:email and mdp =:mdp ;"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array(":email"=>$email, ":mdp"=>$mdp);
            $exec->execute ($donnees);
            return $exec->fetch(); 
        }


        /**      GENERAL       **/

        private function getHab($idProp){
            $requete = "select * from habitation where idhabitation = ".$idProp.";"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return  $exec->fetch(); 
        }

        private function getContratLoc($idProp){
            $requete = "select * from contratLoc where idhabitation = ".$idProp." and current_date() between datedebutC and datefinc ;"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return  $exec->fetch(); 
        }

        private function getUser($idUser){
            $requete = "select * from user where idUser = ".$idUser.";"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return $exec->fetch();
        }

        private function getContratMandatLoc($idProp){
            $requete = "select * from contratmandatlocatif where idUser = ".$_SESSION['id']." and idhabitation =".$idProp." and (etatcontrat='Actif' or etatcontrat='En attente');"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return $exec->fetch();
        }
        

        /**      RESERVATION       **/


        public function listHab (){ //#######PAS SUR#######// 
			$requete = "select b.*,a.prix from contratmandatlocatif a,habitation b
                        where a.idhabitation = b.idhabitation
                        and a.etatcontrat = 'actif'
                        and b.etat = 'louable';"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return  $exec->fetchAll(); 
		}

        public function remplirReservationHabitation(){

            $liste_Hab = $this->listHab();
            $nb_Hab = sizeof($liste_Hab);

            if ($nb_Hab == 0){echo "Il semblerai qu'aucune habitation soit reservable pour le moment !";}
            else{

                echo "<ul class='ul_reservationY'>";

                for ($i=0;$i<$nb_Hab/3;$i++)
                {

                    echo "<ul class='ul_reservationX'>";

                    for ($j=0 ; $j < 3; $j++)
                    {
                        if ($i*3 + $j >=$nb_Hab){break;}
                        echo "<li class='li_reservation'>
                                <div class='reservation-block'>
                                        <p>".$liste_Hab[$i*3+$j]['adresse']."</p>
                                        <p>".$liste_Hab[$i*3+$j]['taille']." m²</p>
                                    <br><p>".$liste_Hab[$i*3+$j]['prix']."€</p>
                                    <div class='image-container'>
                                        <img src='picture/chalet/".$liste_Hab[$i*3+$j]['lienImage']."' class='imageRes'>
                                    </div>
                                    <form method='post'>
                                        <button class='ajouter' name='ajouter_id' value=".$liste_Hab[$i*3+$j]['idHabitation'].">Ajouter au panier</button>
                                    </form>
                                </div>
                            </li>";
                    }

                    echo "</ul>";
                }

                echo "</ul>";

            }
        }

        public function ajouterHabitationRes($id_hab){
            $iduser = $_SESSION["id"];
            $requete = "select count(idhabitation) from panierHab where idhabitation = ".$id_hab." and iduser = ".$iduser." ;";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute (); 

            if ( $exec->fetch()["count(idhabitation)"] ==0){
                $requete = "insert into panierHab(iduser,idhabitation) values(".$iduser.",".$id_hab.");";

                $exec = $this->unPdo->prepare ($requete);
                $exec->execute ();
            }
            else {echo "deja dans votre panier !";}
        }

        public function getClientRes(){
            $requete = "select id_reservation from reservation where id_client = ".$_SESSION["id_client"]." and etat ='en attente';";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();
            if ($exec->fetch() == ''){
                $requete = "insert into reservation values(null, ".$_SESSION["id_client"].",null,'en attente');";
                //on prepare la requete
                $exec2 = $this->unPdo->prepare ($requete);
                //exécuter la requete
                $exec2->execute ();

                
            } 
            $requete = "select id_reservation from reservation where id_client = ".$_SESSION["id_client"].";";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();

            
            
            return $exec->fetch();
        }



        public function listEqpt (){
			$requete = "select a.*,b.nomType from equipement a, typeEquipement b
                        where a.qteEquipement > 0
                        and  a.idTypeEquipement = b.idTypeEquipement;"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return  $exec->fetchAll(); 
		}

        public function remplirReservationEquipement(){

            $liste_Eqpt = $this->listEqpt();
            $nb_Eqpt = sizeof($liste_Eqpt);

            if ($nb_Eqpt == 0){echo "Il semblerai qu'aucun équipement soit reservable pour le moment !";}
            else{

                echo "<ul class='ul_reservationY'>";

                for ($i=0;$i<$nb_Eqpt/3;$i++)
                {

                    echo "<ul class='ul_reservationX'>";

                    for ($j=0 ; $j < 3; $j++)
                    {
                        if ($i*3 + $j >=$nb_Eqpt){break;}
                        echo "<li class='li_reservation'>
                                <div class='reservation-block'>
                                        <p>".$liste_Eqpt[$i*3+$j]['nomType']."</p>
                                        <p>".$liste_Eqpt[$i*3+$j]['nomEquipement']." m²</p>
                                    <br><p>".$liste_Eqpt[$i*3+$j]['prix']."€</p>
                                    <div class='image-container'>
                                        <img src='picture/eqpt/".$liste_Eqpt[$i*3+$j]['lienImage']."' class='imageRes'>
                                    </div>
                                    <form method='post'>
                                        <button class='ajouter' name='ajouter_id' value=".$liste_Eqpt[$i*3+$j]['idEquipement'].">Ajouter au panier</button>
                                    </form>
                                </div>
                            </li>";
                    }

                    echo "</ul>";
                }

                echo "</ul>";

            }
        }

        public function ajouterEquipementRes($id_eqpt){
            $iduser = $_SESSION["id"];
            $requete = "select count(idEquipement) from paniereqp where idEquipement = ".$id_eqpt." and iduser = ".$iduser." ;";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute (); 

            if ( $exec->fetch()["count(idEquipement)"] ==0){
                $requete = "insert into panierEqp(qte,iduser,idEquipement) values(1,".$iduser.",".$id_eqpt.");";

                $exec = $this->unPdo->prepare ($requete);
                $exec->execute ();
            }
            else {

                $requete = "update panierEqp set qte = qte +1 where idUser =".$iduser." and idEquipement = ".$id_eqpt.";";

                $exec = $this->unPdo->prepare ($requete);
                $exec->execute ();

            }
        }


        /**      PROPRIETE       **/


        public function ajouterPropri($tab,$fileName){

            $requete = "insert into habitation values(null, :adresse, :taille, '".$fileName."' ,".$_SESSION['id'].", :codeR, :etat);";
        
            $donnees = array(':adresse' => $tab['adresse'],
                            ':taille' => $tab['taille'],
                            ':codeR' => $tab['codeR'],
                            ':etat' => $tab['etat']
                            );
            //on prepare la requete
            $exec = $this->unPdo->prepare ($requete);
            //exécuter la requete
            $exec->execute ($donnees);
            echo " <br> Insertion réussie.";
            
        }

        public function remplirPropieteHabitation(){

            $liste_Hab = $this->listHabProp();
            $nb_Hab = sizeof($liste_Hab);

            if ($nb_Hab == 0){echo "<p> Il semblerai que vous n'avez pas d'habitations à votre nom pour le moment !";}
            else{

                echo "<ul class='ul_reservationY'>";

                for ($i=0;$i<$nb_Hab/3;$i++)
                {

                    echo "<ul class='ul_reservationX'>";

                    for ($j=0 ; $j < 3; $j++)
                    {
                        if ($i*3 + $j >=$nb_Hab){break;}
                        echo "<li class='li_reservation'>
                                <div class='reservation-block'> 
                                        <p>".$liste_Hab[$i*3+$j]['adresse']."</p>
                                    <br><p>".$liste_Hab[$i*3+$j]['taille']." m²</p>
                                    <div class='image-container'>
                                        <img src='picture/chalet/".$liste_Hab[$i*3+$j]['lienImage']."' class='imageRes'>
                                    </div>
                                    <a href='index.php?page=infoHab&habitation=".$liste_Hab[$i*3+$j]['idHabitation']."' method='post'>
                                        <button class='ajouter' name='info' value=".$liste_Hab[$i*3+$j]['idHabitation'].">Plus d'informations</button>
                                    </a>
                                </div>
                            </li>";
                    }

                    echo "</ul>";
                }

                echo "</ul>";

            }
        }

        public function isMine ($idhabitation){
            $requete = "select ".$idhabitation." in (select idHabitation from habitation where idproprietaire =".$_SESSION['id'].");"; 
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();

            $res = $exec->fetch();

            return $res[0] ; 
        }

        public function listHabProp (){ //#######PAS SUR#######// 
            $iduser = $_SESSION["id"];
			$requete = "select * from habitation where idproprietaire = ".$iduser." ;"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return  $exec->fetchAll(); 
		}

        public function afficherProp($idProp){

            echo "<h2> Votre propriété </h2>";

            $prop = $this->gethab($idProp);

            echo "<div class='reservation-block'>
                <p>".$prop['adresse']."</p>
                <p>".$prop['taille']." m²</p>
                    <div class='image-container'>
                        <img src='picture/chalet/".$prop['lienImage']."' class='imageRes'>
                    </div>
                </div>";
        }

        public function afficherContratLocatifProp($idProp){
            $contrat = $this->getContratLoc($idProp);

            echo "<h2> Contrat Locatif </h2>";

            if (!$contrat){
                echo "Pas de contrat actif pour le moment";
            }
            else{
                $locataire = $this->getUser($contrat['idUser']);

                echo "<div class='reservation-block'>
                        <p>Durée : ".$contrat['dureeC']."</p>
                        <p>Date de début : ".$contrat['dateDebutC']."</p>
                        <p>Date de fin".$contrat['dateFinC']."</p>
                        <p>Nombre de personnes : ".$contrat['nbPersonneC']."</p>
                        <br><br>

                        <p>Locataire : </p>
                        <p>Nom : ".$locataire['nom']."</p>
                        <p>Prenom : ".$locataire['prenom']."</p>
                        <p>Téléphone : ".$locataire['tel']."</p>
                        <p>E-mail :".$locataire['email']."</p>
                    </div>";
            }

        }

        public function afficherContratMandatLocatifProp($idProp){
            $contrat = $this->getContratMandatLoc($idProp);

            echo "<h2> Contrat Mandat Locatif </h2>";

            if (!$contrat){
                echo "Pas de contrat actif pour le moment";
            }
            else{
                echo "<div class='reservation-block'>
                        <p>Prix : ".$contrat['prix']."</p>
                        <p>Date de signature : ".$contrat['dateSignature']."</p>
                        <p>Etat du contrat : ".$contrat['etatContrat']."</p>
                    </div>";
            }


        }

        public function changerContrat($prix){
            $requete = "insert into contratMandatLocatif values(null, :prix, 'En attente', null, ".$_SESSION['id'].",".$_GET['habitation'].");";
                $donnees = array(':prix' => $prix);
                //on prepare la requete
                $exec = $this->unPdo->prepare ($requete);
                //exécuter la requete
                $exec->execute ($donnees);
                echo " <br> Votre demande a été enregistrer et est en cours de signature.
                       <br> En attendant la signature, votre ancien contrat reste actif.";
        }



        public function changerHabitation($tab,$fileName){

            $requete = "update Habitation set adresse=:adresse, taille=:taille, lienImage='".$fileName."', codeR=:codeR, etat=:etat
                        where idHabitation = ".$_GET['habitation'].";";
        
            $donnees = array(':adresse' => $tab['adresse'],
                            ':taille' => $tab['taille'],
                            ':codeR' => $tab['codeR'],
                            ':etat' => $tab['etat']
                            );
            //on prepare la requete
            $exec = $this->unPdo->prepare ($requete);
            //exécuter la requete
            $exec->execute ($donnees);
            echo " <br> Modification réussie !";
            
        }




        /* PANIER  */

        public function sizeOfPanier(){


            $requete = "select count(idEquipement) from panierEqp where iduser = ".$_SESSION['id'].";"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            $qteEQP =  $exec->fetch(); 

            $requete = "select count(idHabitation) from panierHab where iduser = ".$_SESSION['id'].";"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            $qteHab =  $exec->fetch(); 

            return $qteHab[0] + $qteEQP[0];
        }


        private function getPanierEquipement(){
            $requete = "select a.*,b.qte from equipement a, panierEqp b 
                        where b.idUser = ".$_SESSION['id']."
                        and a.idequipement = b.idequipement;"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return  $exec->fetchAll(); 
        }


        public function remplirPanierEquipement(){
            
            $panierEqp = $this->getPanierEquipement();
            $nb_eqp = sizeof($panierEqp);

            for ($i=0;$i<$nb_eqp;$i++)
            {
                echo 
                    "<li>
                        <div class='cart-item'>
                            <img src='picture/eqpt/".$panierEqp[$i]["lienImage"]."' class='image-container'>
                            <div class='item-details'>
                                <p>Article :".$panierEqp[$i]["nomEquipement"]."</p>
                                <p>".$panierEqp[$i]['qte']." x </p>
                                <p>".$panierEqp[$i]["prix"]."€</p>
                            </div>



                            <form method='post'>
                                <input type='image' src='picture/logo_corbeille.png' alt='Bouton' name='submit' class='corbeille'>
                                <input type='hidden' name='supprimerEqp' value=".$panierEqp[$i]["idEquipement"].">
                            </form>

                            <div class='plusmoins'>


                                <form method='post'>
                                    <input type='image' src='picture/icon_plus.png' alt='Bouton' name='submit' class='plus corbeille'>
                                    <input type='hidden' name='ajouterEqp' value=".$panierEqp[$i]["idEquipement"].">
                                </form>
                                
                                <form method='post'>
                                    <input type='image' src='picture/icon_moins.png' alt='Bouton' name='submit' class='moins corbeille'>
                                    <input type='hidden' name='retirerEqp' value=".$panierEqp[$i]["idEquipement"].">
                                </form>


                            </div>


                        </div>
                    </li>";
            }


            

            
        }


        public function supprimerPanierEQP($idEQPT){
            $requete = "delete from paniereqp where idEquipement = ".$idEQPT." and idUser = ".$_SESSION['id'].";"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
        }

        public function supprimerPanierHab($idHab){
            $requete = "delete from panierhab where idHabitation = ".$idHab." and idUser = ".$_SESSION['id'].";"; 
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
        }


        public function ajouterPanierEQP($idEQPT){
            $requete = "update panierEqp set qte = qte +1 where idUser =".$_SESSION['id']." and idEquipement = ".$idEQPT.";";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();
        }

        public function retirerPanierEQP($idEQPT){

            $requete = "select qte from panierEqp where idUser =".$_SESSION['id']." and idEquipement = ".$idEQPT."; ";
            $exec = $this->unPdo->prepare ($requete);
            $exec->execute ();

            $res = $exec->fetch();


            if ($res[0] == 1){$this->supprimerPanierEQP($idEQPT);}
            else {
                $requete = "update panierEqp set qte = qte - 1 where idUser =".$_SESSION['id']." and idEquipement = ".$idEQPT.";";
                $exec = $this->unPdo->prepare ($requete);
                $exec->execute ();
            }
        }


        private function getPanierHabitation(){
            $requete = "select a.*,c.prix from habitation a, panierHab b,contratmandatlocatif c 
                        where a.idhabitation = b.idhabitation
                        and b.iduser = ".$_SESSION['id']." 
                        and a.idhabitation = c.idhabitation;";
            $exec = $this->unPdo->prepare ($requete);
            $donnees = array();
            $exec->execute ($donnees);
            return  $exec->fetchAll(); 
        }


        public function remplirPanierHabitation(){
            
            $panierHab = $this->getPanierHabitation();
            $nb_hab = sizeof($panierHab);

            for ($i=0;$i<$nb_hab;$i++)
            {
                echo 
                    "<li>
                        <div class='cart-item'>
                            <img src='picture/chalet/".$panierHab[$i]["lienImage"]."' class='image-container'>
                            <div class='item-details'>
                                <p>Logement :".$panierHab[$i]["adresse"]."</p>
                                <p>".$panierHab[$i]["prix"]."€</p>
                            </div>



                            <form method='post'>
                                <input type='image' src='picture/logo_corbeille.png' alt='Bouton' name='submit' class='corbeille'>
                                <input type='hidden' name='supprimerHab' value=".$panierHab[$i]["idHabitation"].">
                            </form>


                        </div>
                    </li>";
            }


            

            
        }

        public function remplirPanier(){
            echo "<ul class='liste'>";
            $this->remplirPanierHabitation();
            $this->remplirPanierEquipement();
            echo "</ul>";
        }

        public function remplirSommaireHabitation(){
            
            $panierHab = $this->getPanierHabitation();
            $nb_hab = sizeof($panierHab);

            for ($i=0;$i<$nb_hab;$i++)
            {
                echo 
                    "<li>
                        <p>Logement : ".$panierHab[$i]["adresse"]." = ".$panierHab[$i]["prix"]."€</p>
                    </li>";
            }
        }

        public function remplirSommaireEquipement(){
            
            $panierEqp = $this->getPanierEquipement();
            $nb_eqp = sizeof($panierEqp);

            for ($i=0;$i<$nb_eqp;$i++)
            {
                echo 
                    "<li>
                        <p>Article ".$panierEqp[$i]["nomEquipement"]." : ".$panierEqp[$i]["prix"]." € x ".$panierEqp[$i]["qte"]." = ".number_format((float)$panierEqp[$i]["qte"]*$panierEqp[$i]["prix"], 2, '.', '')." € </p> 
                    </li>";
            }
        }


        public function remplirSommaire(){
            echo "<ul class='liste'>";
            $this->remplirSommaireHabitation();
            $this->remplirSommaireEquipement();

            echo "</ul>";
        }



        public function sommePanier(){

            $panierEqp = $this->getPanierEquipement();
            $nb_eqp = sizeof($panierEqp);

            $panierHab = $this->getPanierHabitation();
            $nb_hab = sizeof($panierHab);


            $sommeHab = 0;
            $sommeEqp = 0;


            for ($i=0;$i<$nb_eqp;$i++)
            {

                $sommeEqp += $panierEqp[$i]["qte"]*$panierEqp[$i]["prix"];
            }

            for ($i=0;$i<$nb_hab;$i++)
            {
                $sommeHab += $panierHab[$i]["prix"];
            }



            $somme =$sommeHab + $sommeEqp;
            return $somme; 
        }





    }

    

?>