<?php
require "../../db.php";
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    try {
        $select_order = "SELECT id,order_date, amount FROM orders WHERE user_id = :user_id";
        $stmt = $db->prepare($select_order);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($orders);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

