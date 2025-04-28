<?php
  
  require_once("vue/propriete/propriete.php");


// Vérifie si le formulaire a été soumis
if(isset($_POST["submit"])) {
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
                $unControleur->ajouterPropri($_POST,$fileNameNew);
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
  
    
?>