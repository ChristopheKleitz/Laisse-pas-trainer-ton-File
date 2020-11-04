<?php
if (isset($_POST['submit']) && empty($_POST['upload'])) {
    if (!empty($_FILES['upload']['name'][0])) {

        $files = $_FILES['upload'];
        $allowedType = ['jpg', 'png', 'gif'];

        foreach ($files['name'] as $position => $file_name) {

            $file_tmp = $files['tmp_name'][$position];
            $file_size = $files['size'][$position];
            $file_ext = pathinfo($files['name'][$position], PATHINFO_EXTENSION);

            if (in_array($file_ext, $allowedType)) {

                if ($file_size <= 1048576) {

                    $file_name_new = uniqid() . '.' . $file_ext;
                    $file_destination = 'uploads/' . $file_name_new;

                    if (move_uploaded_file($file_tmp, $file_destination)) {

                        ?>

                        <div class="card mb-3 col-3">
                            <img class="card-img-top" src="<?php echo $file_destination ?>" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $file_name ?></h5>
                            </div>
                        </div>

                    <?php
                    } else {

                        return "Loading error...";

                    }

                } else {

                    return "Your file is too large, get him to the gym !";
                }

            } else {

                return "Extension not allowed ! Only jpg, gif or png please";
            }
        }
    }
} else {
    return 'You should select at least one file';
}


