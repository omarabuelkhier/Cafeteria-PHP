<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require "../../db.php";

// print_r($_REQUEST);
// print_r($_FILES);
// exit;

$oldData = [];
$errors = [];
$category = $_REQUEST['category'];
$id = $_REQUEST['id'];
// var_dump($category);
// exit;

foreach ($_POST as $key => $value) {

    if (empty($value)) {
        $errors[$key] = "The {$key} field is required";
    } else {
        $oldData[$key] = $value;
    }
}

if (empty($_FILES['image']['tmp_name'])) {
    $errors['image'] = "Please select a profile image";
} else {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    if (!in_array($ext, ["jpg", "jpeg", "png"])) {
        $errors['image'] = "Only JPG, JPEG, PNG files are allowed";
    }
}
if ($errors) {
    echo "all Field Is Required";
    $errors = json_encode($errors);
    $url = "Location: product.php?errors={$errors}";
    if ($oldData) {
        $oldData = json_encode($oldData);
        $url .= "&oldData={$oldData}";
    }
    header($url);
} else {

    $img_time = time();

    $temp_name = $_FILES['image']['tmp_name'];

    $image_name = $_FILES['image']['name'];

    $image_path = "image/{$img_time}.{$ext}";

    $saved = move_uploaded_file($temp_name, $image_path);

    try {
        $insert_query = "update `product` set `name`=:username,`price` =:userprice,`image` =:userimage ,`category_id`=:usercategory_id
                   where `id`=:anyid ;";

        $insert_stmt = $db->prepare($insert_query);
        $insert_stmt->bindParam(":anyid", $id);
        $insert_stmt->bindParam(':username', $_POST['name']);
        $insert_stmt->bindParam(':userprice', $_POST['price']);
        $insert_stmt->bindParam(':usercategory_id', $category);
        $insert_stmt->bindParam('userimage', $image_path);
        $insert_stmt->execute();

        if ($insert_stmt->rowCount() > 0) {
            header("Location:table.php");
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}
