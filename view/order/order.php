<?php
require "../../db.php";
require "../../authentication_admin.php";
if ($db) {
    try {
        $stmt = $db->prepare("SELECT  name , orders.id,order_date,amount ,room , ext  FROM orders 
                                      inner join users on users.id = orders.user_id
                                      where status = 'Processing'");
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
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
    <div class="card mt-3">
        <h6 class="card-header ">
            Orders
        </h6>
        <div class="card-body">
            <?php
            foreach ($orders as $index => $order) :
                ?>
                <div class="table-responsive m-auto " style="width: 1500px">
                    <table class=" table table-bordered  mt-4">
                        <thead style="background-color: #0e223e;color: white">
                        <tr>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Room</th>
                            <th>Ext</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $order["order_date"] ?></td>
                            <td><?php echo $order["name"] ?></td>
                            <td><?php echo $order["room"] ?></td>
                            <td><?php echo $order["ext"] ?></td>
                            <td><a href="#" class="btn btn-primary" onclick="changeStatus(<?php echo $order["id"] ?>)">Deliver</a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <?php
                    try {
                        $stmt2 = $db->prepare("SELECT name , price, image , quantity FROM order_items 
         inner join product  on product.id = order_items.product_id
        WHERE order_id = :order_id");
                        $stmt2->bindParam(':order_id', $order["id"], PDO::PARAM_INT);
                        $stmt2->execute();
                        $products = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                    <div class="accordion container">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-<?php echo $index ?>" aria-expanded="true"
                                        aria-controls="panelsStayOpen-<?php echo $index ?>">
                                    Products
                                </button>
                            </h2>
                            <div id="panelsStayOpen-<?php echo $index ?>" class="accordion-collapse collapse show"
                                 aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <div class="card">
                                        <h6 class="card-header fw-bold " style="background-color: #153257">
                                            Products
                                        </h6>
                                        <!--Last Order Product-->
                                        <div class="card-body">

                                            <div class="container ">
                                                <div class='row'>
                                                    <?php foreach ($products as $product): ?>
                                                        <div class='col-2 mt-3'>

                                                            <div class='card h3 position-relative'
                                                                 style='border-radius: 20px; '>
                                             <span class="position-absolute  translate-middle badge rounded-pill "
                                                   style="background-color: #0e223e ;  top:10px;left: 170px;width: 50px; height: 50px">
                                               <?php echo($product["price"]) ?>
                                               </span>

                                                                <img src='../product/<?php echo($product["image"])?>'
                                                                     class='card-img-top bg-white '
                                                                     style='height: 150px; border-radius: 20px 20px 0 0;'
                                                                     alt='Product Image'>
                                                                <div class='card-body'
                                                                     style='background-color: #153257; border-radius: 0 0 20px 20px; color: white;'>
                                                                    <h5 class='card-title fw-bold text-center'><?php echo($product['name']); ?></h5>
                                                                </div>
                                                                <div class='position-relative    text-center'>
                                                                     <span class="position-absolute  translate-middle badge rounded-pill "
                                                                           style="background-color: #ffffff ; color: #153257;
                                                                               top:5px;left: 88px;width: 40px; height: 40px">
                                                                         <?php echo($product["quantity"]) ?>

                                                                                    </span>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer fw-bold h5">
                                        <span>
                                            Total : <?php echo($order["amount"]) ?>
                                        </span>
                                        </div>

                                        <?php
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="../../assets/script.js"></script>
<script
    integrity = "sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin = "anonymous" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="../../assets/script.js"></script>
<script>
    function changeStatus(order_id) {
        alert(order_id)
        $.ajax({
            url: 'changeStatus.php',
            type: 'POST',
            data: {order_id: order_id},
            success: function () {
                alert('Status updated successfully');
            },
            error: function () {
                alert('Error updating status');
            }
        })
    }
</script>
</body>
</html>