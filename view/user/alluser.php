<?php
require "../../authentication_admin.php";
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
require "../../db.php";


if($db){
    try {
        $row_per_page = 3;
        $start = 0;
        $select_stmt = "SELECT COUNT(*) FROM users";
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

        $select_stmt1 = "SELECT * FROM users LIMIT :start, :row_per_page";
        $stmt1 = $db->prepare($select_stmt1);
        $stmt1->bindParam(':start',$start, PDO::PARAM_INT);
        $stmt1->bindParam(':row_per_page',$row_per_page, PDO::PARAM_INT);
        $stmt1->execute();
        $users = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}
    echo " <div class='card mt-5 w-75 m-auto' >
        <h4 class='card-header fw-bold'>
            Users
        </h4>
        <div class='card-body'>";
    if ($users) {

        echo "
    <table class='table table-bordered ' >  
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Room</th>
        <th>Image</th>
        <th>Ext</th>
        <th>Delete</th>
        <th>update</th>


     </tr>";
        foreach ($users as $user) {
            echo "<tr  > 
            <td> {$user['id']}</td>
            <td> {$user['name']}</td>
            <td> {$user['room']}</td>
            <td><img src='{$user['image']}' width='50' height='50'></td>
            <td> {$user['ext']}</td>
            <td><a href='delete.php?id={$user['id']}' class='btn btn-danger'>Delete</a></td>
            <td><a href='edit.php?id={$user['id']}' class='btn btn-primary'>Update</a></td>

        </tr>";

        }
        echo "
        ";

    }
    echo "</table>";


     ?>
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
                            <a class='btn' href='Create.php'  style='background-color: #23569c ;color: white' type='submit' >Add new User</a>
                        </div> 
                        </div>






</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="../../assets/script.js"></script>
</body>
</html>