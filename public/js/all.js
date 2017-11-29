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
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function suspendUser (e)
{
    var id = e.id;

    $.ajax({
        url:'/admin/suspend',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { id:id },
        success: function(data) {
            toggleSuccess(data);
            location.reload();
        }
    });
}

function makeAdmin(e)
{
    var id = e.id;

    $.ajax({
        url:'/admin/make.admin',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { id:id },
        success: function(data) {
            toggleSuccess(data.msg);
            location.reload();
        }
    });
}

function demoteAdmin(e)
{
    var id = $(e).data('id');

    $.ajax({
        url:'/admin/demote.admin',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { id:id },
        success: function(data) {
            toggleSuccess(data.msg);
            location.reload();
        }
    });
}

function deleteUser (e)
{
    var id = e.id;

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
            $('#ajax-loading').hide();
            $('.modal-body').html(data);
            $('#modal').modal('toggle');
        },
        error: function(data)
        {
            toggleError();
            console.log(data.responseText);
            console.log(data.responseJSON.errors);
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
            $('#itemsTable').DataTable().clear();

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

                        if(value.featured == 1)
                            featured = 'checked';
                        else
                            featured = '';

                        //Deprecaeated

                        var html = '<tr>' +
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
                            '<input type="checkbox" name="featured" id="featured" data-case="featured"  data-id="'+ value.id +'" onchange="editItemDetail(this)" ' + featured + ' > Yes' +
                            '</td>' +
                            '<td>' +
                            '<button class="btn btn-dark" onclick="saleStatus(this)" data-id="'+ value.id +'" style="cursor:pointer">Sale Status</button>' +
                            '<button class="btn btn-danger" onclick="deleteItemDetail(this)" data-id="'+ value.id +'" style="cursor:pointer">Delete</button>' +
                            '</td>' +
                            '</tr>';

                        $('.items-list').append(html);



                        // itemTable.row.add( [
                        //     '<td>'+ (key+1) +'</td>',
                        //     '<td data-case="color" data-id="'+ value.id +'" onblur="editItemDetail(this)" contenteditable>'+ value.color +'</td>',
                        //     '<td data-case="size" data-id="'+ value.id +'" onblur="editItemDetail(this)" contenteditable>'+ value.size +'</td>',
                        //     '<td><button class="btn btn-primary btn-block" style="cursor: pointer;" data-link="'+ value.images +'" onclick="viewImagesDetail(this)">View Images</button></td>',
                        //     '<td data-case="stock" data-id="'+ value.id +'" onblur="editItemDetail(this)" contenteditable>'+ value.stock +'</td>',
                        //     '<td><input type="radio" name="status#'+ value.id +'" ' + status.available + ' data-case="status" data-id="'+ value.id +'" onclick="editItemDetail(this)" value="available"> Available <br><input type="radio" name="status#'+ value.id +'" ' + status.preorder + '  data-case="status" data-id="'+ value.id +'" onclick="editItemDetail(this)" value="preorder"> Preorder <br><input type="radio" name="status#'+ value.id +'" ' + status.hidden + '  data-case="status" data-id="'+ value.id +'" onclick="editItemDetail(this)" value="hidden"> Hidden <br></td>',
                        //     '<td><input type="checkbox" name="featured" id="featured" data-case="featured"  data-id="'+ value.id +'" onchange="editItemDetail(this)" ' + featured + ' > Yes </td>',
                        //     '<td><button class="btn btn-dark" onclick="saleStatus(this)" data-id="'+ value.id +'" style="cursor:pointer">Sale Status</button><button class="btn btn-danger" onclick="deleteItemDetail(this)" data-id="'+ value.id +'" style="cursor:pointer">Delete</button></td>'
                        // ] ).draw( false );
                    });
                }break
            }
        }
    });
}

