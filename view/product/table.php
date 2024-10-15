<?php
require "../../authentication_admin.php";
require '../../db.php';
require '../../utils.php';

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

    <?php


    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    if ($db) {
        try {
            $row_per_page = 3;
            $start = 0;
            $select_stmt = "SELECT COUNT(*) FROM product";
            $stmt = $db->query($select_stmt);
            $num_row = $stmt->fetchColumn();
            $pages = ceil($num_row / $row_per_page);
            if (isset($_GET['page-nr'])) {
                $page = intval($_GET['page-nr']);
                if ($page > 0 && $page <= $pages) {
                    $start = ($page - 1) * $row_per_page;
                } else {
                    $start = 0;
                }
            }
            $select_qry = "SELECT * FROM `product` LIMIT :start, :row_per_page;";
            $stmt1 = $db->prepare($select_qry);
            $stmt1->bindValue(':start',$start, PDO::PARAM_INT);
            $stmt1->bindValue(':row_per_page',$row_per_page, PDO::PARAM_INT);
            $result = $stmt1->execute();
            $products = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    echo " <div class='card mt-5 w-75 m-auto' >
        <h4 class='card-header fw-bold'>
            Product
        </h4>
        <div class='card-body'>";
    if ($products) {

        echo "<div>  
        <table class='table table-bordered '> 
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Image</th>
            <th>Available</th>
            <th>Update</th>
            <th>Delete</th>
         </tr>
    ";
        //    print_r($users);
        foreach ($products as $product) {
            echo "<tr>
                    <td>{$product["id"]}</td>
                    <td>{$product["name"]}</td>
                    <td > {$product["price"]} </td>
                    <td><img src='{$product["image"]}' width='50' height='50' class='mx-2'></td>
                    <td>";
                if ($product["status"] == 1){
                       echo "<a class='btn btn-success' onclick='changeProductStatus({$product['id']},{$product['status']})' >Avaliable</a>";
                }
                else{
                    echo "<a class='btn btn-dark' onclick='changeProductStatus({$product['id']},{$product['status']})' >Not Avaliable</a>";
                }
              echo  "</td>
                    <td><a href='update.php?id={$product["id"]}' class='btn btn-primary'>Update</a></td>
                    <td><a href='delete.php?id={$product["id"]}' class='btn btn-danger'>Delete</a></td>
                    <tr>";

        }
    }
  ?>
    </table>
        <nav aria-label="Page navigation example">
     <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="?page-nr=1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>

    <li class="page-item">
      <a class="page-link" href="?page-nr=<?= $pages;?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>

    <div class='row mt-4'>
                    <div class='col-12'>
                        <div class=''>
                            <a class='btn' href='product.php'  style='background-color: #23569c ;color: white' type='submit' >Add New Product</a>
                        </div>
          </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="../../assets/script.js"></script>
    </div>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script>
    function changeProductStatus(productId,status) {

    $.ajax({
        url: 'changeProductStatus.php',
        type: 'POST',
        data: {productId:productId,status:status},
        success: function () {
            location.reload();
        },
        error: function () {
            alert('Failed to change product status');
        }
    })
    }
</script>
</body>
</html>
    