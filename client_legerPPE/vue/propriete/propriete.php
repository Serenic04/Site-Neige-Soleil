<div class="reservation"> 
    <div class="content">

    <h2>Vos propriétés</h2>

    <div class="reservation-section">
        

        <?php 
            $unControleur = new Controleur();
            $unControleur->remplirPropieteHabitation();
        ?>
    </div>

    <h2>Enregistrer Une Nouvelle Propriétés </h2>

    <div class="form-container">
            <div class="form-fields">
                <form method="post" enctype="multipart/form-data">
                    
                    <label for="adresse">L'adresse :</label>
                    <input type="text" name="adresse" placeholder="Entrez l'adresse : ">

                    <label for="taille">La taille (en m²) :</label>
                    <input type="text" name="taille" placeholder="Entrez la taille : ">

                    <label for="codeR">Code Régional :</label>
                    <input type="text" name="codeR" placeholder="Entrez le code régional : ">

                    <label for="etat">Choisissez son état courant :</label>
                    <select id="choix" name="etat">
                        <option value="louable">Louable</option>
                        <option value="occupe">Non louable</option>
                    </select>


                    <label for="image">Sélectionnez une image :</label>
                    <input type="file" name="image" id="image" accept="image/*" required>


        
                    <input type="submit" value="valider" name="submit">
                </form>
            </div>
        </div>
    </div>
</div>