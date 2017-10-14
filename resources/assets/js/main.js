/**
 * Created by JohnNate on 9/7/17.
 */

function userInfo (e)
{
    const id = e.id;

    $('#modal').modal('toggle');
    $('#ajax-loading').show();
    $('.modal-title').empty();

    $.ajax({
        url: '/admin/userinfo',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { id:id },
        success: function(data) {
            const user = JSON.parse(data);

            const html = '<h3 class="m-2 mb-4">User Information</h3>' +
                '<table class="table">' +
                '<tr>' +
                '<td>Name</td>' +
                '<td>'+ user.firstname +' ' + user.lastname+ '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Phone</td>' +
                '<td>'+ user.user_info.phone + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td>Birthday</td>' +
                '<td>'+ user.user_info.birthday + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Address</td>' +
                '<td>'+ user.user_info.address + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Country</td>' +
                '<td>'+ user.user_info.country + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Postcode</td>' +
                '<td>'+ user.user_info.postcode + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Province</td>' +
                '<td>'+ user.user_info.province + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Last Login</td>' +
                '<td>'+ user.last_login + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Created</td>' +
                '<td>'+ user.created_at + '</td>' +
                '</tr>' +
                '</table>';

            $('.modal-body').html(html);
            $('#ajax-loading').hide();
        }
    });
}

function suspendUser (e)
{
    const id = e.id;

    $.ajax({
        url:'/admin/suspend',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { id:id },
        success: function(data) {
            toggleSuccess(data);
        }
    });
}

