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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
<link rel="stylesheet" href="../../assets/style.css">

<body>
    <?php include ("../../layouts/sidebar.php"); ?>
    <div class="main p-3">
        <?php include ("../../layouts/navbar.php"); ?>

        <?php
        require "../../db.php";

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        if (isset($_GET['old_data'])) {
            $old_data = json_decode($_GET['old_data'], true);
        }
        $id = $_GET["id"];

        if ($db) {
            try {
                $select_stmt = "SELECT * FROM categories;";
                $stmt = $db->prepare($select_stmt);
                $res = $stmt->execute();
                $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        if ($id && $db) {
            try {
                $select_query = "select * from product where id=:id";
                $stmt = $db->prepare($select_query);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $img_path = $data["image"];
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        ?>

        <body>
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header">
                        <h2>Add Product</h2>
                    </div>
                    <div class="card-body">
                        <form action="updatevalidation.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                            <div class="mb-3 input-group">
                                <label for="product" class="input-group-text fw-bold">Product</label>
                                    <input type="text" class="form-control" id="product" name="name"
                                        placeholder="Chosse Drink" value="<?php $val = isset($data['name']) ? $data['name'] : "";
                                        echo $val ?>" required>
                            </div>

                            <div class="mb-3 input-group">
                                <label for="price" class="input-group-text pe-4 fw-bold">Price</label>
                                    <input type="number" step="1" class="form-control me-2" id="price" name="price"
                                        placeholder="Price" value="<?php $val = isset($data['price']) ? $data['price'] : "";
                                        echo $val ?>" required>
                            </div>

                            <div class="mb-3 input-group">
                                <label for="category" class="input-group-text fw-bold">Category</label>
                                    <select class="form-select me-2" id="category" name="category" required>
                                        
                                        <option>.....</option>

                                        <?php foreach ($category as $cat) { 
                                            if ($cat['id'] == $data['category_id']) {
                                                echo '<option selected value="'. $cat['id']. '">'. $cat['name']. '</option>';
                                            } else {
                                                echo '<option value="'. $cat['id']. '">'. $cat['name']. '</option>';
                                            }
                                        }
                                        ?>
                                       

                                      
                                    </select>

                            </div>

                            <div class="mb-3 input-group">
                                    <input type="file" class="form-control" name="image">
                                    <label for="picture" class="input-group-text me-5 fw-bold">Product picture</label>
                            </div>

                            <div class="row mt-4">
                                <div class="col-6">
                                    <div class="d-grid gap-2 ">
                                        <button class="btn" style="background-color: #23569c ;color: white"
                                            type="submit">Update
                                        </button>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="d-grid gap-2">
                                        <a class="btn" href="table.php" style="background-color: #153257;color: white"
                                            type="reset">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="../../assets/script.js"></script>
</body>

</html>