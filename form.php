<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //////////////////declare la route vers le stockage des photos///////////////////
    $uploadDir = 'public/uploads/';

    ///////////////////////pathinfo récupére les info et PATHINFO_EXTENSION donc les extensions/////////////
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    ////////////////////declare une variable qui concaténe un id unique avec l'extension de l'image//////////////////////
    $fileName = uniqid() . '.' . $extension;

    ////////////////////////basename parametre la route du client au serveur//////////
    $uploadFile = $uploadDir . basename($fileName);

    ////////////////////////la fonction deplace la photo dans un dossiers temporaire//////
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);

    ///////////////on stocke dans un tableau les extensions que l'on autorises//////////
    $authorizedExtensions = ['jpg', 'gif', 'webp', 'png'];

    /////////////limitation du poids dans une variable//////////////
    $maxFileSize = 1000000;

    //////////////on cherche si l'extension est autorisé//////////////////
    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Format invalide (gif, jpg, png, webp)';
    }

    ///////////////on cherche si l'image existe et si son poids est inférieur à $maxFileSize/////////////
    if (file_exists($_FILES['image']['tmp_name']) && filesize($_FILES['image']['tmp_name']) > $maxFileSize) {
        $errors[] = 'Ton image doit faire moins de 1Mo';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homertic</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="form.php" method="post" enctype="multipart/form-data">
        <label for="imageUpload">✖️</label>
        <input type="file" name="image" id="image" />
        <button name="send">Allez envoie ta photo !</button>
        <button name="delete">Supprimer</button>
    </form>
</body>

</html>