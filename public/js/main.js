/**
 * Created by JohnNate on 9/7/17.
 */

function userInfo (e)
{
    const id = e.id;

    $('#modal').modal('toggle');

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

    $.ajax({
        url:'/admin/delete_confirmation',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { id:id, type:'user' },
        success: function(data) {
            $('.modal-body').html(data);
        }
    });
}

function cancelDelete()
{
    $('#modal').modal('toggle');
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
        }
    }

    $.ajax({
        url: url,
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { id:id, type: type },
        success: function(data) {
            $('#modal').modal('toggle');
            toggleSuccess(data);
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

            // console.log(transaction_details);

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
    const next = $(e).data('id');

    $.ajax({
        url:'/admin/category',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: { category:next },
        success: function(data) {
            switch(data.category)
            {
                case 1:
                {
                    $('.category-two').append(html);
                }break;


                case 2:
                {
                    $('.category-three').append(html);
                }break;

                case 3:
                {
                    $('.items-list').append(html);
                }break
            }
        }
    });
}

function toggleSuccess (data)
{
    $('.notification-success').removeClass('hidden');
    $('.alert-body').html(data);
    setTimeout(function()
    {
        $('.notification-success').addClass('hidden');
        location.reload();
    }, 1500);
}

function toggleError (data)
{
    $('.notification-success').removeClass('hidden');
    setTimeout(function()
    {
        $('.notification-success').addClass('hidden');
        location.reload();
    }, 1500);
}