function saleStatus (e)
{
    var id = $(e).data('id');

    $('#modal').modal('toggle');
    $('.modal-title').html('Payment Verification Image');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/items/sales_status',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id:id},
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function saveSale()
{
    var options = {
        url: '/admin/items/save_sales',
        type: 'POST',
        success: function(response)
        {
            toggleSuccess(response.msg);
            $('#modal').modal('toggle');
        },
        error: function(response)
        {
            console.log(response.responseText);
            toggleError(JSON.stringify(response.responseJSON.errors));
            $('#modal').modal('toggle');
        }
    };

    $("#addSale").ajaxSubmit(options);
}

function removeSale ()
{
    var options = {
        url: '/admin/items/remove_sale',
        type: 'POST',
        success: function(response)
        {
            toggleSuccess(response.msg);
            $('#modal').modal('toggle');
        },
        error: function(response)
        {
            console.log(response.responseText);
            toggleError(JSON.stringify(response.responseJSON.errors));
            $('#modal').modal('toggle');
        }
    };

    $("#addSale").ajaxSubmit(options);
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

                var date = value.created_at.substring(0,10).split('-');

                if(value.user === null)
                 return true;

                if(value.transfer_proof == null)
                {
                    var transfer_proof = '<button class="btn btn-danger">Not Paid</button>'
                }else{

                    var proof = value.transfer_proof;

                    proof = '/storage/payment_verification/' + proof.split('/')[2] + '/' + proof.split('/')[3];

                    var transfer_proof = '<button class="btn btn-primary" data-link="'+ value.id +'" onclick="viewPaymentProofAdmin(this)">View Transfer Proof</button>';
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
                        $('#wpTable').DataTable();
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
                        $('#pcTable').DataTable();
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
                        $('#wsTable').DataTable();
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
                        $('#scTable').DataTable();
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


function verifyPayment(e)
{
    var id = $(e).data('id');

    $('#modal').modal('toggle');
    $('.modal-title').html('Payment Verification Image');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/verify_payment/' + id,
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function viewPaymentProof(e)
{
    var id = $(e).data('id');

    $('#modal').modal('toggle');
    $('.modal-title').html('Payment Verification Image');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/view_payment_proof',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id:id},
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function viewPaymentProofAdmin(e)
{
    var id = $(e).data('link');

    $('#modal').modal('toggle');
    $('.modal-title').html('Payment Verification Image');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/view_payment_proof',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id:id},
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function openAdditionals (e)
{
    var id = $(e).data('link');
    var img = id.split('/');

    $('#modal').modal('toggle');
    $('.modal-title').html('View Additionals');
    $('.modal-body').empty();
    $('#ajax-loading').hide();
    $('.modal-body').html('<a href="http://localhost:8000/storage/support_ticket/' + img[2] + '/' + img[3] + '"><img src="/storage/support_ticket/' + img[2] + '/' + img[3] + '" width="300px"></a>');

}

function loadFeatured ()
{
    var featured = $('.featured-product');
    featured.empty();

    $.ajax({
        url: '/admin/webconfig/get_featured',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        success: function (data) {
            
            $.each(data.featured, function(key, value){

                var images = data.images[key][0];
                images = images.split('/')[2] + '/' + images.split('/')[3];

                var html = '<div class="single-featured col-md-4">' +
                    '<img src="/storage/item_detail/' + images + '" data-id="' + value.id + '" onclick="checkBox(this)" id="featuredimg' + value.id +'">' +
                    '<input type="checkbox" name="featured#'+ value.id +'" id="featured'+ value.id +'" class="featured-items">' +
                    '</div>';

                featured.append(html);
            });

        },
        error: function(response) {
            console.log(response.responseJSON);
            toggleError(response.responseJSON.errors);
        }
    });
}

function removeFeatured()
{
    var items = $('.featured-items');
    var items_id = [];

    $.each(items, function(key, value){
        if($(value).is(':checked')) {
            var id = $(value).attr('id').split('featured')[1];
            items_id.push(id);
        }
    });

    console.log(items_id);

    $.ajax({
        url: '/admin/webconfig/remove.featured',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data:{items: items_id},
        success: function (data) {

            $.each(items_id, function(key, value)
            {
                $('#featured' + value).remove();
                $('#featuredimg' + value).remove();
            });

            toggleSuccess(data.msg);
        },
        error: function(response) {
            console.log(response);
            toggleError(response.responseJSON.errors);
        }
    });
}

function saveThis(e)
{
    var what = $(e).data('what');
    var data = "";

    switch(what)
    {
        case 'about':
        {
            data = tinyMCE.get('about').getContent()
        }break;

        case 'tnc':
        {
            data = tinyMCE.get('tnc').getContent()
        }break;

        case 'return':
        {
            data = tinyMCE.get('return').getContent()
        }break;

        case 'shipping':
        {
            data = tinyMCE.get('shipping').getContent()
        }break;

        case 'contact' :
        {
            data = tinyMCE.get('contact').getContent()
        }break;
    }

    $.ajax({
        url: '/admin/webconfig/edit.texts',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data:{data: data, what: what},
        success: function (data) {
            toggleSuccess(data.msg);
            // console.log(data);
        },
        error: function(response) {
            console.log(response);
            // console.log(response.responseText);
            toggleError(response.responseJSON.errors);
        }
    });
}

function uploadNew ()
{
    $('#modal').modal('toggle');
    $('.modal-title').html('New Slider Image');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/webconfig/add_slider_ajax',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        success: function (data) {
            $('#ajax-loading').hide();
            $('.modal-body').html(data);
        },
        error: function(response) {
            $('#modal').modal('toggle');
            toggleError(response.responseJSON.errors);
            console.log(response.responseText);
            console.log(response.responseJSON);
        }
    });
}

function removeImage()
{
    var items = $('.slide-items');
    var items_id = [];
    var item_remove = [];

    $.each(items, function(key, value){
        if($(value).is(':checked')) {
            var id      = $(value).val();
            var remove  = $(value).attr('id').split('slide')[1];
            items_id.push(id);
            item_remove.push(remove);
        }
    });

    if(items_id.length == 0)
    {
        toggleError("Please select an item");
        return false;
    }

    $.ajax({
        url: '/admin/webconfig/remove.slider',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data:{items: items_id},
        success: function (data) {

            $.each(item_remove, function(key, value)
            {
                $('.slide-' + value).remove();
            });

            toggleSuccess(data.msg);
        },
        error: function(response) {
            console.log(response);
            console.log(response.responseText);
            toggleError(response.responseJSON.errors);
        }
    });
}

function changeImage()
{
    var options = {
        url: '/admin/webconfig/change_collections',
        type: 'POST',
        success: function(response)
        {
            toggleSuccess(response.msg);
            setTimeout(
                function()
                {
                    location.reload();
                }, 2500);
        },
        error: function(response)
        {
            toggleError(JSON.stringify(response.responseJSON.errors));
            console.log(response.responseJSON.errors_debug);
        }
    };

    $("#changeCollection").ajaxSubmit(options);
}

function viewMailContent(e)
{
    var id = $(e).data('id');

    $('#modal').modal('toggle');
    $('.modal-title').html('Newsletter Content');
    $('.modal-body').empty();
    $('#ajax-loading').show();

    $.ajax({
        url: '/admin/newsletter/view.content',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id},
        success: function (data) {
            $('#ajax-loading').hide();
            $('.modal-body').html(data);
        },
        error: function(response) {
            $('#modal').modal('toggle');
            console.log(response.responseText);
            toggleError(response.responseJSON.errors);
        }
    });
}

function saveTransferText ()
{
    var value = tinyMCE.get('value_transfer').getContent();

    $.ajax({
        url: '/admin/webconfig/update_transfer_text',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        data: {value: value},
        type: 'POST',
        success: function (data) {
            toggleSuccess(data.msg);
        },
        error: function (response) {
            toggleError(response.responseJSON.errors);
        }
    });
}

/*
    Cesa's Work
 */
function editCategory (e)
{
    const id = $(e).data('id');
    $('.modal-title').empty();
    $('#modal').modal('toggle');

    $.ajax({
        url: '/admin/edit_category_req',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {id: id, type: 'category'},
        success: function(data){
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}

function newCategory () {
    $('#modal').modal('toggle');
    $('.modal-title').html('New Category');

    $.ajax({
        url: '/admin/new_category_req',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}


function editStudioCategory (e)
{
    $('#modal').modal('toggle');
    $('.modal-title').html('New Category');

    var id = $(e).data('id');

    $.ajax({
        url: '/admin/studio/editCategory/' + id,
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        success: function (data) {
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        },
        error: function(res){
            console.log(res.responseText);
        }
    });
}

function editStudioItem (e)
{
    var id = $(e).data('id');

    $('.modal-title').empty();
    $('#modal').modal('toggle');

    $.ajax({
        url: '/admin/studio/edit_item',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'GET',
        data: {id: id},
        success: function(data){
            $('.modal-body').html(data);
            $('#ajax-loading').hide();
        }
    });
}
//# sourceMappingURL=all.js.map
