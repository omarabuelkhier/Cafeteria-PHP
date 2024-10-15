<?php
require "../../utils.php";
require "../../db.php";
session_start();
if ($_SESSION['permission'] == 2){
    $user_id =intval($_SESSION["user_id"]);
}else{
    $user_id =intval($_REQUEST["user_id"]);
}

$amount = array_sum($_REQUEST["total_price"]);
$order_date =date("Y-m-d H:i:s");
if ($db){
    try {
        $insertOrder = "insert into orders (user_id,amount,order_date) values (:user_id,:amount,:order_date);";
        $stmt = $db->prepare($insertOrder);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':order_date', $order_date);
        $res= $stmt->execute();
        $order_id = intval($db->lastInsertId());
    }catch(PDOException $e){
        echo $e->getMessage();
    }

}
foreach($_POST["product"] as $index => $product) {
    $product_id = intval($product);
    $quantity = intval($_REQUEST["quantity"][$index]);
    $total_price = intval($_REQUEST["total_price"][$index]);
    try {
        $insertOrderItems = "insert into order_items (order_id, product_id, quantity, total_price)
        values (:order_id, :product_id, :quantity, :total_price);";
        $stmt = $db->prepare($insertOrderItems);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->execute();
        if ($_SESSION["permission"] == 1){
            header("Location: order.php");
        }else{
            header("Location: myOrder.php");
        }
}catch (PDOException $e) {
        echo $e->getMessage();
    }
}