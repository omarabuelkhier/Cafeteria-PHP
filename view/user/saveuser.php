<?php
require '../../db.php';


$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmpassword'];
$room = $_POST['room'];
$ext = $_POST['ext'];
$permissions = $_POST['permission_id'];

$passwordRegex = "/^([a-z0-9_]){8}$/";


$errors = [];
$old_data = [];
$data = [];

foreach ($_POST as $key => $value) {
    if (empty($value)) {

        $errors[$key] = "please enter a valid {$key}";
    } else {
        if ($key == "password") {
            if (!preg_match($passwordRegex, $value)) {
                $errors['password'] = "Invalid password";
                $value = null;
            } else {
                $value = null;
            }
        }
        if ($key == "confirmpassword") {
            if ($_POST['password'] != $value) {
                $errors['confirmpassword'] = "Password Don't Match";
            }
        }
        $old_data[$key] = $value;
    }
}

if (empty($_FILES['image']['tmp_name'])) {
    $errors['image'] = "Image is required";
} else {
    $extion = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    // var_dump($ext);
    if (!in_array($extion, ["jpg", "jpeg", "png"])) {
        $errors['image'] = "Only JPG, JPEG, PNG files are allowed";
    }

}
if ($errors) {
    $errors = json_encode($errors);
    $url = "Location: Create.php?error={$errors}";
    if ($old_data) {
        $old_data = json_encode($old_data);
        $url .= "&old_data={$old_data}";
    }
    header($url);
} else {

    $img_time = time();

    $temp_name = $_FILES['image']['tmp_name'];

    $image_name = $_FILES['image']['name'];

    $image_path = "images/{$img_time}.{$extion}";

    $saved = move_uploaded_file($temp_name, $image_path);


    try {
        $inst_query = "Insert into `users`(`name`,`email`, `password` , `room` ,`ext`, `image`, `permission_id`) 
        values(:username , :useremail , :userpassword ,:userroom , :userext ,:userimage ,:permission_id);";

        $stmt = $db->prepare($inst_query);

        $stmt->bindParam(':username', $name, PDO::PARAM_STR);
        $stmt->bindParam(':useremail', $email, PDO::PARAM_STR);
        $stmt->bindParam(':userpassword', $password, PDO::PARAM_STR);
        $stmt->bindParam(':userroom', $room, PDO::PARAM_STR);
        $stmt->bindParam(':userext', $ext, PDO::PARAM_STR);
        $stmt->bindParam(':userimage', $image_path);
        $stmt->bindParam(':permission_id', $permissions);

        $res = $stmt->execute();
        if ($db->lastInsertId()) {
            header("Location: alluser.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }


};
