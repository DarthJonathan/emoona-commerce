@extends ('layouts.admin')

@section('title', 'Sales')
@section('transactions_active', 'class=active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 tabs-wrapper row">
            <div class="col-lg-3 tab" data-id="wp" onclick="changeTab(this)">
                <h3>Waiting Payment</h3>
                <div class="tab-border wp-link active"></div>
            </div>
            <div class="col-lg-3 tab" data-id="pc" onclick="changeTab(this)">
                <h3>Payment Confirmation</h3>
                <div class="tab-border pc-link"></div>
            </div>
            <div class="col-lg-3 tab" data-id="ws" onclick="changeTab(this)">
                <h3>Waiting Shipping</h3>
                <div class="tab-border ws-link"></div>
            </div>
            <div class="col-lg-3 tab" data-id="sc" onclick="changeTab(this)">
                <h3>Shipped and Confirmed</h3>
                <div class="tab-border sc-link"></div>
            </div>
        </div>
    </div>
    <div class="row content">

        <!-- Waiting Payment -->
        <div class="col-lg-12 wp">
            <table class="table">
                <thead>
                    <tr>
                        <td>No.</td>
                        <td>User Name</td>
                        <td>Payment Type</td>
                        <td>Notes</td>
                        <td>Transaction Date</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody class="wp-content">

                </tbody>
            </table>
        </div>

        <!-- Payment Confirmation -->
        <div class="col-lg-12 pc">
            <table class="table">
                <thead>
                    <tr>
                        <td>No.</td>
                        <td>User Name</td>
                        <td>Payment Type</td>
                        <td>Notes</td>
                        <td>Payment Proof</td>
                        <td>Transaction Date</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody class="pc-content">

                </tbody>
            </table>
        </div>

        <!-- Waiting Shipping -->
        <div class="col-lg-12 ws">
            <table class="table">
                <table class="table">
                    <thead>
                    <tr>
                        <td>No.</td>
                        <td>User Name</td>
                        <td>Payment Type</td>
                        <td>Notes</td>
                        <td>Payment Proof</td>
                        <td>Transaction Date</td>
                        <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody class="ws-content">

                    </tbody>
                </table>
            </table>
        </div>

        <!-- Shipped and Confirmed -->
        <div class="col-lg-12 sc">
            <table class="table">
                <thead>
                <tr>
                    <td>No.</td>
                    <td>User Name</td>
                    <td>Payment Type</td>
                    <td>Notes</td>
                    <td>Payment Proof</td>
                    <td>Shipping Codes</td>
                    <td>Transaction Date</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody class="sc-content">

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function()
    {
        $('.wp').show("slow");
        $('.pc').hide("slow");
        $('.ws').hide("slow");
        $('.sc').hide("slow");

        loadTransactionDatas();
    });
</script>
@endsection