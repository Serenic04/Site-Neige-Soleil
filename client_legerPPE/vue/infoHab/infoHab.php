<?php 

    $unModele = new Modele();


    echo "<div class='content'>";

    echo "<a href='index.php?page=propriete'>
            <img src='picture/annuler.png'>
        </a>";



    

    if (isset($_GET['habitation'])){
        if ($unModele->isMine($_GET['habitation'])){

            $unModele->afficherProp($_GET['habitation']);
            $unModele->afficherContratLocatifProp( $_GET['habitation']);
            $unModele->afficherContratMandatLocatifProp($_GET['habitation']);

            echo "<h2>Modifier votre contrat</h2>";

            echo "  <div class='form-container'>
                        <div class='form-fields'>
                            <form method='post' enctype='multipart/form-data'>
                                
                                <label for='prix'>Prix :</label>
                                <input type='text' name='prix' placeholder='Entrez le nouveau prix : '>

                                <input type='submit' value='Modifier Votre Contrat' name='changeContrat'>
                            </form>
                        </div>
                    </div>";



            echo "  <div class='form-container'>
                    <div class='form-fields'>
                        <form method='post' enctype='multipart/form-data'>
                            
                            <label for='adresse'>L'adresse :</label>
                            <input type='text' name='adresse' placeholder='".addslashes("Entrez l'adresse : ")."'>

                            <label for='taille'>La taille (en m²) :</label>
                            <input type='text' name='taille' placeholder='Entrez la taille : '>

                            <label for='codeR'>Code Régional :</label>
                            <input type='text' name='codeR' placeholder='Entrez le code régional : '>

                            <label for='etat'>Choisissez son état courant :</label>
                                <select id='choix' name='etat'>
                                    <option value='louable'>Louable</option>
                                    <option value='occupe'>Non louable</option>
                                </select>


                            <label for='image'>Sélectionnez une image :</label>
                            <input type='file' name='image' id='image' accept='image/*' required>

                            <input type='submit' value='Modifier Votre Habitation' name='changeHabitation'>
                        </form>
                    </div>
                </div>";

                if(isset($_POST["changeContrat"])) {
                    $unControleur->changerContrat($_POST['prix']);
                }

                if(isset($_POST["changeHabitation"])) {
                        // Informations sur le fichier uploadé
                    $file = $_FILES['image'];
                    
                    // Propriétés du fichier
                    $fileName = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileError = $file['error'];
                    $fileType = $file['type'];
                    
                    // Extension du fichier
                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    
                    // Extensions autorisées
                    $allowed = array('jpg', 'jpeg', 'png', 'gif');
                    
                    // Vérifie si l'extension est autorisée
                    if(in_array($fileExt, $allowed)) {
                        // Vérifie s'il n'y a pas d'erreur
                        if($fileError === 0) {
                            // Vérifie la taille du fichier (5MB max ici)
                            if($fileSize < 5000000) {
                                // Génère un nom unique pour éviter les conflits
                                $fileNameNew = uniqid('', true) . '.' . $fileExt;
                                // Destination finale
                                $fileDestination = 'picture/chalet/' . $fileNameNew;
                                
                                // Déplace le fichier vers sa destination finale
                                move_uploaded_file($fileTmpName, $fileDestination);
                                $unControleur->changerHabitation($_POST, $fileNameNew);
                                echo "Votre propriété a été ajouté avec succès !";
                            } else {
                                echo "Votre fichier est trop volumineux !";
                            }
                        } else {
                            echo "Une erreur est survenue lors de l'upload !";
                        }
                    } else {
                        echo "Vous ne pouvez pas uploader ce type de fichier !";
                    }
                    
                

    
                }
            }
        else{
            echo "Cette propriétée ne vous appartient pas !";
        }


        echo "</div>";
    


    }

?>