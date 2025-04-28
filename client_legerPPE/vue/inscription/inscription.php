<div class="inscription">
    <div class="content">
        <h2>Inscription</h2>

        <div class="form-inscription"> 
            
            <div class="form-container">
                <div class="form-fields">
                    <form method="post">
                        <label for="nom">Votre Nom :</label>
                        <input type="text" name="nom" placeholder="Entrez votre nom">

                        <label for="prenom">Votre Prénom :</label>
                        <input type="text" name="prenom" placeholder="Entrez votre prénom">

                        <label for="email">Votre Adresse E-mail :</label>
                        <input type="text" name="email" placeholder="Entrez votre e-mail">

                        <label for="adresse">Votre Adresse :</label>
                        <input type="text" name="adresse" placeholder="Entrez votre adresse">

                        <label for="tel">Votre téléphone :</label>
                        <input type="text" name="tel" placeholder="Entrez téléphone">

                        <label for="role">Choisissez une option :</label>
                        <select id="choix" name="role">
                            <option value="locataire">Locataire</option>
                            <option value="proprio">Propiétaire</option>
                            <option value="both">Les deux</option>
                        </select>
            
                        <label for="mot_de_passe">Votre Mot De Passe :</label>
                        <input type="password" name="mot_de_passe" placeholder="Entrez votre mot de passe">
            
                        <label for="confirm_password">Confirmation Du Mot De Passe :</label>
                        <input type="password" name="confirm_password" placeholder="Confirmez votre mot de passe">
            
                        <button class="button" name="valider">Inscription</button>
                    </form>
                </div>
            </div>

            <a href="index.php?page=connexion">Déjà inscrit ? Connectez vous ici !</a>
        </div>
    </div>
</div>