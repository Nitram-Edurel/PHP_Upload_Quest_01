<?php
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $uploadDir = 'public/uploads/';
        $uploadFile = $uploadDir . uniqid() . basename($_FILES['avatar']['name']);
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $extensions_ok = ['jpg', 'webp', 'png', 'gif'];
        $maxFileSize = 1000000;

        $errors = [];
        $data = array_map('trim', $_POST);

        if( (!in_array($extension, $extensions_ok))){
            $errors[] = 'Veuillez sélectionner une image de type Jpg, un Webp, un Png ou bien un Gif !';
        }

        if(empty($data['firstname'])) {
            $errors[]= 'Firstname is required !';
        }

        if(empty($data['lastname'])) {
            $errors[]= 'Lastname is required !';
        }

        if(empty($data['age'])) {
            $errors[]= 'Age is required !';
        }

        if(empty($data['age'] < 100)) {
            $errors[]= 'You are too old mate !';
        }

        if(empty($data['age'] > 18)) {
            $errors[]= 'Wow you are damn too young kid!';
        }

        if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
        {
            $errors[] = "Attention votre fichier doit faire moins de 1M !";
        }
        if(empty($errors)){
            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        } else {
            foreach($errors as $error){
                echo $error . '<br>';
            }
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homer veut ajouter sa photo de profil</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
        <label for=firstname>Quel est votre prénom ?</label>
        <input type="text" name="firstname" id="firstname" required><br>

        <label for="lastname">Quel est votre nom ?</label>
        <input type="text" name="lastname" id="lastname" required><br>

        <label for="age">Quel est votre age ?</label>
        <input type="number" name="age" id="age" required><br>

        <label for="imageUpload">Upload an profile image</label><br>
        <input type="file" name="avatar" id="imageUpload" required/><br>
        <button name="send">Send</button><br>
        <button name="delete">Delete</button>
    </form>
    <?php foreach($_POST as $_post) : ?>
        <p><?= $_post ?></p>
        <?php endforeach; ?>

    <?= '<img src=' . $uploadFile . '/>' ?>
     

</body>
</html>