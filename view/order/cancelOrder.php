<?php
require "../../utils.php";
require "../../db.php";

$id = $_GET['order_id'];
if ($db){
    if ($id){
        try {
            $delete_query = "DELETE FROM orders WHERE id = :order_id";
            $stmt = $db->prepare($delete_query);
            $stmt->bindParam(":order_id", $id, PDO::PARAM_INT);
            $stmt->execute();
            header("Location: myOrder.php");
        }catch (PDOException $e) {
            echo $e->getMessage();
        }
}
}
