<?php
require "../../db.php";
if ($db) {
    if ($_REQUEST['status'] == 1) {
        try {
            $update_status = "UPDATE `product` SET `status` = 0 
        where id =:product_id ";
            $stmt = $db->prepare($update_status);
            $stmt->bindParam(':product_id', $_REQUEST['productId'], PDO::PARAM_INT);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($products);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }else {
        try {
            $update_status = "UPDATE `product` SET `status` = 1 
        where id =:product_id ";
            $stmt = $db->prepare($update_status);
            $stmt->bindParam(':product_id', $_REQUEST['productId'], PDO::PARAM_INT);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($products);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}