<?php

require "../../db.php";
require "../../utils.php";

$name = $_POST["name"];
$id = $_POST["id"];
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
    $url = "Location: edit.php?error={$errors}";
    if ($old_data) {
        $old_data = json_encode($old_data);
        $url .= "&old_data={$old_data}";
    }
    header($url);
} else {

    try {
        $inst_query = "update `categories` set `name` = :category_name where `id` = :id";

        $stmt = $db->prepare($inst_query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(':category_name', $name);
        $res = $stmt->execute();
        if ($stmt->rowCount()>0) {
            header("Location: table.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }


}
