<?php
require "../../db.php";
if ($db) {
    if (isset($_REQUEST['order_id'])) {
        try {
            $update_order = "UPDATE orders SET status = 'Out For Delivery' 
        where id =:order_id ";
            $stmt = $db->prepare($update_order);
            $stmt->bindParam(':order_id', $_REQUEST['order_id'], PDO::PARAM_INT);
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($orders);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}