<?php
require "../../db.php";
require "../../utils.php";
require "../../authentication_user.php";

if ($db) {
    try {
        $stmt = $db->prepare("SELECT * FROM orders WHERE user_id = :user_id order by order_date desc ");
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
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
            My Orders
        </h6>
        <div class="card-body">
            <form action="">
                <div class="row  ">
                    <div class="col d-flex">
                        <label for="order_date" class="input-group-text fw-bold">Date from</label>
                        <input type="date" name="from" id="date_from" class="form-control order_date">
                    </div>
                    <div class="col d-flex">
                        <label for="order_date" class="input-group-text fw-bold">Date to</label>
                        <input type="date" name="to" id="date_to" class="form-control order_date" onchange="getDate()">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="container table table-bordered  mt-4 ">
            <thead>
            <tr>
                <th>Order Date</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="orders">

            <?php $total = 0;
            for ($i = 0; $i < count($orders); $i++) :
                $total += $orders[$i]['amount']; ?>


                <tr>
                    <td>
                        <button class="btn btn-success me-2 append-order"
                                onclick="getItems(<?php echo $orders[$i]['id'] ?>)">
                            <i class="lni lni-plus"></i>
                        </button>
                        <?php echo $orders[$i]['order_date'] ?></td>
                    <td>
                        <?php if ($orders[$i]["status"] == "Processing"): ?>
                            <span class="badge rounded-pill bg-warning"><?php echo $orders[$i]['status'] ?></span>
                        <?php else: ?>
                        <span class="badge rounded-pill bg-success"><?php echo $orders[$i]['status'] ?></span></td>
                    <?php endif; ?>
                    <td><?php echo $orders[$i]['amount'] ?></td>
                    <td>
                        <?php if ($orders[$i]['status'] == 'Processing'): ?>
                            <a href="cancelOrder.php?order_id=<?php echo($orders[$i]['id']) ?>" class="btn btn-danger">Cancel</a>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endfor; ?>
            </tbody>
            <tfoot id="tfoot">
            <tr class="fw-bold h5" style="background-color: #445568 ;color: white;font-family: 'DejaVu Serif';">
                <th colspan="2">Total</th>
                <th colspan="2">
                    <?php echo $total; ?>
                </th>
            </tr>
            </tfoot>
        </table>

    </div>
    <div class=" card m-auto " id="items" style="width: 1100px">

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="../../assets/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<script>

    function getItems(order_id) {

        $.ajax({
            url: `getOrderItems.php`,
            method: 'GET',
            data: {order_id: order_id},
            dataType: 'json',
            success: function (items) {
                let CardHeader = `
                <h6 class="card-header fw-bold" style="background-color: #153257">
                    Order Items
                </h6>`;
                let CardBody = '<div class="card-body ">' +
                    '<div class="row">';
                for (let i = 0; i < items.length; i++) {
                    CardBody += `
                                    <div class='col-md-3 col-lg-2 mb-2 position-relative h3  mt-3'>
                                      <span class="position-absolute  translate-middle badge rounded-pill  pt-2"
                                                   style="background-color: #0e223e ;  top:10px;left: 160px;width: 50px; height: 50px ; z-index: 1">
                                                       ${items[i].price}
                                               </span>
                                        <div class='card' style='border-radius: 20px;'>
                                            <img src='../product/${items[i].image}' class='card-img-top'
                                                 style='height: 150px;  border-radius: 20px 20px 0 0; '
                                                 alt='Product Image'>
                                            <div class='card-body '
                                                 style='background-color: #153257; border-radius: 0 0 20px 20px; color: white;'>
                                                <h5 class='card-title fw-bold text-center'> ${items[i].name}</h5>

                                            </div>
                                                                    <div class='position-relative    text-center'>
                                                                     <span class="position-absolute  translate-middle badge rounded-pill "
                                                                           style="background-color: #ffffff ; color: #153257;
                                                                               top:0;left: 75px;width: 40px; height: 40px">
                                                                                    ${items[i].quantity}
                                                                                    </span>
                                                                </div>
                                        </div>
                                    </div>`
                }

                CardBody += '</div>' +
                    '</div>' +
                    ' </div>';
                $('#items').html(CardHeader + CardBody);
            },

        });
    }

    function getDate() {
        $.ajax({
            url: `getDate.php`,
            method: 'GET',
            data: {from: $('#date_from').val(), to: $('#date_to').val()},
            dataType: 'json',
            success: function (items) {
                console.log(items)
                let total = 0;
                let body = $('#orders');
                body = ''

                body += `<tr>`;

                for (let i = 0; i < items.length; i++) {
                    total += items[i].amount;
                    body += `
                            <td>
                                <button class="btn btn-success me-2 append-order"
                                        onclick="getItems(${items[i].id})">
                                    <i class="lni lni-plus"></i>
                                </button>
                             ${items[i].order_date}</td>
                            <td>
                            ${items[i].status === 'Processing' ?
                        `<span class="badge rounded-pill bg-warning">${items[i].status}</span>` :
                        `<span class="badge rounded-pill bg-success">${items[i].status}</span>`}
                        </td>

                            <td>${items[i].amount}</td>

                            <td> ${items[i].status === "Processing" ?
                        `<a href="" class="btn btn-danger" >Cancel</a>` :
                        `<a href=""></a>`}
</td>


                        </tr>

                    `;
                    body += `<tr>`
                    let tfoot = $(`#tfoot`);
                    tfoot += ''
                    tfoot += `
                                   <tr class="fw-bold h5" style="background-color: #445568 ;color: white;font-family: 'DejaVu Serif';">
                                     <td colspan="2" >Total</td>
                            <td colspan="2"  >${total}</td>
                                </tr>`
                    $('#orders').html(body);
                    $('#tfoot').html(tfoot);
                }
            },


        })

    }


</script>
</body>
</html>






