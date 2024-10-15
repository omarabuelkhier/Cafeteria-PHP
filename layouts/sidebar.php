<?php
if ($_SESSION['permission'] == 1): ?>
<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button id="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="#">Cafeteria</a>
            </div>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="../user/Create.php" class="sidebar-link">
                    <i class="lni lni-users"></i>
                    <span> Create Users</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../product/product.php" class="sidebar-link">
                    <i class="lni lni-users"></i>
                    <span>Add Product</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="../category/create.php" class="sidebar-link">
                    <i class="lni lni-users"></i>
                    <span>Category</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#auth"
                   aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-cart"></i>
                    <span>Order</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="../order/create-order.php" class="sidebar-link">Create Order</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../order/checks.php" class="sidebar-link">Checks</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../order/order.php" class="sidebar-link">Order</a>
                    </li>

                </ul>
            </li>

        </ul>
        <div class="sidebar-footer">
            <a href="../Login/logout.php" class="sidebar-link">
                <i class="lni lni-exit"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <?php else: ?>


    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button id="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">Cafeteria</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="../order/create-order.php"" class="sidebar-link">
                        <i class="lni lni-users"></i>
                        <span>Create Order</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../order/myOrder.php"" class="sidebar-link">
                        <i class="lni lni-users"></i>
                        <span>My Orders</span>
                    </a>
                </li>


            </ul>
            <div class="sidebar-footer">
                <a href="../Login/logout.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>


        <?php endif; ?>
