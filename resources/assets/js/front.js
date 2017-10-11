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
            console.log(response);
            toggleSuccess(response.msg);
        },
        error: function(response)
        {
            // toggleError(JSON.stringify(response.responseJSON.errors));
            console.log(response.responseText);
        }
    };

    if($('#size').val() == 'non')
        return false;
    else
        $("#productForm").ajaxSubmit(options);
}

function toggleSuccess (msg)
{
    alert(msg);
}

function toggleError (msg)
{
    alert(msg);
}