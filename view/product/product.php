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
<?php require "../../layouts/sidebar.php"; ?>
<div class="main p-3">
    <?php include("../../layouts/navbar.php"); ?>

    <?php
    require "../../db.php";
    require "../../utils.php";
    if (isset($_GET['old_data'])) {
        $old_data = json_decode($_GET['old_data'], true);
        // var_dump($old_data);
    }


    if ($db) {
        try {
            $select_stmt = "SELECT * FROM categories;";
            $stmt = $db->prepare($select_stmt);
            $res = $stmt->execute();
            $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($permissions);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Add Product</h4>
            </div>
            <div class="card-body">
                <form action="validation.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3 input-group ">
                        <label for="product" class="input-group-text fw-bold">Product</label>

                        <input type="text" class="form-control" id="product" name="name"
                               placeholder="Chosse Drink"
                               value="<?php $val = isset($old_data['name']) ? $old_data['name'] : "";
                               echo $val ?>" required>
                    </div>

                    <div class="mb-3 input-group">
                        <label for="price" class="input-group-text pe-4 fw-bold">Price</label>
                        <input type="number" step="1" class="form-control me-2" id="price" name="price"
                               placeholder="Price"
                               value="<?php $val = isset($old_data['price']) ? $old_data['price'] : "";
                               echo $val ?>" required>

                    </div>

                    <div class=" input-group">
                        <label for="category" class="input-group-text fw-bold">Category</label>
                        <select class="form-select me-2" id="category" name="category" required>
                            <option selected disabled>.....</option>
                            <?php foreach ($category as $cat) { ?>
                                <option value="<?php echo $cat['id'] ?>"><?php echo $cat['name'] ?>
                                </option>
                            <?php }
                            ?>

                        </select>

                    </div>
            </div>

            <div class="ms-3 input-group">
                <input type="file" class="form-control " name="image">
                <label for="picture" class="input-group-text me-5 fw-bold">Product picture</label>
            </div>

            <div class="row mt-4">
                <div class="col-6">
                    <div class="d-grid gap-2 ">
                        <button class="btn" style="background-color: #23569c ;color: white"
                                type="submit">Save
                        </button>
                    </div>

                </div>
                <div class="col-6">
                    <div class="d-grid gap-2">
                        <button class="btn" style="background-color: #153257;color: white"
                                type="reset">Reset
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="../../assets/script.js"></script>
</body>

</html>