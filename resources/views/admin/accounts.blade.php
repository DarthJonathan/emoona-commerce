@extends('layouts.admin')

@section('title', 'Account Management')
@section('accounts_active', 'class=active')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Admins
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-default">
                                <tr>
                                    <td>No</td>
                                    <td>Email</td>
                                    <td>Name</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $count => $admin)
                                <tr>
                                    <td>{{ $count+1 }}</td>
                                    <td>{{ $admin['email'] }}</td>
                                    <td>{{ $admin['firstname'] }} {{ $admin['lastname'] }}</td>
                                    <td>
                                        @if($admin['email'] != 'admin@admin.com')
                                            <button
                                                    class="btn btn-warning"
                                                    data-id="{{ $admin['id'] }}"
                                                    onclick="demoteAdmin(this)"
                                                    style="cursor: pointer"
                                            >Demote Admin</button>
                                        @endif
                                        <button
                                                class="btn btn-danger"
                                                data-id="{{ $admin['id'] }}"
                                                onclick="deleteUser(this)"
                                                style="cursor: pointer"
                                                data-toggle="popover"
                                                data-content="Delete User"
                                        >
                                            <img src="{{ asset('icons/trash_icon.png') }}" width="25px" alt="">
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        User Accounts
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-default">
                                <tr>
                                    <td>No</td>
                                    <td>Email</td>
                                    <td>Name</td>
                                    <td>Suspended</td>
                                    <td>Activated</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accounts as $count => $account)
                                    <tr>
                                        <td>{{ $count+1 }}</td>
                                        <td>{{ $account['email'] }}</td>
                                        <td>{{ $account['firstname'] }} {{ $account['lastname'] }}</td>
                                        <td>
                                            @if($account['user_info']['suspended'] == null || $account['user_info']['suspended'] == 0)
                                                <div class="btn btn-primary">Not Suspended</div>
                                            @else
                                                <div class="btn btn-danger">Suspended</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($account['activation_code'] == null)
                                                <div class="btn btn-primary">Activated</div>
                                            @else
                                                <div class="btn btn-danger">Not Activated</div>
                                            @endif
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-primary float-left m-1 user-info"
                                                id="{{ $account['id'] }}"
                                                onclick="userInfo(this)"
                                                style="cursor: pointer"
                                                data-toggle="popover"
                                                data-content="See User Info"
                                            >
                                                <img src="{{ asset('icons/plus_icon.png') }}" width="25px" alt="">
                                            </button>
                                            <form action="{{ URL::to('admin/user_transactions') }}" method="POST">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="id" value="{{ $account['id'] }}">

                                                <button
                                                    class="btn btn-primary float-left m-1"
                                                    style="cursor: pointer"
                                                    data-toggle="popover"
                                                    data-content="See User Transactions"
                                                >
                                                    <img src="{{ asset('icons/search_icon.png') }}" width="25px" alt="">
                                                </button>
                                            </form>
                                            <button
                                                class="btn btn-warning float-left m-1 make-admin"
                                                id="{{ $account['id'] }}"
                                                onclick="makeAdmin(this)"
                                                style="cursor: pointer"
                                                data-toggle="popover"
                                                data-content="Set User as Admin"
                                            >
                                                <img src="{{ asset('icons/star_icon.png') }}" width="25px" alt="">
                                            </button>
                                            <button
                                                class="btn btn-warning float-left m-1 suspend-user"
                                                id="{{ $account['id'] }}"
                                                onclick="suspendUser(this)"
                                                style="cursor: pointer"
                                                data-toggle="popover"
                                                data-content="Suspend or Unsuspend User"
                                            >
                                                <img src="{{ asset('icons/minus_icon.png') }}" width="25px" alt="">
                                            </button>
                                            <button
                                                class="btn btn-danger float-left m-1 delete-user"
                                                id="{{ $account['id'] }}"
                                                onclick="deleteUser(this)"
                                                style="cursor: pointer"
                                                data-toggle="popover"
                                                data-content="Delete User"
                                            >
                                                <img src="{{ asset('icons/trash_icon.png') }}" width="25px" alt="">
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function()
        {
            $('[data-toggle="popover"]').popover({
                placement : 'top',
                trigger : 'hover'
            });
        });
    </script>
@endsection