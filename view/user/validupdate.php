<?php


require "../../db.php";
// print_r($_REQUEST);
// exit;
$oldData = [];
$errors = [];
$id = $_REQUEST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmpassword'];
$room = $_POST['room'];
$ext = $_POST['ext'];
$permissions = $_POST['permission_id'];


$passwordRegex = "/^([a-z0-9_]){8}$/";
foreach ($_POST as $key => $value) {

    if (empty($value)) {
        $errors[$key] = "The {$key} field is required";
    } else {
        if ($key == "password") {
            if (!preg_match($passwordRegex, $value)) {
                $errors['password'] = "Invalid password";
                $value = null;
            } else {
                $value = null;
            }
        }
        if ($key == "confirm_password") {
            if ($_POST['password'] != $value) {
                $errors['confirm_password'] = "Password Don't Match";
            }
        }
        $oldData[$key] = $value;
    }
}

if (empty ($_FILES['image']['tmp_name'])) {
    $errors['image'] = "Please select a profile image";
} else {
    $extion = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    if (!in_array($extion, ["jpg", "jpeg", "png"])) {
        $errors['image'] = "Only JPG, JPEG, PNG files are allowed";
    }
}
if ($errors) {
    $errors = json_encode($errors);
    $url = "Location: edit.php?errors={$errors}";
    if ($oldData) {
        $oldData = json_encode($oldData);
        $url .= "&oldData={$oldData}";
    }

    header($url);
} else {
    $image_time = time();
    $temp_name = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    $image_path = "images/{$image_time}.{$extion}";
    $saved = move_uploaded_file($temp_name, $image_path);
if ($id && $db){


    try {
        $update_qry ="update `users` set `name`=:username,`email` =:useremail,`password` =:userpassword ,
                    `room`=:userroom,`ext`=:userext ,`image` =:userimage ,`permission_id`=:userpermission
                   where `id`=:anyid ;";
        
                   $update_stmt = $db->prepare($update_qry);

        $update_stmt->bindParam(":anyid" , $id);
        $update_stmt->bindParam(':username', $name, PDO::PARAM_STR);
        $update_stmt->bindParam(':useremail', $email, PDO::PARAM_STR);
        $update_stmt->bindParam(':userpassword', $password, PDO::PARAM_STR);
        $update_stmt->bindParam(':userroom', $room, PDO::PARAM_STR);
        $update_stmt->bindParam(':userext', $ext, PDO::PARAM_STR);
        $update_stmt->bindParam(':userimage', $image_path);
        $update_stmt->bindParam(':userpermission', $permissions);
        $result = $update_stmt->execute();
        // var_dump($result);
//         var_dump($update_stmt);

        if ($update_stmt->rowCount() > 0 ){
            header("Location: alluser.php");
        }
    }catch (exception $e){
        echo $e->getMessage();
    }
}

}
