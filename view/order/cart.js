$(document).ready(function(){
    let userId = null;
    let UserPermission1   = parseInt($(`#user-permission1`).val());
    $(`#GetUserId`).on('change', function(){
         userId = $(this).val();
    })

$('.add-product').on('click', function(e) {
    e.preventDefault();
    if (  userId === null && UserPermission1 === 1 ) {
        alert('select User ');
        return;
    }

    let name = $(this).data(`name`);
    let id = $(this).data(`id`);
    let price = $(this).data(`price`);
    $(this).addClass('disabled')

    let html =
        `<tr>
            <td>${name}</td>
           
            <td>
               <div class="input-group mb-3">
               <input type="hidden" name="product[]" value="${id}">
                  <input type="hidden" name="user_id" value="${userId}">
                    <input type="number" name="quantity[]" data-price="${price}" class="form-control-sm product-qty" min="1" value="1">
                </div>
                </td>
                <input type="hidden" name="total_price[]" class="total-price" value="${price}" >
             <td class="product-price" >${price}</td>
            <td><button type="button" class="btn-close remove-product " data-id=${id} ></button></td>
        </tr>`;
    $(`.append-product`).append(html);
    calculate_total();
});

$(`body`).on('click','.remove-product' ,function(){
    let id = $(this).data(`id`);
    $(this).closest(`tr`).remove();
    $(`#product-` + id).removeClass('disabled');
    calculate_total();
});//remove Product From Table

    $(`body`).on('keyup change', '.product-qty',function(e){
        let qty = parseInt($(this).val());
        let productPrice = $(this).data(`price`);
        let total=qty * productPrice;
        $(this).closest('tr').find(`.product-price`).html(total);
        $(this).closest('tr').find(`.total-price`).val(total);
        calculate_total();
            })
});


function calculate_total(){
    let price = 0;
    $(`.product-price`).each(function(i){
price += parseInt($(this).html());
});
    $(`.total-order`).html(price);
    if(price > 0){
        $(`#add-order-btn`).removeClass('disabled');
    }else{
        $(`#add-order-btn`).addClass('disabled');
    }
}
