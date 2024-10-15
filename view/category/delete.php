<?php
require "../../utils.php";
require "../../db.php";

$id = $_GET['id'];
if ($id && $db) {
    try{



        $delete_qeury = "delete from `categories` WHERE id=:userid";
        $stmt_del = $db->prepare($delete_qeury);
        $stmt_del->bindParam(":userid", $id, PDO::PARAM_INT);
        $res = $stmt_del->execute();

        $select_query = "select * from `categories` where id=:id";
            $stmt =$db->prepare($select_query);
            $stmt->bindParam(":id",$id,PDO::PARAM_INT);
            $stmt->execute();
            $obj = $stmt->fetch(PDO::FETCH_ASSOC);
//            $img_path = $obj["image"];
//            if(file_exists($img_path)){
//                unlink($img_path);
//            }




        header("Location: table.php");
    }catch(PDOException $e){
        echo $e->getMessage();
    }


}
