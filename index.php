<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Laisse pas traîner ton File</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Laisse pas traîner ton File...</header>
    <form action="/" enctype="multipart/form-data" method="post">
        <div>
            <label for='upload'>Sélectionner vos fichiers:</label><br>
            <input id='upload' name="upload[]" type="file" multiple="multiple"/>
        </div>
        <input type="submit" name="submit" value="submit">
    </form>
    <br><br>
    <div class="row">
        <?php require 'upload.php' ?>
    </div>
    <footer>Si tu veux pas qu'il glisse..</footer>
</body>
</html>

<?php

if (isset($_FILES['submit']) && $_FILES['upload']['error'] <> 0) {
    if (!empty($_FILES['upload']['name'][0])) {

        $files = $_FILES['upload'];
        $allowedType = ['jpg', 'png', 'gif'];
        $uploaded = [];
        $failed = [];

        foreach ($files['name'] as $position => $file_name) {

            $file_tmp = $files['tmp_name'][$position];
            $file_size = $files['size'][$position];
            $file_ext = pathinfo($files['name'][$position], PATHINFO_EXTENSION);

            if (in_array($file_ext, $allowedType)) {

                if ($file_size <= 1048576) {

                    $file_name_new = uniqid() . '.' . $file_ext;
                    $file_destination = 'uploads/' . $file_name_new;

                    if (move_uploaded_file($file_tmp, $file_destination)) {

                        $uploaded[$position] = $file_destination;

                    } else {

                        $failed[$position] = [$file_name];

                    }

                } else {

                    $failed[$position] = "[{$file_name}] is too large!";
                }

            } else {

                $failed[$position] = "[{$file_name}] file extension '{$file_ext}' is not allowed";
            }
        }
    }
} else {
    return 'You should select at least one file';
}

?>