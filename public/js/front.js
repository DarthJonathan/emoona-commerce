/**
 * Created by JohnNate on 10/10/17.
 */

function addToCart()
{
    var options = {
        url: '/product/add_to_cart',
        type: 'post',
        success: function(response)
        {
            toggleSuccess(response.msg);
            loadCart();
        },
        error: function(response)
        {
            toggleError(JSON.stringify(response.responseJSON.errors));
            // console.log(response.responseJSON.errors_debug);
        }
    };

    if($('#size').val() == 'non')
        return false;
    else
        $("#productForm").ajaxSubmit(options);
}

function removeItem(e)
{
    var id = $(e).data('id');

    $.ajax({
        url: '/remove_item',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { id:id },
        success: function (response) {
            toggleSuccess("Item Removed from Cart");
            loadCart();
        },
        error: function(data) {
            toggleError(data.responseJSON.errors);
            console.log(data.responseJSON.errors_debug);
        }
    });
}

function clearCart ()
{
    $.ajax({
        url: '/clear_cart',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        success: function (response) {
            toggleSuccess ("Cart Cleared!");
            loadCart();
        },
        error: function(data) {
            toggleError(data.responseJSON.errors);
            console.log(data.responseJSON.errors_debug);
        }
    });
}

function loadCart()
{
    var cart = $('.cart-item-container');
    var bag = $('#bag-items');
    var total = $('#total-price');

    cart.empty();

    $.ajax({
        url: '/cart/contents_ajax/',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        success: function (data) {

            console.log(data);

            if(data.cart == null)
            {
                var html = "<div class='cart-empty'>" +
                    "<h4>Cart Is Empty</h4>" +
                    "</div>";

                cart.append(html);
            }else
            {
                bag.html('<span>BAG</span>(' + data.quantity + ')');
                total.html('Rp.' + data.total + ',00');

                $.each(data.cart, function(key, value)
                {
                    var html = '<div class="cart-item row align-items-center">' +
                        '<div class="item-image col-lg-3" style= "background-image:url(' +  '/storage/item_detail/' + value.attributes.product_image + ')" >' +
                        '</div>' +
                        '<div class="item-description col-6">' +
                        '<h4>' + value.name + '</h4>' +
                        '<h5>Rp.' + value.price + '.00</h5>' +
                        '<span>' + value.quantity + ' pc(s)</span>' +
                        '</div>' +
                        '<div class="item-edit col-3">' +
                        '<a href="#" onclick="removeItem(this)" data-id="' + value.id + '">Remove</a>' +
                        '</div>' +
                        '</div>' +

                        '<hr>';
                    cart.append(html);
                });
            }
        }
    });
}

function toggleSuccess (msg)
{
    alert(msg);
}

function toggleError (msg)
{
    alert(msg);
}
//# sourceMappingURL=front.js.map
