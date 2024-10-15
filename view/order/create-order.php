<?php
require "../../utils.php";
session_start();
if ($_SESSION["login"] == true) {
}else{
    $_SESSION=[];
    session_destroy();
    header("Location: ../Login/login.php");
}
require "../../db.php";
if ($db && $_SESSION["permission"] == 2 ) {

    try {
        $select_qry = "SELECT  * FROM `order_items` order by id desc LIMIT 1;";
        $stmt = $db->query($select_qry);
        $orders = $stmt->fetch(PDO::FETCH_ASSOC);
        if (isset($orders["order_id"])){
           $order_id= $orders["order_id"];
        }else{
            $order_id = null;
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
    /* Select Last Order*/
    if (isset($order_id)){
        try {
            $select_qry2 = "SELECT name , price, image FROM order_items 
         inner join product  on product.id = order_items.product_id
        WHERE `order_id` = $order_id";
            $stat2 = $db->prepare($select_qry2);
            $stat2->execute();
            $products = $stat2->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }else{
        $products = [];
    }

}
if($db){
    /*Select Products*/
    try {
        $select_Product = "SELECT id ,name , image , price  FROM product where status = '1' ";
        $stat1 = $db->prepare($select_Product);
        $stat1->execute();
        $allProduct = $stat1->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
if ($db && $_SESSION['permission'] == 1 ){
    try {
        $select_user = "SELECT * from users where permission_id = 2 ";
        $stat1 = $db->prepare($select_user);
        $stat1->execute();
        $users = $stat1->fetchAll(PDO::FETCH_ASSOC);
    }catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cafeteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
</head>
<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
<link rel="stylesheet" href="../../assets/style.css">

<body>
<?php include("../../layouts/sidebar.php"); ?>
<div class="main p-3">
    <?php include("../../layouts/navbar.php"); ?>
    <div class="mt-3 ">
        <div class="row ">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <form action="saveOrder.php" method="post">
                        <div class="row">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Qnt</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="append-product"></tbody>

                            </table>
                            <div class="form-group mt-5">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" name="notes" id="notes"></textarea>
                            </div>
                            <div class="input-group mt-3">
                                <span class="input-group-text">Room No.</span>
                                <select class="form-select" aria-label="Default select example" name="room">
                                    <option selected disabled></option>
                                    <option value="application_1">Application 1</option>
                                    <option value="application_2">Application 2</option>
                                    <option value="cloud">Cloud</option>
                                </select>
                            </div>
                            <hr style="border: #0f1010 5px " class="mt-3">
                            <h4>
                                Total :
                                <span   class="total-order" >
                                    0</span> EGP</h4>

                        </div>
                            <div class="d-grid gap-2">

                                <button type="submit" id="add-order-btn" class="btn btn-lg  disabled" style="background-color: #153257;color: white; border-radius: 20px">Submit </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-8 ">
                <?php if ($_SESSION["permission"] == 1 ):?>
                    <input type="hidden" id="user-permission1" value="<?php echo $_SESSION['permission']; ?>">

                    <div class="card  mb-5" style="height: 150px">
                        <h6 class="card-header fw-bold  " style="background-color: #153257;height:">
                            Add To User
                        </h6>
                        <div class="card-body">
                            <div class="row ">
                                <div class="d-flex m-auto">
                                    <span class="input-group-text pe-5 ps-4 fw-bold ">User</span>
                                    <select id="GetUserId" name="user_id" class="form-control " >
                                        <option selected  disabled>Select User</option>
                                        <?php foreach ($users as $user) { ?>
                                            <option value="<?php echo $user['id']  ?>" ><?php echo $user['name'] ?>
                                            </option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else:?>
                    <!--Last Order Product-->
                <div class="card">
                    <h6 class="card-header  fw-bold  " style="background-color: #153257">
                        Last Order
                    </h6>
                    <div class="card-body">
                        <div>
                            <div class='row'>
                                <?php foreach ($products as $product): ?>
                                    <div class='col-md-3 col-lg-2 mb-2 '>
                                        <div class='card' style='border-radius: 20px;'>
                                            <img src='../product/<?php echo ($product["image"])?>' class='card-img-top'
                                                 style='height: 150px;  border-radius: 20px 20px 0 0; '
                                                 alt='Product Image'>
                                            <div class='card-body'
                                                 style='background-color: #153257; border-radius: 0 0 20px 20px; color: white;'>
                                                <h5 class='card-title fw-bold text-center'><?php echo($product['name']); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border: #0f1010 2px solid">
                <?php endif;?>

                <!--all product-->
                <div class="card">
                    <h5 class="card-header fw-bold " style="background-color: #153257">
                        Products
                    </h5>
                    <div class="card-body">

                        <div class="container">
                            <div class='row'>
                                <?php foreach ($allProduct as $product): ?>
                                    <div class='col-md-4 col-lg-2 mt-2'>

                                        <div class='card h3 position-relative' style='border-radius: 20px; '>
                                             <span class="position-absolute  translate-middle badge rounded-pill " style="background-color: #0e223e ;  top:10px;left: 150px;width: 50px; height: 50px"   >
                                               <?php echo ($product["price"])?>
                                               </span>
                                            <button class="add-product"
                                                    style='border:none; border-radius: 20px 20px 0 0;'
                                                    id="product-<?php echo($product['id']) ?>"
                                                    data-name="<?php echo($product['name']) ?>"
                                                    data-price="<?php echo($product['price']) ?>"
                                                    data-id="<?php echo($product['id']) ?>">
                                                <img src='../product/<?php echo ($product["image"])  ?>' class='card-img-top bg-white  '
                                                     style='height: 150px; width: 165px; border-radius: 20px 20px 0 0; margin-left: -6px'
                                                     alt='Product Image'>
                                            </button>
                                            <div class='card-body'
                                                 style='background-color: #153257; border-radius: 0 0 20px 20px; color: white;'>
                                                <h4 class='card-title  text-center'><?php echo($product['name']); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>


                               <?php
                   ?>
                           </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="../../assets/script.js"></script>
<script src="cart.js"></script>
</body>
</html>
