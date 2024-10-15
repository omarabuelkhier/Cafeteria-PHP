<?php
session_start();
require "../../db.php";
if (isset($_GET['from']) && isset( $_GET['to'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];
    try {
        $stmt = $db->prepare("SELECT * FROM orders WHERE user_id = :user_id and order_date between :date_from and :date_to ");
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->bindParam(':date_from', $from);
        $stmt->bindParam(':date_to', $to);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($items);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

