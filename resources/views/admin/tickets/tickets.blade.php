@extends ('layouts.admin')

@section('title', 'Sales')
@section('tickets_active', 'class=active')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12" id="ticketTable">
                <table class="table">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Title</td>
                            <td>Submitted</td>
                            <td>Category</td>
                            <td>Completed</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody id="tickets">
                        {{-- Load By Ajax --}}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" id="ticketTitle">
                        {{-- Filled By Ajax --}}
                        Click A Ticket Above
                    </div>
                    <div class="card-body">
                        <div id="ticketDetails">
                            {{-- Filled By Ajax --}}
                        </div>
                        <button class="btn btn-primary reply-btn float-right mt-3" onclick="replyTicket(this)" data-id="">Reply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        var allTickets;

        $(document).ready(function()
        {
            loadTickets();
            $('.reply-btn').hide();
        });

        function loadTickets ()
        {
            var ticket = $('#tickets');

            ticket.empty();

            $.ajax({
                url: '/admin/get_tickets',
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function (data) {

                    allTickets = data.tickets;

                    $.each(data.tickets, function(key, value){

                        if(value.completed == null)
                            var completed = "Not Completed";
                        else
                            var completed = makeDate(value.completed);

                        var html = "<tr>" +
                            "<td>" + (key+1) + "</td>" +
                            "<td>" + value.title + "</td>" +
                            "<td>" + makeDate(value.created_at) + "</td>" +
                            "<td>" + value.category + "</td>" +
                            "<td>" + completed + "</td>" +
                            "<td>" +
                            "<button class='btn-primary btn mr-1' onclick='openTicketDetail(this)' data-id='"+ value.id +"'>View</button>" +
                            "<button class='btn-primary btn' onclick='markCompleted(this)' data-id='"+ value.id +"'>Completed</button>" +
                            "</td>" +
                            "</tr>";

                        ticket.append(html);
                    });
                },
                error: function (data) {
                    toggleError(data.responseJSON.errors);
                    console.log(data.responseJSON.errors_debug);
                }
            });
        }

        function refreshData(e)
        {
            $.ajax({
                url: '/admin/get_tickets',
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function (data) {
                    allTickets = data.tickets;

                    openTicketDetail(e);
                },
                error: function (data) {
                    toggleError(data.responseJSON.errors);
                    console.log(data.responseJSON.errors_debug);
                }
            });
        }

        function openTicketDetail (e)
        {
            if(!$(e).data('id'))
                var id = e;
            else
                var id = $(e).data('id');

            var ticketDetail = $('#ticketDetails');
            var ticketTitle = $('#ticketTitle');

            ticketDetail.empty();
            ticketTitle.empty();

            $.each(allTickets, function(key, value){

                if(value.id == id)
                {
                    ticketTitle.html(value.title);

                    $('.reply-btn').data('id', id);

                    $.each(value.ticket_detail, function(key, value){

                        var html = '<div class="card my-3">'+
                                        '<div class="card-header">' +
                                            makeDate(value.created_at) +
                                        '</div>' +
                                        '<div class="card-body float-right">' +
                                            value.text +
                                        '</div>'+
                                    '</div>';

                        ticketDetail.append(html);

                    });
                }
            });

            $('.reply-btn').show();
        }
    </script>
@endsection