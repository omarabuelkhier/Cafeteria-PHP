<?php

require "../../db.php";
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    try {
        $select_items = "SELECT name , price, image , quantity FROM order_items 
         inner join product  on product.id = order_items.product_id
        WHERE `order_id` = :order_id";
        $stat2 = $db->prepare($select_items);
        $stat2->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stat2->execute();
        $items = $stat2->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($items);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

