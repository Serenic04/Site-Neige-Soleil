<div class="reservation">
    <div class="content">
        <div class="reservation-section">

            <?php 
                $unModele = new Modele();
                $unModele->remplirReservationEquipement();
            ?>


            

        </div>


        <a href="index.php?page=panier">
            <button class="btnRes">Voir Le Panier</button>
        </a>


    </div>
</div>