function deleteUser (e)
{
    const id = e.id;

    $('#modal').modal('toggle');
    $('.modal-title').empty();

    $.ajax({
        url:'/admin/delete_confirmation',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { id:id, type:'user' },
        success: function(data) {
            $('.modal-title').html('Are You Sure');
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function cancelDelete()
{
    $('#modal').modal('toggle');
    $('#ajax-loading').show();
}

function confirmDelete(e)
{
    const id = $(e).data('id');
    const type = $(e).data('type');
    var url ='';

    switch(type)
    {
        case 'user':
        {
            url = '/admin/remove';
        }break;

        case 'category':
        {
            url = '/admin/delete_category';
        }break;

        case 'item' :
        {
            url = '/admin/delete_item';
        }break;

        case 'itemDetail' :
        {
            url = '/admin/delete_item_detail';
        }break;
    }

    $.ajax({
        url: url,
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: { id:id, type: type },
        success: function(data) {
            if(!data.error)
            {
                $('#modal').modal('toggle');
                toggleSuccess(data.msg);
                if(data.next) {
                    var e = {
                        id: parseInt(data.next.id),
                        category: data.next.next
                    }

                    console.log(e);
                    loadNextCategory(e);
                }
            }else
            {
                $('#modal').modal('toggle');
                toggleError(data.msg);
            }
        }
    });
}

function deleteCategory (e)
{
    const id = $(e).data('id');
    $('.modal-title').empty();
    $('#modal').modal('toggle');
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/delete_confirmation',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id, type: 'category'},
        success: function (data) {
            $('.modal-title').html('Are You Sure');
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function deleteItem (e)
{
    const id = $(e).data('id');
    $('.modal-title').empty();
    $('#modal').modal('toggle');
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/delete_confirmation',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id, type: 'item'},
        success: function (data) {
            $('.modal-title').html('Are You Sure');
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function deleteItemDetail (e) {

    const id = $(e).data('id');
    $('.modal-title').empty();
    $('#modal').modal('toggle');
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/delete_confirmation',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id, type: 'itemDetail'},
        success: function (data) {
            $('.modal-title').html('Are You Sure');
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function newItem () {
    $('#modal').modal('toggle');
    $('.modal-title').html('New Item');
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/new_item_req',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function newItemDetail (e)
{
    const id = $(e).data('id');

    $('#modal').modal('toggle');
    $('.modal-title').html('New Item Detail');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/new_item_detail_req',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {id:id},
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function editItem (e) {

    const id = $(e).data('id');

    $('#modal').modal('toggle');
    $('.modal-title').html('Edit Item');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/edit_item_req',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {id:id},
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function editItemDetail (e) {

    var id              = $(e).data('id');
    var field           = $(e).data('case');

    if($(e).val())
        var value       = $(e).val();
    else
        var value       = $(e).html();

    $.ajax({
        url: '/admin/edit_item_detail',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {id:id, field:field, value:value},
        success: function (response) {
            toggleSuccess(response.msg);
        },error: function (response) {
            toggleError(response.responseJSON.errors);
            console.log(response.responseJSON.errors_debug);
        }
    });
}

function viewImagesDetail (e)
{
    var image_path = $(e).data("link");

    $('#modal').modal('toggle');
    $('.modal-title').html('Edit Item');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/edit_item_detail_image_req',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {id:image_path},
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        },
        error: function(data) {
            $('#modal').modal('toggle');

            toggleError(data.responseJSON.errors);
            console.log(data.responseJSON.errors_debug);
        }
    });
}

function seeTransactionDetail (e)
{
    const id = $(e).data('id');

    $.ajax({
        url:'/admin/user_transaction_detail',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { id:id },
        success: function(data) {

            const transaction_details = JSON.parse(data);

            var html = '<h3 class="m-2 mb-4">User Information</h3>' +
                '<table class="table">' +
                '<thead>' +
                '<tr>' +
                '<td>No</td>' +
                '<td>Item</td>' +
                '<td>Color</td>' +
                '<td>Size</td>' +
                '<td>Quantity</td>' +
                '</tr>' +
                '</thead>' +
                '<tbody class="trans-detail"></tbody>' +
                '</table>';

            $('.modal-body').html(html);

            $.each(transaction_details, function (key, value){
                $('.trans-detail').append(
                    '<tr>' +
                    '<td>'+ (key+1) +'</td>' +
                    '<td>'+ value.item.name +'</td>' +
                    '<td>'+ value.item_detail.color +'</td>' +
                    '<td>'+ value.item_detail.size +'</td>' +
                    '<td>'+ value.quantity +'</td>' +
                    '</td>'
                );
            });

            $('#modal').modal('toggle');
        }
    });
}

function loadNextCategory (e)
{
    if(!$(e).data('id'))
        var id = e.id;
    else
        var id = $(e).data('id');

    if(!$(e).data('category'))
        var next = e.category;
    else
        var next = $(e).data('category');

    $.ajax({
        url:'/admin/category',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { category:next, id:id },
        success: function(data) {

            const out = JSON.parse(data);
            var html = "";

            switch(out.category)
            {
                case '1':
                {
                    $('.category-two').empty();
                    $('.category-three').empty();
                    $('.items-list').empty();

                    $.each(out.html, function(key, value){

                        html = '<div style="cursor:pointer" class="list-group-item list-group-item-action" onclick="loadNextCategory(this)" data-id="'+ value.id +'" data-category="2">' +
                            '<span class="float-left">' +
                                value.name +
                            '</span>' +
                                '<button style="cursor: pointer" class="btn btn-primary float-right btn-sm" data-id="'+ value.id +'" onclick="editCategory(this)">Edit Item</button>' +
                                '<button style="cursor: pointer" class="btn btn-danger float-right btn-sm mr-2" data-id="'+ value.id +'" onclick="deleteCategory(this)">Delete Item</button>' +
                            '</div>';

                        $('.category-two').append(html);
                    });
                }break;

                case '2':
                {
                    $('.category-three').empty();
                    $('.items-list').empty();

                    $.each(out.html, function(key, value){

                        html = '<div style="cursor:pointer" class="list-group-item list-group-item-action" onclick="loadNextCategory(this)" data-id="'+ value.id +'" data-category="3">' +
                            '<a>' +
                            value.name +
                            '</a>' +
                            '<button style="cursor: pointer" class="btn btn-primary float-right btn-sm" data-id="'+ value.id +'" onclick="editItem(this)">Edit Item</button>' +
                            '<button style="cursor: pointer" class="btn btn-primary float-right btn-sm mr-2" data-id="'+ value.id +'" onclick="newItemDetail(this)">New Item Detail</button>' +
                            '<button style="cursor: pointer" class="btn btn-danger float-right btn-sm mr-2" data-id="'+ value.id +'" onclick="deleteItem(this)">Delete Item</button>' +
                            '</a>';

                        $('.category-three').append(html);
                    });
                }break;

                case '3':
                {
                    $('.items-list').empty();

                    $.each(out.html, function(key, value){

                        var status = {};

                        if(value.status == 'available') {
                            status.available = 'checked';
                            status.preorder = '';
                            status.hidden = '';
                        }
                        else if(value.status == 'preorder') {
                            status.available = '';
                            status.preorder = 'checked';
                            status.hidden = '';
                        }
                        else{
                            status.available = '';
                            status.preorder = '';
                            status.hidden = 'checked';
                        }

                        html = '<tr>' +
                            '<td>'+ (key+1) +'</td>' +
                            '<td data-case="color" data-id="'+ value.id +'" onblur="editItemDetail(this)" contenteditable>'+ value.color +'</td>' +
                            '<td data-case="size" data-id="'+ value.id +'" onblur="editItemDetail(this)" contenteditable>'+ value.size +'</td>' +
                            '<td>' +
                            '   <button class="btn btn-primary btn-block" style="cursor: pointer;" data-link="'+ value.images +'" onclick="viewImagesDetail(this)">View Images</button>' +
                            '</td>' +
                            '<td data-case="stock" data-id="'+ value.id +'" onblur="editItemDetail(this)" contenteditable>'+ value.stock +'</td>' +
                            '<td>'+
                            '<input type="radio" name="status#'+ value.id +'" ' + status.available + ' data-case="status" data-id="'+ value.id +'" onclick="editItemDetail(this)" value="available"> Available <br>' +
                            '<input type="radio" name="status#'+ value.id +'" ' + status.preorder + '  data-case="status" data-id="'+ value.id +'" onclick="editItemDetail(this)" value="preorder"> Preorder <br>' +
                            '<input type="radio" name="status#'+ value.id +'" ' + status.hidden + '  data-case="status" data-id="'+ value.id +'" onclick="editItemDetail(this)" value="hidden"> Hidden <br>' +
                            '</td>' +
                            '<td>' +
                            '<button class="btn btn-danger" onclick="deleteItemDetail(this)" data-id="'+ value.id +'" style="cursor:pointer">Delete</button>' +
                            '</td>' +
                            '</tr>';

                        $('.items-list').append(html);
                    });
                }break
            }
        }
    });
}

function toggleSuccess (data)
{
    $('.notification-success').removeClass('hidden');
    $('.alert-body-success').html(data);
    setTimeout(function()
    {
        $('.notification-success').addClass('hidden');
    }, 2500);
}

function toggleError (data)
{
    $('.notification-error').removeClass('hidden');
    $('.alert-body-error').html(data);
    setTimeout(function()
    {
        $('.notification-error').addClass('hidden');
    }, 2500);
}

/* Transactions */
function changeTab(e)
{
    var id = $(e).data('id');

    switch(id)
    {
        case 'wp':
        {
            $('.pc').hide();
            $('.ws').hide();
            $('.sc').hide();
            $('.wp').show("slow");

            $('.tab-border').removeClass("active");
            $('.wp-link').addClass('active');
        }break;

        case 'pc':
        {
            $('.wp').hide();
            $('.ws').hide();
            $('.sc').hide();
            $('.pc').show("slow");

            $('.tab-border').removeClass("active");
            $('.pc-link').addClass('active');
        }break;

        case 'ws':
        {
            $('.wp').hide();
            $('.pc').hide();
            $('.sc').hide();
            $('.ws').show("slow");

            $('.tab-border').removeClass("active");
            $('.ws-link').addClass('active');
        }break;

        case 'sc':
        {
            $('.wp').hide();
            $('.pc').hide();
            $('.ws').hide();
            $('.sc').show("slow");

            $('.tab-border').removeClass("active");
            $('.sc-link').addClass('active');
        }break;
    }
}

function loadTransactionDatas ()
{
    var wp = $('.wp-content');
    var pc = $('.pc-content');
    var ws = $('.ws-content');
    var sc = $('.sc-content');

    wp.empty();
    pc.empty();
    ws.empty();
    sc.empty();

    $.ajax({
        url: '/admin/get_transactions',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        success: function (res) {

            $.each(res.transactions, function(key, value){

                console.log(value);

                var date = value.created_at.substring(0,10).split('-');

                if(value.transfer_proof == null)
                {
                    var transfer_proof = '<button class="btn btn-danger">Not Paid</button>'
                }else{
                    var transfer_proof = '<img src="'+ value.transfer_proof + '">'
                }

                switch(value.status)
                {
                    case 0 :
                    {
                        var html = '<tr>' +
                            '<td>'+ value.id +'</td>'+
                            '<td>'+ value.user.firstname + ' ' + value.user.lastname +'</td>'+
                            '<td>'+ value.payment_type.name +'</td>'+
                            '<td>'+ value.notes + '</td>'+
                            '<td>'+ date[2] + ' - ' + date[1] + ' - ' + date[0] + '</td>'+
                            '<td><button class="btn btn-primary" onclick="openTicket(this)" data-id="'+ value.id +'" data-user-id="' + value.user_id + '">Open Ticket</button></td>'+
                        '</tr>';
                        wp.append(html);
                    }break;

                    case 1 :
                    {
                        var html = '<tr>' +
                            '<td>'+ value.id +'</td>'+
                            '<td>'+ value.user.firstname + ' ' + value.user.lastname +'</td>'+
                            '<td>'+ value.payment_type.name +'</td>'+
                            '<td>'+ value.notes +'</td>'+
                            '<td>'+ transfer_proof +'</td>'+
                            '<td>'+ date[2] + ' - ' + date[1] + ' - ' + date[0] + '</td>'+
                            '<td>' +
                            '<button class="btn btn-primary mr-2" onclick="openTicket(this)" data-id="'+ value.id +'" data-user-id="' + value.user_id + '">Open Ticket</button>' +
                            '<button class="btn btn-primary" onclick="confirmPayment(this)" data-id="' + value.id + '">Confirm Payment</button>' +
                            '</td>'+
                            '</tr>';
                        pc.append(html);
                    }break;

                    case 2 :
                    {
                        var html = '<tr>' +
                            '<td>'+ value.id +'</td>'+
                            '<td>'+ value.user.firstname + ' ' + value.user.lastname +'</td>'+
                            '<td>'+ value.payment_type.name +'</td>'+
                            '<td>'+ value.notes +'</td>'+
                            '<td>'+ transfer_proof +'</td>'+
                            '<td>'+ date[2] + ' - ' + date[1] + ' - ' + date[0] + '</td>'+
                            '<td>' +
                            '<button class="btn btn-primary" onclick="addTrackingCode(this)" data-id="'+ value.id +'">Add Tracking Code</button>' +
                            '<button class="btn btn-primary" onclick="openTicket(this)" data-id="'+ value.id +'" data-user-id="' + value.user_id + '">Open Ticket</button>' +
                            '</td>'+
                            '</tr>';
                        ws.append(html);
                    }break;

                    case 3 :
                    {
                        var html = '<tr>' +
                            '<td>'+ value.id +'</td>'+
                            '<td>'+ value.user.firstname + ' ' + value.user.lastname +'</td>'+
                            '<td>'+ value.payment_type.name +'</td>'+
                            '<td>'+ value.notes +'</td>'+
                            '<td>'+ transfer_proof +'</td>'+
                            '<td>'+ value.shipping_codes +'</td>'+
                            '<td>'+ date[2] + ' - ' + date[1] + ' - ' + date[0] + '</td>'+
                            '<td><button class="btn btn-primary" onclick="openTicket(this)" data-id="'+ value.id +'" data-user-id="' + value.user_id + '">Open Ticket</button></td>'+
                            '</tr>';
                        sc.append(html);
                    }break;
                }

            });
        },
        error: function (data) {
            toggleError(data.responseJSON.errors);
            console.log(data.responseJSON.errors_debug);
        }
    });
}

function confirmPayment(e)
{
    var id = $(e).data('id');

    $('#modal').modal('toggle');
    $('.modal-title').html('Confirm Payment?');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/confirm_prompt',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id, type: 'confirm_payment'},
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function confirmAction(e)
{
    var id = $(e).data('id');
    var type = $(e).data('type');

    $.ajax({
        url: type,
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id},
        success: function (response) {
            toggleSuccess(response.msg);
            $('#modal').modal('toggle');

            if(type == 'confirm_payment')
                loadTransactionDatas();
        },
        error: function(data) {
            toggleError(data.responseJSON.errors);
            console.log(data.responseJSON.errors_debug);
            $('#modal').modal('toggle');
        }
    });
}

function cancelAction()
{
    $('#modal').modal('toggle');
}

function openTicket(e)
{
    var id = $(e).data('id');
    var user_id = $(e).data('user-id');

    $('#modal').modal('toggle');
    $('.modal-title').html('Open New Support Ticket');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/open_ticket_req',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id, user_id: user_id},
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function addTrackingCode(e)
{
    var id = $(e).data('id');

    $('#modal').modal('toggle');
    $('.modal-title').html('Add Tracking Code');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/add_tracking_code_req',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id},
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function replyTicket(e)
{
    var id = $(e).data('id');
    
    $('#modal').modal('toggle');
    $('.modal-title').html('Reply Ticket');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/reply_ticket_req',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id},
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function markCompleted (e)
{
    var id = $(e).data('id');

    $.ajax({
        url: '/admin/complete_ticket',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id},
        success: function (response) {
            toggleSuccess(response.msg);
            loadTickets();
        },
        error: function(data) {
            toggleError(data.responseJSON.errors);
            console.log(data.responseJSON.errors_debug);
        }
    });
}

function makeDate (e)
{
    var date = e.substring(0,10).split('-');

    date = date[2] + '-' + date[1] + '-' + date[0];

    return date;
}