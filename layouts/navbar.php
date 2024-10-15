<?php
if ($_SESSION['permission'] == 1):?>
    <nav id="navbar" class="navbar py-3 w-100  mt-1 d-none d-lg-block">
    <div class="  d-flex  justify-content-between ">
        <div class="ms-5 h6 fw-bold">
            <a href="../Login/home.php" class="text-white text-decoration-none  "><small class="text-white  mx-2">Home</small></a>
            <a href="../product/table.php" class="text-white text-decoration-none  "><small class="text-white  mx-2">Products</small></a>
            <a href="../user/alluser.php" class="text-white text-decoration-none  "><small class="text-white  mx-2">Users</small></a>
            <a href="../category/table.php" class="text-white text-decoration-none  "><small class="text-white  mx-2">Category</small></a>
            <a href="../order/create-order.php" class="text-white text-decoration-none  "><small class="text-white  mx-2">Manual Order</small></a>
            <a href="../order/checks.php" class="text-white text-decoration-none  "><small class="text-white  mx-2">Checks</small></a>
            <a href="../order/order.php" class="text-white text-decoration-none  "><small class="text-white  mx-2">Order</small></a>
        </div>
        <div class="me-5" >
            <a href="#" class="text-white text-decoration-none  "><small class="text-white  mx-2"><?php echo $_SESSION["username"]?></small></a>
            <img class="mx-3 rounded-1" src="../../admin.jpeg" width="40px" height="50px"  alt="" style="margin-top: -12px; margin-bottom: -10px;" >
        </div>
    </div>
</nav>
<?php else :?>
<nav id="navbar" class="navbar py-3 w-100  mt-1 d-none d-lg-block">
    <div class="  d-flex  justify-content-between ">
        <div class="ms-5 h6 fw-bold">
            <a href="../order/create-order.php" class="text-white text-decoration-none  "><small class="text-white  mx-2">Home</small></a>
            <a href="../order/myOrder.php" class="text-white text-decoration-none  "><small class="text-white  mx-2">My Orders</small></a>
        </div>
        <div class="me-5" >
            <a href="#" class="text-white text-decoration-none  "><small class="text-white  mx-2"><?php echo $_SESSION["username"]?></small></a>
            <img class="mx-3 rounded-1" src="<?php echo $_SESSION["user_image"]?>" width="40px" height="50px"  alt="" style="margin-top: -12px; margin-bottom: -10px;" >
        </div>
    </div>
</nav>
<?php endif; ?>
