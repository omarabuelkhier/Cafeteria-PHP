<?php
require "../../authentication_admin.php";
if (isset($_GET['error'])) {
    $errors = json_decode($_GET['error'], true);
}
;
if (isset($_GET['old_data'])) {
    $old_data = json_decode($_GET['old_data'], true);
}
;



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
    <div class="card mt-5 w-75 m-auto">
        <div class="card-header">
            Add Category
        </div>
        <div class="card-body">
            <form action="categoryValidation.php" method="post">


                <div class="input-group mb-3">
                    <span class="input-group-text">Name</span>
                    <input type="text" class="form-control" placeholder="Category Name" name="name" aria-label="Category Name" value="<?php $val = isset($old_data['name']) ? $old_data['name'] : "";
                    echo $val ?>">
                </div>
                <span style="color :red">
                     <?php $errorname = isset($errors['name']) ? $errors['name'] : '';
                     echo $errorname; ?>
                </span>



                <div class="row mt-4">
                    <div class="col-6">
                        <div class="d-grid gap-2 ">
                            <button class="btn" style="background-color: #23569c ;color: white" type="submit">Create</button>
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="d-grid gap-2">
                            <button class="btn" style="background-color: #153257;color: white"  type="submit">Reset</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>



</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="../../assets/script.js"></script>
</body>
</html>