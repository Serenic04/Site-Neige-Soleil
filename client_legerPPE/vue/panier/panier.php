<div class="panier">
    <div class="main">
        <h2>MON PANIER</h2>
        
        <div class="content">

            <div class="cart-section">
                <div class="cart-items">

                    <?php

                    $unControleur = new Controleur();
                    if ($unControleur->sizeOfPanier() == 0){echo "Votre Panier Est Vide !";}
                    else {$unControleur->remplirPanier();        
                    }
                    
                    
                    ?>

                </div>
                
                <div class="cart-summary">



                    <?php
                        $unControleur = new Controleur();

                        if ($unControleur->sizeOfPanier() == 0){echo "Votre Panier Est Vide !";}
                        else {$unControleur->remplirSommaire();}

                        
                    ?>


                    <div class="somme">
                        <hr />
                        <p><strong>Total = <?php 
                        $valeur = $unControleur->sommePanier();
                        if ($valeur == ''){echo '0€';}
                        else{echo $valeur."€";}
                        ?></strong></p>
                    </div>


                </div>
            </div>
        
            <div class="payment-section">
                <div class="payment-option">
                    <h3>Paiement par Carte Bancaire</h3>
                    <p>INFORMATIONS-CB</p>
                </div>
                <div class="payment-option">
                    <h3>Paiement par Paypal</h3>
                    <p>INFORMATIONS-PAYPAL</p>
                </div>
            </div>

        </div>
        
    </div>
</div>