<?php
    require_once ("modele/modele.class.php");
    class Controleur {
        private $unModele ;

        public function __construct(){
            //instancier la classe modele
            $this->unModele= new Modele ();
        }
        /**********Gestion des clients *************/
        public function inscription($tab){
            //controler les donnees avant de les insertion dans la BDD

            //appel au modele pour inserer les données
            $this->unModele->inscription($tab);
        }

        public function verifConnexion ($email, $mdp){
			//controler les données email et mdp 

			//appel du modele 
			return $this->unModele->verifConnexion ($email, $mdp);
		}

        public function getClientRes (){
		
			//appel du modele 
			return $this->unModele->getClientRes ();
		}

        public function ajouterHabitationRes ($id_hab){
			
			//appel du modele 
			$this->unModele->ajouterHabitationRes ($id_hab);
		}

		public function ajouterEquipementRes ($id_stand){
			
			//appel du modele 
			$this->unModele->ajouterEquipementRes ($id_stand);
		}

		public function ajouterPropri ($infoHab, $fileName){
			
			//appel du modele 
			$this->unModele->ajouterPropri ($infoHab , $fileName);
		}

		public function remplirReservationHabitation (){
			
			//appel du modele 
			$this->unModele->remplirReservationHabitation ();
		}

		public function remplirReservationEquipement (){
			
			//appel du modele 
			$this->unModele->remplirReservationEquipement ();
		}


		public function remplirPropieteHabitation (){
		
			//appel du modele 
			return $this->unModele->remplirPropieteHabitation ();
		}


		public function refrshPage (){
		
			//appel du modele 
			$this->unModele->refrshPage ();
		}

		public function changerHabitation ($tab, $fileNameNew){
		
			//appel du modele 
			$this->unModele->changerHabitation ($tab, $fileNameNew);
		}

		public function changerContrat ($prix){
		
			//appel du modele 
			$this->unModele->changerContrat ($prix);
		}


		public function sizeOfPanier (){
		
			//appel du modele 
			return $this->unModele->sizeOfPanier ();
		}

		public function remplirPanierequipement (){
		
			//appel du modele 
			$this->unModele->remplirPanierequipement ();
		}


		public function supprimerPanierEQP($idEQPT){
		
			//appel du modele 
			$this->unModele->supprimerPanierEQP($idEQPT);
		}


		public function ajouterPanierEQP($idEQPT){
		
			//appel du modele 
			$this->unModele->ajouterPanierEQP($idEQPT);
		}

		public function retirerPanierEQP($idEQPT){
		
			//appel du modele 
			$this->unModele->retirerPanierEQP($idEQPT);
		}

		public function remplirPanierHabitation(){
		
			//appel du modele 
			$this->unModele->remplirPanierHabitation();
		}


		public function supprimerPanierHab($idHab){
		
			//appel du modele 
			$this->unModele->supprimerPanierHab($idHab);
		}

		public function remplirPanier(){
		
			//appel du modele 
			$this->unModele->remplirPanier();
		}

		public function remplirSommaire(){
		
			//appel du modele 
			$this->unModele->remplirSommaire();
		}

		public function sommePanier(){
		
			//appel du modele 
			return $this->unModele->sommePanier();
		}
		
    }
?>