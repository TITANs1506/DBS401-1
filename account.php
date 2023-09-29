<?php
require_once 'header.php';

if (isset($_POST['upgrade'])) {
    if (isset($_FILES) && !empty($_FILES)) {
        $uploadpath = "/var/tmp/";
        $error = "";

        $timestamp = time();

        $userValue = $_COOKIE['user'];
        $target_file = $uploadpath . $userValue . "_" . $timestamp . "_" . $_FILES["image"]["name"];

        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        if ($_FILES["image"]["size"] > 1048576) {
            $error .= '<p class="h5 text-danger">Maximum file size is 1MB.</p>';
        } elseif ($_FILES["image"]["type"] !== "image/jpeg") {
            $error .= '<p class="h5 text-danger">Only JPG files are allowed.</p>';
        } else {
            $exif = exif_read_data($target_file, 0, true);

            if ($exif === false) {
                $error .= '<p class="h5 text-danger">No metadata found.</p>';
            } else {
                $metadata = '<table class="table table-striped">';
                foreach ($exif as $key => $section) {
                    $metadata .=
                        '<thead><tr><th colspan="2" class="text-center">' .
                        $key .
                        "</th></tr></thead><tbody>";
                    foreach ($section as $name => $value) {
                        $metadata .=
                            "<tr><td>" . $name . "</td><td>" . $value . "</td></tr>";
                    }
                    $metadata .= "</tbody>";
                }
                $metadata .= "</table>";
            }
        }
    }
}
?>
<div class="container mt-5">
    <?php
    $sql = sqlSelect($conn, 'select * from users where id = ? LIMIT 1', 'i', 2);
    if ($sql && $sql->num_rows == 1) {
        $row = $sql->fetch_assoc();
        $id = $row['id'];
        $username = $row['username'];
        $acc_image = $row['images'];
        echo "<div class='mb-5'>
        <strong>User $username:</strong>
        <div class='row'>
            <div class='col-sm-7'>
                <form action='' method='post' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <label>User name</label>
                        <input type='text' class='form-control' placeholder='{$username}' name='accname' readonly>
                    </div>
                    <div class='form-group'>
                        <label>Update image</label>
                        <input type='file' class='form-control' name='accimg'>
                    </div>
                    <div>
                        <button type='submit' class='btn btn-outline-primary btn-sm' name='update'>Update</button>
                    </div>
                </form>
            </div>
            <div class='col-sm-5 text-center align-self-center'>
                <label>User image</label>
                <img src='images/$acc_image' class='rounded mx-auto' alt='Item image' width='400'>
            </div>
        </div>
    </div>";
        // I want to show a loading effect within 1.5s here but don't know how
        sleep(1.5);
        // This might be okay..... I think so
        // My teammates will help me fix it later, I hope they don't forget that
        echo $error;
        echo $metadata;
        unlink($target_file);
    }
    ?>