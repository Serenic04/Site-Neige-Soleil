<div class="reservation">
    <div class="content">
        <div class="reservation-section">

            <?php 
                $unControleur = new Controleur();
                $unControleur->remplirReservationHabitation();
            ?>


            

        </div>


        <a href="index.php?page=panier">
            <button class="btnRes">Voir Le Panier</button>
        </a>


    </div>
</div>