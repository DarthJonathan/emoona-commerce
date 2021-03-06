/**
 * Created by JohnNate on 10/10/17.
 */

var store_cache = null;
var category_cache = {};
var categories_cache = {};
var sale_cache = null;

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
            location.reload();
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
        url: '/cart/contents_ajax',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'GET',
        success: function (data) {

            if(data.cart == null)
            {
                bag.html('<span>BAG</span>(0)');
                total.html('Rp.0,00');

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
                        '<h5>Rp.' + makePrice(value.price) + '.00</h5>' +
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

function getStore() {
    return $.get('/products/front.page').promise();
}

function loadStore (){
    if(store_cache === null)
        store_cache = getStore();

    store_cache.done((data) => renderStore(data));
}

function openProduct (e)
{
    var link = '/product/' + $(e).data('gender') + '/' + $(e).data('category') + '/' + $(e).data('id');
    window.location.href = link;
}

function loadFromCategory (e)
{
    var category_id = $(e).data('id');

    if(!categories_cache[category_id])
        categories_cache[category_id] = $.get('/products/category.products',{category_id: category_id }).promise();

    categories_cache[category_id].done((data) => renderFromCategory(data));
}

function renderFromCategory (res)
{
    var store = $('.shop-page-shop');
    store.empty();

    var counter = 0;
    var counter_empty = 0;

    if(res.products.length == 0)
    {
        var html = "<div class='category-empty'><h4>we're making something great, stay connected!</h4></div>";
        store.append(html);
        return true;
    }

    //Load Default Products, limited 30 products
    $.each(res.products, function(key, value) {

        counter++;

        //Check if item detail is not available
        if(value.item_detail.length == 0) {
            counter_empty++;
            return true;
        }

        //Check if item detail is not available
        if(res.images[key].length == 0) {
            var image = null;
            return true;
        }
        else
            var image = res.images[key][0].split('/');


        var image = res.images[key][0].split('/');
        image = '/storage/item_detail/' + image[2] + '/' + image[3];

        var price = value.price;

        var html = '<div class="col-md-3 float-left mb-5" style="cursor: pointer" onclick="openProduct(this)" data-id="' + value.id + '" data-category="' + value.item_category.name + '" data-gender="'+ value.item_category.gender +'">' +
            '<div class="shop-picture ps1"' +
            'style="background-image: url(' + image + ')"' +
            '>' +
            '</div>' +
            '<div class="sale-tag-circle sale-'+ key + '">SALE</div>' +
            '<div class="shop-picture-desc">' +
            '<div class="shop-picture-name">' +
            value.name +
            '</div>' +
            '<div class="shop-picture-price sale-price-' + key + '">' +
            'IDR ' + makePrice(value.price) +
            '</div>'+
            '</div>' +
            '</div>';

        store.append(html);
        $('.sale-' + key).css('display', 'none');
        var key_parent = key;

        $.each(value.item_detail, function(key, value){
            if(res.discounts[value.id] != null)
            {
                $('.sale-' + key_parent).css('display', 'block');
                $('.sale-price-' + key_parent).html('IDR <s>' + makePrice(price) + '</s> ' + makePrice((price - (res.discounts[value.id] * price))));
            }
        });
    });

    if(counter_empty == counter)
    {
        store.empty();
        var html = "<div class='category-empty'><h4>we're making something great, stay connected!</h4></div>";
        store.append(html);
    }

}

function orderHistory()
{
    window.location.href = '/order.history';
}

function orderTracking()
{
    window.location.href = '/orders';
}

function viewOrder(e)
{
    var id = $(e).data('id');
    window.location.href = '/transactions/' + id;
}

function viewTickets(e)
{
    var id = $(e).data('id');
    window.location.href = '/tickets';
}

function viewTransfer ()
{
    window.location.href = '/transfer.information';
}

function printThis()
{
    window.print();
}

function reloadTicket(e)
{
    var ticket_field = $('.replies-field-' + e);
    var reply = $('#reply' + e);

    var html = '<div class="row">' +
        '<div class="col-md-8"></div><div class="col-md-4 box-username"><center> You </center></div>'+
        '<div class="col-md-12 box-message">'+
         reply.val() +
        '</div>'+
        '</div>';

    ticket_field.append(html);
    reply.empty();
}

function newTicketUser()
{
    var options = {
        url: '/tickets/new.ticket',
        type: 'POST',
        success: function(response) {
            toggleSuccess(response.msg);
            location.reload();
        },
        error: function(response) {
            console.log(response);
            var errors = "";
            $.each(response.responseJSON.errors,function(key, value)
            {
                errors += value + "<br>";
            });

            toggleError(errors);
        }
    };

    $("#newTicketUser").ajaxSubmit(options);
    return false;
}

function replyTicketUser(e)
{
    var options = {
        url: '/tickets/reply.ticket',
        type: 'POST',
        success: function(response) {
            toggleSuccess(response.msg);
            reloadTicket(e);
        },
        error: function(response) {

            console.log(response);

            var errors = "";
            $.each(response.responseJSON.errors,function(key, value)
            {
                errors += value + "<br>";
            });

            toggleError(errors);
        }
    };

    $("#replyTicketUser" + e).ajaxSubmit(options);
    return false;
}

function openTnc ()
{
    window.location.href = '/tnc';
}
function openReturn ()
{
    window.location.href = '/return';
}
function openShipping ()
{
    window.location.href = '/shipping';
}
function openContact ()
{
    window.location.href = '/contact';
}

function viewProduct(e)
{
    var id = $(e).data('id');
    var gender = $(e).data('gender');
    var category = $(e).data('category');

    window.location.href = '/product/' + gender + '/' + category + '/' + id;
}

function openMobileNav ()
{
    $('.mobile-nav-collapse').toggleClass('showNav');
    $('.navbar-toggler').toggleClass('togglerShow');
    $('.hamburger').toggleClass('hamburger--close');
}

function loadSale ()
{
    if(sale_cache === null)
        sale_cache = $.get('/products/on.sale');

    sale_cache.done((data) => renderSale(data));
}

function renderSale (res)
{
    var store = $('.shop-page-shop');
    store.empty();

    //Load Default Products, limited 30 products
    $.each(res.products, function(key, value){

        if(res.images[key].length == 0) {
            var image = null;
            return true;
        }

        var image = res.images[key][0].split('/');
        image = '/storage/item_detail/' + image[2] + '/' + image[3];

        var html = '<div class="col-md-3 float-left mb-5" style="cursor: pointer" onclick="openProduct(this)" data-id="' + value.item.item.id + '" data-category="' + value.category.name + '" data-gender="'+ value.category.gender +'">' +
            '<div class="shop-picture ps1"' +
            'style="background-image: url(' + image + ')"' +
            '>' +
            '</div>' +
            '<div class="sale-tag-circle">SALE</div>' +
            '<div class="shop-picture-desc">' +
            '<div class="shop-picture-name">' +
            value.item.item.name +
            '</div>' +
            '<div class="shop-picture-price">' +
            'IDR ' + makePrice(value.item.item.price) +
            '</div>'+
            '</div>' +
            '</div>';

        store.append(html);
    });
}

function notifyMe (e)
{
    var cat = $(e).data('cat');
    var id ="";

    switch(cat)
    {
        case 'no-stock':
        {
            id = $(e).data('id');
        }break;

        case 'preorder':
        {
            id = $("#size option:selected").val();
        }
    }

    $.ajax({
        url: '/products/notify',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data:{cat:cat, id:id},
        success: function (res) {
            toggleSuccess(res.msg);
        },
        error: function (res) {
            toggleError(res.responseJSON.errors);
            console.log(res.responseText);
        }
    });
}

function sliderRedirect(e)
{
    var link = $(e).data('link');
    window.location.href = link;
}

function openCategory(e)
{
    var cat = $(e).data('cat');
    switch(cat)
    {
        case 'men':
        {
            window.location.href = '/store/male';
        }break;

        case 'woman':
        {
            window.location.href = '/store/female';
        }break;

        case 'others' :
        {
            window.location.href = '/store/others';
        }break;
    }
}

function getCategory (e)
{
    return $.get('/products/category.products_all', {category_id: e}).promise();
}

function loadCategory (e) {
    var id = e;

    if(!category_cache[id])
        category_cache[id] = getCategory(id);

    category_cache[id].done((data) => renderCategory(data));
}

function renderStore (res)
{
    var store = $('.shop-page-shop');
    store.empty();
    //Load Default Products, limited 30 products
    $.each(res.products, function(key, value){

        //Check if item detail is not available
        if(value.item_detail.length == 0) {
            return;
        }

        if(res.images[key].length == 0) {
            var image = null;
            return true;
        }
        else {
            var image = res.images[key][0].split('/');
        }

        image = '/storage/item_detail/' + image[2] + '/' + image[3];

        var price = value.price;

        var html = '<div class="col-md-3 float-left mb-5" style="cursor: pointer" onclick="openProduct(this)" data-id="' + value.id + '" data-category="' + value.item_category.name + '" data-gender="'+ value.item_category.gender +'">' +
            '<div class="shop-picture ps1"' +
            'style="background-image: url(' + image + ')"' +
            '>' +
            '</div>' +
            '<div class="sale-tag-circle sale-'+ key + '">SALE</div>' +
            '<div class="shop-picture-desc">' +
            '<div class="shop-picture-name">' +
            value.name +
            '</div>' +
            '<div class="shop-picture-price sale-price-' + key + '">' +
            'IDR ' + makePrice(value.price) +
            '</div>'+
            '</div>' +
            '</div>';

        store.append(html);
        $('.sale-' + key).css('display', 'none');
        var key_parent = key;

        $.each(value.item_detail, function(key, value1){
            if(res.discounts[value1.id] != null) {
                $('.sale-' + key_parent).css('display', 'block');
                $('.sale-price-' + key_parent).html('IDR <s>' + makePrice(price) + '</s> ' + makePrice((price - (res.discounts[value1.id] * price))));
            }
        });
    });

    var mcat = $('#mdropdowns');
    var wcat = $('#wdropdowns');
    var ocat = $('#odropdowns');

    mcat.empty();
    wcat.empty();
    ocat.empty();

    var countMcat = 0;
    var countWcat = 0;
    var countOcat = 0;

    //Load Categories
    $.each(res.categories, function(key, value){

        switch(value.gender)
        {
            case 'male' :
            {
                mcat.append('<li class="category-links" data-id="' + value.id + '" onclick="loadFromCategory(this)">' + value.name.toUpperCase() + '</li>');
                countMcat++;
            }break;

            case 'female' :
            {
                wcat.append('<li class="category-links" data-id="' + value.id + '" onclick="loadFromCategory(this)">' + value.name.toUpperCase() + '</li>');
                countWcat++;
            }break;

            case 'others' :
            {
                ocat.append('<li class="category-links" data-id="' + value.id + '" onclick="loadFromCategory(this)">' + value.name.toUpperCase() + '</li>');
                countOcat++;
            }break;
        }
    });

    $('#menDropDown').data('count', countMcat);
    $('#womanDropDown').data('count', countWcat);
    $('#othersDropDown').data('count', countOcat);
}

function renderCategory (res) {

    var store = $('.shop-page-shop');
    store.empty();

    //Check if product is null
    if(res.products.length == 0)
    {
        store.empty();

        var html = "<div class='category-empty'><h4>we're making something great, stay connected!</h4></div>";
        store.append(html);
    }

    var counter = 0;

    //Load Default Products, limited 30 products
    $.each(res.products, function(key1, value1){
        $.each(value1, function(key, value) {
            //Check if item detail is not available
            if (value.item_detail == "")
                return true;

            if(res.images[key1].length == 0 || res.images[key1][key][0][0] == null) {
                var image = null;
                return true;
            }

            var image = res.images[key1][key][0][0].split('/');
            image = '/storage/item_detail/' + image[2] + '/' + image[3];

            var html = '<div class="col-md-3 float-left mb-5" style="cursor: pointer" onclick="openProduct(this)" data-id="' + value.id + '" data-category="' + value.item_category.name + '" data-gender="' + value.item_category.gender + '">' +
                '<div class="shop-picture ps1"' +
                'style="background-image: url(' + image + ')"' +
                '>' +
                '</div>' +
                '<div class="sale-tag-circle sale-'+ counter + '">SALE</div>' +
                '<div class="shop-picture-desc">' +
                '<div class="shop-picture-name">' +
                value.name +
                '</div>' +
                '<div class="shop-picture-price sale-price-' + counter + '">' +
                'IDR ' + makePrice(value.price) +
                '</div>' +
                '</div>' +
                '</div>';

            store.append(html);
            $('.sale-' + counter).css('display', 'none');
            var key_parent = counter;
            var price = value.price;

            $.each(value.item_detail, function(key, value2){
                if(res.discounts[value2.id] != null) {
                    $('.sale-' + key_parent).css('display', 'block');
                    $('.sale-price-' + key_parent).html('IDR <s>' + makePrice(price) + '</s> ' + makePrice((price - (res.discounts[value2.id] * price))));
                }
            });

            counter++;
        });

    });

    //Load the category dropdown
    var mcat = $('#mdropdowns');
    var wcat = $('#wdropdowns');
    var ocat = $('#odropdowns');

    mcat.empty();
    wcat.empty();
    ocat.empty();

    var countMcat = 0;
    var countWcat = 0;
    var countOcat = 0;

    //Load Categories
    $.each(res.categories, function(key, value){

        switch(value.gender)
        {
            case 'male' :
            {
                mcat.append('<li class="category-links" data-id="' + value.id + '" onclick="loadFromCategory(this)">' + value.name.toUpperCase() + '</li>');
                countMcat++;
            }break;

            case 'female' :
            {
                wcat.append('<li class="category-links" data-id="' + value.id + '" onclick="loadFromCategory(this)">' + value.name.toUpperCase() + '</li>');
                countWcat++;
            }break;

            case 'others' :
            {
                ocat.append('<li class="category-links" data-id="' + value.id + '" onclick="loadFromCategory(this)">' + value.name.toUpperCase() + '</li>');
                countOcat++;
            }break;
        }
    });

    $('#menDropDown').data('count', countMcat);
    $('#womanDropDown').data('count', countWcat);
    $('#othersDropDown').data('count', countOcat);
}

function loadStudioCategory(e){
    var template = $(e).data('category');

    var banners = $('#banner-space');
    var dropdown = $('#mdropdowns');
    banners.empty();
    dropdown.empty();

    $.ajax({
        url: '/studio/test'+template,
        type : "GET",
        success : function(data){
            $('#mdropdowns').html(data);
        }
    });
}

function checkProducts (e)
{   
    var store   = $('.shop-page-shop');
    var cats    = $(e).data('count');

    if(cats == 0)
    {
        store.empty();

        var html = "<div class='category-empty'><h4>we're making something great, stay connected!</h4></div>";
        store.append(html);   
    }else {
        loadCategory($(e).data('category'));
    }
}

function makePrice (nStr)
{
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function viewStudioItem (e)
{
    var link = $(e).data('link');
    var type = $(e).data('type');

    $('#modal').modal('toggle');
    $('.modal-title').html('Studio Item');
    $('#ajax-loading').hide();
    var modal = $('.modal-body');

    modal.empty();
    var html = "<img src='/storage/img/studio/" + link + "' width='100%'>";
    modal.html(html);
}