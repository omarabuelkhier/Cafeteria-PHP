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
        if (isset($_GET["oldData"])) {
            $oldData = json_decode($_GET["oldData"], true);
        }
        if (isset($_GET["errors"])) {
            $errors = json_decode($_GET["errors"], true);
        }
        if ($db) {
            try {
                $select_stmt = "SELECT * FROM permissions;";
                $stmt = $db->prepare($select_stmt);
                $res = $stmt->execute();
                $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        $id = $_GET["id"];

        // var_dump($old_data);
        if ($id && $db) {
            try {
                $select_query = "select * from users where id=:id";
                $stmt = $db->prepare($select_query);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
                $old_data = $stmt->fetch(PDO::FETCH_ASSOC);
                $img_path = $old_data["image"];
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        ?>
        <div class="card mt-5 w-75 m-auto">
            <div class="card-header">
                Update User
            </div>
            <div class="card-body">
                <form action="validupdate.php" method="post" enctype="multipart/form-data">




                    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
                    <div class="input-group mt-3 ">
                        <span class="input-group-text">Name</span>
                        <input type="text" class="form-control" placeholder="Name" name="name" aria-label="Username"
                            value="<?php $val = isset($old_data['name']) ? $old_data['name'] : "";
                            echo $val ?>">

                    </div>
                    <span style="color :red">
                        <?php $errorname = isset($errors['name']) ? $errors['name'] : '';
                        echo $errorname; ?>
                    </span>


                    <div class="input-group mt-3">
                        <input type="text" class="form-control" placeholder="Email" name="email"
                            aria-label="Recipient's Email" value="<?php $val = isset($old_data['email']) ? $old_data['email'] : "";
                            echo $val ?>">
                        <span class="input-group-text" id="basic-addon2">@example.com</span>


                    </div>
                    <span style="color :red">
                        <?php $erroremail = isset($errors['email']) ? $errors['email'] : '';
                        echo $erroremail; ?>
                    </span>


                    <div class="input-group mt-3">
                        <span class="input-group-text">Password</span>
                        <input type="password" class="form-control" placeholder="Password" name="password"
                            aria-label="password" value="<?php $val = isset($old_data['password']) ? $old_data['password'] : "";
                            echo $val ?>">
                    </div>
                    <span style="color :red">
                        <?php $errorpass = isset($errors['password']) ? $errors['password'] : '';
                        echo $errorpass; ?>
                    </span>


                    <div class="input-group mt-3">
                        <span class="input-group-text">Confirm Password</span>
                        <input type="password" class="form-control" placeholder="Confirm Password"
                            name="confirmpassword" aria-label="password" value="<?php $val = isset($old_data['password']) ? $old_data['password'] : "";
                            echo $val ?>">
                    </div>
                    <span style="color :red">
                        <?php $errorpass = isset($errors['confirmpassword']) ? $errors['confirmpassword'] : '';
                        echo $errorpass; ?>
                    </span>


                    <div class="input-group mt-3">
                        <span class="input-group-text">Room No.</span>
                        <select id="room" class="form-select" aria-label="Default select example" name="room">
                            <option selected disabled>....</option>
                            <?php if ($old_data["room"] == "application_1") {
                                echo '<option selected value="application_1">Application 1</option>
                                <option value="application_2">Application 2</option>
                                <option value="cloud">Cloud</option>';
                            } else if ($old_data["room"] == "application_2") {
                                echo '<option  value="application_1">Application 1</option>
                                <option selected value="application_2">Application 2</option>
                                <option  value="cloud">Cloud</option>';
                            } else {

                                echo '<option  value="application_1">Application 1</option>
                                <option value="application_2">Application 2</option>
                                <option selected value="cloud">Cloud</option>';
                            }
                            ?>


                        </select>
                    </div>
                    <span style="color :red">
                        <?php $errorroom = isset($errors['room']) ? $errors['room'] : '';
                        echo $errorroom; ?>
                    </span>

                    <div class="input-group mt-3">
                        <span class="input-group-text">Ext.</span>
                        <select id="ext" class="form-select" aria-label="Default select example" name="ext" onlyread>
                            <option selected disabled>.....</option>
                            <?php if ($old_data["room"] == "application_1") {
                                echo '<option selected value="1000">1000</option>
                                <option value="2000">2000</option>
                                <option value="3000">3000</option>';
                            } else if ($old_data["room"] == "application_2") {
                                echo '<option value="1000">1000</option>
                                <option selected value="2000">2000</option>
                                        <option value="3000">3000</option>';
                            } else {
                                echo '<option value="1000">1000</option>
                                     <option  value="2000">2000</option>
                                        <option selected value="3000">3000</option>';
                            }
                            ?>
                        </select>

                    </div>




                    <span style="color :red">
                        <?php $errorroom = isset($errors['ext']) ? $errors['ext'] : '';
                        echo $errorroom; ?>
                    </span>

                    <div class="input-group mt-3">
                        <input class="form-control" type="file" name="image">
                        <label class="input-group-text" for="inputGroupFile01">Profile Image</label>

                    </div>

                    <div class="input-group mt-3">
                        <span class="input-group-text">Permission</span>
                        <select class="form-select" aria-label="Default select example" name="permission_id">
                            <option selected disabled>Select Permission</option>
                           
                            <?php foreach ($permissions as $permission) {
                                if ($permission['id'] == $old_data['permission_id']) {
                                    echo '<option selected value="' . $permission['id'] . '">' . $permission['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $permission['id'] . '">' . $permission['name'] . '</option>';
                                }
                            }
                            ?>
                            

                        </select>
                    </div>
                    <span style="color :red">
                        <?php $imgerror = isset($errors['image']) ? $errors['image'] : '';
                        echo $imgerror; ?>
                    </span>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="d-grid gap-2 ">
                                <button class="btn" style="background-color: #23569c ;color: white" type="submit">Update User</button>
                            </div>

                        </div>
                        <div class="col-6">
                            <div class="d-grid gap-2">
                                <a class="btn" href="alluser.php" style="background-color: #153257;color: white"
                                    type="reset">Cancel</a>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

</html>



</div>
<script>
    //          const room = document.getElementById("room");
    //          const ext = document.getElementById("ext");

    // if (room.value == "application_1") {
    //      ext.value = "1000";
    //  }else if (room.value == "application_2") {
    //      ext.value = "2000";
    //  }
    //  else {
    //      ext.value = "3000";

    // }

    const room = document.getElementById("room");
    const ext = document.getElementById("ext");



    const Mapping = {
        application_1: "1000",
        application_2: "2000",
        cloud: "3000"
    };
    room.addEventListener("change", function () {
        if (Mapping[room.value]) {
            ext.value = Mapping[room.value];

        } else {
            ext.value = "";
        }
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
<script src="../../assets/script.js"></script>
</body>

</html>