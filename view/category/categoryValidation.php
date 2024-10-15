<?php
require "../../db.php";
require "../../utils.php";

$name = $_POST["name"];
$errors = [];
$old_data = [];

foreach ($_POST as $key => $value) {
    if (empty($value)) {

        $errors[$key] = "please enter a valid {$key}";
    } else {
        $old_data[$key] = $value;
    }
}


if ($errors) {
    $errors = json_encode($errors);
    $url = "Location: create.php?error={$errors}";
    if ($old_data) {
        $old_data = json_encode($old_data);
        $url .= "&old_data={$old_data}";
    }
    header($url);
} else {

    try{
        $inst_query = "Insert into `categories`(`name`) 
        values(:category_name);";

        $stmt = $db->prepare($inst_query);

        $stmt->bindParam(':category_name',$name);
        $res = $stmt->execute();
        if($db->lastInsertId()){
            header("Location: table.php");
        }
    }catch(PDOException $e){
        echo $e->getMessage();
    }



}
